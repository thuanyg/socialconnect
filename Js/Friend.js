$(document).ready(function () {
    // Khởi tạo các biến lưu các button
    var addFriendButton = $(".add-friend-btn");
    var cancelFriendButton = $(".cancel-add-friend-btn");
    var acceptFriendButton = $(".accept-add-friend-btn");
    var deleteFriendButton = $(".delete-add-friend-btn");
    var FriendButtons = [addFriendButton, cancelFriendButton, acceptFriendButton, deleteFriendButton];
    function hideButtons() {
        FriendButtons.forEach(e => {
            e.fadeOut(0);
        });
    }
    // Khi click "Add Friend" 
    $(".add-friend-btn").on("click", function (event) {
        event.preventDefault();
        var userId = $(this).data("userid"); // userid người được gửi yêu cầu kết bạn
        $.ajax({
            url: "Ajax/Friend.php", // Điều chỉnh đường dẫn đến file xử lý yêu cầu kết bạn
            type: "POST", // Hoặc "GET" tùy thuộc vào việc bạn muốn gửi yêu cầu kết bạn bằng phương thức nào.
            data: {
                userid: userId,
                action: "request"
            },
            success: function (response) {
                if (response) {
                    hideButtons();
                    $(".cancel-add-friend-btn").fadeIn(1000);
                    showNotification("Đã gửi lời mời kết bạn");
                    var senderID = $("input[name='txtUserid']").val();
                    // SaveNotificationFriend(senderID, userId, 'request');
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi nếu có.
            }
        });
    });


    // function SaveNotificationFriend(userID, receiverID, type) {
    //     var action = type;
    //     var notify = {
    //         userid: userID,
    //         receiverID: receiverID,
    //         action: action
    //     };
    //     $.ajax({
    //         url: "Ajax/Notification.php",
    //         type: "POST",
    //         data: notify,
    //         success: function (data) {

    //         }
    //     })
    // }
    // Khi click "Cancel request"
    $(".cancel-add-friend-btn").on("click", function (event) {
        event.preventDefault();
        var userId = $(this).data("userid"); // userid người được gửi yêu cầu kết bạn
        $.ajax({
            url: "Ajax/Friend.php", // Điều chỉnh đường dẫn đến file xử lý yêu cầu kết bạn
            type: "POST", // Hoặc "GET" tùy thuộc vào việc bạn muốn gửi yêu cầu kết bạn bằng phương thức nào.
            data: {
                userid: userId,
                action: "cancel-request" // Dữ liệu gửi đi
            },
            success: function (response) {
                if (response) {
                    hideButtons();
                    $(".add-friend-btn").first().fadeIn(1000);
                    showNotification("Đã hủy lời mời kết bạn");
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi nếu có.
            }
        });
    });

    // Khi click "Accept"
    $(".accept-add-friend-btn").on("click", function (event) {
        event.preventDefault();
        var userId = $(this).data("userid"); // userid người được gửi yêu cầu kết bạn
        $.ajax({
            url: "Ajax/Friend.php", // Điều chỉnh đường dẫn đến file xử lý yêu cầu kết bạn
            type: "POST", // Hoặc "GET" tùy thuộc vào việc bạn muốn gửi yêu cầu kết bạn bằng phương thức nào.
            data: {
                userid: userId,
                action: "accept-request" // Dữ liệu gửi đi
            },
            success: function (response) {
                if (response) {
                    hideButtons();
                    $(".friend-btn").fadeIn(1000);
                    showNotification("Đã đồng ý lời mời kết bạn");
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi nếu có.
            }
        });
    });


    // Khi click "Delete" - Từ chối lời mời kết bạn
    $(".delete-add-friend-btn").on("click", function (event) {
        event.preventDefault();
        var userId = $(this).data("userid"); // userid người được gửi yêu cầu kết bạn
        $.ajax({
            url: "Ajax/Friend.php", // Điều chỉnh đường dẫn đến file xử lý yêu cầu kết bạn
            type: "POST", // Hoặc "GET" tùy thuộc vào việc bạn muốn gửi yêu cầu kết bạn bằng phương thức nào.
            data: {
                userid: userId,
                action: "delete-request" // Dữ liệu gửi đi
            },
            success: function (response) {
                if (response) {
                    hideButtons();
                    $(".add-friend-btn").fadeIn(1000);
                    showNotification("Đã từ chối lời mời kết bạn");
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi nếu có.
            }
        });
    });

    //Unfriend
    $(".unfriend-btn").click(function (e) {
        e.preventDefault();
        var profileid = $(this).data("profileid");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "Ajax/Friend.php",
                type: "POST",
                data: {
                    userid: userID,
                    profileID: profileid,
                    action: "unfriend"
                },
                success: function (data) {
                    if (data.trim() == "1") {
                        showNotification("Xóa bạn bè thành công!");
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                }
            })
        }
    })
    var number = 0;
    $(".btn-loadMore").on('click', function (e) {
        e.preventDefault();
        number += 8;
        $.ajax({
            url: 'Ajax/Friend.php',
            type: "POST",
            data: {
                number: number,
                action: 'get_more_friends',
            }, success: function (data) {
                $(".list-friends").append(data);
            }
        })
    })

    var numberFriendRequest = 0;
    $(".btn-FriendRequest-loadMore").on('click', function (e) {
        e.preventDefault();
        numberFriendRequest += 4;
        $.ajax({
            url: 'Ajax/Friend.php',
            type: "POST",
            data: {
                numberFriendRequest: numberFriendRequest,
                action: 'get_more_FriendRequest',
            }, success: function (data) {
                $(".list-friendRequest").append(data);
            }
        })
    })

    var number1 = 0;
    $(".load-them").on('click', function (e) {
        e.preventDefault();
        var userIDprofile = $(this).data('profileid');
        number1 += 8;
        $.ajax({
            url: 'Ajax/Friend.php',
            type: "POST",
            data: {
                userID: userIDprofile,
                number: number1,
                action: 'more_friends',
            }, success: function (data) {
                $(".list-friends").append(data);
            }
        })
    })

});