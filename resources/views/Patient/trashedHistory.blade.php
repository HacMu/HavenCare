@extends('Patient.patientMaster')

@section('title', 'Apporintment')

@section('pageHeader', 'Apporintment History')

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
</style>
<div class="align-items-center" style="margin-top:64px">
    @if ($appointments->count() > 0)
    <div class="row">
        <div class="col">
            <div class="card bg-light mb-4 border-0 ">
                <div class="d-flex align-items-center bg-light rounded justify-content-between  card-header border-0 " style="height:48px;">
                    <span class="ml-2">
                        <h1 class="fs-5 mt-3 pull-left" id="article">Expired booked appointments</h1>
                    </span>
                    <span class="ml-2r">
                        <a href="{{route('patient.appointment')}}" class="btn btn-light fs-8 mt-3 pull-right align-items-center border-0">Active Appointments</a>
                    </span>
                </div>

                <div class="card-body rounded">
                    <div class="row">
                        @foreach ($appointments as $appointment)
                            <div class="col mb-1 mt-1 ">
                                <div class="card border-0 shadow rounded-75">
                                    <div class="card-body mt-2 ">
                                        <h5 class="card-title" style="font-size:12pt;font-weight:bold;color:#00a099">
                                            {{ $appointment->appdoctor->doctor->clinic->department->bolum_adi }}</h5>
                                        <p class="card-text">{{ $appointment->appdoctor->doctor->clinic->klinik_adi }}
                                            |
                                            {{ $appointment->appdoctor->doctor->clinic->klinik_numarasi }}
                                        </p>
                                    </div>

                                    <ul class="list-group border-0 mt-0  list-group-flush">
                                        <li class="list-group-item border-0"><i class="fa-solid fa-stethoscope mr-2"
                                                style="color:#00a099"></i>Dr.{{ $appointment->appdoctor->doctor->doktor_adi }}
                                        </li>
                                        <li class="list-group-item  border-0"><i class="fa-solid fa-clock mr-2"
                                                style="color:#00a099"></i>{{ $appointment->randevu_tarihi }} |
                                            {{ $appointment->randevu_saati }}</li>
                                        <li class="list-group-item border-0"><i class="fa-solid fa-location-dot mr-3"
                                                style="color:#00a099"></i>{{ $appointment->appdoctor->doctor->clinic->department->bolum_adres }}
                                        </li>
                                        <li class="list-group-item border-0 mb-2">
                                            @if ($appointment->randevu_durumu == 'Attend' )
                                                <span style="margin-top: 3px"
                                                    class="badge rounded-pill text-bg-danger">{{$appointment->randevu_durumu}}</span>
                                            @elseif ($appointment->randevu_tarihi < now()->format('Y-m-d'))
                                                <span style="margin-top: 3px"
                                                    class="badge rounded-pill text-bg-danger">Expired</span>
                                                    @php
                                                    $earlier = new DateTime(date('Y-m-d'));
                                                    $later = new DateTime($appointment->randevu_tarihi);
                                                    @endphp
                                                <p style="margin-top:3px;color:#E63946" class="badge">
                                                    {{ $earlier->diff($later)->format('%a') }} day ago</p>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pt-4 justify-content-end">
                            <li class="page-item pull-right">
                                {!! $appointments->links('vendor.pagination.custom') !!}
                            </li>
                        </ul>
                    </nav>


                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col">
            <div class="card bg-light mb-4 border-0 ">
                <div class="d-flex align-items-center bg-light rounded justify-content-between  card-header border-0 " style="height:48px;">
                    <span class="ml-2">
                        <h1 class="fs-5  pull-left" id="article">No appointment history</h1>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
