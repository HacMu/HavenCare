@extends('Admin.adminMaster')
<!--Set title of page as Patient info-->
@section('title', 'Patient info')
<!--Set header of page as Patient Management-->
@section('pageHeader', 'Patient Management')

@section('content')
    <?php
    if (count($errors) > 0) {
        foreach ($errors->all() as $item) {
            Alert::toast($item, 'error');
        }
    }
    ?>
    <style>
        #article {
            background: linear-gradient(to right,
                    rgba(0, 160, 153, 1) 0%,
                    rgba(65,105,225,1) 100%);
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
                                placeholder="Search for patient">
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!--Patient information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span class="ml-2">Havencare patients information</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Patient ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Birth Date</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col" class="text-center">Join date</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="allData">
                                @foreach ($datas as $data)
                                    <tr>
                                        <th scope="row">{!! $data->id !!}</th>
                                        <td>{!! $data->patient->hasta_tc !!}</td>
                                        <td>{!! $data->patient->hasta_adi !!}</td>
                                        <td>{!! $data->patient->hasta_cin !!}</td>
                                        <td>{!! $data->patient->hasta_dt !!}</td>
                                        <td>{!! $data->email !!}</td>
                                        <td>{!! $data->patient->hasta_tel !!}</td>
                                        <td>
                                            <div class="text-center">
                                                {!! $data->patient->created_at->format('d-m-Y') !!}
                                            </div>

                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if ($data->patient->created_at == $data->patient->updated_at)
                                                    <span class="badge rounded-pill text-bg-danger">Unupdated</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-success">Updated</span>
                                                @endif
                                            </div>
                                        </td>
                    </div>
                    <td>
                        <div class="d-flex justify-content-center">

                            <a href="{{ route('admin.edit.patient', $data->id) }}" class="navbar-brand mr-2"><i
                                    style="color: #00a099;font-size:14pt" class="fa-solid fa-pen-to-square "></i>
                            </a>
                            <a href="{{ route('admin.show.patient', $data->id) }}"class="navbar-brand mr-2"><i
                                    style="color: #4169E1;font-size:14pt" class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#"class="navbar-brand">
                                <form action="{{ route('delete.patient', $data->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="navbar-brand"><i style="color: #E63946;font-size:14pt"
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </a>
                        </div>
                    </td>
                    </tr>
                    @endforeach
                    </tbody>

                    <tbody id="content" class="searchedData">

                    </tbody>
                    </table>
                    <!--Table pagination-->
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination justify-content-between">
                            <li class="page-item">
                                <a href="#" class="page-link btn-light pull-right border-0 rounded shadow-sm"
                                    style="background-color:#4169E1;color: white" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop"><i class="fa-solid fa-plus mr-2"></i><b>Add
                                        patient</b></a>
                            </li>
                            <li class="page-item pull-right">
                                {!! $datas->links('vendor.pagination.custom') !!}
                            </li>
                        </ul>
                    </nav>
                    <!--End table pagination-->

                </div>
            </div>
        </div>
    </div>
    </div>

    <!--Add patient modal-->
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center border-0 shadow-sm">
                    <b class="modal-title fs-4 pull-center" id="article">Add new patient</b>
                </div>
                <form action="{{ route('add.new.patient') }}" method="POST">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="hasta_tc" placeholder="#" minlength="10" required>
                                    <label for="floatingInput">Patient ID</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="name" placeholder="#" required>
                                    <label for="floatingInput">Full name</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="email" placeholder="#" required>
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="hasta_tel" placeholder="#" required>
                                    <label for="floatingInput">Phone number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="hasta_dt" placeholder="#" required>
                                    <label for="floatingInput">Birth date</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <select class="form-select bg-light border-0 shadow-sm  rounded" id="floatingSelect"
                                        name="hasta_cin" aria-label="Floating label select example" required>
                                        <option selected value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="floatingSelect">Gender</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0 d-flex justify-content-between border-0">
                        <button type="reset" class="btn btn-light pull-left border-0" data-bs-dismiss="modal"
                            aria-label="Close">Cancle</button>
                        <button type="submit" class="btn btn-primary pull-right border-0"
                            style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">Add
                            patient</button>
                    </div>
                </form>
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
                url: '{{ URL::to('searchPatient') }}',
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
