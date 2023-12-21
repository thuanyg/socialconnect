<?php
include_once("database.php");
class Friend
{
    // Sender(Người gửi) gửi yêu cầu kết bạn cho Receiver(Người nhận)
    public function Request($sender_id, $receiver_id)
    {
        $DB = new Database();
        $sql = "INSERT INTO friend_requests (sender_id, receiver_id, status) 
                VALUES ({$sender_id}, {$receiver_id}, 'Pending') 
                ON DUPLICATE KEY UPDATE status = 'Pending'";

        if ($this->checkExistRequest($sender_id, $receiver_id) == true) {
            $result = $DB->Execute($sql);
            return $result;
        } else return null;
    }

    // Hủy yêu cầu kết bạn
    public function CancelRequest($sender_id, $receiver_id)
    {
        $DB = new Database();
        // $sql = "UPDATE friend_requests SET status = 'Cancel' WHERE sender_id = {$sender_id} and receiver_id = {$receiver_id}";
        $sql = "DELETE FROM friend_requests WHERE sender_id = {$sender_id} and receiver_id = {$receiver_id}";
        $result = $DB->Execute($sql);
        return $result;
    }
    // Từ chối kết bạn
    public function DeleteRequest($sender_id, $receiver_id)
    {
        $DB = new Database();
        // $sql = "UPDATE friend_requests SET status = 'Cancel' WHERE sender_id = {$sender_id} and receiver_id = {$receiver_id}";
        $sql = "DELETE FROM friend_requests WHERE sender_id = {$sender_id} and receiver_id = {$receiver_id}";
        $result = $DB->Execute($sql);
        return $result;
    }

    // Kiểm tra trùng
    function checkDuplicate($sender_id, $receiver_id)
    {
        // Lấy trạng thái yêu cầu của người mà user hiện tại đang muốn kết bạn
        $status = $this->getStatusRequest($receiver_id, $sender_id)[0];
        if ($status != null) {
            if ($status["status"] == "Pending") {
                return true; // Duplicate request
            }
        }
        return false;
    }

    // Lấy trạng thái yêu cầu của 2 người dùng
    public function getStatusRequest($user_id, $profile_user_id)
    {
        $DB = new Database();
        $sql = "SELECT status FROM friend_requests WHERE sender_id = {$user_id} AND receiver_id = {$profile_user_id}";
        $result = $DB->Query($sql);
        return $result;
    }

    public function checkExistRequest($user_id, $profile_user_id)
    {
        $DB = new Database();
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME = 'friend_requests' AND COLUMN_NAME IN ('sender_id', 'receiver_id')";
        $result = $DB->Query($sql);
        if ($result == null) {
            return false;
        } else return true;
    }

    public function checkExistStatus($user_id, $profile_user_id)
    {
        $DB = new Database();
        $sql = "SELECT * FROM friend_requests WHERE (sender_id = {$user_id} AND receiver_id = {$profile_user_id} AND status = 'Cancel')  OR (receiver_id = {$user_id} AND sender_id = {$profile_user_id} AND status = 'Cancel') ";
        $result = $DB->Query($sql);
        return $result;
    }



    public function getStatusResponse($user_id, $profile_user_id)
    {
        $DB = new Database();
        $sql = "SELECT status FROM friend_requests WHERE receiver_id = {$user_id} AND sender_id = {$profile_user_id}";
        $result = $DB->Query($sql);
        return $result;
    }
    // Chấp nhận kết bạn
    public function AcceptRequest($current_id, $sender_id)
    {
        $DB = new Database();
        $sql_update_status = "UPDATE friend_requests SET status = 'Accepted' WHERE sender_id = {$sender_id} and receiver_id = {$current_id}";
        $sql_add_friend = "INSERT INTO friendships (user1_id, user2_id, status) 
                            VALUES ({$sender_id}, {$current_id}, 'isFriend') 
                            ON DUPLICATE KEY UPDATE status = 'isFriend'";
        if ($DB->Execute($sql_update_status)) {
            $result = $DB->Execute($sql_add_friend);
        }
        return $result;
    }

