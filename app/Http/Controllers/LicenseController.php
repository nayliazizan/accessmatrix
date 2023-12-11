<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\License;

class LicenseController extends Controller
{
    public function index(){

        $licenses = License::all();
        return view('licenses.index', ['licenses' => $licenses,]);
    }

    public function show($license_id){

        $license = License::findOrFail($license_id);
        return view('licenses.show', ['license'=>$license]);
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

    public function destroy($license_id){
        $license = License::findOrFail($license_id);
        $license->delete();

        return redirect('/licenses');
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
        return redirect('/licenses/'.$license->license_id);
    }
    

}
