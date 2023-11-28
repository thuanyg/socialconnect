//Edit information user

$('.btn-save-setting').on('click', function (e) {
    var first_name = $('.first-name').val();
    var last_name = $('.last-name').val();
    var email = $('.email').val();
    var userid = $('#userid').val();
    var isValid = true;
    if (first_name.trim() == '' && last_name.trim() == '' && email.trim() == '') {
        showNotification("Chưa nhập thông tin!");
        isValid = false;
        return;
    }
    if (validateInput(first_name) || validateInput(first_name) || validateInput(email)) {
        showNotification("Biểu mẫu đang chứa đoạn mã script!!!");
        isValid = false;
        return;
    }
    var regex = /^[a-zA-ZÀ-Ỹà-ỹ\s]+$/;
    console.log(regex.test(first_name));
    if (!regex.test(first_name) && first_name.trim() != "") {
        showNotification("Hãy nhập họ tên đúng định dạng!");
        isValid = false;
        return;
    }
    if (!regex.test(last_name) && last_name.trim() != "") {
        showNotification("Hãy nhập họ tên đúng định dạng!");
        isValid = false;
        return;
    }

    var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(email) && email.trim() != "") {
        showNotification("Hãy nhập Email đúng định dạng!");
        isValid = false;
        return;
    }
    if (isValid) {
        $.ajax({
            url: "Ajax/User.php",
            type: "POST",
            data: {
                first_name: first_name,
                last_name: last_name,
                email: email,
                userid: userid,
                action: "save-setting"
            },
            success: function (response) {
                if (response.trim() == "invalid") {
                    showNotification("Email đã tồn tại");
                    return;
                }
                if (response.trim() == "updated") {
                    showNotification("Cập nhật thành công");
                    return;
                }
                window.location.href = "page-setting.php";
            }
        })
    }
});
// Set Privacy
$('.checkbox-privacy').on('click', function (e) {
    if ($(this).val() == "off") $(this).val('on');
    else $(this).val('off');
    var privacy = $(this).val();
    var userid = $('#userid').val();
    console.log(privacy);
    $.ajax({
        url: "Ajax/user.php",
        type: "POST",
        data: {
            userid: userid,
            privacy: privacy,
            action: 'setting-privacy'
        },
        success: function (response) {
            if (response.trim() == "setPublic") {
                showNotification("Đã thiết lập quyền riêng tư: Công khai");
                return;
            }
            if (response.trim() == "setPrivate") {
                showNotification("Đã thiết lập quyền riêng tư: Riêng tư");
                return;
            }
            showNotification("Có lỗi xảy ra. Vui lòng thử lại!");
        }

    })

});
// Kiểm tra điều kiện đầu vào hợp lệ
function validateInput(input) {
    return /<script\b[^<]*<\/script>/i.test(input);
}