@extends('Admin.adminMaster')
<!--Set title of page as Admin - Dashboard-->
@section('title', 'Admin - Dashboard')
<!--Set header of page as  dashboard panel-->
@section('pageHeader', 'Dashboard Panel')

@section('content')
    <style>
        a:hover {
            color: white;
        }
    </style>
    <!--Cards-->

    <div class="align-items-center" style="margin-top:84px">
        <div class="row">
            <div class="col">
                <div class="card shadow border-0 text-white mb-3"
                    style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('/Images/pulse.png') }}" class="img-fluid rounded-start ">
                        </div>
                        <div class="col-md-8">
                            <div class="card-header bg- border-0">
                                <b>Patients</b>
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-1">Havencare Active Patient : <b>{{ $patientCount }}</b> </p>
                                <p><a class="card-text" href="{{ route('admin.users.patients') }}"><small><span>More
                                                details</span><i class="arrow fa fa-angle-right ml-2"></i></a></p></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow border-0 text-white mb-3"
                    style="background: rgb(65,105,225);background: linear-gradient(90deg, rgba(65,105,225,1) 0%, rgba(41,57,73,1) 100%);">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('/Images/stethoscope2.png') }}" style="width:76px;height:76px"
                                class="img-fluid rounded-start ">
                        </div>
                        <div class="col-md-8">
                            <div class="card-header bg- border-0">
                                <b>Doctors</b>
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-1">Havencare Active Doctor : <b>{{ $doctorCount }}</b> </p>
                                <p><a class="card-text" href="{{ route('admin.users.doctors') }}"><small><span>More
                                                details</span><i class="arrow fa fa-angle-right ml-2"></i></a></p></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--Count of admins card-->
            <div class="col">
                <div class="card shadow border-0 text-white mb-3"
                    style="background: rgb(41,57,73);background: linear-gradient(90deg, rgba(41,57,73,1) 15%, rgba(129,216,208,1) 100%);">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('/Images/settings.png') }}" style="width:72px;height:72px"
                                class="img-fluid rounded-start ">
                        </div>
                        <div class="col-md-8">
                            <div class="card-header bg- border-0">
                                <b>Admins</b>
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-1">Havencare Active Admin : <b>{{ $adminCount }}</b> </p>
                                <p><a class="card-text"><small><span>Only one admin</span></a></p></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Cards end -->

    <!--Charts start-->
    <div class="align-items-center " style="margin-top:32px;">
        <div class="row ">
            <div class="col-xl-6">
                <!--New patient chart-->
                <div class="card mb-4 border-0">
                    <div class="card-header border-0" style="background-color : #00A099;color:white">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="ml-2">New patient last year</span>
                    </div>
                    <div class="card-body d-flex"><canvas id="myLineChart" width="100%" height="40"></canvas></div>
                </div>
                <!--Appointment chart-->
                <div class="card mb-4 border-0">
                    <div class="card-header border-0" style="background-color : #4169E1;color:white">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span class="ml-2">Appointment statistics</span>
                    </div>
                    <div class="card-body"><canvas id="myLineChart2" width="100%" height="40"></canvas></div>
                </div>
            </div>

            <div class="col-xl-6">
                <!--All user pie chart-->
                <div class="card  mb-4 border-0 ">
                    <div class="card-header border-0" style="background-color : #23313f;color:white">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span class="ml-2">Suitability of the staff</span>
                    </div>
                    <div class="card-body "><canvas id="myPieChart" width="100%" height="40"></canvas></div>
                </div>

            </div>

        </div>
    </div>
    <!--Charts end-->


    <!--Chart Jscripts-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--Users pie Chart-->
    <script>
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Doctor',
                    'Patient',
                    'Admin'
                ],
                datasets: [{
                    label: 'Count',
                    data: [JSON.parse('{!! json_encode($doctorCount) !!}'), JSON.parse('{!! json_encode($patientCount) !!}'),
                        JSON.parse('{!! json_encode($adminCount) !!}'),
                    ],
                    backgroundColor: [
                        'rgb(230, 57, 70)',
                        'rgb(35, 49, 63)',
                        'rgb(0, 160, 153)'
                    ],
                    hoverOffset: 6
                }]
            }
        });
    </script>
    <!--New Patient Chart-->
    <script>
        var ctx = document.getElementById("myLineChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: JSON.parse('{!! json_encode($months) !!}'),
                datasets: [{
                    label: "Patient",
                    backgroundColor: "rgba(0, 160, 153, 1)",
                    borderColor: "rgba(0, 160, 153, 1)",

                    data: JSON.parse('{!! json_encode($monthCount) !!}'),
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 10,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
    <!--Appointment Chart-->
    <script>
        var ctx = document.getElementById("myLineChart2");
        var myLineChart2 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse('{!! json_encode($monthsApp) !!}'),
                datasets: [{
                    label: "Appointments",
                    backgroundColor: "rgb(65, 105, 225)",
                    borderColor: "rgb(65, 105, 225)",

                    data: JSON.parse('{!! json_encode($monthCountApp) !!}'),
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 10,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
@endsection
