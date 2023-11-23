<?php
include("../Classes/database.php");
include("../Classes/search.php");
include("../Classes/timer.php");
include("../Classes/user.php");
include("../Classes/post.php");
session_start();
if (isset($_GET["action"])) {
    if ($_GET["action"] == "search-user") {
        $query = $_GET["query"];
        $s = new Search();
        $result = $s->SearchUser($query);
        if ($result != null) {
            for ($i = 0; $i < sizeof($result); $i++) {
?>
                <li>
                    <a href="profile.php?uid=<?php echo $result[$i]["userid"] ?>">
                        <img src="<?php echo $result[$i]["avatar_image"] ?>" alt="" class="list-avatar">
                        <div class="list-name"> <?php echo $result[$i]["first_name"] . " " . $result[$i]["last_name"] ?> </div>

                    </a>
                </li>
            <?php
            }
        }
    }
    if ($_GET["action"] == "search-message") {
        $query = $_GET["query"];
        $s = new Search();
        $result = $s->SearchUser($query);
        if ($result != null) {
            for ($i = 0; $i < sizeof($result); $i++) {
            ?>
                <li>
                    <a href="chats-friend.php?uid=<?php echo $result[$i]["userid"] ?>">
                        <div class="" style="padding: 5px">
                            <img style="width: 30px; display: inline-block;" src="<?php echo $result[$i]["avatar_image"] ?>" alt="" class="list-avatar">
                            <span style="font-size: 16px;"><?php echo $result[$i]["first_name"] . " " . $result[$i]["last_name"] ?> </span>
                        </div>
                    </a>
                </li>
            <?php
            }
        }
    }
    if ($_REQUEST["action"] == "find-history-message") {
        $query = $_GET["query"];
        $senderID = $_GET["userID"];
        $receiverID = $_GET["receiverID"];
        $s = new Search();
        $result = $s->SearchHistoryMessage($senderID, $receiverID, $query);
        if ($result != null) {
            echo "<div style='text-align:center; color: blue'>" . count($result) . " results</div>";
            for ($i = 0; $i < sizeof($result); $i++) {
            ?>
                <div class="loading-history"></div>
                <li class="message-result-row" style="color: #fff; background-color: #2a41e8;" data-message-id="<?php echo $result[$i]["id"] ?>">
                    <div class="" style="padding: 5px">
                        <span style="font-size: 16px;">Message: <?php echo $result[$i]["text"] ?></span>
                        <span style="padding: 0 3px;">|</span>
                        <span style="font-size: 16px;">Date: <?php echo $result[$i]["date"] ?></span>
                    </div>
                </li>
            <?php
            }
        }
    }
    if ($_REQUEST["action"] == "search-friend") {
        $query = $_GET["query"];
        $s = new Search();
        $u = new User();

        $result = $s->SearchFriend($query);
        if ($result != null) {
            for ($i = 0; $i < sizeof($result); $i++) {

            ?>
                <li>
                    <a href="profile.php?uid=<?php echo $result[$i]["userid"] ?>">
                        <img src="<?php echo $result[$i]["avatar_image"] ?>" alt="" class="list-avatar">
                        <div class="list-name"> <?php echo $result[$i]["first_name"] . " " . $result[$i]["last_name"] ?> 
                        <p><?php
                                if (($resultUser = $u->getAbout($result[$i]["userid"])) != '') {
                                    if ($resultUser['desc'] != '' && $resultUser['address'] != '' && $resultUser['edu'] != '') {
                                        echo $resultUser['desc'] . ' - Đang sống ở ' . $resultUser['address'] . ' - Học tại ' . $resultUser['edu'];
                                    }
                                }
                                ?></p>
                    </div>
                        <div class="list-about">
                            
                        </div>
                    </a>
                </li>
                <?php
            }
        } else {
            //echo "<div style='text-align:center; color: blue'>No results</div>";
        }
    }
    if ($_REQUEST["action"] == "search-post") {
        $query = $_GET["query"];
        $s = new Search();
        $user = new User();
        $post = $s->SearchPost($query);
        if ($post != null) {
            for ($i = 0; $i < sizeof($post); $i++) {
                if ($post[$i]['has_image'] == 1) {
                    $t = new Timer();
                    $time = $t->TimeSince($post[$i]["date"]); // Return array
                    $hours = $time["hours"];
                    $minutes = $time["minutes"];
                    $seconds = $time["seconds"];
                    // Get user for each post
                    $userOfPost = $user->getUser($post[$i]["userid"]);
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
                                        if ($userOfPost["userid"] ==  $_SESSION["userid"]) {
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
                                        if ($userOfPost["userid"] ==  $_SESSION["userid"]) {
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

                            <div class="flex space-x-4 lg:font-bold" post-id="<?php echo $post[0]["postid"] ?>">
                                <a href="#" class="like-post-btn flex items-center space-x-2">
                                    <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                        </svg>
                                    </div>
                                    <div> Like</div>
                                </a>
                                <a href="#" class="comment-post-btn flex items-center space-x-2">
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
                                <div class="flex items-center">
                                    <img src="" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                                    <img src="" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                                    <img src="" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                                </div>
                                <div class="dark:text-gray-100">
                                    Liked <strong> Johnson</strong> and <strong> 209 Others </strong>
                                </div>
                            </div>

                            <div class="border-t py-4 space-y-4 dark:border-gray-600">
                                <div class="flex">
                                    <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                        <img src="" alt="" class="absolute h-full rounded-full w-full">
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
                                        <img src="" alt="" class="absolute h-full rounded-full w-full">
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
        }
    } else {
        //echo '<div style="text-align: center">Không có bài viết</div>';
    }
    ?>

<?php
};
?>