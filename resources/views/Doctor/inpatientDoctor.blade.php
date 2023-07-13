@extends('Doctor.doctorMaster')

@section('title', 'In-patients')

@section('pageHeader', 'In-patients')

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
                                name="search" placeholder="Search for In-patient">
                            <select class="form-select  border-0  rounded" id="kategori"
                                name="hasta_cin" aria-label="Floating label select example" style="width:256px">
                                <option selected value="all">All in-patient</option>
                                <option value="active">Active</option>
                                <option value="requested">Requested</option>
                            </select>
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
                        <span class="ml-2">Inpatient information</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            @if ($inpatients->count() == 0)
                                <tbody>
                                    <tr>
                                        <p>There is no information about In-Paitens</p>
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
                                            <td>{{ $inpatient->yatis_tarihi }}</td>
                                            <td>
                                                @if ($inpatient->oda_id != null)
                                                    {{ $inpatient->inRoom->oda_numarasi }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($inpatient->oda_id != null)
                                                    {{ $inpatient->inRoom->department->bolum_adi }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($inpatient->yatis_durumu == 'Requested')
                                                    <span class="badge rounded-8 text-bg-primary">
                                                        <p class="p-1" style="color: white">Requsted</p>
                                                    </span>
                                                @elseif ($inpatient->yatis_durumu == 'Active')
                                                    <span class="badge rounded-8 text-bg-success">
                                                        <p class="p-1" style="color: white">Active</p>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if ($inpatient->yatis_durumu == 'Requested')
                                                        <a href="#"class="navbar-brand">
                                                            <form
                                                                action="{{ route('doctor.delete.inpatient.request', $inpatient->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="navbar-brand mr-2"><i
                                                                        style="color: #E63946;font-size:14pt"
                                                                        class="fa-solid fa-trash-can"></i></button>
                                                            </form>
                                                        </a>
                                                        <a
                                                            href="{{ route('doctor.inpatient.show.patient', $inpatient->hasta_id) }}"class="navbar-brand mr-2"><i
                                                                style="color: #4169E1;font-size:15pt"
                                                                class="fa-solid fa-circle-info"></i>
                                                        </a>
                                                    @elseif ($inpatient->yatis_durumu == 'Active')
                                                        <form
                                                            action="{{ route('doctor.take.out.inpatient', $inpatient->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="navbar-brand mr-2"><i
                                                                    style="color: #00a099;font-size:15pt"
                                                                    class="fa-solid  fa-arrow-right-from-bracket"></i></button>
                                                        </form>
                                                        <a
                                                            href="{{ route('doctor.inpatient.show.patient', $inpatient->hasta_id) }}"class="navbar-brand mr-2"><i
                                                                style="color: #4169E1;font-size:15pt"
                                                                class="fa-solid fa-circle-info"></i>
                                                        </a>
                                                    @endif
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
                                    <a href="#" class="page-link btn-light pull-left border-0 rounded shadow-sm"
                                        style="background-color:#4169E1;color: white" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop"><i class="fa-solid fa-plus mr-2"></i><b>Add
                                            In-Patient</b></a>
                                    <a href="{{ route('doctor.outpatient') }}"
                                        class="btn btn-light fs-8 ml-2 mlalign-items-center border-0">Out-Patients</a>
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
    <!--App new inpatient-->
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center border-0 shadow-sm">
                    <b class="modal-title fs-4 pull-center" id="article">Add new In-Patient</b>
                </div>
                <form action="{{ route('doctor.new.inpatient') }}" method="POST">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="hasta_tc" placeholder="#" minlength="10" required>
                                    <label for="floatingInput">Patient ID</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="yatis_nedeni" placeholder="#" required>
                                    <label for="floatingInput">In-Reason</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0 d-flex justify-content-between border-0">
                        <button type="reset" class="btn btn-light pull-left border-0" data-bs-dismiss="modal"
                            aria-label="Close">Cancle</button>
                        <button type="submit" class="btn btn-primary pull-right border-0"
                            style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">Send
                            request</button>
                    </div>
                </form>
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
                url: '{{ URL::to('searchInpatientDoctor') }}',
                data: {
                    'search': value
                },
                success: function(data) {
                    $('#content').html(data);

                }
            });
        })
        $('#kategori').on('change', function() {
            var value = $(this).val();
            $("#content").empty();
            $('#search').val('');
            if (value != "all") {
                $('.allData').hide();
                $('.searchedData').show();
            } else {
                $('.allData').show();
                $('.searchedData').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('inpatientDoctorFilter') }}',
                data: {
                    'filter': value
                },
                success: function(data) {
                    $('#content').html(data);

                }
            });
        })
    </script>
@endsection
