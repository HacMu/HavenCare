@extends('Admin.adminMaster')

@section('title', 'Out-Patient')

@section('pageHeader', 'Out-Patient Management')

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
                    <div class="mb-3">
                        <nav class="navbar navbar-expand border rounded shadow">
                            <div class="container-fluid">
                                <i class="fa-solid mr-2 fa-magnifying-glass"></i>
                                <input type="text" autocomplete="off" class="form-control border-0 rounded" id="search" name="search"
                                    placeholder="Search for out-patient">
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
                            <i class="fa-solid fa-bed-pulse"></i>
                            <span class="ml-2">Outpatient information</span>
                        </div>
                        <div class="card-body">
                            <table class="table shade table-striped">
                                @if ($inpatients->count() == 0)
                                <tbody>
                                    <tr>
                                        <p>There is no information about Out-Paitens</p>
                                    </tr>
                                </tbody>
                                @else

                                <thead>
                                    <tr>
                                        <th scope="col" hidden></th>
                                        <th scope="col">Patient ID</th>
                                        <th scope="col">Patinet</th>
                                        <th scope="col">Doctor</th>
                                        <th scope="col">In-Date</th>
                                        <th scope="col">Room NO</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Out-Date</th>
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
                                            <td>{{ $inpatient->yatis_tarihi }}</td>
                                            <td>{{ $inpatient->inRoom->oda_numarasi }}</td>
                                            <td>{{ $inpatient->inRoom->department->bolum_adi }}</td>
                                            <td>{{ $inpatient->cikis_tarihi }}</td>
                                            <td class="text-center">
                                                @if ($inpatient->yatis_durumu == 'Out')
                                                    <span class="badge rounded-8 text-bg-danger">
                                                        <p class="p-1" style="color: white">Out</p>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                        <a
                                                            href="{{ route('admin.out.outpatient.info', $inpatient->id) }}"class="navbar-brand mr-2"><i
                                                                style="color: #4169E1;font-size:15pt"
                                                                class="fa-solid fa-circle-info"></i>
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
                                    <li class="page-item">
                                        <a href="{{route('admin.active.inpatient')}}"
                                        class="page-link btn-light pull-left border-0 rounded shadow-sm">In-Patients </a>
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
        <script type="text/javascript">
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
                    url: '{{ URL::to('searchOutpatient') }}',
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
