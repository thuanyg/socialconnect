<?php
include_once("../Classes/notification.php");
include_once("../Classes/user.php");
include_once("../Classes/post.php");
$p = new Post();
$user = new User();
$notify = new Notification();
if (isset($_REQUEST["action"])) {
    
    if ($_POST["action"] == "get-notification") {
        $userid = $_POST["userid"];
        // Get Post_Related
        $notify = $notify->getNotification($userid);
        if($notify != null){
            for ($i=0; $i < count($notify); $i++) { 
                $senderID = $notify[$i]["sender_id"];
                $sender = $user->getUser($senderID);
                $notify[$i]["sender"] = $sender;
            }
        }
        echo json_encode($notify);
    }

    if ($_POST["action"] == "get-notification-to-load") {
        $userid = $_POST["userid"];
        $offset = $_POST["offset"];
        // Get Post_Related
        $notify = $notify->getNextNotification($userid, $offset);
        if($notify != null){
            for ($i=0; $i < count($notify); $i++) { 
                $senderID = $notify[$i]["sender_id"];
                $sender = $user->getUser($senderID);
                $notify[$i]["sender"] = $sender;
            }
        }
        echo json_encode($notify);
    }



    if ($_POST["action"] == "like-post") {
        $userid = $_POST["userid"];
        $postid = $_POST["postid"];
        $post = $p->getPostOnID($postid);
        $receiverID = ($user->getUser($post[0]["userid"]))["userid"];
        // Sender = userLike || Receiver  = user of post
        $result = $notify->setNotification($receiverID, $userid, $postid, 'like');
        echo $result;
    }

    if ($_POST["action"] == "read-notification") {
        $notifyID = $_POST["notifyID"];
        $result = $notify->readNotification($notifyID);
        echo $result;
    }

    if ($_POST["action"] == "read-all-notification") {
        $userid = $_POST["userid"];
        $result = $notify->readAllNotification($userid);
        echo $result;
    }

    if ($_POST["action"] == "delete-notification") {
        $notifyID = $_POST["notifyID"];
        $result = $notify->deleteNotification($notifyID);
        echo $result;
    }
}
?>