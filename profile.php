<?php
include("Classes/user.php");
include("Classes/post.php");
include("Classes/timer.php");
include("Classes/friend.php");
include("Classes/message.php");
include("Classes/notification.php");
$notify = new Notification();
session_start();
$userCurrent = null;
$userProfile = null;
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
} else {
    $f = new Friend();
    $user = new User();

    $userCurrent = $user->getUser($_SESSION["userid"]); // Return Array (userCurrent = result[0])

    if (isset($_GET["uid"])) {
        if ($user->getUser($_GET["uid"])) {
            $userProfile = $user->getUser($_GET["uid"]);
        } else {
            header("Location: pagenotfound.html");
            exit();
        }
    }
    $about = $user->getAbout($userProfile["userid"]);
    if ($_GET["uid"] == $_SESSION["userid"] || !isset($_GET["uid"])) {
        header("Location: timeline.php");
    }
    $p = new Post();
    $post = $p->getPost($userProfile["userid"]);
    $friends = $f->getListFriend($userCurrent["userid"]);
    $friendProfiles = $f->getListFriendLimit($userProfile["userid"], 0, 8);
}

?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.foxthemes.net/socialite/timeline.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:41:59 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="assets/images/favicon.png" rel="icon" type="image/png">

    <!-- Basic Page Needs
        ================================================== -->
    <title><?php echo $userProfile["first_name"] . " " . $userProfile["last_name"] ?> - Profile</title>
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
        .profile_avatar_holder:hover .icon_change_photo {
            display: block;
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

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10022;
        }
    </style>
</head>

