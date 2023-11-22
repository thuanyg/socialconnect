<?php
include("../Classes/post.php");
include("../Classes/timer.php");
include("../Classes/user.php");

if (isset($_POST["action"])) {
    if ($_POST["action"] == "create-post") {
        // Upload Image
        if (isset($_POST["images"])) {
            $images = json_encode($_POST["images"]);
        } else $images = "";
        $data = array(
            "userid" => $_POST["userid"],
            "post" => $_POST["post"],
            "images" => $images,
            "privacy" => $_POST["privacy"]
        );
        $p = new Post();
        // Create post
        if ($p->createPost($data, $data["userid"])) {
            $post = $p->getNewPost($data["userid"]);
            if ($post != null) {
                if ($post['has_image'] == 1) {
                    $t = new Timer();
                    $time = $t->TimeSince($post["date"]); // Return array
                    $hours = $time["hours"];
                    $minutes = $time["minutes"];
                    $seconds = $time["seconds"];
                    //Get user
                    $user = new User();
                    $userCurrent = $user->getUser($data["userid"]);
                    // Upload picture
?>

                    <div class="card lg:mx-0 uk-animation-slide-bottom-small">

                        <!-- post header-->
                        <div class="flex justify-between items-center lg:p-4 p-2.5">
                            <div class="flex flex-1 items-center space-x-4">
                                <a href="#">
                                    <img src="<?php echo $userCurrent["avatar_image"] ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                </a>
                                <div class="flex-1 font-semibold capitalize">
                                    <a href="#" class="text-black dark:text-gray-100"> <?php echo $userCurrent["first_name"] . " " . $userCurrent["last_name"] ?> </a>
                                    <div class="text-gray-700 flex items-center space-x-2"><span><?php if ($hours <= 0) echo $time["minutes"] . " phút trước";
                                                                                                    else echo $hours . "h " . $time["minutes"] . " phút trước";
                                                                                                    ?></span> <ion-icon name="people"></ion-icon></div>
                                </div>
                            </div>
                            <div>
                                <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">

                                    <ul class="space-y-1">
                                        <li>
                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                <i class="uil-share-alt mr-1"></i> Share
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                <i class="uil-edit-alt mr-1"></i> Edit Post
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                <i class="uil-comment-slash mr-1"></i> Disable comments
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                <i class="uil-favorite mr-1"></i> Add favorites
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="-mx-2 my-2 dark:border-gray-800">
                                        </li>
                                        <li>
                                            <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                                <i class="uil-trash-alt mr-1"></i> Delete
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <!-- Show Text Post -->
                        <div class="p-5 pt-0 border-b dark:border-gray-700">
                            <?php echo $post["post"]; ?>
                        </div>

                        <!-- Show Image Post -->
                        <div uk-lightbox>
                            <div class="grid grid-cols-2 gap-2 px-5">
                                <?php
                                if ($post["media"] != null) {
                                    $media_json = $post["media"];
                                    $media = json_decode($media_json, true);
                                    for ($j = 0; $j < sizeof($media); $j++) {
                                        $fileInfo = pathinfo($media[$j]);
                                        // Lấy phần mở rộng của tên tệp và chuyển nó thành chữ thường
                                        $fileExtension = strtolower($fileInfo['extension']);
                                        if ($fileExtension === 'jpg' || $fileExtension === 'jpeg' || $fileExtension === 'png' || $fileExtension === 'webp') {

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



                        <!--Like comment share-->
                        <div class="p-4 space-y-3">
                            <div class="flex space-x-4 lg:font-bold">
                                <a href="#" class="flex items-center space-x-2">
                                    <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                        </svg>
                                    </div>
                                    <div> Like</div>
                                </a>
                                <a href="#" class="flex items-center space-x-2">
                                    <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div> Comment</div>
                                </a>
                                <a href="#" class="flex items-center space-x-2 flex-1 justify-end">
                                    <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                            <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                        </svg>
                                    </div>
                                    <div> Share</div>
                                </a>
                            </div>
                        </div>
                    </div>
<?php

                }
            }
        }
    }
    // Delete post
    if($_POST["action"] == "delete-post"){
        $postid = $_POST["postid"];
        $post = new Post();
        $result = $post->deletePost($postid);
        if($result) echo 1;
        else echo 0;
    }
    
    if($_POST["action"] == "get-post"){
        $postid = $_POST["postid"];
        $post = new Post();
        $result = $post->getAPost($postid);
        echo json_encode($result);
    }
    //Edit post
    if($_POST["action"] == "edit-post"){
        $postText = $_POST["postText"];
        $privacy = $_POST["privacy"];
        $postid = $_POST["postId"];
        $images = json_encode($_POST["images"]);
        $data = array(
            "post" => $postText,
            "images" => $images,
            "privacy" => $privacy
        );
        $post = new Post();
        $result = $post->updatePost($postid, $data);
        
        echo $result;
    }
}


?>