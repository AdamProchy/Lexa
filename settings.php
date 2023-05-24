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
include("config.php");
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Lexa/index.php");
    exit();
}

$email = $_SESSION["email"];
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
$aboutMe = $_SESSION["aboutMe"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (count ($_FILES) == 1 && $_FILES['profilePicture']['name'] != "") {
        $filename = uniqid();
        $extension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
        $basename = $filename . "." . $extension;
        $oldPfp = mysqli_query($conn, "SELECT profilePicture FROM credentials WHERE email = '$email'");
        $oldPfp = mysqli_fetch_array($oldPfp)["profilePicture"];
        $sqlDeletePfp = "SELECT * FROM credentials WHERE profilePicture = '$oldPfp'";
        $sql = "UPDATE credentials SET profilePicture = '$basename' WHERE email = '$email'";
        mysqli_query($conn, $sql);
        move_uploaded_file($_FILES['profilePicture']['tmp_name'], "./profilePictures/$basename");
        unlink("./profilePictures/$oldPfp");
        $_SESSION["profilePicture"] = "./profilePictures/$basename";
    }
}


$profilePicture = $_SESSION["profilePicture"];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/settings.css">
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
    <!--NAVBAR END-->
    <div class="container mt-5 mb-5">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
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
                                <p><?php echo $aboutMe; ?></p>
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
                                    <h6 class="mb-3 text-light">Změnit osobní informace</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="eMail">Email</label>
                                        <input type="email" class="form-control" id="eMail" placeholder="Vložte nový email">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="text">O mně</label>
                                        <input type="text" class="form-control" id="about_me" placeholder="Napište něco o sobě">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="phone">Telefon</label>
                                        <input type="text" class="form-control" id="phone" placeholder="Vložte nové telefonní číslo">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-3 text-light">Další</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="Street">random</label>
                                        <input type="name" class="form-control" id="Street" placeholder="Enter Street">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ciTy">random</label>
                                        <input type="name" class="form-control" id="ciTy" placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="sTate">random</label>
                                        <input type="text" class="form-control" id="sTate" placeholder="Enter State">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="zIp">random</label>
                                        <input type="text" class="form-control" id="zIp" placeholder="Zip Code">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="file" name="profilePicture" />
                                </div>

                            </div>
                            <br>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <button class="btn btn-primary" type="submit" name="submit">Potvrdit</button>
                                    <a type="button" class="btn btn-danger">Smazat účet</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

<?php
mysqli_close($conn);
?>