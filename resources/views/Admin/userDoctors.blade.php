@extends('Admin.adminMaster')
<!--Set title of page as Doctor info-->
@section('title', 'Doctor info')
<!--Set header of page as Doctor Management-->
@section('pageHeader', 'Doctor Management')

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
                                placeholder="Search for doctor">
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!--Doctor information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span class="ml-2">Havencare doctors information</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Doctor ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Speciality</th>
                                    <th scope="col">Clinic</th>
                                    <th scope="col">Department</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="allData">
                                @foreach ($datas as $data)
                                    <tr>
                                        <th scope="row">{!! $data->id !!}</th>
                                        <td>{!! $data->doctor->doktor_tc !!}</td>
                                        <td>{!! $data->doctor->doktor_adi  !!}</td>
                                        <td>{!! $data->doctor->doktor_uzmanlik !!}</td>
                                        <td>{!! $data->doctor->clinic->klinik_adi !!}</td>
                                        <td>{!! $data->doctor->clinic->department->bolum_adi !!}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if ($data->doctor->created_at == $data->doctor->updated_at)
                                                    <span class="badge rounded-pill text-bg-danger">Unupdated</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-success">Updated</span>
                                                @endif
                                            </div>
                                        </td>
                    </div>
                    <td>
                        <div class="d-flex justify-content-center">

                            <a href="{{route('admin.edit.doctor',$data->id)}}" class="navbar-brand mr-2"><i
                                    style="color: #00a099;font-size:14pt" class="fa-solid fa-pen-to-square "></i>
                            </a>
                            <a href="{{route('admin.show.doctor',$data->id)}}"class="navbar-brand mr-2"><i
                                    style="color: #4169E1;font-size:14pt" class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#"class="navbar-brand">
                                <form action="{{route('delete.doctor',$data->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
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
                                    data-bs-target="#addDoctor"><i class="fa-solid fa-plus mr-2"></i><b>Add
                                        doctor</b></a>
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

    <!--Add doctor modal-->
    <div class="modal fade mt-0" id="addDoctor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center border-0 shadow-sm">
                    <b class="modal-title fs-4 pull-center" id="article">Add new doctor</b>
                </div>
                <form action="{{ route('add.new.doctor') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('POST') }}

                    <div class="modal-body pb-0">
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="doktor_tc" placeholder="#" minlength="10" required>
                                    <label for="floatingInput">Doctor ID</label>
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
                                        id="floatingInput" name="doktor_tel" placeholder="#" required>
                                    <label for="floatingInput">Phone number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="doktor_uzmanlik" placeholder="#" required>
                                    <label for="floatingInput">Speciality</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="doktor_dt" placeholder="#" required>
                                    <label for="floatingInput">Birth date</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <select class="form-select bg-light border-0 shadow-sm  rounded" id="floatingSelect"
                                        name="doktor_cin" aria-label="Floating label select example" required>
                                        <option selected value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="floatingSelect">Gender</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <select class="form-select bg-light border-0 shadow-sm  rounded" id="bolum_id"
                                        name="bolum_id" aria-label="Floating label select example" onchange="getClinics()" required>
                                        <option value="" selected>Select department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->bolum_adi }}</option>
                                        @endforeach
                                    </select>
                                    <label for="bolum_id">Department</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <select class="form-select bg-light border-0 shadow-sm  rounded" id="klinik_id"
                                        name="klinik_id" aria-label="Floating label select example" required>

                                    </select>
                                    <label for="klinik_id">Clinic</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="mb-3">
                                    <input class="form-control" name="doktor_img" type="file" accept="image/*" id="formFile">
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0 d-flex justify-content-between border-0">
                        <button type="reset" class="btn btn-light pull-left border-0" data-bs-dismiss="modal"
                            aria-label="Close">Cancle</button>
                        <button type="submit" class="btn btn-primary pull-right border-0"
                            style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">Add
                            doctor</button>
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
                url: '{{ URL::to('searchDoctor') }}',
                data: {
                    'search': value
                },
                success: function(data) {
                    $('#content').html(data);

                }
            });
        })
        function getClinics() {
        var value = document.getElementById("bolum_id").value;
        $('#klinik_id').empty();
        $.ajax({
            type: 'get',
            url: '{{ URL::to('getDepOfClinic') }}',
            data: {
                'id': value,
            },
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    $('#klinik_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].klinik_adi + ' NO : ' + data[i].klinik_numarasi
                    }));
                }

            }
        });
    }
    </script>


@endsection

