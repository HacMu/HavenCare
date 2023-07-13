<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel='stylesheet' href='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel="stylesheet" href="{{ asset('sidebar/style.css') }}">
    <link rel="stylesheet" href="{{ asset('Css/containerStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('Css/uploadPhoto.css') }}">
    <link rel="icon" href="/Images/logo.png">
    <script src="https://kit.fontawesome.com/cd3855d533.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <title>@yield('title')</title>
</head>

<body>
    <div hidden>
        <x-app-layout>

        </x-app-layout>
    </div>

    <div id="wrapper">
        <div id="sidebar-wrapper">
            @include('Admin.adminSidebar')
            <!--Include sidebar.blade.php inside layouts folder-->
        </div>
        <div id="page-content-wrapper">
            <div class="page-content">
                <div class="container">
                    <div style="height:64px;justify-content:center">
                        <div class="row">
                            <div class="col">
                                @include('Admin.adminNavbar')
                                <!--include navbar.blade.php inside Admin folder-->
                            </div>
                        </div>
                    </div>
                    <!--Their is page content section-->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
    <!--Bootstrap Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>
