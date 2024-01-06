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


class StaffController extends Controller
{
    // Display a listing of the staffs
    public function index()
    {
        $staffs = Staff::with('group')->get();
        $groups = Group::all();
        return view('staffs.index', compact('staffs', 'groups'));
    }

    // Show the form for creating a new staff
    public function create()
    {
        $groups = Group::all();
        return view('staffs.create', compact('groups'));
    }

    // Store a newly created staff in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required|exists:groups,group_id',
            'staff_id_rw' => 'required|string|max:255|unique:staffs,staff_id_rw',
            'staff_name' => 'required|string|max:255',
            'dept_id' => 'required|string|max:255',
            'dept_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        Staff::create($data);

        return redirect()->route('staffs.index')->with('success', 'Staff created successfully!');
    }

    // Show the form for editing the specified staff
    public function edit(Staff $staff)
    {
        $groups = Group::all();
        return view('staffs.edit', compact('staff', 'groups'));
    }

    // Update the specified staff in the database
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

    // Delete the specified staff from the database
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
                'groups.group_name', // Use 'groups.group_name' instead of 'group.group_name'
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
                // Freeze the first row
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
        return Log::select('logs.log_id', 'logs.user_id', 'users.name as user_name', 'logs.type_action', 'logs.table_name', 'logs.record_id', 'logs.record_name', 'logs.column_name', 'logs.old_value', 'logs.new_value', 'logs.created_at')
            ->leftJoin('users', 'logs.user_id', '=', 'users.user_id')
            ->where('logs.table_name', 'staffs') // Add the condition for table_name
            ->get();
    }
    
    public function styles(Worksheet $sheet)
    {
        // Bold the headers
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Adjust column widths
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
                // Freeze the first row
                $event->sheet->freezePane('A2');
            },
        ];
    }

}