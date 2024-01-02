<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\License;
use App\Models\Log;

//for EXPORT module
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LicenseController extends Controller
{
    public function index(){
        $licenses = License::withTrashed()->get(); // Include soft-deleted licenses

        return view('licenses.index', compact('licenses'));
    }

    public function create(){
        return view('licenses.create');
    }

   public function store(){
        $license = new License();

        $license->license_name = request('license_name');
        $license->license_desc = request('license_desc');

        $license->save();

        return redirect('/licenses');
    }

    public function destroy($license_id)
    {
        $license = License::findOrFail($license_id);

        if ($license->trashed()) {
            // Permanently delete the soft-deleted license
            $license->forceDelete();
            return redirect()->route('licenses.index')->with('success', 'License permanently deleted!');
        } else {
            // Soft-delete the license
            $license->delete();
            return redirect()->route('licenses.index')->with('success', 'License soft-deleted!');
        }
    }

    public function restore($license_id)
    {
        $license = License::withTrashed()->findOrFail($license_id);

        // Restore the soft-deleted license
        $license->restore();

        return redirect()->route('licenses.index')->with('success', 'License restored!');
    }

    public function edit($license_id){
        $license = License::findOrFail($license_id);
        return view('licenses.edit', ['license' => $license]);
    }
    
    public function update(Request $request, $license_id){
        $license = License::findOrFail($license_id);
        $license->license_name = $request->input('license_name');
        $license->license_desc = $request->input('license_desc');
        $license->save();
        return redirect('/licenses');
    }

    public function exportListLicense($format)
    {
        switch ($format) {
            case 'xls':
                return Excel::download(new LicenseListExport, 'licenses_list.xls');
                break;
            case 'pdf':
                $licenses = License::withTrashed()->get();
                $pdf = PDF::loadView('exports.licenses_list', ['licenses' => $licenses]);
                return $pdf->download('licenses.pdf');
                break;
            default:
                return redirect('/licenses')->with('error', 'Invalid export format');
        }
    }

    public function exportLogLicense($format)
    {
        switch ($format) {
            case 'xls':
                return Excel::download(new LicenseLogChangesExport, 'licenses_log.xls');
                break;
            case 'pdf':
                $logs = Log::leftJoin('users', 'logs.user_id', '=', 'users.user_id')
                ->where('logs.table_name', 'licenses')
                ->select('logs.log_id', 'users.name as user_name', 'logs.type_action', 'logs.record_name', 'logs.column_name', 'logs.old_value', 'logs.new_value', 'logs.created_at')
                ->get();
                $pdf = PDF::loadView('exports.licenses_log', ['logs' => $logs]);
                return $pdf->download('licenses_log.pdf');
                break;
            default:
                return redirect('/licenses')->with('error', 'Invalid export format');
        }
    }
}

class LicenseListExport implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        return [
            'LICENSE ID',
            'LICENSE NAME',
            'LICENSE DESCRIPTION',
            'TIME CREATED',
            'TIME UPDATED',
            'TIME DELETED',
        ];
    }

    public function collection()
    {
        return License::select('license_id', 'license_name', 'license_desc', 'created_at', 'updated_at', 'deleted_at')
            ->withTrashed() // Include soft-deleted licenses
                ->get();
    }

    public function styles(Worksheet $sheet)
    {
        // Bold the headers
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Adjust column widths
        $columnWidths = [
            'A' => 15,
            'B' => 30,
            'C' => 30,
            'D' => 27,
            'E' => 27,
            'F' => 27,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['C'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }
}

class LicenseLogChangesExport implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        return [
            '#',
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
            ->where('logs.table_name', 'licenses') // Add the condition for table_name
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
            'A' => 14,
            'B' => 8,
            'C' => 20,
            'D' => 8,
            'E' => 12,
            'F' => 9,
            'G' => 30,
            'H' => 13,
            'I' => 30,
            'J' => 30,
            'K' => 27,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['D', 'F', 'H', 'I', 'J'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

}