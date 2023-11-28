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

function getPhoto(){
    console.log(profileID);
    $.ajax({
        url: "Ajax/Post.php",
        method: "POST",
        dataType: "html",
        data: {
            userid: profileID,
            action: "show-image-of-orther"
        },
        success: function (data) {
            //console.log(data);
            $("#result").html(data);
            // Photo tab
            $(".photo-tab").on("click", function (e) {
                e.preventDefault();
                $(".photo-tab").removeClass("active");
                $(this).addClass('active');
                if ($(this).hasClass("album")) {
                    $(".photo-of-you").hide();
                    $(".album-of-you").show();
                } else {
                    $(".album-of-you").hide();
                    $(".photo-of-you").show();
                }

            });
            //Phôt click to big
            $(document).ready(function () {
                $('.image-small img').on('click', function () {
                    var imgUrl = $(this).attr('src');
                    $('.image-big img').attr('src', imgUrl);
                    $('.image-big').css({ "display": "block", "opacity": "1", "align-items": "center" });
                });

                //dong anh lon
                $('.image-big .close').on('click', function () {
                    $('.image-big').css({ "display": "none", "opacity": "0" });
                });
            });
        }
    });
}