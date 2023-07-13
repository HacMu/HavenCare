@extends('Admin.adminMaster')
<!--Set title of page as Edit - doctor-->
@section('title', 'Edit - doctor')
<!--Set header of page as Doctor Management-->
@section('pageHeader', 'Doctor Management')

@section('content')
    @php
        $genders = ['Male', 'Female'];
    @endphp
    <?php
    if (count($errors) > 0) {
        foreach ($errors->all() as $item) {
            Alert::toast($item, 'error');
        }
    }
    ?>

    <div class="align-items-center" style="margin-top:64px">

        <div class="row">
            <div class="col">
                <!--Doctor information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span class="ml-2">Edit Dr.{{ $doctorData->doctor->doktor_adi }} information</span>
                        <span class="pull-right">Havencare ID : {{ $doctorData->id }}</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="mb-0" action="{{ route('admin.update.doctor', $doctorData->id) }}"
                            style="margin-bottom: 32px">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="id"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            readonly name="id" placeholder="#"
                                            value="{{ $doctorData->doctor->user_id }}" required>
                                        <label for="floatingInput">Havencare ID</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="doktor_tc"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $doctorData->doctor->doktor_tc }}" required>
                                        <label for="floatingInput">Doctor ID</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $doctorData->doctor->doktor_adi }}" required>
                                        <label for="floatingInput">Full name</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="doktor_dt"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                            placeholder="#" value="{{ $doctorData->doctor->doktor_dt }}" required>
                                        <label for="floatingInput">Birth date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <select class="form-select bg-light border-0 shadow-sm  rounded" required name="doktor_cin" id="floatingSelect"
                                        aria-label="Floating label select example">
                                        @foreach ($genders as $item)
                                            <option value="{{ $item }}"
                                                {{ $doctorData->doctor->doktor_cin == $item ? 'selected' : '' }}>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Gender</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="doktor_uzmanlik"
                                                class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                                placeholder="#" value="{{ $doctorData->doctor->doktor_uzmanlik }}"
                                                required>
                                            <label for="floatingInput">Speciality</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <select class="form-select bg-light border-0 shadow-sm  rounded" id="bolum_id"
                                            name="bolum_id" aria-label="Floating label select example"
                                            onchange="getClinics()" required>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $doctorData->doctor->clinic->department->bolum_adi == $department->bolum_adi ? 'selected' : '' }}>
                                                    {{ $department->bolum_adi }}</option>
                                            @endforeach
                                        </select>
                                        <label for="bolum_id">Department</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <select class="form-select bg-light border-0 shadow-sm  rounded" id="klinik_id"
                                            name="klinik_id" aria-label="Floating label select example" required>
                                            @foreach ($clinics as $clinic)
                                                <option value="{{ $clinic->id }}"
                                                    {{ $doctorData->doctor->clinic->id == $clinic->id ? 'selected' : '' }}>
                                                    {{ $clinic->klinik_adi }} NO : {{ $clinic->klinik_numarasi }}</option>
                                            @endforeach
                                        </select>
                                        <label for="klinik_id">Clinic</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInput" name="email" placeholder="#"
                                            value="{{ $doctorData->email }}" required>
                                        <label for="floatingInput">Email</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInput" name="doktor_tel" placeholder="#"
                                            value="{{ $doctorData->doctor->doktor_tel }}" required>
                                        <label for="floatingInput">Phone number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="doktor_adres"
                                            class="form-control bg-light border-0 shadow-sm  rounded"
                                            id="floatingInputValue" value="{{ $doctorData->doctor->doktor_adres }}">
                                        <label for="floatingInputValue">Address</label>
                                    </div>
                                </div>
                            </div>


                            <nav aria-label="Page navigation example mt-4 ">
                                <ul class="pagination justify-content-between">
                                    <li class="page-item">
                                        <a href="{{ route('admin.users.doctors') }}"" type="reset"
                                            class="btn btn-light border-0">Cancle</a>
                                    </li>
                                    <li class="page-item">
                                        <button type="submit" class="page-link btn-light border-0 rounded shadow-sm"
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


    <script type="text/javascript">
        function getClinics() {
            var value = document.getElementById("bolum_id").value;
            $('#klinik_id').empty();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('getDepOfClinic') }}',
                data: {
                    'id': value,
                },
                success: function(data) {

                    for (var i = 0; i < data.length; i++) {
                        $('#klinik_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].klinik_adi + ' NO : ' + data[i].klinik_numarasi
                        }));
                    }

                }
            });
        }
    </script>
@endsection
