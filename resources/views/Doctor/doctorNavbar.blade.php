<nav class="navbar navbar-light rounded shadow-sm" style="margin-top:32px;background-color:#293949">
    <div class="container ">
        <a class="navbar-brand " style="color:#F8F9FA;font-size:20px;font-weight:bold;">
            <button onclick="myFunction()" class="navbar-brand"><i style="color: #F8F9FA" class="fa-solid fa-bars"></i></button>
            @yield('pageHeader')
        </a>
        <form class="d-flex">
            @include('layouts.logineduser')
            <!--Auth dropdown menu-->
        </form>
    </div>
</nav>


<script>
    function myFunction() {
        var x = document.getElementById("sidebar");
        var y = document.getElementById("wrapper");
        var z = document.getElementById("sidebar-wrapper");
        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.paddingLeft = "250px";
            z.style.width = "250px"
        } else {
            x.style.display = "none";
            y.style.paddingLeft = "48px";
            z.style.width = "0px"
        }
    }
</script>
