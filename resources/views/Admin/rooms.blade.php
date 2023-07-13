@extends('Admin.adminMaster')

@section('title', 'Rooms')

@section('pageHeader', 'Rooms Management')

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
                        <input type="text"  class="form-control border-0 rounded" id="search" name="search"
                            placeholder="Search for room">
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <!--Rooms information-->
            <div class="card mb-4  shadow">
                <div class="card-header border-0"
                    style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                    <i class="fa-solid fa-bed"></i>
                    <span class="ml-2">Havencare rooms information</span>
                </div>
                <div class="card-body">
                    <table class="table shade table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Room name</th>
                                <th scope="col">Room NO</th>
                                <th scope="col">Bed number</th>
                                <th scope="col">Department</th>
                                <th scope="col">Address</th>
                                <th scope="col">Create date</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="allData">
                            @foreach ($rooms as $room)
                            <tr>
                                <th scope="row">{{ $room->id }}</th>
                                <td>{!! $room->oda_adi !!}</td>
                                <td>{!! $room->oda_numarasi !!}</td>
                                <td>{!! $room->yatak_sayisi !!}</td>
                                <td>{!! $room->department->bolum_adi !!}</td>
                                <td>{!! $room->department->bolum_adres !!}</td>
                                <td>{!! $room->created_at->format('d-m-Y') !!}</td>

                                <td>
                                    <div class="d-flex justify-content-center">
                                        @if ($room->created_at == $room->updated_at)
                                            <span class="badge rounded-pill text-bg-danger">Unupdated</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-success">Updated</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">

                                        <a href="{{route('admin.edit.room',$room->id)}}"
                                            class="navbar-brand mr-2"><i style="color: #00a099;font-size:14pt"
                                                class="fa-solid fa-pen-to-square "></i>
                                        </a>
                                        <a href="#"class="navbar-brand">
                                            <form action="{{route('admin.delete.room',$room->id)}}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="navbar-brand"><i
                                                        style="color: #E63946;font-size:14pt"
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
                                    room</b></a>
                        </li>
                        <li class="page-item pull-right">
                            {!! $rooms->links('vendor.pagination.custom') !!}
                        </li>
                    </ul>
                </nav>
                <!--End table pagination-->

            </div>
        </div>
    </div>
</div>
</div>


<!--Add room modal-->
<div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header d-flex justify-content-center border-0 shadow-sm" >
            <b class="modal-title fs-5 fs-4 pull-center" id="article">Add new room</b>
        </div>
        <form action="{{ route('admin.new.room') }}" method="POST">
            @csrf
            <div class="modal-body pb-0">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                id="floatingInput" name="oda_adi" placeholder="#" required>
                            <label for="floatingInput">Room name</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control bg-light border-0 shadow-sm  rounded"
                                id="floatingInput" name="oda_numarasi" placeholder="#" required>
                            <label for="floatingInput">Oda NO</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control bg-light border-0 shadow-sm  rounded"
                                id="floatingInput" name="yatak_sayisi" placeholder="#" required>
                            <label for="floatingInput">Bed number</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            <select class="form-select bg-light border-0 shadow-sm  rounded" id="floatingSelect"
                                name="bolum_id" aria-label="Floating label select example" required>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->bolum_adi }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Department</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0 d-flex justify-content-between border-0">
                <button type="reset" class="btn btn-light pull-left  border-0" data-bs-dismiss="modal"
                    aria-label="Close">Cancle</button>
                <button type="submit" class="btn btn-primary pull-right border-0"
                    style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">Add
                    clinic</button>
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
            url: '{{ URL::to('searchRoom') }}',
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
