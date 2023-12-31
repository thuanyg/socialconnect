
// Search users - Ajax
var userID = $("input[name='txtUserid']").val();
var searchDocument = $("#searchResults");
var scrolledOnce = false;
var searchFetching = false;
var notifyFetching = false;
var offset = 10;
var notifyOffset = 10;
var shouldLoadMore = true;
$(window).scroll(function () {
    var windowHeight = window.innerHeight;
    var scrollTop = $(this).scrollTop();
    if (scrollTop > windowHeight - 100) {
        $(".scroll-to-top").show();
    } else {
        $(".scroll-to-top").hide();
    }
});
$(".scroll-to-top").click(function (e) {
    e.preventDefault();
    window.scroll({
        top: 0,
        left: 0,
        behavior: 'smooth' 
    });
})
$("input[name='txtSearch']").on("keyup", function () {
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
                                $(".header_search_dropdown").off('scroll');
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

function SaveNotification(postID, type) {
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

function SendNotification(postID, type) {
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
    ws.send(JSON.stringify(notify));
}

var isNotificationOpen = false;
$(".notification-btn").on("click", function (e) {
    e.preventDefault();
    if (!isNotificationOpen) {
        isNotificationOpen = true;
        $.ajax({
            url: "Ajax/Notification.php",
            type: "POST",
            data: {
                userid: userID,
                action: "get-notification"
            },
            success: function (data) {
                if (data.trim() != "[]") {
                    var data = JSON.parse(data);
                    $(".list-notification").empty();
                    data.forEach(item => {
                        var action = "";
                        if (item.type == "share") action = "shared"
                        if (item.type == "like") action = "liked"
                        if (item.type == "comment") action = "commented"
                        var status = (item.isRead == "1") ? "" : "un-read";
                        var htmlListNotify = `<li class="${status} notify-item">
                                            <a href="post.php?p=${item.related_object_id}">
                                                <div class="drop_avatar"> <img src="${item.sender.avatar_image}" alt=""></div>
                                                    <div class="drop_text">
                                                        <p>
                                                            <strong>${item.sender.last_name}</strong> ${action} your post
                                                            <span class="text-link"></span>
                                                        </p>
                                                        <time> ${timeAgo(item.date)} </time>
                                                </div>
                                            </a>
                                            <div class="options-notify-button" title="Options">
                                                <ion-icon name="ellipsis-horizontal-circle-outline"></ion-icon>
                                            </div>
                                            <div class="options-notify-list" style="position: absolute" data-notify-id=${item.id}>                                            
                                                <ul>
                                                    <li><a href="" class="btn-read-notification">
                                                        <ion-icon name="checkmark-outline"></ion-icon>
                                                        Mark as read </a>
                                                    </li>
                                                    <li><a href="" class="btn-remove-notification">
                                                        <ion-icon name="close-circle-outline"></ion-icon>
                                                        Remove this notification
                                                        </a>
                                                    </li>
                                                    <li><a href="">
                                                        <ion-icon name="flag-outline"></ion-icon>
                                                        Report issue
                                                        </a>
                                                    </li>
                                               </ul>
                                            </div>
                                        </li>`
                        $(".list-notification").append(htmlListNotify);
                    });
                    notifyOffset = 10;
                }
            }
        })
    }

    // Load notification
    $(".simplebar-content:eq(0)").scroll(function () {
        var scrollTop = $(this).scrollTop();
        var windowHeight = $(this).height();
        var docHeight = $(".list-notification").height();
        // console.log(scrollTop + " -- " + docHeight + " -- " + windowHeigh);
        if (scrollTop + windowHeight > docHeight - 50) {
            ViewNextNotification()
        }
    });
});

function getNotificationToLoad(notifyOffset) {
    notifyFetching = true;
    $.ajax({
        url: "Ajax/Notification.php",
        type: "POST",
        data: {
            offset: notifyOffset,
            userid: userID,
            action: "get-notification-to-load"
        },
        cache: false,
        success: function (data) {
            if (data.trim() != "[]") {
                var data = JSON.parse(data);
                data.forEach(item => {
                    var action = "";
                    if (item.type == "share") action = "shared"
                    if (item.type == "like") action = "liked"
                    if (item.type == "comment") action = "commented"
                    var htmlListNotify = `<li class="un-read">
                                        <a href="post.php?p=${item.related_object_id}">
                                            <div class="drop_avatar"> <img src="${item.sender.avatar_image}" alt=""></div>
                                                <div class="drop_text">
                                                    <p>
                                                        <strong>${item.sender.last_name}</strong> ${action} your post
                                                        <span class="text-link"></span>
                                                    </p>
                                                    <time> ${timeAgo(item.date)} </time>
                                            </div>
                                        </a>
                                        <div class="options-notify-button" title="Options">
                                                <ion-icon name="ellipsis-horizontal-circle-outline"></ion-icon>
                                        </div>
                                        <div class="options-notify-list" style="position: absolute" data-notify-id=${item.id}>                                            
                                                <ul>
                                                    <li><a href="" class="btn-read-notification">
                                                        <ion-icon name="checkmark-outline"></ion-icon>
                                                        Mark as read </a>
                                                    </li>
                                                    <li><a href="" class="btn-remove-notification">
                                                        <ion-icon name="close-circle-outline"></ion-icon>
                                                        Remove this notification
                                                        </a>
                                                    </li>
                                                    <li><a href="">
                                                        <ion-icon name="flag-outline"></ion-icon>
                                                        Report issue
                                                        </a>
                                                    </li>
                                               </ul>
                                        </div>
                                    </li>`
                    $(".list-notification").append(htmlListNotify);
                });
                notifyFetching = false;
            }
        },
    });
}

function ViewNextNotification() {
    if (notifyFetching) return;
    getNotificationToLoad(notifyOffset);
    notifyOffset += 5;
}

//Mark as read all notification
$(".btn-read-all-notification").click(function (e) {
    e.preventDefault();
    $.ajax({
        url: "Ajax/Notification.php",
        type: "POST",
        data: {
            userid: userID,
            action: "read-all-notification"
        },
        success: function (response) {
            if (response.trim() == "1") {
                showNotification("Marked all as read.")
            }
        }
    })
})
// Mark as read notification
$(document).on("click", ".btn-read-notification", function (e) {
    e.preventDefault()
    var notifyItem = $(this).parents().eq(3);
    var notifyID = $(this).parents().eq(2).data("notify-id");
    var notifyUnreadNumber = $(".notification-quantity");
    if (notifyItem.hasClass("un-read")) {
        $.ajax({
            url: "Ajax/Notification.php",
            type: "POST",
            data: {
                notifyID: notifyID,
                action: "read-notification"
            },
            success: function (response) {
                if (response.trim() == "1") {
                    notifyItem.removeClass("un-read");
                    var currentNum = Number(notifyUnreadNumber.text());
                    switch (currentNum) {
                        case 1:
                            notifyUnreadNumber.remove();
                            break;
                        default:
                            notifyUnreadNumber.text(currentNum - 1);
                            break;
                    }
                }
            }
        })
    } else {
        showNotification("You have read this notification already.")
    }
})
// Read notification
$(".btn-read-all-notification").click(function (e) {
    e.preventDefault();
    $.ajax({
        url: "Ajax/Notification.php",
        type: "POST",
        data: {
            userid: userID,
            action: "read-all-notification"
        },
        success: function (response) {
            if (response.trim() == "1") {
                showNotification("Marked all as read.")
            }
        }
    })
})
// Remove notification
$(document).on("click", ".btn-remove-notification", function (e) {
    e.preventDefault()
    var notifyItem = $(this).parents().eq(3);
    var notifyID = $(this).parents().eq(2).data("notify-id");
    var notifyUnreadNumber = $(".notification-quantity");
    $.ajax({
        url: "Ajax/Notification.php",
        type: "POST",
        data: {
            notifyID: notifyID,
            action: "delete-notification"
        },
        success: function (response) {
            if (response.trim() == "1") {
                if (notifyItem.hasClass("un-read")) {
                    var currentNum = Number(notifyUnreadNumber.text());
                    switch (currentNum) {
                        case 1:
                            notifyUnreadNumber.remove();
                            break;
                        default:
                            notifyUnreadNumber.text(currentNum - 1);
                            break;
                    }
                }
                showNotification("Removed!!!")
                notifyItem.remove();
            }
        }
    })
})

// Confirm friend request
$(".confirm-req").click(function (e) {
    e.preventDefault();
    var reqID = $(this).data("request-id");
    $.ajax({
        url: "Ajax/Friend.php",
        type: "POST",
        data: {
            userid: reqID,
            action: "accept-request"
        },
        success: function (data) {
            if (data.trim() != "") {
                window.location.reload();
            }
        }
    })

})

// Delete friend request
$(".delete-req").click(function (e) {
    e.preventDefault();
    var reqID = $(this).data("request-id");
    $.ajax({
        url: "Ajax/Friend.php",
        type: "POST",
        data: {
            userid: reqID,
            action: "delete-request"
        },
        success: function (data) {
            if (data.trim() != "") {
                window.location.reload();
            }
        }
    })

})
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
// Để chuyển đổi các ký tự đặc biệt thành HTML entities.
function escapeHtml(input) {
    return input.replace(/</g, "&lt;").replace(/>/g, "&gt;");
}
// Biểu thức chính quy để tìm kiếm các thẻ nhúng từ web khác
function containsExternalEmbed(input) {
    var embedPattern = /<\s*iframe[^>]*src\s*=\s*["']([^"']+)["'][^>]*>/i;
    return embedPattern.test(input);
}

// Event GUI
$(document).on("click", ".options-notify-button", function (e) {
    var listOption = $(this).next();
    if (listOption.hasClass("active")) {
        listOption.removeClass("active");
        $(this).parent().css("height", "61px");
        $(".notification-content").css("height", "auto")
    } else {
        $(".notification-content").css("height", "100vh")
        listOption.addClass("active");
        $(this).parent().css("height", "185px");
    }
})