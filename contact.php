<?php
// include header.php
include 'inc/header.php';
// header tags toevoegen
echo '<header class="head">';
echo "Contactgegevens {$arContactgegevens['kruidenier']}...<br>";
echo '</header>'; //afsluiten header
// voor gridopmaak alvast de main-content
echo '<main class="main-content" id="contact">';


echo '<h1>'.$arContactgegevens['kruidenier'].'</h1>';
echo $arContactgegevens['contactpersoon'].'<br>';
echo $arContactgegevens['adres'].'<br>';
echo $arContactgegevens['postcode'].' '.$arContactgegevens['plaats'].'<br>';
echo 'Meer info: <a href="mailto:'.$arContactgegevens['mailadres'].'">V.B. Kruidvat</a><br>';
echo '</main>'; //main afsluiten
// include footer
include("inc/footer.php");
?>