 // Validation Form
 function ValidateModel() {
    var countEmpty = 0;
    var firstName = $("input[name='txtFirstName']").val();
    var lastName = $("input[name='txtLastName']").val();
    var email = $("input[name='email']").val();
    var password = $("input[name='password']").val();
    var rePassword = $("input[name='rePassword']").val();
    var gender = $("select[name='slGender']").val();
    var phone = $("input[name='txtPhone']").val();
    var privacyChecked = $("input[name='ckPrivacy']").is(":checked");
    var formData = $("#formRegister_model").serializeArray();
    $.each(formData, function (index, field) {
        // console.log(index + ": " + field.name + ": " + field.value);
        if (field.value.trim() == "") {
            countEmpty++;
        }
    });
    var isValid = true;
    if (countEmpty >= formData.length - 2) {
        showNotification("Hãy nhập thông tin để đăng ký.")
        isValid = false;
        return;
    }
    var regex = /^[a-zA-ZÀ-Ỹà-ỹ\s]+$/;
    if (firstName == "") {
        showNotification("Chưa nhập FirstName.")
        isValid = false;
        return;
    } else if (!regex.test(firstName)) {
        showNotification("Tên không hợp lệ!")
        isValid = false;
        return;
    }
    if (lastName == "") {
        showNotification("Chưa nhập LastName.")
        isValid = false;
        return;
    } else if (!regex.test(firstName)) {
        showNotification("Tên không hợp lệ!")
        isValid = false;
        return;
    }
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
    if (rePassword == "" || password != rePassword) {
        showNotification("Mật khẩu không hợp lệ hoặc không trùng khớp!")
        isValid = false;
        return;
    }
    if (!privacyChecked) {
        showNotification("Bạn phải đọc và chấp nhận các điều khoản về chúng tôi!")
        isValid = false;
        return;
    }
    // if (isValid) {
    //     return formData;
    // }
    return isValid;
}

function Register() {
    var firstName = $("input[name='txtFirstName']").val();
    var lastName = $("input[name='txtLastName']").val();
    var email = $("input[name='email']").val();
    var password = $("input[name='password']").val();
    var gender = $("select[name='slGender']").val();
    var phone = $("input[name='txtPhone']").val();  
    if (ValidateModel()) {
        $.ajax({
            url: "Ajax/Register.php",
            method: "POST",
            dataType: "html",
            data: { 
                firstName: firstName,
                lastName: lastName,
                email: email,
                password: password,
                gender: gender,
                phone: phone
             },
            success: function (data) {
                if(data.trim() == "1"){
                    showNotification("Đăng ký thành công!");
                    $("input[name='email_login']").val(email);
                    $(".uk-modal.uk-open").removeClass("uk-open");
                } else {
                    showNotification("Email đã tồn tại!");
                }
            }
        });
    }
}