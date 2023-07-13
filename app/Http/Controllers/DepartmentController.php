<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{

    public function departmentsIndex(){
        $user_type = Auth::user()->user_type;
        if($user_type == '2'){
            $datas = Department::orderBy('bolum_adi','ASC')->paginate(10);
            return view('Admin.departments',compact('datas'));
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNewDepartment(Request $request)
    {
        $user_type = Auth::user()->user_type;
        if($user_type == '2'){
            $input = $request->all();
            Validator::make($input, [
                'bolum_adi' => ['required', 'string', 'max:255'],
                'bolum_adres' => ['required', 'string', 'max:255'],
            ])->validate();
            $department = Department::create([
                'bolum_adi' => $input['bolum_adi'],
                'bolum_adres' => $input['bolum_adres'],
                'bolum_aciklama' => $input['bolum_aciklama'],
            ]);
            $department->save();
            Alert::toast( $department->bolum_adi.' department added successfully', 'success');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function editDepartment($departmentID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $department = Department::where('id','=',$departmentID)->first();
            return view('Admin.editDepartment')->with('department',$department);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function updateDepartment(Request $request, $departmentID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $input = $request->all();
            $department = Department::where('id', '=', $departmentID)->first();
            Validator::make($input, [
                'bolum_adi' => ['required', 'string', 'max:255'],
                'bolum_adres' => ['required', 'string', 'max:255'],
            ])->validate();
            $department->bolum_adi = $request->bolum_adi;
            $department->bolum_adres = $request->bolum_adres;
            $department->bolum_aciklama = $request->bolum_aciklama;
            $department->save();
            Alert::toast($department->bolum_adi.' updated successfully', 'success');
            return redirect()->route('admin.hospital.departments');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function deleteDepartment($departmentID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $department = Department::where('id', '=', $departmentID)->first();
            $department->delete();
            Alert::toast($department->bolum_adi. ' department deleted successfully','success');
            return redirect()->back();
        }
    }
    
}
