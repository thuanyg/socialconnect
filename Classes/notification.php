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
}