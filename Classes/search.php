<?php
class Search
{
    function SearchUser($query)
    {
        $sql = "SELECT * FROM users WHERE last_name LIKE '%{$query}%' OR first_name LIKE '%{$query}%'";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }

    function SearchHistoryMessage($senderID, $receiverID, $query)
    {
        $sql = "SELECT * FROM messages WHERE text LIKE '%{$query}%' AND (sender_id = {$senderID} 
        and receiver_id = {$receiverID}) OR ((sender_id = {$receiverID} and receiver_id = {$senderID})) ";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }
}
