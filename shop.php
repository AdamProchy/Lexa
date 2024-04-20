<?php
include_once('utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$sexuality = $_SESSION['sexuality'];
$Id = $_SESSION['ID'];
$dateSent = false;

$pageName = 'shop.php';
include('./templates/head_and_navbar.php');
?>
<!--responsive cards with different ammount of coins to buy-->
<section id="shop" class="p-5">
    <div class="container-fluid mb-0 pb-0">
        <h2 class="text-center">Obchod</h2>
        <br>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-4">
            <div class="col">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <div class="container">
                            <p class="lead">Prachy</p>
                        </div>
                        <p class="card-text">100 peněz</p>
                        <p class="card-text">Cena: 100 Kč</p>
                        <form action="shop.php" method="post">
                            <input type="hidden" name="coins" value="100">
                            <button type="submit" class="btn btn-primary">Koupit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <div class="container">
                            <p class="lead">Prachy</p>
                        </div>
                        <p class="card-text">100 peněz</p>
                        <p class="card-text">Cena: 100 Kč</p>
                        <form action="shop.php" method="post">
                            <input type="hidden" name="coins" value="100">
                            <button type="submit" class="btn btn-primary">Koupit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <div class="container">
                            <p class="lead">Prachy</p>
                        </div>
                        <p class="card-text">100 peněz</p>
                        <p class="card-text">Cena: 100 Kč</p>
                        <form action="shop.php" method="post">
                            <input type="hidden" name="coins" value="100">
                            <button type="submit" class="btn btn-primary">Koupit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <div class="container">
                            <p class="lead">Prachy</p>
                        </div>
                        <p class="card-text">100 peněz</p>
                        <p class="card-text">Cena: 100 Kč</p>
                        <form action="shop.php" method="post">
                            <input type="hidden" name="coins" value="100">
                            <button type="submit" class="btn btn-primary">Koupit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <div class="container">
                            <p class="lead">Prachy</p>
                        </div>
                        <p class="card-text">100 peněz</p>
                        <p class="card-text">Cena: 100 Kč</p>
                        <form action="shop.php" method="post">
                            <input type="hidden" name="coins" value="100">
                            <button type="submit" class="btn btn-primary">Koupit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-secondary text-light p-2">
                    <div class="class-body text-center">
                        <div class="container">
                            <p class="lead">Prachy</p>
                        </div>
                        <p class="card-text">100 peněz</p>
                        <p class="card-text">Cena: 100 Kč</p>
                        <form action="shop.php" method="post">
                            <input type="hidden" name="coins" value="100">
                            <button type="submit" class="btn btn-primary">Koupit</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
<?php
include('./templates/footer.php');
