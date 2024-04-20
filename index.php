<?php
include_once ("database_connection_checker.php");
if (isset($_SESSION['email'])) {
    header("Location: home.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $psw = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_SPECIAL_CHARS);
    $stmt = $conn->prepare("SELECT * FROM credentials WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows == 1) {
        $result = mysqli_fetch_array($result);
        if (password_verify($psw, $result["psw"])) {
            $_SESSION["firstName"] = $result["firstName"];
            $_SESSION["email"] = $email;
            $_SESSION["lastName"] = $result["lastName"];
            $_SESSION["aboutMe"] = $result["aboutMe"];
            $_SESSION["profilePicture"] = "./protected/profilePictures/" . $result["profilePicture"];
            $_SESSION["sexuality"] = $result["sexuality"];
            $_SESSION["dateSent"] = false;
            $_SESSION["ID"] = $result["ID"];

            header("location: ./home.php");
        } else {
            $error = "Špatné heslo!";
        }
    } else {
        $error = "Uživatel neexistuje!";
    }
}
mysqli_close($conn);
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
    <title>🖤 Moje Rande 🧡 - Přihlášení</title>
</head>

<body>
    <form method="post">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $error ?>
            </div>
        <script>
            setTimeout(function() { document.querySelector(".alert").remove(); }, 2000);
        </script>
        <?php endif; unset($error); ?>
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-12 col-lg-9 col-xl-7">
                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-md-5">
                                <div class="d-flex justify-content-end">
                                    <button id="switch" type="button" class="btn nav-link" onclick="cycleThemes()"></button>
                                </div>
                                <h1 class="mb-4 pb-2 pb-md-0 mb-md-5">Přihlášení</h1>
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="email" id="emailAddress" name="email" class="form-control form-control-lg"  <?php if(isset($_POST['email'])) echo "value='".$_POST['email']."'"; ?> />
                                                <label class="form-label" for="emailAddress">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="password" id="psw" name="psw" class="form-control form-control-lg" />
                                                <label class="form-label" for="psw">Heslo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-2">
                                        <input class="btn btn-primary btn-lg" type="submit" value="Submit" />
                                    </div>
                                    <br>
                                    <a href="./register.php">Registrovat</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="./scripts/night-theme.js"></script>
</body>

</html>