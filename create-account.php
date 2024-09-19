<?php 
    session_name("user_session");
    session_start();
    if (isset($_SESSION['user_id'])) {
        header('Location: ../new-coms/pages/dashboard.php'); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <base href="../../../../">
    <meta charset="utf-8" />
    <title>COMS</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <?php require('config/dbconnection/databaseconfig.php'); ?>
    <link href="/new-coms/content/css/pages/login/classic/login-1.css" rel="stylesheet" type="text/css" />
    <link href="/new-coms/content/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/new-coms/content/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/new-coms/content/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="/new-coms/assets/logo/Logo-9b593c.png" />
    
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed subheader-enabled page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-1 login-signup-on d-flex flex-column flex-lg-row flex-column-fluid bg-white"
            id="kt_login">
            <!--begin::Aside-->
            <div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10"
                style="background-color: #9b593c;">
                <!--begin: Aside Container-->
                <div class="d-flex flex-row-fluid flex-column justify-content-between">
                    <!--begin: Aside header-->
                    <a href="#" class="flex-column-auto mt-5 pb-lg-0 pb-10">
                        <img src="/new-coms/assets/logo/white-version-logo.png" class="max-h-200px" alt="" />
                    </a>
                    <!--end: Aside header-->
                    <!--begin: Aside content-->
                    <div class="flex-column-fluid d-flex flex-column pt-15">
                        <h3 class="font-size-h1 mb-5 text-white"><b>Welcome to COMS!</b></h3>
                        <p class="font-weight-lighter text-white opacity-80">
                            The <b>Concessionaire Operations Monitoring System (COMS)</b> is an innovative solution for
                            monitoring and managing operations within business spaces. This system aids in tracking
                            payments for electricity, water, and rent bills, and it also provides automatic
                            notifications to the owner regarding contract dates and tenant changes. Tenants similarly
                            receive notifications, particularly concerning due dates for contracts.
                        </p>
                    </div>
                    <!--end: Aside content-->
                    <!--begin: Aside footer for desktop-->
                    <div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
                        <div class="opacity-70 font-weight-bold text-white">© 2020 DU-Developers</div>
                        <div class="d-flex">
                            <a href="#" class="text-white ml-10">Contact</a>
                        </div>
                    </div>
                    <!--end: Aside footer for desktop-->
                </div>
                <!--end: Aside Container-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
                <!--begin::Content body-->
                <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
                    <!--begin::Signin-->
                    <div class="login-form login-signin">
                        <div class="text-center mb-10 mb-lg-20">
                            <h3 class="font-size-h1">Sign In</h3>
                            <p class="text-muted font-weight-bold">Enter your username and password</p>
                        </div>
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_login_signin_form" role="form" method="POST" name="login" >
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                    placeholder="Username" name="username" id="username" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="password"
                                    placeholder="Password" name="password" id="password" autocomplete="off" />
                            </div>
                            <!--begin::Action-->
                            <div class="form-group d-flex flex-column justify-content-between align-items-center">
                                <button type="submit" id="kt_login_signin_submit" name="login"
                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3"
                                    style="width: inherit!important;">Sign In</button>
                                <div class="d-flex flex-row pt-10">
                                    <span class="font-weight-bold text-dark-50">Dont have an account yet?</span>
                                    <a href="javascript:;" class="font-weight-bold ml-2" id="kt_login_signup">Sign
                                        Up!</a>
                                </div>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Signin-->
                    <!--begin::Signup-->
                    <div class="login-form login-signup">
                        <div class="text-center mb-10 mb-lg-20">
                            <h3 class="font-size-h1">Create account</h3>
                            <p class="text-muted font-weight-bold">Enter details to create new owner account</p>
                        </div>
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_login_signup_form">
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                    placeholder="First Name" name="firstname" id="sfirstname" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                    placeholder="Last Name" name="lastname" id="slastname"  autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="username"
                                    placeholder="Username" name="username" id="susername"  autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="email"
                                    placeholder="Email" name="email" id="semail" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="password"
                                    placeholder="Password" name="password" id="spassword" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="password"
                                    placeholder="Confirm password" name="cpassword" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="date"
                                    placeholder="Birthday" name="birthday" id="birthday" autocomplete="off" />
                                <input type="hidden" name="validate_birthdate"  id="validate_birthdate">
                            </div>
                            <div class="form-group">
                                <div class="d-flex flex-row">
                                    <span class="use-title font-weight-bold">User Type: </span>
                                    <input type="radio" value="Owner" name="usertype" id="dot-1" class="ml-2 mb-2" checked required>
                                    <label for="dot-1"><span class="use mb-0 p-2"> Owner </span><span></span></label>     
                                </div>       
                            </div>
                            <div class="form-group">
                                <div class="d-flex flex-row">
                                    <label class="checkbox mb-0">
                                        <input type="checkbox" name="agree" />
                                        <span></span>
                                    </label>
                                    <span class="ml-2">
                                        By signing up, you agree to the 
                                        <a href="#">terms and conditions</a> 
                                        of the system
                                    </span>
                                </div>
                            </div>
                            <div class="form-group d-flex flex-wrap flex-center">
                                <button type="button" id="kt_login_signup_submit"
                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
                                <button type="button" id="kt_login_signup_cancel"
                                    class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Signup-->
                    <div class="login-form login-otp">
                        <div class="text-center mb-10 mb-lg-20">
                            <h3 class="font-size-h1">OTP Verification</h3>
                        </div>
                       <form class="form" novalidate="novalidate" id="kt_otp_form">
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                    placeholder="an OTP (One-Time Password) has been sent" name="otpcode" id="otpcode" autocomplete="off" />                           
                            </div>
                            <div class="form-group d-flex flex-wrap flex-center">
                                <button type="button" id="kt_otp_submit"
                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Verify OTP</button>
                                <button type="button" id="kt_otp_cancel"
                                    class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
                                <button type="button" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4 d-none" id="kt_otp_resend">Resend OTP</button>
                            </div>
                            <div class="text-center" id="timer"></div>
                            <div class="countdown-message" id="countdownMessage"></div>
                       </form>
                    </div>
                </div>
                <!--end::Content body-->
                <!--begin::Content footer for mobile-->
                <div
                    class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
                    <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© 2020 Metronic</div>
                    <div class="d-flex order-1 order-sm-2 my-2">
                        <a href="#" class="text-dark-75 text-hover-primary">Privacy</a>
                        <a href="#" class="text-dark-75 text-hover-primary ml-4">Legal</a>
                        <a href="#" class="text-dark-75 text-hover-primary ml-4">Contact</a>
                    </div>
                </div>
                <!--end::Content footer for mobile-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
    <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#8950FC", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#6993FF", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#EEE5FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#E1E9FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="/new-coms/content/plugins/global/plugins.bundle.js"></script>
    <script src="/new-coms/content/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="/new-coms/content/js/scripts.bundle.js"></script>
    <!-- <script src="/new-coms/content/js/pages/custom/login/login-general.js"></script> -->
    <script src="/new-coms/controller/javascript/create-owner.js"></script>
</body>
<!--end::Body-->

</html>
<script>
    let searchParams = new URLSearchParams(window.location.search)
    _isotpsent = searchParams.has('sent')

    if(_isotpsent){
        var expirationTime = <?php echo time() + 3.04 * 60; ?> * 1000;

        if (expirationTime > 0) {
            var x = setInterval(function () {
                var now = new Date().getTime();
                var distance = expirationTime - now;

                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("timer").innerHTML = "Time Remaining: " + minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "";
                    document.getElementById("countdownMessage").innerHTML = "OTP validity has expired. Please click 'Resend OTP' for a new one.";
                    $("#kt_otp_resend").removeClass("d-none"); // Show Resend OTP button
                }
            }, 1000);
        }

    }
</script>