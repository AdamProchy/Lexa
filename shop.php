<?php
session_start();
if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName'])) {
    header("location: ./");
    exit();
}
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$sexuality = $_SESSION['sexuality'];
$dateSent = false;
include "config.php";
include "functions.php";
?>
<!DOCTYPE html>
