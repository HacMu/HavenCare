<aside class="sidebar" id="sidebar">
    <div id="leftside-navigation" class="nano">
        <div>
            <img src="{{ asset('Images/logo-2.png') }}" alt="" style="width:180px; margin:32px auto 32px auto; display:block;">
        </div>
        <ul class="nano-content">
            <li>
                <a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
            </li>

            <li class="sub-menu">
                <a href="javascript:void(0);"><i class="fa-solid fa-user"></i><span>Users</span><i
                        class="arrow fa fa-angle-right pull-right"></i></a>
                <ul>
                    <li>
                        <a href="{{route('admin.users.doctors')}}">Doctors</a>
                    </li>
                    <li>
                        <a href="{{route('admin.users.patients')}}">Patients</a>
                    </li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:void(0);"><i class="fa-solid fa-circle-h"></i><span>Hospital</span><i
                        class="arrow fa fa-angle-right pull-right"></i></a>
                <ul>
                    <li>
                        <a href="{{route('admin.hospital.departments')}}">Departments</a>
                    </li>
                    <li>
                        <a href="{{route('admin.hospital.clinics')}}">Clinics</a>
                    </li>
                    <li>
                        <a href="{{route('admin.hospital.rooms')}}">Rooms</a>
                    </li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="{{route('admin.show.appointment.list')}}"><i class="fa-solid fa-calendar-check"></i></i><span>Appointments</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{route('admin.active.inpatient')}}"><i class="fa-solid fa-hospital-user"></i><span>In-Patient</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:void(0);"><i class="fa-solid fa-gear"></i><span>Account Setting</span><i
                        class="arrow fa fa-angle-right pull-right"></i></a>
                <ul>
                    <li>
                    <a>
                        <form method="POST" action="{{ route('logout') }}" >
                            @csrf
                            <input type="submit" name="submit" value="Log out">
                        </form>
                    </a>
                    </li>
                    
                    <li>
                        <a href="{{route('home')}}">Back Home</a>
                    </li>
                </ul>
            </li>
        </ul>
        </li>
        </ul>
    </div>
</aside>
<!-- partial -->
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script src="{{ asset('sidebar/script.js') }}"></script>
