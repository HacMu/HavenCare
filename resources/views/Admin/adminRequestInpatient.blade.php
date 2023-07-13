@extends('Admin.adminMaster')

@section('title', 'In-Patient Requests')

@section('pageHeader', 'Request Management')

@section('content')
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
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-bed-pulse"></i>
                        <span class="ml-2">Requests information</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            @if ($inpatients->count() == 0)
                                <tbody>
                                    <tr>
                                        <p>There is no information about In-Paitens requests</p>
                                    </tr>
                                </tbody>
                            @else
                                <thead>
                                    <tr>
                                        <th scope="col" hidden></th>
                                        <th scope="col">Patient ID</th>
                                        <th scope="col">Patinet</th>
                                        <th scope="col">Doctor</th>
                                        <th scope="col">Doctor Specialist</th>
                                        <th scope="col">In-Date</th>
                                        <th scope="col" class="text-center">In-Satus</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="allData">
                                    @foreach ($inpatients as $inpatient)
                                        <tr>
                                            <th hidden><span></span></th>
                                            <th scope="row">{{ $inpatient->inPatient->patient->hasta_tc }}</th>
                                            <td>{{ $inpatient->inPatient->patient->hasta_adi }}</td>
                                            <td>{{ $inpatient->inDoctor->doctor->doktor_adi }}</td>
                                            <td>{{ $inpatient->inDoctor->doctor->doktor_uzmanlik }}</td>
                                            <td>{{ $inpatient->yatis_tarihi }}</td>
                                            <td class="text-center">
                                                @if ($inpatient->yatis_durumu == 'Requested')
                                                    <span class="badge rounded-8 text-bg-primary">
                                                        <p class="p-1" style="color: white">Requested</p>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a
                                                        href="{{ route('admin.inpatient.request.info', $inpatient->id) }}"class="navbar-brand "><i
                                                        style="color: #00a099;font-size:15pt"
                                                        class="fa-solid fa-check"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                        <!--Table pagination-->
                        <nav aria-label="Page navigation example ">
                            <ul class="pagination justify-content-between">
                                <li class="page-item pull-left">
                                    <a href="{{ route('admin.active.inpatient') }}"
                                    class="page-link btn-light pull-left border-0 rounded shadow-sm">Return back </a>
                                </li>
                                <li class="page-item pull-right">
                                    {!! $inpatients->links('vendor.pagination.custom') !!}
                                </li>
                            </ul>
                        </nav>
                        <!--End table pagination-->

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
