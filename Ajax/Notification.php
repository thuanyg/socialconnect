
<?php
    include_once("../Classes/notification.php");
    if(isset($_REQUEST["action"])){
        if($_POST["action"] == "get-notification"){
            $userid = $_POST["userid"];
            $notify = new Notification();
            $result = $notify->getNotification($userid);
            echo json_encode($result);
        }
    }
?>