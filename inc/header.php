<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// include database.php
if (basename($_SERVER['PHP_SELF'])!='login.php') {
    require_once 'conn/database.php';
    include 'inc/functions.php';
}

include_once 'class/Gebruiker.php';
include_once 'class/Product.php';
include_once 'class/Logging.php';
include 'inc/check_login.php';
include_once 'inc/config.php';


?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Vaatje Buskruit</title>
        <!-- hier komen de css-bestanden -->
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="shortcut  icon" type="image/jpg" href="img/favicon-32x32.png">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
    <!-- voor de opmaak straks zetten we alles in een container… -->
    <div class="container">
<?php
// include menu
include('inc/menu.php');
