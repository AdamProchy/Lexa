<?php
/*
 _____                                  
/ _  / __ ___   _____  _ __ __ _  /\/\  
\// / / _` \ \ / / _ \| '__/ _` |/    \ 
 / //\ (_| |\ V / (_) | | | (_| / /\/\ \
/____/\__,_| \_/ \___/|_|  \__,_\/    \/                                      
*/
session_start();
if (isset($_SESSION["email"])) {
    header("location: ./");
    exit();
}

include("config.php");
$isAdult = true;
$isEmailAvailable = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $lastName = $birthdayDate = $gender = $email = $psw = $sexuality = $isAdult = "";
    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);
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
        $sql = "INSERT INTO credentials (firstName, lastName, gender, sexuality, birthDate, email, psw)
                VALUES ('$firstName', '$lastName', '$gender', '$sexuality', '$birthdayDate', '$email', '$psw')";

        if (mysqli_query($conn, $sql)) {
            $sql = "select ID, aboutMe from credentials where email = '$email'";
            $result = mysqli_query($conn, $sql);
            $_SESSION["firstName"] = $firstName;
            $_SESSION["email"] = $email;
            $_SESSION["lastName"] = $lastName;
            $_SESSION["aboutMe"] = mysqli_fetch_array(mysqli_query($conn, $sql))["aboutMe"];
            $_SESSION["profilePicture"] = "./profilePictures/default.png";
            $_SESSION["sexuality"] = $sexuality;
            $_SESSION["dateSent"] = false;
            $_SESSION["ID"] = mysqli_fetch_array(mysqli_query($conn, $sql))["ID"];
            header("location: home.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <title>🖤 Moje Rande 🧡 - Registrace</title>
</head>

<body>
<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <?php if (!$isEmailAvailable) : ?>
        <div class="alert alert-danger text-center" role="alert">
            Registrace se nezdařila! Email je již použitý.
        </div>
    <?php endif; ?>


    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="mb-4 pb-2 pb-md-0 mb-md-5">Registrace</h1>
                            <form method="post">

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" id="firstName" name="firstName"
                                                   class="form-control form-control-lg" required/>
                                            <label class="form-label" for="firstName">Jméno</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" id="lastName" name="lastName"
                                                   class="form-control form-control-lg" required/>
                                            <label class="form-label" for="lastName">Přijmení</label>
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-4 d-flex align-items-center">
                                        <div class="form-outline datepicker w-100">
                                            <input type="date" class="form-control form-control-lg" name="birthdayDate"
                                                   id="birthdayDate" required/>
                                            <label for="birthdayDate" class="form-label">Datum narození</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <h6 class="mb-2 pb-1">Pohlaví: </h6>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="femaleGender" value="F" required/>
                                            <label class="form-check-label" for="femaleGender">Žena</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="maleGender" value="M"/>
                                            <label class="form-check-label" for="maleGender">Muž</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="FtMGender" value="FtM"/>
                                            <label class="form-check-label" for="FtMGender">Trans muž</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="MtFGender" value="MtF"/>
                                            <label class="form-check-label" for="MtFGender">Trans žena</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <input type="email" id="emailAddress" name="email"
                                                   class="form-control form-control-lg" required/>
                                            <label class="form-label" for="emailAddress">Email</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <input type="password" id="psw" name="psw"
                                                   class="form-control form-control-lg" required/>
                                            <label class="form-label" for="psw">Heslo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <select class="select form-control-lg" name="sexuality" required>
                                            <option value="S">Heterosexuál</option>
                                            <option value="G">Homosexuál</option>
                                            <option value="L">Lesba</option>
                                            <option value="B">Bisexuál</option>
                                            <option value="A">Asexuál</option>
                                            <option value="P">Pansexuál</option>
                                            <option value="Q">Queer</option>
                                            <option value="?">Nejistý</option>
                                        </select>
                                        <label class="form-label select-label">Orientace</label>
                                    </div>
                                </div>

                                <div class="mt-4 pt-2">
                                    <input class="btn btn-primary btn-lg" type="submit" value="Submit"/>
                                </div>
                                <br>
                                <a href="./">Přihlásit</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</form>
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
            alert("You must be at least 18 years old.");
            return false;
        } else if (age > 100) {
            // Reset the input field
            birthdayDateInput.value = "";
            alert("Please enter a valid birthday.");
            return false;
        }

        return true;
    }

    // Add event listener to the form for validation
    document.getElementById("birthdayDate").addEventListener("change", validateBirthday);
</script>
</body>

</html>