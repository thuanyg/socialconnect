
// Search users - Ajax
var searchDocument = $("#searchResults");
var scrolledOnce = false;
var searchFetching = false;
var offset = 10;
var shouldLoadMore = true;
$("input[name='txtSearch']").on("input", function () {
    var query = $(this).val();
    $("#searchResults > :not(#search-loading)").remove();
    if (query.trim() !== "") {
        Search(query);
        $(".header_search_dropdown").scroll(function () {
            if (shouldLoadMore) {
                var scrollTop = $(this).scrollTop();
                var windowHeight = $(this).height();
                var docHeight = searchDocument.height();

                if (!searchFetching && scrollTop + windowHeight > docHeight - 100 && !scrolledOnce) {
                    scrolledOnce = true;
                    ViewNextSearchResults();
                } else {
                    scrolledOnce = false;
                }
            }
        });
        function getResultsToLoad(query, offset) {
            searchFetching = true;
            $("#search-loading").show();
            setTimeout(() => {
                $.ajax({
                    url: "Ajax/Search.php",
                    type: "GET",
                    data: {
                        offset: offset,
                        query: query,
                        action: "get-search-results-to-load"
                    },
                    cache: false,
                    success: function (data) {
                        searchFetching = false;
                        if (data.trim()) {
                            $("#searchResults #search-loading").before(data);
                            if (data.trim() == '<div style="text-align: center" hidden>Finished Searching</div>') {
                                shouldLoadMore = false;
                                $(window).off('scroll');
                                $("#search-loading").hide();
                            }
                        } else {
                            shouldLoadMore = false;
                            return;
                        }
                        $("#search-loading").hide();
                    },
                });
            }, 2000);

        }
        function ViewNextSearchResults() {
            // console.log("Calling ViewNextPost");
            if (searchFetching) return;
            getResultsToLoad(query, offset);
            offset += 5;
        }
    }
});

$("input[name='txtSearch']").keyup(function (e) {
    if (e.which === 13) {
        var query = $(this).val();
        SearchFriend(query);
        SearchPost(query);
    }
});



function Search(query) {
    $.ajax({
        url: "Ajax/Search.php", // Your server-side search script
        type: "GET",
        dataType: "html",
        data: {
            query: query,
            action: "search-user"
        },
        success: function (data) {
            if (data) {
                $(".header_search_dropdown").addClass("uk-open");
                $("#searchResults #search-loading").before(data);
            }
        },
    });
}
function SearchFriend(query) {
    $.ajax({
        url: "Ajax/Search.php", // Your server-side search script
        type: "GET",
        dataType: "html",
        data: {
            query: query,
            action: "search-friend"
        },
        success: function (data) {
            if (data) {
                sessionStorage.setItem("myData", JSON.stringify(data));
                window.location.href = "search-results.php";
            }
        }
    })
}
function SearchPost(query) {
    $.ajax({
        url: "Ajax/Search.php", // Your server-side search script
        type: "GET",
        dataType: "html",
        data: {
            query: query,
            action: "search-post"
        },
        success: function (postSearchData) {
            if (postSearchData) {
                sessionStorage.setItem("postSearchData", JSON.stringify(postSearchData));
                window.location.href = "search-results.php";
                //console.log(postSearchData)
            }
        }
    })
}

function SaveNotification(btn, type) {
    var postID = btn.parent().attr("post-id");
    var userID = $("input[name='txtUserid']").val();
    var action = "";
    if (type == "like") {
        action = "like-post";
    }
    if (type == "comment") {
        action = "comment-post";
    }
    if (type == "share") {
        action = "share-post";
    }
    var notify = {
        userid: userID,
        postid: postID,
        action: action
    };
    $.ajax({
        url: "Ajax/Notification.php",
        type: "POST",
        data: notify,
        success: function (data) {
            
        }
    })
}

function SendNotificationLike(btn) {
    var postID = btn.parent().attr("post-id");
    var userID = $("input[name='txtUserid']").val();
    // console.log(userID + " " + postID);
    var notify = {
        userid: userID,
        postid: postID,
        action: "like-post"
    };
    ws.send(JSON.stringify(notify));
}

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
                if (data.trim() != "") {
                    var data = JSON.parse(data);
                    $(".list-notification").empty();
                    data.forEach(item => {
                        var htmlLike = `<li>
                                            <a href="post.php?p=${item.related_object_id}">
                                                <div class="drop_avatar"> <img src="${item.sender.avatar_image}" alt=""></div>
                                                    <div class="drop_text">
                                                        <p>
                                                            <strong>${item.sender.last_name}</strong> Liked Your Post
                                                            <span class="text-link"></span>
                                                        </p>
                                                        <time> ${timeAgo(item.date)} </time>
                                                </div>
                                            </a>
                                        </li>`
                        $(".list-notification").append(htmlLike);
                    });
                }
            }
        })
    }
});
function timeAgo(dateString) {
    const currentDate = new Date();
    const pastDate = new Date(dateString);
    const timeDifference = currentDate - pastDate;

    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) {
        return days + " ngày trước";
    } else if (hours > 0) {
        return hours + " giờ trước";
    } else if (minutes > 0) {
        return minutes + " phút trước";
    } else {
        return "1 phút trước";
    }
}
// Kiểm tra điều kiện đầu vào hợp lệ
// function validateInput(input) {
//     return !/<script\b[^<]*<\/script>/i.test(input);
// }