@extends('Admin.adminMaster')

@section('title', 'Show - Appointment')

@section('pageHeader', 'Appointment Management')

@section('content')


<div class="align-items-center" style="margin-top:64px">
    <div class="row">
        <div class="col">
            <!--Patient information-->
            <div class="card mb-4  shadow">
                <div class="card-header border-0"
                    style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                    <i class="fa-solid fa-eye"></i>
                    <span class="ml-2">Show Appointment information</span>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <h5 class="h5"
                style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">Appointment Information</h5>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="yatis_durumu"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{ $appointment->randevu_durumu}}" required>
                                <label for="floatingInput">Appointment status</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="oda_id"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{ $appointment->appdoctor->doctor->clinic->department->bolum_adi}} : {{$appointment->appdoctor->doctor->clinic->klinik_numarasi}}" required>
                                <label for="floatingInput">Department</label>
                            </div>
                        </div>
                    </div>
                     <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="yatis_nedeni"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{$appointment->randevu_tarihi}}" required>
                                <label for="floatingInput">Appointment date</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="yatis_tarihi"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{ $appointment->randevu_saati}}" required>
                                <label for="floatingInput">Appointment time</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <h5 class="h5"
                style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">Doctor Information</h5>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="id"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{$appointment->appdoctor->id}}" required>
                                <label for="floatingInput">Havencare ID</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="doktor_tc"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{$appointment->appdoctor->doctor->doktor_tc}}" required>
                                <label for="floatingInput">Doctor ID</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="doktor_adi"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{ $appointment->appdoctor->doctor->doktor_adi}}" required>
                                <label for="floatingInput">Doctor name</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="oda_id"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{$appointment->appdoctor->doctor->doktor_uzmanlik}}" required>
                                <label for="floatingInput">Specialist</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="bolum_adi"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{ $appointment->appdoctor->doctor->clinic->department->bolum_adi}}" required>
                                <label for="floatingInput">Department</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="oda_id"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{$appointment->appdoctor->doctor->clinic->klinik_adi}} NO : {{$appointment->appdoctor->doctor->clinic->klinik_numarasi}} " required>
                                <label for="floatingInput">Clinic</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <h5 class="h5"
                style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">Patient Information</h5>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="id"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    readonly name="id" placeholder="#"
                                    value="{{$appointment->apppatient->patient->user_id}}" required>
                                <label for="floatingInput">Havencare ID</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="hasta_tc"
                                readonly class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    placeholder="#" value="{{ $appointment->apppatient->patient->hasta_tc }}" required>
                                <label for="floatingInput">Patient ID</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="text" name="name"
                                readonly class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    placeholder="#" value="{{$appointment->apppatient->patient->hasta_adi  }}" required>
                                <label for="floatingInput">Full name</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="date" name="hasta_dt"
                                readonly class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                    placeholder="#" value="{{$appointment->apppatient->patient->hasta_dt }}" required>
                                <label for="floatingInput">Birth date</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <div class="form-floating mb-3">
                                    <input type="text" name="hasta_cin"
                                    readonly class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $appointment->apppatient->patient->hasta_cin }}" required>
                                    <label for="floatingInput">Gender</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <div class="form-floating mb-3">
                                    <input type="text" name="hasta_kan_grubu"
                                    readonly class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $appointment->apppatient->patient->hasta_kan_grubu }}" required>
                                    <label for="floatingInput">Blood type</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input  readonly type="text" name="hasta_kilo" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInputGroup1" value="{{$appointment->apppatient->patient->hasta_kilo }}">
                                    <label for="floatingInputGroup1">Weight</label>
                                </div>
                                <span class="input-group-text  bg-light border-0 shadow-sm  rounded">Kg</span>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input  readonly type="text" name="hasta_boyu" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInputGroup1" value="{{ $appointment->apppatient->patient->hasta_boyu }}">
                                    <label for="floatingInputGroup1">Height</label>
                                </div>
                                <span class="input-group-text  bg-light border-0 shadow-sm  rounded">Cm</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input readonly type="email" class="form-control bg-light border-0 shadow-sm  rounded"
                                    id="floatingInput" name="email" placeholder="#"  value="{{ $appointment->apppatient->email }}" required>
                                <label for="floatingInput">Email</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input readonly type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                    id="floatingInput" name="hasta_tel" placeholder="#" value="{{$appointment->apppatient->patient->hasta_tel}}" required>
                                <label for="floatingInput">Phone number</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input readonly type="text" name="hasta_adres"  class="form-control bg-light border-0 shadow-sm  rounded"
                                    id="floatingInputValue" value="{{ $appointment->apppatient->patient->hasta_adres }}">
                                <label for="floatingInputValue">Address</label>
                            </div>
                        </div>
                    </div>
                    <nav aria-label="Page navigation example mt-4 ">
                        <ul class="pagination justify-content-end">
                            <li class="page-item">
                                <a href={{url()->previous()}}  class="page-link btn-light pull-right border-0 rounded shadow-sm"
                                    style="background-color:#00a099;color: white">
                                       <b>Return back</b></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
