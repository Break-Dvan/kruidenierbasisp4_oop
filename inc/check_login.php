<?php
//bestandsnaam ophalen door de dirnaam te vervangen door '' in het totale path.
$file=str_replace(dirname($_SERVER['PHP_SELF']),'',$_SERVER['PHP_SELF'] );
$file=str_replace("/","", $file);
//controle of er is ingelogd
$ingelogd=isset($_SESSION['ingelogd']) ? $_SESSION['ingelogd'] : false ;

if (($file!='login.php') AND ($file!='authorisatie.php'))  {
    if (!$ingelogd) {
        session_destroy();
        session_unset();
        header("location: login.php");
        exit;
    }

}
?>