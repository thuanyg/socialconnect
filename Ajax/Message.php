<?php
include_once("../Classes/message.php");
include_once("../Classes/user.php");
include_once("../Classes/status.php");
include_once("../Classes/timer.php");
if (isset($_POST["action"])) {
    if ($_POST["action"] == "show-message") {
        $mess = new Message();
        $messageData = $mess->getMessage($_POST["senderId"], $_POST["receiverId"]);
        $totalMessage = $mess->countMessage($_POST["senderId"], $_POST["receiverId"]);
        $user = new User();
        $sender_user = $user->getUser($_POST["senderId"]);
        $receiver_user = $user->getUser($_POST["receiverId"]);
        $status_obj = new Status();
        $receiver_status = $status_obj->getStatus($receiver_user["userid"]);
?>
        <div class="messages-headline <?php echo $receiver_user["userid"]; ?>">
            <div style="display: inline-block; position: relative;" class="message-avatar">
                <i class="fas fa-circle 
            <?php
            if ($receiver_status != null && $receiver_status[0]["status"] == "online") echo "online";
            else if ($receiver_status != null && $receiver_status[0]["status"] == "offline") echo "offline";
            ?>-icon icon-small"></i>
                <img src="<?php echo $receiver_user["avatar_image"] ?>" alt="">
            </div>
            <h4 style="font-size: 18px;"> <?php echo $receiver_user["first_name"] . " " . $receiver_user["last_name"]; ?> </h4>
            <span class="statusText">
                <?php
                if ($receiver_status != null && $receiver_status[0]["status"] == "online") echo "Active now";
                else if ($status_obj->offlineTime($receiver_user["userid"]) != null) {
                    $time = $status_obj->offlineTime($receiver_user["userid"]);
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
            <a href="#" class="message-action text-red-500" data-receiver-id="<?php echo $receiver_user["userid"]; ?>" onclick="deleteConversation(this)">
                <i class="icon-feather-trash-2"></i>
                <span class="md:inline hidden" style="font-size: 16px;"> Delete</span>
            </a>
            <span class="message-menu-btn" style="display: none; cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                </svg></span>
        </div>
        <div class="message-search-result" style="" data-receiver-id="<?php echo $receiver_user["userid"]; ?>">
            <h4 style="font-size:16px; margin-left: 10px;" class="search_title">History chat
            </h4>
            <span class="message-search-result-close" onclick="$('.message-search-result').hide();">
                X
            </span>
            <ul class="list-history-message">
            </ul>
        </div>
        </div>
        <div class="message-option">
            <div class="m-option-avatar"><img src="<?php echo $receiver_user["avatar_image"] ?>" alt="" width="100px"></div>
            <a href="profile.php?uid=<?php echo $receiver_user['userid'] ?>"><?php echo $receiver_user["first_name"] . " " . $receiver_user["last_name"]; ?></a>
            <div>
                <span onclick="window.location.href='profile.php?uid=<?php echo $receiver_user['userid'] ?>'">
                    <span>
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <p>Profile</p>
                </span>
                <span>
                    <span class="sl-mute">
                        <i class="fa-solid fa-volume-xmark"></i>
                    </span>
                    <p>Mute</p>
                </span>
                <span class="btn-search-message">
                    <span>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <p>Search</p>
                </span>
            </div>
            <div class="search-message" style="display: none;" data-receiver-id="<?php echo $receiver_user["userid"]; ?>"><input value="" name="txtSearchMessage" type="text" class="form-control uk-open" placeholder="Search for messages" aria-expanded="true"></div>
            <div class="m-custom-chat m-menu-drop-down">
                <div>
                    Custom chat
                    <span><i class="fa-solid fa-caret-down"></i></span>
                    <span style="display: none;"><i class="fa-solid fa-list"></i></span>
                </div>
                <ul class="list-custom-chat">
                    <li><i class="fa-brands fa-affiliatetheme"></i> Change theme</li>
                    <li><i class="fa-solid fa-face-smile"></i> Change emoji</li>
                    <li><i class="fa-solid fa-user-pen"></i> Edit nicknames</li>
                    <li class="btn-search-message"><i class="fa-solid fa-magnifying-glass"></i> Search in conversation</li>
                </ul>
            </div>
            <div class="m-media-chat m-menu-drop-down">
                <div>
                    Media, files and links
                    <span><i class="fa-solid fa-caret-down"></i></span>
                    <span style="display: none;"><i class="fa-solid fa-list"></i></span>
                </div>
                <ul class="list-media-chat">
                    <li><i class="fa-regular fa-image"></i> Media</li>
                    <li><i class="fa-solid fa-file"></i> Files</li>
                    <li><i class="fa-solid fa-link"></i> Links</li>
                </ul>
            </div>
            <div class="m-privacy-chat m-menu-drop-down">
                <div>
                    Privacy and support
                    <span><i class="fa-solid fa-caret-down"></i></span>
                    <span style="display: none;"><i class="fa-solid fa-list"></i></span>
                </div>
                <ul class="list-privacy-chat" style="display: none;">
                    <li><i class="fa-solid fa-volume-off"></i> Mute</li>
                    <li><i class="fa-solid fa-comment-slash"></i> Restric</li>
                    <li><i class="fa-solid fa-triangle-exclamation"></i> Report</li>
                </ul>
            </div>
        </div>
        <div class="message-content-scrolbar" data-simplebar>
            <input type="hidden" name="totalMessage" value="<?php echo $totalMessage ?>">
            <div id="loading" class="">
                <img src="./assets/images/gif/loading_message.svg" alt="Loading...">
                <!-- <p>Loading...</p> -->
            </div>
            <div class="message-content-inner">
                <?php
                if ($messageData != null) {
                    for ($i = sizeof($messageData) - 1; $i >= 0; $i--) {
                        $mess_row = $messageData[$i];
                ?>
                        <!-- Message Content Inner -->
                        <?php
                        if ($mess_row["sender_id"] ==  $sender_user["userid"]) {
                            if ($mess_row["deleted_by_sender"] == false) {
                        ?>
                                <div class="message-bubble me">
                                    <div class="message-bubble-inner">
                                        <div class="message-avatar"><img src="<?php echo $sender_user["avatar_image"] ?>" alt=""></div>
                                        <div class="message-text" data-message-id="<?php echo $mess_row["id"]; ?>">
                                            <p>
                                                <?php
                                                $pattern = '/\b(?:https?|ftp):\/\/[^\s\/$.?#].[^\s]*/';
                                                if (preg_match($pattern, $mess_row["text"], $matches)) {
                                                    $remainingText = preg_replace($pattern, '', $mess_row["text"]); // Phần còn lại ngoài link
                                                ?>
                                                    <?php echo $remainingText ?>
                                                    <a style="color: #eeeee4; text-decoration: underline;" onmouseover="this.style.color='#FFCC00'" onmouseout="this.style.color='#eeeee4'" href="<?php echo $matches[0] ?>"><?php echo $matches[0] ?></a>
                                                <?php
                                                } else if ($mess_row["text"] != null) {
                                                    echo $mess_row["text"];
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <div class="flex-custom">
                                            <div class="flex-custom flex-option" data-message-id="<?php echo $mess_row["id"]; ?>">
                                                <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                                                    </svg></span>
                                                <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M307 34.8c-11.5 5.1-19 16.6-19 29.2v64H176C78.8 128 0 206.8 0 304C0 417.3 81.5 467.9 100.2 478.1c2.5 1.4 5.3 1.9 8.1 1.9c10.9 0 19.7-8.9 19.7-19.7c0-7.5-4.3-14.4-9.8-19.5C108.8 431.9 96 414.4 96 384c0-53 43-96 96-96h96v64c0 12.6 7.4 24.1 19 29.2s25 3 34.4-5.4l160-144c6.7-6.1 10.6-14.7 10.6-23.8s-3.8-17.7-10.6-23.8l-160-144c-9.4-8.5-22.9-10.6-34.4-5.4z" />
                                                    </svg></span>
                                                <span class="custom-button delete-one-chat"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                    </svg></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <!-- Xu ly files -->
                                    <?php
                                    if ($mess_row["media"] != null) {
                                        $media = json_decode($mess_row["media"], true);
                                        for ($j = 0; $j < sizeof($media); $j++) {
                                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                            $mime_type = finfo_file($finfo, "../uploads/messages/" . $media[$j]);

                                    ?>
                                            <!-- Xu ly files end -->
                                            <div class="image-chat" style="text-align: right; margin: 10px; margin-right: 60px;">
                                                <?php
                                                if (strpos($mime_type, 'image/') === 0) {
                                                ?>
                                                    <img class="image-chat-inner" style="max-width: 200px; max-height: 200px; border-radius: 10px; display: inline-block;" src="./uploads/messages/<?php echo $media[$j] ?>">
                                                <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="video-chat" style="text-align: right; margin: 10px; margin-right: 60px;">
                                                <?php
                                                if (strpos($mime_type, 'video/') === 0) {
                                                ?>
                                                    <div class="w-full h-full" style="justify-content: right; display: flex;">
                                                        <video controls>
                                                            <source src="./uploads/messages/<?php echo $media[$j]; ?>" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>


                                            <div class="audio-chat" style="justify-content: right; display: flex; margin-right: 60px;">
                                                <?php
                                                if (strpos($mime_type, 'audio/') === 0) {
                                                ?>
                                                    <audio controls>
                                                        <source src="./uploads/messages/<?php echo $media[$j] ?>" type="audio/mpeg">
                                                    </audio>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                    <?php
                                        }
                                    } ?>

                                </div>
                                <!-- Time Sign -->
                                <div class="message-time-sign">
                                    <span>
                                        <?php
                                        $time = (new Timer())->formatHourMinute($mess_row["date"]);
                                        $timeSince = (new Timer())->TimeSince($mess_row["date"]);
                                        if ($timeSince["hours"] > 23) {
                                            echo $mess_row["date"];
                                        } else echo $time;
                                        ?>
                                    </span>
                                </div>
                            <?php
                            }
                        }
                        if ($mess_row["sender_id"] ==  $receiver_user["userid"]) {
                            if ($mess_row["deleted_by_receiver"] == false) {
                            ?>
                                <div class="message-bubble">
                                    <div class="message-bubble-inner">
                                        <div class="message-avatar"><img src="<?php echo $receiver_user["avatar_image"] ?>" alt=""></div>
                                        <div class="message-text">
                                            <p>
                                                <?php
                                                $pattern = '/\b(?:https?|ftp):\/\/[^\s\/$.?#].[^\s]*/';
                                                if (preg_match($pattern, $mess_row["text"], $matches)) {
                                                    $remainingText = preg_replace($pattern, '', $mess_row["text"]); // Phần còn lại ngoài link
                                                ?>
                                                    <?php echo $remainingText ?>
                                                    <a style="color: #00f; text-decoration: underline;" onmouseover="this.style.color='#FFCC00'" onmouseout="this.style.color='#00f'" href="<?php echo $matches[0] ?>"><?php echo $matches[0] ?></a>
                                                <?php
                                                } else if ($mess_row["text"] != null) {
                                                    echo $mess_row["text"];
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <div class="flex-custom flex-custom-left">
                                            <div class="flex-custom flex-option" data-message-id="<?php echo $mess_row["id"]; ?>">
                                                <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                                                    </svg></span>
                                                <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M307 34.8c-11.5 5.1-19 16.6-19 29.2v64H176C78.8 128 0 206.8 0 304C0 417.3 81.5 467.9 100.2 478.1c2.5 1.4 5.3 1.9 8.1 1.9c10.9 0 19.7-8.9 19.7-19.7c0-7.5-4.3-14.4-9.8-19.5C108.8 431.9 96 414.4 96 384c0-53 43-96 96-96h96v64c0 12.6 7.4 24.1 19 29.2s25 3 34.4-5.4l160-144c6.7-6.1 10.6-14.7 10.6-23.8s-3.8-17.7-10.6-23.8l-160-144c-9.4-8.5-22.9-10.6-34.4-5.4z" />
                                                    </svg></span>
                                                <span class="custom-button delete-one-chat"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                    </svg></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <!-- Xu ly files -->
                                    <?php
                                    if ($mess_row["media"] != null) {
                                        $media = json_decode($mess_row["media"], true);
                                        for ($j = 0; $j < sizeof($media); $j++) {
                                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                            $mime_type = finfo_file($finfo, "../uploads/messages/" . $media[$j]);

                                    ?>
                                            <!-- Xu ly files end -->
                                            <div class="image-chat" style="text-align: left; margin: 10px; margin-left: 60px;">
                                                <?php
                                                if (strpos($mime_type, 'image/') === 0) {
                                                ?>
                                                    <img class="image-chat-inner" style="max-width: 200px; max-height: 200px; border-radius: 10px; display: inline-block;" src="./uploads/messages/<?php echo $media[$j] ?>">
                                                <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="video-chat" style="text-align: left; margin: 10px; margin-left: 60px;">
                                                <?php
                                                if (strpos($mime_type, 'video/') === 0) {
                                                ?>
                                                    <div class="w-full h-full" style="justify-content: right; display: flex;">
                                                        <video controls>
                                                            <source src="./uploads/messages/<?php echo $media[$j]; ?>" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="audio-chat" style="justify-content: left; display: flex; margin-left: 60px;">
                                                <?php
                                                if (strpos($mime_type, 'audio/') === 0) {
                                                ?>
                                                    <audio controls>
                                                        <source src="./uploads/messages/<?php echo $media[$j] ?>" type="audio/mpeg">
                                                    </audio>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                    <?php
                                        }
                                    } ?>
                                </div>
                                <!-- Time Sign -->
                                <div class="message-time-sign">
                                    <span>
                                        <?php
                                        $time = (new Timer())->formatHourMinute($mess_row["date"]);
                                        $timeSince = (new Timer())->TimeSince($mess_row["date"]);
                                        if ($timeSince["hours"] > 23) {
                                            echo $mess_row["date"];
                                        } else echo $time;
                                        ?>
                                    </span>
                                </div>

                <?php
                            }
                        }
                    }
                }
                ?>
            </div>
            <!-- Message Content Inner / End -->
            <div class="message-bubble message-typing" style="display: none;" data-receivcer-id="<?php echo $_POST["receiverId"]; ?>">
                <div class="message-bubble-inner">
                    <div class="message-avatar"><img src="<?php echo $receiver_user["avatar_image"] ?>" alt=""></div>
                    <div class="message-text">
                        <!-- Typing Indicator -->
                        <div class="typing-indicator">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="message-reply">
                <textarea name="taMessage" cols="" rows="1" aria-setsize="10" placeholder="Your Message"></textarea>
                <!--Show Image Preview-->
                <div id="imagePreview" style="text-align: center; margin: 0 auto;"></div>
                <!--Show emoji-->
                <div>
                    <div id="emojiPicker" style="position: relative; bottom:0;z-index: 1000;"></div>
                </div>
                <div style="margin: 0 10px;" class="flex bg-gray-50 border border-purple-100 rounded-2xl p-2 shadow-sm items-center">
                    <div class="lg:block hidden ml-1" style="margin: 0 10px;"> Add </div>
                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                        <label for="FileInput" class="message-attachment image-item">
                            <svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </label>
                        <label class="message-attachment emojiPicker-item">
                            <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden="" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path>
                            </svg>
                        </label>
                        <label for="FileInput" class="message-attachment music-item">
                            <svg class="text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" id="veiw-more" hidden="" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                            </svg>
                        </label>
                        <a href="" class="message-attachment -item">
                            <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden="" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </a>

                        <!-- view more -->
                        <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more" uk-toggle="target: #veiw-more; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path>
                        </svg>
                    </div>
                    <!-- vSet to Form -->
                    <form method="POST" id="uploadForm" enctype="multipart/form-data">
                        <input type="file" hidden name="fileToUpload[]" id="FileInput" multiple>
                        <input type="file" hidden id="VideoInput">
                    </form>
                </div>

                <button class="button ripple-effect send-submit" data-receiver-id="<?php echo $receiver_user["userid"]; ?>" onclick="sendMessage(this)">Send</button>
            </div>
        </div>
    <?php
    }


    // Get message load infinity

    if ($_POST["action"] == "get-message") {
        $senderId = $_POST["senderId"];
        $receiverId = $_POST["receiverId"];
        $offset = $_GET["offset"];
        $mess = new Message();
        $totalMessage = $mess->countMessage($senderId, $receiverId);
        $messageData = $mess->getMessagePrevious($senderId, $receiverId, $offset);
        $user = new User();
        $sender_user = $user->getUser($_POST["senderId"]);
        $receiver_user = $user->getUser($_POST["receiverId"]);
        $status_obj = new Status();
        $receiver_status = $status_obj->getStatus($receiver_user["userid"]);
    ?>
        <?php
        if ($messageData != null) {
        ?>
            <!-- <div class="message-content-inner"> -->
            <?php
            for ($i = count($messageData) - 1; $i >= 0; $i--) {
                $mess_row = $messageData[$i];
            ?>
                <!-- Message Content Inner -->
                <?php
                if ($mess_row["sender_id"] ==  $senderId) {
                    if ($mess_row["deleted_by_sender"] == false) {
                ?>
                        <div class="message-bubble me">
                            <div class="message-bubble-inner">
                                <div class="message-avatar"><img src="<?php echo $sender_user["avatar_image"] ?>" alt=""></div>
                                <div class="message-text">
                                    <p>
                                        <?php
                                        $pattern = '/\b(?:https?|ftp):\/\/[^\s\/$.?#].[^\s]*/';
                                        if (preg_match($pattern, $mess_row["text"], $matches)) {
                                            $remainingText = preg_replace($pattern, '', $mess_row["text"]); // Phần còn lại ngoài link
                                        ?>
                                            <?php echo $remainingText ?>
                                            <a style="color: #00f; text-decoration: underline;" onmouseover="this.style.color='#FFCC00'" onmouseout="this.style.color='#00f'" href="<?php echo $matches[0] ?>"><?php echo $matches[0] ?></a>
                                        <?php
                                        } else if ($mess_row["text"] != null) {
                                            echo $mess_row["text"];
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="flex-custom">
                                    <div class="flex-custom flex-option" data-message-id="<?php echo $mess_row["id"]; ?>">
                                        <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                                            </svg></span>
                                        <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M307 34.8c-11.5 5.1-19 16.6-19 29.2v64H176C78.8 128 0 206.8 0 304C0 417.3 81.5 467.9 100.2 478.1c2.5 1.4 5.3 1.9 8.1 1.9c10.9 0 19.7-8.9 19.7-19.7c0-7.5-4.3-14.4-9.8-19.5C108.8 431.9 96 414.4 96 384c0-53 43-96 96-96h96v64c0 12.6 7.4 24.1 19 29.2s25 3 34.4-5.4l160-144c6.7-6.1 10.6-14.7 10.6-23.8s-3.8-17.7-10.6-23.8l-160-144c-9.4-8.5-22.9-10.6-34.4-5.4z" />
                                            </svg></span>
                                        <span class="custom-button delete-one-chat"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                            </svg></span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Xu ly files -->
                            <?php
                            if ($mess_row["media"] != null) {
                                $media = json_decode($mess_row["media"], true);
                                for ($j = 0; $j < sizeof($media); $j++) {
                                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime_type = finfo_file($finfo, "../uploads/messages/" . $media[$j]);

                            ?>
                                    <!-- Xu ly files end -->
                                    <div class="image-chat" style="text-align: right; margin: 10px;">
                                        <?php
                                        if (strpos($mime_type, 'image/') === 0) {
                                        ?>
                                            <img class="image-chat-inner" style="max-width: 200px; max-height: 200px; border-radius: 10px; display: inline-block;" src="./uploads/messages/<?php echo $media[$j] ?>">
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="video-chat" style="text-align: right; margin: 10px;">
                                        <?php
                                        if (strpos($mime_type, 'video/') === 0) {
                                        ?>
                                            <div class="w-full h-full" style="justify-content: right; display: flex;">
                                                <video controls>
                                                    <source src="./uploads/messages/<?php echo $media[$j]; ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>


                                    <div class="audio-chat" style="justify-content: right; display: flex;">
                                        <?php
                                        if (strpos($mime_type, 'audio/') === 0) {
                                        ?>
                                            <audio controls>
                                                <source src="./uploads/messages/<?php echo $media[$j] ?>" type="audio/mpeg">
                                            </audio>
                                        <?php
                                        }
                                        ?>
                                    </div>
                            <?php
                                }
                            } ?>
                        </div>
                        <!-- Time Sign -->
                        <div class="message-time-sign">
                            <span>
                                <?php
                                $time = (new Timer())->formatHourMinute($mess_row["date"]);
                                $timeSince = (new Timer())->TimeSince($mess_row["date"]);
                                if ($timeSince["hours"] > 23) {
                                    echo $mess_row["date"];
                                } else echo $time;
                                ?>
                            </span>
                        </div>
                    <?php
                    }
                }
                if ($mess_row["sender_id"] ==  $receiverId) {
                    if ($mess_row["deleted_by_sender"] == false) {
                    ?>
                        <div class="message-bubble">
                            <div class="message-bubble-inner">
                                <div class="message-avatar"><img src="<?php echo $receiver_user["avatar_image"] ?>" alt=""></div>
                                <div class="message-text">
                                    <p>
                                        <?php
                                        $pattern = '/\b(?:https?|ftp):\/\/[^\s\/$.?#].[^\s]*/';
                                        if (preg_match($pattern, $mess_row["text"], $matches)) {
                                            $remainingText = preg_replace($pattern, '', $mess_row["text"]); // Phần còn lại ngoài link
                                        ?>
                                            <?php echo $remainingText ?>
                                            <a style="color: #00f; text-decoration: underline;" onmouseover="this.style.color='#FFCC00'" onmouseout="this.style.color='#00f'" href="<?php echo $matches[0] ?>"><?php echo $matches[0] ?></a>
                                        <?php
                                        } else if ($mess_row["text"] != null) {
                                            echo $mess_row["text"];
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="flex-custom">
                                    <div class="flex-custom flex-option" data-message-id="<?php echo $mess_row["id"]; ?>">
                                        <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                                            </svg></span>
                                        <span class="custom-button"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M307 34.8c-11.5 5.1-19 16.6-19 29.2v64H176C78.8 128 0 206.8 0 304C0 417.3 81.5 467.9 100.2 478.1c2.5 1.4 5.3 1.9 8.1 1.9c10.9 0 19.7-8.9 19.7-19.7c0-7.5-4.3-14.4-9.8-19.5C108.8 431.9 96 414.4 96 384c0-53 43-96 96-96h96v64c0 12.6 7.4 24.1 19 29.2s25 3 34.4-5.4l160-144c6.7-6.1 10.6-14.7 10.6-23.8s-3.8-17.7-10.6-23.8l-160-144c-9.4-8.5-22.9-10.6-34.4-5.4z" />
                                            </svg></span>
                                        <span class="custom-button delete-one-chat"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                            </svg></span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Xu ly files -->
                            <?php
                            if ($mess_row["media"] != null) {
                                $media = json_decode($mess_row["media"], true);
                                for ($j = 0; $j < sizeof($media); $j++) {
                                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime_type = finfo_file($finfo, "../uploads/messages/" . $media[$j]);

                            ?>
                                    <!-- Xu ly files end -->
                                    <div class="image-chat" style="text-align: left; margin: 10px;">
                                        <?php
                                        if (strpos($mime_type, 'image/') === 0) {
                                        ?>
                                            <img class="image-chat-inner" style="max-width: 200px; max-height: 200px; border-radius: 10px; display: inline-block;" src="./uploads/messages/<?php echo $media[$j] ?>">
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="video-chat" style="text-align: left; margin: 10px;">
                                        <?php
                                        if (strpos($mime_type, 'video/') === 0) {
                                        ?>
                                            <div class="w-full h-full" style="justify-content: right; display: flex;">
                                                <video controls>
                                                    <source src="./uploads/messages/<?php echo $media[$j]; ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>


                                    <div class="audio-chat" style="justify-content: left; display: flex;">
                                        <?php
                                        if (strpos($mime_type, 'audio/') === 0) {
                                        ?>
                                            <audio controls>
                                                <source src="./uploads/messages/<?php echo $media[$j] ?>" type="audio/mpeg">
                                            </audio>
                                        <?php
                                        }
                                        ?>
                                    </div>
                            <?php
                                }
                            } ?>
                        </div>
                        <!-- Time Sign -->
                        <div class="message-time-sign">
                            <span>
                                <?php
                                $time = (new Timer())->formatHourMinute($mess_row["date"]);
                                $timeSince = (new Timer())->TimeSince($mess_row["date"]);
                                if ($timeSince["hours"] > 23) {
                                    echo $mess_row["date"];
                                } else echo $time;
                                ?>
                            </span>
                        </div>
                <?php
                    }
                } ?>

                <!-- </div> -->
<?php
            }
        }
    }

    if ($_POST["action"] == "delete-conversation") {
        $userid = $_POST["userid"];
        $receiverId = $_POST["receiverID"];
        $mess = new Message();
        echo $mess->deleteConversation($userid, $receiverId);
    }

    if ($_POST["action"] == "get-total-message") {
        $senderId = $_POST["senderId"];
        $receiverId = $_POST["receiverId"];
        $mess = new Message();
        echo $mess->countMessage($senderId, $receiverId);
    }
    if ($_POST["action"] == "delete-one-chat") {
        $chatID = $_POST["chatID"];
        $mess = new Message();
        echo $mess->deleteOneChat($chatID);
    }
    if ($_POST["action"] == "delete-one-chat-friend") {
        $chatID = $_POST["chatID"];
        $mess = new Message();
        echo $mess->deleteOneChatFriend($chatID);
    }
    if ($_POST["action"] == "delete-chat") {
        $chatID = $_POST["chatID"];
        $mess = new Message();
        echo $mess->deleteChat($chatID);
    }
}
?>