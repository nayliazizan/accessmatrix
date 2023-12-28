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
            case 'csv':
                return Excel::download(new LicenseExport, 'licenses.csv');
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
            case 'csv':
                return Excel::download(new LicenseLogChangesExport, 'licenses_log.csv');
                break;
            case 'pdf':
                $logs = Log::get();
                $pdf = PDF::loadView('exports.licenses_log', ['logs' => $logs]);
                return $pdf->download('licenses_log.pdf');
                break;
            default:
                return redirect('/licenses')->with('error', 'Invalid export format');
        }
    }
}

class LicenseExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'License ID',
            'License Name',
            'License Description',
            'Time Created',
            'Time Updated',
            'Time Deleted',
        ];
    }

    public function collection()
    {
        return License::select('license_id', 'license_name', 'license_desc', 'created_at', 'updated_at', 'deleted_at')
            ->withTrashed() // Include soft-deleted projects
                ->get();
    }
}

class LicenseLogChangesExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            '#',
            'Type of Action',
            'User ID',
            'Table Name',
            'Column Name',
            'Record ID',
            'Old Value',
            'New Value',
            'Time',
        ];
    }

    public function collection()
    {
        return Log::select('log_id', 'type_action', 'user_id', 'table_name', 'column_name', 'record_id', 'old_value', 'new_value', 'created_at')
            ->get();
    }
}