<body>


    <!-- Thanh thông báo ở góc trên bên phải -->
    <div class="notification" id="notification">
        <span id="notification-text"></span>
        <button id="close-notification">X</button>
    </div>
    <div id="loader">
        <div class="loader-global"></div>
    </div>
    <!-- Get Current UserID -->
    <input name="txtUserid" type="hidden" value="<?php echo $userCurrent["userid"] ?>">
    <input name="txtUserProfileId" type="hidden" value="<?php echo $userProfile["userid"] ?>">
    <input type="hidden" name="txtUserAvatar" value="<?php echo $userCurrent["avatar_image"] ?>">

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
                    <li><a href="feed.php">
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
                            if ($friend["privacy"] == "public") {
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
        <?php
        if ($userProfile["privacy"] == "public") {
        ?>
            <div class="main_content">
                <div class="mcontainer">

                    <!-- Profile cover -->
                    <div class="profile user-profile">

                        <div class="profiles_banner">
                            <img src="<?php echo $userProfile["cover_image"] ?>" alt="">
                            <div class="profile_action absolute bottom-0 right-0 space-x-1.5 p-3 text-sm z-50 hidden lg:flex">

                            </div>
                        </div>
                        <div class="profiles_content">

                            <div class="profile_avatar">
                                <div class="profile_avatar_holder">
                                    <img src="<?php echo $userProfile["avatar_image"] ?>" alt="">
                                </div>
                                <div class="user_status status_online"></div>
                            </div>

                            <div class="profile_info">
                                <h1 style="text-align: center;"><?php echo $userProfile["first_name"] . " " . $userProfile["last_name"] ?></h1>
                                <p style="text-align: center;"> <?php if ($about != null) {
                                                                    echo $about["desc"];
                                                                } ?> </p>
                            </div>

                        </div>

                        <div class="flex justify-between lg:border-t border-gray-100 flex-col-reverse lg:flex-row pt-2">
                            <nav class="responsive-nav pl-3">
                                <ul uk-switcher="connect: #timeline-tab; animation: uk-animation-fade">
                                    <li><a href="#">Timeline</a></li>
                                    <li><a href="#all-friend">Friend <span><?php echo $f->getQuantityFriend($userProfile["userid"]) ?></span> </a></li>
                                    <li><a href="#" onclick="showImageOfOther()" class="image-orther" userprofile="<?php echo $userProfile["userid"] ?>">Photoes </a></li>
                                </ul>
                            </nav>


                            <div class="flex items-center space-x-1.5 flex-shrink-0 pr-4 mb-2 justify-center order-1 relative">

                                <!-- // Process -->
                                <a style="background-color: lightseagreen;" href="chats-friend.php?uid=<?php echo $userProfile["userid"]; ?>" data-userid="<?php echo $userProfile["userid"]; ?>" class="friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                    <!--Add friend status icon-->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0084FF" class="bi bi-chat-left-quote" viewBox="0 0 16 16">
                                        <path d="M8.25.334a8 8 0 1 0 7.5 12.833 1.6 1.6 0 0 1-2.143-.926 1.6 1.6 0 0 1 2.572-1.9 4.8 4.8 0 0 1-6.429-2.777H6V5a1 1 0 0 1 1-1h3.25a5.6 5.6 0 0 0-.764-3.075 1.6 1.6 0 0 1 .162-2.314 1.6 1.6 0 0 1 2.282.108A8.001 8.001 0 0 0 8.25.334z" />
                                    </svg>
                                    <span>Chat</span>

                                </a>
                                <!-- button actions -->
                                <a style="display: none;" href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                    <!--Add friend status icon-->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-success">
                                        <path d="M8 0C3.58 0 0 3.58 0 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm-2.12 11.46l-3.54-3.54 1.41-1.41 2.12 2.12 4.24-4.24 1.41 1.41-5.65 5.65z" />
                                    </svg>
                                    <span> Friends </span>
                                </a>
                                <!-- cancel request -->
                                <a style="display: none;" href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="cancel-add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                    <!--Add friend status icon-->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="w-5" viewBox="0 0 16 16">
                                        <path d="M8 1a7 7 0 100 14A7 7 0 008 1zM5.354 5.354a.5.5 0 01.708 0L8 8.293l2.938-2.939a.5.5 0 11.707.707L8.707 9l2.938 2.939a.5.5 0 01-.707.707L8 9.707l-2.939 2.939a.5.5 0 01-.707-.707L7.293 9 4.354 6.061a.5.5 0 010-.707z"></path>
                                    </svg>
                                    <span> Cancel request </span>
                                </a>
                                <!-- add friend -->
                                <a style="display: none;" href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                    <!--Add friend status icon-->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span> Add Friend </span>
                                </a>

                                <?php
                                $f = new Friend();
                                ?>
                                <!-- isfriend -->
                                <?php
                                if ($f->isFriend($_SESSION["userid"], $userProfile["userid"])) {
                                ?>
                                    <a href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                        <!--Add friend status icon-->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-success">
                                            <path d="M8 0C3.58 0 0 3.58 0 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm-2.12 11.46l-3.54-3.54 1.41-1.41 2.12 2.12 4.24-4.24 1.41 1.41-5.65 5.65z" />
                                        </svg>
                                        <span> Friends </span>
                                    </a>
                                    <?php
                                } else {
                                    $status_req = $f->getStatusRequest($_SESSION["userid"], $userProfile["userid"]);
                                    $status_res = $f->getStatusResponse($_SESSION["userid"], $userProfile["userid"]);
                                    if ($status_req != null) {
                                        if ($status_req[0]["status"] == "Pending") {
                                    ?>
                                            <!-- cancel request -->
                                            <a href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="cancel-add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                                <!--Add friend status icon-->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="w-5" viewBox="0 0 16 16">
                                                    <path d="M8 1a7 7 0 100 14A7 7 0 008 1zM5.354 5.354a.5.5 0 01.708 0L8 8.293l2.938-2.939a.5.5 0 11.707.707L8.707 9l2.938 2.939a.5.5 0 01-.707.707L8 9.707l-2.939 2.939a.5.5 0 01-.707-.707L7.293 9 4.354 6.061a.5.5 0 010-.707z"></path>
                                                </svg>
                                                <span> Cancel request </span>
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <!-- add friend -->
                                            <a href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                                <!--Add friend status icon-->
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span> Add Friend </span>
                                            </a>
                                        <?php
                                        }
                                    }

                                    if ($status_res != null) {
                                        if ($status_res[0]["status"] == "Pending") {
                                        ?>
                                            <!--Chấp nhận hoặc Hủy yêu cầu kết bạn của ngườì khác -->
                                            <a href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="accept-add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                                <!--Add friend status icon-->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="w-5" viewBox="0 0 16 16">
                                                    <path d="M8 1a7 7 0 100 14A7 7 0 008 1zM5.354 5.354a.5.5 0 01.708 0L8 8.293l2.938-2.939a.5.5 0 11.707.707L8.707 9l2.938 2.939a.5.5 0 01-.707.707L8 9.707l-2.939 2.939a.5.5 0 01-.707-.707L7.293 9 4.354 6.061a.5.5 0 010-.707z"></path>
                                                </svg>
                                                <span> Accept </span>
                                            </a>
                                            <a href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="delete-add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                                <!--Add friend status icon-->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="w-5" viewBox="0 0 16 16">
                                                    <path d="M8 1a7 7 0 100 14A7 7 0 008 1zM5.354 5.354a.5.5 0 01.708 0L8 8.293l2.938-2.939a.5.5 0 11.707.707L8.707 9l2.938 2.939a.5.5 0 01-.707.707L8 9.707l-2.939 2.939a.5.5 0 01-.707-.707L7.293 9 4.354 6.061a.5.5 0 010-.707z"></path>
                                                </svg>
                                                <span> Delete Request </span>
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <!-- add friend -->
                                            <a href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                                <!--Add friend status icon-->
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span> Add Friend </span>
                                            </a>
                                        <?php
                                        }
                                    }
                                    if ($status_req == null && $status_res == null) {
                                        ?>
                                        <!-- add friend -->
                                        <a href="#" data-userid="<?php echo $userProfile["userid"]; ?>" class="add-friend-btn flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5 hover:text-white">
                                            <!--Add friend status icon-->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span> Add Friend </span>
                                        </a>
                                <?php
                                    }
                                }
                                ?>

                                <?php
                                $isFriend = $f->isFriend($_SESSION["userid"], $userProfile["userid"]);
                                if ($isFriend) {
                                ?>
                                    <!-- more icon -->
                                    <a href="#" class="flex items-center justify-center h-10 w-10 rounded-md bg-gray-100">
                                        <ion-icon name="ellipsis-horizontal" class="text-xl">···</ion-icon>
                                    </a>
                                    <!-- more drowpdown -->
                                    <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small; offset:5">
                                        <ul class="space-y-1">
                                            <li>
                                                <a href="#" data-profileid="<?php echo $userProfile["userid"] ?>" class="unfriend-btn flex items-center px-3 py-2 text-red-500 hover:bg-red-50 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                                    <ion-icon name="stop-circle-outline" class="pr-2 text-xl"></ion-icon> Unfriend
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php
                                } ?>
                            </div>

                        </div>

                    </div>




                    <div class="uk-switcher lg:mt-8 mt-4" id="timeline-tab">

                        <!-- Timeline -->
                        <div class="md:flex md:space-x-6 lg:mx-16">
                            <div class="space-y-5 flex-shrink-0 md:w-7/12" id="PostContaier">

                                <!-- create post  -->
                                <div class="card lg:mx-0 p-5" style="font-weight: bold; text-align: center;">
                                    <div class="flex space-x-3">
                                        <span>Bài viết trên dòng thời gian</span>
                                    </div>
                                </div>



                                <!------------------------------------------------------------------------------------------------------------------------------------------------->
                                <!-- Post with picture -->
                                <?php

                                if ($post != null) {
                                    $isFriend = $f->isFriend($userCurrent["userid"], $userProfile["userid"]);
                                    for ($i = 0; $i < sizeof($post); $i++) {
                                        $like = $p->getLikePost($post[$i]["postid"]);
                                        $comment = $p->getCommentPost($post[$i]["postid"]);
                                        $quantityCmt = $p->getQuantityCommentPost($post[$i]["postid"])[0]["total"];
                                        $isFriendCondition = ($isFriend == 1 && $post[$i]['privacy'] == "Friend");
                                        $isFriendPrivacy = $post[$i]['privacy'] == "Friend";
                                        $isPublicCondition = $post[$i]['privacy'] == "Public";
                                        $isPrivateCondition = $post[$i]['privacy'] == "Private";
                                        $isPostCondition = $post[$i]['type'] == "post";
                                        $isPostShareCondition = $post[$i]['type'] == "share";
                                        if (($isFriendCondition || $isPublicCondition) && $isPostCondition) {
                                            $t = new Timer();
                                            $time = $t->TimeSince($post[$i]["date"]); // Return array
                                            $hours = $time["hours"];
                                            $minutes = $time["minutes"];
                                            $seconds = $time["seconds"];
                                            // Upload picture
                                ?>

                                            <div class="card post-card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $post[$i]["postid"] ?>">
                                                <!-- post header-->
                                                <div class="flex justify-between items-center lg:p-4 p-2.5">
                                                    <div class="flex flex-1 items-center space-x-4">
                                                        <a href="#">
                                                            <img src="<?php echo $userProfile["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                                        </a>
                                                        <div class="flex-1 font-semibold capitalize">
                                                            <a href="#" class="text-black dark:text-gray-100"> <?php echo $userProfile["first_name"] . " " . $userProfile["last_name"] ?> </a>
                                                            <div class="text-gray-700 flex items-center space-x-2"><span><?php if ($hours <= 0)
                                                                                                                                echo $minutes . " phút trước";
                                                                                                                            else if ($hours >= 24)
                                                                                                                                echo floor($hours / 24) . " ngày trước";
                                                                                                                            else
                                                                                                                                echo $hours . " h " . $minutes . " phút trước";
                                                                                                                            ?></span>
                                                                <?php
                                                                if ($isPublicCondition) {
                                                                ?>
                                                                    <ion-icon name="earth"></ion-icon>
                                                                <?php
                                                                }
                                                                if ($isFriendCondition) {
                                                                ?>
                                                                    <ion-icon name="people"></ion-icon>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- Show Text Post -->
                                                <div class="p-5 pt-0 border-b dark:border-gray-700">
                                                    <?php echo $post[$i]["post"]; ?>
                                                </div>

                                                <!-- Show Image/Video Post -->
                                                <div uk-lightbox>
                                                    <div class="grid grid-cols-2 gap-2 px-5">
                                                        <?php
                                                        if ($post[$i]["media"] != null) {
                                                            $media_json = $post[$i]["media"];
                                                            $media = json_decode($media_json, true);
                                                            for ($j = 0; $j < sizeof($media); $j++) {
                                                                $fileInfo = pathinfo($media[$j]);
                                                                // Lấy phần mở rộng của tên tệp và chuyển nó thành chữ thường
                                                                $fileExtension = strtolower($fileInfo['extension']);
                                                                if ($fileExtension === 'jpg' || $fileExtension === 'jpeg' || $fileExtension === 'png' || $fileExtension === 'webp' || $fileExtension === 'gif') {
                                                        ?>
                                                                    <a href="uploads/posts/<?php echo $media[$j]; ?>" class="col-span-3 relative">
                                                                        <img src="uploads/posts/<?php echo $media[$j]; ?>" alt="<?php echo $media[$j]; ?>" class="rounded-md w-full lg:h-76 object-cover">

                                                                    </a>
                                                                <?php
                                                                } else if ($fileExtension === 'mp4' || $fileExtension === 'avi' || $fileExtension === 'mkv') {
                                                                ?>
                                                                    <div class="w-full h-full">
                                                                        <video controls>
                                                                            <source src="uploads/posts/<?php echo $media[$j]; ?>" type="video/mp4">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    </div>


                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <a href="assets/images/post/img-4.jpg">
                                                        <img src="assets/images/post/img-2.jpg" alt="" class="rounded-md w-full h-full">
                                                    </a>
                                                    <a href="assets/images/post/img-4.jpg" class="relative">
                                                        <img src="assets/images/post/img-3.jpg" alt="" class="rounded-md w-full h-full">
                                                        <div class="absolute bg-gray-900 bg-opacity-30 flex justify-center items-center text-white rounded-md inset-0 text-2xl"> + 15 more </div>
                                                    </a> -->

                                                    </div>
                                                </div>


                                                <!--Like comment share-->
                                                <div class="p-4 space-y-3">
                                                    <?php
                                                    $liked = 0;
                                                    if ($like != null) {
                                                        for ($j = 0; $j < count($like); $j++) {
                                                            if ($like[$j]["userid"] == $userCurrent["userid"]) {
                                                                $liked = 1;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <div class="flex space-x-4 lg:font-bold" post-id="<?php echo $post[$i]["postid"] ?>" author-id="<?php echo $post[$i]["userid"] ?>">
                                                        <button type="button" class="like-post-btn flex items-center space-x-2">
                                                            <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="<?php if ($liked == 0) echo "currentColor";
                                                                                                                                    else echo "blue"; ?>" width="22" height="22" class="dark:text-gray-100">
                                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                                </svg>
                                                            </div>
                                                            <div class="like-text" style="color:<?php if ($liked == 1) echo "blue"; ?>"> Like</div>
                                                        </button>
                                                        <a href="#" uk-toggle="target: #post-details-modal" class="comment-post-btn flex items-center space-x-2" post-id="<?php echo $post[$i]["postid"] ?>">
                                                            <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <div id="quantity-comment"> Comment <?php if ($quantityCmt > 0)
                                                                                echo "(" . $quantityCmt . ")" ?> </div>
                                                        </a>
                                                        <a href="#" uk-toggle="target: #share-post-modal" class="share-post-btn flex items-center space-x-2 flex-1 justify-end">
                                                            <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                                                </svg>
                                                            </div>
                                                            <div> Share</div>
                                                        </a>
                                                    </div>
                                                    <div class="flex items-center space-x-3 pt-2">
                                                        <div class="avatar-user-like flex items-center">
                                                            <?php
                                                            if ($like != null) {
                                                                for ($j = 0; $j < 3 && $j < count($like); $j++) {
                                                                    $userlike = $user->getUser($like[$j]["userid"]);

                                                            ?>
                                                                    <img src="<?php echo $userlike["avatar_image"] ?>" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="dark:text-gray-100">
                                                            <?php
                                                            $total = $p->getQuantityLike($post[$i]["postid"]);
                                                            if ($liked == 1) {
                                                                if ($total != null && $total[0]["total"] > 1) {
                                                                    echo '<strong> You </strong> and <strong>' . ($total[0]["total"] - 1) . ' others</strong>';
                                                                } else {
                                                                    echo '<strong> You liked </strong>';
                                                                }
                                                            } else {
                                                                if ($total != null && $total[0]["total"] > 0) {
                                                                    echo '<strong>' . $total[0]["total"] . ' others</strong>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <!-- Comment container -->
                                                    <div class="border-t py-4 space-y-4 dark:border-gray-600 comment-container" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                        <?php
                                                        if ($comment != null) {
                                                            for ($c = 0; $c < sizeof($comment); $c++) {
                                                                $timer = new Timer();
                                                                $timeAgo = $timer->timeAgo($comment[$c]["date"]);
                                                                $cmt_user = $user->getUser($comment[$c]['comment_userid']);
                                                                $quantityRep = $p->getQuantityReplyComment($comment[$c]['comment_id'])[0]["total"];
                                                        ?>
                                                                <div class="flex">
                                                                    <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                                                        <a href="profile.php?uid=<?php echo $cmt_user["userid"] ?>">
                                                                            <img src="<?php echo $cmt_user["avatar_image"] ?>" alt="" class="absolute h-full rounded-full w-full">
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                                                            <a href="profile.php?uid=<?php echo $cmt_user["userid"] ?>"><b><?php echo $cmt_user["first_name"] . " " . $cmt_user["last_name"] ?></b></a>
                                                                            <p class="leading-6"><?php echo $comment[$c]["comment_msg"] ?></p>
                                                                            <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                                                        </div>
                                                                        <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                                                            <button class="reply-option-btn" commentid="<?php echo $comment[$c]["comment_id"] ?>">Reply</button>
                                                                            <button class="view-reply-btn ml-8 mt-0" commentid="<?php echo $comment[$c]["comment_id"] ?>" style="font-size: 13px;" data-next-offset="0">View replies (<?php echo $quantityRep ?>)</button>
                                                                            <span><?php echo $timeAgo ?></span>
                                                                        </div>
                                                                        <div class="reply-dropdown bg-gray-100 rounded-full relative dark:bg-gray-800 border-t" commentid="<?php echo $comment[$c]["comment_id"] ?>" post-id="<?php echo $post[$i]["postid"]; ?>" style="display: none;">
                                                                            <input placeholder="Reply <?php echo $cmt_user["last_name"] ?>" class="bg-transparent max-h-10 shadow-none px-5 reply-comment-textbox" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                                            <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                                                <button style="padding: 6px;" href="#" class="reply-comment-btn" commentid="<?php echo $comment[$c]["comment_id"] ?>" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                                                    <ion-icon name="arrow-redo-outline"></ion-icon>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="reply-comment-msg " commentid="<?php echo $comment[$c]["comment_id"] ?>">
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    if ($quantityCmt > 2) {
                                                    ?>
                                                        <a href="#" class="btn-view-more-comment hover:text-blue-600 hover:underline" data-next-offset="2">
                                                            View more <?php echo $quantityCmt - 2 ?> Comments
                                                        </a>
                                                    <?php
                                                    } else if ($quantityCmt < 0) {
                                                    ?>
                                                        <h6><span style='color:#97A5B8'>No comment yet!</span></h6>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div id="error_status" post-id="<?php echo $post[$i]["postid"]; ?> "></div>
                                                    <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                                        <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5 comment-textbox" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                        <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                            <button href="#" class="add-comment-btn" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                                <ion-icon name="send-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php
                                        } else if (($isFriendCondition || $isPublicCondition) && $isPostShareCondition) {
                                            $t = new Timer();
                                            $time = $t->TimeSince($post[$i]["date"]); // Return array
                                            $hours = $time["hours"];
                                            $minutes = $time["minutes"];
                                            $seconds = $time["seconds"];
                                            // Get user for each post
                                            $userOfPost = $userProfile;
                                        ?>
                                            <div class="card post-card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $post[$i]["postid"] ?>">
                                                <!-- post header-->
                                                <div class="flex justify-between items-center lg:p-4 p-2.5">
                                                    <div class="flex flex-1 items-center space-x-4">
                                                        <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>">
                                                            <img src="<?php echo $userOfPost["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                                        </a>
                                                        <div class="flex-1 font-semibold capitalize">
                                                            <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>" class="text-black dark:text-gray-100"> <?php echo $userOfPost["first_name"] . " " . $userOfPost["last_name"] ?></a>
                                                            <span style="font-weight: 400; text-transform: none; margin-left: 5px;"> đã chia sẻ bài viết </span>
                                                            <div class="text-gray-700 flex items-center space-x-2">
                                                                <span><?php if ($hours <= 0)
                                                                            echo $minutes . " phút trước";
                                                                        else if ($hours >= 24)
                                                                            echo floor($hours / 24) . " ngày trước";
                                                                        else
                                                                            echo $hours . " h " . $minutes . " phút trước";
                                                                        ?>
                                                                </span><?php
                                                                        if ($isPublicCondition) {
                                                                        ?>
                                                                    <ion-icon name="earth"></ion-icon>
                                                                <?php
                                                                        }
                                                                        if ($isFriendCondition) {
                                                                ?>
                                                                    <ion-icon name="people"></ion-icon>
                                                                <?php
                                                                        }
                                                                ?></ion-icon>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="post-action">
                                                        <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                                        <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Show Text Post -->
                                                <div class="p-5 pt-0 border-b dark:border-gray-700">
                                                    <?php echo $post[$i]["post"]; ?>
                                                </div>
                                                <!-- Show post share -->
                                                <div uk-lightbox>
                                                    <div class="grid grid-cols-1 gap-2 px-5">
                                                        <?php
                                                        // Lấy bài post gốc - bài được share
                                                        $postShare = $p->getAPost($post[$i]["post_share_id"])[0];
                                                        $userOfPostShare = $user->getUser($postShare["userid"]);
                                                        $t = new Timer();
                                                        $time = $t->TimeSince($postShare["date"]); // Return array
                                                        $hours = $time["hours"];
                                                        $minutes = $time["minutes"];
                                                        $seconds = $time["seconds"];
                                                        ?>
                                                        <div class="card post-card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $postShare["postid"] ?>">
                                                            <!-- Show Image/Video Post Share -->
                                                            <div uk-lightbox>
                                                                <div class="grid grid-cols-2 gap-2 px-5">
                                                                    <?php
                                                                    if ($postShare["media"] != null) {
                                                                        $media_json = $postShare["media"];
                                                                        $media = json_decode($media_json, true);
                                                                        for ($j = 0; $j < sizeof($media); $j++) {
                                                                            $fileInfo = pathinfo($media[$j]);
                                                                            // Lấy phần mở rộng của tên tệp và chuyển nó thành chữ thường
                                                                            $fileExtension = strtolower($fileInfo['extension']);
                                                                            if ($fileExtension === 'jpg' || $fileExtension === 'jpeg' || $fileExtension === 'png') {
                                                                    ?>
                                                                                <a href="uploads/posts/<?php echo $media[$j]; ?>" class="col-span-3 relative">
                                                                                    <img src="uploads/posts/<?php echo $media[$j]; ?>" alt="<?php echo $media[$j]; ?>" class="rounded-md w-full lg:h-76 object-cover">

                                                                                </a>
                                                                            <?php
                                                                            } else if ($fileExtension === 'mp4' || $fileExtension === 'avi' || $fileExtension === 'mkv') {
                                                                            ?>
                                                                                <div class="w-full h-full">
                                                                                    <video width="320" height="240" controls>
                                                                                        <source src="uploads/posts/<?php echo $media[$j]; ?>" type="video/mp4">
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
                                                                                </div>


                                                                    <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <!-- post header-->
                                                            <div class="flex justify-between items-center lg:p-4 p-2.5">
                                                                <div class="flex flex-1 items-center space-x-4">
                                                                    <a href="profile.php?uid=<?php echo $userOfPostShare["userid"] ?>">
                                                                        <img src="<?php echo $userOfPostShare["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                                                    </a>
                                                                    <div class="flex-1 font-semibold capitalize">
                                                                        <a href="profile.php?uid=<?php echo $userOfPostShare["userid"] ?>" class="text-black dark:text-gray-100">
                                                                            <?php echo $userOfPostShare["first_name"] . " " . $userOfPostShare["last_name"] ?>
                                                                        </a>
                                                                        <div class="text-gray-700 flex items-center space-x-2"><span>
                                                                                <?php if ($hours <= 0)
                                                                                    echo $minutes . " phút trước";
                                                                                else if ($hours >= 24)
                                                                                    echo floor($hours / 24) . " ngày trước";
                                                                                else
                                                                                    echo $hours . " h " . $minutes . " phút trước";
                                                                                ?></span>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Show Text Post -->
                                                            <div class="p-5 pt-0 border-b dark:border-gray-700">
                                                                <?php echo $postShare["post"] ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!--Like comment share-->
                                                <div class="p-4 space-y-3">
                                                    <?php
                                                    $liked = 0;
                                                    if ($like != null) {
                                                        for ($j = 0; $j < count($like); $j++) {
                                                            if ($like[$j]["userid"] == $userCurrent["userid"]) {
                                                                $liked = 1;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <div class="flex space-x-4 lg:font-bold" post-id="<?php echo $postShare["postid"] ?>" author-id="<?php echo $postShare["userid"] ?>">
                                                        <button type="button" class="like-post-btn flex items-center space-x-2">
                                                            <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="<?php if ($liked == 0)
                                                                                                                                        echo "currentColor";
                                                                                                                                    else
                                                                                                                                        echo "blue"; ?>" width="22" height="22" class="dark:text-gray-100">
                                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                                </svg>
                                                            </div>
                                                            <div class="like-text" style="color:<?php if ($liked == 1)
                                                                                                    echo "blue"; ?>"> Like <?php if (count($like) > 0)
                                                                                                                                echo "(" . count($like) . ")" ?> </div>
                                                        </button>
                                                        <a href="#" uk-toggle="target: #post-details-modal" class="comment-post-btn flex items-center space-x-2" post-id="<?php echo $post[$i]["postid"] ?>">
                                                            <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <div id="quantity-comment"> Comment <?php if ($quantityCmt > 0)
                                                                                echo "(" . $quantityCmt . ")" ?> </div>
                                                        </a>
                                                        <a href="#" uk-toggle="target: #share-post-modal" class="share-post-btn flex items-center space-x-2 flex-1 justify-end">
                                                            <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                                                </svg>
                                                            </div>
                                                            <div> Share</div>
                                                        </a>
                                                    </div>
                                                    <div class="flex items-center space-x-3 pt-2">
                                                        <div class="avatar-user-like flex items-center">
                                                            <?php
                                                            if ($like != null) {
                                                                for ($j = 0; $j < 3 && $j < count($like); $j++) {
                                                                    $userlike = $user->getUser($like[$j]["userid"]);

                                                            ?>
                                                                    <img src="<?php echo $userlike["avatar_image"] ?>" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="dark:text-gray-100">
                                                            <?php
                                                            $total = $p->getQuantityLike($post[$i]["postid"]);
                                                            if ($liked == 1) {
                                                                if ($total != null && $total[0]["total"] > 1) {
                                                                    echo '<strong> You </strong> and <strong>' . ($total[0]["total"] - 1) . ' others</strong>';
                                                                } else {
                                                                    echo '<strong> You liked </strong>';
                                                                }
                                                            } else {
                                                                if ($total != null && $total[0]["total"] > 0) {
                                                                    echo '<strong>' . $total[0]["total"] . ' others</strong>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <!-- Comment container -->
                                                    <div class="border-t py-4 space-y-4 dark:border-gray-600 comment-container" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                        <?php
                                                        if ($comment != null) {
                                                            for ($c = 0; $c < sizeof($comment); $c++) {
                                                                $timer = new Timer();
                                                                $timeAgo = $timer->timeAgo($comment[$c]["date"]);
                                                                $cmt_user = $user->getUser($comment[$c]['comment_userid']);
                                                                $quantityRep = $p->getQuantityReplyComment($comment[$c]['comment_id'])[0]["total"];
                                                        ?>
                                                                <div class="flex">
                                                                    <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                                                        <a href="profile.php?uid=<?php echo $cmt_user["userid"] ?>">
                                                                            <img src="<?php echo $cmt_user["avatar_image"] ?>" alt="" class="absolute h-full rounded-full w-full">
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                                                            <a href="profile.php?uid=<?php echo $cmt_user["userid"] ?>"><b><?php echo $cmt_user["first_name"] . " " . $cmt_user["last_name"] ?></b></a>
                                                                            <p class="leading-6"><?php echo $comment[$c]["comment_msg"] ?></p>
                                                                            <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                                                        </div>
                                                                        <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                                                            <button class="reply-option-btn" commentid="<?php echo $comment[$c]["comment_id"] ?>">Reply</button>
                                                                            <button class="view-reply-btn ml-8 mt-0" commentid="<?php echo $comment[$c]["comment_id"] ?>" style="font-size: 13px;" data-next-offset="0">View replies (<?php echo $quantityRep ?>)</button>
                                                                            <span><?php echo $timeAgo ?></span>
                                                                        </div>
                                                                        <div class="reply-dropdown bg-gray-100 rounded-full relative dark:bg-gray-800 border-t" commentid="<?php echo $comment[$c]["comment_id"] ?>" post-id="<?php echo $post[$i]["postid"]; ?>" style="display: none;">
                                                                            <input placeholder="Reply <?php echo $cmt_user["last_name"] ?>" class="bg-transparent max-h-10 shadow-none px-5 reply-comment-textbox" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                                            <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                                                <button style="padding: 6px;" href="#" class="reply-comment-btn" commentid="<?php echo $comment[$c]["comment_id"] ?>" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                                                    <ion-icon name="arrow-redo-outline"></ion-icon>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="reply-comment-msg " commentid="<?php echo $comment[$c]["comment_id"] ?>">
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    if ($quantityCmt > 2) {
                                                    ?>
                                                        <a href="#" class="btn-view-more-comment hover:text-blue-600 hover:underline" data-next-offset="2">
                                                            View more <?php echo $quantityCmt - 2 ?> Comments
                                                        </a>
                                                    <?php
                                                    } else if ($quantityCmt < 0) {
                                                    ?>
                                                        <h6><span style='color:#97A5B8'>No comment yet!</span></h6>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div id="error_status" post-id="<?php echo $post[$i]["postid"]; ?> "></div>
                                                    <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                                        <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5 comment-textbox" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                        <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                            <button href="#" class="add-comment-btn" post-id="<?php echo $post[$i]["postid"]; ?>">
                                                                <ion-icon name="send-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                <?php
                                        }
                                    }
                                } else {
                                    echo '<div style="text-align: center">Không có bài viết</div>';
                                }
                                ?>



                            </div>

                            <!-- Sidebar -->
                            <div class="w-full space-y-6">

                                <div class="widget card p-5">
                                    <h4 class="text-lg font-semibold"> About
                                        <i class="fa fa-edit edit-about-btn" style="margin-left: 10px; cursor: pointer;" title="Change About"></i>
                                    </h4>
                                    <ul class="text-gray-600 space-y-3 mt-3">
                                        <?php
                                        if ($about != null) {
                                        ?>
                                            <li class="flex items-center space-x-2">
                                                <ion-icon name="home"></ion-icon>
                                                <!-- <ion-icon name="home" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                                Live In <strong> <?php echo $about["address"] ?> </strong>
                                            </li>
                                        <?php
                                        }
                                        if ($about != null && $about["birthday"] != NULL) {
                                            $formattedDate = date("d-m-Y", strtotime($about["birthday"]));
                                        ?>
                                            <li class="flex items-center space-x-2">
                                                <ion-icon name="calendar"></ion-icon>
                                                <!-- <ion-icon name="home-sharp" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                                Birthday <strong> <?php echo $formattedDate ?> </strong>
                                            <?php
                                        } else {
                                            echo '<li class="flex items-center space-x-2">
                                        <ion-icon name="calendar"></ion-icon>
                                        <!-- <ion-icon name="home-sharp" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                        Birthday ';
                                        }
                                        if ($about != null) {
                                            ?>
                                            <li class="flex items-center space-x-2">
                                                <ion-icon name="school"></ion-icon>
                                                <!-- <ion-icon name="home-sharp" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                                Education <strong> <?php echo $about["edu"] ?> </strong>
                                            <?php
                                        } else {
                                            echo '<li class="flex items-center space-x-2">
                                        <ion-icon name="school"></ion-icon>
                                        <!-- <ion-icon name="home-sharp" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                        Education </li>';
                                        }
                                        if ($about != null) {
                                            ?>
                                            <li class="flex items-center space-x-2">
                                                <ion-icon name="planet"></ion-icon>
                                                <!-- <ion-icon name="information-circle" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                                Bio <strong> <?php echo $about["desc"] ?> </strong>
                                            <?php
                                        } else {
                                            echo '<li class="flex items-center space-x-2">
                                        <ion-icon name="planet"></ion-icon>
                                        <!-- <ion-icon name="information-circle" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                        Bio </li>';
                                        }
                                            ?>
                                            <!-- <li class="flex items-center space-x-2">
                                        <ion-icon name="globe" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon>
                                        From <strong> Aden , Yemen </strong>
                                    </li> -->
                                            <!-- <li class="flex items-center space-x-2">
                                        <ion-icon name="heart-sharp" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon>
                                        From <strong> Relationship </strong>
                                    </li> -->
                                            <!-- <li class="flex items-center space-x-2">
                                        <ion-icon name="logo-rss" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon>
                                        Flowwed By <strong> 3,240 People </strong>
                                    </li> -->
                                    </ul>
                                    <div class="gap-3 grid grid-cols-3 mt-4">
                                        <!-- <img src="assets/images/avatars/avatar-lg-2.jpg" alt="" class="object-cover rounded-lg col-span-full">
                                    <img src="assets/images/avatars/avatar-2.jpg" alt="" class="rounded-lg">
                                    <img src="assets/images/avatars/avatar-4.jpg" alt="" class="rounded-lg">
                                    <img src="assets/images/avatars/avatar-5.jpg" alt="" class="rounded-lg"> -->
                                        <?php
                                        if ($about != null && $about["about_image"] != null) {
                                            $images = json_decode($about["about_image"]);
                                            for ($i = 0; $i < 4 && $i < sizeof($images); $i++) {
                                                if ($i == 0) {
                                                    echo "<img src='uploads/avatars/" . $images[$i] . "' style='cursor: pointer' class='about-image object-cover rounded-lg col-span-full'>";
                                                } else {
                                                    echo "<img src='uploads/avatars/" . $images[$i] . "' style='cursor: pointer' class='about-image rounded-lg'>";
                                                }
                                            }
                                        }
                                        ?>
                                    </div>

                                </div>

                                <div class="widget card p-5 border-t">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-lg font-semibold"> Friends </h4>
                                            <p class="text-sm"> <?php echo $f->getQuantityFriend($userProfile["userid"]) . " Friends" ?> </p>
                                        </div>
                                        <a href="#" class="text-blue-600 ">See all</a>
                                    </div>

                                    <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                                        <?php
                                        for ($i = 0; $i < sizeof($friendProfiles); $i++) {
                                            $friendProfile = $user->getUser($friendProfiles[$i]["friend_id"]);
                                        ?>
                                            <a href="profile.php?uid=<?php echo $friendProfile["userid"] ?>">
                                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2">
                                                    <img src="<?php echo $friendProfile["avatar_image"] ?>" alt="" class="w-full h-full object-cover absolute">
                                                </div>
                                                <div class="text-sm truncate"> <?php echo $friendProfile["first_name"] . " " . $friendProfile["last_name"] ?> </div>
                                            </a>

                                        <?php
                                        } ?>

                                    </div>
                                    <a href="#" class="button gray mt-3 w-full" useridProfile="<?php $userProfile['userid'] ?>"> See all </a>
                                </div>



                            </div>
                        </div>

                        <!-- Friends  -->
                        <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                            <h2 class="text-xl font-bold"> Friends</h2>

                            <nav class="responsive-nav border-b">
                                <ul>
                                    <li class="tab all-friend-tab active"><a href="" class="lg:px-2"> All Friends <span> <?php echo $f->getQuantityFriend($userProfile["userid"]) ?> </span> </a></li>
                                    <li class="tab recently-tab"><a href="#" class="lg:px-2"> Recently added </a></li>
                                </ul>
                            </nav>
                            <div class="tab-content all-friend">

                                <div class="grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-2 gap-y-4 mt-3 list-friends">
                                    <?php
                                    for ($i = 0; $i < sizeof($friendProfiles); $i++) {
                                        $friend = $user->getUser($friendProfiles[$i]["friend_id"]);
                                    ?>
                                        <div class="card p-2">
                                            <a href="profile.php?uid=<?php echo $friend["userid"] ?>">
                                                <img src="<?php echo $friend["avatar_image"] ?>" class="h-36 object-cover rounded-md shadow-sm w-full">
                                            </a>
                                            <div class="pt-3 px-1">
                                                <a href="profile.php?uid=<?php echo $friend["userid"] ?>" class="text-base font-semibold mb-0.5"> <?php echo $friend["first_name"] . " " . $friend["last_name"] ?> </a>
                                                <p class="font-medium text-sm"><?php echo $f->getQuantityFriend($friend["userid"]) . " Friend" ?> </p>
                                                <button class="bg-blue-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md text-blue-600 text-sm mb-1">
                                                    Friend
                                                </button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <?php
                                if (sizeof($f->getListFriend($userProfile['userid'])) > 8) {
                                ?>
                                    <div class="flex justify-center mt-6">
                                        <a data-profileid=<?php echo $userProfile['userid'] ?> href="#" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white load-them">
                                            Load more ..</a>

                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- // Tab recently friend -->
                            <div class="tab-content recently" style="display: none;">
                                <div class="grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-2 gap-y-4 mt-3">
                                    <?php
                                    $recentlyFriends = $f->getRecentlyFriend($userProfile["userid"]);
                                    for ($i = 0; $i < sizeof($recentlyFriends); $i++) {
                                        $friend = $user->getUser($recentlyFriends[$i]["friend_id"]);
                                    ?>
                                        <div class="card p-2">
                                            <a href="profile.php?uid=<?php echo $friend["userid"] ?>">
                                                <img src="<?php echo $friend["avatar_image"] ?>" class="h-36 object-cover rounded-md shadow-sm w-full">
                                            </a>
                                            <div class="pt-3 px-1">
                                                <a href="profile.php?uid=<?php echo $friend["userid"] ?>" class="text-base font-semibold mb-0.5"> <?php echo $friend["first_name"] . " " . $friend["last_name"] ?> </a>
                                                <p class="font-medium text-sm"><?php echo $f->getQuantityFriend($friend["userid"]) . " Friend" ?></p>
                                                <button class="bg-blue-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md text-blue-600 text-sm mb-1">
                                                    Friend
                                                </button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <a href="#" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                        Load more ..</a>
                                </div>
                            </div>


                        </div>
                        <!-- Photos  -->
                        <div class="card md:p-6 p-2 max-w-3xl mx-auto" id="result">

                        </div>
                        <!-- Pages  -->
                        <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                            <h2 class="text-xl font-bold"> Pages</h2>
                            <nav class="responsive-nav border-b md:m-0 -mx-4">
                                <ul>
                                    <li class="active"><a href="#" class="lg:px-2"> Following </a></li>
                                    <li><a href="#" class="lg:px-2"> Newest </a></li>
                                    <li><a href="#" class="lg:px-2"> My pages</a></li>
                                    <li><a href="#" class="lg:px-2"> Suggestions</a></li>
                                </ul>
                            </nav>

                            <div class="grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4 mt-5">

                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-4.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5"> John Michael </a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>

                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-3.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5">
                                            Alex Dolgove </a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>

                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-5.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5"> Dennis Han </a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>
                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-7.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5"> Monroe Parker </a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>
                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-6.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5"> Erica Jones </a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>
                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-2.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5"> Stella Johnson</a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>
                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-4.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5"> John Michael </a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>

                                <div class="card">
                                    <a href="timeline-page.html">
                                        <img src="assets/images/avatars/avatar-3.jpg" class="h-36 object-cover rounded-t-md shadow-sm w-full">
                                    </a>
                                    <div class="p-3">
                                        <a href="timeline-page.html" class="text-base font-semibold mb-0.5">
                                            Alex Dolgove </a>
                                        <p class="font-medium text-sm">843K Following </p>
                                        <button class="bg-gray-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md  text-sm">
                                            Following
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="flex justify-center mt-6">
                                <a href="#" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                    Load more ..</a>
                            </div>

                        </div>

                        <!-- Groups  -->
                        <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                            <div class="flex justify-between items-start relative md:mb-4 mb-3">
                                <div class="flex-1">
                                    <h2 class="text-xl font-bold"> Groups </h2>
                                    <nav class="responsive-nav style-2 md:m-0 -mx-4">
                                        <ul>
                                            <li class="active"><a href="#"> Joined <span> 230</span> </a></li>
                                            <li><a href="#"> My Groups </a></li>
                                            <li><a href="#"> Discover </a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <a href="create-group.html" data-tippy-placement="left" data-tippy="" data-original-title="Create New Album" class="bg-blue-100 font-semibold py-2 px-6 rounded-md text-sm md:mt-0 mt-3 text-blue-600">
                                    Create
                                </a>
                            </div>

                            <div class="grid md:grid-cols-2  grid-cols-2 gap-x-2 gap-y-4 mt-3">

                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize">Graphic Design </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>
                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize"> Mountain Riders </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>
                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-2.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize"> Coffee Addicts </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>
                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-5.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize"> Property Rent </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>
                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-1.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize"> Architecture </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>
                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize">Graphic Design </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>
                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize"> Mountain Riders </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>
                                <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                    <a href="timeline-group.html" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="assets/images/group/group-2.jpg" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-page.html" class="text-base font-semibold capitalize"> Coffee Addicts </a>
                                        <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                    </div>
                                    <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                        Following
                                    </button>
                                </div>

                            </div>

                            <div class="flex justify-center mt-6">
                                <a href="#" class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                    Load more ..</a>
                            </div>

                        </div>

                        <!-- Videos -->
                        <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                            <h2 class="text-xl font-semibold"> Friend</h2>
                            <nav class="responsive-nav border-b">
                                <ul>
                                    <li class="active"><a href="#" class="lg:px-2"> Suggestions </a></li>
                                    <li><a href="#" class="lg:px-2"> Newest </a></li>
                                    <li><a href="#" class="lg:px-2"> My Videos </a></li>
                                </ul>
                            </nav>

                            <div class="grid md:grid-cols-3 grid-cols-2  gap-x-2 gap-y-4 mt-3">
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-1.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-2.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-3.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-4.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-5.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>

                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-6.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-3.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-2.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="video-watch.html" class="w-full h-36 overflow-hidden rounded-lg relative block">
                                        <img src="assets/images/video/img-4.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                        <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                    </a>
                                </div>
                            </div>

                            <div class="flex justify-center mt-6">
                                <a href="#" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                    Load more ..</a>
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        <?php
        } else {
            echo "<div style='text-align: center; margin-top: 50px' class='main_content'>Người dùng hiện đang ở chế độ riêng tư.</div>";
        }
        ?>

    </div>

    <!--share post-->
    <div id="share-post-modal" style="overflow-y: scroll !important" class="create-post" uk-modal>
        <div style="width: 600px;" class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">

            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Share Post </h3>
                <button id="closeModelPost" class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img src="<?php echo $userCurrent["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-2">
                    <textarea name="taPostShare" class="uk-textare text-black shadow-none focus:shadow-none text-xl font-medium resize-none" rows="5" placeholder="You want to share what from this article?"></textarea>
                </div>
            </div>
            <div style="text-align: center; font-family: 500;">You are sharing this article.</div>
            <div class="share-details-card">
                <!-- Append post share details here -->
            </div>
            <div class="flex items-center w-full justify-between p-3 border-t">
                <select class="selectpicker mt-2 col-4 story">
                    <option selected>Public</option>
                    <option>Friend</option>
                    <option>Private</option>
                </select>
                <div class="flex space-x-2">
                    <a style="cursor: pointer; color: whitesmoke;" class="btn-share-post bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium">
                        Share </a>
                </div>

                <a hidden class="btn-share-post bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold">
                    Share </a>
            </div>
        </div>
    </div>

    <!-- Post details modal-->
    <div id="post-details-modal" style="overflow-y: scroll;" class="create-post" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> [Name]'s post </h3>
                <button id="closeModelPost" class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <div class="post-details-card">
                <!-- Append post details here -->
            </div>
        </div>
    </div>

    <div class="scroll-to-top start-chat" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
            <path fill="currentColor" d="m13 5.586l-4.707 4.707a.999.999 0 1 0 1.414 1.414L12 9.414V17a1 1 0 1 0 2 0V9.414l2.293 2.293a.997.997 0 0 0 1.414 0a.999.999 0 0 0 0-1.414z" />
        </svg>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include("./Websocket/src/Notification.php") ?>
    <!-- For Night mode -->
    <script>
        $(".tab").click(function(e) {
            e.preventDefault();
            $(".tab").removeClass("active");
            $(this).addClass("active");
            $(".tab-content").hide();
            if ($(this).hasClass("recently-tab")) {
                $(".recently").show();
            }
            if ($(this).hasClass("all-friend-tab")) {
                $(".all-friend").show();
            }
        })
    </script>

    <!-- Javascript
    ================================================== -->

    <script src="Js/Global.js"></script>
    <script src="Js/Profile.js"></script>
    <script src="Js/Post.js"></script>
    <script src="Js/notification.js"></script>
    <script src="Js/Friend.js"></script>
    <script src="../../code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</body>

<!-- Mirrored from demo.foxthemes.net/socialite/timeline.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:42:27 GMT -->

</html>