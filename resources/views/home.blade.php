<!DOCTYPE html>
<html lang="en">
<!-- Head Code Start Here -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Havencare</title>
    <script src="https://kit.fontawesome.com/29899eac5f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('Css/main.css') }}">
    <link rel="icon" href="/Images/logo.png">
    <style>
        .header__MainText {
            background: url({{ asset('/Images/HomeBackgournd2.jpg') }});
            background-position: center right;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .info {
            width: 100%;
            height: 500px;
            background: url({{asset('/Images/info_bac.png')}});
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<!-- Head Code End Here -->

<!-- Body Code Start Here -->

<body>

    <div hidden>
        <x-app-layout>

        </x-app-layout>
    </div>
    <!-- Header Section Start Here -->
    <header class="header" id="header-page">

        <!-- Nav Section Start Here -->
        <nav class="header__nav">

            <!-- Header Logo Start Here -->
            <div class="header__logo">
                <img src="{{ asset('/Images/logo-1.png') }}" alt="">
            </div>
            <!-- Header Logo End Here -->

            <!-- Header NavigationBar Items Start Here -->
            <div class="header__items">
                <ul class="header__ul">
                    <li class="header__li">
                        <a href="#header-page" class="header__links">
                            Home
                        </a>
                    </li>
                    <li class="header__li">
                        <a href="#features-page" class="header__links">
                            Features
                        </a>
                    </li>
                    <li class="header__li">
                        <a href="#aboutUs-page" class="header__links">
                            About us
                        </a>
                    </li>
                    <li class="header__li">
                        <a href="#contact-page" class="header__links">
                            Contact
                        </a>
                    </li>

                    <li class="header__li">
                        @if (Route::has('login'))
                            <div class="hidden sm:block" style="z-index: 10;margin-right:64px;font-size:16px">
                                @auth
                                    @include('layouts.logineduser')
                                </div>
                </div>
            @else
                <a class="header__links" href="{{ route('login') }}">Log in</a>

                @if (Route::has('register'))
                    <a class="header__links" href="{{ route('register') }}" id="an">Register</a>
                @endif
            @endauth
            @endif
            </li>
            </ul>

            </div>



            <!-- Header NavigationBar Items End Here -->

        </nav>
        <!-- Nav Section End Here -->

        <!-- Main Text Section Start Here -->
        <div class="header__MainText">

            <!-- Texts Start Here -->
            <p>for patient & visitors</p>
            <h1>Find <span>Best Clinic</span>
                To Get Solutions. </h1>
            <p class="secText">Health is one of the most important things
                for us therefore immediately check your health for you good.
            </p>
            <!-- Texts End Here -->

            <!-- Links Start Here -->
            <a href="#">Make an appointment</a>
            <!-- Links End Here -->

            <div class="header__MainText--scrollBtn">
                <h4>Scroll down</h4>
                <img src="{{ asset('/Images/scroll.png') }}" alt="">
            </div>
        </div>
        <!-- Main Text Section End Here -->

    </header>
    <!-- Header Section End Here -->

    <!-- Info Sections Start Here -->
    <section class="info" style="z-index:-4">

        <div class="info__Boxes">

            <div class="info-i-1">
                <div class="box">
                    <img src="{{ asset('/Images/info-i-1.p') }}ng" alt="">
                </div>
                <div class="box_Text">
                    <h1>1000+</h1>
                    <h2>Happy Patient</h2>
                </div>
            </div>

            <div class="info-i-2">
                <div class="box">
                    <img src="{{ asset('/Images/info-i-2.p') }}ng" alt="">
                </div>
                <div class="box_Text">
                    <h1>150+</h1>
                    <h2>Surgery</h2>
                </div>
            </div>

            <div class="info-i-3">
                <div class="box">
                    <img src="{{ asset('/Images/info-i-3.p') }}ng" alt="">
                </div>
                <div class="box_Text">
                    <h1>250+</h1>
                    <h2>Qualified Doctors</h2>
                </div>
            </div>

        </div>

    </section>
    <!-- Info Section End Here -->

    <!-- Features Section Start Here -->
    <section class="features" id="features-page">

        <div class="features__title">
            <h1 id="features_title">We Provide Best Services</h1>
            <p>Wether you’re a fundamental care physician, heart specialist
                or one of the different myriad specialties accessible in
                today’s dynamic and ever-changing medication landspace</p>
        </div>

        <div class="features__Boxes">

            <div class="box-info-1">
                <div class="box_img">
                    <img src="{{ asset('/Images/Untitled-1') }}.png" alt="">
                </div>
                <div class="box_text">
                    <h1>Online Appointment</h1>
                    <p>Havencare clinical is surpri-singly easy to use.Let
                        us show you how it is writes and prescriptions.</p>
                    <a href="#">read more</a>
                </div>
            </div>

            <div class="box-info-2">
                <div class="box_img">
                    <img src="{{ asset('/Images/Untitled-2') }}.png" alt="">
                </div>
                <div class="box_text">
                    <h1>E-Medical Records</h1>
                    <p>Havencare clinical is surpri-singly easy to use.Let
                        us show you how it is writes and prescriptions.</p>
                    <a href="#">read more</a>
                </div>
            </div>

            <div class="box-info-3">
                <div class="box_img">
                    <img src="{{ asset('/Images/Untitled-3') }}.png" alt="">
                </div>
                <div class="box_text">
                    <h1>Manage End-To-End</h1>
                    <p>Havencare clinical is surpri-singly easy to use.Let
                        us show you how it is writes and prescriptions.</p>
                    <a href="#">read more</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Features Section End Here -->

    <!-- AboutUs Sectios Start Here -->
    <section class="aboutUs" id="aboutUs-page">
        <div class="aboutUs__img" id="aboutUs_img">
            <img src="{{ asset('/Images/about_img.') }}jpg" alt="">
        </div>

        <div class="aboutUs__title">
            <h1 class="ab_h1" id="AboutUs_title">About Havencare</h1>
            <p class="ab_p">The art of medicine consists in amusing the
                patient while
                nature cures the treatment.</p>

            <div class="aboutUs__title__text">

                <div class="Hours_Service">
                    <div class="img_box">
                        <img src="{{ asset('/Images/I-1.png') }}" alt="">
                    </div>
                    <div class="text">
                        <h1>24 Hours Service</h1>
                        <p>Health carely is a new way to get health
                            insurance
                            quotes offer tools similar to those health</p>
                    </div>

                </div>

                <div class="Qualified_Doctor">
                    <div class="img_box">
                        <img src="{{ asset('/Images/I-2.png') }}" alt="">
                    </div>
                    <div class="text">
                        <h1>Qualified Doctor</h1>
                        <p>Health carely is a new way to get health
                            insurance
                            quotes offer tools similar to those health</p>
                    </div>
                </div>

                <div class="Need_Emergency">
                    <div class="img_box">
                        <img src="{{ asset('/Images/I-3.png') }}" alt="">
                    </div>
                    <div class="text">
                        <h1>Need Emergency</h1>
                        <p>Health carely is a new way to get health
                            insurance
                            quotes offer tools similar to those health</p>
                    </div>
                </div>

            </div>

        </div>



    </section>
    <!-- AboutUs Sectios End Here -->

    <!-- Contact Section Start Here -->
    <section class="contact" id="contact-page">

        <div class="contact__logo__copyRight">
            <img src="{{ asset('/Images/logo-2.png') }}" alt="">
            <p>Copyright 2022 Havencare.All rights reserved.</p>
        </div>

        <div class="contact__service">
            <h1>Service</h1>
            <span class="hat"></span>
            <div class="location_ser">
                <img src="{{ asset('/Images/location.png') }}" alt="">
                <a href="">
                    <p>Yeni Mah. Hamdi Başaran Cad. Merkez/Elazığ</p>
                </a>
            </div>
            <div class="phone_ser">
                <img src="{{ asset('/Images/phone.png') }}"alt="">
                <a href="">
                    <p>+90-536-934-92-36</p>
                </a>
            </div>
            <div class="mail_ser">
                <img src="{{ asset('/Images/mail.png') }}"alt="">
                <a href="">
                    <p>havencare.hospital@gmail.com</p>
                </a>
            </div>
        </div>

        <div class="contact__socialMedia">
            <h1>Social media</h1>
            <span class="hat"></span>
            <div class="facebook_con">
                <img src="{{ asset('/Images/facebook.png') }}" alt="">
                <a href="">
                    <p>www.facebook.com/havencare</p>
                </a>
            </div>
            <div class="instagram_con">
                <img src="{{ asset('/Images/instagram.png') }}" alt="">
                <a href="">
                    <p>www.instagram.com/havencare</p>
                </a>
            </div>
            <div class="linkedin_con">
                <img src="{{ asset('/Images/linkedin.png') }}" alt="">
                <a href="">
                    <p>www.linkedin.com/havencare</p>
                </a>
            </div>
        </div>
    </section>
    <!-- Contact Section End Here -->
    <script src="{{ asset('Js/main.js">') }}"></script>
</body>
<!-- Body Code End Here -->

</html>
