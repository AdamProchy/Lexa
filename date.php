<?php
include('utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$sexuality = $_SESSION['sexuality'];
$dateSent = false;

$sql = "SELECT * FROM credentials";
$result = mysqli_query($conn, $sql);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

shuffle($users);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($users as $i => $user) {
        if (isset($_POST["send-date-$i"])) {
            $dateSent = true;
            $senderId = $_SESSION['ID'];
            $date = mysqli_real_escape_string($conn, $_POST['sender-date']);
            $time = mysqli_real_escape_string($conn, $_POST['sender-time']);
            $message = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['sender-message']));
            $place = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['sender-place']));
            $recipientId = mysqli_real_escape_string($conn, $_POST['recipientId']);

            $datetime = $date . ' ' . $time;
            $sql = "INSERT INTO dates (senderId, recipientId, dateInvitation, message, place)
                    VALUES ('$senderId', '$recipientId', '$datetime', '$message', '$place')";

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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="styles/index.css">
        <link rel="icon" type="image/x-icon" href="protected/img/favicon.ico">
        <title>🖤 Moje Rande 🧡</title>
    </head>
    <body class="d-flex flex-column min-vh-100" id="body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark nav-underline">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php"><img src="protected/img/logo.png" width="200px"
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
                        <a class="nav-link active" href="./date.php" style="color: #ff9900;">Chci rande!</a>
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
    <section id="dates" class="p-5">
        <div class="container">
            <h2 class="text-center">Nabídka</h2>
            <br>
            <div class="row g-4">
                <?php
                foreach ($users as $i => $user) {
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
                        echo '<input type="date" class="form-control" id="sender-date" name="sender-date" required min="' . date('Y-m-d') . '">';
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
                        echo '<input type="hidden" name="recipientId" value="' . $users[$i]['ID'] . '">';
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
    <footer class="bg-dark text-white text-center position-relative mt-auto">
        <div class="container">
            <p class="lead">Copyright &copy; PROCHY | SPŠE Ječná</p>
            <a href="#" class="position-absolute bottom-0 end-0 p-5"><i class="bi-arrow-up-circle h1"
                                                                        style="color: #ff9900;"></i></a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script>
        function checkTimeValidity() {
            const today = new Date();
            const todayDate = today.toISOString().slice(0, 10);
            const selectedDateInput = document.getElementById("sender-date");
            const selectedDate = new Date(selectedDateInput.value);

            const selectedDateFormatted = selectedDate.toISOString().slice(0, 10);

            if (selectedDateFormatted === todayDate) {
                const currentTime = new Date();
                const currentHours = currentTime.getHours();
                const currentMinutes = currentTime.getMinutes();

                const selectedTime = document.getElementById("sender-time").valueAsDate;
                const selectedHours = selectedTime.getHours();
                const selectedMinutes = selectedTime.getMinutes();
                if (selectedHours < currentHours || (selectedHours === currentHours && selectedMinutes < currentMinutes)) {
                    alert("Prosím, vyberte platný čas.");
                    document.getElementById("sender-time").value = null;
                }
            }
        }

        document.getElementById("sender-time").addEventListener("change", checkTimeValidity);
        document.getElementById("sender-date").addEventListener("change", checkTimeValidity);
    </script>
    <script src="./scripts/night-theme.js"></script>
    </body>
    </html>
<?php
mysqli_close($conn);
?>