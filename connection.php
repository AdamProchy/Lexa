<?php
include_once('functions.php');
session_start();
//test if connection_params.txt exists
if (file_exists('connection_params.txt')) {
    $file = fopen("connection_params.txt", "r");
    $conn_params = json_decode(fread($file, filesize("connection_params.txt")), true);
    fclose($file);
    try {
        $conn = mysqli_connect($conn_params['host'], $conn_params['user'], $conn_params['password'], 'mojerandedb', $conn_params['port']);
        if ($conn) {
            createDatabase($conn);
            header('Location: ./');
            exit();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
if (isset($_SESSION['conn_params'])){
    $conn = mysqli_connect($_SESSION['conn_params']['host'], $_SESSION['conn_params']['user'], $_SESSION['conn_params']['password'], 'mojerandedb', $_SESSION['conn_params']['port']);
    if ($conn) {
        header('Location: ./');
        exit();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['form_name'] == 'connection_form') {
    $conn_params = [
        'host' => $_POST['host'],
        'user' => $_POST['user'],
        'password' => $_POST['password'],
        'port' => $_POST['port'],
    ];
    try {
        $conn = mysqli_connect($conn_params['host'], $conn_params['user'], $conn_params['password'], '', $conn_params['port']);
        $_SESSION['conn_params'] = $conn_params;
        $file = fopen("connection_params.txt", "w");
        fwrite($file, json_encode($conn_params));
        fclose($file);
        if (isset($_SESSION['delete_conn_params']) && $_SESSION['delete_conn_params']) {
            unset($_SESSION['delete_conn_params']);
        } else {
            createDatabase($conn);
        }
        $success = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Database Connection</h1>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger text-center" role="alert">
                        MySQL Error: <?= $error ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($success) && $success) : ?>
                    <div class="alert alert-success text-center" role="alert">
                        Database created successfully! Redirecting...
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = "./";
                        }, 2000);
                    </script>
                <?php endif; ?>

                <form method="post">
                    <input type="hidden" name="form_name" value="connection_form">
                    <div class="mb-3">
                        <label for="host" class="form-label">Host:</label>
                        <input type="text" name="host" id="host" class="form-control" required value="localhost">
                    </div>
                    <div class="mb-3">
                        <label for="user" class="form-label">User:</label>
                        <input type="text" name="user" id="user" class="form-control" required value="root">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="port" class="form-label">Port:</label>
                        <input type="number" name="port" id="port" class="form-control" required value="3306">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Connect</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>