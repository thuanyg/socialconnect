<?php
include_once("database.php");
class Notification
{
    // public function getDate() {
    //     date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ là múi giờ của Việt Nam
    //     $currentDateTime = date("Y-m-d H:i:s");    
    //     return $currentDateTime;
    // }


    function getNotification($userid){
        $DB = new Database();
        $sql = "SELECT * FROM notifications WHERE userid = {$userid} ORDER BY date DESC LIMIT 10";
        $result = $DB->Query($sql);
        return $result;
    }

    function getNextNotification($userid, $offset){
        $DB = new Database();
        $sql = "SELECT * FROM notifications WHERE userid = {$userid} ORDER BY date DESC LIMIT 5 OFFSET {$offset}";
        $result = $DB->Query($sql);
        return $result;
    }

    function setNotification($userid, $sender_id, $related_object_id, $type){
        $DB = new Database();
        // $date = $this->getDate();
        $sql = "INSERT INTO notifications (userid, sender_id, related_object_id, `type`) VALUES ({$userid}, {$sender_id}, {$related_object_id}, '$type')";
        $result = $DB->Execute($sql);
        return $result;
    }

    function getQuantityUnread($userid){
        $sql = "SELECT COUNT(*) as 'total' FROM notifications WHERE userid = ".$userid." AND isRead = 0";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }

    function readAllNotification($userid){
        $sql = "UPDATE notifications SET isRead = 1 WHERE userid = ".$userid;
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }

    function readNotification($notifyID){
        $sql = "UPDATE notifications SET isRead = 1 WHERE id = ".$notifyID;
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }

    function deleteNotification($notifyID){
        $sql = "DELETE FROM notifications WHERE id = ".$notifyID;
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }


}