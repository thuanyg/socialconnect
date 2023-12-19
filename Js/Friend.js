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
                action: "request" // Dữ liệu gửi đi
            },
            success: function (response) {
                if (response) {
                    // Hiển thị overlay để chặn hành động của người dùng
                    // document.getElementById("overlay").style.display = "block";
                    // Cho phép nút trở lại hoạt động sau 3 giây
                    // setTimeout(function () {
                    //     document.getElementById("overlay").style.display = "none";
                    // }, 2000);
                    hideButtons();
                    $(".cancel-add-friend-btn").fadeIn(1000);
                    showNotification("Đã gửi lời mời kết bạn");
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi nếu có.
            }
        });
    });

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
    
    var number = 0;
    $(".btn-loadMore").on('click',function(e){
        e.preventDefault();
        $.ajax({
            url : 'Ajax/Friend.php',
            type : "POST",
            data : {
                number : number+8,
                action : 'get_more_friends' ,
            },success : function(data){
             $(".list-friends").append(data);
            }
        })
    })
});