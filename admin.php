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
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin panel</title>
</head>
<body>
<?php if (isset($error)) : ?>
    <div class="alert alert-danger text-center" role="alert" id="alert">
        MySQL Error: <?= $error ?>
    </div>
<?php endif; ?>

<?php if (isset($success) and $success) : ?>
    <div class="alert alert-success text-center" role="alert" id="alert">
        Databáze byla úspěšně aktualizována!
    </div>
    <script>
        setTimeout(function () {
            document.getElementById('alert').style.display = 'none';
        }, 2000);
    </script>
<?php endif; ?>

<form method="post" onsubmit="return confirmDeleteDatabase();">
    <input type="hidden" name="form_name" value="delete_database">
    <button type="submit" class="btn btn-danger">Smazat databázi</button>
</form>
<form method="post" onsubmit="return confirmDeleteConnection();">
    <input type="hidden" name="form_name" value="delete_connection">
    <button type="submit" class="btn btn-danger">Smazat připojení</button>
</form>
<form method="post" onsubmit="return confirmUpdateDatabase();">
    <input type="hidden" name="form_name" value="update_database">
    <button type="submit" class="btn btn-info">Aktualizovat databázi</button>
</form>
<a href="<?php echo $_SESSION['referer']; ?>" class="btn btn-primary">Zpátky</a>
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
