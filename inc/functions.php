<?php
// functie of product al bestaat...
function getExistProduct($artikelnummer) {
    global $dbconn; // database connectie moet wel beschikbaar zijn
    $resultFunction=false;
    $qry = "SELECT id FROM product 
            WHERE artikelnummer={$artikelnummer};";
    $result = mysqli_query($dbconn,$qry);
    if (mysqli_num_rows($result)==1) { // bestaat; mag maar één keer voorkomen in db. artikelnummer uniek.
        $resultFunction=true;
    }
    return $resultFunction;
}
// functie product updaten...Aantal moet wel correct zijn: aantal oude voorraad + aantal bestelling
function updateProduct ($artikelnummer, $prijs, $aantal) { // leverancier en artikelgroep wijzigen niet. Alleen aantal en prijs zouden kunnen wijzigen...
    global $dbconn;
    $updateQry = "UPDATE product
                    SET prijs='{$prijs}', aantal={$aantal}
                    WHERE artikelnummer={$artikelnummer};";
    $resultUpdate = mysqli_query($dbconn, $updateQry);
}
// functie product toevoegen
function insertProduct ($artikelnummer, $omschrijving, $leverancier, $artikelgroep, $eenheid, $prijs, $aantal){
    global $dbconn;

    $qryInsert = "INSERT INTO product
                    (artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal)
                    VALUES ({$artikelnummer}, '".addslashes($omschrijving)."', '". addslashes($leverancier)."', '{$artikelgroep}', '{$eenheid}', '".str_replace(",",".",$prijs)."', {$aantal});";
    $resultInsert = mysqli_query($dbconn, $qryInsert);
}
function getProductVoorraad($artikelnummer) {
    global $dbconn; // database connectie moet wel beschikbaar zijn
    $resultFunction=-1;
    $qry = "SELECT id, aantal FROM product 
            WHERE artikelnummer={$artikelnummer};";
    $result = mysqli_query($dbconn,$qry);
    if (mysqli_num_rows($result)==1) { // bestaat; mag maar één keer voorkomen in db. artikelnummer uniek.
        $product=mysqli_fetch_assoc($result);
        $resultFunction=$product['aantal'];
    }
    return $resultFunction;
}


function deleteProduct($id) {
    global $dbconn;
    $qryDelete = "DELETE FROM product
                   WHERE id=$id;";
    mysqli_query($dbconn, $qryDelete);
}
// insert into log_import-table
// logImport($_FILES['csvbestand']['name'], $_SESSION['inlognaam'], $update, $new );
function logImport($file, $user, $iUpdate, $iNew) {
    global $dbconn;

    $qryInsertLog = "INSERT INTO `log_import` 
                    (`bestand`, `medewerker`, `update`, `new`)
                    values('.{$file}', '{$user}', {$iUpdate}, {$iNew});";
    $result = mysqli_query($dbconn, $qryInsertLog);
}

function getFileExtension($name) {
    $n = strrpos($name, '.');
    return ($n === false) ? '' : substr($name, $n+1);
}
?>