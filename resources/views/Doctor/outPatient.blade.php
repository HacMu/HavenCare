@extends('Doctor.doctorMaster')

@section('title', 'Out-patients')

@section('pageHeader', 'Out-patients')

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
                            <input type="text" autocomplete="off" class="form-control border-0 rounded mr-2" id="search"
                                name="search" placeholder="Search for Out-patient">
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
                            @if ($outpatients->count() == 0)
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
                                    <th scope="col">In-Date</th>
                                    <th scope="col">Room NO</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Out-Date</th>
                                    <th scope="col" class="text-center">In-Satus</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="allData">
                                @foreach ($outpatients as $outpatient)
                                    <tr>
                                        <th hidden><span></span></th>
                                        <th scope="row">{{ $outpatient->inPatient->patient->hasta_tc }}</th>
                                        <td>{{ $outpatient->inPatient->patient->hasta_adi }}</td>
                                        <td>{{ $outpatient->yatis_tarihi }}</td>
                                        <td>{{ $outpatient->inRoom->oda_numarasi }}</td>
                                        <td>{{ $outpatient->inRoom->department->bolum_adi }}</td>
                                        <td>{{ $outpatient->cikis_tarihi }}</td>
                                        <td class="text-center">
                                            <span class="badge rounded-8 text-bg-danger">
                                                <p class="p-1" style="color: white">{{ $outpatient->yatis_durumu }}</p>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a
                                                    href="{{ route('doctor.outpatient.show.patient', $outpatient->id) }}"class="navbar-brand mr-2"><i
                                                        style="color: #4169E1;font-size:15pt"
                                                        class="fa-solid fa-circle-info"></i>
                                                </a>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody id="content" class="searchedData">

                            </tbody>
                            @endif
                        </table>
                        <!--Table pagination-->
                        <nav aria-label="Page navigation example ">
                            <ul class="pagination justify-content-between">

                                <li class="page-item">
                                    <a href="{{ route('doctor.inpatient') }}"
                                        class="btn btn-light fs-8  pull-right align-items-center border-0">In-Patients</a>
                                </li>

                                <li class="page-item pull-right">
                                    {!! $outpatients->links('vendor.pagination.custom') !!}
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
            $('#kategori').val('all');
            if (value) {
                $('.allData').hide();
                $('.searchedData').show();
            } else {
                $('.allData').show();
                $('.searchedData').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('searchOutpatientDoctor') }}',
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
