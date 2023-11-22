<?php
class Signup
{
    public function create_user($data)
    {
        if ($this->checkUser($data)) {
            $first_name = $data['firstName'];
            $last_name = $data['lastName'];
            $gender = $data['gender'];
            $email = $data['email'];
            $password = $data['password'];
            $last_name_without_diacritics = mb_convert_encoding($last_name, 'ASCII', 'UTF-8');
            $first_name_without_diacritics = mb_convert_encoding($first_name, 'ASCII', 'UTF-8');
            $url_address = strtolower($first_name_without_diacritics) . "." . strtolower($last_name_without_diacritics);
            $userid = $this->create_userid();
            $DB = new Database();
            $sql = "insert into users (userid, first_name, last_name, gender, email, password, url_address)  
            VALUES ($userid, '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";
            $res = $DB->Execute($sql);
            return $res; // Return true or false
        } else return 0;
    }

    public function checkUser($data)
    {
        $email = $data['email'];
        $sql = "SELECT count(id) as userCount from users WHERE email = '$email'";
        $DB = new Database();
        $result = $DB->Query($sql);

        if ($result !== false) {
            // Kiểm tra xem có kết quả nào trả về hay không
            if (!empty($result) && isset($result[0]['userCount'])) {
                $userCount = $result[0]['userCount'];
                // Bây giờ bạn có thể kiểm tra giá trị của $userCount để xác định số lượng người dùng với cùng địa chỉ email.
                if ($userCount > 0) {
                    return 0;
                } else return 1;
            }
        }
    }

    public function create_userid()
    {
        $length = rand(10, 19);
        $userid = "";
        for ($i = 0; $i <= $length; $i++) {
            $new_rand  = rand(0, 9);
            $userid .= $new_rand;
        }
        return $userid;
    }
}
