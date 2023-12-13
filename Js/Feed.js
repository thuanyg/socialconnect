// View next post
var windowHeight = window.innerHeight;
var scrolledOnce = false;
var postFetching = false; // Sửa thành postFetching
var offset = 5;
var postDocument = $("#PostContaier");
$(window).scroll(function() {
    var docHeight = postDocument.height();
    var scrollTop = $(this).scrollTop();
    // Kiểm tra xem có đang thực hiện gọi Ajax không và trang có đủ dữ liệu để load thêm không
    if (!postFetching && scrollTop + windowHeight > docHeight - 800 && !scrolledOnce) {
        scrolledOnce = true;
        ViewNextPost();
    } else {
        scrolledOnce = false;
    }
});

function getPostToLoad(offset) {
    postFetching = true;
    $.ajax({
        url: "Ajax/Post.php",
        type: "POST",
        data: {
            offset: offset,
            action: "get-post-to-load"
        },
        cache: false,
        success: function(data) {
            postFetching = false;
            if (data.trim()) {
                postDocument.append(data);
                if (data.trim() == '<div style="text-align: center">Không còn bài viết</div>') {
                    $(window).off('scroll');
                }
            } else {
                return;
            }
        },
    });
}

function ViewNextPost() {
    // console.log("Calling ViewNextPost");
    if (postFetching) return;
    getPostToLoad(offset);
    offset += 5;
}
$(".btn-send-message-birthday").click(function(e) {
    e.preventDefault();
    const friendID = $(this).data("friend-id");
    const userID = $("input[name='txtUserid']").val();
    const messageContent = $(this).prev().val();
    if (messageContent.trim() == "") {
        showNotification("Hãy nhập lời chúc để gửi tới bạn bè!");
        return;
    }
    var message = {
        senderId: userID,
        receiverId: friendID,
        messageContent: messageContent,
        action: "send-message"
    }

    $.ajax({
        url: "Ajax/Message.php",
        type: "POST",
        data: message,
        success: function(data){
            if(data.trim() == "1"){
                showNotification("Đã gửi tin nhắn.");
                $("#birthdays .uk-close")[0].click();
                $("input[name='txtMessage']").val("");
            }
        }
    })

})