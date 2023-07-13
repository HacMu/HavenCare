@extends('Admin.adminMaster')
<!--Set title of page as Edit - patient info-->
@section('title', 'Show - In-Patient Request')
<!--Set header of page as Patient Management panel-->
@section('pageHeader', 'In-Patient Request Information')

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
                        <span class="ml-2">Show In-Patient request information</span>
                        <span class="pull-right">ID : {{ $patient->id }}</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.inpatient.confirm.request', $patient->id) }}" method="post">
                            @csrf
                            <div class="row g-2">
                                <h5 class="h5"
                                    style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">
                                    In-Patient Information</h5>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="yatis_durumu"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#" value="{{ $patient->yatis_durumu }}"
                                            required>
                                        <label for="floatingInput">In-Status</label>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="yatis_nedeni"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#" value="{{ $patient->yatis_nedeni }}"
                                            required>
                                        <label for="floatingInput">In-Reason</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <select class="form-select bg-light border-0 shadow-sm  rounded" id="bolum_id"
                                            name="bolum_id" onchange="getRoom()" aria-label="Floating label select example"
                                            required>
                                            <option value="none" hidden disabled  selected>Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->bolum_adi }}</option>
                                            @endforeach
                                        </select>
                                        <label for="bolum_id ">Department</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <select class="form-select bg-light border-0 shadow-sm required rounded" id="oda_id"
                                            name="oda_id" aria-label="Floating label select example" required>
                                            <option value="" hidden disabled  selected>Select room</option>
                                        </select>
                                        <label for="oda_id">Room</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="yatis_tarihi"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#" value="{{ $patient->yatis_tarihi }}"
                                            required>
                                        <label for="floatingInput">In-Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <h5 class="h5"
                                    style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">
                                    Doctor Information</h5>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="id"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#" value="{{ $patient->inDoctor->id }}"
                                            required>
                                        <label for="floatingInput">Havencare ID</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="doktor_tc"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#"
                                            value="{{ $patient->inDoctor->doctor->doktor_tc }}" required>
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
                                            value="{{ $patient->inDoctor->doctor->doktor_adi }}" required>
                                        <label for="floatingInput">Doctor name</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="doktor_uzmanlik"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#"
                                            value="{{ $patient->inDoctor->doctor->doktor_uzmanlik }}" required>
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
                                            value="{{ $patient->inDoctor->doctor->clinic->department->bolum_adi }}"
                                            required>
                                        <label for="floatingInput">Department</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="clinic_id"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#"
                                            value="{{ $patient->inDoctor->doctor->clinic->klinik_adi }} NO : {{ $patient->inDoctor->doctor->clinic->klinik_numarasi }} "
                                            required>
                                        <label for="floatingInput">Clinic</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <h5 class="h5"
                                    style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">
                                    Patient Information</h5>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="id"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#"
                                            value="{{ $patient->inPatient->patient->user_id }}" required>
                                        <label for="floatingInput">Havencare ID</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="hasta_tc" readonly
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $patient->inPatient->patient->hasta_tc }}"
                                            required>
                                        <label for="floatingInput">Patient ID</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" readonly
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $patient->inPatient->patient->hasta_adi }}"
                                            required>
                                        <label for="floatingInput">Full name</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="hasta_dt" readonly
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $patient->inPatient->patient->hasta_dt }}"
                                            required>
                                        <label for="floatingInput">Birth date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="hasta_cin" readonly
                                                class="form-control bg-light border-0 shadow-sm  rounded"
                                                id="floatingInput" placeholder="#"
                                                value="{{ $patient->inPatient->patient->hasta_cin }}" required>
                                            <label for="floatingInput">Gender</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="hasta_kan_grubu" readonly
                                                class="form-control bg-light border-0 shadow-sm  rounded"
                                                id="floatingInput" placeholder="#"
                                                value="{{ $patient->inPatient->patient->hasta_kan_grubu }}" required>
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
                                                id="floatingInputGroup1"
                                                value="{{ $patient->inPatient->patient->hasta_kilo }}">
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
                                                id="floatingInputGroup1"
                                                value="{{ $patient->inPatient->patient->hasta_boyu }}">
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
                                            name="email" placeholder="#" value="{{ $patient->inPatient->email }}"
                                            required>
                                        <label for="floatingInput">Email</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input readonly type="text"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            name="hasta_tel" placeholder="#"
                                            value="{{ $patient->inPatient->patient->hasta_tel }}" required>
                                        <label for="floatingInput">Phone number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input readonly type="text" name="hasta_adres"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputValue"
                                            value="{{ $patient->inPatient->patient->hasta_adres }}">
                                        <label for="floatingInputValue">Address</label>
                                    </div>
                                </div>
                            </div>
                            <nav aria-label="Page navigation example mt-4 ">
                                <ul class="pagination justify-content-between">
                                    <li class="page-item">
                                        <a href={{ route('admin.inpatient.request') }}
                                            class="page-link btn-light pull-left border-0 rounded shadow-sm">
                                            Return back</a>
                                    </li>
                                    <button type="submit"
                                        class="page-link btn-light pull-left border-0 rounded shadow-sm"
                                        style="background-color: #00a099;color:white">
                                        <b>Confirm</b>
                                    </button>
                                </ul>
                            </nav>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function getRoom() {
            var depID = document.getElementById("bolum_id").value;
            $('#oda_id').empty();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('getRoom') }}',
                data: {
                    'depID': depID,
                },
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        $('#oda_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].oda_adi + ' NO : ' + data[i].oda_numarasi
                        }));
                    }
                }
            });
        }
    </script>
@endsection
