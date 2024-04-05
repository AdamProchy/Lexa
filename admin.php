<?php
include('utils.php');

$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];

if ($_SESSION['ID'] != 1) {
    header('Location: ./');
    exit();
}

if (isset($_POST['form_name'])) {
    switch ($_POST['form_name']) {
        case 'delete_database':
            $conn = mysqli_connect($_SESSION["conn_params"]['host'], $_SESSION["conn_params"]['user'], $_SESSION["conn_params"]['password'], '', $_SESSION["conn_params"]['port']);
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
    <title>Admin</title>

</head>
<body>
<!-- Button to delete database -->
<form method="post">
    <input type="hidden" name="form_name" value="delete_database">
    <button type="submit" class="btn btn-danger">Delete database</button>
</form>
<!-- Button to delete database connection -->
<form method="post">
    <input type="hidden" name="form_name" value="delete_connection">
    <button type="submit" class="btn btn-danger">Delete connection</button>
</form>
<a href="<?php echo $_SESSION['referer']; ?>" class="btn btn-primary">Return</a></body>
</html>
