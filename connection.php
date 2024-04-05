<?php

session_start();
//show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if (isset($_SESSION['conn_params'])) : header('Location: ./'); endif;
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
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger text-center" role="alert">
        MySQL Error: <?= $error ?>
    </div>
<?php endif; ?>

<?php if (isset($success) and $success) : ?>
    <div class="alert alert-success text-center" role="alert">
        Database created successfully! Redirecting...
    </div>
    <script>
        setTimeout(function () {
            window.location.href = "./";
        }, 2000);
    </script>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="form_name" value="connection_form">
    <label for="host">Host:</label>
    <input type="text" name="host" id="host" required value="localhost">
    <label for="user">User:</label>
    <input type="text" name="user" id="user" required value="root">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <label for="port">Port:</label>
    <input type="number" name="port" id="port" required value="3306">
    <button type="submit">Connect</button>
</body>
</html>
