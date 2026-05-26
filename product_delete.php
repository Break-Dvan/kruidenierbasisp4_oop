<?php
include 'inc/header.php';
// header tags toevoegen
echo '<header class="head">';

echo '</header>'; //afsluiten header
// voor gridopmaak alvast de main-content
echo '<main class="main-content">';
// FORM EDIT product...
echo '<div id="frmDetail">';
if (isset($_GET["id"])) {
    $productId=$_GET["id"];
}
else {
    echo 'Product niet gevonden...';
    header('refresh: 2; url=voorraad.php');
    exit;
}
$delProduct = new Product($dbconn);
$result = $delProduct->getProductDetails($productId);
$infoProduct = $result->fetch(PDO::FETCH_ASSOC);
$Product = "<h2>Product: ".$infoProduct['artikelnummer']. " - ".$infoProduct['omschrijving']."</h2>";

//$msg = '<div class="msgA">Weet u zeker dat u '.$infoProduct['omschrijving']. ' wilt verwijderen?<br>';
$msg = '<div class="msgA">Weet u zeker dat u '.$infoProduct['omschrijving']. ' wilt verwijderen?<br>';
if ($infoProduct['aantal']>0) {
    $msg .= 'Let op: u verwijdert dan ook de voorraad: '.$infoProduct['aantal']. ' ('.$infoProduct['eenheid']. ')<br>';
}
$msg .= '</div>';

?>
<div>
    <?php
        echo $Product;
        echo $msg;
    ?>
    <form action ="dataverwerken.php" method="POST" class="frmDetail">
        <input type="hidden" name="action" value="DeleteProduct">
        <input type="hidden" name="id" value="<?php echo $productId;?>">
        <input type="hidden" name="artikelnummer" value"<?php echo $infoProduct['artikelnummer'];?>

        <div class="submitbtn">
            <input type="submit" name="verwijderen" value="verwijderen" class="btnDetailSubmit">
            <input type="submit" name="terug" value="terug" class="btnDetailSubmit">
        </div>
    </form>
</div>
<?php
echo '</div>'; //frmDetail
echo '</main>'; //main-content
include ("inc/footer.php");
?>

