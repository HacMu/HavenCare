@extends('Admin.adminMaster')
<!--Set title of page as Edit - Department info-->
@section('title', 'Edit - Department')
<!--Set header of page as Departments Management panel-->
@section('pageHeader', 'Departments Management')

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
                <!--Patient information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span class="ml-2">Edit {{ $department->bolum_adi  }} information</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="mb-0" action="{{route('admin.update.department',$department->id)}}"
                            style="margin-bottom: 32px">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                             name="bolum_adi" placeholder="#"
                                            value="{{$department->bolum_adi}}" required>
                                        <label for="floatingInput">Department name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                             name="bolum_adres" placeholder="#"
                                            value="{{$department->bolum_adres}}" required>
                                        <label for="floatingInput">Department address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                             name="bolum_aciklama" placeholder="#"
                                            value="{{$department->bolum_aciklama}}">
                                        <label for="floatingInput">Department Description</label>
                                    </div>
                                </div>
                            </div>
                            <nav aria-label="Page navigation example mt-4 ">
                                <ul class="pagination justify-content-between">
                                    <li class="page-item">
                                        <a href="{{ route('admin.hospital.departments') }}"" type="reset"
                                            class="btn btn-light border-0">Cancle</a>
                                    </li>
                                    <li class="page-item">
                                        <button type="submit" class="page-link btn-light border-0 rounded shadow-sm"
                                            style="background-color:#00a099;color: white"><i
                                                class="fa-solid fa-check mr-2"></i><b>Save</b></button>
                                    </li>
                                </ul>
                            </nav>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
