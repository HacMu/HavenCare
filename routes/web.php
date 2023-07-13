<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoomController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Routes created by Auth
Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/redirects',[HomeController::class,'redirects']);

Route::post('/changePasswordUsers',[HomeController::class,'changePasswordUsers'])->name('changing.password');

//Admin routes
Route::get('/admin/dashboard', [AdminController::class,'adminRedirect'])->name('admin.dashboard');//redirect admin
Route::get('/admin/users/patients', [AdminController::class,'userPatients'])->name('admin.users.patients');//show patient
Route::post('/admin/users/patients',[AdminController::class,'addNewPatient'])->name('add.new.patient');//add new patient
Route::put('/admin/users/update/patient/{id}',[AdminController::class,'updatePatient'])->name('admin.update.patient');
Route::get('/admin/users/edit/patient/{id}', [AdminController::class,'editPatient'])->name('admin.edit.patient');//open edit patient panel
Route::get('/admin/users/show/patient/{id}', [AdminController::class,'showPatient'])->name('admin.show.patient');//
Route::post('/admin/users/patients/delete/{id}',[AdminController::class,'deletePatient'])->name('delete.patient');
Route::get('/searchPatient' ,[AdminController::class,'searchPatient']);//search patient


Route::get('/admin/users/doctors', [AdminController::class,'userDoctors'])->name('admin.users.doctors');//show DOCTOR
Route::post('/admin/users/doctors',[AdminController::class,'addNewDoctor'])->name('add.new.doctor');//add new DOCTOR
Route::get('/admin/users/show/doctor/{id}', [AdminController::class,'showDoctor'])->name('admin.show.doctor');// show DOCTOR information
Route::delete('/admin/users/doctors/delete/{id}',[AdminController::class,'deleteDoctor'])->name('delete.doctor');//delete DOCTOR
Route::get('/admin/users/edit/doctor/{id}', [AdminController::class,'editDoctor'])->name('admin.edit.doctor');//open edit doctor panel
Route::get('/getDepOfClinic', [AdminController::class,'getDepOfClinic']);//get department name of clinic
Route::put('/admin/users/update/doctor/{id}',[AdminController::class,'updateDoctor'])->name('admin.update.doctor');//update DOCTOR
Route::get('/admin/active/in-patient', [AdminController::class,'activeInpatient'])->name('admin.active.inpatient');//show active in-patient
Route::get('/admin/out-patient', [AdminController::class,'outInpatient'])->name('admin.out.inpatient');//show out-patient
Route::get('/admin/in-patient/show/info/{id}', [AdminController::class,'showInpatientInfo'])->name('admin.active.inpatient.info');//show in-patient info
Route::get('/admin/out-patient/show/info/{id}', [AdminController::class,'showOutpatientInfo'])->name('admin.out.outpatient.info');//show out-patient info
Route::get('/admin/request-patient/', [AdminController::class,'inPatientRequest'])->name('admin.inpatient.request');//show in-patient request page
Route::post('/admin/request-patient/confirm/{id}', [AdminController::class,'inPatientConfirmRequest'])->name('admin.inpatient.confirm.request');//confirm in-patient request
Route::get('/admin/request-patient/info/{id}', [AdminController::class,'inPatientRequestInfo'])->name('admin.inpatient.request.info');//in-patient request info
Route::get('/getRoom', [AdminController::class,'getRoom']);
Route::get('/searchInpatient' ,[AdminController::class,'searchInpatient']);//search inpatient
Route::get('/searchOutpatient' ,[AdminController::class,'searchOutpatient']);//search outpatient
Route::get('/searchDoctor' ,[AdminController::class,'searchDoctor']);//search doctor
Route::get('/searchDepartments' ,[AdminController::class,'searchDepartments']);//search department
Route::get('/searchClinic' ,[AdminController::class,'searchClinic']);//search clinic
Route::get('/searchRoom' ,[AdminController::class,'searchRoom']);//search roon
Route::get('/admin/appointment/', [AdminController::class,'showAppAdmin'])->name('admin.show.appointment.list');// show appointments information
Route::get('/admin/appointment/show/{id}', [AdminController::class,'appInfoShowAdmin'])->name('admin.show.appointment.info');// show DOCTOR information
Route::get('/searchForAppAdmin' ,[AdminController::class,'searchForAppAdmin']);//search roon

Route::get('/admin/hospital/departments',[DepartmentController::class,'departmentsIndex'])->name('admin.hospital.departments');//show departments information
Route::post('/admin/hospital/new/departments',[DepartmentController::class,'addNewDepartment'])->name('admin.new.department');//add new department
Route::get('/admin/hospital/edit/department/{id}',[DepartmentController::class,'editDepartment'])->name('admin.edit.department');//show edit department panel
Route::put('/admin/hospital/update/department/{id}',[DepartmentController::class,'updateDepartment'])->name('admin.update.department');//update department
Route::delete('/admin/hospital/delete/department/{id}',[DepartmentController::class,'deleteDepartment'])->name('admin.delete.department');//delete department



