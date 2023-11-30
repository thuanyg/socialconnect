<?php
require_once("database.php");
class Comment
{
    function getComment(){
        $DB = new Database();
        $sql = "SELECT * FROM comments ";
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result[0];
        } else return null;
    }
    function

}
?>