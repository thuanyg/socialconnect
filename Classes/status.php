<?php
require_once("timer.php");
class Status
{
    function updateStatus($userid, $status)
    {
        $sql = "INSERT INTO users_status (userid, `status`) 
        VALUES ({$userid}, '{$status}')
        ON DUPLICATE KEY UPDATE `status` = '{$status}';
        ";
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }

    function getStatus($userid){
        $sql = "SELECT * FROM users_status WHERE userid = {$userid}";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }

    function offlineTime($userid){
        $status = $this->getStatus($userid);
        if($status != null){
            if($status[0]["status"] == "offline"){
                $date = $status[0]["date"];
                $time = (new Timer())->TimeSince($date);
                return $time;
            }
        }
    }
}
