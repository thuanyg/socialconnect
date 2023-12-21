<?php
include_once("Classes/user.php");
include_once("Classes/timer.php");
include_once("Classes/friend.php");
include_once("Classes/message.php");
include_once("Classes/notification.php");
session_start();
$notify = new Notification();
$timer = new Timer();
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
} else {
    $user = new User();
    $userCurrent = $user->getUser($_SESSION["userid"]); // Return Array (userCurrent = result[0])
    $f = new Friend();
    $friends = $f->getListFriend($userCurrent["userid"]);
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
    <title>My Account - Setting</title>
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


</head>

<body>



    <!-- Thanh thông báo ở góc trên bên phải -->
    <div class="notification" id="notification">
        <span id="notification-text"></span>
        <button id="close-notification">X</button>
    </div>
    <div id="wrapper">

        <!-- Header -->
        <header>
            <div class="header_wrap">
                <div class="header_inner mcontainer">
                    <div class="left_side">
                        <span class="slide_menu" uk-toggle="target: #wrapper ; cls: is-collapse is-active">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path d="M3 4h18v2H3V4zm0 7h12v2H3v-2zm0 7h18v2H3v-2z" fill="currentColor"></path>
                            </svg>
                        </span>

                        <div id="logo">
                            <a href="feed.php">
                                <img src="assets/images/logo_size_big.png" alt="">
                                <img src="assets/images/logo-mobile.png" class="logo_mobile" alt="">
                            </a>
                        </div>
                    </div>

                    <!-- search icon for mobile -->
                    <div class="header-search-icon" uk-toggle="target: #wrapper ; cls: show-searchbox"> </div>
                    <div class="header_search"><i class="uil-search-alt"></i>
                        <input value="" name="txtSearch" type="text" class="form-control" placeholder="Search for Friends , Videos and more.." autocomplete="off">
                        <div uk-drop="mode: click" class="header_search_dropdown">
                            <h4 class="search_title"> Results/Recently</h4>
                            <ul id="searchResults">
                                <div id="search-loading" style="display: none;">
                                    <div id="wifi-loader">
                                        <svg class="circle-outer" viewBox="0 0 86 86">
                                            <circle class="back" cx="43" cy="43" r="40"></circle>
                                            <circle class="front" cx="43" cy="43" r="40"></circle>
                                            <circle class="new" cx="43" cy="43" r="40"></circle>
                                        </svg>
                                        <svg class="circle-middle" viewBox="0 0 60 60">
                                            <circle class="back" cx="30" cy="30" r="27"></circle>
                                            <circle class="front" cx="30" cy="30" r="27"></circle>
                                        </svg>
                                        <svg class="circle-inner" viewBox="0 0 34 34">
                                            <circle class="back" cx="17" cy="17" r="14"></circle>
                                            <circle class="front" cx="17" cy="17" r="14"></circle>
                                        </svg>
                                        <div class="text" data-text="Searching"></div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>

                    <div class="right_side">

                        <div class="header_widgets">
                            <a href="#" class="is_icon notification-btn" uk-tooltip="title: Notifications">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                </svg>
                                <?php
                                $noti = $notify->getQuantityUnread($userCurrent["userid"]);
                                if ($noti != null && $noti[0]["total"] != 0) {
                                    $q = $noti[0]["total"];
                                    echo "<span class='notification-quantity'>" . $q . "</span>";
                                }
                                ?>
                            </a>
                            <div uk-drop="mode: click" class="notification-content header_dropdown">
                                <div class="dropdown_scrollbar" data-simplebar>
                                    <div class="drop_headline">
                                        <h4>Notifications </h4>
                                        <div class="btn_action">
                                            <a href="#" data-tippy-placement="left" title="Notifications">
                                                <ion-icon name="settings-outline"></ion-icon>
                                            </a>
                                            <a href="#" class="btn-read-all-notification" data-tippy-placement="left" title="Mark as read all">
                                                <ion-icon name="checkbox-outline"></ion-icon>
                                            </a>
                                        </div>
                                    </div>
                                    <ul class="list-notification">
                                        <!-- Append Notification Here -->
                                    </ul>
                                </div>
                            </div>

                            <!-- Message -->
                            <a href="#" class="is_icon" uk-tooltip="title: Message">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                </svg>
                                <span>4</span>
                            </a>
                            <div uk-drop="mode: click" class="header_dropdown is_message">
                                <div class="dropdown_scrollbar" data-simplebar>
                                    <div class="drop_headline">
                                        <h4>Messages </h4>
                                        <div class="btn_action">

                                        </div>
                                    </div>
                                    <input type="text" class="uk-input" placeholder="Search in Messages">
                                    <ul>
                                        <?php
                                        $friends_mess = (new Message())->getFriendMessage($userCurrent["userid"]);
                                        for ($i = 0; $i < sizeof($friends_mess); $i++) {
                                            $friend = $user->getUser($friends_mess[$i]["friend_id"]);
                                            $mess_obj = new Message();
                                            $mess = $mess_obj->getLastestMessage($userCurrent["userid"], $friend["userid"]);
                                        ?>
                                            <li class="message-preview un-read" data-friend-id="<?php echo $friend["userid"] ?>">
                                                <a href="chats-friend.php?uid=<?php echo $friend["userid"] ?>">
                                                    <div class="drop_avatar"> <img src="<?php echo $friend["avatar_image"] ?>" alt="">
                                                    </div>
                                                    <div class="drop_text">
                                                        <strong> <?php echo $friend["first_name"] . " " . $friend["last_name"] ?> </strong> <time> 6:43 PM</time>
                                                        <p>
                                                            <?php
                                                            if ($mess[0]["sender_id"] == $userCurrent["userid"]) echo "Me: " . $mess[0]["text"];
                                                            if ($mess[0]["sender_id"] == $friend["userid"]) echo $mess[0]["text"];
                                                            ?>
                                                        </p>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <a href="chats-friend.php" class="see-all"> See all in Messages</a>
                            </div>


                            <a href="#">
                                <img src="<?php echo $userCurrent["avatar_image"]; ?>" class="is_avatar" alt="">
                            </a>
                            <div uk-drop="mode: click;offset:5" class="header_dropdown profile_dropdown">

                                <a href="timeline.php" class="user">
                                    <div class="user_avatar">
                                        <img src="<?php echo $userCurrent["avatar_image"]; ?>" alt="">
                                    </div>
                                    <div class="user_name">
                                        <div> <?php echo $userCurrent["first_name"] . " " . $userCurrent["last_name"]; ?> </div>
                                        <span> @<?php echo $userCurrent["url_address"]; ?></span>
                                    </div>
                                </a>
                                <hr>
                                <a href="page-setting.php">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    My Account
                                </a>
                                <a href="#" id="night-mode" class="btn-night-mode">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                    </svg>
                                    Night mode
                                    <span class="btn-night-mode-switch">
                                        <span class="uk-switch-button"></span>
                                    </span>
                                </a>
                                <a href="logout.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Log Out
                                </a>


                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </header>

        <!-- sidebar -->
        <div class="sidebar">

            <div class="sidebar_inner" data-simplebar>

                <ul>
                    <li><a href="timeline.php">
                            <div class="user_avatar">
                                <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="avatar" style="width: 35px; border-radius: 50%; margin-right: 15px;">
                            </div>
                            <span> <?php echo $userCurrent["first_name"] . " " . $userCurrent["last_name"] ?> </span>
                        </a>
                    </li>
                    <li class="active"><a href="feed.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-600">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span> Feed </span> </a>
                    </li>
                    <li><a href="friends.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg><span> Friends </span></a>
                    </li>
                    <li><a href="chats-friend.php">
                            <img src="./assets/images/chat.png" alt="" style="width: 26px; margin-right: 8px">
                            <span> Messages </span></a>
                    </li>
                    <li id="more-veiw" hidden><a href="birthdays.php">
                            <svg fill="currentColor" class="text-yellow-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                                <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                            </svg>
                            <span> Birthdays </span> <span class="new">N</span></a>
                    </li>
                </ul>

                <a href="#" class="see-mover h-10 flex my-1 pl-2 rounded-xl text-gray-600" uk-toggle="target: #more-veiw; animation: uk-animation-fade">
                    <span class="w-full flex items-center" id="more-veiw">
                        <svg class="  bg-gray-100 mr-2 p-0.5 rounded-full text-lg w-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        See More
                    </span>
                    <span class="w-full flex items-center" id="more-veiw" hidden>
                        <svg class="bg-gray-100 mr-2 p-0.5 rounded-full text-lg w-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        See Less
                    </span>
                </a>

                <h3 class="side-title"> Contacts </h3>

                <div class="contact-list my-2 ml-1">
                    <?php
                    if ($friends != null) {
                        for ($i = 0; $i < sizeof($friends); $i++) {
                            $friend = $user->getUser($friends[$i]["friend_id"]);
                    ?>
                            <a href="chats-friend.php?uid=<?php echo $friend["userid"] ?>">
                                <div class="contact-avatar">
                                    <img src="<?php echo $friend["avatar_image"] ?>" alt="avatar">
                                    <span class="user_status status_online"></span>
                                </div>
                                <div class="contact-username">
                                    <?php echo $friend["first_name"] . " " . $friend["last_name"] ?>
                                </div>
                            </a>
                    <?php
                        }
                    }
                    ?>

                </div>

                <ul class="side_links" data-sub-title="Actions">


                    <li><a href="page-setting.php"> <ion-icon name="settings-outline" class="side-icon"></ion-icon> <span>
                                Setting </span> </a>

                    </li>
                    <!-- <li><a href="#"> <ion-icon name="document-outline" class="side-icon"></ion-icon> <span> Create
                                Content </span> </a>
                        <ul>
                            <li><a href="create-group.html"> Create Group </a></li>
                            <li><a href="create-page.html"> Create Page </a></li>
                        </ul>
                    </li> -->
                    <li><a href="#"> <ion-icon name="code-slash-outline" class="side-icon"></ion-icon> <span>
                                Development </span> </a>
                        <ul>
                            <li><a href="development-icons.php"> Icons </a></li>
                        </ul>
                    </li>
                    <li><a href="#"> <ion-icon name="log-in-outline" class="side-icon"></ion-icon> <span> Authentication
                            </span> </a>
                        <ul>
                            <li><a href="form-register.php">Form Sign-up </a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>

                </ul>

                <div class="footer-links">
                    <a href="#">About</a>
                    <a href="#">Careers</a>
                    <a href="#">Support</a>
                    <a href="#">Contact Us </a>
                    <a href="#">Developer</a>
                    <a href="#">Terms of service</a>
                </div>

            </div>

            <!-- sidebar overly for mobile -->
            <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>

        </div>

        <!-- Main Contents -->
        <div class="main_content">
            <div class="mcontainer">

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold"> Setting </h2>
                    <nav class="responsive-nav border-b md:m-0 -mx-4">
                        <ul uk-switcher="connect: #form-type; animation: uk-animation-fade">
                            <li><a href="#" class="lg:px-2"> Profile</a></li>
                            <li><a href="#" class="lg:px-2"> Privacy</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="grid lg:grid-cols-3 mt-12 gap-8">
                    <div>
                        <h3 class="text-xl mb-2 font-semibold"> Basic</h3>
                        <p>Changing personal information such as name and email.</p>
                    </div>
                    <div class="bg-white rounded-md lg:shadow-md shadow col-span-2 lg:mx-16">

                        <div class="grid grid-cols-2 gap-3 lg:p-6 p-4">
                            <div>
                                <label for=""> First name</label>
                                <input type="text" placeholder="" class="shadow-none with-border first-name" value="<?php echo $userCurrent["first_name"] ?>">
                            </div>
                            <div>
                                <label for=""> Last name</label>
                                <input type="text" placeholder="" class="shadow-none with-border last-name" value="<?php echo $userCurrent["last_name"] ?>">
                            </div>
                            <div class="col-span-2">
                                <label for=""> Email</label>
                                <input type="text" placeholder="" class="shadow-none with-border email" value="<?php echo $userCurrent["email"] ?>">
                            </div>


                        </div>

                        <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                            <button class="p-2 px-4 rounded bg-gray-50 text-red-500" onclick='window.history.back()'>
                                Cancel </button>
                            <button type="button" class="button bg-blue-700 btn-save-setting"> Save </button>
                        </div>

                    </div>

                    <div>
                        <h3 class="text-xl mb-2 font-semibold"> Privacy</h3>
                        <p> Adjusting your settings accordingly helps ensure that you maintain control over your
                            information</p>
                    </div>
                    <div class="bg-white rounded-md lg:shadow-lg shadow col-span-2 lg:p-6 p-4 lg:mx-16">

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4>Who can see my information?</h4>
                                    <div> Turn on for public, turn off for private. </div>
                                </div>
                                <?php
                                $status = $user->getStatusPrivacy($_SESSION["userid"]);
                                ?>
                                <div class="switches-list -mt-8 is-large">
                                    <div class="switch-container">
                                        <label class="switch"><input type="checkbox" <?php if ($status[0]["privacy"] == "public")
                                                                                            echo "checked value='on'";
                                                                                        else
                                                                                            echo "value='off'" ?> class="checkbox-privacy"><span class="switch-button"></span> </label>
                                        <input type="hidden" value="<?php echo $_SESSION["userid"] ?>" id="userid">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
    <!-- For Night mode -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <?php include("./Websocket/src/Notification.php") ?>
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
    <script src="Js/page-setting.js"></script>
    <script src="Js/Global.js"></script>
    <script src="Js/notification.js"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

<!-- Mirrored from demo.foxthemes.net/socialite/pages-setting.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:42:45 GMT -->

</html>