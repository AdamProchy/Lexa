<?php
/*
 _____                                  
/ _  / __ ___   _____  _ __ __ _  /\/\  
\// / / _` \ \ / / _ \| '__/ _` |/    \ 
 / //\ (_| |\ V / (_) | | | (_| / /\/\ \
/____/\__,_| \_/ \___/|_|  \__,_\/    \/                                      
*/
session_start();
if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName'])) {
    header("location: ./");
    exit();
}
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$sexuality = $_SESSION['sexuality'];
$dateSent = false;
include "config.php";

$sql = "SELECT * FROM credentials";
$result = mysqli_query($conn, $sql);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

function sexuality($sexuality)
{
    switch ($sexuality) {
        case "S":
            return "Heterosexuál";
            break;
        case "G":
            return "Homosexuál";
            break;
        case "L":
            return "Lesba";
            break;
        case "B":
            return "Bisexuál";
            break;
        case "A":
            return "Asexuál";
            break;
        case "D":
            return "Demisexuál";
            break;
        case "P":
            return "Pansexuál";
            break;
        case "Q":
            return "Queer";
            break;
        case "?":
            return "Nejisté";
            break;
    }
}

function gender($gender)
{
    switch ($gender) {
        case "M":
            return "Muž";
            break;
        case "F":
            return "Žena";
            break;
        case "MtF":
            return "Trans žena";
            break;
        case "FtM":
            return "Trans muž";
            break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    for ($i = 0; $i < count($users); $i++) {
        if (isset($_POST["send-date-$i"])) {
            $dateSent = true;
            $senderEmail = $_SESSION['email'];
            $date = filter_input(INPUT_POST, 'sender-date');
            $time = filter_input(INPUT_POST, 'sender-time');
            $message = filter_input(INPUT_POST, 'sender-message');
            $place = filter_input(INPUT_POST, 'sender-place');
            $recipientEmail = $users[$i]['email'];

            $datetime = $date . ' ' . $time;
            $sql = "INSERT INTO dates (senderEmail, recipientEmail, dateInvitation, message, place)
            VALUES ('$senderEmail', '$recipientEmail', '$datetime', '$message', '$place')";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
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
        <title>🖤 Chci rande! 🧡</title>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php"><img src="./img/logo.png" width="200px" height="50px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="./home.php">Domu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="color: #ff9900;" href="./date.php">Chci rande!</a>
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

    <!--Date was sent successfully-->
    <?php if ($dateSent) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Úspěch!</strong> Žádost o rande byla úspěšně odeslána.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <script>
            setTimeout(function () {
                window.location.href = "./date.php";
            }, 2500);
        </script>
    <?php } ?>

    <section id="dates" class="p-5 bg-dark">
        <div class="container">
            <h2 class="text-center text-white">Nabídka</h2>
            <br>
            <div class="row g-4">
                <?php for ($i = 0; $i < sizeof($users); $i++) {
                    if ($users[$i]['email'] != "admin@admin.com" && $users[$i]['email'] != $_SESSION['email']) {
                        $firstNameDB = $users[$i]['firstName'];
                        $lastNameDB = $users[$i]['lastName'];
                        $aboutMeDB = $users[$i]['aboutMe'];
                        $sexualityDB = $users[$i]['sexuality'];
                        $gender = $users[$i]['gender'];
                        $birthDateDB = $users[$i]['birthDate'];
                        $now = date("Y-m-d");
                        $diff = date_diff(date_create($birthDateDB), date_create($now));
                        $profilePictureDB = "./profilePictures/" . $users[$i]['profilePicture'];
                        echo '<div class="col-md-6 col-lg-3">';
                        echo '<div class="card bg-secondary text-white">';
                        echo '<img src="' . $profilePictureDB . '" class="card-img-top rounded text-center" alt="User Image" style="width: 100%; height: 200px;">';
                        echo '<div class="card-body text-center">';
                        echo '<h3 class="card-title"><span style="font-weight: 600;">' . $firstNameDB . '</span></h3>';
                        echo '<p class="card-title" style="font-size: large;">' . $lastNameDB . '</p>';
                        echo '<p class="card-subtitle mb-2"><b>Věk: </b>' . $diff->format('%y') . '</p>';
                        echo '<p class="card-subtitle mb-2"><b>Pohlaví: </b>' . gender($gender) . '</p>';
                        echo '<h6 class="card-subtitle mb-2"><b>Sexualita: </b></h6>';
                        echo '<p class="card-text">' . sexuality($sexualityDB) . '</p>';
                        echo '<h6 class="card-subtitle mb-2"><b>O mně:</b> </h6>';
                        echo '<p class="card-text">' . $aboutMeDB . '</p>';
                        echo '<button type="button" class="btn btn-primary mr-2 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal' . $i . '">Požádat o rande</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        echo '<div class="modal fade" id="exampleModal' . $i . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                        echo '<div class="modal-dialog">';
                        echo '<div class="modal-content" id="cardbg">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="exampleModalLabel">Požádat o rande</h5>';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                        echo '<form method="post">';
                        echo '<div class="mb-3">';
                        echo '<label for="sender-name" class="col-form-label">Jméno:</label>';
                        echo '<input type="text" class="form-control" id="sender-name" name="sender-name" value="' . $firstNameDB . ' ' . $lastNameDB . '" disabled>';
                        echo '</div>';
                        echo '<div class="mb-3">';
                        echo '<label for="sender-date" class="col-form-label">Datum:</label>';
                        echo '<input type="date" class="form-control" id="sender-date" name="sender-date" required>';
                        echo '</div>';
                        echo '<div class="mb-3">';
                        echo '<label for="sender-time" class="col-form-label">Čas:</label>';
                        echo '<input type="time" class="form-control" id="sender-time" name="sender-time" required>';
                        echo '</div>';
                        echo '<div class="mb-3">';
                        echo '<label for="sender-place" class="col-form-label">Místo:</label>';
                        echo '<input type="text" class="form-control" id="sender-place" name="sender-place" required>';
                        echo '</div>';
                        echo '<div class="mb-3">';
                        echo '<label for="sender-message" class="col-form-label">Zpráva:</label>';
                        echo '<textarea class="form-control" id="sender-message" name="sender-message"></textarea>';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>';
                        echo '<button type="submit" class="btn btn-primary" name="send-date-' . $i . '">Odeslat</button>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } ?>
            </div>
        </div>
    </section>


    <!--FOOTER-->
    <footer class="p-1 bg-dark text-white text-center position-relative mt-auto">
        <div class="container">
            <p class="lead">Copyright &copy; PROCHY | SPŠE Ječná</p>
            <a href="#" class="position-absolute bottom-0 end-0 p-5"><i class="bi-arrow-up-circle h1"
                                                                        style="color: #ff9900;"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    </body>

    </html>

<?php
mysqli_close($conn);
?>