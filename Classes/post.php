<?php
// <!-- Các hàm để xử lý bài viết post (Tạo bài post, lấy bài post, ...) -->
include_once("database.php");
class Post
{
    function createPost($data, $userid)
    {
        $DB = new Database();
        $post = $DB->escapedString($data["post"]); // get content
        $images = $data["images"]; 
        $privacy = $data["privacy"]; 
        $postid = $this->create_postid();
        $sql = "INSERT INTO posts (postid, userid, post, has_image, media, privacy) VALUES ($postid, $userid, '$post', 1, '$images', '$privacy')";
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

    function getPost($userid){
        $sql = "select * from posts where userid = " . $userid. " Order by date desc";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }

    function getAPost($postID){
        $sql = "select * from posts where postid = ".$postID;
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }

    function getPostPublic($userid){
        $sql = "select * from posts where userid = " . $userid. " and privacy = 'public' Order by date desc";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }

    function getAllPostPublic(){
        $sql = "select * from posts where privacy = 'public' Order by date desc";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }


    function getNewPost($userid){
        $sql = "select * from posts where userid = " . $userid. " ORDER BY id DESC LIMIT 1 ";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result[0];
        } else return null;
    }

    // Xóa bài post
    function deletePost($postid){
        $sql = "DELETE FROM posts WHERE postid = {$postid}";
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }

    // Like post
    function setLikePost($postid, $userid){
        $sql = "INSERT INTO notifications (userid, related_object_id, content, type) VALUES ({$userid}, {$postid},'like','like')";
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }
    //Edit post
    function updatePost($postid, $data){
        $DB = new Database();
        $post = $DB->escapedString($data["post"]); // get content
        $images = $data["images"]; 
        $privacy = $data["privacy"]; 
        $sql = "UPDATE posts SET post = '$post', privacy = '$privacy', media = '$images' WHERE postid = $postid";
        $DB = new Database();
        $result = $DB->Execute($sql);
        return $result;
    }
}
