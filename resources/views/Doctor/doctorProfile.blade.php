@extends('Doctor.doctorMaster')

@section('title', 'Profile')

@section('pageHeader', 'Profile')

@section('content')
    @php
        $genders = ['Male', 'Female'];
    @endphp

    {{-- Define and display error messages --}}
    <?php
    if (count($errors) > 0) {
        foreach ($errors->all() as $item) {
            Alert::toast($item, 'error');
        }
    }
    ?>
    {{-- End Error --}}
    <style>
        #profilename {
            background: linear-gradient(to right,
                    rgba(0, 160, 153, 1) 0%,
                    rgba(65, 105, 225, 1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }
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
        {{-- Update personel info --}}
        <div>
            <form method="POST" action="{{route('doctor.profile.update')}}" style="margin-top:32px;margin-bottom: 32px"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="row text-center" style="margin-bottom: 32px">
                    <div class="profile-pic-wrapper">
                        <div class="pic-holder shadow">
                            <!-- uploaded pic shown here -->
                            @if ($data->doctor->doktor_img == null)
                                <img id="profilePic" class="pic" src="{{ asset('doctorImages/blank.png') }}">
                            @else
                                <img id="profilePic" class="pic" src="{{asset('/doctorImages/'.$data->doctor->doktor_img )}}">
                            @endif
                            <input class="uploadProfileInput" type="file" name="image" id="newProfilePhoto"
                                accept="image/*" style="opacity: 0;" />
                            <label for="newProfilePhoto" class="upload-file-block">
                                <div class="text-center">
                                    <div class="mb-2">
                                        <i class="fa fa-camera fa-2x"></i>
                                    </div>
                                    <div class="text-uppercase">
                                        Update <br /> Profile Photo
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div>
                            <div class="row mt-3">
                                <div class="col d-flex justify-content-center">
                                    <h5 class="h5 fs-4 mr-2" id="profilename" style="font-weight: bold">{{ $data->name }}
                                    </h5>
                                    <span id="profilename"><button type="button" onclick="editnameclick()"><i
                                                class="fa-solid fa-pen-to-square fs-4"></i></button></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p class="fs-8">ID : {{ $data->doctor->doktor_tc }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" name="doktor_tc" class="form-control bg-light border-0 shadow-sm  rounded"
                                id="floatingInput" readonly placeholder="#" value="{{ $data->doctor->doktor_tc }}">
                            <label for="floatingInputValue">ID Number</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" onkeyup="changingname()"   name="name" required
                                class="form-control bg-light border-0 shadow-sm  rounded" id="name" placeholder="#"
                                value="{{ $data->name }}">
                            <label for="name">Fullname</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="date" name="doktor_dt" required
                                class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                value="{{ $data->doctor->doktor_dt }}">
                            <label for="floatingInputValue">Birth Date</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                placeholder="#" required name="doktor_cin" aria-label="Floating label select example">
                                @foreach ($genders as $item)
                                    <option value="{{ $item }}"
                                        {{ $data->doctor->doktor_cin == $item ? 'selected' : '' }}>
                                        {{ $item }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Gender</label>
                        </div>
                    </div>
                </div>
                <h5 class="h5"
                    style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">Contact
                    Information</h5>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="doktor_tel" required
                                class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                value="{{$data->doctor->doktor_tel}}">
                                <label for="floatingInputValue">Phone number</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="email" required
                                class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput"
                                placeholder="#" value="{{ $data->email }}">
                                <label for="floatingInputValue">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="doktor_adres"
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                    value="{{$data->doctor->doktor_adres}}">
                                <label for="floatingInputValue">Address</label>
                            </div>
                        </div>
                    </div>
                <h5 class="h5"
                    style="color:#00a099;margin-top:24px;font-weight:bold;margin-bottom: 24px;text-align:left">Specialization
                    Information</h5>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="doktor_uzmanlik" required readonly
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                    value="{{$data->doctor->doktor_uzmanlik}}">
                                <label for="floatingInputValue">Specialist</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="klinik_id" required readonly
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                    value="{{$data->doctor->clinic->klinik_adi}} | {{$data->doctor->clinic->klinik_numarasi}}">
                                <label for="floatingInputValue">Clinic name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="klinik_numarasi" required readonly
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                    value="{{$data->doctor->clinic->klinik_numarasi}}">
                                <label for="floatingInputValue">Clinic NO</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="bolum_id" required readonly
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                    value="{{$data->doctor->clinic->department->bolum_adi}}">
                                <label for="floatingInputValue">Deparmtment name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="bolum_adres" required readonly
                                    class="form-control bg-light border-0 shadow-sm  rounded" id="floatingInput" placeholder="#"
                                    value="{{$data->doctor->clinic->department->bolum_adres}}">
                                <label for="floatingInputValue">Deparmtment address</label>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col">
                        <a href="#" class="btn btn-light pull-left border-0 rounded mt-8 shadow-sm"
                                        style="background-color:#4169E1;color: white" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop"><b>Change
                                            password</b></a>
                    </div>
                    <div class="col">
                        <button class="btn btn-light pull-right border-0 rounded mt-8 shadow-sm"
                            style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);color:white"><i
                                class="fa-solid fa-check mr-2"></i><b>Update profile</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center border-0 shadow-sm" >
                <b class="modal-title fs-5 fs-4 pull-center" id="article">Change password</b>
            </div>
            <form action="{{ route('doctor.reset.password') }}" method="POST">
                @csrf
                <div class="modal-body pb-0">
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control bg-light border-0 shadow-sm  rounded"
                                    id="floatingInput" name="new_password" min="8" placeholder="#" required>
                                <label for="floatingInput">New password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control bg-light border-0 shadow-sm  rounded"
                                    id="floatingInput" name="confirm_password" min="8" placeholder="#"  required>
                                <label for="floatingInput">Confirm password</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0 d-flex justify-content-between border-0">
                    <button type="reset" class="btn btn-light pull-left  border-0" data-bs-dismiss="modal"
                        aria-label="Close">Cancle</button>
                    <button type="submit" class="btn btn-primary pull-right border-0"
                        style="background: rgb(0,160,153);background: linear-gradient(90deg, rgba(0,160,153,1) 0%, rgba(65,105,225,1) 100%);">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script>
        $(document).on("change", ".uploadProfileInput", function() {
            var triggerInput = this;
            var currentImg = $(this).closest(".pic-holder").find(".pic").attr("src");
            var holder = $(this).closest(".pic-holder");
            var wrapper = $(this).closest(".profile-pic-wrapper");
            $(wrapper).find('[role="alert"]').remove();
            triggerInput.blur();
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) {
                return;
            }
            if (/^image/.test(files[0].type)) {
                // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() {
                    $(holder).addClass("uploadInProgress");
                    $(holder).find(".pic").attr("src", this.result);
                    $(holder).append(
                        '<div class="upload-loader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );

                    // Dummy timeout; call API or AJAX below
                    setTimeout(() => {
                        $(holder).removeClass("uploadInProgress");
                        $(holder).find(".upload-loader").remove();
                        // If upload successful
                        if (Math.random() < 0.9) {
                            // Clear input after upload
                        } else {
                            $(holder).find(".pic").attr("src", currentImg);
                            $(wrapper).append(
                                '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i> There is an error while uploading! Please try again later.</div>'
                            );

                        }
                    }, 1500);
                };
            } else {
                $(wrapper).append(
                    '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose the valid image.</div>'
                );
            }
        });
    </script>


    <script>
        function changingname() {
            document.getElementById('profilename').innerHTML = document.getElementById('name').value;
        }

        function editnameclick() {
            (function($) {
                $.fn.focusTextToEnd = function() {
                    document.getElementById('name').focus();
                    var $thisVal = document.getElementById('name').value;
                    this.val('').val($thisVal);
                    return this;
                }
            }(jQuery));
            $('#name').focusTextToEnd();
        }
    </script>
@endsection
