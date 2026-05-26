<?php
include("inc/header.php");

if ($_POST['submit']) {
    $inlognaam=isset($_POST['inlognaam']) ? $_POST['inlognaam'] : '';
    $wachtwoord=isset($_POST['wachtwoord']) ? $_POST['wachtwoord'] : '';
}
else {
    header('refresh: 1, index.php');
    exit();
}
//object Gebruiker
$oUser = new Gebruiker($dbconn);

//$resultaat bepalen....
$result = $oUser->getAuthorisation($inlognaam, $wachtwoord);

if ($result) { //$result = true or false..
    $rol = $oUser->rol;
    $_SESSION['inlognaam'] = $inlognaam;
    $_SESSION['wachtwoord'] = $wachtwoord;
    $_SESSION['rol'] = $rol;
    $_SESSION['ingelogd'] = true;
    header('refresh: 1; url=kassa.php');
    exit;
} else {
    echo 'Helaas, uw inlognaam en/of wachtwoord corresponderen niet met onze gegevens. U wordt
            doorgestuurd...<br>';
    session_destroy();
    session_unset();
    header('refresh: 5; url=login.php');
    exit;
}
include("inc/footer.php");
?>