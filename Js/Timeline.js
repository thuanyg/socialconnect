// View next post
var userID = $("input[name='txtUserid']").val();
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
            userid: userid,
            offset: offset,
            action: "get-post-timeline-to-load"
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
// Click the tabs
$(".friend-tab").on("click", function(e) {
    e.preventDefault();
    $(".friend-tab").removeClass("active"); 
    $(this).addClass("active");
    if($(this).index() == 1){ // Tab recently
        $(".tab").hide();
        $(".recently-friend-tab").show();
    }
    if($(this).index() == 0){ // Tab friend
        $(".tab").hide();
        $(".all-friend-tab").show();
    }
    // if($(this).index() == 2){ // Tab family
    //     $(".tab").hide();
    //     $(".recently-friend-tab").show();
    // }
    // if($(this).index() == 3){ // Tab University
    //     $(".tab").hide();
    //     $(".recently-friend-tab").show();
    // }
});

//Photo of you
function showImage() {

    var userid = $("input[name='txtUserid']").val();
    console.log(userid);
    $.ajax({
        url: "Ajax/Post.php",
        method: "POST",
        dataType: "html",
        data: {
            userid: userid,
            action: "show-image-of-you"
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


$("#about-save-btn").click(function(e) {
    // e.preventDefault();
    if (confirm("Do you want to change about?")) {
        var userid = $(".data-userid")[0].textContent;
        var birthday = $("input[name='dBirthday']").val();
        var address = $("input[name='txtAddress']").val();
        var education = $("input[name='txtEducation']").val();
        var desc = $("textarea[name='taBio']").val();
        showNotification("Processing...");
        $.ajax({
            url: "Ajax/User.php",
            method: "POST",
            dataType: "html",
            data: {
                userid: userid,
                birthday: birthday,
                address: address,
                education: education,
                desc: desc,
                action: "add-about"
            },
            success: function(data) {
                if (data == 1) {
                    showNotification("You have successfully added about");
                    window.location.href = "timeline.php"
                } else {
                    showNotification("Something wrong!");
                }
            }
        });
    }
});
