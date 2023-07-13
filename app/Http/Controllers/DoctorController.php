<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Room;
use App\Models\Inpatient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use DateTime;
use Illuminate\Http\UploadedFile;

class DoctorController extends Controller
{
    //
    public function doctorRedirect(){
        $usertype = Auth::user()->user_type;

        //Check user type and redirect to his page
        if($usertype == '1'){ //Doctor user
            $data = Auth::user();
            return view('Doctor.doctorProfile')->with('data', $data);
        }
        else{
            return view('home');
        }
    }
    public function updateProfile(Request $request){
            $usertype = Auth::user()->user_type;
            if($usertype == '1'){
            $user = Auth::user();
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'doktor_dt' => ['required','date'],
                'doktor_tel' => ['required', 'string', 'max:255'],
                'email' => ['required',Rule::unique('users')->ignore($user->id),],
                'doktor_cin' => ['required', 'string', 'max:255'],
            ]);

            $old_email = Auth::user()->email;
            $user->name = $request->name;
            $user->doctor->doktor_adi = $request->name;
            $user->doctor->doktor_dt = $request->doktor_dt;
            $user->doctor->doktor_tel = $request->doktor_tel;
            $user->doctor->doktor_cin = $request->doktor_cin;
            $user->doctor->doktor_adres = $request->doktor_adres;
            if($request->image){
                $image = $request->image;
                $imagename = time().'.'.$image->getClientOriginalExtension();
                $request->image->move('doctorImages',$imagename);
                $user->doctor->doktor_img = $imagename;

            }
            if($request->email != $old_email){
                $user->email = $request->email;
                $user->update();
            }
            $user->update();
            $user->doctor->update();
            Alert::toast('Profile updated successfully', 'success');
            return redirect()->back();
        }
    }

    public function doctorApp(){ //daily
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $appointments = Appointment::where('doktor_id','=',Auth::user()->id)
                            ->where('randevu_tarihi','=',now()->format('Y-m-d'))
                            ->orderBy('randevu_tarihi','ASC')
                            ->orderBy('randevu_saati')->paginate(12);
            return view('Doctor.apponitmentDoctor')->with('appointments',$appointments);
        }
    }
    public function allDoctorApp(){//all
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $appointments = Appointment::where('doktor_id','=',Auth::user()->id)
                            ->orderBy('randevu_tarihi','ASC')
                            ->orderBy('randevu_saati')->paginate(12);
            return view('Doctor.allAppointmentDoctor')->with('appointments',$appointments);
        }
    }
    public function showApp($appointmentID){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $appointment = Appointment::where('id', '=', $appointmentID)->first();
            return view('Doctor.showAppointment')->with('appointment',$appointment);
        }
    }
    public function attendApp(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $appointment = Appointment::where('id', '=', $request->id)->first();
            $appointment->randevu_durumu = "Attend";
            $appointment->save();
            return response()->json();
        }
    }
    public function inpatientPage(){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $inpatients = Inpatient::where('doktor_id','=',Auth::user()->id)
                                    ->where('yatis_durumu','<>','Rejected')
                                    ->where('yatis_durumu','<>','Out')
                                    ->orderBy('yatis_durumu','ASC')
                                    ->paginate(15);
            $departments = Department::all();
            return view('Doctor.inpatientDoctor')->with('inpatients',$inpatients)->with('departments',$departments);
        }
    }
    public function outpatientPage(){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $outpatients = Inpatient::where('doktor_id','=',Auth::user()->id)
                                    ->where('yatis_durumu','=','Out')
                                    ->orderBy('yatis_tarihi','ASC')
                                    ->orderBy('created_at','DESC')
                                    ->paginate(15);
            return view('Doctor.outPatient')->with('outpatients',$outpatients);
        }
    }

    public function newInpatient(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $hastaTc = Patient::where('hasta_tc','=',$request->hasta_tc)->first();
            $inpatientCount = Inpatient::where('hasta_id','=',$hastaTc->user_id)
                                        ->where('yatis_durumu','<>','Out')->count();
            if($inpatientCount > 0){
                Alert::toast($hastaTc->hasta_adi.' is already In-patient','error');
                return redirect()->back();
            }
            else{
                $input = $request->all();
                Validator::make($input, [
                    'yatis_nedeni' =>['required','string','max:255'],
                ])->validate();
                $date = new DateTime(date('Y-m-d'));
                $inPatient =Inpatient::create([
                        'hasta_id' => DB::table('patients')->where('hasta_tc', '=',$input['hasta_tc'])->value('user_id'),
                        'doktor_id' => Auth::user()->id,
                        'yatis_tarihi' => now()->format('Y-m-d'),
                        'yatis_nedeni' => $input['yatis_nedeni'],
                        'yatis_durumu' => 'Requested',
                ]);
                $inPatient->save();
                Alert::toast('In-Patient requested','info');
                return redirect()->back();
            }
        }
    }
    public function deleteInpatientRequest($inPatientID){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $inpatient = Inpatient::where('id','=',$inPatientID)->first();
            $inpatient->yatis_durumu = 'Request deleted';
            $inpatient->save();
            $inpatient->delete();
            Alert::toast('Request deleted successfully','success');
            return redirect()->back();
        }
    }
    public function inPatientInfoShow($inPateintID){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $patient = Inpatient::where('hasta_id','=',$inPateintID)
                                ->where('yatis_durumu','<>','Out')->first();
            return view('Doctor.showInpatientInfo')->with('patient',$patient);
        }
    }
    public function outPatientInfoShow($inPateintID){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $patient = Inpatient::where('id','=',$inPateintID)
                                ->where('yatis_durumu','=','Out')->first();
            return view('Doctor.showOutpatientInfo')->with('patient',$patient);
        }
    }
    public function takeOutPatient($inPateintID){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $patient = Inpatient::where('id','=',$inPateintID)->first();
            $patient->yatis_durumu = 'Out';
            $patient->cikis_tarihi = now()->format('Y-m-d');
            $patient->save();
            Alert::toast('Patient is out now','success');
            return redirect()->back();
        }
    }
    public function searchAppsDoctor(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $appointments = Appointment::join('users','appointments.hasta_id','=','users.id')
                                    ->join('patients','appointments.hasta_id','=','patients.user_id')
                                    ->select('appointments.*','appointments.id as appID')
                                    ->where('patients.hasta_adi','LIKE',$request->search.'%')
                                    ->where('doktor_id','=',Auth::user()->id)
                                    ->orwhere('patients.hasta_tc','LIKE',$request->search.'%')
                                    ->where('doktor_id','=',Auth::user()->id)
                                    ->get();
            $output = " ";
            $attendColor = " ";
            foreach($appointments as $appointment){
                if($appointment->randevu_durumu == "Attend"){
                    $attendColor = 'style="color:#00a099"';
                }
                $output .=
            '<tr>
            <th scope="row" '.$attendColor.'>'.$appointment->apppatient->patient->hasta_tc.'</th>
            <td>'.$appointment->apppatient->patient->hasta_adi.'</td>
            <td>'.$appointment->apppatient->patient->hasta_cin.'</td>
            <td>'.$appointment->apppatient->patient->hasta_tel.'</td>
            <td>'.$appointment->randevu_tarihi.'</td>
            <td>'.$appointment->randevu_saati.'</td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/doctor/appointment/info/".$appointment->appID).'"class="navbar-brand mr-2"><i
                                    style="color: #4169E1;font-size:14pt" class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </td>
        </tr>';
            $attendColor = " ";
            }

        return response($output);
        }
    }
    public function filterMinAppsDoctor(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $maxDate = Appointment::where('doktor_id','=',Auth::user()->id)->max('randevu_tarihi');
            if($request->max != ""){
                $appointments = Appointment::join('users','appointments.hasta_id','=','users.id')
                                        ->join('patients','appointments.hasta_id','=','patients.user_id')
                                        ->select('appointments.*','appointments.id as appID')
                                        ->whereBetween('randevu_tarihi',[$request->min,$request->max])
                                        ->where('doktor_id','=',Auth::user()->id)
                                        ->orderBy('randevu_tarihi','ASC')
                                        ->orderBy('randevu_saati','ASC')
                                        ->get();
            }
            else{
                $appointments = Appointment::join('users','appointments.hasta_id','=','users.id')
                ->join('patients','appointments.hasta_id','=','patients.user_id')
                ->select('appointments.*','appointments.id as appID')
                ->whereBetween('randevu_tarihi',[$request->min,$maxDate])
                ->where('doktor_id','=',Auth::user()->id)
                ->orderBy('randevu_tarihi','ASC')
                ->orderBy('randevu_saati','ASC')
                ->get();
            }
            $output = " ";
            $attendColor = " ";
            foreach($appointments as $appointment){
                if($appointment->randevu_durumu == "Attend"){
                    $attendColor = 'style="color:#00a099"';
                }
                $output .=
            '<tr>
            <th scope="row" '.$attendColor.'>'.$appointment->apppatient->patient->hasta_tc.'</th>
            <td>'.$appointment->apppatient->patient->hasta_adi.'</td>
            <td>'.$appointment->apppatient->patient->hasta_cin.'</td>
            <td>'.$appointment->apppatient->patient->hasta_tel.'</td>
            <td>'.$appointment->randevu_tarihi.'</td>
            <td>'.$appointment->randevu_saati.'</td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/doctor/appointment/info/".$appointment->appID).'"class="navbar-brand mr-2"><i
                                    style="color: #4169E1;font-size:14pt" class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </td>
        </tr>';
            $attendColor = " ";
            }

        return response($output);
        }
    }
    public function filterMaxAppsDoctor(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $minDate = Appointment::where('doktor_id','=',Auth::user()->id)->min('randevu_tarihi');
            if($request->min != ""){
                $appointments = Appointment::join('users','appointments.hasta_id','=','users.id')
                                        ->join('patients','appointments.hasta_id','=','patients.user_id')
                                        ->select('appointments.*','appointments.id as appID')
                                        ->whereBetween('randevu_tarihi',[$request->min,$request->max])
                                        ->where('doktor_id','=',Auth::user()->id)
                                        ->orderBy('randevu_tarihi','ASC')
                                        ->orderBy('randevu_saati','ASC')
                                        ->get();
            }
            else{
                $appointments = Appointment::join('users','appointments.hasta_id','=','users.id')
                ->join('patients','appointments.hasta_id','=','patients.user_id')
                ->select('appointments.*','appointments.id as appID')
                ->whereBetween('randevu_tarihi',[$minDate,$request->max])
                ->where('doktor_id','=',Auth::user()->id)
                ->orderBy('randevu_tarihi','ASC')
                ->orderBy('randevu_saati','ASC')
                ->get();
            }
            $output = " ";
            $attendColor = " ";
            foreach($appointments as $appointment){
                if($appointment->randevu_durumu == "Attend"){
                    $attendColor = 'style="color:#00a099"';
                }
                $output .=
            '<tr>
            <th scope="row" '.$attendColor.'>'.$appointment->apppatient->patient->hasta_tc.'</th>
            <td>'.$appointment->apppatient->patient->hasta_adi.'</td>
            <td>'.$appointment->apppatient->patient->hasta_cin.'</td>
            <td>'.$appointment->apppatient->patient->hasta_tel.'</td>
            <td>'.$appointment->randevu_tarihi.'</td>
            <td>'.$appointment->randevu_saati.'</td>
            <td>
                        <div class="d-flex justify-content-center">
                            <a href="'.url("/doctor/appointment/info/".$appointment->appID).'"class="navbar-brand mr-2"><i
                                    style="color: #4169E1;font-size:14pt" class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </td>
        </tr>';
            $attendColor = " ";
            }

        return response($output);
        }
    }
    public function searchInpatientDoctor(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $inpatients = Inpatient::join('users','inpatients.hasta_id','=','users.id')
                                    ->join('patients','inpatients.hasta_id','=','patients.user_id')
                                    ->select('inpatients.*','inpatients.id as inID')
                                    ->where('patients.hasta_adi','LIKE',$request->search.'%')
                                    ->where('doktor_id','=',Auth::user()->id)
                                    ->where('yatis_durumu','<>','Out')
                                    ->orwhere('patients.hasta_tc','LIKE',$request->search.'%')
                                    ->where('doktor_id','=',Auth::user()->id)
                                    ->where('yatis_durumu','<>','Out')
                                    ->orderBy('yatis_durumu','ASC')
                                    ->get();
            $output = " ";

            foreach($inpatients as $inpatient){
                $room = " ";
                $department = " ";
                $instatus = " ";
                $actionOne = " ";
                $actionTwo = " ";
                if($inpatient->oda_id != null){
                    $room = $inpatient->inRoom->oda_numarasi;
                    $department = $inpatient->inRoom->department->bolum_adi;
                }
                if($inpatient->yatis_durumu == 'Active'){
                     $instatus = '<span class="badge rounded-8 text-bg-success">
                     <p class="p-1" style="color: white">Active</p>
                 </span>';
                    $actionOne = '
                    <form
                    action="'.url("/doctor/in-patient/make/out/".$inpatient->inID).'"
                    method="POST">
                    '.csrf_field().'
                    <button type="submit" class="navbar-brand mr-2"><i
                        style="color: #00a099;font-size:15pt"
                        class="fa-solid  fa-arrow-right-from-bracket"></i></button>
                    </form>
                    ';
                    $actionTwo = '
                    <a
                    href="'.url("/doctor/in-patient/patient/info/".$inpatient->hasta_id).'"class="navbar-brand mr-2"><i
                        style="color: #4169E1;font-size:15pt"
                        class="fa-solid fa-circle-info"></i>
                    </a>
                    ';
                }
                else if($inpatient->yatis_durumu == 'Requested'){
                    $instatus = '<span class="badge rounded-8 text-bg-primary">
                    <p class="p-1" style="color: white">Requsted</p>
                    </span>';
                    $actionOne = '
                    <form
                    action="'.url("/doctor/in-patient/delete-request/".$inpatient->inID).'"
                    method="POST">
                    '.csrf_field().'
                    <button type="submit" class="navbar-brand mr-2"><i
                            style="color: #E63946;font-size:14pt"
                            class="fa-solid fa-trash-can"></i></button>
                    </form>
                    ';
                    $actionTwo = '
                    <a
                    href="'.url("/doctor/in-patient/patient/info/".$inpatient->hasta_id).'"class="navbar-brand mr-2"><i
                        style="color: #4169E1;font-size:15pt"
                        class="fa-solid fa-circle-info"></i>
                     </a>
                    ';
                }
                $output .=
            '<tr>
            <th scope="row">'.$inpatient->inPatient->patient->hasta_tc.'</th>
            <td>'.$inpatient->inPatient->patient->hasta_adi.'</td>
            <td>'.$inpatient->yatis_tarihi.'</td>
            <td>'.$room.'</td>
            <td>'.$department.'</td>
            <td class="text-center">'.$instatus.'</td>
            <td>
                        <div class="d-flex justify-content-center">
                           '.$actionOne.'
                           '.$actionTwo .'
                        </div>
            </td>
        </tr>';
            }
        return response($output);
        }
    }
    public function searchOutpatientDoctor(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $inpatients = Inpatient::join('users','inpatients.hasta_id','=','users.id')
                                    ->join('patients','inpatients.hasta_id','=','patients.user_id')
                                    ->select('inpatients.*','inpatients.id as inID')
                                    ->where('yatis_durumu','=','Out')
                                    ->where('patients.hasta_adi','LIKE',$request->search.'%')
                                    ->where('doktor_id','=',Auth::user()->id)
                                    ->orwhere('patients.hasta_tc','LIKE',$request->search.'%')
                                    ->where('doktor_id','=',Auth::user()->id)
                                    ->get();
            $output = " ";
            foreach($inpatients as $inpatient){
                $output .=
            '<tr>
            <th scope="row">'.$inpatient->inPatient->patient->hasta_tc.'</th>
            <td>'.$inpatient->inPatient->patient->hasta_adi.'</td>
            <td>'.$inpatient->yatis_tarihi.'</td>
            <td>'.$inpatient->inRoom->oda_numarasi.'</td>
            <td>'.$inpatient->inRoom->department->bolum_adi.'</td>
            <td>'.$inpatient->cikis_tarihi.'</td>
            <td class="text-center">
            <span class="badge rounded-8 text-bg-danger">
                                                <p class="p-1" style="color: white">'.$inpatient->yatis_durumu.'</p>
            </span></td>
            <td>
                        <div class="d-flex justify-content-center">
                        <a href="'.url("/doctor/out-patient/patient/info/".$inpatient->inID).'"class="navbar-brand mr-2"><i
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
    public function inpatientDoctorFilter(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            if($request->filter == 'active'){
                $inpatients = Inpatient::join('users','inpatients.hasta_id','=','users.id')
                ->join('patients','inpatients.hasta_id','=','patients.user_id')
                ->select('inpatients.*','inpatients.id as inID')
                ->where('yatis_durumu','=','Active')
                ->where('doktor_id','=',Auth::user()->id)
                ->orderBy('yatis_tarihi','ASC')
                ->get();
            }
            else if($request->filter == 'requested'){
                $inpatients = Inpatient::join('users','inpatients.hasta_id','=','users.id')
                ->join('patients','inpatients.hasta_id','=','patients.user_id')
                ->select('inpatients.*','inpatients.id as inID')
                ->where('yatis_durumu','=','Requested')
                ->where('doktor_id','=',Auth::user()->id)
                ->orderBy('yatis_tarihi','ASC')
                ->get();
            }


            $output = " ";

            foreach($inpatients as $inpatient){
                $room = " ";
                $department = " ";
                $instatus = " ";
                $actionOne = " ";
                $actionTwo = " ";
                if($inpatient->oda_id != null){
                    $room = $inpatient->inRoom->oda_numarasi;
                    $department = $inpatient->inRoom->department->bolum_adi;
                }
                if($inpatient->yatis_durumu == 'Active'){
                     $instatus = '<span class="badge rounded-8 text-bg-success">
                     <p class="p-1" style="color: white">Active</p>
                 </span>';
                    $actionOne = '
                    <form
                    action="'.url("/doctor/in-patient/make/out/".$inpatient->inID).'"
                    method="POST">
                    '.csrf_field().'
                    <button type="submit" class="navbar-brand mr-2"><i
                        style="color: #00a099;font-size:15pt"
                        class="fa-solid  fa-arrow-right-from-bracket"></i></button>
                    </form>
                    ';
                    $actionTwo = '
                    <a
                    href="'.url("/doctor/in-patient/patient/info/".$inpatient->hasta_id).'"class="navbar-brand mr-2"><i
                        style="color: #4169E1;font-size:15pt"
                        class="fa-solid fa-circle-info"></i>
                    </a>
                    ';
                }
                else if($inpatient->yatis_durumu == 'Requested'){
                    $instatus = '<span class="badge rounded-8 text-bg-primary">
                    <p class="p-1" style="color: white">Requsted</p>
                    </span>';
                    $actionOne = '
                    <form
                    action="'.url("/doctor/in-patient/delete-request/".$inpatient->inID).'"
                    method="POST">
                    '.csrf_field().'
                    <button type="submit" class="navbar-brand mr-2"><i
                            style="color: #E63946;font-size:14pt"
                            class="fa-solid fa-trash-can"></i></button>
                    </form>
                    ';
                    $actionTwo = '
                    <a
                    href="'.url("/doctor/in-patient/patient/info/".$inpatient->hasta_id).'"class="navbar-brand mr-2"><i
                        style="color: #4169E1;font-size:15pt"
                        class="fa-solid fa-circle-info"></i>
                     </a>
                    ';
                }
                $output .=
            '<tr>
            <th scope="row">'.$inpatient->inPatient->patient->hasta_tc.'</th>
            <td>'.$inpatient->inPatient->patient->hasta_adi.'</td>
            <td>'.$inpatient->yatis_tarihi.'</td>
            <td>'.$room.'</td>
            <td>'.$department.'</td>
            <td class="text-center">'.$instatus.'</td>
            <td>
                        <div class="d-flex justify-content-center">
                           '.$actionOne.'
                           '.$actionTwo .'
                        </div>
            </td>
        </tr>';
            }
        return response($output);
        }
    }
    public function doctorResetPassword(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '1'){
            $user = Auth::user()->where('id','=',Auth::user()->id)->first();
            $input = $request->all();
            if($request->new_password == $request->confirm_password){
                Validator::make($input, [
                    'new_password' => ['required', 'string','min:8','max:16'],
                ])->validate();
                $user->password = Hash::make($input['new_password']);
                $user->save();
                Alert::toast('Password updated successfully','success');
                return redirect()->back();
            }
            else{
                Alert::toast('Passwords not match','error');
                return redirect()->back();
            }
        }
    }
}
