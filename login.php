<?php
    session_start();
    if (isset($_SESSION["userid"])) {
        header("Location: feed.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="assets/images/favicon.png" rel="icon" type="image/png">

    <!-- Basic Page Needs
        ================================================== -->
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Socialite is - Professional A unique and beautiful collection of UI elements">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="assets/css/icons.css">

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="assets/css/uikit.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/css/tailwind.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
        }


        .bootstrap-select.btn-group button {
            background-color: #f3f4f6 !important;
            height: 44px !important;
            box-shadow: none !important;
        }

        #checkbox1 {
            display: block;
            margin: 0 auto;
            width: 15px;
        }
    </style>

</head>

<body>


    <div class="lg:flex max-w-5xl min-h-screen mx-auto p-6 py-10">
        <div class="flex flex-col items-center lg: lg:flex-row lg:space-x-10">

            <div class="lg:mb-12 flex-1 lg:text-left text-center">
                <img src="assets/images/logo_size_big.png" alt="" class="lg:mx-0 lg:w-52 mx-auto w-40">
                <p class="font-medium lg:mx-0 md:text-2xl mt-6 mx-auto sm:w-3/4 text-xl"> Connect with friends and the
                    world around you on SocialConnect.</p>
            </div>
            <div class="lg:mt-0 lg:w-96 md:w-1/2 sm:w-2/3 mt-10 w-full">
                <form class="p-6 space-y-4 relative bg-white shadow-lg rounded-lg">
                    <input name="email_login" type="email" placeholder="Email or Phone Number" class="with-border">
                    <input name="password_login" type="password" placeholder="Password" class="with-border">
                    <button onclick="Login()" type="button"
                        class="bg-blue-600 font-semibold p-3 rounded-md text-center text-white w-full">
                        Log In
                    </button>
                    <a style="cursor: pointer;" onclick="ForgotPassword()" type="button" class="text-blue-500 text-center block"> Forgot Password?
                    </a>
                    <hr class="pb-3.5">
                    <div class="flex">
                        <a href="#register" type="button"
                            class="bg-green-600 hover:bg-green-500 hover:text-white font-semibold py-3 px-5 rounded-md text-center text-white mx-auto"
                            uk-toggle>
                            Create New Account
                        </a>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm"> <a href="#" class="font-semibold hover:underline"> Create a Page
                    </a> for a celebrity, band or business </div>
            </div>

        </div>
    </div>
    <!-- Thanh thông báo ở góc trên bên phải -->
    <div class="notification" id="notification">
        <span id="notification-text"></span>
        <button id="close-notification">X</button>
    </div>
    <!-- This is the modal -->
    <div id="register" uk-modal>
        <div class="uk-modal-dialog uk-modal-body rounded-xl shadow-2xl p-0 lg:w-5/12">
            <button class="uk-modal-close-default p-3 bg-gray-100 rounded-full m-3" type="button" uk-close></button>
            <div class="border-b px-7 py-5">
                <div class="lg:text-2xl text-xl font-semibold mb-1"> Sign Up</div>
                <div class="text-base text-gray-600"> It’s quick and easy.</div>
            </div>
            <form id="formRegister_model" class="p-7 space-y-5">
                <div class="grid lg:grid-cols-2 gap-5">
                    <input name="txtFirstName" type="text" placeholder="Your Name" class="with-border">
                    <input name="txtLastName" type="text" placeholder="Last  Name" class="with-border">
                </div>
                <input name="email" type="email" placeholder="Info@example.com" class="with-border">
                <input name="password" type="password" placeholder="******" class="with-border">
                <input name="rePassword" type="password" placeholder="******" class="with-border">
                <div class="grid lg:grid-cols-2 gap-3">
                    <div>
                        <label class="mb-0"> Gender </label>
                        <select name="slGender" class="selectpicker mt-2 with-border">
                            <option>Male</option>
                            <option>Female</option>
                        </select>

                    </div>
                    <div>
                        <label class="mb-2"> Phone: optional </label>
                        <input name="txtPhone" type="text" placeholder="+543 5445 0543" class="with-border">
                    </div>
                </div>

                <p class="text-xs text-gray-400 pt-3">
                    <input name="ckPrivacy" type="checkbox" id="checkbox1" checked>
                    By clicking Sign Up, you agree to our
                    <a href="#" class="text-blue-500">Terms</a>,
                    <a href="#">Data Policy</a> and
                    <a href="#">Cookies Policy</a>.
                    You may receive SMS Notifications from us and can opt out any time.
                </p>
                <div class="flex">
                    <button onclick="Register()" type="button"
                        class="bg-blue-600 font-semibold mx-auto px-10 py-3 rounded-md text-center text-white">
                        Get Started
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- For Night mode -->
    <script>

        (function (window, document, undefined) {
            'use strict';
            if (!('localStorage' in window)) return;
            var nightMode = localStorage.getItem('gmtNightMode');
            if (nightMode) {
                document.documentElement.className += ' night-mode';
            }
        })(window, document);

        (function (window, document, undefined) {

            'use strict';

            // Feature test
            if (!('localStorage' in window)) return;

            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode) return;

            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function (event) {
                event.preventDefault();
                document.documentElement.classList.toggle('dark');
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('gmtNightMode', true);
                    return;
                }
                localStorage.removeItem('gmtNightMode');
            }, false);

        })(window, document);
        
        
    </script>

    <!-- Javascript
    ================================================== -->
    <script src="Js/Login.js"></script>
    <script src="Js/notification.js"></script>
    <script src="Js/ForgotPassword.js"></script>
    <script src="Js/Register_model.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>