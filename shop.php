<?php
ini_set('display_errors', 1);
include_once('utils.php');
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$Id = $_SESSION['ID'];

if (!isset($_SESSION['variableSymbol']) or empty($_SESSION['variableSymbol'])) {
    $variableSymbol = rand(1000000000, 9999999999);
    $_SESSION['variableSymbol'] = $variableSymbol;
} else {
    $variableSymbol = $_SESSION['variableSymbol'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['buy-coins'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO `money_requests` (`applicantId`, `amount`, `variableSymbol`) VALUES (?, ?, ?)");
            $stmt->bind_param('iii', $Id , $_POST['coins-czk'], $_SESSION['variableSymbol']);
            $stmt->execute();
            $stmt->close();
            $success = "Žádost o peníze byla úspěšně odeslána.";
            unset($_SESSION['variableSymbol']);
        } catch (Exception $e) {
            $error = "Něco se pokazilo. Zkuste to prosím znovu." . $e->getMessage();
        }
    }
}

//Check if user has already a pending request
$stmt = $conn->prepare("SELECT * FROM `money_requests` WHERE `applicantId` = ? AND `accepted` IS NULL;");
$stmt->bind_param('i', $Id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $pendingRequest = true;
    $pendingVariableSymbol = $result->fetch_assoc()['variableSymbol'];
    $pendingAmount = $result->fetch_assoc()['amount'];
    $error = "Máte již odeslanou žádost o peníze. Počkejte prosím na schválení.";
}
$stmt->close();


$pageName = 'shop.php';
include('./templates/head_and_navbar.php');
?>
<section id="shop" class="p-5">
    <div class="container-fluid mb-0 pb-0">
        <h2 class="text-center">Obchod</h2>
        <br>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-4">
            <div class="container">
                <!-- TODO: Přidat text, který vysvětluje, že uživatel musí nejdříve poslat peníze a pak bez refreshnutí-->
                <form method="post">
                    <div class="mb-3">
                        <div class="row">
                            <!-- TODO: Nastavit tak, aby se text zobrazoval uprostřed nad inputy-->
                            <label for="czk" class="form-label col">CZK</label>
                            <label for="coins-czk" class="form-label col">Peníze</label>
                        </div>
                        <div class="input-group">
                            <?php if(isset($pendingAmount)) $pendingAmountCZK = $pendingAmount*10; ?>
                            <input type="number" class="form-control" id="czk" name="czk" min="0" step="10" required <?php if (isset($pendingRequest) and $pendingRequest) echo "readonly value='$pendingAmountCZK'" ?>>
                            <span class="input-group-text">=</span>
                            <input type="number" class="form-control" id="coins-czk" name="coins-czk" min="0" step="1" required <?php if (isset($pendingRequest) and $pendingRequest) echo "readonly value='$pendingAmount'" ?>>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="qr-code" class="form-label">QR Kód</label>
                        <p class="form-control-static"><img id="qr-code" src="https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=2978644003&bankCode=0800&amount=0&currency=CZK&vs=<?= $variableSymbol ?>"></p>
                    </div>
                    <div class="mb-3">
                        <label for="bank-account" class="form-label">Číslo účtu</label>
                        <p class="form-control-static">2978644003/0800</p>
                    </div>
                    <div class="mb-3">
                        <label for="variable-symbol" class="form-label">Variabilní symbol</label>
                        <p class="form-control-static"><?= $variableSymbol ?></p>
                    </div>

                    <button type="submit" name="buy-coins" class="btn btn-success" <?php if (isset($pendingRequest) and $pendingRequest) echo "disabled" ?>>Poslat žádost o přidání coinů</button>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    document.getElementById('czk').addEventListener('change', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters

        var czk = Math.round(this.value / 10) * 10; // Round to the nearest 10
        this.value = czk; // Update the input field value
        var coins = czk / 10;
        document.getElementById('coins-czk').value = coins;

        var variableSymbol = <?= json_encode($variableSymbol) ?>; // Get the variable symbol from PHP
        var qrCode = document.getElementById('qr-code');

        // Update the QR code URL
        qrCode.src = 'https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=2978644003&bankCode=0800&amount=' + czk + '&currency=CZK&vs=' + variableSymbol;
    });

    document.getElementById('coins-czk').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters

        var coins = Math.floor(this.value); // Round down to the nearest whole number
        this.value = coins; // Update the input field value
        var czk = coins * 10;
        document.getElementById('czk').value = czk;

        var variableSymbol = <?= json_encode($variableSymbol) ?>; // Get the variable symbol from PHP
        var qrCode = document.getElementById('qr-code');

        // Update the QR code URL
        qrCode.src = 'https://api.paylibo.com/paylibo/generator/czech/image?accountNumber=2978644003&bankCode=0800&amount=' + czk + '&currency=CZK&vs=' + variableSymbol;
    });
</script>
<?php
include('./templates/footer.php');
