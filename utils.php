<?php
/*
 _____
/ _  / __ ___   _____  _ __ __ _  /\/\
\// / / _` \ \ / / _ \| '__/ _` |/    \
 / //\ (_| |\ V / (_) | | | (_| / /\/\ \
/____/\__,_| \_/ \___/|_|  \__,_\/    \/
*/
session_start();
include_once("functions.php");
include_once("database_connection_checker.php");
if (!isset($_SESSION["email"])) {
    // If user is not logged in, reroute to login form on index.php
    header("Location: ./");
    exit();
}