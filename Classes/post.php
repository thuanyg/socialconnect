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

    function getPost($userid){
        $sql = "select * from posts where userid = " . $userid. " Order by date desc limit 5";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }
    function getFullPost($userid){
        $sql = "select * from posts where userid = " . $userid. " ";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }

    function getNextPostTimeLine($userid, $offset){
        $sql = "select * from posts where userid = " . $userid. " Order by date desc limit 5 offset {$offset}";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }

    function getNextPostProfile($userid, $offset){
        $sql = "select * from posts where userid = " . $userid. " AND (privacy = 'public' OR privacy = 'friend') Order by date desc limit 5 offset {$offset}";
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
        $sql = "select * from posts where privacy = 'public' Order by date desc limit 5";
        $DB = new Database();
        $result = $DB->Query($sql);
        if($result != null){
            return $result;
        } else return null;
    }
    function getNextAllPostPublic($offset){
        $sql = "select * from posts where privacy = 'public' Order by date desc limit 5 offset {$offset}";
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
    // Lay so luong anh cua post
    function getPhotoFromPost($userid){
        $sql = "SELECT SUM(JSON_LENGTH(media)) AS total_media FROM posts where userid = " . $userid;
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
        $Sql = "INSERT INTO `like` (userid, postid ) VALUES ({$userid}, {$postid} )";
        $DB = new Database();
        $result1 = $DB->Execute($sql);
        $result2 = $DB->Execute($Sql);
     if ($result1&&$result2 )
     {
        return 1;
     }else{
        return 0;
     }
        
    }
    // get like post
    function getLikePost($postid){
        $sql = "select * from `like` where postid=$postid";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;



    }
    // lấy số lượng like 
    function getQuantityLike($postid){
        $sql = "Select count(*) as total  From `like` where postid = $postid";
        $DB = new Database();
        $result = $DB->Query($sql);
        return $result;

    }
    //share post
    function setSharePost($postid, $userid) {
       

        $Sql = "INSERT INTO share (share_userid, postid ) VALUES ({$userid}, {$postid} )";
        

        
        $DB = new Database();
        $result = $DB->Execute($Sql);
        return $result;
        
         
    }
    //Edit post
    function updatePost($postid, $data){
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
