<?php
include 'inc/init.php';
//controle of id is meegegeven
if (isset($_GET["id"])) {
    $productId=$_GET["id"];
}
else {
    $_SESSION['error_voorraad'] = "Product is niet gevonden...";
    header('location: voorraad.php');
    exit;
}
//ophalen en controleren gegeven voordat er output wordt gestuurd...
$oProduct = new Product($dbconn);
$result = $oProduct->getProductDetails($productId);
if (!$result) {
    $_SESSION['error_voorraad'] =  'Het ophalen van detailgegevens is niet goedgegaan. Raadpleeg uw beheerder!';
    header('location: voorraad.php');
    exit();
}
$aantal = $result->rowCount();

if($aantal>1) {
    $_SESSION['error_voorraad'] =  'Er zijn meerdere producten geselecteerd. Dit gaat niet goed!';
    header('location: voorraad.php');
    exit();
} elseif ($aantal==0) {
    $_SESSION['error_voorraad'] =  'Er is geen product geselecteerd. Dit gaat niet goed!';
    header('location: voorraad.php');
    exit();
}
include 'inc/header.php';
// header tags toevoegen
echo '<header class="head">';
echo '</header>'; //afsluiten header
// voor gridopmaak alvast de main-content
echo '<main class="main-content">';
// FORM EDIT product...
echo '<div id="frmDetail">';

//1 record...
$product = $result->fetch(PDO::FETCH_ASSOC);
$listArtikelgroep = $oProduct->getProductGroups($dbconn);
if (!$listArtikelgroep) {
    $selectBox = '<SELECT name="artikelgroep" id="fArtikelgroep">
                    <option value="' . $product["artikelgroep"] . '">' . $product["artikelgroep"] . '</option>
                    </SELECT>';
} else {
    $selectBox = '<SELECT name="artikelgroep" id="fArtikelgroep">';
    while ($artikelGroup = $listArtikelgroep->fetch(PDO::FETCH_ASSOC)) {
        if ($product["artikelgroep"]==$artikelGroup["artikelgroep"]) {
            $selectBox .= '<option selected value="' . $artikelGroup["artikelgroep"] . '">' . $artikelGroup["artikelgroep"] . '</option>';
        } else {
            $selectBox .= '<option value="' . $artikelGroup["artikelgroep"] . '">' . $artikelGroup["artikelgroep"] . '</option>';
        }

    }
    $selectBox .= '</SELECT>';
}

?>
<div>
    <form action ="dataverwerken.php" method="POST" class="frmDetail">
        <input type="hidden" name="action" value="UpdateProduct">
        <input type="hidden" name="id" value="<?php echo $productId;?>">
        <label for="fproductnr">Artikelnummer:</label>
        <input type="text" name="artikelnummer" value="<?php echo $product["artikelnummer"];?>" id="fproductnr" readonly class="ro">
        <label for="fproductomschrijving">Omschrijving:</label>
        <input type="text" name="omschrijving" value="<?php echo $product["omschrijving"];?>" id="fproductomschrijving">
        <label for="fLeverancier">Leverancier.:</label>
        <input type="text" name="leverancier" value="<?php echo $product["leverancier"];?>" id="fLeverancier">
        <label for="fArtikelgroep">Artikelgroep:</label>
        <?php echo $selectBox;?>
        <label for="fEenheid">Eenheid:</label>
        <input type="text" name="eenheid" value="<?php echo $product["eenheid"];?>" id="fEenheid">
        <label for="fPrijs">Prijs:</label>
        <input type="text" name="prijs" value="<?php echo $product["prijs"];?>" id="fPrijs">
        <label for="fAantal">Aantal:</label>
        <input type="text" name="aantal" value="<?php echo $product["aantal"];?>" id="fAantal">
        <div class="submitbtn">
            <input type="submit" name="submit" value="bewaren..." class="btnDetailSubmit">
        </div>
    </form>
</div>
<?php
echo '</div>'; //frmDetail
echo '</main>'; //main-content
include ("inc/footer.php");
?>
