<?php
include("../Classes/database.php");
include("../Classes/login.php");

if (isset($_POST["email"])) {
    $data = array(
        "email" => $_POST["email"],
        "password" => $_POST["password"],
    );
    $signup = new Login();
    if ($signup->Login_user($data)) {
        echo 1;
    } else {
        echo 0;
    }
};
