<?php
include('utils.php');

$email = $_SESSION["email"];
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
$Id = $_SESSION["ID"];
$isImage = true;
$updated = false;
$emailError = false;
$oldPasswordEmpty = false;
$wrongPassword = false;
$now = date("Y-m-d");
$diff = date_diff(date_create(getBirthDate()), date_create($now));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (count($_FILES) == 1 && $_FILES['profilePicture']['name'] != "") {
        if (@is_array(getimagesize($_FILES['profilePicture']['tmp_name']))) {
            $filename = uniqid();
            $extension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
            $basename = $filename . "." . $extension;
            $oldPfp = mysqli_query($conn, "SELECT profilePicture FROM credentials WHERE email = '$email'");
            $oldPfp = mysqli_fetch_array($oldPfp)["profilePicture"];
            $sqlDeletePfp = "SELECT * FROM credentials WHERE profilePicture = '$oldPfp'";
            $sql = "UPDATE credentials SET profilePicture = '$basename' WHERE email = '$email'";
            mysqli_query($conn, $sql);
            move_uploaded_file($_FILES['profilePicture']['tmp_name'], "./protected/profilePictures/$basename");
            if ($oldPfp != "default.png") unlink("./protected/profilePictures/$oldPfp");
            $_SESSION["profilePicture"] = "./profilePictures/$basename";
            $updated = true;
        } else {
            $isImage = false;
        }
    }
    if ($_POST["aboutMe"] != "") {
        $aboutMeInput = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["aboutMe"]));
        $sql = "UPDATE credentials SET aboutMe = '$aboutMeInput' WHERE email = '$email'";
        mysqli_query($conn, $sql);
        $updated = true;
    }
    if ($_POST["newPassword"] != "") {
        if ($_POST["oldPassword"] == "") {
            $oldPasswordEmpty = true;
        } else {
            if (checkPassword($email, $_POST["oldPassword"])) {
                $password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
                $sql = "UPDATE credentials SET psw = '$password' WHERE email = '$email'";
                mysqli_query($conn, $sql);
                $updated = true;
            } else {
                $wrongPassword = true;
            }
        }
    }
    if ($_POST["email"] != "") {
        if (checkEmail($_POST["email"])) {
            $emailInput = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["email"]));
            mysqli_query($conn, "UPDATE credentials SET email = '$emailInput' WHERE email = '$email'");
            $_SESSION["email"] = $emailInput;
            $email = $emailInput;
            $updated = true;
        } else {
            $emailError = true;
        }
    }
}

$sql = "SELECT aboutMe from credentials WHERE email = '$email'";
$aboutMe = mysqli_query($conn, $sql);
$aboutMe = mysqli_fetch_array($aboutMe)["aboutMe"];

$profilePicture = $_SESSION["profilePicture"];
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="styles/settings.css">
        <link rel="icon" type="image/x-icon" href="protected/img/favicon.ico">
        <title>🖤 Chci rande! 🧡</title>
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
                        <a class="nav-link" href="./home.php">Domu</a>
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
                            <a class="nav-link active fw-bold" style="color: #ff9900;"
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

    <?php if (!$isImage) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Nahraný soubor není obrázek!</h4>
            <p>Prosím, nahrajte obrázek.</p>
            <hr>
            <p class="mb-0">Zkuste to znovu.</p>
        </div>
    <?php endif; ?>

    <?php if ($emailError) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Email již existuje!</h4>
            <p>Prosím, zvolte jiný email.</p>
            <hr>
            <p class="mb-0">Zkuste to znovu.</p>
        </div>
    <?php endif; ?>

    <?php if ($wrongPassword) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Špatné heslo!</h4>
            <p>Prosím, zadejte správné heslo.</p>
            <hr>
            <p class="mb-0">Zkuste to znovu.</p>
        </div>
    <?php endif; ?>

    <?php if ($oldPasswordEmpty) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Špatné heslo!</h4>
            <p>Prosím, zadejte vaše staré heslo, pokud ho chcete změnit.</p>
            <hr>
            <p class="mb-0">Zkuste to znovu.</p>
        </div>
    <?php endif; ?>

    <?php if ($updated) : ?>
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">Profil aktualizován!</h4>
            <p>Váš profil byl úspěšně aktualizován.</p>
        </div>
    <?php endif; ?>

    <div class="container mt-5 mb-5">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img src="<?php echo $profilePicture; ?>">
                                </div>
                                <h5 class="user-name"><?php echo $firstName . " " . $lastName ?></h5>
                                <h6 class="user-email"><?php echo $email ?></h6>
                            </div>
                            <div class="about">
                                <h5 class="mb-2">O mně:</h5>
                                <p><?php echo $aboutMe;
                                    $isImage = true; ?></p>
                            </div>
                            <div class="age">
                                <h5 class="mb-2">Věk:</h5>
                                <p><?php echo $diff->format('%y'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="mb-3">Změnit osobní informace</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email"
                                               placeholder="Vložte nový email" name="email">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="text">O mně</label>
                                        <input type="text" class="form-control" id="about_me"
                                               placeholder="Napište něco o sobě" name="aboutMe">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row gutters mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="mb-3">Změnit heslo</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="oldPassword">Staré heslo</label>
                                        <input type="password" class="form-control" id="oldPassword"
                                               placeholder="Zadejte staré heslo" name="oldPassword">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="newPassword">Nové heslo</label>
                                        <input type="password" class="form-control" id="newPassword"
                                               placeholder="Zadejte nové heslo" name="newPassword">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row gutters mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="mb-3">Změnit profilový obrázek</h6>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="file" name="profilePicture"/>
                                </div>
                            </div>
                            <br>
                            <div class="row gutters mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <button class="btn btn-primary" type="submit" name="submit">Potvrdit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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