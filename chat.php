<?php
/*
 _____                                  
/ _  / __ ___   _____  _ __ __ _  /\/\  
\// / / _` \ \ / / _ \| '__/ _` |/    \ 
 / //\ (_| |\ V / (_) | | | (_| / /\/\ \
/____/\__,_| \_/ \___/|_|  \__,_\/    \/                                      
*/


session_start();
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit();
}
include "config.php";

$sql = "SELECT * FROM `dates` WHERE `senderEmail` = '$email' OR `recipientEmail` = '$email'";
$result = mysqli_query($conn, $sql);

$dates = array();
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row;
}
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="styles/chat.css">
        <title>🖤 Chat 🧡</title>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php"><img src="./img/logo.png" width="200px"
                                                            height="50px"></a>
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
                        <a class="nav-link active" href="./chat.php">Chat</a>
                    </li>
                </ul>
                <ul class="navbar-nav mt-2 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <p class="navbar-text text-white">Přihlášen: </p>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link text-warning"
                           href="./settings.php"><?php echo $firstName . " " . $lastName ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="./logout.php">Odhlásit se</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row overflow-hidden shadow">
            <div class="col-3 p-2 bg-dark">
                <div class="messages-box bg-dark">
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
                            $chatMate_ID = $chatMate_First_Name = $chatMate_Last_Name = $chatMate_Picture = "";
                            //Decide who is the chatmate
                            $sql = "SELECT * FROM `credentials` WHERE `ID` = '" . $chatRoom['user1_id'] . "'";
                            $result = mysqli_query($conn, $sql);
                            // Compare with email from session
                            if (mysqli_fetch_array($result)['email'] == $email) {
                                $sql = "SELECT ID,firstName, lastName, profilePicture FROM `credentials` WHERE `ID` = " . $chatRoom['user2_id'] . ";";
                                $result = mysqli_query($conn, $sql);
                            }

                            $chatMate = mysqli_fetch_array($result);
                            $chatMate_ID = $chatMate['ID'];
                            $chatMate_First_Name = $chatMate['firstName'];
                            $chatMate_Last_Name = $chatMate['lastName'];
                            $chatMate_Picture = './profilePictures/' . $chatMate['profilePicture'];

                            $chatRoomId = $chatRoom['ID'];

                            echo "<a class='list-group-item list-group-item-action bg-dark text-white rounded-0'>";
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


            <!-- Chat Box-->
            <div class="col-9 px-0">
                <div class="px-4 py-5 chat-box bg-dark">
                    <!-- Sender Message on right side-->
                    <div class="media mb-3">
                        <img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50"
                             class="rounded-circle">
                        <div class="media-body ml-3">
                            <div class="bg-secondary rounded py-2 px-3 mb-1 mt-1 d-inline-block mw-100"
                                 style="overflow-wrap: break-word;">
                                <p class="text-light mb-0">Toto je ODESÍLATEL
                                    testghghhggghgghhghgfhgfhjgjhghjghjgjhggfhgfdhnfdhjgbhfdjgbjhfdbhgkdjfhgkfdjhgjkfdghkfdjghkfdjhgfdkjghfdkjghdjhgkjfdghjhgjghjgjhgfghjhgfdfghjhgfdsfghjkjztrertzjkjhgfdfg</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <div class="media mb-3">
                        <img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50"
                             class="rounded-circle">
                        <div class="media-body ml-3">
                            <div class="bg-secondary rounded py-2 px-3 mb-1 mt-1 d-inline-block mw-100"
                                 style="overflow-wrap: break-word;">
                                <p class="text-light mb-0">Toto je ODESÍLATEL </p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <!-- Receiver Message on Left Side-->
                    <div class="media mb-3 text-end">
                        <img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50"
                             class="rounded-circle">
                        <div class="media-body ml-3">
                            <div class="rounded py-2 px-3 mb-1 mt-1 d-inline-block mw-100 "
                                 style="overflow-wrap: break-word; background-color: #FF9900;">
                                <p class="text-small mb-0 text-light text-start">Toto je
                                    Lorenfbhdjshgjkdhglkjdhgkjfdshgfdhgjkdfshgfdsjgldsfhkgfdhskgjhfdslkjghfdslkjghfdslkjhglkfdsjhglkjfdshglkjfdshgdjhglkjfdshgkfjdbjfhglkfjdshgkfdshghůlfdjglfdhgkjfdhglkjfdghlfdkhglkfdjhglkjm
                                    ipsu</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <div class="media mb-3 text-end">
                        <img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50"
                             class="rounded-circle">
                        <div class="media-body ml-3">
                            <div class="rounded py-2 px-3 mb-1 mt-1 d-inline-block mw-100 "
                                 style="overflow-wrap: break-word; background-color: #FF9900;">
                                <p class="text-small mb-0 text-light text-start">Toto je
                                    gfdjgfdkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk
                                    ipsu</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>
                </div>


                <form action="#" class="bg-dark">
                    <div class="input-group">
                        <input type="text" placeholder="Type a message" aria-describedby="button-addon2"
                               class="form-control rounded-0 border-0 py-4 bg-dark">
                        <div class="input-group-append">
                            <button id="button-addon2" type="submit" class="btn btn-link bg-primary text-white p-3 m-2">
                                Odeslat
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    </body>

    </html>

<?php
mysqli_close($conn);
?>