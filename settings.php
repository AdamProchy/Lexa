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
            $oldPfp = mysqli_query($conn, "SELECT profilePicture FROM credentials WHERE ID = '$Id'");
            $oldPfp = mysqli_fetch_array($oldPfp)["profilePicture"];
            $sqlDeletePfp = "SELECT * FROM credentials WHERE profilePicture = '$oldPfp'";
            $sql = "UPDATE credentials SET profilePicture = '$basename' WHERE Id = '$Id'";
            mysqli_query($conn, $sql);
            move_uploaded_file($_FILES['profilePicture']['tmp_name'], "./protected/profilePictures/$basename");
            if ($oldPfp != "default.png") unlink("./protected/profilePictures/$oldPfp");
            $_SESSION["profilePicture"] = "./protected/profilePictures/$basename";
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
$pageName = 'settings.php';
include('./templates/head_and_navbar.php');
if (!$isImage) { ?>
    <div class="alert alert-danger text-center" role="alert">
        <h4 class="alert-heading">Nahraný soubor není obrázek!</h4>
        <p>Prosím, nahrajte obrázek.</p>
        <hr>
        <p class="mb-0">Zkuste to znovu.</p>
    </div>
<?php }
if ($emailError) { ?>
    <div class="alert alert-danger text-center" role="alert">
        <h4 class="alert-heading">Email již existuje!</h4>
        <p>Prosím, zvolte jiný email.</p>
        <hr>
        <p class="mb-0">Zkuste to znovu.</p>
    </div>
<?php }
if ($wrongPassword) { ?>
    <div class="alert alert-danger text-center" role="alert">
        <h4 class="alert-heading">Špatné heslo!</h4>
        <p>Prosím, zadejte správné heslo.</p>
        <hr>
        <p class="mb-0">Zkuste to znovu.</p>
    </div>
<?php }
if ($oldPasswordEmpty) { ?>
    <div class="alert alert-danger text-center" role="alert">
        <h4 class="alert-heading">Špatné heslo!</h4>
        <p>Prosím, zadejte vaše staré heslo, pokud ho chcete změnit.</p>
        <hr>
        <p class="mb-0">Zkuste to znovu.</p>
    </div>
<?php }
if ($updated) { ?>
    <div class="alert alert-success text-center" role="alert">
        <h4 class="alert-heading">Profil aktualizován!</h4>
        <p>Váš profil byl úspěšně aktualizován.</p>
    </div>
<?php } ?>

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
                                    <h4 class="mb-3">Změnit heslo</h4>
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
<?php
include('./templates/footer.php');