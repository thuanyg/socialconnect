// View next post
var userID = $("input[name='txtUserid']").val();
var profileID = $("input[name='txtUserProfileId']").val();
var windowHeight = window.innerHeight;
var scrolledOnce = false;
var postFetching = false; // Sửa thành postFetching
var offset = 5;
var postDocument = $("#PostContaier");
var shouldLoadMore = true;

$(window).scroll(function() {
    if (shouldLoadMore) {
        var docHeight = postDocument.height();
        var scrollTop = $(this).scrollTop();

        if (!postFetching && scrollTop + windowHeight > docHeight - 800 && !scrolledOnce) {
            scrolledOnce = true;
            ViewNextPost();
        } else {
            scrolledOnce = false;
        }
    }
});

function getPostToLoad(userid, offset) {
    postFetching = true;
    $.ajax({
        url: "Ajax/Post.php",
        type: "POST",
        data: {
            userid: profileID,
            offset: offset,
            action: "get-post-profile-to-load"
        },
        cache: false,
        success: function(data) {
            postFetching = false;
            if (data.trim()) {
                postDocument.append(data);
                if (data.trim() == '<div style="text-align: center">Không còn bài viết</div>') {
                    shouldLoadMore = false;
                    console.log("End of the posts");
                }
            } else {
                shouldLoadMore = false;
                return;
            }
        },
    });
}

function ViewNextPost() {
    // console.log("Calling ViewNextPost");
    if (postFetching) return;
    getPostToLoad(userID, offset);
    offset += 5;
}