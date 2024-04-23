<?php
//show errors
ini_set('display_errors', 1);
session_start();
include_once("database_connection_checker.php");
if (!isset($_SESSION["conn_params"])) {
    // If database connection doesn't exist, reroute to connection form on connection.php
    header("Location: ./connection.php");
    exit();
} else {
    //Create database connection based on conn_params
    $conn = mysqli_connect($_SESSION["conn_params"]['host'], $_SESSION["conn_params"]['user'], $_SESSION["conn_params"]['password'], '', $_SESSION["conn_params"]['port']);
    mysqli_query($conn, "USE mojerandedb");
}
$isAdult = true;
$isEmailAvailable = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $lastName = $birthdayDate = $gender = $email = $psw = $sexuality = $isAdult = "";
    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);

    //Check if the first and last name is valid using https://check-name.herokuapp.com api
    $firstName_url = urlencode($firstName);
    $lastName_url = urlencode($lastName);
    // Get the response from the api
    try {
        $response = file_get_contents("https://check-name.herokuapp.com/verify/$firstName_url%20$lastName_url");
    } catch (Exception $e) {
    }
    $response = json_decode($response, true);
    $score = $response["score"];
    if (isset($score) and $score == 0) {
        $error = "Jméno nebo příjmení není validní.";
    } else {
        $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);
        $birthdayDate = filter_input(INPUT_POST, "birthdayDate", FILTER_SANITIZE_SPECIAL_CHARS);
        $gender = filter_input(INPUT_POST, "inlineRadioOptions", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $psw = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_SPECIAL_CHARS);
        $psw = password_hash($psw, PASSWORD_DEFAULT);
        $sexuality = filter_input(INPUT_POST, "sexuality", FILTER_SANITIZE_SPECIAL_CHARS);

        $now = date("Y-m-d");
        $diff = date_diff(date_create($birthdayDate), date_create($now));

        if (checkIfEmailAvalible($email, $conn)) {
            try{
                $stmt = $conn->prepare("INSERT INTO credentials (firstName, lastName, email, gender, sexuality, psw, birthDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $firstName, $lastName, $email, $gender, $sexuality, $psw, $birthdayDate);
                $stmt->execute();
                $stmt->close();

                $sql = "select ID, aboutMe from credentials where email = '$email'";
                $result = mysqli_query($conn, $sql);
                $_SESSION["firstName"] = $firstName;
                $_SESSION["email"] = $email;
                $_SESSION["lastName"] = $lastName;
                $_SESSION["aboutMe"] = mysqli_fetch_array(mysqli_query($conn, $sql))["aboutMe"];
                $_SESSION["profilePicture"] = "./protected/profilePictures/default.png";
                $_SESSION["sexuality"] = $sexuality;
                $_SESSION["dateSent"] = false;
                $_SESSION["ID"] = mysqli_fetch_array(mysqli_query($conn, $sql))["ID"];

                header("location: home.php");
                exit();
            } catch (Exception $e) {
                $error = "Nastala chyba v databázi: " . $e->getMessage();
            }
        } else {
            $error = "Email je již použitý.";
        }
    }
}

mysqli_close($conn);

