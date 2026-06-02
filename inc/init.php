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