var isValid = true;
function CheckInput() {
    var email = $("input[name='email_login']").val();
    if (confirm("Bạn muốn lấy lại mật khẩu của email: " + email)) {
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (email == "") {
            showNotification("Chưa nhập Email.")
            isValid = false;
            return;
        } else if (!emailRegex.test(email)) {
            showNotification("Email không hợp lệ.")
            isValid = false;
            return;
        }
    } else isValid = false;
    return isValid;
}

function ForgotPassword() {
    if (CheckInput()) {
        var email = $("input[name='email_login']").val();
        showNotification("Đang xử lý yêu cầu...");
        $.ajax({
            url: "Ajax/ForgotPassword.php",
            method: "POST",
            dataType: "html",
            data: {
                email: email
            },
            success: function (data) {
                if (data != 0) {
                    showNotification("Lấy lại mật khẩu thành công. Hãy kiểm tra email!")
                } else {
                    showNotification("Xảy ra lỗi. Hãy kiểm tra lại email!")
                }
            }
        });

    }
}