Route::get('/admin/hospital/clinics',[ClinicController::class,'clinicsIndex'])->name('admin.hospital.clinics');//show clinics information
Route::post('/admin/hospital/clinics',[ClinicController::class,'addNewClinic'])->name('admin.new.clinic');//add clinic
Route::get('/admin/hospital/edit/clinic/{id}',[ClinicController::class,'editClinic'])->name('admin.edit.clinic');//show edit clinic panel
Route::put('/admin/hospital/update/clinic/{id}',[ClinicController::class,'updateClinic'])->name('admin.update.clinic');//update clinic
Route::delete('/admin/hospital/delete/clinic/{id}',[ClinicController::class,'deleteClinic'])->name('admin.delete.clinic');//delete clinic

Route::get('/admin/hospital/rooms',[RoomController::class,'roomsIndex'])->name('admin.hospital.rooms');//show rooms information
Route::post('/admin/hospital/rooms',[RoomController::class,'addNewRoom'])->name('admin.new.room');//add room
Route::delete('/admin/hospital/delete/room/{id}',[RoomController::class,'deleteRoom'])->name('admin.delete.room');//delete room
Route::get('/admin/hospital/edit/room/{id}',[RoomController::class,'editRoom'])->name('admin.edit.room');//show edit room panel
Route::put('/admin/hospital/update/room/{id}',[RoomController::class,'updateRoom'])->name('admin.update.room');//update room

//Patient routes
Route::get('/patient/profile', [PatientController::class,'patientRedirect'])->name('patient.profile');//redirect patient
Route::put('/patient/profile/update',[PatientController::class,'update'])->name('profile.update');//update profile
Route::put('/profile/changePassword',[App\Http\Controllers\PatientController::class, 'changePassword'])->name('profile.changePassword');
Route::get('/patient/appointment', [PatientController::class,'appointmentPage'])->name('patient.appointment');//view appointment page
Route::post('/patient/appointment/cancle/{id}', [PatientController::class,'cancleApp'])->name('softdelete.appointment');//cancle appointment
Route::get('/getClinicsApp', [PatientController::class,'getClinicsApp']);//get department name of clinic
Route::get('/getDoctorApp', [PatientController::class,'getDoctorApp']);//get doctor name of clinic
Route::get('/getAvailableTime', [PatientController::class,'getAvailableTime']);//get available time
Route::get('/searchDepartment', [PatientController::class,'searchDepartment']);//search department
Route::post('/patient/appointment/booking', [PatientController::class,'bookAppointment'])->name('patient.appointment.book');//get available time
Route::get('/patient/appointment/history', [PatientController::class,'historyAppointment'])->name('patient.appointment.history');//view history of appointment
Route::post('/patient/reset-password',[PatientController::class,'patientResetPassword'])->name('patient.reset.password');

//Doctor routes
Route::get('/doctor/profile', [DoctorController::class,'doctorRedirect'])->name('doctor.profile');//redirect doctor
Route::put('/doctor/profile/update',[DoctorController::class, 'updateProfile'])->name('doctor.profile.update');//doctor update profile
Route::get('/doctor/daily/appointment', [DoctorController::class,'doctorApp'])->name('doctor.appointment');//view doctor daily appointment page
Route::get('/doctor/all/appointment', [DoctorController::class,'allDoctorApp'])->name('doctor.appointment.all');//view doctor all appointment page
Route::get('/doctor/appointment/info/{id}', [DoctorController::class,'showApp'])->name('doctor.appointment.show');//view doctor appointment page
Route::get('/attendApp', [DoctorController::class,'attendApp']);//attend appointment
Route::get('/doctor/in-patient', [DoctorController::class,'inpatientPage'])->name('doctor.inpatient');//view doctor inpatient  page
Route::get('/doctor/out-patient', [DoctorController::class,'outpatientPage'])->name('doctor.outpatient');//view doctor outpatient  page
Route::post('/doctor/in-patient', [DoctorController::class,'newInpatient'])->name('doctor.new.inpatient');//view doctor inpatient  page
Route::post('/doctor/in-patient/delete-request/{id}', [DoctorController::class,'deleteInpatientRequest'])->name('doctor.delete.inpatient.request');//view delete inpatient  request
Route::get('/doctor/in-patient/patient/info/{id}', [DoctorController::class,'inPatientInfoShow'])->name('doctor.inpatient.show.patient');//view inpatient patient info
Route::get('/doctor/out-patient/patient/info/{id}', [DoctorController::class,'outPatientInfoShow'])->name('doctor.outpatient.show.patient');//view outpatient patient info
Route::post('/doctor/in-patient/make/out/{id}', [DoctorController::class,'takeOutPatient'])->name('doctor.take.out.inpatient');//take out patient
Route::get('/searchAppsDoctor', [DoctorController::class,'searchAppsDoctor']);//search for patient in all appointment
Route::get('/filterMinAppsDoctor', [DoctorController::class,'filterMinAppsDoctor']);//filter min date of apps
Route::get('/filterMaxAppsDoctor', [DoctorController::class,'filterMaxAppsDoctor']);//filter max date of apps
Route::get('/searchInpatientDoctor', [DoctorController::class,'searchInpatientDoctor']);//search for patient inpatient doctor
Route::get('/searchOutpatientDoctor', [DoctorController::class,'searchOutpatientDoctor']);//search for patient outpatient doctor
Route::get('/inpatientDoctorFilter', [DoctorController::class,'inpatientDoctorFilter']);//filter inpatient
Route::post('/doctor/reset-password',[DoctorController::class,'doctorResetPassword'])->name('doctor.reset.password');
