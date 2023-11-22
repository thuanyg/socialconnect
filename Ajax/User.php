<?php
    include("../Classes/database.php");
    include("../Classes/user.php");
    if(isset($_POST["action"])){
        if($_POST["action"] == "add-about"){
            $data = array(
                "userid" => $_POST["userid"],
                "birthday" => $_POST["birthday"],
                "address" => $_POST["address"],
                "education" => $_POST["education"],
                "desc" => $_POST["desc"]
            );
            $u = new User();
            if($u->addAbout($data["userid"], $data)){
                echo 1;
            } else echo 0;
        }
        if($_POST["action"] == "save-setting"){
            $data = array(
                "userid" => $_POST["userid"],
                "first_name" => $_POST["first_name"],
                "last_name" => $_POST["last_name"],
                "email" => $_POST["email"],         
            );
            $u = new User();
            if($u->checkUser($data)){
                if($u->updateSetting($data["userid"], $data)){
                    echo "updated";
                } else echo "error";
            } else echo "invalid";
            
        }
        if($_POST["action"]=="setting-privacy"){
            $privacy =$_POST["privacy"];
            $userid = $_POST["userid"];
            $u = new User();
            if($privacy=="on"){
                if($u->setPrivacy($userid, 'public')) echo "setPublic";
            } else {                
                if($u->setPrivacy($userid, 'private')) echo "setPrivate";
            }
        }
    }
?>