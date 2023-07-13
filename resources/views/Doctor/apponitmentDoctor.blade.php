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
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span class="ml-2">Daily Appointments</span>
                        <span class="pull-right">{{ now()->format('Y-m-d') }}</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            @if ($appointments->count() == 0)
                                <tbody>
                                    <tr>
                                        <p>You don't have any appointment today !</p>
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
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="allData">
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <th hidden><span>{{ $appointment->id }}</span></th>
                                            <th @if ($appointment->randevu_durumu == 'Attend') style="color:#00a099" @endif
                                                scope="row" id="hasta_tc">
                                                {!! $appointment->apppatient->patient->hasta_tc !!}</th>
                                            <td>{!! $appointment->apppatient->patient->hasta_adi !!}</td>
                                            <td>{!! $appointment->apppatient->patient->hasta_cin !!}</td>
                                            <td>{!! $appointment->apppatient->patient->hasta_tel !!}</td>
                                            <td>{!! $appointment->randevu_tarihi !!}</td>
                                            <td>{!! $appointment->randevu_saati !!}</td>
                                            <td class="ml-0 mr-0 pl-0 pr-0" onclick="attend(this)">
                                                @if($appointment->randevu_durumu != 'Attend')
                                                <a class="navbar-brand mr-2" id="refresh" ><i
                                                        style="cursor:pointer;color: #00a099;font-size:14pt"
                                                        class="fa-solid fa-check"></i></a>
                                                @endif
                                            </td>
                                            <td class="ml-0 mr-0 pl-0 pr-0">
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
                                    <a href="{{ route('doctor.appointment.all') }}"
                                        class="btn btn-light fs-8 mt-0 pull-left align-items-center border-0">All
                                        appointments</a>
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
        function attend(obj) {
            var appID = obj.parentNode.cells[0].textContent;
            $.ajax({
                type: 'get',
                url: '{{ URL::to('attendApp') }}',
                data: {
                    'id': appID,
                },
                success: function() {
                    obj.parentNode.cells[1].style.color = "#00a099";
                    obj.parentNode.cells[7].style.visibility = "hidden";
                    obj.parentNode.cells[7].style.backgroundColor  = "#00a099";
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        title: 'Appointment masked as attend',
                        animation: false,
                        position: 'bottom',
                        showConfirmButton: false,
                        background: '#293949',
                        color: 'white',
                        width: '365px',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                }
            });
        }
    </script>
@endsection
