<?php
include("../Classes/database.php");
include("../Classes/search.php");
if (isset($_GET["action"])) {
    if ($_GET["action"] == "search-user") {
        $query = $_GET["query"];
        $s = new Search();
        $result = $s->SearchUser($query);
        if ($result != null) {
            for ($i = 0; $i < sizeof($result); $i++) {
?>
                <li>
                    <a href="profile.php?uid=<?php echo $result[$i]["userid"] ?>">
                        <img src="<?php echo $result[$i]["avatar_image"] ?>" alt="" class="list-avatar">
                        <div class="list-name"> <?php echo $result[$i]["first_name"] . " " . $result[$i]["last_name"] ?> </div>
                    </a>
                </li>
            <?php
            }
        }
    }
    if ($_GET["action"] == "search-message") {
        $query = $_GET["query"];
        $s = new Search();
        $result = $s->SearchUser($query);
        if ($result != null) {
            for ($i = 0; $i < sizeof($result); $i++) {
            ?>
                <li>
                    <a href="chats-friend.php?uid=<?php echo $result[$i]["userid"] ?>">
                        <div class="" style="padding: 5px">
                            <img style="width: 30px; display: inline-block;" src="<?php echo $result[$i]["avatar_image"] ?>" alt="" class="list-avatar">
                            <span style="font-size: 16px;"><?php echo $result[$i]["first_name"] . " " . $result[$i]["last_name"] ?> </span>
                        </div>
                    </a>
                </li>
            <?php
            }
        }
    }
    if ($_REQUEST["action"] == "find-history-message") {
        $query = $_GET["query"];
        $senderID = $_GET["userID"];
        $receiverID = $_GET["receiverID"];
        $s = new Search();
        $result = $s->SearchHistoryMessage($senderID, $receiverID, $query);
        if ($result != null) {
            echo "<div style='text-align:center; color: blue'>" . count($result) . " results</div>";
            for ($i = 0; $i < sizeof($result); $i++) {
            ?>
                <div class="loading-history"></div>
                <li class="message-result-row" style="color: #fff; background-color: #2a41e8;" data-message-id="<?php echo $result[$i]["id"] ?>">
                    <div class="" style="padding: 5px">
                        <span style="font-size: 16px;">Message: <?php echo $result[$i]["text"] ?></span>
                        <span style="padding: 0 3px;">|</span>
                        <span style="font-size: 16px;">Date: <?php echo $result[$i]["date"] ?></span>
                    </div>
                </li>
<?php
            }
        }
    }
};
?>