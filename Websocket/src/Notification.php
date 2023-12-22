<script type="text/javascript">
    // ----------------<!--Phần xử lý Websocket-->--------------------------------------
    const ws = new WebSocket('ws://26.29.22.58:8081?uid=<?php echo $_SESSION["userid"]; ?>');
    ws.onopen = () => {
        console.log('Connected to the server');
    };

    ws.onmessage = (event) => {
        const data = JSON.parse(event.data);
        console.log((data));
        if (data.action == "like-post") {
            // Nếu là thông báo like từ người khác
            if (data.sender != "Me") {
                var senderID = data.userid;
                var postID = data.postid;
                var avatar = data.avatar_image;
                var last_name = data.last_name;
                var quantity = data.notification_quantity;
                var html = `<li>
                            <a href="post.php?p=${data.postid}">
                                <div class="drop_avatar"> <img src="${avatar}" alt=""></div>
                                    <div class="drop_text">
                                        <p>
                                            <strong>${last_name}</strong> Liked Your Post
                                            <span class="text-link"></span>
                                        </p>
                                        <time> Just now </time>
                                </div>
                            </a>
                        </li>`
                $(".list-notification").prepend(html);
                var numOfNotify = $(".notification-quantity").text();
                numOfNotify = Number(numOfNotify) + 1;
                $(".notification-quantity").text(numOfNotify);
                $("#notification").css('background-color', '#0a8032');
                $("#notification span").html(`<a href='post.php?p=${data.postid}'><strong>${last_name}</strong> đã thích bài viết của bạn<span class="text-link"></span></a>`);
                $("#notification").show();
                setTimeout(() => {
                    $("#notification").fadeOut(2000);
                    $("#notification").css('background-color', '#0e5f7d');
                }, 3000);
            }
        }
        if (data.action == "comment-post") {
            // Nếu là thông báo cmt từ người khác
            if (data.sender != "Me") {
                var senderID = data.userid;
                var postID = data.postid;
                var avatar = data.avatar_image;
                var last_name = data.last_name;
                var quantity = data.notification_quantity;
                var html = `<li>
                            <a href="post.php?p=${data.postid}">
                                <div class="drop_avatar"> <img src="${avatar}" alt=""></div>
                                    <div class="drop_text">
                                        <p>
                                            <strong>${last_name}</strong> commented your post
                                            <span class="text-link"></span>
                                        </p>
                                        <time> Just now </time>
                                </div>
                            </a>
                        </li>`
                $(".list-notification").prepend(html);
                var numOfNotify = $(".notification-quantity").text();
                numOfNotify = Number(numOfNotify) + 1;
                $(".notification-quantity").text(numOfNotify);
                $("#notification").css('background-color', '#0a8032');
                $("#notification span").html(`<a href='post.php?p=${data.postid}'><strong>${last_name}</strong> đã bình luận bài viết của bạn<span class="text-link"></span></a>`);
                $("#notification").show();
                setTimeout(() => {
                    $("#notification").fadeOut(2000);
                    $("#notification").css('background-color', '#0e5f7d');
                }, 5000);
            }
        }
        if (data.action == "share-post") {
            // Nếu là thông báo share từ người khác
            if (data.sender != "Me") {
                var senderID = data.userid;
                var postID = data.postid;
                var avatar = data.avatar_image;
                var last_name = data.last_name;
                var quantity = data.notification_quantity;
                var html = `<li>
                            <a href="post.php?p=${data.postid}">
                                <div class="drop_avatar"> <img src="${avatar}" alt=""></div>
                                    <div class="drop_text">
                                        <p>
                                            <strong>${last_name}</strong> shared your post
                                            <span class="text-link"></span>
                                        </p>
                                        <time> Just now </time>
                                </div>
                            </a>
                        </li>`
                $(".list-notification").prepend(html);
                var numOfNotify = $(".notification-quantity").text();
                numOfNotify = Number(numOfNotify) + 1;
                $(".notification-quantity").text(numOfNotify);
                $("#notification").css('background-color', '#0a8032');
                $("#notification span").html(`<strong>${last_name}</strong> đã chia sẻ bài viết của bạn<span class="text-link"></span>`);
                $("#notification").show();
                setTimeout(() => {
                    $("#notification").fadeOut(2000);
                    $("#notification").css('background-color', '#0e5f7d');
                }, 5000);
            }
        }
        if (data.action == "private") {
            if (data.from != "Me") {
                $("#notification").css('background-color', '#a1b9e4');
                $("#notification span").html(`<a href='chats-friend.php?uid=${data.senderId}'>Message from <strong style:"color: white">${data.name}</strong> : <span class="text-link">${data.messageContent}</span></a>`);
                $("#notification").show();
                setTimeout(() => {
                    $("#notification").fadeOut(2000);
                    $("#notification").css('background-color', '#0e5f7d');
                }, 5000);
            }
        }
    };
    // ----------------<!--Kết thúc xử lý Websocket-->-----------------------------------
</script>