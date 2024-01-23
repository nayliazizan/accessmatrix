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

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::with('group')->get();
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
        $groups = Group::all();
        return view('staffs.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'nullable|exists:groups,group_id',
            'staff_id_rw' => 'required|string|max:255|unique:staffs,staff_id_rw',
            'staff_name' => 'required|string|max:255',
            'dept_id' => 'required|string|max:255',
            'dept_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $data['group_id'] = $data['group_id'] ?? null;

        Staff::create($data);

        return redirect()->route('staffs.index')->with('success', 'Staff created successfully!');
    }

    public function edit(Staff $staff)
    {
        $groups = Group::all();
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
            'dept_name' => 'required',
            'status' => 'required',
        ]);

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
                ->where('logs.table_name', 'licenses')
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
        try {
            $validator = $request->validate([
                'staff_file' => 'required|file|mimes:xlsx|max:2048',
            ]);

            $filePath = $request->file('staff_file')->getRealPath();

            if ($request->file('staff_file')->getClientOriginalExtension() !== 'xlsx') {
                throw new \Exception('Wrong file type. Please upload a valid xlsx file.');
            }


            Excel::import(new class extends StaffImport {}, $filePath);

            return redirect()->route('staff.index')->with('success', 'Staff imported successfully');
        } catch (ValidationException $e) {
            return redirect()->route('staff.index')->withErrors($e->validator)->withInput();
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
        $request->validate([
            'to_track' => 'required|in:status,department',
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        $toTrack = $request->input('to_track');
        $file = $request->file('excel_file');
        $filePath = $file->storeAs('uploads', 'uploaded_file.xlsx');

        $databaseData = Staff::all();
        $excelData = $this->readExcel($filePath);

        if ($toTrack == 'status') {
            $differences = $this->compareStatusAndReturnDifferences($databaseData, $excelData);
        } elseif ($toTrack == 'department') {
            $differences = $this->compareDeptAndReturnDifferences($databaseData, $excelData);
        } 
        return view('tracker/results', compact('differences', 'toTrack'));
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
    

    private function compareStatusAndReturnDifferences($databaseData, $excelData)
    {
        $differences = [];

        foreach ($excelData as $excelRow) {
            $staffId = $excelRow[0];
            $excelStatus = strtolower($excelRow[4]); 
            $excelStatus = trim($excelStatus); 
    
            $databaseStaff = $databaseData->firstWhere('staff_id_rw', $staffId);
    
            if ($databaseStaff && strtolower($databaseStaff->status) != $excelStatus) {
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
    
    private function compareDeptAndReturnDifferences($databaseData, $excelData)
    {
        $differences = [];

        foreach ($excelData as $excelRow) {
            $staffId = $excelRow[0];
            $excelDept = strtolower($excelRow[3]);  
            $excelDept = trim($excelDept);
    
            $databaseStaff = $databaseData->firstWhere('staff_id_rw', $staffId);
    
            if ($databaseStaff && strtolower($databaseStaff->dept_name) != $excelDept) {
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
}

class StaffListExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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

    public function styles(Worksheet $sheet)
    {
        // Bold the headers
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Adjust column widths
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

class StaffLogExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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

}

class StaffImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        return new Staff([
            'staff_id_rw' => $row['staff_id_rw'],
            'staff_name' => $row['staff_name'],
            'dept_id' => $row['dept_id'],
            'dept_name' => $row['dept_name'],
            'status' => $row['status'],
            'group_id' => null, 
        ]);
    }
}
