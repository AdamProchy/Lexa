<?php
include('utils.php');
if (strpos($_SERVER['HTTP_REFERER'], 'admin.php') === false) {
    $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
}
if ($_SESSION['ID'] != 1) {
    header('Location: ./');
    exit();
}

if (isset($_POST['form_name'])) {
    $conn = mysqli_connect($_SESSION["conn_params"]['host'], $_SESSION["conn_params"]['user'], $_SESSION["conn_params"]['password'], '', $_SESSION["conn_params"]['port']);
    switch ($_POST['form_name']) {
        case 'delete_database':
            mysqli_query($conn, "DROP DATABASE IF EXISTS mojerandedb");
            mysqli_close($conn);
            unset($_SESSION['conn_params']);
            header('Location: ./');
            exit();
        case 'delete_connection':
            unset($_SESSION['conn_params']);
            unlink('connection_params.txt');
            $_SESSION['delete_conn_params'] = true;
            header('Location: ./');
            exit();
        case 'update_database':
            try {
                createDatabase($conn);
                $success = true;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        default:
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger text-center" role="alert">
        MySQL Error: <?= $error ?>
    </div>
<?php endif; ?>

<?php if (isset($success) and $success) : ?>
    <div class="alert alert-success text-center" role="alert">
        Databáze byla úspěšně aktualizována!
    </div>
    <script>
        setTimeout(function () {
            document.getElementById('successAlert').style.display = 'none';
        }, 2000);
    </script>
<?php endif; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" onsubmit="return confirmDeleteDatabase();">
                <input type="hidden" name="form_name" value="delete_database">
                <button type="submit" class="btn btn-danger w-100 mb-3">Smazat databázi</button>
            </form>
            <form method="post" onsubmit="return confirmDeleteConnection();">
                <input type="hidden" name="form_name" value="delete_connection">
                <button type="submit" class="btn btn-danger w-100 mb-3">Smazat připojení</button>
            </form>
            <form method="post" onsubmit="return confirmUpdateDatabase();">
                <input type="hidden" name="form_name" value="update_database">
                <button type="submit" class="btn btn-info w-100">Aktualizovat databázi</button>
            </form>
            <a href="<?php echo isset($_SESSION['referer']) ? $_SESSION['referer'] : './'; ?>" class="btn btn-primary w-100 mt-3">Zpátky</a>
        </div>
    </div>
</div>

<script>
    function confirmDeleteDatabase() {
        return confirm("Jste si jistí, že chcete smazat databázi?");
    }

    function confirmDeleteConnection() {
        return confirm("Jste si jistí, že chcete vymazat připojení k databázi?");
    }

    function confirmUpdateDatabase() {
        return confirm("Jste si jistí, že chcete aktualizovat databázi?");
    }
</script>

</body>
</html>
