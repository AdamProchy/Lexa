<?php
session_start();
$conn_params = $_SESSION['conn_params'];
session_destroy();
session_start();
$_SESSION['conn_params'] = $conn_params;
header("Location: ./");
exit;
