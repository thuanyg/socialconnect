<?php
include_once("database.php");
class Notification
{
    function getNotification($userid){
        $DB = new Database();
        $sql = "SELECT * FROM notifications WHERE userid = {$userid} ORDER BY date DESC LIMIT 10";
        $result = $DB->Query($sql);
        return $result;
    }

    function setNotification($userid, $sender_id, $related_object_id, $type){
        $DB = new Database();
        $sql = "INSERT INTO notifications (userid, sender_id, related_object_id, `type`) VALUES ({$userid}, {$sender_id}, {$related_object_id}, '$type')";
        $result = $DB->Execute($sql);
        return $result;
    }

    function getNotificationUnread($userid){
        $sql = "SELECT COUNT(*) as 'total' FROM notifications WHERE userid = ".$userid." AND isRead = 0";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }
}