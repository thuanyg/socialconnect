<?php
include_once("database.php");
class User
{
    function getUser($id)
    {
        $DB = new Database();
        $sql = "SELECT * FROM users WHERE userid = '$id' LIMiT 1";
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result[0];
        } else return null;
    }

    function addAbout($userid, $data)
    {
        $DB = new Database();
        $birthday = $data["birthday"];
        if(!$birthday){
            $birthday = NULL;
        }
        $desc = $DB->escapedString($data["desc"]);
        $address = $DB->escapedString($data["address"]);
        $education = $DB->escapedString($data["education"]);
        $media = $data["media"];
        if($birthday){
            $sql = "INSERT INTO users_about (userid, birthday, `desc`, `address`, edu,about_image) 
                VALUES ({$userid}, '{$birthday}', '{$desc}', '{$address}', '{$education}','{$media}')
                ON DUPLICATE KEY UPDATE birthday = '{$birthday}', `desc` = '{$desc}', `address` = '{$address}', edu = '{$education}',about_image ='{$media}'";
        }else {
            $sql = "INSERT INTO users_about (userid, birthday, `desc`, `address`, edu,about_image) 
            VALUES ({$userid}, NULL, '{$desc}', '{$address}', '{$education}','{$media}')
            ON DUPLICATE KEY UPDATE birthday = NULL, `desc` = '{$desc}', `address` = '{$address}', edu = '{$education}',about_image ='{$media}'";
        }
        
        $result = $DB->Execute($sql);
        if ($result) {
            return true;
        } else return false;
    }

    function getAbout($userid)
    {
        $DB = new Database();
        $sql = "SELECT * FROM users_about WHERE userid = {$userid} LIMIT 1";
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result[0];
        } else return null;
    }

    function setConnectionID($userid, $conn_id)
    {
        $DB = new Database();
        $sql = "UPDATE users SET connection_id = {$conn_id} WHERE userid = {$userid}";
        $result = $DB->Execute($sql);
        if ($result) {
            return true;
        } else return false;
    }
    function getStatusPrivacy($userid){
        $DB=new Database();
        $sql="SELECT privacy FROM users WHERE userid={$userid}";
        $result = $DB->Query($sql);
        return $result;
    }
    function updateSetting($userid,$data){
        $DB=new Database();
        $first_name = $data["first_name"];
        $last_name = $data["last_name"];
        $email = $data["email"];
       
        $sql = "update users set first_name = '{$first_name}', last_name = '{$last_name}', email = '{$email}' where userid = {$userid}";
        $result = $DB->Execute(($sql));
        return $result;
    }
    function checkUser($data)
    {   $userid = $_POST["userid"];
        $email = $data['email'];
        $sql = "SELECT count(id) as userCount from users WHERE email = '$email'";
        $sql1 = "SELECT count(id) as user from users WHERE userid = '$userid' and email = '$email'";
        $DB = new Database();
        $result = $DB->Query($sql);
        $result1 = $DB->Query($sql1);
        if ($result !== false && $result1 !== false) {
            if (!empty($result1) && isset($result1[0]['user'])) {
                $user= $result1[0]['user'];
                
                // Bây giờ bạn có thể kiểm tra giá trị của $userCount để xác định số lượng người dùng với cùng địa chỉ email.
                if ($user > 0) {
                    return 1;
                }
            }
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
    function setPrivacy($userid,$str){
        $DB= new Database();
        $sql = "update users set privacy = '{$str}' where userid = {$userid}";
        $result = $DB->Execute($sql);
        return $result;
    }
    function updateAvatar($userid,$data){
        $DB=new Database();
        $imagesNew = $data["imagesNew"];
       
        
        $sql = "update users set avatar_image = 'uploads/avatars/{$imagesNew}' where userid = {$userid}";
        $result = $DB->Execute(($sql));
        return $result;
    }
    function updateCover($userid,$data){
        $DB=new Database();
        $imagesNew = $data["imagesNew"];
       
        
        $sql = "update users set cover_image = 'uploads/avatars/{$imagesNew}' where userid = {$userid}";
        $result = $DB->Execute(($sql));
        return $result;
    }
    function getAboutImage($userid) {
        $DB=new Database();
        $sql = "select about_image from users_about where userid={$userid}";
        $result = $DB->Query($sql);
        return $result;
    }
    function updateAboutImage($userid,$media) {
        $DB=new Database();
        $sql = "update users_about set about_image = '{$media}' where userid = {$userid}";
        $result = $DB->Execute($sql);
        return $result;
    }

    function getBirthday($friendID){
        $DB=new Database();
        $sql = "SELECT birthday FROM Users_about WHERE userid = $friendID";
        $result = $DB->Query($sql);
        return $result;
    }

    function deleteAccount($userid){
        $DB=new Database();
        $sql = "DELETE FROM users WHERE userid = $userid";
        $result = $DB->Execute($sql);
        return $result;
    }

    
    
}