<?php
include('utils.php');

$email = $_SESSION["email"];
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="styles/settings.css">
        <link rel="icon" type="image/x-icon" href="protected/img/favicon.ico">
        <title>🖤 Chci rande! 🧡</title>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
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
                                <h5 class="mb-2 text-light">O mně:</h5>
                                <p><?php echo $aboutMe;
                                    $isImage = true; ?></p>
                            </div>
                            <div class="age">
                                <h5 class="mb-2 text-light">Věk:</h5>
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
                                    <h4 class="mb-3 text-light">Změnit osobní informace</h6>
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
                                    <h4 class="mb-3 text-light">Změnit heslo</h6>
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
                                    <h4 class="mb-3 text-light">Změnit profilový obrázek</h6>
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