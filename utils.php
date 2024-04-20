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
    header("Location: ./");
    exit();
}