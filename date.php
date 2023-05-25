<!-- 
    Lexa hledá ženu ❤️

Protože je Lexa žádaný a fešný chlapík, pravidelně chodí na randíčka. 
Bohužel se v nich ztrácí a má v tom obecně velký nepořádek. 
Potřebuje proto evidovat ženy, se kterými randí. 
Vytvořte webovou aplikaci a pomozte tak Lexovi najít znovu smysl a naději na lepší zítřky plné lásky.

Vaše aplikace bude obsahovat následující:

    jméno a příjmení ženy, věk ženy, popis ženy
    rande s danou ženou (popis toho, jak rande šlo, datum, kdy na rande byli, a kde).

Aplikace bude také umět:

    přidat novou ženu a přidat nové rande
    smazat záznam o ženě a smazat záznam o randíčku
    upravit záznam o ženě a upravit záznam o randíčku.

Lexa bude mít možnost si ženy seřadit v abecedním pořadí a zároveň i podle toho, 
kdy se s ženou naposledy viděl/psal si (nejstarší/nejnovější interakce). 
Samozřejmě Lexa nechce, aby měl k jeho aplikaci přístup někdo jiný, 
proto se k datům dostane pouze skrze své přihlašovací údaje.
-->

<?php
session_start();
if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName'])) {
    header("location: ./");
    exit();
}
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$sexuality = $_SESSION['sexuality'];

include "config.php";

$sql = "SELECT * FROM credentials";
$result = mysqli_query($conn, $sql);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/index.css">
    <title>🖤 Chci rande! 🧡</title>
</head>

<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../Lexa/index.php"><img src="../Lexa/img/logo.png" width="200px" height="50px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/home.php">Domu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/date.php">Chci rande!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/help.php">Podpora</a>
                    </li>
                </ul>
                <ul class="navbar-nav mt-2 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/settings.php">Nastavení</a>
                    </li>
                    <li class="nav-item">
                        <p class="navbar-text">Přihlášen:</p>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/profile.php"><?php echo $firstName . " " . $lastName ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/logout.php">Odhlásit se</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="dates" class="p-5">
        <div class="container">
            <h2 class="text-center text-dark">Nabídka:</h2>
            <br>
            <div class="row g-4">
                <?php for ($i = 0; $i < sizeof($users); $i++) {
                    $firstNameDB = $users[$i]['firstName'];
                    $lastNameDB = $users[$i]['lastName'];
                    $aboutMeDB = $users[$i]['aboutMe'];
                    $sexualityDB = $users[$i]['sexuality'];
                    $birthDateDB = $users[$i]['birthDate'];
                    $now = date("Y-m-d");
                    $diff = date_diff(date_create($birthDateDB), date_create($now));
                    $profilePictureDB = "./profilePictures/" . $users[$i]['profilePicture'];
                    echo '<div class="col-md-6 col-lg-3">';
                    echo '<div class="card bg-dark text-white">';
                    echo '<div class="card-body text-center">';
                    echo '<div id="card-top">';
                    echo '<img src="' . $profilePictureDB . '" class="rounded-circle" id="image" alt="">';
                    echo '<h3 class="card-title"><span style="font-weight: 600;">' . $firstNameDB . '</span> <br> <span style="font-size: large;"> ' . $lastNameDB . '</span></h3>';
                    echo '</div>';
                    echo '<br>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">Věk: </h6>';
                    echo '<p class="card-text">' . $diff->format('%y') . '</p>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">O mně: </h6>';
                    echo '<p class="card-text">' . $aboutMeDB . '</p>';
                    echo '<a href="#" class="btn btn-primary mr-2 mt-3">Požádat o rande</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                } ?>
            </div>
        </div>
    </section>



    <!--FOOTER-->
    <footer class="p-5 bg-dark text-white text-center position-relative">
        <div class="container">
            <p class="lead">Copyright &copy; PROCHY</p>
            <a href="#" class="position-absolute bottom-0 end-0 p-5"><i class="bi-arrow-up-circle h1"></i></a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>