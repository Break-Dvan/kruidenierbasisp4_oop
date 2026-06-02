<?php
// controle ingelogd
include ('inc/check_login.php');
// ophalen rol gebruiker
$autRol=isset($_SESSION['rol']) ? strtolower($_SESSION['rol']) : '';
$inlognaam=isset($_SESSION['inlognaam']) ? $_SESSION['inlognaam'] : '';
// samenstellen menu
$menu='';
// op basis van rol menu tonen
    $menu = '<nav>
                   <ul>
                        <li><a class="navbar-brand" href="kassa.php"><img src="img/logo_buskruit.png" class="img-responsive" alt="home..."/></a></li><!-- Logo -->
                        <li><a href="voorraad.php">Voorraad</a></li>
                        <li><a href="voorraad_import.php">Importeren</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="uitloggen.php">Uitloggen</a></li>
                   </ul>
                </nav>';
if ($ingelogd) {
    echo $menu;
}

?>

