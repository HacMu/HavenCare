@extends('Admin.adminMaster')
<!--Set title of page as Departments-->
@section('title', 'Departments')
<!--Set header of page as Departments Management-->
@section('pageHeader', 'Departments Management')

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
                    rgba(65, 105, 225, 1) 100%);
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
                            <input type="text" class="form-control border-0 rounded"  id="search" name="search"
                                placeholder="Search for department">
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!--Department information-->
                <div class="card mb-4  shadow">
                    <div class="card-header border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white">
                        <i class="fa-solid fa-house-chimney-medical"></i>
                        <span class="ml-2">Havencare department information</span>
                    </div>
                    <div class="card-body">
                        <table class="table shade table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Department name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Create date</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="allData">
                                @foreach ($datas as $data)
                                    <tr>
                                        <th scope="row">{!! $data->id !!}</th>
                                        <td>{!! $data->bolum_adi !!}</td>
                                        <td>{!! $data->bolum_adres !!}</td>
                                        <td>{!! $data->bolum_aciklama !!}</td>
                                        <td>{!! $data->created_at->format('d-m-Y') !!}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if ($data->created_at == $data->updated_at)
                                                    <span class="badge rounded-pill text-bg-danger">Unupdated</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-success">Updated</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">

                                                <a href="{{ route('admin.edit.department', $data->id) }}"
                                                    class="navbar-brand mr-2"><i style="color: #00a099;font-size:14pt"
                                                        class="fa-solid fa-pen-to-square "></i>
                                                </a>
                                                <a href="#"class="navbar-brand">
                                                    <form action="{{ route('admin.delete.department', $data->id) }}"
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
                                            department</b></a>
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


    <!--Add department modal-->
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 d-flex justify-content-center shadow-sm">
                    <b class="modal-title fs-4" id="article">Add new department</b>
                </div>
                <form action="{{ route('admin.new.department') }}" method="POST">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="bolum_adi" placeholder="#" required>
                                    <label for="floatingInput">Department name</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="bolum_adres" placeholder="#" required>
                                    <label for="floatingInput">Department address</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm  rounded"
                                        id="floatingInput" name="bolum_aciklama" placeholder="#">
                                    <label for="floatingInput">Department description</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0 d-flex justify-content-between border-0">
                        <button type="reset" class="btn btn-light border-0" data-bs-dismiss="modal"
                            aria-label="Close">Cancle</button>
                        <button type="submit" class="btn btn-primary pull-right border-0"
                            style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">Add
                            department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $('#search').on('keyup', function() { //Arama input içindeki değer değiştirildiğinde bu fonksiyon çalışır
            var value =  $(this).val();
            $("#content").empty();
            if (value) {//eğer arama input içinde değer varsa
                $('.allData').hide(); //tüm bilgiler gizlenir
                $('.searchedData').show();//laravel controller'dan gelen bilgileri görüntülenir.
            } else {
                $('.allData').show();
                $('.searchedData').hide();
            }
            $.ajax({
                type: 'get',//methodu get olarak tanımlanır
                url: '{{ URL::to('searchDepartments') }}',//laravel rotunu belirlenir
                data: {
                    'search': value // arama input içindeki değer denetleyiciye gönderilir
                },
                success: function(data) {
                    $('#content').html(data);//gelen verileri ekrana yazdırılır

                }
            });
        })
    </script>
@endsection
