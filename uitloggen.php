<?php
include 'inc/init.php';
session_destroy();
session_unset();
header('refresh: 0; url=login.php');
include ("inc/footer.php");
?>

