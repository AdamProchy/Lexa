<?php
include('./utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$email = $_SESSION['email'];

$getChatRoomId = $_GET['chatRoomId'] ?? null;
$pageName = 'chat.php';
include('./templates/head_and_navbar.php');
?>
    <div class="container-fluid">
        <div class="row overflow-hidden">
            <div class="col-3">
                <div class="messages-box">
                    <div class="list-group rounded-0">
                        <?php
                        $sql = "SELECT * FROM `chat_rooms` WHERE `user1_id` = (SELECT ID FROM `credentials` WHERE `email` = '" . $email . "') OR `user2_id` = (SELECT ID FROM `credentials` WHERE `email` = '" . $email . "');";
                        $result = mysqli_query($conn, $sql);
                        $chatRooms = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $chatRooms[] = $row;
                        }
                        //Print all chat rooms
                        foreach ($chatRooms as $chatRoom) {
                            $chatMate = getChatMate($conn, $email, $chatRoom['user1_id'], $chatRoom['user2_id']);

                            $chatMate_ID = $chatMate['ID'];
                            $chatMate_First_Name = $chatMate['firstName'];
                            $chatMate_Last_Name = $chatMate['lastName'];
                            $chatMate_Picture = './protected/profilePictures/' . $chatMate['profilePicture'];

                            $chatRoomId = $chatRoom['ID'];
                            if ($chatRoomId == $getChatRoomId) {
                                echo "<a class='list-group-item list-group-item-action text-dark rounded-0' href='./chat.php?chatRoomId=" . $chatRoomId . "' style='background-color: #FF9900;'>";
                            } else {
                                echo "<a class='list-group-item list-group-item-action rounded-0' href='./chat.php?chatRoomId=" . $chatRoomId . "'>";
                            }
                            echo "<div class='media'><img src='" . $chatMate_Picture . "' alt='user' width='30' class='rounded-circle'>";
                            echo "<div class='media-body ml-4'>";
                            echo "<div class='d-flex align-items-center justify-content-between mb-0'>";
                            echo "<h5 class=' mb-0'>" . $chatMate_First_Name . " " . $chatMate_Last_Name . "</h5>";
                            echo "</div>";
                            if (!is_null($chatRoom['last_message'])) {
                                echo "<small class='mt-0'>" . $chatRoom['last_message'] . "</small>";
                            }
                            echo "</div>";
                            echo "</div>";
                            echo "</a>";

                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            // Check if chat room is selected
            if (is_null($getChatRoomId)) {
                echo "<div class='col-9 px-0'>";
                echo "<div class='px-4 py-5 chat-box'>";
                echo "<h3 class='text-center'>Vyberte chat</h3>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</body>";
                echo "</html>";
            } else {
                //Firstly load all messages
                $sql = "SELECT * FROM `messages` WHERE `sender_id` = (SELECT ID FROM `credentials` WHERE `email` = '" . $email . "') OR `receiver_id` = (SELECT ID FROM `credentials` WHERE `email` = '" . $email . "');";
                $result = mysqli_query($conn, $sql);
                $messages = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $messages[] = $row;
                }
                //Load my ID
                $sql = "SELECT ID FROM `credentials` WHERE `email` = '" . $email . "';";
                $result = mysqli_query($conn, $sql);
                $myID = mysqli_fetch_array($result)['ID'];

                //Load chatmate ID
                $sql = "SELECT user1_id, user2_id FROM `chat_rooms` WHERE `ID` = " . $getChatRoomId . ";";
                $result = mysqli_query($conn, $sql);
                $chatRoom = mysqli_fetch_array($result);
                $chatMate_ID = $chatRoom['user1_id'] == $myID ? $chatRoom['user2_id'] : $chatRoom['user1_id'];

                //Filter out messages that have user1_id as me and user2_id as chat mate or vice versa
                $messages = array_filter($messages, function ($message) use ($myID, $chatMate_ID) {
                    return ($message['sender_id'] == $myID && $message['receiver_id'] == $chatMate_ID) || ($message['sender_id'] == $chatMate_ID && $message['receiver_id'] == $myID);
                });

                echo "<div class='col-9 px-0'>";
                echo "<div class='px-4 py-5 chat-box'>";

                //Print all messages:
                foreach ($messages as $message) {
                    $sender_id = $message['sender_id'];
                    $receiver_id = $message['receiver_id'];
                    $message_text = $message['message'];
                    $message_time = date("H:i | d.m", strtotime($message['created_at']));
                    $message_id = $message['ID'];

                    //Get my profile picture
                    $sql = "SELECT profilePicture FROM `credentials` WHERE `ID` = " . $myID . ";";
                    $result = mysqli_query($conn, $sql);
                    $myPfp = './protected/profilePictures/' . mysqli_fetch_array($result)['profilePicture'];

                    //If i'm the sender, use printMyMessage
                    if ($sender_id == $myID) {
                        printMyMessage($message_text, $message_time, $myPfp);
                    } else {
                        //If i'm the receiver, use printReceiverMessage
                        $sql = "SELECT profilePicture FROM `credentials` WHERE `ID` = " . $sender_id . ";";
                        $result = mysqli_query($conn, $sql);
                        $sender_pfp = './protected/profilePictures/' . mysqli_fetch_array($result)['profilePicture'];
                        printReceiverMessage($message_text, $message_time, $sender_pfp);
                    }
                }
                echo "</div>";
                echo "</div>";

            }
            ?>
        </div>
        <form action="send-message.php" class="row" method="post">
            <div class="input-group">
                <input type="hidden" name="user1_id" value="<?php echo $myID; ?>">
                <input type="hidden" name="user2_id" value="<?php echo $chatMate_ID; ?>">
                <input type="hidden" name="chatRoomId" value="<?php echo $getChatRoomId; ?>">
                <input type="text" placeholder="Napište zprávu" aria-describedby="button-addon2"
                       class="form-control rounded-0 border-0 py-4" name="message">
                <div class="input-group-append">
                    <button id="button-addon2" type="submit" class="btn btn-link bg-primary text-white p-3 m-2">
                        Odeslat
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    <script src="./scripts/night-theme.js"></script>
    </body>

    </html>

<?php
mysqli_close($conn);
?>