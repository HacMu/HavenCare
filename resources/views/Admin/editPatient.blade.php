@extends('Admin.adminMaster')
<!--Set title of page as Edit - patient-->
@section('title', 'Edit - patient')
<!--Set header of page as Patient Management-->
@section('pageHeader', 'Patient Management')

@section('content')
    @php
        $genders = ['Male', 'Female'];
        $bloodTypes = ['O positive: 35%', 'O negative: 13%', 'A positive: 30%', 'A negative: 8%', 'B positive: 8%', 'B negative: 2%', 'AB positive: 2%', 'AB negative: 1%'];
    @endphp
 <?php
    if (count($errors)>0){
         foreach ($errors->all() as $item){
             Alert::toast($item,'error');
         }
    }
 ?>

    <div class="align-items-center" style="margin-top:64px">

        <div class="row">
            <div class="col">
                <!--Patient information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span class="ml-2">Edit {{ $patientData->patient->hasta_adi }} information</span>
                        <span class="pull-right">Havencare ID : {{ $patientData->id }}</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="mb-0" action="{{ route('admin.update.patient',$patientData->id) }}" style="margin-bottom: 32px">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="id"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        readonly name="id" placeholder="#"
                                        value="{{ $patientData->patient->user_id }}" required>
                                    <label for="floatingInput">Havencare ID</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="hasta_tc"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $patientData->patient->hasta_tc }}" required>
                                    <label for="floatingInput">Patient ID</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $patientData->patient->hasta_adi }}" required>
                                    <label for="floatingInput">Full name</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="date" name="hasta_dt"
                                        class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                        placeholder="#" value="{{ $patientData->patient->hasta_dt }}" required>
                                    <label for="floatingInput">Birth date</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <select class="form-select bg-light border-0 shadow-sm  rounded" required name="hasta_cin" id="floatingSelect"
                                    aria-label="Floating label select example">
                                    @foreach ($genders as $item)
                                        <option value="{{ $item }}"
                                            {{ $patientData->patient->hasta_cin == $item ? 'selected' : '' }}>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Gender</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <select class="form-select bg-light border-0 shadow-sm  rounded" name="hasta_kan_grubu" id="floatingSelect"
                                        aria-label="Floating label select example">
                                        <@foreach ($bloodTypes as $item)
                                            <option value="{{ $item }}"
                                                {{ $patientData->patient->hasta_kan_grubu == $item ? 'selected' : '' }}>
                                                {{ $item }}</option>
                                            @endforeach
                                    </select>
                                    <label for="floatingSelect">Blood type</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input type="text" name="hasta_kilo" class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputGroup1" value="{{ $patientData->patient->hasta_kilo }}">
                                        <label for="floatingInputGroup1">Weight</label>
                                    </div>
                                    <span class="input-group-text  bg-light border-0 shadow-sm  rounded">Kg</span>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input type="text" name="hasta_boyu" class="form-control bg-light border-0 shadow-sm  rounded"
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
                                    <input type="email" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="email" placeholder="#"  value="{{ $patientData->email }}" required>
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="hasta_tel" placeholder="#" value="{{$patientData->patient->hasta_tel}}" required>
                                    <label for="floatingInput">Phone number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" name="hasta_adres"  class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInputValue" value="{{ $patientData->patient->hasta_adres }}">
                                    <label for="floatingInputValue">Address</label>
                                </div>
                            </div>
                        </div>


                        <nav aria-label="Page navigation example mt-4 ">
                            <ul class="pagination justify-content-between">
                                <li class="page-item">
                                    <a href="{{ route('admin.users.patients') }}"" type="reset"
                                        class="btn btn-light border-0">Cancle</a>
                                </li>
                                <li class="page-item">
                                    <button type="submit"  class="page-link btn-light border-0 rounded shadow-sm"
                                        style="background-color:#00a099;color: white"><i
                                            class="fa-solid fa-check mr-2"></i><b>Save</b></button>
                                </li>
                            </ul>
                        </nav>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
