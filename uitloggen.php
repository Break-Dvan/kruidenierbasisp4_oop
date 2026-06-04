<?php
include 'inc/init.php';
session_destroy();
session_unset();
header('location: login.php');
include ("inc/footer.php");
?>