    //unfriend
    public function UnFriend($userid, $profileID)
    {
        $DB = new Database();
        $sql = "DELETE FROM friendships WHERE (user1_id = $userid AND user2_id = $profileID) OR (user2_id = $userid AND user1_id = $profileID)";
        $sql2 = "DELETE FROM friend_requests WHERE (sender_id = $userid AND receiver_id = $profileID) OR (receiver_id = $userid AND sender_id = $profileID)";
        $result = $DB->Execute($sql);
        $result2 = $DB->Execute($sql2);
        return $result && $result2;
    }

    // Check tình trạng là bạn bè hay không
    public function isFriend($user_id, $profile_user_id)
    {
        $DB = new Database();
        $sql = "SELECT * FROM friendships WHERE (user1_id = {$user_id} AND user2_id = {$profile_user_id} AND status = 'isFriend') 
                                            OR (user2_id = {$user_id} AND user1_id = {$profile_user_id} AND status = 'isFriend')";
        $result = $DB->Query($sql);
        if ($result == null) return false;
        else return true;
    }

    // Lấy tất cả các yêu cầu kết bạn
    public function getRequests($userid)
    {
        $DB = new Database();
        $sql = "SELECT * FROM friend_requests WHERE receiver_id = {$userid} AND `status` = 'Pending' ORDER BY `date` DESC";
        $result = $DB->Query($sql);
        return $result;
    }

    //lấy 4 yêu cầu kết bạn
    public function getRequestsLimit($userid,$offset,$limit)
    {
        $DB = new Database();
        $sql = "SELECT * FROM friend_requests WHERE receiver_id = {$userid} AND `status` = 'Pending' ORDER BY `date` DESC limit $offset,$limit";
        $result = $DB->Query($sql);
        return $result;
    }
    // Lấy 1 vài yêu cầu kết bạn mới nhất
    public function getSomeRequests($userid)
    {
        $DB = new Database();
        $sql = "SELECT * FROM friend_requests WHERE receiver_id = {$userid} AND `status` = 'Pending' ORDER BY `date` DESC LIMIT 3";
        $result = $DB->Query($sql);
        return $result;
    }

    // Lấy tất cả các yêu cầu đã gửi
    public function getResponses($userid)
    {
        $DB = new Database();
        $sql = "SELECT * FROM friend_requests WHERE sender_id = {$userid}";
        $result = $DB->Query($sql);
        return $result;
    }

    // Lấy danh sách bạn bè
    public function getListFriend($userid)
    {
        $DB = new Database();
        $sql = "SELECT user1_id AS friend_id
        FROM friendships
        WHERE user2_id = {$userid} AND status = 'isFriend'
        UNION
        SELECT user2_id AS friend_id
        FROM friendships
        WHERE user1_id = {$userid} AND status = 'isFriend'";
        $result = $DB->Query($sql);
        return $result;
        // print_r($result);

    }
    public function getListFriendLimit($userid,$offset,$limit)
    {
        $DB = new Database();
        $sql = "SELECT user1_id AS friend_id
        FROM friendships
        WHERE user2_id = {$userid} AND status = 'isFriend'
        UNION
        SELECT user2_id AS friend_id
        FROM friendships
        WHERE user1_id = {$userid} AND status = 'isFriend' limit $offset ,$limit ";
        $result = $DB->Query($sql);
        return $result;
        // print_r($result);

    }

    // Lấy số lượng bạn bè
    public function getQuantityFriend($userid)
    {
        $friends = $this->getListFriend($userid);
        return sizeof($friends);
    }
    // Lấy số ds bạn bè kết bạn gần đây. LIMIT 8
    public function getRecentlyFriend($userid)
    {
        $sql = "SELECT user1_id AS friend_id , `date` AS date_added
        FROM friendships
        WHERE user2_id = {$userid} AND status = 'isFriend'
        UNION
        SELECT user2_id AS friend_id, `date` AS date_added
        FROM friendships
        WHERE user1_id = {$userid} AND status = 'isFriend'
        ORDER BY date_added DESC 
        LIMIT 8";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }

    public function getFriendToLoad($userid)
    {
        $sql = "SELECT user1_id AS friend_id , `date` AS date_added
        FROM friendships
        WHERE user2_id = {$userid} AND status = 'isFriend'
        UNION
        SELECT user2_id AS friend_id, `date` AS date_added
        FROM friendships
        WHERE user1_id = {$userid} AND status = 'isFriend'
        ORDER BY date_added DESC 
        LIMIT 6 ";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }
}

//Test
// $f = new Friend();
// $f->getListFriend(5678);