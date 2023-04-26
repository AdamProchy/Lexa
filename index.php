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
    //
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <title>🖤 Moje Rande 🧡</title>
</head>

<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Moje rande</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="../Lexa/index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/date.html">Chci rande!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Lexa/faq.html">FAQ</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Přihlášen: Adam Prochazka
                </span>
            </div>
        </div>
    </nav>

    <!--DATES IN MAIN-->
    <section id="dates" class="p-5">
        <div class="container">
            <h2 class="text-center text-dark">Domluvené schůzky:</h2>
            <br>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div id="card-top">
                                <img src="https://randomuser.me/api/portraits/women/69.jpg" class="rounded-circle"
                                    id="image" alt="">
                                <h3 class="card-title"><span style="font-weight: 600;">Karolína </span><span
                                        style="font-size: large;"> Noribmergovád</span></h3>
                            </div>
                            <br>
                            <h6 class="card-subtitle mb-2 text-muted">Místo: Praha</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Čas: 14:00</h6>
                            <p class="rating">⭐⭐⭐⭐⭐</p>
                            <a href="#" class="btn btn-primary mr-2 mt-3">Upravit</a>
                            <a href="#" class="btn btn-danger mt-3">Zrušit</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div id="card-top">
                                <img src="https://randomuser.me/api/portraits/women/69.jpg" class="rounded-circle"
                                    id="image" alt="">
                                <h3 class="card-title"><span style="font-weight: 600;">Karolína </span><span
                                        style="font-size: large;"> Noribmergovád</span></h3>
                            </div>
                            <br>
                            <h6 class="card-subtitle mb-2 text-muted">Místo: Praha</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Čas: 14:00</h6>
                            <p class="rating">⭐⭐⭐⭐⭐</p>
                            <a href="#" class="btn btn-primary mr-2 mt-3">Upravit</a>
                            <a href="#" class="btn btn-danger mt-3">Zrušit</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div id="card-top">
                                <img src="https://randomuser.me/api/portraits/women/69.jpg" class="rounded-circle"
                                    id="image" alt="">
                                <h3 class="card-title"><span style="font-weight: 600;">Karolína </span><span
                                        style="font-size: large;"> Noribmergovád</span></h3>
                            </div>
                            <br>
                            <h6 class="card-subtitle mb-2 text-muted">Místo: Praha</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Čas: 14:00</h6>
                            <p class="rating">⭐⭐⭐⭐⭐</p>
                            <a href="#" class="btn btn-primary mr-2 mt-3">Upravit</a>
                            <a href="#" class="btn btn-danger mt-3">Zrušit</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div id="card-top">
                                <img src="https://randomuser.me/api/portraits/women/69.jpg" class="rounded-circle"
                                    id="image" alt="">
                                <h3 class="card-title"><span style="font-weight: 600;">Karolína </span><span
                                        style="font-size: large;"> Noribmergovád</span></h3>
                            </div>
                            <br>
                            <h6 class="card-subtitle mb-2 text-muted">Místo: Praha</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Čas: 14:00</h6>
                            <p class="rating">⭐⭐⭐⭐⭐</p>
                            <a href="#" class="btn btn-primary mr-2 mt-3">Upravit</a>
                            <a href="#" class="btn btn-danger mt-3">Zrušit</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div id="card-top">
                                <img src="https://randomuser.me/api/portraits/women/69.jpg" class="rounded-circle"
                                    id="image" alt="">
                                <h3 class="card-title"><span style="font-weight: 600;">Karolína </span><span
                                        style="font-size: large;"> Noribmergovád</span></h3>
                            </div>
                            <br>
                            <h6 class="card-subtitle mb-2 text-muted">Místo: Praha</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Čas: 14:00</h6>
                            <p class="rating">⭐⭐⭐⭐⭐</p>
                            <a href="#" class="btn btn-primary mr-2 mt-3">Upravit</a>
                            <a href="#" class="btn btn-danger mt-3">Zrušit</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div id="card-top">
                                <img src="https://randomuser.me/api/portraits/women/69.jpg" class="rounded-circle"
                                    id="image" alt="">
                                <h3 class="card-title"><span style="font-weight: 600;">Karolína </span><span
                                        style="font-size: large;"> Noribmergovád</span></h3>
                            </div>
                            <br>
                            <h6 class="card-subtitle mb-2 text-muted">Místo: Praha</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Čas: 14:00</h6>
                            <p class="rating">⭐⭐⭐⭐⭐</p>
                            <a href="#" class="btn btn-primary mr-2 mt-3">Upravit</a>
                            <a href="#" class="btn btn-danger mt-3">Zrušit</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div id="card-top">
                                <img src="https://randomuser.me/api/portraits/women/69.jpg" class="rounded-circle"
                                    id="image" alt="">
                                <h3 class="card-title"><span style="font-weight: 600;">Karolína </span><span
                                        style="font-size: large;"> Noribmergovád</span></h3>
                            </div>
                            <br>
                            <h6 class="card-subtitle mb-2 text-muted">Místo: Praha</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Čas: 14:00</h6>
                            <p class="rating">⭐⭐⭐⭐⭐</p>
                            <a href="#" class="btn btn-primary mr-2 mt-3">Upravit</a>
                            <a href="#" class="btn btn-danger mt-3">Zrušit</a>
                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>