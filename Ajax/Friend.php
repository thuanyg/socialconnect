<?php
    include("../Classes/database.php");
    include("../Classes/user.php");
    include("../Classes/friend.php");
    session_start();
    if(isset($_POST["action"])){
        if($_POST["action"] == "request"){
            $sender_id = $_SESSION["userid"]; // User gửi lời mời kết bạn
            $receiver_id = $_POST["userid"]; // User nhận
            $f = new Friend();
            $result = $f->Request($sender_id, $receiver_id);
            echo $result;
        }

        if($_POST["action"] == "cancel-request"){
            $sender_id = $_SESSION["userid"]; // User gửi lời mời kết bạn
            $receiver_id = $_POST["userid"]; // User nhận
            $f = new Friend();
            $result = $f->CancelRequest($sender_id, $receiver_id);
            echo $result;
        }

        if($_POST["action"] == "accept-request"){
            $sender_id = $_POST["userid"]; // User gửi lời mời
            $receiver_id = $_SESSION["userid"]; // Người nhận được lời mời kết bạn là user hiện tại
            $f = new Friend();
            $result = $f->AcceptRequest($receiver_id, $sender_id);
            echo $result;
        }

        if($_POST["action"] == "delete-request"){ // Từ chối kết bạn
            $sender_id = $_POST["userid"]; // Người gửi lời mời là user trên url
            $receiver_id = $_SESSION["userid"]; // Người nhận được lời mời là người dùng hiện tại
            $f = new Friend();
            $result = $f->DeleteRequest($sender_id, $receiver_id);
            echo $result;
        }

        if($_POST["action"] == "response"){
            echo "response";
        }
    }
?>