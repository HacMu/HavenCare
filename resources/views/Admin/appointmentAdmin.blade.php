@extends('Admin.adminMaster')

@section('title', 'Appointment')

@section('pageHeader', 'Appointment Management')

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
                            <input type="text" autocomplete="off" class="form-control border-0 rounded" id="search" name="search"
                                placeholder="Search for appointment">
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
                        <span class="ml-2">Appointments information</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            @if ($appointments->count() == 0)
                                <tbody>
                                    <tr>
                                        <p>There is no active appointment</p>
                                    </tr>
                                </tbody>
                            @else
                                <thead>
                                    <tr>
                                        <th scope="col" hidden></th>
                                        <th scope="col">Patient ID</th>
                                        <th scope="col">Patinet name</th>
                                        <th scope="col">Doctor name</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Appointment date</th>
                                        <th scope="col">Appointment time</th>
                                        <th scope="col" class="text-center">Actions</th>
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
                                            <td>{!! $appointment->appdoctor->doctor->doktor_adi !!}</td>
                                            <td>{!! $appointment->appdoctor->doctor->clinic->department->bolum_adi !!}</td>
                                            <td>{!! $appointment->randevu_tarihi !!}</td>
                                            <td>{!! $appointment->randevu_saati !!}</td>
                                            <td class="ml-0 mr-0 pl-0 pr-0">
                                                <div class="d-flex justify-content-center">
                                                    <a
                                                        href="{{ route('admin.show.appointment.info', $appointment->id) }}"class="navbar-brand mr-2"><i
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
        $('#search').on('keyup', function() {
            var value =  $(this).val();
            $("#content").empty();
            if (value) {
                $('.allData').hide();
                $('.searchedData').show();
            } else {
                $('.allData').show();
                $('.searchedData').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('searchForAppAdmin') }}',
                data: {
                    'search': value
                },
                success: function(data) {
                    $('#content').html(data);

                }
            });
        })
    </script>
@endsection
