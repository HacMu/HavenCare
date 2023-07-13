<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Inpatient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Room;
use Illuminate\Http\UploadedFile;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //check if user has login
    }

    public function adminRedirect(){
        $usertype = Auth::user()->user_type;
        //multi check user type if it is admin
        if($usertype == '2'){ //Admin user
            $admindata = Auth::user()->get();
            //Return count of users
            $patientCount = Auth::user()->where('user_type','=','0')->count();
            $doctorCount = Auth::user()->where('user_type','=','1')->count();
            $adminCount = Auth::user()->where('user_type','=','2')->count();


            //data for charts
            $chartData = Auth::user()::select('id','created_at')->where('user_type','=','0')->get()->groupBy(function($chartData){
                return Carbon::parse($chartData->created_at)->format('M');
            });
            $months = [];
            $monthCount = [];
            foreach($chartData as $month=> $values){
                $months[]=$month;
                $monthCount[] = count($values);
            }
            $chartDataApp = Appointment::select('id','created_at')->get()->groupBy(function($chartDataApp){
                return Carbon::parse($chartDataApp->created_at)->format('M');
            });
            $monthsApp = [];
            $monthCountApp = [];
            foreach($chartDataApp as $month=> $values){
                $monthsApp[]=$month;
                $monthCountApp[] = count($values);
            }
            return view('Admin.dashboard')
                    ->with('patientCount',$patientCount)
                    ->with('doctorCount',$doctorCount)
                    ->with('adminCount',$adminCount)
                    ->with('chartData',$chartData)
                    ->with('months',$months)
                    ->with('monthCount',$monthCount)
                    ->with('monthsApp',$monthsApp)
                    ->with('monthCountApp',$monthCountApp);
        }
        else{
            return abort(404,'Page not found');
        }
    }

    public function userPatients(){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $datas = Auth::user()->where('user_type','=','0')->orderBy('name','ASC')->paginate(10);
            return view('Admin.userPatients')
                    ->with('datas',$datas);
        }
        else{
            return abort(404,'Page not found');
        }
    }

    public function addNewPatient(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $input = $request->all();
            Validator::make($input, [
                'hasta_tc' => ['required','unique:patients', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'hasta_tel' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['rerquired','string','min:8'],
                'hasta_dt' => ['required', 'date'],
            ])->validate();
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['hasta_tc']),
            ]);
            $patient =Patient::create([
                    'user_id' => DB::table('users')->where('email', '=',$input['email'])->value('id'),
                    'hasta_tc' => $input['hasta_tc'],
                    'hasta_adi' => $input['name'],
                    'hasta_tel' => $input['hasta_tel'],
                    'hasta_dt' => $input['hasta_dt'],
                    'hasta_cin' => $input['hasta_cin'],
            ]);
            $user->save();
            $patient->save();
            Alert::toast($request->name.' added successfully', 'success');
            return redirect()->back();
        }

    }

    public function deletePatient($patientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $patient = Auth::user()->where('id','=',$patientID);
            $patient->delete();
            Alert::toast('Patient has been deleted successfully', 'success');
            return redirect()->route('admin.users.patients');
        }
    }
    public function editPatient($patientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $patientData = Auth::user()->where('id','=',$patientID)->first();
            return view('Admin.editPatient')->with('patientData',$patientData);
        }
    }
    public function updatePatient(Request $request,$patientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $user = Auth::user()->where('id','=',$patientID)->first();
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'hasta_dt' => ['required','date'],
            'hasta_tel' => ['required', 'string', 'max:255'],
            'email' => ['required','email','string',Rule::unique('users')->ignore($user->id)],
            'hasta_tc' => ['required','string', 'max:255',Rule::unique('patients')->ignore($user->patient->id)],
            'hasta_cin' => ['required', 'string', 'max:255'],
        ]);
        $old_email = Auth::user()->select('email')->where('id','=',$patientID);

        $user->name = $request->name;
        $user->patient->hasta_adi = $request->name;
        $user->patient->hasta_dt = $request->hasta_dt;
        $user->patient->hasta_tel = $request->hasta_tel;
        $user->patient->hasta_cin = $request->hasta_cin;
        $user->patient->hasta_adres = $request->hasta_adres;
        $user->patient->hasta_kan_grubu = $request->hasta_kan_grubu;
        $user->patient->hasta_boyu = $request->hasta_boyu;
        $user->patient->hasta_kilo = $request->hasta_kilo;
        $user->patient->hasta_tc = $request->hasta_tc;
        if($request->email != $old_email){
            $user->email = $request->email;
            $user->update();
        }
        $user->update();
        $user->patient->update();
        Alert::toast($user->patient->hasta_adi.' updated successfully', 'success');
        return redirect()->route('admin.users.patients');
        }
    }
    public function showPatient($patientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $patientData = Auth::user()->where('id','=',$patientID)->first();
            return view('Admin.showPatient')->with('patientData',$patientData);
        }
    }

    public function userDoctors(){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $datas = Auth::user()->where('user_type','=','1')->orderBy('name','ASC')->paginate(10);
            $clinics = Clinic::get();
            $departments = Department::get();
            return view('Admin.userDoctors')
                    ->with('datas',$datas)
                    ->with('clinics',$clinics)
                    ->with('departments',$departments);
        }
        else{
            return abort(404,'Page not found');
        }
    }
    public function addNewDoctor(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $input = $request->all();
            Validator::make($input, [
                'doktor_tc' => ['required','unique:doctors', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'doktor_tel' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['rerquired','string','min:8'],
                'doktor_dt' => ['required', 'date'],
                'doktor_cin' => ['required', 'string', 'max:255'],
                'doktor_uzmanlik' => ['required', 'string', 'max:255'],
                'klinik_id'=> ['required', 'integer']
            ])->validate();
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['doktor_tc']),
                'user_type'=> 1,
            ]);
            $doctor =Doctor::create([
                    'user_id' => DB::table('users')->where('email', '=',$input['email'])->value('id'),
                    'doktor_tc' => $input['doktor_tc'],
                    'doktor_adi' => $input['name'],
                    'doktor_tel' => $input['doktor_tel'],
                    'doktor_dt' => $input['doktor_dt'],
                    'doktor_cin' => $input['doktor_cin'],
                    'doktor_uzmanlik' => $input['doktor_uzmanlik'],
                    'klinik_id' => $input['klinik_id'],
            ]);
            if($request->doktor_img){
                $image = $request->doktor_img;
                $imagename = time().'.'.$image->getClientOriginalExtension();
                $request->doktor_img->move('doctorImages',$imagename);
                $doctor->doktor_img = $imagename;

            }
            $user->save();
            $doctor->save();
            Alert::toast($request->name.' added successfully', 'success');
            return redirect()->back();
        }
    }
    public function deleteDoctor($doctorID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $doctor = Auth::user()->where('id','=',$doctorID);
            $doctor->delete();
            Alert::toast('Doctor has been deleted successfully', 'success');
            return redirect()->route('admin.users.doctors');
        }
    }
    public function showDoctor($doctorID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $doctorData = Auth::user()->where('id','=',$doctorID)->first();
            return view('Admin.showDoctor')->with('doctorData',$doctorData);
        }
    }

    public function editDoctor($doctorID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $doctorData = Auth::user()->where('id','=',$doctorID)->first();
            $clinics = Clinic::where('bolum_id','=', $doctorData->doctor->clinic->department->id)->get();
            $departments = Department::get();
            return view('Admin.editDoctor')->with('doctorData',$doctorData)
                                           ->with('clinics',$clinics)
                                           ->with('departments',$departments);
        }
    }

    public function updateDoctor(Request $request, $doctorID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $doctor = Auth::user()->where('id','=',$doctorID)->first();
            $input = $request->all();
            Validator::make($input, [
                'doktor_tc' => ['required', 'string', 'max:255',Rule::unique('doctors')->ignore($doctor->doctor->id)],
                'name' => ['required', 'string', 'max:255'],
                'doktor_tel' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($doctor->id)],
                'doktor_dt' => ['required', 'date'],
                'doktor_cin' => ['required', 'string', 'max:255'],
                'doktor_uzmanlik' => ['required', 'string', 'max:255'],
                'klinik_id'=> ['required', 'integer'],
            ])->validate();
            $old_email = Auth::user()->select('email')->where('id','=',$doctorID);

            $doctor->name = $request->name;
            $doctor->doctor->doktor_adi = $request->name;
            $doctor->doctor->doktor_tc = $request->doktor_tc;
            $doctor->doctor->doktor_tel = $request->doktor_tel;
            $doctor->doctor->doktor_cin = $request->doktor_cin;
            $doctor->doctor->doktor_dt = $request->doktor_dt;
            $doctor->doctor->doktor_uzmanlik = $request->doktor_uzmanlik;
            $doctor->doctor->klinik_id = $request->klinik_id;
            $doctor->doctor->doktor_adres = $request->doktor_adres;
            if($request->email != $old_email){
                $doctor->email = $request->email;
                $doctor->update();
            }
            $doctor->update();
            $doctor->doctor->update();
            Alert::toast('Dr.'.$doctor->doctor->doktor_adi.' updated successfully', 'success');
            return redirect()->route('admin.users.doctors');
        }
    }

    public function getDepOfClinic(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $clinic = Clinic::where('bolum_id','=',$request->id)->get();
            return response()->json($clinic);
        }
    }
    public function activeInpatient(){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $inpatients = Inpatient::where('yatis_durumu','=','Active')->latest()->paginate(15);
            $requestCount = Inpatient::where('yatis_durumu','=','Requested')->count();
            return view('Admin.inpatientAdmin',compact('inpatients','requestCount'));
        }
    }
    public function outInpatient(){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $inpatients = Inpatient::where('yatis_durumu','=','Out')->latest()->paginate(15);
            return view('Admin.outpatientAdmin',compact('inpatients'));
        }
    }
    public function showInpatientInfo($patientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $patient = Inpatient::where('id','=',$patientID)
            ->where('yatis_durumu','=','Active')->first();
            return view('Admin.adminShowInpatientInfo')->with('patient',$patient);
        }
    }
    public function showOutpatientInfo($patientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $patient = Inpatient::where('id','=',$patientID)
            ->where('yatis_durumu','=','Out')->first();
            return view('Admin.adminShowOutpatientInfo')->with('patient',$patient);
        }
    }
    public function inPatientRequestInfo($patientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $patient = Inpatient::where('id','=',$patientID)
            ->where('yatis_durumu','=','Requested')->first();
            $departments = Department::all();
            return view('Admin.inPatientRequestInfo')->with('patient',$patient)->with('departments',$departments);
        }
    }
    public function inPatientRequest(){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $inpatients = Inpatient::where('yatis_durumu','=','Requested')->latest()->paginate(15);
            return view('Admin.adminRequestInpatient',compact('inpatients'));
        }
    }
    public function getRoom(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){

                $rooms = Room::where('bolum_id','=',$request->depID)->get();
            return response()->json($rooms);
        }
    }
    public function inPatientConfirmRequest(Request $request,$inpatientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $inpatientRequest = Inpatient::where('id','=',$inpatientID)->first();
            $input = $request->all();
            Validator::make($input, [
                'oda_id' =>['required']
            ])->validate();
            $inpatientRequest->oda_id = $request->oda_id;
            $inpatientRequest->yatis_tarihi = now()->format('Y-m-d');
            $inpatientRequest->yatis_durumu = 'Active';
            $inpatientRequest->save();
            Alert::toast('Request activated successfully','success');
            return redirect()->route('admin.inpatient.request');
        }
    }
    public function searchInpatient(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $inpatients = Inpatient::join('patients', 'inpatients.hasta_id', '=', 'patients.user_id')
                                    ->join('doctors', 'inpatients.doktor_id', '=', 'doctors.user_id')
                                    ->select('inpatients.*','inpatients.id as inID')
                                    ->where('patients.hasta_adi','LIKE',$request->search.'%')
                                    ->where('inpatients.yatis_durumu','=','Active')
                                    ->orwhere('patients.hasta_tc','LIKE',$request->search.'%')
                                    ->where('inpatients.yatis_durumu','=','Active')
                                    ->orwhere('doctors.doktor_adi','LIKE',$request->search.'%')
                                    ->where('inpatients.yatis_durumu','=','Active')
                                    ->get();
            $output = " ";
            foreach($inpatients as $inpatient){
                $output .=
            '<tr>
            <th scope="row">'.$inpatient->inPatient->patient->hasta_tc.'</th>
            <td>'.$inpatient->inPatient->patient->hasta_adi.'</td>
            <td>'.$inpatient->inDoctor->doctor->doktor_adi.'</td>
            <td>'.$inpatient->yatis_tarihi.'</td>
            <td>'.$inpatient->inRoom->oda_numarasi.'</td>
            <td>'.$inpatient->inRoom->department->bolum_adi.'</td>
            <td class="text-center"><span class="badge rounded-8 text-bg-success">
            <p class="p-1" style="color: white">Active</p>
            </span>
             </td>
            <td>
            <div class="d-flex justify-content-center">
            <a
                href="'.url("/admin/in-patient/show/info/".$inpatient->inID).'" class="navbar-brand mr-2"><i
                    style="color: #4169E1;font-size:15pt"
                    class="fa-solid fa-circle-info"></i>
            </a>
            </div>
            </td>
        </tr>';
            }
        return response($output);
        }
    }
    public function searchOutpatient(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $inpatients = Inpatient::join('patients', 'inpatients.hasta_id', '=', 'patients.user_id')
                                    ->join('doctors', 'inpatients.doktor_id', '=', 'doctors.user_id')
                                    ->select('inpatients.*','inpatients.id as inID')
                                    ->where('patients.hasta_adi','LIKE',$request->search.'%')
                                    ->where('inpatients.yatis_durumu','=','Out')
                                    ->orwhere('patients.hasta_tc','LIKE',$request->search.'%')
                                    ->where('inpatients.yatis_durumu','=','Out')
                                    ->orwhere('doctors.doktor_adi','LIKE',$request->search.'%')
                                    ->where('inpatients.yatis_durumu','=','Out')
                                    ->get();
            $output = " ";
            foreach($inpatients as $inpatient){
                $output .=
            '<tr>
            <th scope="row">'.$inpatient->inPatient->patient->hasta_tc.'</th>
            <td>'.$inpatient->inPatient->patient->hasta_adi.'</td>
            <td>'.$inpatient->inDoctor->doctor->doktor_adi.'</td>
            <td>'.$inpatient->yatis_tarihi.'</td>
            <td>'.$inpatient->inRoom->oda_numarasi.'</td>
            <td>'.$inpatient->inRoom->department->bolum_adi.'</td>
            <td>'.$inpatient->cikis_tarihi.'</td>
            <td class="text-center"><span class="badge rounded-8 text-bg-danger">
            <p class="p-1" style="color: white">Out</p>
            </span>
             </td>
            <td>
            <div class="d-flex justify-content-center">
            <a
                href="'.url("/admin/out-patient/show/info/".$inpatient->inID).'" class="navbar-brand mr-2"><i
                    style="color: #4169E1;font-size:15pt"
                    class="fa-solid fa-circle-info"></i>
            </a>
            </div>
            </td>
        </tr>';
            }
        return response($output);
        }
    }


    public function searchPatient(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $patients = User::join('patients', 'users.id', '=', 'patients.user_id')
                                    ->select('users.*','users.id as patientID')
                                    ->where('patients.hasta_adi','LIKE',$request->search.'%')
                                    ->orwhere('patients.hasta_tc','LIKE',$request->search.'%')
                                    ->get();
            $output = " ";
            foreach($patients as $patient){
                if($patient->patient->created_at == $patient->patient->updated_at){
                    $td = '<span class="badge rounded-pill text-bg-danger">Unupdated</span>';
                }
                else{
                    $td = '<span class="badge rounded-pill text-bg-success">Updated</span>';
                }
                $output .=
            '<tr>
            <th scope="row">'.$patient->patientID.'</th>
            <td>'.$patient->patient->hasta_tc.'</td>
            <td>'.$patient->patient->hasta_adi.'</td>
            <td>'.$patient->patient->hasta_cin.'</td>
            <td>'.$patient->patient->hasta_dt.'</td>
            <td>'.$patient->email.'</td>
            <td>'.$patient->patient->hasta_tel.'</td>
            <td class="text-center">'.$patient->patient->created_at->format('d-m-Y').'</td>
            <td>
                <div class="d-flex justify-content-center">
                '.$td.'
                </div>
            </td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/admin/users/edit/patient/".$patient->patientID).'" class="navbar-brand mr-2"><i
                                    style="color: #00a099;font-size:14pt" class="fa-solid fa-pen-to-square "></i>
                            </a>
                            <a href="'.url("/admin/users/show/patient/".$patient->patientID).'"class="navbar-brand mr-2"><i
                                    style="color: #4169E1;font-size:14pt" class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#"class="navbar-brand">
                                <form action="'.url("/admin/users/patients/delete/".$patient->patientID).'" method="POST">
                                    '.csrf_field().'
                                    <button type="submit" class="navbar-brand"><i style="color: #E63946;font-size:14pt"
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </a>
                        </div>
                    </td>
        </tr>';
            }

        return response($output);
        }
    }
    public function searchDoctor(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $doctors = User::join('doctors', 'users.id', '=', 'doctors.user_id')
                                    ->select('users.*','users.id as doctorID')
                                    ->where('doctors.doktor_adi','LIKE',$request->search.'%')
                                    ->orwhere('doctors.doktor_tc','LIKE',$request->search.'%')
                                    ->orwhere('doctors.doktor_uzmanlik','LIKE',$request->search.'%')
                                    ->get();
            $output = " ";
            foreach($doctors as $doctor){
                if($doctor->doctor->created_at == $doctor->doctor->updated_at){
                    $td = '<span class="badge rounded-pill text-bg-danger">Unupdated</span>';
                }
                else{
                    $td = '<span class="badge rounded-pill text-bg-success">Updated</span>';
                }
                $output .=
            '<tr>
            <th scope="row">'.$doctor->doctorID.'</th>
            <td>'.$doctor->doctor->doktor_tc.'</td>
            <td>'.$doctor->doctor->doktor_adi.'</td>
            <td>'.$doctor->doctor->doktor_uzmanlik.'</td>
            <td>'.$doctor->doctor->clinic->klinik_adi.'</td>
            <td>'.$doctor->doctor->clinic->department->bolum_adi.'</td>
            <td>
                <div class="d-flex justify-content-center">
                '.$td.'
                </div>
            </td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/admin/users/edit/doctor/".$doctor->doctorID).'" class="navbar-brand mr-2"><i
                                    style="color: #00a099;font-size:14pt" class="fa-solid fa-pen-to-square "></i>
                            </a>
                            <a href="'.url("/admin/users/show/doctor/".$doctor->doctorID).'"class="navbar-brand mr-2"><i
                                    style="color: #4169E1;font-size:14pt" class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#"class="navbar-brand">
                                <form action="'.url("/admin/users/doctors/delete/".$doctor->doctorID).'" method="POST">
                                    '.csrf_field().'
                                    '.method_field('DELETE') .'
                                    <button type="submit" class="navbar-brand"><i style="color: #E63946;font-size:14pt"
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </a>
                        </div>
                    </td>
        </tr>';
            }

        return response($output);
        }
    }
    public function searchDepartments(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $departments = Department::where('bolum_adi','LIKE',$request->search.'%')
                                        ->orwhere('bolum_adres','LIKE',$request->search.'%')->get();
            $output = " ";
            foreach($departments as $department){
                if($department->created_at == $department->updated_at){
                    $td = '<span class="badge rounded-pill text-bg-danger">Unupdated</span>';
                }
                else{
                    $td = '<span class="badge rounded-pill text-bg-success">Updated</span>';
                }
            $output .=
            '<tr>
            <th scope="row">'.$department->id.'</th>
            <td>'.$department->bolum_adi.'</td>
            <td>'.$department->bolum_adres.'</td>
            <td>'.$department->bolum_aciklama.'</td>
            <td>'.$department->created_at.'</td>
            <td>
                <div class="d-flex justify-content-center">
                '.$td.'
                </div>
            </td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/admin/hospital/edit/department/".$department->id).'" class="navbar-brand mr-2"><i
                                    style="color: #00a099;font-size:14pt" class="fa-solid fa-pen-to-square "></i>
                            </a>
                            <a href="#"class="navbar-brand">
                                <form action="'.url("/admin/hospital/delete/department/".$department->id).'" method="POST">
                                    '.csrf_field().'
                                    '.method_field('DELETE') .'
                                    <button type="submit" class="navbar-brand"><i style="color: #E63946;font-size:14pt"
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </a>
                        </div>
                    </td>
        </tr>';
            }
        return response($output);
        }
    }
    public function searchClinic(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $clinics = Clinic::join('departments', 'clinics.bolum_id', '=', 'departments.id')
                                    ->select('clinics.*','clinics.id as clinicID')
                                    ->where('clinics.klinik_adi','LIKE',$request->search.'%')
                                    ->orwhere('clinics.klinik_numarasi','LIKE',$request->search.'%')
                                    ->get();
            $output = " ";
            foreach($clinics as $clinic){
                if($clinic->created_at == $clinic->updated_at){
                    $td = '<span class="badge rounded-pill text-bg-danger">Unupdated</span>';
                }
                else{
                    $td = '<span class="badge rounded-pill text-bg-success">Updated</span>';
                }
                $output .=
            '<tr>
            <th scope="row">'.$clinic->clinicID.'</th>
            <td>'.$clinic->klinik_adi.'</td>
            <td>'.$clinic->klinik_numarasi.'</td>
            <td>'.$clinic->department->bolum_adi.'</td>
            <td>'.$clinic->department->bolum_adres.'</td>
            <td>'.$clinic->created_at->format('d-m-Y').'</td>
            <td>
                <div class="d-flex justify-content-center">
                '.$td.'
                </div>
            </td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/admin/hospital/edit/clinic/".$clinic->clinicID).'" class="navbar-brand mr-2"><i
                                    style="color: #00a099;font-size:14pt" class="fa-solid fa-pen-to-square "></i>
                            </a>
                            <a href="#"class="navbar-brand">
                                <form action="'.url("/admin/hospital/delete/clinic/".$clinic->clinicID).'" method="POST">
                                    '.csrf_field().'
                                    '.method_field('DELETE') .'
                                    <button type="submit" class="navbar-brand"><i style="color: #E63946;font-size:14pt"
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </a>
                        </div>
                    </td>
        </tr>';
            }

        return response($output);
        }
    }
    public function searchRoom(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $rooms = Room::join('departments', 'rooms.bolum_id', '=', 'departments.id')
                                    ->select('rooms.*','rooms.id as roomID')
                                    ->where('rooms.oda_adi','LIKE',$request->search.'%')
                                    ->orwhere('rooms.oda_numarasi','LIKE',$request->search.'%')
                                    ->orwhere('departments.bolum_adi','LIKE',$request->search.'%')
                                    ->get();
            $output = " ";
            foreach($rooms as $room){
                if($room->created_at == $room->updated_at){
                    $td = '<span class="badge rounded-pill text-bg-danger">Unupdated</span>';
                }
                else{
                    $td = '<span class="badge rounded-pill text-bg-success">Updated</span>';
                }
                $output .=
            '<tr>
            <th scope="row">'.$room->roomID.'</th>
            <td>'.$room->oda_adi.'</td>
            <td>'.$room->oda_numarasi.'</td>
            <td>'.$room->yatak_sayisi.'</td>
            <td>'.$room->department->bolum_adi.'</td>
            <td>'.$room->department->bolum_adres.'</td>
            <td>'.$room->created_at->format('d-m-Y').'</td>
            <td>
                <div class="d-flex justify-content-center">
                '.$td.'
                </div>
            </td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/admin/hospital/edit/room/".$room->roomID).'" class="navbar-brand mr-2"><i
                                    style="color: #00a099;font-size:14pt" class="fa-solid fa-pen-to-square "></i>
                            </a>
                            <a href="#"class="navbar-brand">
                                <form action="'.url("/admin/hospital/delete/room/".$room->roomID).'" method="POST">
                                    '.csrf_field().'
                                    '.method_field('DELETE') .'
                                    <button type="submit" class="navbar-brand"><i style="color: #E63946;font-size:14pt"
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </a>
                        </div>
                    </td>
        </tr>';
            }

        return response($output);
        }
    }
    public function showAppAdmin(){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $appointments = Appointment::where('randevu_durumu','=','Active')->orderBy('created_at','ASC')->paginate(12);
            return view('Admin.appointmentAdmin',compact('appointments'));
        }
    }
    public function appInfoShowAdmin($appID){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $appointment = Appointment::where('id','=',$appID)->first();
            return view('Admin.adminShowAppInfo')->with('appointment',$appointment);
        }
    }
    public function searchForAppAdmin(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $appointments = Appointment::join('patients', 'appointments.hasta_id', '=', 'patients.user_id')
                                    ->join('doctors', 'appointments.doktor_id', '=', 'doctors.user_id')
                                    ->select('appointments.*','appointments.id as appID')
                                    ->where('patients.hasta_adi','LIKE',$request->search.'%')
                                    ->where('appointments.randevu_durumu','=','Active')
                                    ->orwhere('patients.hasta_tc','LIKE',$request->search.'%')
                                    ->where('appointments.randevu_durumu','=','Active')
                                    ->orwhere('doctors.doktor_adi','LIKE',$request->search.'%')
                                    ->where('appointments.randevu_durumu','=','Active')
                                    ->get();
            $output = " ";
            foreach($appointments as $appointment){
                $output .=
            '<tr>
            <th scope="row">'.$appointment->apppatient->patient->hasta_tc.'</th>
            <td>'.$appointment->apppatient->patient->hasta_adi.'</td>
            <td>'.$appointment->appdoctor->doctor->doktor_adi.'</td>
            <td>'.$appointment->appdoctor->doctor->clinic->department->bolum_adi.'</td>
            <td>'.$appointment->randevu_tarihi.'</td>
            <td>'.$appointment->randevu_saati.'</td>
            <td>
            <div class="d-flex justify-content-center">
            <a
                href="'.url("/admin/appointment/show/".$appointment->appID).'" class="navbar-brand mr-2"><i
                    style="color: #4169E1;font-size:15pt"
                    class="fa-solid fa-circle-info"></i>
            </a>
            </div>
            </td>
        </tr>';
            }
        return response($output);
        }
    }
}
