<?php
/*
 _____
/ _  / __ ___   _____  _ __ __ _  /\/\
\// / / _` \ \ / / _ \| '__/ _` |/    \
 / //\ (_| |\ V / (_) | | | (_| / /\/\ \
/____/\__,_| \_/ \___/|_|  \__,_\/    \/
*/
session_start();
include("functions.php");
if (!isset($_SESSION["conn_params"])) {
    // If database connection doesn't exist, reroute to connection form on connection.php
    header("Location: ./connection.php");
    exit();
} else {
    //Create database connection based on conn_params
    $conn = mysqli_connect($_SESSION["conn_params"]['host'], $_SESSION["conn_params"]['user'], $_SESSION["conn_params"]['password'], '', $_SESSION["conn_params"]['port']);
    mysqli_query($conn, "USE mojerandedb");
}
if (!isset($_SESSION["email"])) {
    // If user is not logged in, reroute to login form on index.php
    header("Location: ./");
    exit();
}