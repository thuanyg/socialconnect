<?php
session_start();
include_once("Classes/friend.php");
include_once("Classes/user.php");
include_once("Classes/message.php");
include_once("Classes/status.php");
include("Classes/notification.php");
$notify = new Notification();
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
} else {
    $user_obj = new User();
    $userCurrent = $user_obj->getUser($_SESSION["userid"]);
    $f_obj = new Friend();
    $friends = $f_obj->getListFriend($userCurrent["userid"]);
    $status_obj = new Status();
}
if (isset($_GET["uid"])) {
    $uid_friend_chat = $_GET["uid"];
} else {
    $uid_friend_chat = "";
}
$mess_obj = new Message();
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
    <title>Chat - Social Connect</title>
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

    <style>
        /* .message-tab{
            background-color: lightgray !important;
        } */
    </style>
    <script src="https://kit.fontawesome.com/ed32d729eb.js" crossorigin="anonymous"></script>
</head>

<body class="is_message">
    <!-- Thanh thông báo ở góc trên bên phải -->
    <div class="notification" id="notification">
        <span id="notification-text"></span>
        <button id="close-notification">X</button>
    </div>
    <!-- Cửa sổ confirm -->
    <div id="confirmationModal" class="confirm-modal">
        <div class="confirm-modal-content">
            <p>Bạn muốn thực hiện hành động nào?</p>
            <button class="deleteOne">Delete Only Me</button>
            <button class="deleteAll">Delete All</button>
        </div>
    </div>
    <!-- HTML cho màn hình phủ -->
    <div class="overlay" id="imageOverlay">
        <span class="close span" onclick='document.getElementById("imageOverlay").style.display = "none"' title="Close">x</span>
        <span class="pre-image span" title="Previous">&lt;</span>
        <span class="next-image span" title="Next">&gt;</span>
        <img src="" id="expandedImg">
    </div>
    <!-- Main -->
    <div id="Wrapper" class="is-small">
        <input type="hidden" name="txtUserid" value="<?php echo $_SESSION["userid"] ?>">
        <input type="hidden" name="txtChatUserid" value="<?php echo $uid_friend_chat ?>">
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
                            <a href="#" class="is_icon" uk-tooltip="title: Cart">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                                </svg>
                            </a>
                            <div uk-drop="mode: click" class="header_dropdown dropdown_cart">

                                <div class="drop_headline">
                                    <h4> My Cart </h4>
                                    <a href="#" class="btn_action hover:bg-gray-100 mr-2 px-2 py-1 rounded-md underline"> Checkout </a>
                                </div>

                                <ul class="dropdown_cart_scrollbar" data-simplebar>
                                    <li>
                                        <div class="cart_avatar">
                                            <img src="assets/images/product/2.jpg" alt="">
                                        </div>
                                        <div class="cart_text">
                                            <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1"> Wireless headphones </div>
                                            <p class="text-sm">Type Accessories </p>
                                        </div>
                                        <div class="cart_price">
                                            <span> $14.99 </span>
                                            <button class="type"> Remove</button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cart_avatar">
                                            <img src="assets/images/product/13.jpg" alt="">
                                        </div>
                                        <div class="cart_text">
                                            <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1"> Parfum Spray</div>
                                            <p class="text-sm">Type Parfums </p>
                                        </div>
                                        <div class="cart_price">
                                            <span> $16.99 </span>
                                            <button class="type"> Remove</button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cart_avatar">
                                            <img src="assets/images/product/15.jpg" alt="">
                                        </div>
                                        <div class="cart_text">
                                            <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1"> Herbal Shampoo </div>
                                            <p class="text-sm">Type Herbel </p>
                                        </div>
                                        <div class="cart_price">
                                            <span> $12.99 </span>
                                            <button class="type"> Remove</button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cart_avatar">
                                            <img src="assets/images/product/14.jpg" alt="">
                                        </div>
                                        <div class="cart_text">
                                            <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1"> Wood Chair </div>
                                            <p class="text-sm">Type Furniture </p>
                                        </div>
                                        <div class="cart_price">
                                            <span> $19.99 </span>
                                            <button class="type"> Remove</button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cart_avatar">
                                            <img src="assets/images/product/9.jpg" alt="">
                                        </div>
                                        <div class="cart_text">
                                            <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1"> Strawberries FreshRipe </div>
                                            <p class="text-sm">Type Fruit </p>
                                        </div>
                                        <div class="cart_price">
                                            <span> $12.99 </span>
                                            <button class="type"> Remove</button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cart_avatar">
                                            <img src="assets/images/product/2.jpg" alt="">
                                        </div>
                                        <div class="cart_text">
                                            <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1"> Wireless headphones </div>
                                            <p class="text-sm">Type Accessories </p>
                                        </div>
                                        <div class="cart_price">
                                            <span> $14.99 </span>
                                            <button class="type"> Remove</button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cart_avatar">
                                            <img src="assets/images/product/13.jpg" alt="">
                                        </div>
                                        <div class="cart_text">
                                            <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1"> Parfum Spray</div>
                                            <p class="text-sm">Type Parfums </p>
                                        </div>
                                        <div class="cart_price">
                                            <span> $16.99 </span>
                                            <button class="type"> Remove</button>
                                        </div>
                                    </li>
                                </ul>

                                <div class="cart_footer">
                                    <p> Subtotal : $ 320 </p>
                                    <h1> Total : <strong> $ 320</strong> </h1>
                                </div>
                            </div>

                            <a href="#" class="is_icon" uk-tooltip="title: Notifications">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                </svg>
                                <span>3</span>
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
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar">
                                                    <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                                </div>
                                                <span class="drop_icon bg-gradient-primary">
                                                    <i class="icon-feather-thumbs-up"></i>
                                                </span>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Adrian Mohani</strong> Like Your Comment On Video
                                                        <span class="text-link">Learn Prototype Faster </span>
                                                    </p>
                                                    <time> 2 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="not-read">
                                            <a href="#">
                                                <div class="drop_avatar status-online"> <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Stella Johnson</strong> Replay Your Comments in
                                                        <span class="text-link">Adobe XD Tutorial</span>
                                                    </p>
                                                    <time> 9 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-3.jpg" alt="">
                                                </div>
                                                <span class="drop_icon bg-gradient-primary">
                                                    <i class="icon-feather-thumbs-up"></i>
                                                </span>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Alex Dolgove</strong> Added New Review In Video
                                                        <span class="text-link">Full Stack PHP Developer</span>
                                                    </p>
                                                    <time> 12 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Jonathan Madano</strong> Shared Your Discussion On Video
                                                        <span class="text-link">Css Flex Box </span>
                                                    </p>
                                                    <time> Yesterday </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                                </div>
                                                <span class="drop_icon bg-gradient-primary">
                                                    <i class="icon-feather-thumbs-up"></i>
                                                </span>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Adrian Mohani</strong> Like Your Comment On Course
                                                        <span class="text-link">Javascript Introduction </span>
                                                    </p>
                                                    <time> 2 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar status-online"> <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Stella Johnson</strong> Replay Your Comments in
                                                        <span class="text-link">Programming for Games</span>
                                                    </p>
                                                    <time> 9 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Stella Johnson</strong> Replay Your Comments in
                                                        <span class="text-link">Programming for Games</span>
                                                    </p>
                                                    <time> 9 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-3.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Alex Dolgove</strong> Added New Review In Course
                                                        <span class="text-link">Full Stack PHP Developer</span>
                                                    </p>
                                                    <time> 12 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Jonathan Madano</strong> Shared Your Discussion On Course
                                                        <span class="text-link">Css Flex Box </span>
                                                    </p>
                                                    <time> Yesterday </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Adrian Mohani</strong> Like Your Comment On Course
                                                        <span class="text-link">Javascript Introduction </span>
                                                    </p>
                                                    <time> 2 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="drop_avatar"> <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                                </div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>Stella Johnson</strong> Replay Your Comments in
                                                        <span class="text-link">Programming for Games</span>
                                                    </p>
                                                    <time> 9 hours ago </time>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Message -->
                            <a href="#" class="is_icon" uk-tooltip="title: Message">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- <span>4</span> -->
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
                                            $friend = $user_obj->getUser($friends_mess[$i]["friend_id"]);
                                            $mess = $mess_obj->getLastestMessage($userCurrent["userid"], $friend["userid"]);
                                        ?>
                                            <li class="message-preview <?php if ($mess[0]['read'] == 0) echo 'un-read' ?>" data-friend-id="<?php echo $friend["userid"] ?>">
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
                                <a href="#" class="see-all"> See all in Messages</a>
                            </div>


                            <a href="#">
                                <img src="<?php echo $userCurrent["avatar_image"] ?>" class="is_avatar" alt="">
                            </a>
                            <div uk-drop="mode: click;offset:5" class="header_dropdown profile_dropdown">

                                <a href="timeline.php" class="user">
                                    <div class="user_avatar">
                                        <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="">
                                    </div>
                                    <div class="user_name">
                                        <div> <?php echo $userCurrent["last_name"] . " " . $userCurrent["first_name"] ?> </div>
                                        <span> @<?php echo $userCurrent["url_address"] ?></span>
                                    </div>
                                </a>
                                <hr>

                                <a href="page-setting.php">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    My Account
                                </a>
                                <a href="friends.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                    </svg>
                                    Manage Pages
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

            <div class="sidebar_inner">

                <ul>
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
                    <li><a href="videos.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-500">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
                            </svg>
                            <span> Video</span></a>
                    </li>
                    <li id="more-veiw" hidden><a href="birthdays.php">
                            <svg fill="currentColor" class="text-yellow-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                                <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                            </svg>
                            <span> Birthdays </span> <span class="new">N</span></a>
                    </li>
                </ul>

            </div>

            <!-- sidebar overly for mobile -->
            <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>

        </div>

        <!-- Main Contents -->
        <div class="main_content">

            <span uk-toggle="target: .message-content;" class="fixed left-0 top-36 bg-red-600 z-10 py-1 px-4 rounded-r-3xl text-white"> Users</span>

            <div class="messages-container">
                <div class="messages-container-inner">


                    <div class="messages-inbox">
                        <div class="messages-headline">
                            <div class="input-with-icon" hidden>
                                <input id="autocomplete-input" type="text" placeholder="Search">
                                <i class="icon-material-outline-search"></i>
                            </div>
                            <h2 class="text-2xl font-semibold">Chats</h2>
                            <span class="absolute icon-feather-edit mr-4 text-xl uk-position-center-right cursor-pointer" id="new-message"></span>
                        </div>
                        <div class="messages-inbox-inner" data-simplebar>
                            <ul>

                                <?php
                                $friends_mess = (new Message())->getFriendMessage($userCurrent["userid"]);
                                // echo sizeof($friends_mess);
                                for ($i = 0; $i < sizeof($friends_mess); $i++) {
                                    $friend = $user_obj->getUser($friends_mess[$i]["friend_id"]);
                                    $mess = $mess_obj->getLastestMessage($userCurrent["userid"], $friend["userid"]);
                                    $friend_status = $status_obj->getStatus($friend["userid"]);


                                ?>
                                    <li class="message-tab" data-friend-userid="<?php echo $friend["userid"] ?>">
                                        <a href="">
                                            <div class="message-avatar"><img src="<?php echo $friend["avatar_image"] ?>" alt="">
                                                <i class="fas fa-circle <?php if ($friend_status != null && $friend_status[0]["status"] == "online") echo "online";
                                                                        else if ($friend_status != null && $friend_status[0]["status"] == "offline") echo "offline";
                                                                        ?>-icon icon-small"></i>
                                            </div>
                                            <div class="message-by">
                                                <div class="message-by-headline">
                                                    <h5><?php echo $friend["last_name"] ?></h5>
                                                    <span class="statusText">
                                                        <?php
                                                        if ($friend_status != null && $friend_status[0]["status"] == "online") echo "Active now";
                                                        else if ($status_obj->offlineTime($friend["userid"]) != null) {
                                                            $time = $status_obj->offlineTime($friend["userid"]);
                                                            if ($time["hours"] < 1) {
                                                                echo "Active " . $time["minutes"] . " m ago";
                                                            } else if ($time["hours"] > 23) {
                                                                echo "Active " . floor($time["hours"] / 24) . " d ago";
                                                            } else {
                                                                echo "Active " . $time["hours"] . " h ago";
                                                            }
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                                <?php
                                                if ($mess != null) {
                                                    if ($mess[0]["sender_id"] == $userCurrent["userid"]) {
                                                ?>
                                                        <p>Me: <?php echo $mess[0]["text"] ?></p>
                                                    <?php
                                                    }
                                                    if ($mess[0]["sender_id"] == $friend["userid"]) {
                                                    ?>
                                                        <p><?php echo $friend["last_name"] . ": " . $mess[0]["text"] ?></p>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </a>
                                    </li>

                                    <?php
                                }
                                if ($uid_friend_chat != "") {
                                    $mess = $mess_obj->getLastestMessage($userCurrent["userid"], $uid_friend_chat);
                                    // Nếu không có tin nhắn nào
                                    // echo sizeof($mess);
                                    // print_r($mess);
                                    if ($mess == null) {
                                        $friend_chat_obj = $user_obj->getUser($uid_friend_chat);
                                        $friend_status = $status_obj->getStatus($uid_friend_chat);
                                    ?>
                                        <li class="message-tab" data-friend-userid="<?php echo $uid_friend_chat ?>">
                                            <a href="">
                                                <div class="message-avatar"><img src="<?php echo $friend_chat_obj["avatar_image"] ?>" alt="">
                                                    <i class="fas fa-circle <?php if ($friend_status != null && $friend_status[0]["status"] == "online") echo "online";
                                                                            else if ($friend_status != null && $friend_status[0]["status"] == "offline") echo "offline";
                                                                            ?>-icon icon-small"></i>
                                                </div>
                                                <div class="message-by">
                                                    <div class="message-by-headline">
                                                        <h5><?php echo $friend_chat_obj["last_name"] ?></h5>
                                                        <span class="statusText">
                                                            <?php
                                                            if ($friend_status != null && $friend_status[0]["status"] == "online") echo "Active now";
                                                            else if ($status_obj->offlineTime($uid_friend_chat) != null) {
                                                                $time = $status_obj->offlineTime($uid_friend_chat);
                                                                if ($time["hours"] < 1) {
                                                                    echo "Active " . $time["minutes"] . " m ago";
                                                                } else if ($time["hours"] > 23) {
                                                                    echo "Active " . floor($time["hours"] / 24) . " d ago";
                                                                } else {
                                                                    echo "Active " . $time["hours"] . " h ago";
                                                                }
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <p>Chưa có tin nhắn</p>
                                                </div>
                                            </a>
                                        </li>
                                <?php
                                    }
                                }
                                ?>

                            </ul>

                        </div>
                    </div>


                    <div class="message-content">
                        <div class="theme_chat" style="display: flex; justify-content: center; justify-items: center;">
                            <img style="max-width: 800px; object-fit: cover;" src="./assets/images/themes/theme_chat.jpg" alt="">
                        </div>
                        <!-- append here -->

                    </div>



                </div>
            </div>

        </div>

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


    <!-- For Night mode -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include("./Websocket/src/Notification.php") ?>
    <?php include("./Websocket/src/ChatFriends.php") ?>
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
    <script src="Js/Chats-friend.js"></script>
    <script src="Js/notification.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
    <script src="../../code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="../../unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>

</body>

<!-- Mirrored from demo.foxthemes.net/socialite/chats-friend.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:43:03 GMT -->

</html>