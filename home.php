<?php
include('utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$Id = $_SESSION['ID'];

$sql = "SELECT * FROM `dates` WHERE `senderId` = '$Id' OR `recipientId` = '$Id'";
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="styles/index.css">
        <link rel="icon" type="image/x-icon" href="./protected/img/favicon.ico">
        <title>🖤 Moje Rande 🧡</title>
    </head>

    <body class="d-flex flex-column min-vh-100" id="body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark nav-underline">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php"><img src="./protected/img/logo.png" width="200px"
                                                            height="50px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="./home.php" style="color: #ff9900;">Domu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./date.php">Chci rande!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./help.php">Podpora</a>
                    </li>
                    <li>
                        <a class="nav-link" href="./chat.php">Chat</a>
                    </li>
                </ul>
                <ul class="navbar-nav mt-2 mb-2 mb-lg-0">

                    <li class="nav-item">
                        <button id="switch" class="btn nav-link" onclick="toggleTheme()"></button>
                    <li class="nav-item">
                        <a class="nav-link" href="./shop.php">
                            999999
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-coin" viewBox="0 0 16 16">
                                <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z"/>
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/>
                            </svg>
                        </a>
                    </li>
                    <?php if ($Id == 1) { ?>
                        <li class="nav-item me-2">
                            <a class="nav-link" style="color: #ff9900;" href="./admin.php">Admin panel</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item me-2">
                            <a class="nav-link" style="color: #ff9900;"
                               href="./settings.php"><?php echo $firstName . " " . $lastName ?></a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color: red;" href="./logout.php">Odhlásit se</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (isset($_POST['cancel'])) { ?>
        <?php
        $sql = "DELETE FROM `dates` WHERE `dates`.`ID` = '" . $_POST['dateID'] . "'";
        mysqli_query($conn, $sql);
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Rande bylo úspěšně zrušeno!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function () {
                window.location.href = "./home.php";
            }, 2500);
        </script>
    <?php } ?>

    <?php if (isset($_POST['send_message'])) { ?>
        <?php
        $dateId = "";
        $sql = "SELECT * FROM `dates` WHERE `ID` = '" . $_POST['dateID'] . "'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['senderId'] == $_SESSION['ID']) {
                $dateId = $row['recipientId'];
            } else {
                $dateId = $row['senderId'];
            }
        }
        $date_id = 0;
        // Get date id
        $sql = "SELECT ID FROM `credentials` WHERE `ID` = '" . $dateId . "'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $date_id = $row['ID'];
        }
        //Check if chat room already exists
        $sql = "SELECT * FROM `chat_rooms` WHERE `user1_id` = '" . $_SESSION['ID'] . "' AND `user2_id` = '" . $date_id . "'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $sql = "SELECT * FROM `chat_rooms` WHERE `user1_id` = '" . $date_id . "' AND `user2_id` = '" . $_SESSION['ID'] . "'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0) {
                // Create chat room
                $sql = "INSERT INTO `chat_rooms` (`user1_id`, `user2_id`) VALUES ('" . $_SESSION['ID'] . "', '" . $date_id . "')";
                mysqli_query($conn, $sql);
            }
        }
        //Get chat room id
        $chatRoomId = 0;
        $sql = "SELECT ID FROM `chat_rooms` WHERE `user1_id` = '" . $_SESSION['ID'] . "' AND `user2_id` = '" . $date_id . "'";

        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $chatRoomId = $row['ID'];
        }
        //Reroute to chat
        //TODO: Make reroute to the specific chat right away
        header("Location: chat.php?chatRoomId=" . $chatRoomId);

        ?>
    <?php } ?>


    <?php if (isset($_POST['submit'])) { ?>
        <?php
        $sql = "UPDATE `dates` SET `confirmed` = '1' WHERE `dates`.`ID` = '" . $_POST['dateID'] . "'";
        mysqli_query($conn, $sql);
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Rande bylo úspěšně potvrzeno!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function () {
                window.location.href = "./home.php";
            }, 2500);
        </script>
    <?php } ?>
    <section id="dates" class="p-5">
        <div class="container">
            <?php
            if (empty($dates)) {
                echo "<h2 class='text-center'>Nemáte žádné domluvené schůzky.</h2>";
            } else {
                ?>
                <h2 class="text-center">Domluvené schůzky:</h2>
                <br>
                <div class="row g-4">

                    <?php for ($i = 0; $i < sizeof($dates); $i++) { ?>

                        <?php
                        if ($Id != $dates[$i]['senderId']) {
                            $sql = "SELECT * FROM `credentials` WHERE `ID` = '" . $dates[$i]['senderId'] . "'";
                        }
                        if ($Id != $dates[$i]['recipientId']) {
                            $sql = "SELECT * FROM `credentials` WHERE `ID` = '" . $dates[$i]['recipientId'] . "'";
                        }
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $firstNameDB = $row['firstName'];
                        $lastNameDB = $row['lastName'];
                        $profilePictureDB = "./protected/profilePictures/" . $row['profilePicture'];
                        ?>

                        <div class="col-md-6 col-lg-3">
                            <div class="card"
                                 style="background-color: <?php echo $dates[$i]['confirmed'] ? '#00cc00' : '#ffff00'; ?>; color: black;">
                                <div class="card-body text-center">
                                    <div id="card-top">
                                        <img src="<?php echo $profilePictureDB; ?>" class="rounded-circle" id="image"
                                             alt="">
                                        <h3 class="card-title"><span
                                                    style="font-weight: 600;"><?php echo $firstNameDB; ?></span><br><span
                                                    style="font-size: large;"><?php echo $lastNameDB; ?></span></h3>
                                    </div>
                                    <br>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Místo: <?php echo $dates[$i]['place']; ?></h6>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Datum: <?php echo date("d.m.Y", strtotime($dates[$i]['dateInvitation'])); ?></h6>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Čas: <?php echo date("h:i", strtotime($dates[$i]['dateInvitation'])); ?></h6>
                                    <h6 class="card-subtitle mb-2 text-white">
                                        Zpráva: <?php echo $dates[$i]['message']; ?></h6>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="dateID" value="<?php echo $dates[$i]['ID']; ?>">
                                        <?php if ($dates[$i]['senderId'] == $_SESSION["ID"] || $dates[$i]['confirmed']) { ?>
                                            <button href="#" class="btn btn-danger mt-3" name="cancel">Zrušit rande
                                            </button>
                                            <button href="#" class="btn btn-info mt-3" name="send_message">Napsat zprávu
                                            </button>
                                        <?php } else if ($dates[$i]['senderId'] != $_SESSION["email"]) { ?>
                                            <button href="#" class="btn btn-success mr-2 mt-3" name="submit">Potvrdit
                                            </button>
                                            <button href="#" class="btn btn-danger mt-3" name="cancel">Odmítnout
                                            </button>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
    <footer class="bg-dark text-white text-center position-relative mt-auto">
        <div class="container">
            <p class="lead">Copyright &copy; PROCHY | SPŠE Ječná</p>
            <a href="#" class="position-absolute bottom-0 end-0 p-5"><i class="bi-arrow-up-circle h1"
                                                                        style="color: #ff9900;"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    <script src="./scripts/night-theme.js"></script>
    </body>

    </html>

<?php
mysqli_close($conn);
?>