<?php
include('utils.php');
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
$Id = $_SESSION["ID"];

$pageName = 'help.php';
include('./templates/head_and_navbar.php');
?>
<section id="project" class="p-5">
    <h2 class="text-center">Základní informace</h2>
    <br>
    <div class="container">
        <div class="row text-center">
            <div class="col-md">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <p class="card-text"><span class="fw-bold">Moje</span><span class="text-dark fw-bold rounded" style="background-color: #ff9900;">Rande</span>
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
                        <p class="card-text">Projekt vytvořil <span class="fw-bold">Adam</span> <span class="text-dark fw-bold rounded" style="background-color: #ff9900;">Procházka</span> a <span class="fw-bold">Matyáš</span> <span class="text-dark fw-bold rounded" style="background-color: #ff9900;">Závora</span>
                            ze třídy C4c jako technický projekt pro školu SPŠE Ječná.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="faq" class="p-5">
    <h2 class="text-center">Často kladené dotazy</h2>
    <div class="accordion accordion-flush" id="faqid">
        <div class="accordion-item text-dark" style="background-color: #ff9900;">
            <h2 class="accordion-header">
                <button class="accordion-button bg-secondary collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Jak si mám naplánovat rande?
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Klikněte v horní části stránky na "Chci rande!", vyberte si správného
                    člověka na rande a klikněte na "Požádat o rande". Vyplntě důlezité informace, které se zašlou s
                    pozvánkou na rande dané osobě. Nyní stačí pouze vyčkat, zda protějšek rande přijme nebo ne.
                </div>
            </div>
        </div>
        <div class="accordion-item text-dark" style="background-color: #ff9900;">
            <h2 class="accordion-header">
                <button class="accordion-button bg-secondary collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Kde si změním heslo, email, fotku nebo popisek?
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">V pravé horní části obrazovky stačí kliknout na své barevně označené jméno.
                    Zobrazí se vám stránka, na které můžete všechny tyto akce provést.
                </div>
            </div>
        </div>
        <div class="accordion-item text-dark" style="background-color: #ff9900;">
            <h2 class="accordion-header">
                <button class="accordion-button bg-secondary collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    Accordion Item #3
                </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
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
<div class="p-5">
    <div class="row">
        <div class="col-md-3">
            <h2 style="color: #ff9900;">Front-end</h2>
            <h4>Adam Procházka<br><a href="https://www.linkedin.com/in/adamprochazkacz" target="_blank"><i class="bi bi-linkedin"></i></a></h4>
            <h2 style="color: #ff9900;">Back-end</h2>
            <h4>Matyáš Závora <br><a href="https://www.linkedin.com/in/matyas-zavora/" target="_blank"><i class="bi bi-linkedin"></i></a></h4>
        </div>
        <div class="col-md-4 text-end">
            <h2 style="color: #ff9900;">Adresa</h2>
            <p>Ječná 30<br>120 00 Praha 2</p>
        </div>
        <div class="col-md-5 text-end d-none d-md-block">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3134.2952499145554!2d14.42307158100644!3d50.07530065922398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470b948c9f75eabd%3A0x388885305f00cbcf!2zU3TFmWVkbsOtIHByxa9teXNsb3bDoSDFoWtvbGEgZWxla3Ryb3RlY2huaWNrw6EsIFByYWhhIDIsIEplxI1uw6EgMzA!5e0!3m2!1scs!2scz!4v1710326050227!5m2!1scs!2scz" width="450" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
<?php
include('./templates/footer.php');
