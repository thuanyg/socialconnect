<?php

require("src/PHPMailer.php");
require("src/SMTP.php");
    function SendCode($address, $code)
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP

        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "cryptocard268@gmail.com";
        $mail->Password = "qmoddohhrwkjlicg";
        $mail->SetFrom("cryptocard268@gmail.com");
        $mail->Subject = "New Your Password";
        $mail->Body = "Mật khẩu mới của bạn là: " . $code;
        $mail->AddAddress($address);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        } else {
            echo "Message has been sent";
            return true;
        }
    }
// SendCode("thuan0205766@huce.edu.vn", "htthuan4161");
