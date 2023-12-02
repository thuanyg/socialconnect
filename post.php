<?php
include_once("Classes/user.php");
include_once("Classes/post.php");
include_once("Classes/timer.php");
include_once("Classes/friend.php");
include_once("Classes/message.php");
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
                        <input value="" type="text" class="form-control" placeholder="Search for Friends , Videos and more.." autocomplete="off">
                        <div uk-drop="mode: click" class="header_search_dropdown">

                            <h4 class="search_title"> Recently </h4>
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="assets/images/avatars/avatar-1.jpg" alt="" class="list-avatar">
                                        <div class="list-name"> Erica Jones </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="assets/images/avatars/avatar-2.jpg" alt="" class="list-avatar">
                                        <div class="list-name"> Coffee Addicts </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="assets/images/avatars/avatar-3.jpg" alt="" class="list-avatar">
                                        <div class="list-name"> Mountain Riders </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="assets/images/avatars/avatar-4.jpg" alt="" class="list-avatar">
                                        <div class="list-name"> Property Rent And Sale </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="assets/images/avatars/avatar-5.jpg" alt="" class="list-avatar">
                                        <div class="list-name"> Erica Jones </div>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="right_side">

                        <div class="header_widgets">


                            <a href="#" class="is_icon" uk-tooltip="title: Notifications">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                </svg>
                                <span class="notification-quantity" style="display: none;"></span>
                            </a>
                            <div uk-drop="mode: click" class="header_dropdown">
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
                                        <!-- <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Quang</strong> Replay Your Comments in
                                                        <span class="text-link">Programming for Games</span>
                                                    </p>
                                                    <time> 9 hours ago </time>
                                                </div>
                                            </a>
                                        </li> -->
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
                                            <a href="#" data-tippy-placement="left" title="Notifications">
                                                <ion-icon name="settings-outline" uk-tooltip="title: Message settings ; pos: left"></ion-icon>
                                            </a>
                                            <a href="#" class="btn-read-all-message" data-tippy-placement="left" title="Mark as read all">
                                                <ion-icon name="checkbox-outline"></ion-icon>
                                            </a>
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
                                                <a href="">
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
                    <li class="active"><a href="feed.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-600">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span> Feed </span> </a>
                    </li>

                    <li><a href="videos.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-500">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
                            </svg>
                            <span> Video</span></a>
                    </li>
                    <li><a href="groups.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg><span> Groups </span></a>
                    </li>

                    <li id="more-veiw" hidden><a href="albums.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-purple-500">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg> <span> Photos </span></a>
                    </li>


                    <li id="more-veiw" hidden><a href="birthdays.html">
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
                                <div class="contact-username"> <?php echo $friend["first_name"] . " " . $friend["last_name"] ?> </div>
                            </a>
                    <?php
                        }
                    }
                    ?>

                </div>


                <div class="footer-links">
                    <a href="#">About</a>
                    <a href="#">Blog </a>
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

                                <div class="card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $post[0]["postid"] ?>">

                                    <!-- post header-->
                                    <div class="flex justify-between items-center lg:p-4 p-2.5">
                                        <div class="flex flex-1 items-center space-x-4">
                                            <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>">
                                                <img src="<?php echo $userOfPost["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                            </a>
                                            <div class="flex-1 font-semibold capitalize">
                                                <a href="profile.php?uid=<?php echo $userOfPost["userid"] ?>" class="text-black dark:text-gray-100"> <?php echo $userOfPost["first_name"] . " " . $userOfPost["last_name"] ?> </a>
                                                <div class="text-gray-700 flex items-center space-x-2"><span><?php if ($hours <= 0) echo $minutes . " phút trước";
                                                                                                                else if ($hours >= 24) echo floor($hours / 24) . " ngày trước";
                                                                                                                else echo $hours . " h " . $minutes . " phút trước";
                                                                                                                ?></span> <ion-icon name="people"></ion-icon></div>
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
                                        <div class="grid grid-cols-2 gap-2 px-5">
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
                                        <div class="flex space-x-4 lg:font-bold" post-id="<?php echo $post[0]["postid"] ?>"  author-id="<?php echo $post[0]["userid"]?>">
                                            <button type="button" class="like-post-btn flex items-center space-x-2">
                                                <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="<?php if ($liked == 0) echo "currentColor";
                                                                                                                        else echo "blue"; ?>" width="22" height="22" class="dark:text-gray-100">
                                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                    </svg>
                                                </div>
                                                <div class="like-text" style="color:<?php if ($liked == 1) echo "blue"; ?>"> Like</div>
                                            </button>
                                            <a href="#" uk-toggle="target: #post-details-modal" class="comment-post-btn flex items-center space-x-2">
                                                <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div> Comment</div>
                                            </a>
                                            <a href="#" class="share-post-btn flex items-center space-x-2 flex-1 justify-end">
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

                                        <div class="border-t py-4 space-y-4 dark:border-gray-600 comment-container" post-id="<?php echo $post[0]["postid"];?>">
                                            <div class="flex">
                                                <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                                    <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="" class="absolute h-full rounded-full w-full">
                                                </div>
                                                <div>
                                                    <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                                        <p class="leading-6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officia aliquid hic molestiae provident eaque obcaecati eligendi explicabo distinctio dicta fuga rem asperiores itaque, dolor officiis doloribus, nobis illum assumenda et! <urna class="i uil-heart"></urna> <i class="uil-grin-tongue-wink"> </i> </p>
                                                        <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                                    </div>
                                                    <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                                        <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                                        <a href="#"> Replay </a>
                                                        <span> 3d </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                                    <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="" class="absolute h-full rounded-full w-full">
                                                </div>
                                                <div>
                                                    <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                                        <p class="leading-6"> Test cmt 2 !<i class="uil-grin-tongue-wink-alt"></i> </p>
                                                        <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                                    </div>
                                                    <div class="text-xs flex items-center space-x-3 mt-2 ml-5">
                                                        <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                                        <a href="#"> Replay </a>
                                                        <span> 3d </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <a href="#" class="hover:text-blue-600 hover:underline"> Veiw 8 more Comments </a>

                                        <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                            <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
                                            <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                <a href="#">
                                                    <ion-icon name="happy-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                </a>
                                                <a href="#">
                                                    <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                </a>
                                                <a href="#">
                                                    <ion-icon name="link-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                </a>
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
                                                <div class="text-gray-700 flex items-center space-x-2"><span><?php if ($hours <= 0) echo $minutes . " phút trước";
                                                                                                                else if ($hours >= 24) echo floor($hours / 24) . " ngày trước";
                                                                                                                else echo $hours . " h " . $minutes . " phút trước";
                                                                                                                ?></span> <ion-icon name="people"></ion-icon></div>
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
                                            <div class="card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $postShare["postid"] ?>">
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
                                        <div class="flex space-x-4 lg:font-bold" post-id="<?php echo $post[0]["postid"] ?>" author-id="<?php echo $post[0]["userid"]?>">
                                            <button type="button" class="like-post-btn flex items-center space-x-2">
                                                <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="<?php if ($liked == 0) echo "currentColor";
                                                                                                                        else echo "blue"; ?>" width="22" height="22" class="dark:text-gray-100">
                                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                    </svg>
                                                </div>
                                                <div class="like-text" style="color:<?php if ($liked == 1) echo "blue"; ?>"> Like</div>
                                            </button>
                                            <a href="#" uk-toggle="target: #post-details-modal" class="comment-post-btn flex items-center space-x-2">
                                                <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div> Comment</div>
                                            </a>
                                            <a href="#" class="share-post-btn flex items-center space-x-2 flex-1 justify-end">
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

                                        <div class="border-t py-4 space-y-4 dark:border-gray-600 comment-container" post-id="<?php echo $post[0]["postid"];?>">
                                            <div class="flex">
                                                <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                                    <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="" class="absolute h-full rounded-full w-full">
                                                </div>
                                                <div>
                                                    <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                                        <p class="leading-6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officia aliquid hic molestiae provident eaque obcaecati eligendi explicabo distinctio dicta fuga rem asperiores itaque, dolor officiis doloribus, nobis illum assumenda et! <urna class="i uil-heart"></urna> <i class="uil-grin-tongue-wink"> </i> </p>
                                                        <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                                    </div>
                                                    <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                                        <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                                        <a href="#"> Replay </a>
                                                        <span> 3d </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                                    <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="" class="absolute h-full rounded-full w-full">
                                                </div>
                                                <div>
                                                    <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                                        <p class="leading-6"> Test cmt 2 !<i class="uil-grin-tongue-wink-alt"></i> </p>
                                                        <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                                    </div>
                                                    <div class="text-xs flex items-center space-x-3 mt-2 ml-5">
                                                        <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                                        <a href="#"> Replay </a>
                                                        <span> 3d </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <a href="#" class="hover:text-blue-600 hover:underline"> Veiw 8 more Comments </a>

                                        <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                            <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
                                            <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                <a href="#">
                                                    <ion-icon name="happy-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                </a>
                                                <a href="#">
                                                    <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                </a>
                                                <a href="#">
                                                    <ion-icon name="link-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                </a>
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
                    <div class="lg:w-72 w-full">

                        <a href="#birthdays" uk-toggle>
                            <div class="bg-white mb-5 px-4 py-3 rounded-md shadow">
                                <h3 class="text-line-through font-semibold mb-1"> Birthdays </h3>
                                <div class="-mx-2 duration-300 flex hover:bg-gray-50 px-2 py-2 rounded-md">
                                    <img src="assets/images/icons/gift-icon.png" class="w-9 h-9 mr-3" alt="">
                                    <p class="line-clamp-2 leading-6"> <strong> Jessica Erica </strong> and <strong> two others </strong>
                                        have a birthdays to day .
                                    </p>
                                </div>
                            </div>
                        </a>

                        <h3 class="text-xl font-semibold"> Contacts </h3>

                        <div class="" uk-sticky="offset:80">

                            <nav class="responsive-nav border-b extanded mb-2 -mt-2">
                                <ul uk-switcher="connect: #group-details; animation: uk-animation-fade">
                                    <li class="uk-active"><a class="active" href="#0"> Friends <span> 310 </span> </a></li>
                                    <li><a href="#0">Groups</a></li>
                                </ul>
                            </nav>

                            <div class="contact-list">

                                <a href="#">
                                    <div class="contact-avatar">
                                        <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                        <span class="user_status status_online"></span>
                                    </div>
                                    <div class="contact-username">Contact 1</div>
                                </a>
                                <div uk-drop="pos: left-center ;animation: uk-animation-slide-left-small">
                                    <div class="contact-list-box">
                                        <div class="contact-avatar">
                                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                            <span class="user_status status_online"></span>
                                        </div>
                                        <div class="contact-username"> Contact 1</div>
                                        <p>
                                            <ion-icon name="people" class="text-lg mr-1"></ion-icon> Become friends with
                                            <strong> Stella Johnson </strong> and <strong> 14 Others</strong>
                                        </p>
                                        <div class="contact-list-box-btns">
                                            <button type="button" class="button primary flex-1 block mr-2">
                                                <i class="uil-envelope mr-1"></i> Send message</button>
                                            <button type="button" href="#" class="button secondary button-icon mr-2">
                                                <i class="uil-list-ul"> </i> </button>
                                            <button type="button" a href="#" class="button secondary button-icon">
                                                <i class="uil-ellipsis-h"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <a href="#">
                                    <div class="contact-avatar">
                                        <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                        <span class="user_status"></span>
                                    </div>
                                    <div class="contact-username"> Contact 2</div>
                                </a>
                                <div uk-drop="pos: left-center ;animation: uk-animation-slide-left-small">
                                    <div class="contact-list-box">
                                        <div class="contact-avatar">
                                            <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                            <span class="user_status"></span>
                                        </div>
                                        <div class="contact-username"> Contact 2 </div>
                                        <p>
                                            <ion-icon name="people" class="text-lg mr-1"></ion-icon> Become friends with
                                            <strong> Stella Johnson </strong> and <strong> 14 Others</strong>
                                        </p>
                                        <div class="contact-list-box-btns">
                                            <button type="button" class="button primary flex-1 block mr-2">
                                                <i class="uil-envelope mr-1"></i> Send message</button>
                                            <button type="button" href="#" class="button secondary button-icon mr-2">
                                                <i class="uil-list-ul"> </i> </button>
                                            <button type="button" a href="#" class="button secondary button-icon">
                                                <i class="uil-ellipsis-h"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>



                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- birthdays modal -->
    <div id="birthdays" uk-modal>
        <div class="uk-modal-dialog uk-modal-body rounded-xl shadow-lg">
            <!-- close button -->
            <button class="uk-modal-close-default p-2.5 bg-gray-100 rounded-full m-3" type="button" uk-close></button>

            <div class="flex items-center space-x-3 mb-10">
                <ion-icon name="gift" class="text-yellow-500 text-xl bg-yellow-50 p-1 rounded-md"></ion-icon>
                <div class="text-xl font-semibold"> Today's birthdays </div>
            </div>

            <div class="space-y-6">
                <div class="sm:space-y-8 space-y-6 pb-2">

                    <div class="flex items-center sm:space-x-6 space-x-3">
                        <img src="assets/images/avatars/avatar-3.jpg" alt="" class="sm:w-16 sm:h-16 w-14 h-14 rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-base font-semibold"> <a href="#"> Alex Dolgove </a> </div>
                                <div class="font-medium text-sm text-gray-400"> 19 years old</div>
                            </div>
                            <div class="relative">
                                <input type="text" name="" id="" class="with-border" placeholder="Write her on Timeline">
                                <ion-icon name="happy" class="absolute right-3 text-2xl top-1/4"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center sm:space-x-6 space-x-3">
                        <img src="assets/images/avatars/avatar-2.jpg" alt="" class="sm:w-16 sm:h-16 w-14 h-14 rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-base font-semibold"> <a href="#"> Stella Johnson </a> </div>
                                <div class="font-medium text-sm text-gray-400"> 19 years old</div>
                            </div>
                            <div class="relative">
                                <input type="text" name="" id="" class="with-border" placeholder="Write her on Timeline">
                                <ion-icon name="happy" class="absolute right-3 text-2xl top-1/4"></ion-icon>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="relative cursor-pointer" uk-toggle="target: #upcoming; animation: uk-animation-fade">
                    <div class="bg-gray-50 rounded-lg px-5 py-4 font-semibold text-base"> Upcoming birthdays </div>
                    <i class="-translate-y-1/2 absolute icon-feather-chevron-up right-4 text-xl top-1/2 transform text-gray-400" id="upcoming" hidden></i>
                    <i class="-translate-y-1/2 absolute icon-feather-chevron-down right-4 text-xl top-1/2 transform text-gray-400" id="upcoming"></i>
                </div>
                <div class="mt-5 sm:space-y-8 space-y-6" id="upcoming" hidden>

                    <div class="flex items-center sm:space-x-6 space-x-3">
                        <img src="assets/images/avatars/avatar-6.jpg" alt="" class="sm:w-16 sm:h-16 w-14 h-14 rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-base font-semibold"> <a href="#"> Erica Jones </a> </div>
                                <div class="font-medium text-sm text-gray-400"> 19 years old</div>
                            </div>
                            <div class="relative">
                                <input type="text" name="" id="" class="with-border" placeholder="Write her on Timeline">
                                <ion-icon name="happy" class="absolute right-3 text-2xl top-1/4"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center sm:space-x-6 space-x-3">
                        <img src="assets/images/avatars/avatar-5.jpg" alt="" class="sm:w-16 sm:h-16 w-14 h-14 rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-base font-semibold"> <a href="#"> Dennis Han </a> </div>
                                <div class="font-medium text-sm text-gray-400"> 19 years old</div>
                            </div>
                            <div class="relative">
                                <input type="text" name="" id="" class="with-border" placeholder="Write her on Timeline">
                                <ion-icon name="happy" class="absolute right-3 text-2xl top-1/4"></ion-icon>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- open chat box -->
    <div uk-toggle="target: #offcanvas-chat" class="start-chat">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
        </svg>
    </div>

    <div id="offcanvas-chat" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar bg-white p-0 w-full lg:w-80 shadow-2xl">


            <div class="relative pt-5 px-4">

                <h3 class="text-2xl font-bold mb-2"> Chats </h3>

                <div class="absolute right-3 top-4 flex items-center space-x-2">

                    <button class="uk-offcanvas-close  px-2 -mt-1 relative rounded-full inset-0 lg:hidden blcok" type="button" uk-close></button>

                    <a href="#" uk-toggle="target: #search;animation: uk-animation-slide-top-small">
                        <ion-icon name="search" class="text-xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                    <a href="#">
                        <ion-icon name="settings-outline" class="text-xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                    <a href="#">
                        <ion-icon name="ellipsis-vertical" class="text-xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                    <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small; offset:5">
                        <ul class="space-y-1">
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-100 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <ion-icon name="checkbox-outline" class="pr-2 text-xl"></ion-icon> Mark all as read
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-100 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <ion-icon name="settings-outline" class="pr-2 text-xl"></ion-icon> Chat setting
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-100 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <ion-icon name="notifications-off-outline" class="pr-2 text-lg"></ion-icon> Disable notifications
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-100 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <ion-icon name="star-outline" class="pr-2 text-xl"></ion-icon> Create a group chat
                                </a>
                            </li>
                        </ul>
                    </div>


                </div>


            </div>

            <div class="absolute bg-white z-10 w-full -mt-5 lg:-mt-2 transform translate-y-1.5 py-2 border-b items-center flex" id="search" hidden>
                <input type="text" placeholder="Search.." class="flex-1">
                <ion-icon name="close-outline" class="text-2xl hover:bg-gray-100 p-1 rounded-full mr-4 cursor-pointer" uk-toggle="target: #search;animation: uk-animation-slide-top-small"></ion-icon>
            </div>

            <nav class="responsive-nav border-b extanded mb-2 -mt-2">
                <ul uk-switcher="connect: #chats-tab; animation: uk-animation-fade">
                    <li class="uk-active"><a class="active" href="#0"> Friends </a></li>
                    <li><a href="#0">Groups <span> 10 </span> </a></li>
                </ul>
            </nav>

            <div class="contact-list px-2 uk-switcher" id="chats-tab">

                <div class="p-1">
                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-7.jpg" alt="">
                        </div>
                        <div class="contact-username"> Alex Dolgove</div>
                    </a>
                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-8.jpg" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"> Dennis Han</div>
                    </a>
                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                            <span class="user_status"></span>
                        </div>
                        <div class="contact-username"> Erica Jones</div>
                    </a>
                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-3.jpg" alt="">
                        </div>
                        <div class="contact-username">Stella Johnson</div>
                    </a>

                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-5.jpg" alt="">
                        </div>
                        <div class="contact-username">Adrian Mohani </div>
                    </a>
                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-6.jpg" alt="">
                        </div>
                        <div class="contact-username"> Jonathan Madano</div>
                    </a>
                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                            <span class="user_status"></span>
                        </div>
                        <div class="contact-username"> Erica Jones</div>
                    </a>
                    <a href="chats-friend.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-1.jpg" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"> Dennis Han</div>
                    </a>


                </div>
                <div class="p-1">
                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-7.jpg" alt="">
                        </div>
                        <div class="contact-username"> Alex Dolgove</div>
                    </a>
                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-8.jpg" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"> Dennis Han</div>
                    </a>
                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                            <span class="user_status"></span>
                        </div>
                        <div class="contact-username"> Erica Jones</div>
                    </a>
                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-3.jpg" alt="">
                        </div>
                        <div class="contact-username">Stella Johnson</div>
                    </a>

                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-5.jpg" alt="">
                        </div>
                        <div class="contact-username">Adrian Mohani </div>
                    </a>
                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-6.jpg" alt="">
                        </div>
                        <div class="contact-username"> Jonathan Madano</div>
                    </a>
                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                            <span class="user_status"></span>
                        </div>
                        <div class="contact-username"> Erica Jones</div>
                    </a>
                    <a href="chats-group.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-1.jpg" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"> Dennis Han</div>
                    </a>


                </div>

            </div>
        </div>
    </div>

    <!-- story-preview -->
    <div class="story-prev">

        <div class="story-sidebar uk-animation-slide-left-medium">
            <div class="md:flex justify-between items-center py-2 hidden">
                <h3 class="text-2xl font-semibold"> All Story </h3>
                <a href="#" class="text-blue-600"> Setting</a>
            </div>

            <div class="story-sidebar-scrollbar" data-simplebar>
                <h3 class="text-lg font-medium"> Your Story </h3>

                <a class="flex space-x-4 items-center hover:bg-gray-100 md:my-2 py-2 rounded-lg hover:text-gray-700" href="#">
                    <svg class="w-12 h-12 p-3 bg-gray-200 rounded-full text-blue-500 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-lg font-semibold"> Create a story </div>
                        <div class="text-sm -mt-0.5"> Share a photo or write something. </div>
                    </div>
                </a>

                <h3 class="text-lg font-medium lg:mt-3 mt-1"> Friends Story </h3>

                <div class="story-users-list" uk-switcher="connect: #story_slider ; toggle: > * ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium ">

                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-1.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Dennis Han</div>
                            <p> <span class="story-count"> 2 new </span> <span class="story-time"> 4Mn ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Adrian Mohani</div>
                            <p> <span class="story-count"> 1 new </span> <span class="story-time"> 1hr ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-3.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username">Alex Dolgove </div>
                            <p> <span class="story-count"> 3 new </span> <span class="story-time"> 2hr ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-4.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Stella Johnson </div>
                            <p> <span class="story-count"> 2 new </span> <span class="story-time"> 3hr ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-5.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Adrian Mohani </div>
                            <p> <span class="story-count"> 1 new </span> <span class="story-time"> 4hr ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-8.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Dennis Han</div>
                            <p> <span class="story-count"> 2 new </span> <span class="story-time"> 8Hr ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-6.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Adrian Mohani</div>
                            <p> <span class="story-count"> 1 new </span> <span class="story-time"> 12hr ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-7.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username">Alex Dolgove </div>
                            <p> <span class="story-count"> 3 new </span> <span class="story-time"> 22hr ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-8.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Stella Johnson </div>
                            <p> <span class="story-count"> 2 new </span> <span class="story-time"> 3Dy ago</span> </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="story-media">
                            <img src="assets/images/avatars/avatar-5.jpg" alt="">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> Adrian Mohani </div>
                            <p> <span class="story-count"> 1 new </span> <span class="story-time"> 4Dy ago</span> </p>
                        </div>
                    </a>


                </div>


            </div>

        </div>
        <div class="story-content">

            <ul class="uk-switcher uk-animation-scale-up" id="story_slider">
                <li class="relative">

                    <span uk-switcher-item="previous" class="slider-icon is-left"> </span>
                    <span uk-switcher-item="next" class="slider-icon is-right"> </span>

                    <div uk-lightbox>
                        <a href="assets/images/avatars/avatar-lg-2.jpg" data-alt="Image">
                            <img src="assets/images/avatars/avatar-lg-2.jpg" class="story-slider-image" data-alt="Image">
                        </a>
                    </div>

                </li>
                <li class="relative">

                    <span uk-switcher-item="previous" class="slider-icon is-left"> </span>
                    <span uk-switcher-item="next" class="slider-icon is-right"> </span>

                    <div uk-lightbox>
                        <a href="assets/images/avatars/avatar-lg-1.jpg" data-alt="Image">
                            <img src="assets/images/avatars/avatar-lg-1.jpg" class="story-slider-image" data-alt="Image">
                        </a>
                    </div>

                </li>
                <li class="relative">

                    <span uk-switcher-item="previous" class="slider-icon is-left"> </span>
                    <span uk-switcher-item="next" class="slider-icon is-right"> </span>

                    <div uk-lightbox>
                        <a href="assets/images/avatars/avatar-lg-4.jpg" data-alt="Image">
                            <img src="assets/images/avatars/avatar-lg-4.jpg" class="story-slider-image" data-alt="Image">
                        </a>
                    </div>

                </li>

                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
                <li class="relative">
                    <div class="bg-gray-200 story-slider-placeholder shadow-none animate-pulse"> </div>
                </li>
            </ul>

        </div>

        <!-- story colose button-->
        <span class="story-btn-close" uk-toggle="target: body ; cls: story-active" uk-tooltip="title:Close story ; pos: left">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </span>

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
    <script src="../../unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>

</body>

<!-- Mirrored from demo.foxthemes.net/socialite/feed.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:41:40 GMT -->

</html>