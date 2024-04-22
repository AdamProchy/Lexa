<?php
include_once('utils.php');

$email = $_SESSION["email"];
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
$Id = $_SESSION["ID"];
$now = date("Y-m-d");
$diff = date_diff(date_create(getBirthDate()), date_create($now));
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if (isset($_POST['submit'])){
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
                $success = "Váš profil byl úspěšně aktualizován.";
            } else {
                $error = "Nahraný soubor není obrázek! Zkuste to znovu prosím znovu.";
            }
        }
        if ($_POST["aboutMe"] != "") {
            $aboutMeInput = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["aboutMe"]));
            $sql = "UPDATE credentials SET aboutMe = '$aboutMeInput' WHERE email = '$email'";
            mysqli_query($conn, $sql);
            $success = "Váš profil byl úspěšně aktualizován.";
        }
        if ($_POST["newPassword"] != "") {
            if ($_POST["oldPassword"] == "") {
                $error = "Zadejte vaše staré heslo, pokud ho chcete změnit.";
            } else {
                if (checkPassword($email, $_POST["oldPassword"])) {
                    $password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
                    $sql = "UPDATE credentials SET psw = '$password' WHERE email = '$email'";
                    mysqli_query($conn, $sql);
                    $success = "Váš profil byl úspěšně aktualizován.";
                } else {
                    $error = "Špatné heslo! Zkuste to prosím znovu.";
                }
            }
        }
        if ($_POST["email"] != "") {
            if (checkEmail($_POST["email"])) {
                $emailInput = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["email"]));
                mysqli_query($conn, "UPDATE credentials SET email = '$emailInput' WHERE email = '$email'");
                $_SESSION["email"] = $emailInput;
                $email = $emailInput;
                $success = "Váš profil byl úspěšně aktualizován.";
            } else {
                $error = "Email již existuje! Zvolte prosím jiný email.";
            }
        }
    }
    if (isset($_POST['delete_profile'])) {
        $profilePicture = mysqli_query($conn, "SELECT profilePicture FROM credentials WHERE ID = '$Id'");
        $profilePicture = mysqli_fetch_array($profilePicture)["profilePicture"];
        if ($profilePicture != "default.png") unlink("./protected/profilePictures/$profilePicture");
        mysqli_query($conn, "DELETE FROM credentials WHERE ID = '$Id'");
        session_destroy();
        header("Location: index.php");
    }
}

$sql = "SELECT aboutMe from credentials WHERE email = '$email'";
$aboutMe = mysqli_query($conn, $sql);
$aboutMe = mysqli_fetch_array($aboutMe)["aboutMe"];

$profilePicture = $_SESSION["profilePicture"];
$pageName = 'settings.php';
include('./templates/head_and_navbar.php');
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card border border-secondary rounded-3">
                <div class="card-body">
                    <div class="text-center">
                        <img src="<?php echo $profilePicture; ?>" class="img-fluid rounded-circle profile-picture" alt="User Picture">
                        <h5 class="mt-3"><?php echo $firstName . " " . $lastName ?></h5>
                        <hr>
                        <p class="text-muted"><?php echo $email ?></p>
                        <hr>
                        <p class="card-text"><span class="fw-bold">Věk:</span> <?php echo $diff->format('%y'); ?></p>
                        <hr>
                        <p class="card-text"><span class="fw-bold">O mně:</span> <?php echo $aboutMe; ?></p>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-9">
            <div class="card border border-secondary rounded-3">
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h4 class="mb-3">Změnit osobní informace</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Vložte nový email" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="about_me">O mně</label> <span id="about-me-counter" class="text-muted">0/100</span></label>
                                    <input type="text" class="form-control" id="about_me" placeholder="Napište něco o sobě" name="aboutMe" oninput="limitTextarea(this,100)">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4 class="mb-3">Změnit heslo</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="oldPassword">Staré heslo</label>
                                    <input type="password" class="form-control" id="oldPassword" placeholder="Zadejte staré heslo" name="oldPassword">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="newPassword">Nové heslo</label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="Zadejte nové heslo" name="newPassword">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4 class="mb-3">Změnit profilový obrázek</h4>
                        <div class="form-group">
                            <input class="form-control-file" type="file" name="profilePicture" />
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" type="submit" name="submit">Potvrdit</button>
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteProfileModal">Smazat profil</button>
                            <div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteProfileModalLabel">Smazat profil</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Opravdu chcete smazat svůj profil?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                                            <input type="hidden" name="ID" value="<?php echo $Id; ?>">
                                            <button type="submit" name="delete_profile" class="btn btn-danger">Smazat</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function limitTextarea(field, maxChar){
        const text = field.value;
        const charCount = text.length;

        if (text.length > maxChar) {
            field.value = text.substring(0, maxChar);
        } else {
            document.getElementById('about-me-counter').innerText = charCount + '/' + maxChar;
        }
    }
</script>
<?php
include('./templates/footer.php');
