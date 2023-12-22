<?php
include_once("Classes/user.php");
include_once("Classes/post.php");
include_once("Classes/timer.php");
include_once("Classes/friend.php");
include_once("Classes/message.php");
include("Classes/notification.php");
$notify = new Notification();
session_start();
$userCurrent = null;
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
} else {
    $user = new User();
    $userCurrent = $user->getUser($_SESSION["userid"]); // Return Array (userCurrent = result[0])
    $f = new Friend();
    $friends = $f->getListFriend($userCurrent["userid"]);
    // Post
    $p = new Post();
    if (isset($_REQUEST['p'])) {
        $postid = $_GET["p"];
        $post = $p->getAPost($postid);
    } else {
        $post = null;
    }
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
    <title>Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Socialite is - Professional A unique and beautiful collection of UI elements">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="assets/css/icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
    <input name="txtUserid" type="hidden" value="<?php echo $userCurrent["userid"] ?>">
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
                    <li><a href="albums.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-purple-500">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg> <span> Photos </span></a>
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
                <!--  Feeds  -->
                <div class="lg:flex lg:space-x-10">
                    <div class="lg:w-3/4 lg:px-20 space-y-7">
                        <!------------------------------------------------------------------------------------------------------------------------------------------------->
                        <!-- Post with picture -->
                        <?php
                        if ($post != null) {
                            $like = $p->getLikePost($post[0]["postid"]);
                            $comment = $p->getCommentPost($post[0]["postid"]);
                            $quantityCmt = $p->getQuantityCommentPost($post[0]["postid"])[0]["total"];
                            $isFriend = $f->isFriend($userCurrent["userid"], $post[0]["userid"]);
                            $isFriendCondition = ($isFriend == 1 && $post[0]['privacy'] == "Friend");
                            $isPublicCondition = $post[0]['privacy'] == "Public";
                            $isPrivateCondition = $post[0]['privacy'] == "Private";
                            $isPostCondition = $post[0]['type'] == "post";
                            $isPostShareCondition = $post[0]['type'] == "share";
                            $isOwnPostCondition = $post[0]['userid'] == $userCurrent["userid"];
                            if ($isPrivateCondition || !$isFriendCondition && !$isOwnPostCondition) {
                                echo "<div style='font-weight: 500; font-size: 18px'>Bài viết không tồn tại hoặc đang được đặt ở chế độ riêng tư!</div>";
                            }

                            if (($isFriendCondition || $isPublicCondition) && $isPostCondition) {
                                $t = new Timer();
                                $time = $t->TimeSince($post[0]["date"]); // Return array
                                $hours = $time["hours"];
                                $minutes = $time["minutes"];
                                $seconds = $time["seconds"];
                                // Get user for each post
                                $userOfPost = $user->getUser($post[0]["userid"]);
                        ?>

                                <div class="card post-card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $post[0]["postid"] ?>">

                                    <!-- post header-->
                                    <div class="flex justify-between items-center lg:p-4 p-2.5">
                                        <div class="flex flex-1 items-center space-x-4">
                                            <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>">
                                                <img src="<?php echo $userOfPost["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                            </a>
                                            <div class="flex-1 font-semibold capitalize">
                                                <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>" class="text-black dark:text-gray-100"> <?php echo $userOfPost["first_name"] . " " . $userOfPost["last_name"] ?> </a>
                                                <div class="text-gray-700 flex items-center space-x-2"><span><?php echo $t->timeAgo($post[0]["date"])
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
                                                    if ($isPrivateCondition) {
                                                    ?>
                                                        <ion-icon name="lock-closed"></ion-icon>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-action">
                                            <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                            <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">

                                                <ul class="space-y-1">
                                                    <!-- <li>
                                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                                <i class="uil-share-alt mr-1"></i> Share
                                                            </a>
                                                        </li> -->
                                                    <?php
                                                    if ($userOfPost["userid"] ==  $userCurrent["userid"]) {
                                                    ?>
                                                        <li uk-toggle="target: #edit-post-modal" post-id="<?php echo $post[0]["postid"] ?>">
                                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                                <i class="uil-edit-alt mr-1"></i> Edit Post
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                                <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                                    <path d="M224 64c-44.2 0-80 35.8-80 80v48H384c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80V144C80 64.5 144.5 0 224 0c57.5 0 107 33.7 130.1 82.3c7.6 16 .8 35.1-15.2 42.6s-35.1 .8-42.6-15.2C283.4 82.6 255.9 64 224 64zm32 320c17.7 0 32-14.3 32-32s-14.3-32-32-32H192c-17.7 0-32 14.3-32 32s14.3 32 32 32h64z" />
                                                                </svg> Privacy
                                                            </a>
                                                        </li>
                                                        <!-- <li>
                                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                                <i class="uil-comment-slash mr-1"></i> Disable comments
                                                            </a>

                                                        </li> -->
                                                    <?php
                                                    }
                                                    ?>
                                                    <!-- <li>
                                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                            <i class="uil-favorite mr-1"></i> Add favorites
                                                        </a>
                                                    </li> -->
                                                    <li>
                                                        <hr class="-mx-2 my-2 dark:border-gray-800">
                                                    </li>
                                                    <?php
                                                    if ($userOfPost["userid"] ==  $userCurrent["userid"]) {
                                                    ?>
                                                        <li data-post-id="<?php echo $post[0]["postid"] ?>" onclick="deletePost(event, this)">
                                                            <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                                                <i class="uil-trash-alt mr-1"></i> Delete
                                                            </a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Show Text Post -->
                                    <div class="p-5 pt-0 border-b dark:border-gray-700">
                                        <?php echo $post[0]["post"]; ?>
                                    </div>

                                    <!-- Show Image/Video Post -->
                                    <div uk-lightbox>
                                        <div class="grid grid-cols-1 gap-2 px-5">
                                            <?php
                                            if ($post[0]["media"] != null) {
                                                $media_json = $post[0]["media"];
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
                                                    } else  if ($fileExtension === 'mp4' || $fileExtension === 'avi' || $fileExtension === 'mkv') {
                                                    ?>
                                                        <div class="w-full h-full">
                                                            <video width="668" height="420" controls>
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
                                        <div class="flex space-x-4 lg:font-bold" post-id="<?php echo $post[0]["postid"] ?>" author-id="<?php echo $post[0]["userid"] ?>">
                                            <button type="button" class="like-post-btn flex items-center space-x-2">
                                                <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="<?php if ($liked == 0) echo "currentColor";
                                                                                                                        else echo "blue"; ?>" width="22" height="22" class="dark:text-gray-100">
                                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                    </svg>
                                                </div>
                                                <div class="like-text" style="color:<?php if ($liked == 1) echo "blue"; ?>"> Like</div>
                                            </button>
                                            <a href="#" uk-toggle="target: #post-details-modal" class="comment-post-btn flex items-center space-x-2" post-id="<?php echo $post[0]["postid"] ?>">
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
                                                $total = $p->getQuantityLike($post[0]["postid"]);
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
                                        <div class="border-t py-4 space-y-4 dark:border-gray-600 comment-container" post-id="<?php echo $post[0]["postid"]; ?>">
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
                                                            <div class="reply-dropdown bg-gray-100 rounded-full relative dark:bg-gray-800 border-t" commentid="<?php echo $comment[$c]["comment_id"] ?>" post-id="<?php echo $post[0]["postid"]; ?>" style="display: none;">
                                                                <input placeholder="Reply <?php echo $cmt_user["last_name"] ?>" class="bg-transparent max-h-10 shadow-none px-5 reply-comment-textbox" post-id="<?php echo $post[0]["postid"]; ?>">
                                                                <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                                    <button style="padding: 6px;" href="#" class="reply-comment-btn" commentid="<?php echo $comment[$c]["comment_id"] ?>" post-id="<?php echo $post[0]["postid"]; ?>">
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
                                        <div id="error_status" post-id="<?php echo $post[0]["postid"]; ?> "></div>
                                        <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                            <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5 comment-textbox" post-id="<?php echo $post[0]["postid"]; ?>">
                                            <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                <button href="#" class="add-comment-btn" post-id="<?php echo $post[0]["postid"]; ?>">
                                                    <ion-icon name="send-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php
                            } else if (($isFriendCondition || $isPublicCondition || $isOwnPostCondition) && $isPostShareCondition) {
                                $t = new Timer();
                                $time = $t->TimeSince($post[0]["date"]); // Return array
                                $hours = $time["hours"];
                                $minutes = $time["minutes"];
                                $seconds = $time["seconds"];
                                // Get user for each post
                                $userOfPost = $user->getUser($post[0]["userid"]);
                            ?>

                                <div class="card post-card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $post[0]["postid"] ?>">
                                    <!-- post header-->
                                    <div class="flex justify-between items-center lg:p-4 p-2.5">
                                        <div class="flex flex-1 items-center space-x-4">
                                            <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>">
                                                <img src="<?php echo $userOfPost["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                            </a>
                                            <div class="flex-1 font-semibold capitalize">
                                                <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>" class="text-black dark:text-gray-100"> <?php echo $userOfPost["first_name"] . " " . $userOfPost["last_name"] ?></a>
                                                <span style="font-weight: 400; text-transform: none; margin-left: 5px;"> đã chia sẻ bài viết </span>
                                                <div class="text-gray-700 flex items-center space-x-2"><span><?php echo $t->timeAgo($post[$i]["date"])
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
                                                    if ($isPrivateCondition) {
                                                    ?>
                                                        <ion-icon name="lock-closed"></ion-icon>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-action">
                                            <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                            <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">

                                                <ul class="space-y-1">
                                                    <li>
                                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                            <i class="uil-share-alt mr-1"></i> Share
                                                        </a>
                                                    </li>
                                                    <?php
                                                    if ($userOfPost["userid"] ==  $userCurrent["userid"]) {
                                                    ?>
                                                        <li class="post-action-edit" uk-toggle="target: #edit-post-modal" post-id="<?php echo $post[0]["postid"] ?>">
                                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                                <i class="uil-edit-alt mr-1"></i> Edit Post
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                                <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                                    <path d="M224 64c-44.2 0-80 35.8-80 80v48H384c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80V144C80 64.5 144.5 0 224 0c57.5 0 107 33.7 130.1 82.3c7.6 16 .8 35.1-15.2 42.6s-35.1 .8-42.6-15.2C283.4 82.6 255.9 64 224 64zm32 320c17.7 0 32-14.3 32-32s-14.3-32-32-32H192c-17.7 0-32 14.3-32 32s14.3 32 32 32h64z" />
                                                                </svg> Privacy
                                                            </a>
                                                        </li>
                                                        <!-- <li>
                                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                            <i class="uil-comment-slash mr-1"></i> Disable comments
                                                        </a>

                                                    </li> -->
                                                    <?php
                                                    }
                                                    ?>
                                                    <!-- <li>
                                                    <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                        <i class="uil-favorite mr-1"></i> Add favorites
                                                    </a>
                                                </li> -->
                                                    <li>
                                                        <hr class="-mx-2 my-2 dark:border-gray-800">
                                                    </li>
                                                    <?php
                                                    if ($userOfPost["userid"] ==  $userCurrent["userid"]) {
                                                    ?>
                                                        <li data-post-id="<?php echo $post[0]["postid"] ?>" onclick="deletePost(event, this)">
                                                            <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                                                <i class="uil-trash-alt mr-1"></i> Delete
                                                            </a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Show Text Post -->
                                    <div class="p-5 pt-0 border-b dark:border-gray-700">
                                        <?php echo $post[0]["post"]; ?>
                                    </div>

                                    <!-- Show post share -->
                                    <div uk-lightbox>
                                        <div class="grid grid-cols-1 gap-2 px-5">
                                            <?php
                                            // Lấy bài post gốc - bài được share
                                            $postShare = $p->getAPost($post[0]["post_share_id"])[0];
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
                                                                } else  if ($fileExtension === 'mp4' || $fileExtension === 'avi' || $fileExtension === 'mkv') {
                                                                ?>
                                                                    <div class="w-full h-full">
                                                                        <video width="668" height="420" controls>
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
                                                                    <?php if ($hours <= 0) echo $minutes . " phút trước";
                                                                    else if ($hours >= 24) echo floor($hours / 24) . " ngày trước";
                                                                    else echo $hours . " h " . $minutes . " phút trước";
                                                                    ?></span> <ion-icon name="people"></ion-icon>
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
                                            <div class="flex space-x-4 lg:font-bold" post-id="<?php echo $post[$i]["postid"] ?>" author-id="<?php echo $post[$i]["userid"] ?>">
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
                                                                                                                        echo "<span>(" . count($like) . ")</span>" ?> </div>
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
                                            $quantityCmt = $p->getQuantityCommentPost($post[$i]["postid"])[0]["total"];
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
                        } else {
                            echo '<div style="text-align: center">Không có bài viết</div>';
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>

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
    <!-- For Night mode -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php include("./Websocket/src/Notification.php") ?>
    <script>
        $(".like-post-btn").on("click", function(e) {
            e.preventDefault();
            var postID = $(this).parent().attr("post-id");
            var userID = <?php echo $_SESSION["userid"] ?>;
            // console.log(userID + " " + postID);
            var noti = {
                userid: userID,
                postid: postID,
                action: "like-post"
            };
            ws.send(JSON.stringify(noti));
        });


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

    <script src="Js/Global.js"></script>
    <script src="Js/Post.js"></script>
    <script src="Js/notification.js"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</body>

<!-- Mirrored from demo.foxthemes.net/socialite/feed.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:41:40 GMT -->

</html>