function checkIfEmailAvalible($email, $conn)
{
    $sql = "SELECT email FROM credentials WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return false;
    } else {
        return true;
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
    <link rel="icon" type="image/x-icon" href="./protected/img/favicon.ico">
    <title>🖤 Moje Rande 🧡 - Registrace</title>
</head>

<body>
<form method="post" class="needs-validation" novalidate>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger text-center" role="alert" id="alert">
            <?= $error ?>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    <?php endif; ?>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex justify-content-end">
                                <button id="switch" class="btn nav-link" type="button" onclick="cycleThemes()"></button>
                            </div>
                            <h1 class="mb-4 pb-2 pb-md-0 mb-md-5">Registrace</h1>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">Jméno</label>
                                    <input type="text"
                                           class="form-control <?php if (isset($error) && (strpos($error, "Jméno") !== false)) echo 'is-invalid'; ?>"
                                           id="firstName" name="firstName"
                                           required <?php if (isset($_POST['firstName'])) echo 'value="' . $_POST['firstName'] . '"'; ?>>
                                    <?php
                                    if (isset($error)) {
                                        if (strpos($error, "Jméno") !== false) {
                                            echo '<div class="text-danger">Jméno nebo příjmení není validní.</div>';
                                        }
                                    } else {
                                        echo '<div class="invalid-feedback">Vyplňte vaše křestní jméno.</div>';
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Přijmení</label>
                                    <input type="text"
                                           class="form-control <?php if (isset($error) && (strpos($error, "Jméno") !== false)) echo 'is-invalid'; ?>"
                                           id="lastName" name="lastName"
                                           required <?php if (isset($_POST['lastName'])) echo 'value="' . $_POST['lastName'] . '"'; ?>>
                                    <?php
                                    if (isset($error)) {
                                        if (strpos($error, "Jméno") !== false) {
                                            echo '<div class="text-danger">Jméno nebo příjmení není validní.</div>';
                                        }
                                    } else {
                                        echo '<div class="invalid-feedback">Vyplňte vaše příjmení.</div>';
                                    }
                                    ?>
                                </div>

                                <div class="col-md-6">
                                    <label for="birthdayDate" class="form-label">Datum narození</label>
                                    <input type="date" class="form-control" id="birthdayDate" name="birthdayDate"
                                           required <?php if (isset($_POST['birthdayDate'])) echo 'value="' . $_POST['birthdayDate'] . '"'; ?>>
                                    <div class="invalid-feedback" id="birthdayError">Vyplňte vaše datum narození.</div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-2 pb-1">Pohlaví: </h6>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="femaleGender" value="F"
                                                   required <?php if (isset($_POST['inlineRadioOptions']) and $_POST['inlineRadioOptions'] == 'F') echo 'checked'; ?>/>
                                            <label class="form-check-label" for="femaleGender">Žena</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="maleGender"
                                                   value="M" <?php if (isset($_POST['inlineRadioOptions']) and $_POST['inlineRadioOptions'] == 'M') echo 'checked'; ?>/>
                                            <label class="form-check-label" for="maleGender">Muž</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="FtMGender"
                                                   value="FtM" <?php if (isset($_POST['inlineRadioOptions']) and $_POST['inlineRadioOptions'] == 'FtM') echo 'checked'; ?>/>
                                            <label class="form-check-label" for="FtMGender">Trans muž</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="MtFGender"
                                                   value="MtF" <?php if (isset($_POST['inlineRadioOptions']) and $_POST['inlineRadioOptions'] == 'MtF') echo 'checked'; ?>/>
                                            <label class="form-check-label" for="MtFGender">Trans žena</label>
                                            <div class="invalid-feedback">Vyberte vaše pohlaví.</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="emailAddress">Email</label>
                                    <input type="email" id="emailAddress" name="email" class="form-control"
                                           required <?php if (isset($_POST['email'])) echo 'value="' . $_POST['email'] . '"'; ?>/>
                                    <div class="invalid-feedback">Vyplňte váš email.</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <label class="form-label" for="psw">Heslo</label>
                                        <input type="password" id="psw" name="psw" class="form-control"
                                               required <?php if (isset($_POST['psw'])) echo 'value="' . $_POST['psw'] . '"'; ?>/>
                                        <div class="invalid-feedback">Vyplňte vaše heslo.</div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label select-label">Orientace</label> <br>
                                    <select class="select" name="sexuality" required>
                                        <option value="S" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === 'S') echo 'selected'; ?> >
                                            Heterosexuál
                                        </option>
                                        <option value="G" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === 'G') echo 'selected'; ?> >
                                            Homosexuál
                                        </option>
                                        <option value="L" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === 'L') echo 'selected'; ?> >
                                            Lesba
                                        </option>
                                        <option value="B" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === 'B') echo 'selected'; ?> >
                                            Bisexuál
                                        </option>
                                        <option value="A" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === 'A') echo 'selected'; ?> >
                                            Asexuál
                                        </option>
                                        <option value="P" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === 'P') echo 'selected'; ?> >
                                            Pansexuál
                                        </option>
                                        <option value="Q" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === 'Q') echo 'selected'; ?> >
                                            Queer
                                        </option>
                                        <option value="?" <?php if (isset($_POST['sexuality']) and $_POST['sexuality'] === '?') echo 'selected'; ?> >
                                            Nejistý
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-success btn-lg" type="submit">Registrovat</button>
                                <a href="./" class="btn btn-secondary btn-lg">Přihlásit</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // Bootstrap's validation script initialization
    (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
<script>
    function validateBirthday() {
        // Get the selected birthday date
        var birthdayDateInput = document.getElementById("birthdayDate");
        var birthdayDate = birthdayDateInput.value;

        // Calculate today's date
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        // Convert birthday date and today's date to Date objects
        var birthday = new Date(birthdayDate);
        var currentDate = new Date(yyyy, mm, dd);

        // Calculate age
        var age = yyyy - birthday.getFullYear();
        var monthDiff = mm - (birthday.getMonth() + 1);
        if (monthDiff < 0 || (monthDiff === 0 && dd < birthday.getDate())) {
            age--;
        }

        // Check if age is less than 18 or more than 100
        if (age < 18) {
            // Reset the input field
            birthdayDateInput.value = "";
            alert("Musí ti být alespoň 18 let.");
            return false;
        } else if (age > 100) {
            // Reset the input field
            birthdayDateInput.value = "";
            alert("Zadané datum narození je nepravděpodobné. Zadejte prosím správné datum narození.");
            return false;
        }

        return true;
    }

    // Add event listener to the form for validation
    document.getElementById("birthdayDate").addEventListener("change", validateBirthday);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
<script src="./scripts/night-theme.js"></script>
</body>

</html>