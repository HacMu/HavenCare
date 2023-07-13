<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clinicsIndex()
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $clinics = Clinic::orderBy('klinik_adi','ASC')->paginate(10);
            $departments = Department::get();
            return view('Admin.clinics',compact('clinics','departments'));
        }
    }

    public function addNewClinic(Request $request)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $input = $request->all();
            Validator::make($input, [
                'klinik_adi' => ['required', 'string', 'max:255'],
                'klinik_numarasi' => ['required', 'integer'],
                'bolum_id' =>['required', 'integer']
            ])->validate();
            $clinic = Clinic::create([
                'klinik_adi' => $input['klinik_adi'],
                'klinik_numarasi' => $input['klinik_numarasi'],
                'bolum_id' => $input['bolum_id'],
            ]);
            $clinic->save();
            Alert::toast( $clinic->klinik_adi.' added successfully', 'success');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function editClinic($clinicID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $clinic = Clinic::where('id','=',$clinicID)->first();
            $departments = Department::get();
            return view('Admin.editClinic',compact('clinic','departments'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function updateClinic(Request $request, $clinicID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $input = $request->all();
            $clinic = Clinic::where('id', '=', $clinicID)->first();
            Validator::make($input, [
                'klinik_adi' => ['required', 'string', 'max:255'],
                'klinik_numarasi' => ['required', 'integer'],
                'bolum_id' =>['required', 'integer']
            ])->validate();
            $clinic->klinik_adi = $request->klinik_adi;
            $clinic->klinik_numarasi = $request->klinik_numarasi;
            $clinic->bolum_id = $request->bolum_id;
            $clinic->save();
            Alert::toast($clinic->klinik_adi.' updated successfully', 'success');
            return redirect()->route('admin.hospital.clinics');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function deleteClinic($clinicID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $clinic = Clinic::where('id', '=', $clinicID)->first();
            $clinic->delete();
            Alert::toast($clinic->klinik_adi. ' deleted successfully','success');
            return redirect()->back();
        }
    }
}
