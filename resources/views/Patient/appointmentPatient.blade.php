@extends('Patient.patientMaster')

@section('title', 'Book Appointment')

@section('pageHeader', 'Appointment')

@section('content')
    <style>
        #article {
            background: linear-gradient(to right,
                    rgba(0, 160, 153, 1) 0%,
                    rgba(65, 105, 225, 1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            font-weight: bolder;
        }

        #buttons {
            background: rgb(0, 160, 153);
            background: linear-gradient(90deg, rgba(0, 160, 153, 1) 0%, rgba(65, 105, 225, 1) 100%);
            color: white;
            border: 0px;
        }

        #redbuttons {
            background-color: #E63946;
            color: white;
            border: 0px;
        }
    </style>
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
                <div class="card mb-4 border-0 bg-light">
                    <div class="d-flex align-items-center bg-light rounded  card-header border-0 "
                        style="height:48px;>
                        <span class="ml-2">
                        <h1 class="fs-5 mt-3" id="article">Book an appointment</h1>
                        </span>
                    </div>
                    <div class="card-body rounded">

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <nav class="navbar navbar-expand border-0 bg-white rounded shadow-sm">
                                        <div class="container-fluid">
                                            <i class="fa-solid mr-2 fa-magnifying-glass"></i>
                                            <input type="text" autocomplete="off" class="form-control border-0 rounded"
                                                id="search" name="search" placeholder="Search for department">
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('patient.appointment.book') }}" autocomplete="off" method="POST">
                            @csrf
                            <div class="mb-2 mt-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating" id='allData'>
                                            <select class="form-control  border-0 shadow-sm  rounded" id="bolum_id1"
                                                placeholder="#" required onchange="getClinics()" name="bolum_id"
                                                aria-label="Floating label select example">
                                                <option value="none" selected disabled hidden>Select department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->bolum_adi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="bolum_id">Departments</label>
                                        </div>
                                        <div class="form-floating" id='searchedData' style="display: none;">
                                            <select class="form-control  border-0 shadow-sm  rounded data " id="bolum_id2"
                                                placeholder="#" required onchange="getClinicsSearch()" name="bolum_id"
                                                aria-label="Floating label select example">
                                                <option value="none" selected disabled hidden>Select department</option>

                                            </select>
                                            <label for="bolum_id">Departments</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-control  border-0 shadow-sm  rounded" id="klinik_id"
                                                placeholder="#" required onchange="getDoctor()" name="klinik_id"
                                                aria-label="Floating label select example">

                                            </select>
                                            <label for="klinik_id">Clinics</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col" hidden>
                                    <div class="form-floating ">
                                        <select class="form-control  border-0 shadow-sm  rounded" id="doktor_id"
                                            placeholder="#" required readonly name="doktor_id"
                                            aria-label="Floating label select example">

                                        </select>
                                        <label for="doktor_id">Doctor</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control border-0 shadow-sm  rounded"
                                            id="randevu_tarihi" min="{{ now()->addDays(1)->format('Y-m-d') }}"
                                            max="{{ now()->addDays(30)->format('Y-m-d') }}" onchange="getAvailableTime()"
                                            name="randevu_tarihi" placeholder="#" required>
                                        <label for="randevu_tarihi">Appointment Date</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-control  border-0 shadow-sm  rounded" id="randevu_saati"
                                            placeholder="#" required readonly name="randevu_saati"
                                            aria-label="Floating label select example">

                                        </select>
                                        <label for="randevu_saati">Available times</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span id="errorMessage" style="color: #E63946"></span>
                                    <button type="submit" class="btn btn-primary pull-right border-0"
                                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">Confirm</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card bg-light mb-4 border-0 ">
                    <div class="d-flex align-items-center bg-light rounded justify-content-between  card-header border-0 "
                        style="height:48px;">
                        <span class="ml-2">
                            <h1 class="fs-5 mt-3 pull-left" id="article">My Appointments</h1>
                        </span>
                        <span class="ml-2r">
                            <a href="{{ route('patient.appointment.history') }}"
                                class="btn btn-light fs-8 mt-3 pull-right align-items-center border-0"><i
                                    class="fa-solid mr-2 fa-clock-rotate-left"></i>Appointment History</a>
                        </span>
                    </div>

                    <div class="card-body rounded">
                        <div class="row">
                            @foreach ($appointments as $appointment)
                                <div class="col mb-1 mt-1 ">
                                    <div class="card border-0 shadow rounded-75">
                                        <div class="card-body mt-2 ">
                                            <div class="d-flex align-items-center">
                                                <div class="pic-holder shadow-sm"
                                                    style="width: 80px;height:80px;border:4px solid #00a099">
                                                    @if ($appointment->appdoctor->doctor->doktor_img != null)
                                                        <img id="profilePic" class="pic"
                                                            src="{{ asset('/doctorImages/' . $appointment->appdoctor->doctor->doktor_img) }}">
                                                    @elseif ($appointment->appdoctor->doctor->doktor_img == null)
                                                        @if ($appointment->appdoctor->doctor->doktor_cin == 'Male')
                                                            <img id="profilePic" class="pic"
                                                                src="{{ asset('/doctorImages/doctormale.jpg') }}">
                                                        @elseif ($appointment->appdoctor->doctor->doktor_cin == 'Female')
                                                            <img id="profilePic" class="pic"
                                                                src="{{ asset('/doctorImages/doctordfemale.jpg') }}">
                                                        @endif
                                                    @endif
                                                </div>
                                                <span class="ml-2">
                                                    <h5 class="card-title mb-0"
                                                        style="font-size:12pt;font-weight:bold;color:#00a099">
                                                        Dr.{{ $appointment->appdoctor->doctor->doktor_adi }} </h5>
                                                    <p class="card-text mt-0">
                                                        {{ $appointment->appdoctor->doctor->doktor_uzmanlik }} specialist
                                                    </p>
                                                </span>
                                            </div>
                                        </div>

                                        <ul class="list-group border-0 mt-0  list-group-flush">
                                            <li class="list-group-item d-flex align-items-center border-0"><i
                                                    class="fa-solid fa-circle-h mr-2"
                                                    style="color:#00a099;font-size:13pt;"></i>{{ $appointment->appdoctor->doctor->clinic->klinik_adi }}
                                                | {{ $appointment->appdoctor->doctor->clinic->klinik_numarasi }}
                                            </li>
                                            <li class="list-group-item d-flex align-items-center  border-0"><i
                                                    class="fa-solid fa-clock mr-2"
                                                    style="color:#00a099"></i>{{ $appointment->randevu_tarihi }} |
                                                {{ $appointment->randevu_saati }}</li>
                                            <li class="list-group-item d-flex align-items-center border-0"></i><i
                                                    class="fa-solid fa-location-dot mr-3"
                                                    style="color:#00a099"></i>{{ $appointment->appdoctor->doctor->clinic->department->bolum_adres }}
                                            </li>
                                            <li class="list-group-item border-0">
                                                @if ($appointment->randevu_tarihi >= now()->format('Y-m-d'))
                                                    <span style="margin-top: 3px"
                                                        class="badge rounded-pill text-bg-primary">Active</span>
                                                    @php
                                                        $earlier = new DateTime(date('Y-m-d'));
                                                        $later = new DateTime($appointment->randevu_tarihi);
                                                    @endphp
                                                    <p style="margin-top:3px;color:#00a099" class="badge">
                                                        {{ $later->diff($earlier)->format('%a') }} day left</p>
                                                @elseif ($appointment->randevu_tarihi < now()->format('Y-m-d'))
                                                    <span style="margin-top: 3px"
                                                        class="badge rounded-pill text-bg-danger">Expired</span>
                                                @endif
                                            </li>
                                        </ul>

                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col">
                                                    <a href="#" class="card-link">
                                                        <form
                                                            action="{{ route('softdelete.appointment', $appointment->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit" style="width: 100%"
                                                                class="btn card-link" id="redbuttons">Cancle</button>
                                                        </form>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pt-2 justify-content-end">
                                <li class="page-item pull-right">
                                    {!! $appointments->links('vendor.pagination.custom') !!}
                                </li>
                            </ul>
                        </nav>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        function getClinics() {
            var value = document.getElementById("bolum_id1").value;
            document.getElementById("randevu_tarihi").value = " ";
            $('#klinik_id').empty();
            $('#doktor_id').empty();
            $('#randevu_saati').empty();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('getClinicsApp') }}',
                data: {
                    'id': value,
                },
                success: function(data) {
                    $('#klinik_id').append($('<option>', {
                        selected: true,
                        disabled: true,
                        hidden: true,
                        value: "none",
                        text: 'Select clinic'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#klinik_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].klinik_adi + ' NO : ' + data[i].klinik_numarasi
                        }));
                    }

                }
            });
        }

        function getClinicsSearch() {
            var value = document.getElementById("bolum_id2").value;
            document.getElementById("randevu_tarihi").value = " ";
            $('#klinik_id').empty();
            $('#doktor_id').empty();
            $('#randevu_saati').empty();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('getClinicsApp') }}',
                data: {
                    'id': value,
                },
                success: function(data) {
                    $('#klinik_id').append($('<option>', {
                        selected: true,
                        disabled: true,
                        hidden: true,
                        value: "none",
                        text: 'Select clinic'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#klinik_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].klinik_adi + ' NO : ' + data[i].klinik_numarasi
                        }));
                    }

                }
            });
        }

        function getDoctor() {
            var value = document.getElementById("klinik_id").value;
            document.getElementById("randevu_tarihi").value = " ";
            $('#doktor_id').empty();
            $('#randevu_saati').empty();

            $.ajax({
                type: 'get',
                url: '{{ URL::to('getDoctorApp') }}',
                data: {
                    'klinikID': value,
                },
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        $('#doktor_id').append($('<option>', {
                            value: data[i].user_id,
                            text: data[i].doktor_adi
                        }));
                    }

                }
            });

        }

        function getAvailableTime() {
            var value = document.getElementById("randevu_tarihi").value;
            var doctorID = document.getElementById("doktor_id").value;
            if (doctorID) {
                $('#randevu_saati').empty();
                $.ajax({
                    type: 'get',
                    url: '{{ URL::to('getAvailableTime') }}',
                    data: {
                        'date': value,
                        'id': doctorID,
                    },
                    success: function(data) {
                        time = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '13:30', '14:00', '14:30',
                            '15:00', '15:30'
                        ];
                        for (var i = 0; i < time.length; i++) {
                            for (var j = 0; j < data.length; j++) {
                                if (time[i] != data[j]) {
                                    $('#randevu_saati').append($('<option>', {
                                        value: time[i],
                                        text: time[i]
                                    }));
                                } else if (time[i] == data[j] ) {
                                    $('#randevu_saati').append($('<option>', {
                                        text: time[i],
                                        disabled: true,
                                        value: "none",
                                        style:"background-color:#E63946;color:white"
                                    }));
                                }
                            }
                        }
                        var usedNames = {};
                                    $("select[name='randevu_saati'] > option").each(function() {
                                        if (usedNames[this.text] && this.disabled == false) {
                                            $(this).remove();
                                        } else {
                                            usedNames[this.text] = this.value;
                                        }
                                    });
                    }
                });
                document.getElementById("errorMessage").innerHTML = ' ';
            } else if (!doctorID) {
                document.getElementById("errorMessage").innerHTML = 'There is no doctor in this clinic';
                document.getElementById("randevu_tarihi").value = " ";
            }
        }

        $('#search').on('keyup', function() {

            $value = $(this).val();
            $('#klinik_id').empty();
            $('#doktor_id').empty();
            $('#randevu_saati').empty();
            if ($value) {
                $('#allData').hide();
                $('#searchedData').show();
                document.getElementById("randevu_tarihi").value = " ";
                document.getElementById("randevu_saati").value = " ";
            } else {
                $('.data').empty();
                $('#allData').show();
                $('#searchedData').hide();
                $('#bolum_id1').append($('<option>', {
                    selected: true,
                    disabled: true,
                    hidden: true,
                    value: "none",
                    text: 'Select department'
                }));
                document.getElementById("randevu_tarihi").value = " ";
                document.getElementById("randevu_saati").value = " ";
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('searchDepartment') }}',
                data: {
                    'search': $value
                },
                success: function(data) {
                    $('.data').empty();
                    if (data.length > 0) {
                        $('.data').append($('<option>', {
                            selected: true,
                            disabled: true,
                            hidden: true,
                            value: "none",
                            text: data.length + ' department found please select one'
                        }));
                    } else {
                        $('.data').append($('<option>', {
                            selected: true,
                            disabled: true,
                            hidden: true,
                            value: "none",
                            text: 'Oops, department not found'
                        }));
                    }
                    for (var i = 0; i < data.length; i++) {
                        $('.data').append($('<option>', {
                            value: data[i].id,
                            text: data[i].bolum_adi
                        }));
                    }
                }
            });
        })
    </script>
@endsection
