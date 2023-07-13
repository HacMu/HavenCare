@extends('Doctor.doctorMaster')

@section('title', 'Appointments')

@section('pageHeader', 'My Appointments')

@section('content')
    <style>
        #article {
            background: linear-gradient(to right,
                    rgba(0, 160, 153, 1) 0%,
                    rgba(65, 105, 225, 1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }
    </style>
    <div class="align-items-center" style="margin-top:64px">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <nav class="navbar navbar-expand border rounded shadow">
                        <div class="container-fluid">
                            <i class="fa-solid mr-2 fa-magnifying-glass"></i>
                            <input type="text" autocomplete="off" class="form-control border-0 mr-2 rounded" id="search"
                                name="search" placeholder="Search for patient">

                            <input type="date" class="form-control mr-2 bg-white border-0   rounded"
                                name="hasta_dt" placeholder="#" onchange="getmindate()" id="mindate" style="width: 350px">

                            <input type="date" class="form-control bg-white border-0   rounded"
                                name="hasta_dt" placeholder="#" id="maxdate" style="width: 350px">
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span class="ml-2">All Appointments</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            @if ($appointments->count() == 0)
                                <tbody>
                                    <tr>
                                        <p>You don't have any appointment !</p>
                                    </tr>
                                </tbody>
                            @else
                                <thead>
                                    <tr>
                                        <th scope="col" hidden></th>
                                        <th scope="col">Patient ID</th>
                                        <th scope="col">Patinet name</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Phone number</th>
                                        <th scope="col">Appointment date</th>
                                        <th scope="col">Appointment time</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="allData">
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <th hidden><span>{{ $appointment->id }}</span></th>
                                            <th @if ($appointment->randevu_durumu == 'Attend') style="color:#00a099" @endif
                                                scope="row">
                                                {!! $appointment->apppatient->patient->hasta_tc !!}</th>
                                            <td>{!! $appointment->apppatient->patient->hasta_adi !!}</td>
                                            <td>{!! $appointment->apppatient->patient->hasta_cin !!}</td>
                                            <td>{!! $appointment->apppatient->patient->hasta_tel !!}</td>
                                            <td id="randevu_tarihi">{!! $appointment->randevu_tarihi !!}</td>
                                            <td>{!! $appointment->randevu_saati !!}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a
                                                        href="{{ route('doctor.appointment.show', $appointment->id) }}"class="navbar-brand mr-2"><i
                                                            style="color: #4169E1;font-size:14pt"
                                                            class="fa-solid fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                            <tbody id="content" class="searchedData">

                            </tbody>
                        </table>
                        <!--Table pagination-->
                        <nav aria-label="Page navigation example ">
                            <ul class="pagination justify-content-between">
                                <li class="page-item pull-right">
                                    <a href="{{ route('doctor.appointment') }}"
                                        class="btn btn-light fs-8 mt-3 pull-left align-items-center border-0">Daily
                                        Appointment</a>
                                </li>
                                <li class="page-item pull-right">
                                    {!! $appointments->links('vendor.pagination.custom') !!}
                                </li>
                            </ul>
                        </nav>
                        <!--End table pagination-->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#search').on('keyup', function() {
            var value = $(this).val();
            $("#content").empty();
            $('#maxdate').val('');
            $('#mindate').val('');
            if (value) {
                $('.allData').hide();
                $('.searchedData').show();
            } else {
                $('.allData').show();
                $('.searchedData').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('searchAppsDoctor') }}',
                data: {
                    'search': value
                },
                success: function(data) {
                    $('#content').html(data);

                }
            });
        })

        $('#mindate').on('change', function() {
            var min = $(this).val();
            var max = $('#maxdate').val();
            $("#content").empty();
            $('#search').val('');

            if (min) {
                $('.allData').hide();
                $('.searchedData').show();
            } else {
                $('.allData').show();
                $('.searchedData').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('filterMinAppsDoctor') }}',
                data: {
                    'min': min,
                    'max':max
                },
                success: function(data) {
                    $('#content').html(data);

                }
            });
        })
        $('#maxdate').on('change', function() {
            var max = $(this).val();
            var min = $('#mindate').val();
            $("#content").empty();
            $('#search').val('');
            if (max) {
                $('.allData').hide();
                $('.searchedData').show();
            } else {
                $('.allData').show();
                $('.searchedData').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('filterMaxAppsDoctor') }}',
                data: {
                    'min': min,
                    'max':max
                },
                success: function(data) {
                    $('#content').html(data);

                }
            });
        })
    </script>
@endsection
