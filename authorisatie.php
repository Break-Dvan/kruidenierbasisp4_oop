<?php
include 'inc/init.php';

if ($_POST['submit']) {
    $inlognaam=isset($_POST['inlognaam']) ? $_POST['inlognaam'] : '';
    $wachtwoord=isset($_POST['wachtwoord']) ? $_POST['wachtwoord'] : '';
}
else {
    header('location: index.php');
    exit();
}
//object Gebruiker
$oUser = new Gebruiker($dbconn);

//$resultaat bepalen....
$result = $oUser->getAuthorisation($inlognaam, $wachtwoord);

if ($result) { //$result = true or false.
    $_SESSION['inlognaam'] = $inlognaam;
    $_SESSION['ingelogd'] = true;
    header('location: kassa.php');
    exit;
} else {
    $_SESSION['error_inlog'] = 'Helaas, uw inlognaam en/of wachtwoord corresponderen niet met onze gegevens.<br>';
    header('location: login.php');
    exit;
}
include("inc/footer.php");
?>