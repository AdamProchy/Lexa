<?php
include('./utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$email = $_SESSION['email'];

$getChatRoomId = $_GET['chatRoomId'] ?? null;
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="icon" type="image/x-icon" href="./protected/img/favicon.ico">
        <link rel="stylesheet" href="styles/chat.css">
        <title>🖤 Chat 🧡</title>
    </head>
    <body class="d-flex flex-column min-vh-100" id="body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark nav-underline">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php"><img src="./protected/img/logo.png" width="200px" height="50px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="./home.php">Domu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./date.php">Chci rande!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./help.php">Podpora</a>
                    </li>
                    <li>
                        <a class="nav-link active" href="./chat.php" style="color: #ff9900;">Chat</a>
                    </li>
                </ul>
                <ul class="navbar-nav mt-2 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <button id="switch" class="btn nav-link" onclick="toggleTheme()">Switch</button>
                    <li class="nav-item">
                        <a class="nav-link" href="./shop.php">999999
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-coin" viewBox="0 0 16 16">
                                <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z"/>
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/>
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" style="color: #ff9900;"
                           href="./settings.php"><?php echo $firstName . " " . $lastName ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: red;" href="./logout.php">Odhlásit se</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
                                echo "<a class='list-group-item list-group-item-action bg-dark text-white rounded-0' href='./chat.php?chatRoomId=" . $chatRoomId . "'>";
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