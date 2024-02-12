<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Group;
use App\Models\Log;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PDF;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Importable;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $sortOrder = $request->input('sort_order', 'latest');
    
        $staffs = Staff::with('group');
    
        if ($sortOrder == 'latest') {
            $staffs->orderBy('updated_at', 'desc');
        } elseif ($sortOrder == 'alphabet') {
            $staffs->orderBy('staff_name', 'asc');
        }
    
        $staffs = $staffs->get();
        $groups = Group::all();
    
        return view('staffs.index', compact('staffs', 'groups', 'sortOrder'));
    }
    

    public function searchStaff(Request $request) {
        $searchText = $request->search;
    
        $staffs = Staff::where(function ($query) use ($searchText) {
            $query->where('staff_id_rw', 'LIKE', "%$searchText%")
                  ->orWhere('staff_name', 'LIKE', "%$searchText%")
                  ->orWhere('dept_id', 'LIKE', "%$searchText%")
                  ->orWhere('dept_name', 'LIKE', "%$searchText%")
                  ->orWhere('status', 'LIKE', "%$searchText%");
        })
        ->orWhereHas('group', function ($query) use ($searchText) {
            $query->where('group_name', 'LIKE', "%$searchText%");
        })
        ->get();
    
        $groups = Group::all(); 
    
        return view('staffs.index', compact('staffs', 'groups'));
    }
    

    public function noGroupStaff()
    {
        $ngStaff = Staff::whereNull('group_id')->get();

        return view('staffs.no_group_staff', compact('ngStaff'));
    }


    public function create()
    {
        $groups = Group::orderBy('group_name', 'asc')->get();
        return view('staffs.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'nullable|exists:groups,group_id',
            'staff_id_rw' => [
                'required',
                'string',
                'max:255',
                Rule::unique('staffs', 'staff_id_rw')->ignore($request->staff_id_rw, 'staff_id_rw'),
            ],
            'staff_name' => 'required|string|max:255',
            'dept_id' => 'required|string|max:255',
            'dept_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
    
        // check if department name has more than 5 characters
        if (strlen($request->dept_name) < 5) {
            return redirect()->back()->withInput()->with('error', 'Kindly enter the department name in the longer version.');
        }
    
        // check if staff ID already exists
        if (Staff::where('staff_id_rw', $request->staff_id_rw)->exists()) {
            return redirect()->back()->withInput()->with('error', 'The ID already exists in the system. Please add a new ID.');
        }
    
        $data = $request->all();
        $data['group_id'] = $data['group_id'] ?? null;
    
        Staff::create($data);
    
        return redirect()->route('staffs.index')->with('success', 'Staff created successfully!');
    }

    public function edit(Staff $staff)
    {
        $groups = Group::orderBy('group_name', 'asc')->get();
        return view('staffs.edit', compact('staff', 'groups'));
    }

    public function update(Request $request, $staff_id)
    {
        $staff = Staff::where('staff_id', $staff_id)->firstOrFail();

        $data = $request->validate([
            'group_id' => 'required',
            'staff_id_rw' => [
                'required',
                Rule::unique('staffs')->ignore($staff->staff_id, 'staff_id'),
            ],
            'staff_name' => 'required',
            'dept_id' => 'required',
            'dept_name' => 'required|min:5',
            'status' => 'required',
        ]);

        // Check if department name has more than 5 characters
        if (strlen($data['dept_name']) < 5) {
            return redirect()->route('staffs.edit', $staff->staff_id)->withInput()->with('error', 'Kindly enter the department name in the longer version.');
        }
        
        $staff->update($data);

        return redirect()->route('staffs.index')->with('success', 'Staff updated successfully!');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully!');
    }

    public function exportListStaff(Request $request)
    {
        $format = $request->input('format');
        $group = $request->input('group');
    
        $staffsQuery = Staff::query();
    
        $groupName = ($group !== 'all') ? Group::find($group)->group_name : 'All Groups';
    
        if ($group !== 'all') {
            $staffsQuery->where('group_id', $group);
        }
    
        $staffs = $staffsQuery->get();
    
        if ($format === 'xls') {
            return Excel::download(new StaffListExport($staffs), 'staffs_' . str_replace(' ', '_', $groupName) . '_list.xls');
        } elseif ($format === 'pdf') {
            $pdf = app('dompdf.wrapper');
            $pdf->setPaper('A4', 'landscape');
            $pdf->loadView('exports.staffs_list', ['staffs' => $staffs, 'groupName' => $groupName]);
            return $pdf->download('staffs_' . str_replace(' ', '_', $groupName) . '_list.pdf');
        } else {
            return redirect()->route('staffs.index')->with('error', 'Invalid export format.');
        }
    }

    public function exportLogStaff($format)
    {
        switch ($format) {
            case 'xls':
                return Excel::download(new StaffLogExport, 'staffs_log.xls');
                break;
            case 'pdf':
                $pdf = app('dompdf.wrapper');
                $logs = Log::leftJoin('users', 'logs.user_id', '=', 'users.user_id')
                ->where('logs.table_name', 'staffs')
                ->select(
                'logs.log_id',
                'logs.user_id', 
                'users.name as user_name', 
                'logs.type_action',
                'logs.table_name',
                'logs.record_id', 
                'logs.record_name', 
                'logs.column_name', 
                'logs.old_value', 
                'logs.new_value', 
                'logs.created_at')
                ->get();
                $pdf->setPaper('A4', 'landscape');
                $pdf->loadView('exports.staffs_log', ['logs' => $logs]);
                return $pdf->download('staffs_log.pdf');
                break;
            default:
                return redirect('/groups')->with('error', 'Invalid export format');
        }
    }

    public function importStaff(Request $request)
    {
        set_time_limit(300);
        try {
            $validator = $request->validate([
                'staff_file' => 'required|file|mimes:xlsx|max:2048',
            ]);
    
            $filePath = $request->file('staff_file')->getRealPath();
    
            Excel::import(new StaffImport(), $filePath); // Use the separate class
    
            return redirect()->route('staff.index')->with('success', 'Staff imported successfully');
        } catch (\Exception $e) {
            return redirect()->route('staff.index')->with('error', $e->getMessage());
        }
    }
    

    public function showUploadForm()
    {
        return view('tracker/form');
    }

    public function compareColumn(Request $request)
    {
        set_time_limit(10000);
        try {
            $request->validate([
                'to_track' => 'required|in:status,department,all',
                'excel_file' => 'required|mimes:xlsx,xls',
            ]);

            $toTrack = $request->input('to_track');
            $file = $request->file('excel_file');

            // Check file extension
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, ['xlsx', 'xls'])) {
                throw new \Exception('Wrong file type. Please upload a valid xlsx or xls file.');
            }

            $filePath = $file->storeAs('uploads', 'uploaded_file.xlsx');

            $databaseData = Staff::all();
            $excelData = $this->readExcel($filePath);

            if ($toTrack == 'status') {
                $differences = $this->compareStatus($databaseData, $excelData);
                session(['toTrack' => $toTrack, 'differences' => $differences]);
                return view('tracker.results', compact('toTrack', 'differences'));
            } elseif ($toTrack == 'department') {
                $differences = $this->compareDept($databaseData, $excelData);
                session(['toTrack' => $toTrack, 'differences' => $differences]);
                return view('tracker.results', compact('toTrack', 'differences'));
            } elseif ($toTrack == 'all') {
                $staffsFromSystem = Staff::all(['staff_id_rw', 'staff_name', 'dept_id', 'dept_name', 'status']);
                $staffsFromUpload = collect($excelData)->skip(1)->map(function ($row) {
                    return [
                        'staff_id_rw' => $row[0],
                        'staff_name' => $row[1],
                        'dept_id' => $row[2],
                        'dept_name' => $row[3],
                        'status' => $row[4],
                    ];
                });
    
                // sort the $staffsFromUpload array based on the 'staff_id_rw' value
                $staffsFromUpload = $staffsFromUpload->sortBy('staff_id_rw');
    
                // identify new staff members not present in the system's database
                $newStaffs = $staffsFromUpload->reject(function ($uploadStaff) use ($staffsFromSystem) {
                    return $staffsFromSystem->contains('staff_id_rw', $uploadStaff['staff_id_rw']);
                });
        
                // exclude new staff members from the original right-side table
                $staffsFromUpload = $staffsFromUpload->reject(function ($uploadStaff) use ($newStaffs) {
                    return $newStaffs->contains('staff_id_rw', $uploadStaff['staff_id_rw']);
                });
        
                // append new staff members at the end of the right-side table
                $staffsFromUpload = $staffsFromUpload->concat($newStaffs);
    
                // set a default height of 3 for all rows
                $maxRowHeightsLeft = array_fill(0, count($staffsFromSystem), 3);
                $maxRowHeightsRight = array_fill(0, count($staffsFromUpload), 3);

                return view('tracker.all', compact('staffsFromSystem', 'staffsFromUpload', 'maxRowHeightsLeft', 'maxRowHeightsRight'));
            }

            return redirect()->route('tracker.form')->with('error', 'Invalid tracking option');
        } catch (\Exception $e) {
            return redirect()->route('tracker.form')->with('error', $e->getMessage());
        }
    }

    private function readExcel($filePath)
    {
        $spreadsheet = IOFactory::load(storage_path("app/{$filePath}"));
        $worksheet = $spreadsheet->getActiveSheet();
    
        $data = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }
    
        return $data;
    }
    

    private function compareStatus($databaseData, $excelData)
    {
        $differences = [];
    
        foreach ($excelData as $excelRow) {
            $staffId = $excelRow[0];
            $excelStatus = trim($excelRow[4]);
    
            $databaseStaff = $databaseData->firstWhere('staff_id_rw', $staffId);
    
            if ($databaseStaff && $databaseStaff->status != $excelStatus) {
                $differences[] = [
                    'staff_id_rw' => $staffId,
                    'staff_name' => $excelRow[1],
                    'dept_id' => $excelRow[2],
                    'dept_name' => $excelRow[3],
                    'old_status' => $databaseStaff->status,
                    'new_status' => $excelStatus,
                ];
            }
        }
    
        return $differences;
    }
    
    
    private function compareDept($databaseData, $excelData)
    {
        $differences = [];
    
        foreach ($excelData as $excelRow) {
            $staffId = $excelRow[0];
            $excelDept = trim($excelRow[3]);
    
            $databaseStaff = $databaseData->firstWhere('staff_id_rw', $staffId);
    
            if ($databaseStaff && $databaseStaff->dept_name != $excelDept) {
                $differences[] = [
                    'staff_id_rw' => $staffId,
                    'staff_name' => $excelRow[1],
                    'dept_id' => $excelRow[2],
                    'old_dept' => $databaseStaff->dept_name,
                    'new_dept' => $excelDept,
                    'status' => $excelRow[4],
                ];
            }
        }
    
        return $differences;
    }
    

    public function exportStatus($format)
    {
        // validate the export format
        if (!in_array($format, ['xls', 'pdf'])) {
            return redirect('/tracker/results')->with('error', 'Invalid export format');
        }

        // get differences from the session data
        $differences = session('differences');

        // validate differences
        if (empty($differences)) {
            return redirect('/tracker/results')->with('error', 'No data to export');
        }

        switch ($format) {
            case 'xls':
                return Excel::download(new StatusExport($differences), 'staff_status_changed.xls');
                break;
            case 'pdf':
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('exports.staff_status', ['differences' => $differences]);
                return $pdf->download('staff_status_changed.pdf');
                break;
            default:
                return redirect('/tracker/results')->with('error', 'Invalid export format');
        }
    }

    public function exportDept($format)
    {
        // validate the export format
        if (!in_array($format, ['xls', 'pdf'])) {
            return redirect('/tracker/results')->with('error', 'Invalid export format');
        }

        // get differences from the session data
        $differences = session('differences');

        // validate differences
        if (empty($differences)) {
            return redirect('/tracker/results')->with('error', 'No data to export');
        }

        switch ($format) {
            case 'xls':
                return Excel::download(new DeptExport($differences), 'staff_dept_changed.xls');
                break;
            case 'pdf':
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('exports.staff_dept', ['differences' => $differences]);
                return $pdf->download('staff_dept_changed.pdf');
                break;
            default:
                return redirect('/tracker/results')->with('error', 'Invalid export format');
        }
    }
    
}

class StaffListExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithMapping
{
    use Exportable;
    protected $staffs;

    public function __construct($staffs)
    {
        $this->staffs = $staffs;
    }

    public function collection()
    {
        return Staff::leftJoin('groups', 'staffs.group_id', '=', 'groups.group_id')
            ->when($this->staffs, function ($query) {
                $query->whereIn('staff_id', $this->staffs->pluck('staff_id'));
            })
            ->get([
                'staffs.staff_id',
                'staffs.group_id',
                'groups.group_name', 
                'staffs.staff_id_rw',
                'staffs.staff_name',
                'staffs.dept_id',
                'staffs.dept_name',
                'staffs.status',
                'staffs.created_at',
                'staffs.updated_at',
            ]);
    }

    public function headings(): array
    {
        return [
            'STAFF ID',
            'GROUP ID',
            'GROUP NAME',
            'STAFF ID (RW)',
            'STAFF NAME',
            'DEPARTMENT ID',
            'DEPARTMENT NAME',
            'STATUS',
            'TIME CREATED',
            'TIME UPDATED',
        ];
    }

    public function map($staff): array
    {
        return [
            $staff->staff_id,
            $staff->group_id,
            optional($staff->group)->group_name,
            $staff->staff_id_rw,
            $staff->staff_name,
            $staff->dept_id,
            $staff->dept_name,
            $staff->status,
            $staff->created_at->format('Y-m-d H:i:s'),
            $staff->updated_at->format('Y-m-d H:i:s'), 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // bold the headers
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // adjust column widths
        $columnWidths = [
            'A' => 9,
            'B' => 10,
            'C' => 19,
            'D' => 13,
            'E' => 12,
            'F' => 16,
            'G' => 23,
            'H' => 9,
            'I' => 27,
            'J' => 27,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->freezePane('A2');
            },
        ];
    }

}

class StaffLogExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            'LOG ID',
            'USER ID',
            'USER NAME',
            'TYPE OF ACTION',
            'TABLE NAME',
            'RECORD ID',
            'RECORD NAME',
            'COLUMN NAME',
            'OLD VALUE',
            'NEW VALUE',
            'TIME',
        ];
    }

    public function collection()
    {
        return Log::select('logs.log_id', 
        'logs.user_id', 
        'users.name as user_name', 
        'logs.type_action', 
        'logs.table_name', 
        'logs.record_id', 
        'logs.record_name', 
        'logs.column_name', 
        'logs.old_value', 
        'logs.new_value', 
        'logs.created_at')
            ->leftJoin('users', 'logs.user_id', '=', 'users.user_id')
            ->where('logs.table_name', 'staffs') 
            ->get();
    }

    public function map($log): array
    {
        $log->old_value = $this->formatJsonValue($log->old_value);
        $log->new_value = $this->formatJsonValue($log->new_value);

        return [
            $log->log_id,
            $log->user_id,
            $log->user_name,
            $log->type_action,
            $log->table_name,
            $log->record_id,
            $log->record_name,
            $log->column_name,
            $log->old_value,
            $log->new_value,
            $log->created_at->format('Y-m-d H:i:s'), 
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        $columnWidths = [
            'A' => 9,
            'B' => 6,
            'C' => 11,
            'D' => 9,
            'E' => 8,
            'F' => 9,
            'G' => 16,
            'H' => 12,
            'I' => 15,
            'J' => 15,
            'K' => 20,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->freezePane('A2');
            },
        ];
    }

    private function formatJsonValue($jsonValue)
    {
        // decode the JSON value
        $decodedValue = json_decode($jsonValue, true);

        // check if decoding was successful
        if (json_last_error() === JSON_ERROR_NONE) {
            // format the array to a readable string with bulletpoints
            $formattedValue = implode(', ', array_map(function ($key, $value) {
                return "• $key: $value";
            }, array_keys($decodedValue), $decodedValue));

            return "$formattedValue";
        }

        // return the original value if decoding fails
        return $jsonValue;
    }

}

class StaffImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $staffIdRw = $row['staff_id_rw'];
        $status = strtolower($row['status']);

        // Check if staff with the same staff_id_rw already exists in the database
        $existingStaff = Staff::where('staff_id_rw', $staffIdRw)->first();

        // Check if status is "active" and staff doesn't exist in the database
        if (!$existingStaff && $status == 'active') {
            return new Staff([
                'staff_id_rw' => $staffIdRw,
                'staff_name' => $row['staff_name'],
                'dept_id' => $row['dept_id'],
                'dept_name' => $row['dept_name'],
                'status' => $row['status'],
                'group_id' => $row['group_id'] ?? null, // Assign null if group_id is not provided
            ]);
        }

        return null; // Skip this row
    }

    public function headingRow(): int
    {
        return 1; // Assuming headers are in the first row
    }
}



class StatusExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $data;
    use Exportable;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'STAFF ID',
            'STAFF NAME',
            'DEPARTMENT ID',
            'DEPARTMENT NAME',
            'OLD STATUS',
            'NEW STATUS',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // bold the headers
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // apply styles to specific columns
        $sheet->getStyle('E:F')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'F1F17E',
                ],
            ],
        ]);

        $sheet->freezePane('A1');

        // adjust column widths
        $columnWidths = [
            'A' => 8,
            'B' => 13,
            'C' => 16,
            'D' => 28,
            'E' => 12,
            'F' => 13,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Freeze the first row
                $event->sheet->freezePane('A2');
            },
        ];
    }
}

class DeptExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $data;
    use Exportable;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'STAFF ID',
            'STAFF NAME',
            'DEPARTMENT ID',
            'OLD DEPARTMENT',
            'NEW DEPARTMENT',
            'STATUS',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // bold the headers
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // apply styles to specific columns
        $sheet->getStyle('D:E')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'F1F17E',
                ],
            ],
        ]);

        $sheet->freezePane('A1');

        // adjust column widths
        $columnWidths = [
            'A' => 8,
            'B' => 13,
            'C' => 16,
            'D' => 28,
            'E' => 28,
            'F' => 13,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // freeze the first row
                $event->sheet->freezePane('A2');
            },
        ];
    }
}