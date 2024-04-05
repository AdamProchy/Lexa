<?php
include('utils.php');
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/help.css">
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <title>🖤 Podpora 🧡</title>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php"><img src="./img/logo.png" width="200px" height="50px"></a>
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
                    <a class="nav-link active" style="color: #ff9900;" href="./help.php">Podpora</a>
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
                    <a class="nav-link" style="color: #ff9900;"
                       href="./settings.php"><?php echo $firstName . " " . $lastName ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: red;" href="./logout.php">Odhlásit se</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<section id="project" class="p-5 text-white bg-dark">
    <h2 class="text-center">Základní informace</h2>
    <br>
    <div class="container">
        <div class="row text-center">
            <div class="col-md">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <p class="card-text"><span class="fw-bold">Moje</span><span class="text-dark fw-bold rounded"
                                                                                    style="background-color: #ff9900;">Rande</span>
                            je webová stránka, která slouží pro seznámení s lidmi, kteří se taktéž registrovali na tuto
                            seznamku.</p>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <p class="card-text">Schůzky si můžete naplánovat s kýmkoliv, kdykoliv, kdekoliv a
                            odkudkoliv!</p>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <p class="card-text">Projekt vytvořil <span class="fw-bold">Adam</span> <span
                                    class="text-dark fw-bold rounded"
                                    style="background-color: #ff9900;">Procházka</span> a <span
                                    class="fw-bold">Matyáš</span> <span class="text-dark fw-bold rounded"
                                                                        style="background-color: #ff9900;">Závora</span>
                            ze třídy C4c jako technický projekt pro školu SPŠE Ječná.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="faq" class="p-5 text-white bg-dark">
    <h2 class="text-center">Často kladené dotazy</h2>
    <div class="accordion accordion-flush" id="faqid">
        <div class="accordion-item text-dark" style="background-color: #ff9900;">
            <h2 class="accordion-header">
                <button class="accordion-button bg-secondary collapsed text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                        aria-controls="flush-collapseOne">
                    Jak si mám naplánovat rande?
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                 data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Klikněte v horní části stránky na "Chci rande!", vyberte si správného
                    člověka na rande a klikněte na "Požádat o rande". Vyplntě důlezité informace, které se zašlou s
                    pozvánkou na rande dané osobě. Nyní stačí pouze vyčkat, zda protějšek rande přijme nebo ne.
                </div>
            </div>
        </div>
        <div class="accordion-item text-dark" style="background-color: #ff9900;">
            <h2 class="accordion-header">
                <button class="accordion-button bg-secondary collapsed text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false"
                        aria-controls="flush-collapseTwo">
                    Kde si změním heslo, email, fotku nebo popisek?
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                 data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">V pravé horní části obrazovky stačí kliknout na své barevně označené jméno.
                    Zobrazí se vám stránka, na které můžete všechny tyto akce provést.
                </div>
            </div>
        </div>
        <div class="accordion-item text-dark" style="background-color: #ff9900;">
            <h2 class="accordion-header">
                <button class="accordion-button bg-secondary collapsed text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false"
                        aria-controls="flush-collapseThree">
                    Accordion Item #3
                </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
                 data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the
                    .accordion-flush class. This is the third item's accordion body. Nothing more exciting happening
                    here in
                    terms of content, but just filling up the space to make it look, at least at first glance, a bit
                    more
                    representative of how this would look in a real-world application.
                </div>
            </div>
        </div>
    </div>
</section>
<div class="p-5 text-white bg-dark">
    <div class="row">
        <div class="col-md-3">
            <h2 style="color: #ff9900;">Front-end</h2>
            <h4>Adam Procházka<br><a href="https://www.linkedin.com/in/adamprochazkacz" target="_blank"><i
                            class="bi bi-linkedin"></i></a></h4>
            <h2 style="color: #ff9900;">Back-end</h2>
            <h4>Matyáš Závora <br><a href="https://www.linkedin.com/in/matyas-zavora/" target="_blank"><i
                            class="bi bi-linkedin"></i></a></h4>
        </div>
        <div class="col-md-3 text-end">
            <h2 style="color: #ff9900;">Adresa</h2>
            <p>Ječná 30<br>120 00 Praha 2</p>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3134.2952499145554!2d14.42307158100644!3d50.07530065922398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470b948c9f75eabd%3A0x388885305f00cbcf!2zU3TFmWVkbsOtIHByxa9teXNsb3bDoSDFoWtvbGEgZWxla3Ryb3RlY2huaWNrw6EsIFByYWhhIDIsIEplxI1uw6EgMzA!5e0!3m2!1scs!2scz!4v1710326050227!5m2!1scs!2scz"
                    width="450" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
<footer class="p-1 bg-dark text-white text-center position-relative mt-auto">
    <div class="container">
        <p class="lead">Copyright &copy; PROCHY | SPŠE Ječná</p>
        <a href="#" class="position-absolute bottom-0 end-0 p-5"><i class="bi-arrow-up-circle h1"
                                                                    style="color: #ff9900;"></i></a>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>
</html>