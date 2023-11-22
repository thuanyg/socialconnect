// Phần code thông báo notification -->
const notification = document.getElementById('notification');
const notificationText = document.getElementById('notification-text');
const closeNotification = document.getElementById('close-notification');
// Hàm hiển thị thông báo
function showNotification(message) {
    notificationText.innerText = message;
    notification.style.display = 'block';
    setTimeout(() => {
        hideNotification();
    }, 2000);
}
// Hàm ẩn thông báo
function hideNotification() {
    notification.style.display = 'none';
}

// Sự kiện click để đóng thông báo
closeNotification.addEventListener('click', hideNotification);

$(".like-post-btn").on("click", function (e) {
    e.preventDefault();
    var postID = $(this).parent().attr("post-id");
    var userID = $("input[name='txtUserid']").val();
    // console.log(userID + " " + postID);
    var notify = {
        userid: userID,
        postid: postID,
        action: "like-post"
    };
    ws.send(JSON.stringify(notify));
});

$(".notification-btn").on("click", function (e) {
    e.preventDefault();
    if ($(this).attr('aria-expanded') == 'false') {
        var userID = $("input[name='txtUserid']").val();
        $.ajax({
            url: "Ajax/Notification.php",
            type: "POST",
            data: {
                userid: userID,
                action: "get-notification"
            },
            success: function (data) {
                if (data) {
                    var data = JSON.parse(data);
                    $(".list-notification").empty();
                    data.forEach(item => {
                        var htmlLike = `<li>
                                <a href="post.php?p=${item.related_object_id}">
                                    <div class="drop_avatar"> <img src="" alt=""></div>
                                        <div class="drop_text">
                                                <p>
                                                    <strong></strong> Liked Your Post
                                                    <span class="text-link"></span>
                                                </p>
                                                <time> Just now </time>
                                        </div>
                                </a>
                            </li>`
                        $(".list-notification").append(htmlLike);
                    });
                    // $(".notification-quantity").show();
                    // $(".notification-quantity").text(quantity);
                }
            }
        })
    }
});
// ------------------------------------------------------------------------------------------------------------------
