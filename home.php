<?php
/*
 _____                                  
/ _  / __ ___   _____  _ __ __ _  /\/\  
\// / / _` \ \ / / _ \| '__/ _` |/    \ 
 / //\ (_| |\ V / (_) | | | (_| / /\/\ \
/____/\__,_| \_/ \___/|_|  \__,_\/    \/
*/

//Show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


session_start();
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$Id = $_SESSION['ID'];
if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit();
}
include "config.php";

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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="styles/index.css">
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <title>🖤 Moje Rande 🧡</title>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php"><img src="./img/logo.png" width="200px" height="50px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="./home.php">Domu</a>
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
            if ($row['ID'] == $_SESSION['ID']) {
                $dateId = $row['recipientId'];
            } else {
                $dateId = $row['senderId'];
            }
        }
        $date_id = 0;
        // Get date id
        $sql = "SELECT ID FROM `credentials` WHERE `email` = '" . $dateId . "'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $date_id = $row['ID'];
        }
        //Get user id
        $user_id = 0;
        $sql = "SELECT ID FROM `credentials` WHERE `email` = '" . $_SESSION['email'] . "'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['ID'];
        }
        //Check if chat room already exists
        $sql = "SELECT * FROM `chat_rooms` WHERE `user1_id` = '" . $user_id . "' AND `user2_id` = '" . $date_id . "'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $sql = "SELECT * FROM `chat_rooms` WHERE `user1_id` = '" . $date_id . "' AND `user2_id` = '" . $user_id . "'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0) {
                // Create chat room
                $sql = "INSERT INTO `chat_rooms` (`ID`, `user1_id`, `user2_id`) VALUES (NULL, '" . $user_id . "', '" . $date_id . "')";
                mysqli_query($conn, $sql);
            }
        }
        //Reroute to chat
        //TODO: Make reroute to the specific chat right away
        header("Location: ./chat.php");
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


    <!--DATES IN MAIN-->
    <section id="dates" class="p-5">
        <div class="container">
            <?php
            if (empty($dates)) {
                echo "<h2 class='text-center text-dark'>Nemáte žádné domluvené schůzky.</h2>";
            } else {
                ?>
                <h2 class="text-center text-dark">Domluvené schůzky:</h2>
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
                        $profilePictureDB = "./profilePictures/" . $row['profilePicture'];
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


    <!--FOOTER-->
    <footer class="p-5 bg-dark text-white text-center position-relative mt-auto">
        <div class="container">
            <p class="lead">Copyright &copy; PROCHY</p>
            <a href="#" class="position-absolute bottom-0 end-0 p-5"><i class="bi-arrow-up-circle h1"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    </body>

    </html>

<?php
mysqli_close($conn);
?>