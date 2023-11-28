<?php
// <!-- Các hàm để xử lý bài viết post (Tạo bài post, lấy bài post, ...) -->
include_once("database.php");
class Post
{
    function createPost($data, $userid)
    {
        $DB = new Database();
        $post = $DB->escapedString($data["post"]); // get content
        $media = $data["media"];
        $privacy = $data["privacy"];
        $postid = $this->create_postid();
        $sql = "INSERT INTO posts (postid, userid, post, has_image, media, privacy) VALUES ($postid, $userid, '$post', 1, '$media', '$privacy')";
        $result = $DB->Execute($sql);
        return $result;
    }

    public function create_postid()
    {
        $length = rand(10, 19);
        $postid = "";
        for ($i = 0; $i <= $length; $i++) {
            $new_rand  = rand(0, 9);
            $postid .= $new_rand;
        }
        return $postid;
    }

    function getPost($userid)
    {
        $sql = "SELECT id, postid, MAX(userid) AS userid, MAX(post_share_id) AS post_share_id, MAX(date) AS date, MAX(post) AS post, MAX(has_image) AS has_image, MAX(has_video) AS has_video, MAX(media) AS media, MAX(privacy) AS privacy, MAX(type) AS type
        FROM (
            SELECT id, postid, share_userid AS userid, post_share_id, date, NULL AS post, NULL AS has_image, NULL AS has_video, NULL AS media, privacy, 'share' as type
            FROM share
        
            UNION ALL
        
            SELECT id, postid, userid, NULL AS post_share_id, date, post, has_image, has_video, media, privacy, 'post' as type
            FROM posts
        ) AS combined
        WHERE userid = {$userid}
        GROUP BY postid
        ORDER BY MAX(date) DESC limit 5;";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }
    function getFullPost($userid)
    {
        $sql = "select * from posts where userid = " . $userid . " ";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }

    function getNextPostTimeLine($userid, $offset)
    {
        $sql = "SELECT id, postid, MAX(userid) AS userid, MAX(post_share_id) AS post_share_id, MAX(date) AS date, MAX(post) AS post, MAX(has_image) AS has_image, MAX(has_video) AS has_video, MAX(media) AS media, MAX(privacy) AS privacy, MAX(type) AS type
        FROM (
            SELECT id, postid, share_userid AS userid, post_share_id, date, NULL AS post, NULL AS has_image, NULL AS has_video, NULL AS media, privacy, 'share' as type
            FROM share
        
            UNION ALL
        
            SELECT id, postid, userid, NULL AS post_share_id, date, post, has_image, has_video, media, privacy, 'post' as type
            FROM posts
        ) AS combined
        WHERE userid = {$userid}
        GROUP BY postid
        ORDER BY MAX(date) DESC limit 5 Offset $offset";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }

    function getNextPostProfile($userid, $offset)
    {
        $sql = "select * from posts where userid = " . $userid . " AND (privacy = 'public' OR privacy = 'friend') Order by date desc limit 5 offset {$offset}";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }

    function getAPost($postID)
    {
        $sql = "select * from posts where postid = " . $postID;
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }
    function getPostPublic($userid)
    {
        $sql = "select * from posts where userid = " . $userid . " and privacy = 'public' Order by date desc";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }
    function getAllPostPublic()
    {
        // $sql = "select * from posts where privacy = 'public' Order by date desc limit 5";
        $sql = "SELECT id, postid, MAX(userid) AS userid, MAX(post_share_id) AS post_share_id, MAX(date) AS date, MAX(post) AS post, MAX(has_image) AS has_image, MAX(has_video) AS has_video, MAX(media) AS media, MAX(privacy) AS privacy, MAX(type) AS type
        FROM (
            SELECT id, postid, share_userid AS userid, post_share_id, date, NULL AS post, NULL AS has_image, NULL AS has_video, NULL AS media, privacy, 'share' as type
            FROM share
        
            UNION ALL
        
            SELECT id, postid, userid, NULL AS post_share_id, date, post, has_image, has_video, media, privacy, 'post' as type
            FROM posts
        ) AS combined
        GROUP BY postid
        ORDER BY MAX(date) DESC limit 5;";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }
    function getNextAllPostPublic($offset)
    {
        // $sql = "select * from posts where privacy = 'public' Order by date desc limit 5 offset {$offset}";
        $sql = "SELECT id, postid, MAX(userid) AS userid, MAX(post_share_id) AS post_share_id, MAX(date) AS date, MAX(post) AS post, MAX(has_image) AS has_image, MAX(has_video) AS has_video, MAX(media) AS media, MAX(privacy) AS privacy, MAX(type) AS type
        FROM (
            SELECT id, postid, share_userid AS userid, post_share_id, date, NULL AS post, NULL AS has_image, NULL AS has_video, NULL AS media, privacy, 'share' as type
            FROM share
        
            UNION ALL
        
            SELECT id, postid, userid, NULL AS post_share_id, date, post, has_image, has_video, media, privacy, 'post' as type
            FROM posts
        ) AS combined
        GROUP BY postid
        ORDER BY MAX(date) DESC limit 5 offset $offset;";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result;
        } else return null;
    }
    function getNewPost($userid)
    {
        $sql = "select * from posts where userid = " . $userid . " ORDER BY id DESC LIMIT 1 ";
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result[0];
        } else return null;
    }
    // Lay so luong anh cua post
    function getPhotoFromPost($userid)
    {
        $sql = "SELECT SUM(JSON_LENGTH(media)) AS total_media FROM posts where userid = " . $userid;
        $DB = new Database();
        $result = $DB->Query($sql);
        if ($result != null) {
            return $result[0];
        } else return null;
    }
    // Xóa bài post
    function deletePost($postid)
    {
        $sql = "DELETE FROM posts WHERE postid = {$postid}";
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }
    // Like post
    function setLikePost($postid, $userid)
    {
        // $sql = "INSERT INTO notifications (userid, related_object_id, content, type) VALUES ({$userid}, {$postid},'like','like')";
        $sql = "CALL `sp_ToggleLike`({$userid}, {$postid});";
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }
    // get like post
    function getLikePost($postid)
    {
        $sql = "select * from likes where postid = $postid order by date desc";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }
    // lấy số lượng like 
    function getQuantityLike($postid)
    {
        $sql = "Select count(*) as total  From likes where postid = $postid";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;
    }
    //share post
    function setSharePost($post_share_id, $userid)
    {
        $postid = $this->create_postid();
        $sql = "INSERT INTO share (share_userid, postid, post_share_id) VALUES ({$userid}, {$postid}, {$post_share_id})";
        $sql2 = "INSERT INTO posts (postid, userid, post, has_image, media, privacy) VALUES ({$postid}, {$userid}, '', 1, '', 'Public')";
        $DB = new Database();
        $result = $DB->Execute($sql);
        $result2 = $DB->Execute($sql2);
        if($result && $result2){
            $r = 1;
        } else $r = 0;
        return $r;
    }
    //Edit post
    function updatePost($postid, $data)
    {
        $DB = new Database();
        $post = $DB->escapedString($data["post"]); // get content
        $media = $data["media"];
        $privacy = $data["privacy"];
        $sql = "UPDATE posts SET post = '$post', privacy = '$privacy', media = '$media' WHERE postid = $postid";
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }
}
