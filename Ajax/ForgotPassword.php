<?php
include("../Classes/database.php");
require("../PHPMailer-master/sendMail.php");
if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $DB = new Database();
    $sql = "SELECT * from users WHERE email = '$email'";
    $result = $DB->Query($sql);
    if (!empty($result)){
        $code = renderCode();
        if (SendCode($email, $code)) {
            $res = $DB->Execute("UPDATE users SET password = '$code' WHERE email = '$email' ");
            if ($res) echo $res;
            else echo 0;
        }
    } else echo 0;
}

function renderCode()
{
    $length = 4;
    $code = "htthuan";
    for ($i = 1; $i <= $length; $i++) {
        $new_rand  = rand(0, 9);
        $code .= $new_rand;
    }
    return $code;
}
