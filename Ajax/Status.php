<?php
include("../Classes/status.php");
include("../Classes/database.php");
if (isset($_POST["action"])){
    if($_POST["action"] == "update-status"){
        $userid = $_POST["userid"];
        $s = new Status();
        $result = $s->updateStatus($userid, "online");
        echo $result;
    }
    if($_POST["action"] == "set-status-online"){
        $userid = $_POST["userid"];
        $s = new Status();
        $result = $s->updateStatus($userid, "online");
        echo $result;
    }
    if($_POST["action"] == "set-status-offline"){
        $userid = $_POST["userid"];
        $s = new Status();
        $result = $s->updateStatus($userid, "offline");
        echo $result;
    }
    

}