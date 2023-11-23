// View next post
var windowHeight = window.innerHeight;
var scrolledOnce = false;
var postFetching = false; // Sửa thành postFetching
var offset = 5;
var postDocument = $("#PostContaier");
$(window).scroll(function () {
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
        success: function (data) {
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