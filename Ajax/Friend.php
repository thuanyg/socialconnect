<?php
    include("../Classes/database.php");
    include("../Classes/user.php");
    include("../Classes/friend.php");
    

    session_start();
    if(isset($_POST["action"])){
        if($_POST["action"] == "request"){
            $sender_id = $_SESSION["userid"]; // User gửi lời mời kết bạn
            $receiver_id = $_POST["userid"]; // User nhận
            $f = new Friend();
            $result = $f->Request($sender_id, $receiver_id);
            echo $result;
        }

        if($_POST["action"] == "cancel-request"){
            $sender_id = $_SESSION["userid"]; // User gửi lời mời kết bạn
            $receiver_id = $_POST["userid"]; // User nhận
            $f = new Friend();
            $result = $f->CancelRequest($sender_id, $receiver_id);
            echo $result;
        }

        if($_POST["action"] == "accept-request"){
            $sender_id = $_POST["userid"]; // User gửi lời mời
            $receiver_id = $_SESSION["userid"]; // Người nhận được lời mời kết bạn là user hiện tại
            $f = new Friend();
            $result = $f->AcceptRequest($receiver_id, $sender_id);
            echo $result;
        }

        if($_POST["action"] == "delete-request"){ // Từ chối kết bạn
            $sender_id = $_POST["userid"]; // Người gửi lời mời là user trên url
            $receiver_id = $_SESSION["userid"]; // Người nhận được lời mời là người dùng hiện tại
            $f = new Friend();
            $result = $f->DeleteRequest($sender_id, $receiver_id);
            echo $result;
        }

        if($_POST["action"] == "response"){
            echo "response";
        }
        if($_POST["action"] == "get_more_friends"){
            $userid = $_SESSION["userid"];
            $f = new Friend();
            $user = new User();
            $numberCurrent = $_POST["number"];
            $friendLimit = $f->getListFriendLimit($userid,$numberCurrent,8);
            for ($i = 0; $i < sizeof($friendLimit); $i++) {
                $friend = $user->getUser($friendLimit[$i]["friend_id"]);
            ?>
                <div class="card p-2">
                    <a href="profile.php?uid=<?php echo $friend["userid"] ?>">
                        <img src="<?php echo $friend["avatar_image"] ?>" class="h-36 object-cover rounded-md shadow-sm w-full">
                    </a>
                    <div class="pt-3 px-1">
                        <a href="profile.php?uid=<?php echo $friend["userid"] ?>" class="text-base font-semibold mb-0.5"> <?php echo $friend["first_name"] . " " . $friend["last_name"] ?> </a>
                        <p class="font-medium text-sm"><?php echo $f->getQuantityFriend($friend["userid"]) . " Friend" ?> </p>
                        <button class="bg-blue-100 w-full flex font-semibold h-8 items-center justify-center mt-3 px-3 rounded-md text-blue-600 text-sm mb-1">
                            Friend
                        </button>
                    </div>
                </div>
            <?php
            }
            
        }
}

