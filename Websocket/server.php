<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

include_once("../Classes/message.php");
include_once("../Classes/user.php");
include_once("../Classes/status.php");
include_once("../Classes/post.php");
// Require the Composer autoloader to load Ratchet and its dependencies
require 'vendor/autoload.php';

// Define a class that implements the MessageComponentInterface provided by Ratchet
class YourWebSocketServer implements MessageComponentInterface
{
    protected $clients; // Tạo một biến để lưu trữ danh sách các kết nối từ client

    public function __construct()
    {
        $this->clients = new \SplObjectStorage; // Khởi tạo SplObjectStorage để lưu trữ các kết nối
    }

    // Xử lý khi một kết nối mới được mở
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);
        $userid = $queryArray["uid"];
        echo "UserID connect: " . $userid . "\n";
        $user = new User();
        $user->setConnectionID($userid, $conn->resourceId);
        echo "New connection! ({$conn->resourceId})\n"; // Xuất thông báo kết nối mới với ID của kết nối
        // Set trạng thái online khi kết nối
        $status = new Status();
        $status->updateStatus($userid, "online");
    }

    // Xử lý khi nhận được một tin nhắn từ client
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message = json_decode($msg, true);
        if ($message["action"] == "private") {
            // Chuyển nội tin nhắn thành kiểu html special (XSS)
            $senderId = $message['senderId'];
            $receiverId = $message['receiverId'];
            $user_obj = new User();
            // get user information
            $sen = $user_obj->getUser($senderId);
            $re = $user_obj->getUser($receiverId);
            $receiver_connection_id = $re["connection_id"];
            $messageContent = htmlspecialchars($message['messageContent'], ENT_QUOTES, 'UTF-8');
            // Gán lại tin nhắn để gửi tới người
            $message['messageContent'] = $messageContent;
            if ($message["media"] != null) {
                $media = json_encode($message["media"]);
            } else $media = "";
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $message["date"] = date('Y-m-d H:i:s');
            $dateTime = new DateTime($message["date"]);
            $message["date"] = $dateTime->format('H:i');
            $m = new Message();
            $m->saveMessage($senderId, $receiverId, $messageContent, $media);
            foreach ($this->clients as $client) {
                // Check if the client is the intended receiver
                if ($from == $client) {
                    $message["from"] = "Me";
                } else {
                    $message["from"] = $sen["userid"];
                }
                if ($client->resourceId == $receiver_connection_id || $from == $client) {
                    $client->send(json_encode($message));
                }
            }
        }
        if ($message["action"] == "typing") {
            foreach ($this->clients as $client) {
                // Check if the client is the intended receiver
                if ($from == $client) {
                    $message["typer"] = "Me";
                } else {
                    $message["typer"] = $sen["userid"];
                }

                if ($client->resourceId == $receiver_connection_id || $from == $client) {
                    $client->send(json_encode($message));
                }
            }
        }
        if ($message["action"] == "not-typing") {
            foreach ($this->clients as $client) {
                // Check if the client is the intended receiver
                if ($from == $client) {
                    $message["not_typing"] = "Me";
                } else {
                    $message["not_typing"] = $sen["first_name"] . $sen["last_name"];
                }

                if ($client->resourceId == $receiver_connection_id || $from == $client) {
                    $client->send(json_encode($message));
                }
            }
        }

        if ($message["action"] == "like-post") {
            $postid = $message["postid"];
            $sql = "select * from posts where postid = ".$postid;
            $db = new Database();
            $receiverId = ($db->Query($sql))[0];
            $receiver = (new User())->getUser($receiverId["userid"]);
            $receiver_connection_id = $receiver["connection_id"];
            $userid = $message["userid"];
            // $p = new Post();
            // $p->setLikePost($postid, $userid);
            // Lấy số lượng thông báo chưa đọc
            $sql = "SELECT COUNT(*) as 'total' FROM notifications WHERE userid = ".$userid." AND isRead = 0";
            $notification_quantity = $db->Query($sql)[0]["total"];
            // Set value message
            $message["avatar_image"] = $receiver["avatar_image"];
            $message["first_name"] = $receiver["first_name"];
            $message["last_name"] = $receiver["last_name"];
            $message["notification_quantity"] = $notification_quantity;

            foreach ($this->clients as $client) {
                // Check if the client is the intended receiver
                if ($from == $client) {
                    $message["sender"] = "Me";
                } else {
                    $message["sender"] = "Not me";
                }

                if ($client->resourceId == $receiver_connection_id || $from == $client) {
                    $client->send(json_encode($message));
                }
            }
        }
    }


    // Xử lý khi một kết nối đóng
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn); // Xóa kết nối đã đóng khỏi danh sách các kết nối
        echo "Connection {$conn->resourceId} has disconnected\n"; // Xuất thông báo về kết nối đã đóng với ID của kết nối
        // Set trạng thái offline
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);
        $userid = $queryArray["uid"];
        $status = new Status();
        $status->updateStatus($userid, "offline");
    }

    // Xử lý khi có lỗi xảy ra trên kết nối
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n"; // Xuất thông báo lỗi
        $conn->close(); // Đóng kết nối 
    }
    public function sendConnectedClientsListToAll()
    {
        $clientList = [];
        foreach ($this->clients as $client) {
            $clientList[] = $client->resourceId;
        }

        $data = json_encode(['clients' => $clientList]); // Chuyển danh sách thành JSON

        foreach ($this->clients as $client) {
            $client->send($data);
        }
    }
}

// Tạo máy chủ WebSocket bằng Ratchet, lắng nghe trên cổng 8080
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new YourWebSocketServer() // Sử dụng lớp bạn đã tạo làm máy chủ WebSocket
        )
    ),
    8081
);

echo "Server is running...\n"; // Xuất thông báo máy chủ đang chạy

$server->run(); // Khởi chạy máy chủ để lắng nghe kết nối WebSocket
