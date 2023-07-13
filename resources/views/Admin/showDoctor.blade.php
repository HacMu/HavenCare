@extends('Admin.adminMaster')
<!--Set title of page as Show - doctor info-->
@section('title', 'Show - doctor')
<!--Set header of page as Doctor Management panel-->
@section('pageHeader', 'Doctor Management')

@section('content')
    @php
        $genders = ['Male', 'Female'];
    @endphp
    <div class="align-items-center" style="margin-top:64px">
        <div class="row">
            <div class="col">
                <!--Doctor information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-eye"></i>
                        <span class="ml-2">Show Dr.{{ $doctorData->doctor->doktor_adi }} information</span>
                        <span class="pull-right">Havencare ID : {{ $doctorData->id }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 d-flex mb-2">
                            <div class="profile-pic-wrapper">
                                <div class="pic-holder shadow" style="width:256px;height:256px">
                                    <!-- uploaded pic shown here -->
                                    @if ($doctorData->doctor->doktor_img != null)
                                        <img id="profilePic" class="pic"
                                            src="{{ asset('/doctorImages/' . $doctorData->doctor->doktor_img) }}">
                                    @elseif ($doctorData->doctor->doktor_img == null)
                                        @if ($doctorData->doctor->doktor_cin == 'Male')
                                            <img id="profilePic" class="pic"
                                                src="{{ asset('/doctorImages/doctormale.jpg') }}">
                                        @elseif ($doctorData->doctor->doktor_cin == 'Female')
                                            <img id="profilePic" class="pic"
                                                src="{{ asset('/doctorImages/doctordfemale.jpg') }}">
                                        @endif
                                    @endif
                                </div>
                                <div class="row mt-3">
                                    <div class="col d-flex justify-content-center">
                                        <h5 class="h5 fs-4" id="profilename" style="font-weight: bold">
                                            {{ $doctorData->name }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class="fs-8">ID : {{ $doctorData->doctor->doktor_tc }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="id"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        readonly name="id" placeholder="#" value="{{ $doctorData->doctor->user_id }}"
                                        required>
                                    <label for="floatingInput">Havencare ID</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="doktor_tc" readonly
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $doctorData->doctor->doktor_tc }}" required>
                                    <label for="floatingInput">Doctor ID</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" readonly
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $doctorData->doctor->doktor_adi }}" required>
                                    <label for="floatingInput">Full name</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="date" name="doktor_dt" readonly
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $doctorData->doctor->doktor_dt }}" required>
                                    <label for="floatingInput">Birth date</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="doktor_cin" readonly
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $doctorData->doctor->doktor_cin }}" required>
                                        <label for="floatingInput">Gender</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="doktor_uzmanlik" readonly
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $doctorData->doctor->doktor_uzmanlik }}" required>
                                        <label for="floatingInput">Speciality</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input readonly type="text" name="bolum_id"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputGroup1"
                                            value="{{ $doctorData->doctor->clinic->department->id }}">
                                        <label for="floatingInputGroup1">Department ID</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input readonly type="text" name="bolum_adi"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputGroup1"
                                            value="{{ $doctorData->doctor->clinic->department->bolum_adi }}">
                                        <label for="floatingInputGroup1">Department name</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input readonly type="text" name="klinik_id"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputGroup1" value="{{ $doctorData->doctor->klinik_id }}">
                                        <label for="floatingInputGroup1">Clinic ID</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input readonly type="text" name="klinik_adi"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputGroup1"
                                            value="{{ $doctorData->doctor->clinic->klinik_adi }} NO : {{ $doctorData->doctor->clinic->klinik_numarasi }}">
                                        <label for="floatingInputGroup1">Clinic name</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="email"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        name="email" placeholder="#" value="{{ $doctorData->email }}" required>
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="text"
                                        class="form-control bg-light border-0 shadow-sm  rounded" readonly
                                        id="floatingInput" name="doctor_tel" placeholder="#"
                                        value="{{ $doctorData->doctor->doktor_tel }}" required>
                                    <label for="floatingInput">Phone number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="text" name="doktor_adres"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInputValue"
                                        value="{{ $doctorData->doctor->doktor_adres }}">
                                    <label for="floatingInputValue">Address</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="email"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        name="created_at" placeholder="#" value="{{ $doctorData->doctor->created_at }}"
                                        required>
                                    <label for="floatingInput">Join date</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input readonly type="text"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        name="updated_at" placeholder="#" value="{{ $doctorData->doctor->updated_at }}"
                                        required>
                                    <label for="floatingInput">Last update date</label>
                                </div>
                            </div>
                        </div>

                        <nav aria-label="Page navigation example mt-4 ">
                            <ul class="pagination justify-content-between">
                                <li class="page-item">
                                    <a href="{{ route('admin.edit.doctor', $doctorData->id) }}"" type="reset"
                                        class="btn btn-light border-0">Go to edit page</a>
                                </li>
                                <li class="page-item">
                                    <a href={{ route('admin.users.doctors') }}
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
