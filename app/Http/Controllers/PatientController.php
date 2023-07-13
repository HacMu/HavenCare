<?php


namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Http\UploadedFile;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //check if user has login
    }
    public function patientRedirect(){
        $usertype = Auth::user()->user_type;

        //Check user type and redirect to his page
        if($usertype == '0'){ //Patient user
            $data = Auth::user();
            $usertype = Auth::user()->user_type;
            return view('Patient.profile')->with('data', $data);
        }
        else{
            return view('home');
        }
    }

    //update profile
    public function update(Request $request)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
        $user = Auth::user();
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'hasta_dt' => ['required','date'],
            'hasta_tel' => ['required', 'string', 'max:255'],
            'email' => ['required',Rule::unique('users')->ignore($user->id),],
            'hasta_cin' => ['required', 'string', 'max:255'],
            'hasta_adres' => ['required', 'string', 'max:255'],
            'hasta_kan_grubu' =>['required', 'string', 'max:255']
        ]);

        $old_email = Auth::user()->email;
        $user->name = $request->name;
        $user->patient->hasta_adi = $request->name;
        $user->patient->hasta_dt = $request->hasta_dt;
        $user->patient->hasta_tel = $request->hasta_tel;
        $user->patient->hasta_cin = $request->hasta_cin;
        $user->patient->hasta_adres = $request->hasta_adres;
        $user->patient->hasta_kan_grubu = $request->hasta_kan_grubu;
        $user->patient->hasta_boyu = $request->hasta_boyu;
        $user->patient->hasta_kilo = $request->hasta_kilo;
        if($request->image){
            $image = $request->image;
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('patientImage',$imagename);
            $user->patient->hasta_image = $imagename;

        }
        if($request->email != $old_email){
            $user->email = $request->email;
            $user->update();
        }
        $user->update();
        $user->patient->update();
        Alert::toast('Profile updated successfully', 'success');
        return redirect()->back();
    }
    }

    public function changePassword(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $user = Auth::user();
            if ($request->has('password')) {
                if($request->new_password == $request->confirm_password){
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    return redirect()->back()->with('Changed','Password changed successfully');
                }
            }
            else{
                return redirect()->back()->with('Uncorrect','Password and Confirm password are not equal');
            }
        }
    }

    //get clinic name for appointment
    public function getClinicsApp(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $clinic = Clinic::where('bolum_id','=',$request->id)->get();
            return response()->json($clinic);
        }
    }
    //get doctor name for appointment linked with clinic
    public function getDoctorApp(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $doctor = Doctor::where('klinik_id','=',$request->klinikID)->get();
            return response()->json($doctor);
        }
    }
    //search for department when book an apponitment
    public function searchDepartment(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $departments = Department::where('bolum_adi','LIKE',$request->search.'%')->get();
            return response()->json($departments);
        }
    }
    //get available time for appointment for every single doctor
    public function getAvailableTime(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $Time = ['09:00','09:30','10:00','10:30','11:00','11:30','13:30','14:00','14:30','15:00','15:30'];
            $appTimes =[];
            $randevuSaat = Appointment::where('randevu_tarihi','=',$request->date)
                                        ->where('doktor_id','=',$request->id)->get();
            foreach($randevuSaat as $saat){
                for($i=0;$i<11;$i++){
                    if($saat->randevu_saati == $Time[$i]){
                        array_push($appTimes,$Time[$i]);
                    }
                }
            }
            if(!$appTimes){
                $appTimes = ['0'];
                return response()->json($appTimes);
            }
            else{
                return response()->json($appTimes);
            }
        }
    }

    //show appointment page for patient
    public function appointmentPage(){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $appointments = Appointment::where('hasta_id','=',Auth::user()->id)
                                        ->where('randevu_tarihi','>=',now()->format('Y-m-d'))
                                        ->where('randevu_durumu','<>','Attend')
                                        ->orderBy('randevu_tarihi','ASC')
                                        ->orderBy('randevu_saati')->paginate(4);
            $departments = Department::get();
            return view('Patient.appointmentPatient')->with('appointments',$appointments)
                                                    ->with('departments',$departments);
        }
    }

    //Book an appointment patient panel
    public function bookAppointment(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $user = Auth::user();
            $appointmentCount = Appointment::where('hasta_id','=',$user->id)
                                            ->where('randevu_tarihi','>=',now()->format('Y-m-d'))->count();
            $doctor = Auth::user()->where('id','=',$request->doktor_id)->first();
            $departmentCounts =  Appointment::where('hasta_id','=',$user->id)
                                            ->where('randevu_tarihi','>=',now()->format('Y-m-d'))->get();
            $count = 0;
            foreach($departmentCounts as $departmentCount){
                if($departmentCount->appdoctor->doctor->clinic->department->id == $doctor->doctor->clinic->department->id){
                    $count++;
                }
            }
            if($appointmentCount < 4){ //check count of active appointment for user
                if( $count < 1){ //only one department appointment at the same time
                    $input = $request->all();
                    Validator::make($input, [
                        'doktor_id' => 'required',
                        'randevu_tarihi' => ['required','date'],
                        'randevu_saati' =>['required','string']
                    ])->validate();
                    $appointment =Appointment::create([
                        'doktor_id'=> $input['doktor_id'],
                        'hasta_id'=>Auth::user()->id,
                        'randevu_tarihi' => $input['randevu_tarihi'],
                        'randevu_saati' => $input['randevu_saati'],
                        'randevu_durumu' => 'Active'
                ]);
                $appointment->save();
                Alert::toast('Appoitment booked succussfully','success');
                return redirect()->back();
                }
                else{
                    Alert::toast('Only 1 department book at the same time','error');
                    return redirect()->back();
                }
            }

            else{
                Alert::toast('You can book only 4 appointment','error');
                return redirect()->back();
            }

            }
    }

    //Cancle appointment for patient
    public function cancleApp($randevuID){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $randevu = Appointment::where('id','=',$randevuID)->first();
            $randevu->randevu_durumu = "cancled by patient";
            $randevu->save();
            $randevu->delete();
            Alert::toast('Appointment cancled successfully','success');
            return redirect()->back();
        }
    }

    public function historyAppointment(){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
            $appointments = Appointment::where('hasta_id','=',Auth::user()->id)
                            ->where('randevu_durumu', '=','Attend')
                            ->orWhere('randevu_tarihi','<',now()->format('Y-m-d'))
                            ->where('hasta_id','=',Auth::user()->id)->latest()->paginate(4);
            return view('Patient.trashedHistory',compact('appointments'));
        }
    }
    public function patientResetPassword(Request $request){
        $usertype = Auth::user()->user_type;
        if($usertype == '0'){
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
