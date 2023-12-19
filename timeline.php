<?php
include("Classes/user.php");
include("Classes/post.php");
include("Classes/timer.php");
include("Classes/friend.php");
include("Classes/message.php");
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
} else {
    $user = new User();
    $userCurrent = $user->getUser($_SESSION["userid"]); // Return Array (userCurrent = result[0])
    $about = $user->getAbout($userCurrent["userid"]);
    $p = new Post();
    $post = $p->getOwnPost($userCurrent["userid"]);
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
    <title>Timeline</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Socialite is - Professional A unique and beautiful collection of UI elements">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="assets/css/icons.css">

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        /* CSS for model about */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 10015;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 800px;
            text-align: center;
            position: relative;
        }

        /* .modal textarea, .modal textarea{
            padding: 0 20px;
        } */
        .modal input,
        .modal textarea {
            padding: 0 20px;
            margin: 10px 0px;
            border: 2px solid steelblue;
        }


        .modal textarea {
            padding: 10px 20px;
        }


        .modal input:focus,
        .modal textarea:focus {
            padding: 0 20px;
            margin: 10px 0px;
            border: 2px solid darkseagreen;
        }

        .modal textarea:focus {
            padding: 10px 20px;
        }

        .modal span {
            font-size: 16px;
            color: darkolivegreen;
        }

        .modal button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .modal button:hover {
            background-color: #0056b3;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            font-weight: bolder;
            cursor: pointer;
            color: #333;
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

                            <a href="#" class="is_icon notification-btn" uk-tooltip="title: Notifications">
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
                    <li class="active"><a href="timeline.php">
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
                    <li><a href="videos.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-500">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
                            </svg>
                            <span> Video</span></a>
                    </li>
                    <li id="more-veiw" hidden><a href="products.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-500">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                            </svg>
                            <span> Products</span></a>
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
                            <li><a href="development-components.html"> Compounents </a></li>
                            <li><a href="development-plugins.html"> Plugins </a></li>
                            <li><a href="development-icons.html"> Icons </a></li>
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

                <!-- Profile cover -->
                <div class="profile user-profile">

                    <div class="profiles_banner">
                        <img src="<?php echo $userCurrent["cover_image"] ?>" alt="">
                        <div class="profile_action absolute bottom-0 right-0 space-x-1.5 p-3 text-sm z-50 hidden lg:flex">
                            <a href="#" uk-toggle="target: #edit-cover-modal" class="flex items-center justify-center h-8 px-3 rounded-md bg-gray-700 bg-opacity-70 text-white space-x-1.5">
                                <ion-icon name="image-outline" class="text-xl"></ion-icon>
                                <span> Edit cover </span>
                            </a>
                        </div>
                    </div>
                    <div class="profiles_content">

                        <div class="profile_avatar">
                            <div class="profile_avatar_holder">
                                <img src="<?php echo $userCurrent["avatar_image"] ?>" alt="">
                            </div>
                            <div class="user_status status_online"></div>
                            <div class="icon_change_photo" uk-toggle="target: #edit-avatar-modal"> <ion-icon name="camera" class="text-xl"></ion-icon> </div>
                        </div>

                        <div class="profile_info">
                            <h1 style="text-align: center;"><?php echo $userCurrent["first_name"] . " " . $userCurrent["last_name"] ?></h1>
                            <p style="text-align: center;"> <?php if ($about != null) {
                                                                echo $about["desc"];
                                                            } ?> </p>
                        </div>

                    </div>

                    <div class="flex justify-between lg:border-t border-gray-100 flex-col-reverse lg:flex-row pt-2">
                        <nav class="responsive-nav pl-3">
                            <ul uk-switcher="connect: #timeline-tab; animation: uk-animation-fade">
                                <li><a href="#">Timeline</a></li>
                                <li><a href="#">Friends <span><?php echo $f->getQuantityFriend($userCurrent["userid"]) ?></span> </a></li>
                                <li><a href="#" onclick="showImageOfYou()">Photos </a></li>
                                <li><a href="#">Pages</a></li>
                                <li><a href="#">Groups</a></li>
                                <li><a href="#">Videos</a></li>
                            </ul>
                        </nav>

                        <!-- button actions -->
                        <div class="flex items-center space-x-1.5 flex-shrink-0 pr-4 mb-2 justify-center order-1 relative">

                            <!-- add story -->

                            <!-- search icon -->
                            <a href="#" class="flex items-center justify-center h-10 w-10 rounded-md bg-gray-100" uk-toggle="target: #profile-search;animation: uk-animation-slide-top-small">
                                <ion-icon name="search" class="text-xl"></ion-icon>
                            </a>
                            <!-- search dropdown -->
                            <div class="absolute right-3 bg-white z-10 w-full flex items-center border rounded-md" id="profile-search" hidden>
                                <input type="text" placeholder="Search.." class="flex-1">
                                <ion-icon name="close-outline" class="text-2xl hover:bg-gray-100 p-1 rounded-full mr-2 cursor-pointer" uk-toggle="target: #profile-search;animation: uk-animation-slide-top-small"></ion-icon>
                            </div>

                            <!-- more icon -->
                            <a href="#" class="flex items-center justify-center h-10 w-10 rounded-md bg-gray-100">
                                <ion-icon name="ellipsis-horizontal" class="text-xl">···</ion-icon>
                            </a>
                            <!-- more drowpdown -->
                            <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small; offset:5">
                                <ul class="space-y-1">
                                    <li>
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-100 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                            <ion-icon name="notifications-off-outline" class="pr-2 text-lg"></ion-icon> View as
                                        </a>
                                    </li>
                                    <li>
                                        <a href="page-setting.php" class="flex items-center px-3 py-2 hover:bg-gray-100 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                            <ion-icon name="create-outline" class="pr-2 text-xl"></ion-icon> Account setting
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-100 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                            <ion-icon name="star-outline" class="pr-2 text-xl"></ion-icon> Profile status
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="-mx-2 my-2 dark:border-gray-800">
                                    </li>
                                    <li>
                                        <a href="#" class="delete-account-btn flex items-center px-3 py-2 text-red-500 hover:bg-red-50 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                            <ion-icon name="stop-circle-outline" class="pr-2 text-xl"></ion-icon> Delete account
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                </div>




                <div class="uk-switcher lg:mt-8 mt-4" id="timeline-tab">

                    <!-- Timeline -->
                    <div class="md:flex md:space-x-6 lg:mx-16">
                        <div class="space-y-5 flex-shrink-0 md:w-7/12" id="PostContaier">

                            <!-- create post  -->
                            <div class="card lg:mx-0 p-4" uk-toggle="target: #create-post-modal">
                                <div class="flex space-x-3">
                                    <img src="<?php echo $userCurrent["avatar_image"] ?>" class="w-10 h-10 rounded-full">
                                    <input placeholder="What's Your Mind ? Hamse!" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full">
                                </div>
                                <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
                                    <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer">
                                        <svg class="bg-blue-100 h-9 mr-2 p-1.5 rounded-full text-blue-600 w-9 -my-0.5 hidden lg:block" data-tippy-placement="top" title="Tooltip" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Photo/Video
                                    </div>
                                    <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer">
                                        <svg class="bg-green-100 h-9 mr-2 p-1.5 rounded-full text-green-600 w-9 -my-0.5 hidden lg:block" uk-tooltip="title: Messages ; pos: bottom ;offset:7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" title="" aria-expanded="false">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        Tag Friend
                                    </div>
                                    <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer">
                                        <svg class="bg-red-100 h-9 mr-2 p-1.5 rounded-full text-red-600 w-9 -my-0.5 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Fealing /Activity
                                    </div>
                                </div>
                            </div>



                            <!------------------------------------------------------------------------------------------------------------------------------------------------->
                            <!-- Post with picture -->
                            <?php
                            if ($post != null) {
                                for ($i = 0; $i < sizeof($post); $i++) {
                                    $like = $p->getLikePost($post[$i]["postid"]);
                                    $isFriendCondition = $post[$i]['privacy'] == "Friend";
                                    $isPublicCondition = $post[$i]['privacy'] == "Public";
                                    $isPrivateCondition = $post[$i]['privacy'] == "Private";
                                    if ($post[$i]['has_image'] == 1 && $post[$i]['type'] == "post") {
                                        $t = new Timer();
                                        $time = $t->TimeSince($post[$i]["date"]); // Return array
                                        $hours = $time["hours"];
                                        $minutes = $time["minutes"];
                                        $seconds = $time["seconds"];
                                        // Get user for each post
                                        $userOfPost = $user->getUser($post[$i]["userid"]);
                            ?>

                                        <div class="card post-card lg:mx-0 uk-animation-slide-bottom-small" post-id="<?php echo $post[$i]["postid"] ?>">

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
                                                                <li class="post-action-edit" uk-toggle="target: #edit-post-modal" post-id="<?php echo $post[$i]["postid"] ?>">
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
                                                                <li data-post-id="<?php echo $post[$i]["postid"] ?>" onclick="deletePost(event, this)">
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
                                                    <a href="#" uk-toggle="target: #post-details-modal" class="comment-post-btn flex items-center space-x-2">
                                                        <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div> Comment</div>
                                                    </a>
                                                    <a href="#"  uk-toggle="target: #share-post-modal"  class="share-post-btn flex items-center space-x-2 flex-1 justify-end">
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

                                                <div class="border-t py-4 space-y-4 dark:border-gray-600 comment-container" post-id="<?php echo $post[$i]["postid"]; ?>">
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
                                                        <a href="#">
                                                            <ion-icon name="send-outline" class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    <?php
                                    } else if ($post[$i]['type'] == "share") {
                                        $t = new Timer();
                                        $time = $t->TimeSince($post[$i]["date"]); // Return array
                                        $hours = $time["hours"];
                                        $minutes = $time["minutes"];
                                        $seconds = $time["seconds"];
                                        // Get user for each post
                                        $userOfPost = $user->getUser($post[$i]["userid"]);
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
                                                        <div class="text-gray-700 flex items-center space-x-2"><span><?php if ($hours <= 0) echo $minutes . " phút trước";
                                                                                                                        else if ($hours >= 24) echo floor($hours / 24) . " ngày trước";
                                                                                                                        else echo $hours . " h " . $minutes . " phút trước";
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
                                                                <li class="post-action-edit" uk-toggle="target: #edit-post-modal" post-id="<?php echo $post[$i]["postid"] ?>">
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
                                                                <li data-post-id="<?php echo $post[$i]["postid"] ?>" onclick="deletePost(event, this)">
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
                                                                <a href="post.php?p=<?php echo $postShare["postid"] ?>">
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

                                                <div class="border-t py-4 space-y-4 dark:border-gray-600 comment-container" post-id="<?php echo $post[$i]["postid"]; ?>">
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
                                }
                            } else {
                                echo '<div style="text-align: center">Không có bài viết</div>';
                            }
                            ?>



                        </div>

                        <!--Modal edit about-->
                        <div id="aboutModal" class="modal">
                            <div class="modal-content">
                                <span class="close" id="closeModalButton">&times;</span>
                                <!-- Đây là nơi để nhập thông tin người dùng -->
                                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">About/Description</h2>
                                <form>
                                    <span class="data-userid" hidden><?php echo $userCurrent["userid"]; ?></span>
                                    <span>Birthday</span>
                                    <input type="date" name="dBirthday" placeholder="Birthday" value="<?php if ($about != null) echo $about["birthday"] ?>" />
                                    <span>Address</span>
                                    <input type="text" name="txtAddress" placeholder="Address" value="<?php if ($about != null) echo $about["address"] ?>">
                                    <span>Education</span>
                                    <input type="text" name="txtEducation" placeholder="Education" value="<?php if ($about != null) echo $about["edu"] ?>">
                                    <span>Description</span>
                                    <textarea name="taBio" id="taBio" cols="80" rows="5" placeholder="Biography"><?php if ($about != null) echo $about["desc"] ?></textarea>
                                    <span style="display: block;">*Leave a field blank if you want to delete it*</span>
                                    <button id="about-save-btn" type="button">Save</button>
                                </form>
                            </div>
                        </div>

                        <!--Modal edit post-->
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
                                    }else {
                                    ?>
                                        <li class="flex items-center space-x-2">
                                            <ion-icon name="home"></ion-icon>
                                            <!-- <ion-icon name="home" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                            Live In 
                                        </li>
                                    <?php
                                    }
                                    if ($about != null && $about["birthday"] !=NULL) {
                                        $formattedDate = date("d-m-Y", strtotime($about["birthday"]));
                                    ?>
                                        <li class="flex items-center space-x-2">
                                            <ion-icon name="calendar"></ion-icon>
                                            <!-- <ion-icon name="home-sharp" class="rounded-full bg-gray-200 text-xl p-1 mr-3"></ion-icon> -->
                                            Birthday <strong> <?php echo $formattedDate ?> </strong>
                                        <?php
                                    }else {
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
                                    }else{
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
                                    }else{
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
                                <a href="#" uk-toggle="target: #edit-about-image-modal" class="button gray mt-3 w-full btn-edit-about-image">
                                    <input type="hidden" value="<?php echo $_SESSION['userid'] ?>" name="userid"></input>
                                    Edit </a>
                            </div>

                            <div class="widget card p-5 border-t">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold"> Friends </h4>
                                        <p class="text-sm"> <?php echo $f->getQuantityFriend($userCurrent["userid"]) . " Friends" ?> </p>
                                    </div>
                                    <a href="#" class="text-blue-600 ">See all</a>
                                </div>
                                <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold show-friend">
                                    <?php
                                    $friend1 = $f->getFriendToLoad($userCurrent["userid"]);
                                    for ($i = 0; $i < sizeof($friend1); $i++) {
                                        $friend = $user->getUser($friend1[$i]["friend_id"]);
                                    ?>
                                        <a href="profile.php?uid=<?php echo $friend["userid"] ?>">
                                            <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2">
                                                <img src="<?php echo $friend["avatar_image"] ?>" alt="" class="w-full h-full object-cover absolute">
                                            </div>
                                            <div class="text-sm truncate"> <?php echo $friend["first_name"] . " " . $friend["last_name"] ?> </div>
                                        </a>

                                    <?php

                                    } ?>

                                </div>
                                <a href="#" class="button gray mt-3 w-full see-all-btn "> See all </a>
                            </div>

                            <div class="widget card p-5 border-t">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h4 class="text-lg font-semibold"> Groups </h4>
                                    </div>
                                    <a href="#" class="text-blue-600 "> See all</a>
                                </div>
                                <!-- <div>

                                    <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                        <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                            <img src="assets/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                                        </a>
                                        <div class="flex-1">
                                            <a href="timeline-page.html" class="text-base font-semibold capitalize"> Graphic Design </a>
                                            <div class="text-sm text-gray-500 mt-0.5"> 345K Following</div>
                                        </div>
                                        <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                                            Join
                                        </a>
                                    </div>
                                    <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                        <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                            <img src="assets/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                                        </a>
                                        <div class="flex-1">
                                            <a href="timeline-page.html" class="text-base font-semibold capitalize"> Mountain Riders </a>
                                            <div class="text-sm text-gray-500 mt-0.5"> 452k Following </div>
                                        </div>
                                        <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                                            Join
                                        </a>
                                    </div>
                                    <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                        <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                            <img src="assets/images/group/group-2.jpg" class="absolute w-full h-full inset-0" alt="">
                                        </a>
                                        <div class="flex-1">
                                            <a href="timeline-page.html" class="text-base font-semibold capitalize"> Coffee Addicts </a>
                                            <div class="text-sm text-gray-500 mt-0.5"> 845K Following</div>
                                        </div>
                                        <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                                            Join
                                        </a>
                                    </div>
                                    <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                        <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                            <img src="assets/images/group/group-1.jpg" class="absolute w-full h-full inset-0" alt="">
                                        </a>
                                        <div class="flex-1">
                                            <a href="timeline-page.html" class="text-base font-semibold capitalize"> Architecture </a>
                                            <div class="text-sm text-gray-500 mt-0.5"> 237K Following</div>
                                        </div>
                                        <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                                            Join
                                        </a>
                                    </div>

                                </div> -->
                            </div>

                        </div>
                    </div>

                    <!-- Friends  -->
                    <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                        <h2 class="text-xl font-bold"> Friends</h2>

                        <nav class="responsive-nav border-b">
                            <ul>
                                <li class="friend-tab active"><a href="" class="lg:px-2"> All Friends <span> <?php echo sizeof($friends) ?> </span> </a></li>
                                <li class="friend-tab"><a href="" class="lg:px-2"> Recently added </a></li>
                                <li class="friend-tab"><a href="" class="lg:px-2"> Family </a></li>
                                <li class="friend-tab"><a href="" class="lg:px-2"> University </a></li>
                            </ul>
                        </nav>

                        <div class="all-friend-tab tab grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-2 gap-y-4 mt-3">
                            <?php
                            for ($i = 0; $i < sizeof($friends); $i++) {
                                $friend = $user->getUser($friends[$i]["friend_id"]);
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
                        <!-- // Tab recently friend -->
                        <div class="recently-friend-tab tab grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-2 gap-y-4 mt-3" style="display: none;">
                            <?php
                            $recentlyFriends = $f->getRecentlyFriend($userCurrent["userid"]);
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


                    <!-- Photos  -->
                    <div class="card md:p-6 p-2 max-w-3xl mx-auto" id="result">

                        <div class="flex justify-between items-start relative md:mb-4 mb-3">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold"> Photos </h2>
                                <nav class="responsive-nav style-2 md:m-0 -mx-4">
                                    <ul>
                                        <?php

                                        $postsize = $p->getPhotoFromPost($userCurrent["userid"]);
                                        ?>
                                        <li class="photo-tab photo active"><a href="#"> Photos of you
                                                <span><?php
                                                        if ($postsize != null) {
                                                            if ($postsize["total_media"] == null) {
                                                                echo "0";
                                                            } else {
                                                                echo $postsize["total_media"];
                                                            }
                                                        }
                                                        ?>
                                                </span>
                                            </a></li>
                                        <li class="photo-tab album"><a href="#"> Albums </a></li>
                                    </ul>
                                </nav>
                            </div>
                            <a href="#offcanvas-create" uk-toggle class="flex items-center justify-center z-10 h-10 w-10 rounded-full bg-blue-600 text-white absolute right-0" data-tippy-placement="left" title="Create New Album">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="photo-of-you tab grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-3 mt-5">
                            <?php
                            if ($post != null) {
                                for ($i = 0; $i < sizeof($post); $i++) {
                                    if ($post[$i]["media"] != null) {
                                        $media_json = $post[$i]["media"];
                                        $media = json_decode($media_json, true);
                                        foreach ($media as $file) {
                                            $fileInfo = pathinfo($file);
                                            $fileExtension = strtolower($fileInfo['extension']);
                                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                            ?>
                                                <div class="bg-green-400 max-w-full lg:h-44 h-36 rounded-lg relative overflow-hidden shadow uk-transition-toggle">
                                                    <div class="image-small">
                                                        <img src="uploads/posts/<?php echo $file; ?>" alt="<?php echo $file; ?>" class="w-full h-full absolute object-cover inset-0">
                                                    </div>
                                                    <!-- Overlay -->
                                                    <div class="-bottom-12 absolute bg-gradient-to-b from-transparent h-1/2 to-gray-800 uk-transition-slide-bottom-small w-full"></div>
                                                    <div class="absolute bottom-0 w-full p-3 text-white uk-transition-slide-bottom-small">
                                                        <div class="text-base"> Image description </div>
                                                        <div class="flex justify-between text-xs">
                                                            <a href="#"> Like</a>
                                                            <a href="#"> Comment </a>
                                                            <a href="#"> Share </a>
                                                        </div>
                                                    </div>
                                                </div>
                            <?php
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="image-big">
                            <span class="close-image">&times;</span>
                            <img class="image-big-content">
                        </div>
                        <div class="album-of-you tab grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-3 mt-5" style="display: none;">
                            <div>
                                <div class="bg-gray-200 max-w-full lg:h-44 h-36 rounded-lg relative overflow-hidden shadow uk-transition-toggle">
                                    <img src="assets/images/post/img-2.jpg" class="w-full h-full absolute object-cover inset-0">
                                    <!-- overly-->
                                    <div class="-bottom-12 absolute bg-gradient-to-b from-transparent h-1/2 to-gray-800 uk-transition-slide-bottom-small w-full"></div>
                                    <div class="absolute bottom-0 w-full p-3 text-white uk-transition-slide-bottom-small">
                                        <div class="text-base"> Image description </div>
                                        <div class="flex justify-between text-xs">
                                            <a href="#"> Like</a>
                                            <a href="#"> Comment </a>
                                            <a href="#"> Share </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <!-- Create post modal -->
    <div id="create-post-modal" style="overflow-y: scroll;" class="create-post" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">

            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Create Post </h3>
                <button id="closeModelPost" class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img src="<?php echo $userCurrent["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-2">
                    <textarea name="taPost" class="uk-textare text-black shadow-none focus:shadow-none text-xl font-medium resize-none" rows="5" placeholder="What's Your Mind ?"></textarea>
                </div>

            </div>
            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-3 shadow-sm items-center">
                    <div class="lg:block hidden"> Add to your post </div>
                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                        <svg class="btn-input-image bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <svg class="btn-input-video text-red-600 h-9 p-1.5 rounded-full bg-red-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"> </path>
                        </svg>
                        <svg class="btn-input-audio text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                        <!-- <svg class=" text-green-600 h-9 p-1.5 rounded-full bg-green-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"> </path>
                        </svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path>
                        </svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg> -->


                        <!-- view more -->
                        <!-- <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more" uk-toggle="target: #veiw-more; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path>
                        </svg> -->

                        <!-- vSet to Form -->
                        <!-- <form method="POST" id="uploadForm" name="fanh" enctype="multipart/form-data">
                            <input type="file" hidden name="fileToUpload[]" id="ImageInput" onchange="previewImage()" multiple>
                            <input type="file" hidden id="VideoInput">
                            <input type="file" hidden id="MusicInput">
                        </form> -->
                    </div>
                </div>
            </div>
            <!--Show Image Preview-->
            <div id="imagePreview" style="text-align: center; margin: 0 auto;">
                <ul>

                </ul>
                <!-- <img  style="display: inline-block; max-width: 300px; max-height: 300px;"> -->
            </div>

            <!--EndPreview-->
            <div class="flex items-center w-full justify-between p-3 border-t">
                <select class="selectpicker mt-2 col-4 story">
                    <option selected>Public</option>
                    <option>Friend</option>
                    <option>Private</option>
                </select>

                <div class="flex space-x-2">
                    <a onclick="CreatePost()" style="cursor: pointer; color: whitesmoke;" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium">
                        Share </a>
                </div>

                <a hidden class="bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold">
                    Share </a>
            </div>
        </div>
    </div>
    <!-- Edit post modal -->
    <div id="edit-post-modal" class="create-post is-story" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">

            <div class="text-center py-3 border-b">
                <h3 class="text-lg font-semibold"> Edit Post </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img src="<?php echo $userCurrent["avatar_image"]; ?>" class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-2">
                    <textarea class="uk-textare text-black shadow-none focus:shadow-none text-xl font-medium resize-none" rows="5" placeholder="What's Your Mind?"></textarea>
                </div>

            </div>
            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-2 shadow-sm items-center">
                    <div class="lg:block hidden ml-1"> Add to your post </div>
                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                        <svg class="btn-input-edit-image bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>

                        <svg class="btn-input-edit-video text-red-600 h-9 p-1.5 rounded-full bg-red-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"> </path>
                        </svg>
                        <svg class="text-green-600 h-9 p-1.5 rounded-full bg-green-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"> </path>
                        </svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more-edit" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path>
                        </svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more-edit" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <svg class="text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" id="veiw-more-edit" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>

                        <!-- view more -->
                        <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more-edit" uk-toggle="target: #veiw-more-edit; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path>
                        </svg>
                    </div>

                </div>
            </div>
            <div id="imageEditPreview" style="text-align: center; margin: 0 auto;">
                <ul style="list-style-type: none;"></ul>
            </div>
            <div class="flex items-center w-full justify-between border-t p-3 Privacy">

                <select class="selectpicker mt-2 story">
                    <option>Public</option>
                    <option>Friend</option>
                    <option>Private</option>
                </select>

                <div class="flex space-x-2">
                    <a href="#" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium save-edit-post" data-post-id=<?php ?>>
                        Done </a>
                </div>
                <a href="#" hidden class="bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold">
                    Share </a>
            </div>
        </div>
    </div>
    <!--edit avatar modal -->
    <div id="edit-avatar-modal" class="create-post is-story" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">

            <div class="text-center py-3 border-b">
                <h3 class="text-lg font-semibold"> Edit avatar </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>

            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-2 shadow-sm items-center">

                    <div class="flex flex-1 items-center justify-center space-x-2">
                        <span style="font-size: 16px;">Choose your avatar</span>
                        <label for="ImageInput"><svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </label>

                        <form method="POST" id="uploadForm" name="fanh" enctype="multipart/form-data">
                            <input type="file" hidden name="fileToUpload[]" id="ImageInput" onchange="uploadImgAvatar(this)">
                        </form>
                    </div>

                </div>
            </div>
            <div id="imagePreview" style="text-align: center; margin: 0 auto;">
                <ul style="list-style-type: none;"></ul>
            </div>
            <div class="flex items-center w-full justify-center border-t p-3">
                <div class="flex space-x-2">
                    <a href="#" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium save-edit-avatar" data-post-id=<?php ?>>
                        <input type="hidden" value="<?php echo $_SESSION['userid'] ?>" name="userid"></input>
                        Done </a>
                </div>
            </div>
        </div>
    </div>
    <!--sharepost-->
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
    <!--edit cover modal-->
    <div id="edit-cover-modal" class="create-post is-story" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">

            <div class="text-center py-3 border-b">
                <h3 class="text-lg font-semibold"> Edit cover </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>

            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-2 shadow-sm items-center">
                    <div class="flex flex-1 items-center justify-center space-x-2">
                        <span style="font-size: 16px;">Choose your cover</span>
                        <label for="ImageCover"><svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </label>

                        <form method="POST" name="fanhcover" enctype="multipart/form-data">
                            <input type="file" hidden name="fileToUpload[]" id="ImageCover" onchange="uploadImgAvatar(this)">
                        </form>
                    </div>

                </div>
            </div>
            <div id="imagePreview" style="text-align: center; margin: 0 auto;">
                <ul style="list-style-type: none;"></ul>
            </div>
            <div class="flex items-center w-full justify-center border-t p-3">
                <div class="flex space-x-2">
                    <a href="#" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium save-edit-cover" data-post-id=<?php ?>>
                        <input type="hidden" value="<?php echo $_SESSION['userid'] ?>" name="userid"></input>
                        Done </a>
                </div>

            </div>
        </div>
    </div>
    <!--edit about images-->
    <div id="edit-about-image-modal" class="create-post is-story" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">

            <div class="text-center py-3 border-b">
                <h3 class="text-lg font-semibold"> Edit about image </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>

            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-2 shadow-sm items-center">

                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                        <label for="ImageAbout"><svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </label>

                        <form method="POST" name="fanhAbout" enctype="multipart/form-data">
                            <input type="file" hidden name="fileToUpload[]" multiple id="ImageAbout" onchange="uploadEditImgAbout(this)">
                        </form>
                    </div>

                </div>
            </div>
            <div id="imageAboutPreview" style="text-align: center; margin: 0 auto;">
                <ul style="list-style-type: none;"></ul>
            </div>
            <div class="flex items-center w-full justify-between border-t p-3 Privacy">



                <div class="flex space-x-2">
                    <a href="#" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium save-edit-about-image" data-post-id=<?php ?>>
                        <input type="hidden" value="<?php echo $_SESSION['userid'] ?>" name="userid"></input>
                        Done </a>
                </div>

            </div>
        </div>
    </div>
    <!-- Create new album -->

    <div id="offcanvas-create" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar lg:w-4/12 w-full dark:bg-gray-700 dark:text-gray-300 p-0 bg-white flex flex-col justify-center">

            <button class="uk-offcanvas-close absolute" type="button" uk-close></button>

            <!-- notivication header -->
            <div class="-mb-1 border-b font-semibold px-5 py-5 text-lg">
                <h4> Create album </h4>
            </div>

            <div class="p-6 space-y-3 flex-1">
                <div>
                    <label> Album Name </label>
                    <input type="text" class="with-border" placeholder="">
                </div>
                <div>
                    <label> Visibilty </label>
                    <select id="" name="" class="shadow-none selectpicker with-border">
                        <option data-icon="uil-bullseye"> Private </option>
                        <option data-icon="uil-chat-bubble-user">My Following</option>
                        <option data-icon="uil-layer-group-slash">Unlisted</option>
                        <option data-icon="uil-globe" selected>Puplic</option>
                    </select>
                </div>
                <div uk-form-custom class="w-full py-3">
                    <div class="bg-gray-100 border-2 border-dashed flex flex-col h-32 items-center justify-center relative w-full rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-12">
                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                            <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                        </svg>
                    </div>
                    <input type="file">
                </div>

            </div>
            <div class="p-5">
                <button type="button" class="button w-full">
                    Create Now
                </button>
            </div>


        </div>
    </div>
    <!-- image about preview -->
    <div class="preview-about-image uk-lightbox uk-overflow-hidden uk-lightbox-panel uk-active uk-transition-active">
        <ul class="uk-lightbox-items">
            <li class="uk-active uk-transition-active" style="" tabindex="-1"><img width="750" height="500" src="uploads/posts/img-1.jpg" style="" alt=""></li>
        </ul>
        <div class="uk-lightbox-toolbar uk-position-top uk-text-right uk-transition-slide-top uk-transition-opaque"> <button class="uk-lightbox-toolbar-icon uk-close-large uk-icon uk-close" type="button" uk-close=""><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="close-large">
                    <line fill="none" stroke="#000" stroke-width="1.4" x1="1" y1="1" x2="19" y2="19"></line>
                    <line fill="none" stroke="#000" stroke-width="1.4" x1="19" y1="1" x2="1" y2="19"></line>
                </svg></button> </div> <a class="uk-lightbox-button uk-position-center-left uk-position-medium uk-transition-fade uk-icon uk-slidenav-previous uk-slidenav uk-hidden" href="#" uk-slidenav-previous="" uk-lightbox-item="previous"><svg width="14px" height="24px" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg" data-svg="slidenav-previous">
                <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
            </svg></a> <a class="uk-lightbox-button uk-position-center-right uk-position-medium uk-transition-fade uk-icon uk-slidenav-next uk-slidenav uk-hidden" href="#" uk-slidenav-next="" uk-lightbox-item="next"><svg width="14px" height="24px" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg" data-svg="slidenav-next">
                <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline>
            </svg></a>
        <div class="uk-lightbox-toolbar uk-lightbox-caption uk-position-bottom uk-text-center uk-transition-slide-bottom uk-transition-opaque" style="display: none;"></div>
    </div>
    <!-- Post details modal-->
    <div id="post-details-modal" style="overflow-y: scroll;" class="create-post" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> [Name]'s post </h3>
                <button id="closeModelPost" class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <!-- Append post details here -->
            <div class="post-details-card">
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <?php include("./Websocket/src/Notification.php") ?>
    <!-- For Night mode -->
    <script>
        $(".about-image").click(function(e) {
            e.preventDefault()
            $(".preview-about-image").addClass("uk-open");
            $(".preview-about-image img").attr("src", $(this).attr("src"));
        })

        $(".preview-about-image button").click(function(e) {
            $(".preview-about-image").removeClass("uk-open");
        })

        $(document).keydown(function(e) {
            if (e.key === "Escape" || e.key === "Esc") {
                $(".preview-about-image").removeClass("uk-open");
            }
        });
        // Open model edit about
        var openModalButton = document.getElementsByClassName("edit-about-btn")[0];
        var closeModalButton = document.getElementById("closeModalButton");
        var aboutModal = document.getElementById("aboutModal");

        openModalButton.onclick = function() {
            aboutModal.style.display = "flex";
        };

        closeModalButton.onclick = function() {
            aboutModal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == aboutModal) {
                aboutModal.style.display = "none";
            }
        };


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
    <script src="Js/Timeline.js"></script>
    <script src="Js/Post.js"></script>
    <script src="Js/notification.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="../../unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
<!-- Mirrored from demo.foxthemes.net/socialite/timeline.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jul 2023 17:42:27 GMT -->

</html>