<?php
include_once("database.php");
class Message
{
    function saveMessage($sender_id, $re_id, $mess, $media)
    {
        $DB = new Database();
        $content = $DB->escapedString($mess);
        $sql = "INSERT INTO messages (sender_id, receiver_id , text, media) VALUES ({$sender_id}, {$re_id}, '{$content}', '{$media}')";
        $result = $DB->Execute($sql);
        return $result;
    }

    function countMessage($sender_id, $receiver_id)
    {
        $DB = new Database();
        $sql = "SELECT COUNT(*) as 'total' FROM messages WHERE (sender_id = {$sender_id} and receiver_id = {$receiver_id}) 
                                           OR (sender_id = {$receiver_id} and receiver_id = {$sender_id})";
        $result = $DB->Query($sql);
        return $result[0]["total"];
    }

    function getMessage($sender_id, $receiver_id)
    {
        $DB = new Database();
        $messNumber = $this->countMessage($sender_id, $receiver_id);
        // $offset = $messNumber[0]["total"] - 15;
        $sql = "SELECT * FROM messages WHERE (sender_id = {$sender_id} and receiver_id = {$receiver_id}) 
                OR (sender_id = {$receiver_id} and receiver_id = {$sender_id})
                ORDER BY date DESC LIMIT 15";
        $result = $DB->Query($sql);
        return $result;
    }

    function getMessagePrevious($sender_id, $receiver_id, $offset){
        $DB = new Database();
        $sql = "SELECT * FROM messages WHERE (sender_id = {$sender_id} and receiver_id = {$receiver_id}) 
                OR (sender_id = {$receiver_id} and receiver_id = {$sender_id}) 
                ORDER BY date DESC LIMIT 5 OFFSET {$offset}";
        $result = $DB->Query($sql);
        return $result;
    }

    function getLastestMessage($sender_id, $receiver_id)
    {
        $DB = new Database();
        $sql = "SELECT * FROM messages WHERE (sender_id = {$sender_id} and receiver_id = {$receiver_id}) 
        OR (sender_id = {$receiver_id} and receiver_id = {$sender_id}) 
        ORDER BY date DESC LIMIT 1";
        $result = $DB->Query($sql);
        return $result;
    }

    function deleteConversation($sender_id, $receiver_id){
        $DB = new Database();
        $sql = "DELETE FROM messages WHERE (sender_id = {$sender_id} and receiver_id = {$receiver_id}) 
        OR (sender_id = {$receiver_id} and receiver_id = {$sender_id})";
        $result = $DB->Execute($sql);
        return $result;
    }

    function deleteOneChat($chatID){
        $DB = new Database();
        $sql = "UPDATE messages SET deleted_by_sender = true WHERE id = {$chatID}"; 
        $result = $DB->Execute($sql);
        return $result;
    }
    
    function deleteOneChatFriend($chatID){
        $DB = new Database();
        $sql = "UPDATE messages SET deleted_by_receiver = true WHERE id = {$chatID}"; 
        $result = $DB->Execute($sql);
        return $result;
    }

    function deleteChat($chatID){
        $DB = new Database();
        $sql = "DELETE FROM messages WHERE id = {$chatID}"; 
        $result = $DB->Execute($sql);
        return $result;
    }

    function getFriendMessage($sender_id){
        $DB = new Database();
        $sql = "SELECT DISTINCT receiver_id as 'friend_id' FROM `messages` WHERE sender_id = {$sender_id} ORDER BY date DESC";
        $result = $DB->Query($sql);
        return $result;
    }

    function setReadStatus($sender_id, $receiver_id, $status){
        $DB = new Database();
        $sql = "UPDATE messages SET read = '{$status}' WHERE sender_id = '{$sender_id}' AND receiver_id = '{$receiver_id}'"; 
        $result = $DB->Execute($sql);
        return $result;
    }
}
