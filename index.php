<?php
session_start();
//show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if (!isset($_SESSION["conn_params"])) {
    // If database connection doesn't exist, reroute to connection form on connection.php
    header("Location: ./connection.php");
    exit();
} else {
    $conn = mysqli_connect($_SESSION["conn_params"]['host'], $_SESSION["conn_params"]['user'], $_SESSION["conn_params"]['password'], '', $_SESSION["conn_params"]['port']);
    mysqli_query($conn, "USE mojerandedb");
}
if (isset($_SESSION['email'])) {
    header("Location: home.php");
    exit();
}
$isPasswordRight = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $psw = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql = "select * from credentials where email = '$email'";
    if (mysqli_num_rows(mysqli_query($conn, $sql)) == 1) {
        $db_hash = mysqli_fetch_array(mysqli_query($conn, $sql))["psw"];
        if (password_verify($psw, $db_hash)) {
            $_SESSION["firstName"] = mysqli_fetch_array(mysqli_query($conn, $sql))["firstName"];
            $_SESSION["email"] = $email;
            $_SESSION["lastName"] = mysqli_fetch_array(mysqli_query($conn, $sql))["lastName"];
            $_SESSION["aboutMe"] = mysqli_fetch_array(mysqli_query($conn, $sql))["aboutMe"];
            $_SESSION["profilePicture"] = "./protected/profilePictures/" . mysqli_fetch_array(mysqli_query($conn, $sql))["profilePicture"];
            $_SESSION["sexuality"] = mysqli_fetch_array(mysqli_query($conn, $sql))["sexuality"];
            $_SESSION["dateSent"] = false;
            $_SESSION["ID"] = mysqli_fetch_array(mysqli_query($conn, $sql))["ID"];
            header("location: home.php");
        } else {
            echo "        
            <div class='alert alert-danger text-center' role='alert'>
            Špatné heslo!
            </div>";
        }
    } else {
        echo "
        <div class='alert alert-danger text-center' role='alert'>
        Chyba!
        </div>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./protected/img/favicon.ico">
    <title>🖤 Moje Rande 🧡 - Přihlášení</title>
</head>

<body>
<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <?php if ($isPasswordRight == false) : ?>
        <div class="alert alert-danger text-center" role="alert">
            Špatné heslo!
        </div>
    <?php endif; ?>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="mb-4 pb-2 pb-md-0 mb-md-5">Přihlášení</h1>
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <input type="email" id="emailAddress" name="email"
                                                   class="form-control form-control-lg"/>
                                            <label class="form-label" for="emailAddress">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <input type="password" id="psw" name="psw"
                                                   class="form-control form-control-lg"/>
                                            <label class="form-label" for="psw">Heslo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <input class="btn btn-primary btn-lg" type="submit" value="Submit"/>
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

    </div>
</form>
</body>
</html>