<script type="text/javascript">
    // ----------------<!--Phần xử lý Websocket-->--------------------------------------
    const ws = new WebSocket('ws://192.168.88.105:8081?uid=<?php echo $_SESSION["userid"]; ?>');
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
                $(".list-notification").append(html);
                var numOfNotify = $(".notification-quantity").text();
                numOfNotify = Number(numOfNotify) + 1;
                $(".notification-quantity").text(numOfNotify);
                $("#notification span").html(`<strong>${last_name}</strong> đã thích bài viết của bạn<span class="text-link"></span>`);
                $("#notification").show();
                setTimeout(() => {
                    $("#notification").hide();
                }, 3000);
            }
        }
    };
    // ----------------<!--Kết thúc xử lý Websocket-->-----------------------------------
</script>