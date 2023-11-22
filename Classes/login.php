<?php
session_start();
class Login
{
    public function Login_user($data)
    {
        if ($this->checkUser($data)) {
            return true;
        } else return false;
    }

    public function checkUser($data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $sql = "SELECT * from users WHERE email = '$email' and password = '$password' LIMIT 1";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            $_SESSION["userid"] = $result[0]["userid"];
            return true;
        } else return false;
    }
}
