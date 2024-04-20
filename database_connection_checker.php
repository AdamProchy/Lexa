<?php
//Check if __DIR__/connection_params.txt exist
if (file_exists(__DIR__ . "/connection_params.txt")) {
    // Get data from it
    $file = fopen(__DIR__ . "/connection_params.txt", "r");
    $conn_params = json_decode(fread($file, filesize(__DIR__ . "/connection_params.txt")), true);
    fclose($file);

    // Try to connect to the database
    try {
        $conn = mysqli_connect($conn_params['host'], $conn_params['user'], $conn_params['password'], 'mojerandedb', $conn_params['port']);
        if (!$conn) {
            header('Location: ./connection.php');
        } else {
            $_SESSION['conn_params'] = $conn_params;
        }
    } catch (Exception $e) {
        // If connection fails, delete the file and saved connection parameters and redirect to connection.php
        unlink(__DIR__ . "/connection_params.txt");
        if (isset($_SESSION['conn_params'])) unset($_SESSION['conn_params']);
        header('Location: ./connection.php');
    }
} else {
    unset($_SESSION['conn_params']);
    header('Location: ./connection.php');
}