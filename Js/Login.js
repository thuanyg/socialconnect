// Validation Form

    function Validate() {
        var email = $("input[name='email_login']").val();
        var password = $("input[name='password_login']").val();
        var isValid = true;
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
        var passwordRegex = /^\S+$/;
        if (password == "") {
            showNotification("Chưa nhập Password.")
            isValid = false;
            return;
        } else if (!passwordRegex.test(password)) {
            showNotification("Mật khẩu không hợp lệ!")
            isValid = false;
            return;
        }
        return isValid;
    }

    //Login
    function Login() {
        var email = $("input[name='email_login']").val();
        var password = $("input[name='password_login']").val();
        if (Validate()) {
            showNotification("Đang xử lý yêu cầu...")
            $.ajax({
                url: "Ajax/Login.php",
                method: "POST",
                dataType: "html",
                data: {
                    email: email,
                    password: password
                },
                success: function (data) {
                    if (data == 1) {
                        showNotification("Đăng nhập thành công!");
                        window.location.href = "feed.php";
                    } else {
                        showNotification("Sai tài khoản hoặc mật khẩu!");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Lỗi trong yêu cầu Ajax:", textStatus, errorThrown);
                },
            });
        }
    }
