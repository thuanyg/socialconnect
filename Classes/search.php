<?php
class Search
{
    function SearchUser($query)
    {
        $sql = "SELECT * FROM users WHERE concat(first_name,' ',last_name) LIKE '%{$query}%' and privacy = 'public' LIMIT 10";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }
    function SearchNextUser($query, $offset)
    {
        $sql = "SELECT * FROM users WHERE concat(first_name,' ',last_name) LIKE '%{$query}%' and privacy = 'public' LIMIT 5 OFFSET {$offset}";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }

    function SearchHistoryMessage($senderID, $receiverID, $query)
    {
        $sql = "SELECT * FROM messages WHERE text LIKE '%{$query}%' AND ((sender_id = {$senderID} 
        and receiver_id = {$receiverID}) OR (sender_id = {$receiverID} and receiver_id = {$senderID})) ";
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
    function Searchpost($query)
    {
        $sql = "SELECT id, postid, MAX(userid) AS userid, MAX(post_share_id) AS post_share_id, MAX(date) AS date, MAX(post) AS post, MAX(has_image) AS has_image, MAX(has_video) AS has_video, MAX(media) AS media, MAX(privacy) AS privacy, MAX(type) AS type
        FROM (
            SELECT id, postid, share_userid AS userid, post_share_id, date, NULL AS post, NULL AS has_image, NULL AS has_video, NULL AS media, NULL AS privacy, 'share' as type
            FROM share
        
            UNION ALL
        
            SELECT id, postid, userid, NULL AS post_share_id, date, post, has_image, has_video, media, privacy, 'post' as type
            FROM posts
            WHERE post LIKE '%{$query}%'
        ) AS combined
        GROUP BY postid
        ORDER BY MAX(date) DESC";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }
}
