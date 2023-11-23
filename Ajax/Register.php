<?php
    include("../Classes/database.php");
    include("../Classes/signup.php");
    require("../PHPMailer-master/sendMail.php");
    if(isset($_POST["email"])){
        $data = array(
            "firstName" => $_POST["firstName"],
            "lastName" => $_POST["lastName"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
            "gender" => $_POST["gender"],
            "phone" => $_POST["phone"]
        );
        $signup = new Signup();
        echo $signup->create_user($data);
    };
