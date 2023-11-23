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
    function SearchFriend($query)
    {
        $sql = "SELECT * FROM users WHERE concat(first_name,' ',last_name) LIKE '%{$query}%' and privacy = 'public'";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }
    function Searchpost($query){
        $sql = "select * from posts where privacy = 'public' and post like '%{$query}%' Order by date desc";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }
}
