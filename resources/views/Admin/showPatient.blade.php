@extends('Admin.adminMaster')
<!--Set title of page as Edit - patient info-->
@section('title', 'Show - patient')
<!--Set header of page as Patient Management panel-->
@section('pageHeader', 'Patient Management')

@section('content')
    @php
        $genders = ['Male', 'Female'];
        $bloodTypes = ['O positive: 35%', 'O negative: 13%', 'A positive: 30%', 'A negative: 8%', 'B positive: 8%', 'B negative: 2%', 'AB positive: 2%', 'AB negative: 1%'];
    @endphp
    <div class="align-items-center" style="margin-top:64px">
        @foreach ($errors->all() as $item)
            <div class="alert alert-danger border-0 shadow" role="alert">
                {{ $item }}
            </div>
        @endforeach

        <div class="row">
            <div class="col">
                <!--Patient information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-eye"></i>
                        <span class="ml-2">Show {{ $patientData->patient->hasta_adi }} information</span>
                        <span class="pull-right">Havencare ID : {{ $patientData->id }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 d-flex mb-2">
                            <div class="profile-pic-wrapper">
                                <div class="pic-holder shadow" style="width:256px;height:256px">
                                    <!-- uploaded pic shown here -->
                                    @if ($patientData->patient->hasta_image == null)
                                        <img id="profilePic" class="pic" src="{{ asset('patientImage/blank.png') }}">
                                    @else
                                        <img id="profilePic" class="pic"
                                            src="{{ asset('/patientImage/' . $patientData->patient->hasta_image) }}">
                                    @endif
                                </div>
                                <div class="row mt-3">
                                    <div class="col d-flex justify-content-center">
                                        <h5 class="h5 fs-4" id="profilename" style="font-weight: bold">{{ $patientData->name }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class="fs-8">ID : {{ $patientData->patient->hasta_tc }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="id"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        readonly name="id" placeholder="#" value="{{ $patientData->patient->user_id }}"
                                        required>
                                    <label for="floatingInput">Havencare ID</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="hasta_tc" readonly
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $patientData->patient->hasta_tc }}" required>
                                    <label for="floatingInput">Patient ID</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" readonly
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $patientData->patient->hasta_adi }}" required>
                                    <label for="floatingInput">Full name</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="date" name="hasta_dt" readonly
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $patientData->patient->hasta_dt }}" required>
                                    <label for="floatingInput">Birth date</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="hasta_cin" readonly
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $patientData->patient->hasta_cin }}" required>
                                        <label for="floatingInput">Gender</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="hasta_kan_grubu" readonly
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $patientData->patient->hasta_kan_grubu }}" required>
                                        <label for="floatingInput">Blood type</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input readonly type="text" name="hasta_kilo"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputGroup1" value="{{ $patientData->patient->hasta_kilo }}">
                                        <label for="floatingInputGroup1">Weight</label>
                                    </div>
                                    <span class="input-group-text  bg-light border-0 shadow-sm  rounded">Kg</span>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input readonly type="text" name="hasta_boyu"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputGroup1" value="{{ $patientData->patient->hasta_boyu }}">
                                        <label for="floatingInputGroup1">Height</label>
                                    </div>
                                    <span class="input-group-text  bg-light border-0 shadow-sm  rounded">Cm</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="email"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        name="email" placeholder="#" value="{{ $patientData->email }}" required>
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="text"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        name="hasta_tel" placeholder="#" value="{{ $patientData->patient->hasta_tel }}"
                                        required>
                                    <label for="floatingInput">Phone number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="text" name="hasta_adres"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInputValue"
                                        value="{{ $patientData->patient->hasta_adres }}">
                                    <label for="floatingInputValue">Address</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="email"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        name="created_at" placeholder="#"
                                        value="{{ $patientData->patient->created_at }}" required>
                                    <label for="floatingInput">Join date</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="text"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        name="updated_at" placeholder="#"
                                        value="{{ $patientData->patient->updated_at }}" required>
                                    <label for="floatingInput">Last update date</label>
                                </div>
                            </div>
                        </div>

                        <nav aria-label="Page navigation example mt-4 ">
                            <ul class="pagination justify-content-between">
                                <li class="page-item">
                                    <a href="{{ route('admin.edit.patient', $patientData->id) }}"" type="reset"
                                        class="btn btn-light border-0">Go to edit page</a>
                                </li>
                                <li class="page-item">
                                    <a href={{ route('admin.users.patients') }}
                                        class="page-link btn-light border-0 rounded shadow-sm"
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
