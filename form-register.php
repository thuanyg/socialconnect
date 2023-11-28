<?php
session_start();
if (isset($_SESSION["userid"])) {
    header("Location: feed.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="bg-gray-100">

<!-- Mirrored from demo.foxthemes.net/socialite/form-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:43:08 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="assets/images/favicon.png" rel="icon" type="image/png">

    <!-- Basic Page Needs
        ================================================== -->
    <title>Register - Đăng ký người dùng</title>
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



    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        input,
        .bootstrap-select.btn-group button {
            background-color: #f3f4f6 !important;
            height: 44px !important;
            box-shadow: none !important;
        }

        .notification {
            position: fixed;
            top: 75px;
            right: 20px;
            background-color: rgb(13, 94, 124);
            color: #fff;
            padding: 20px 10px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }

        #close-notification {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 5px 10px;
            margin-left: 10px;
            cursor: pointer;
        }

        #close-notification:hover {
            background-color: #d32f2f;
        }
    </style>

</head>

<body class="bg-gray-100">


    <div id="wrapper" class="flex flex-col justify-between h-screen">

        <!-- header-->
        <div class="bg-white py-4 shadow dark:bg-gray-800">
            <div class="max-w-6xl mx-auto">


                <div class="flex items-center lg:justify-between justify-around">

                    <a href="trending.html">
                        <img src="assets/images/logo_size_big.png" alt="" class="w-32">
                    </a>

                    <div class="capitalize flex font-semibold hidden lg:block my-2 space-x-3 text-center text-sm">
                        <a href="login.php" class="py-3 px-4">Login</a>
                        <a href="form-register.php" class="bg-purple-500 purple-500 px-6 py-3 rounded-md shadow text-white">Register</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- Thanh thông báo ở góc trên bên phải -->
        <div class="notification" id="notification">
            <span id="notification-text"></span>
            <button id="close-notification">X</button>
        </div>
        <!-- Các phần khác của trang web -->
        <!-- Content-->
        <div>
            <div class="lg:p-12 max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
                <form id="formRegister" class="lg:p-10 p-6 space-y-3 relative bg-white shadow-xl rounded-md">
                    <h1 class="lg:text-2xl text-xl font-semibold mb-6"> Register </h1>

                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <label class="mb-0"> First Name </label>
                            <input name="txtFirstName" type="text" placeholder="Your Name" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                        </div>
                        <div>
                            <label class="mb-0"> Last Name </label>
                            <input name="txtLastName" type="text" placeholder="Last  Name" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                        </div>
                    </div>
                    <div>
                        <label class="mb-0"> Email Address </label>
                        <input name="email" type="email" placeholder="Info@example.com" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                    </div>
                    <div>
                        <label class="mb-0"> Password </label>
                        <input name="password" type="password" placeholder="******" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                    </div>
                    <div>
                        <label class="mb-0">RePassword </label>
                        <input name="rePassword" type="password" placeholder="******" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                    </div>
                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <label class="mb-0"> Gender </label>
                            <select name="slGender" class="selectpicker mt-2">
                                <option>Male</option>
                                <option>Female</option>
                            </select>

                        </div>
                        <div>
                            <label class="mb-0"> Phone: optional </label>
                            <input name="txtPhone" type="text" placeholder="+543 5445 0543" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                        </div>
                    </div>

                    <div class="checkbox">
                        <input name="ckPrivacy" type="checkbox" id="chekcbox1" checked>
                        <label for="chekcbox1"><span class="checkbox-icon"></span> I agree to the <a href="pages-terms.html" target="_blank" class="uk-text-bold uk-text-small uk-link-reset"> Terms and Conditions </a>
                        </label>
                    </div>

                    <div>
                        <button onclick="Register()" type="button" class="bg-blue-600 font-semibold p-2 mt-5 rounded-md text-center text-white w-full">
                            Get Started</button>
                    </div>
                </form>


            </div>
        </div>

        <!-- Footer -->

        <div class="lg:mb-5 py-3 uk-link-reset">
            <div class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
                <div class="flex space-x-2 text-gray-700 uppercase">
                    <a href="#"> About</a>
                    <a href="#"> Help</a>
                    <a href="#"> Terms</a>
                    <a href="#"> Privacy</a>
                </div>
                <p class="capitalize"> © copyright 2023 by SocialConnect</p>
            </div>
        </div>

    </div>



    <!-- For Night mode -->
    <script>
        (function(window, document, undefined) {
            'use strict';
            if (!('localStorage' in window)) return;
            var nightMode = localStorage.getItem('gmtNightMode');
            if (nightMode) {
                document.documentElement.className += ' night-mode';
            }
        })(window, document);

        (function(window, document, undefined) {

            'use strict';

            // Feature test
            if (!('localStorage' in window)) return;

            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode) return;

            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function(event) {
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
    <script src="./js/notification.js"></script>
    <script src="./Js/Register.js"></script>
    <script src="../../code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="../../unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>


</body>

<!-- Mirrored from demo.foxthemes.net/socialite/form-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:43:09 GMT -->

</html>