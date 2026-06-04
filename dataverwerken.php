<?php
include 'inc/init.php';
//include 'inc/header.php';
// header tags toevoegen
echo '<header class="head">';
echo '<p>eventueel extra info</p>';
echo '</header>'; //afsluiten header

// voor gridopmaak alvast de main-content
echo '<main class="main-content">';
// Begin FORM
//echo '<div id="frmDetail">';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = isset($_POST["action"]) ? $_POST["action"] : 'LEEG';
    switch ($action) {
        case "UpdateProduct":
            updateProductDetail();
            break;
        case "NewProduct":
            newProduct();
            break;
        case "ImportVoorraad":
            importCSV();
            break;
        case "DeleteProduct":
            //deleteProduct();
            $delValue = false;
            $delValue = isset($_POST["verwijderen"]) ? true : false;
            $idProduct = isset($_POST["id"]) ? $_POST['id'] : 0;
            $artikelnr = isset($_POST["artikelnummer"]) ? $_POST["artikelnummer"] : 'onbekend artikel';
            if ($delValue) {
                $oDelProduct = new Product($dbconn);
                $msg = $oDelProduct->deleteProduct($idProduct);
//                echo $msg; => komt uit class...
                //echo 'Product ' . $artikelnr . ' is verwijderd...<br>';
                header('refresh: 1; url=voorraad.php');
            } else {
                //echo 'Product ' . $artikelnr . ' is niet verwijderd...<br>';
                header('refresh: 1; url=voorraad.php');
            }
            break;
        case "LEEG":
        default:
            echo "geen geldige actie...";
    }
} else {
    header('url=index.php');
}
function updateProductDetail()
{
    global $dbconn;
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $artikelnr = isset($_POST['artikelnummer']) ? addslashes($_POST['artikelnummer']) : "";
    $omschrijving = isset($_POST['omschrijving']) ? addslashes($_POST['omschrijving']) : "";
    $leverancier = isset($_POST['leverancier']) ? addslashes($_POST['leverancier']) : "";
    $artikelgroep = isset($_POST['artikelgroep']) ? $_POST['artikelgroep'] : "";
    $eenheid = isset($_POST['eenheid']) ? $_POST['eenheid'] : "";
    $prijs = isset($_POST['prijs']) ? addslashes($_POST['prijs']) : "";
    $prijs = str_replace(",", ".", $prijs);
    $aantal = isset($_POST['aantal']) ? $_POST['aantal'] : "";
    $oUpdateProduct = new Product($dbconn);
//    echo "Resultaat: {$id} {$prijs} {$aantal} {$omschrijving} {$leverancier} {$artikelgroep}";
    $result = $oUpdateProduct->updateProduct($id, $prijs, $aantal, $omschrijving, $leverancier, $artikelgroep);
    //(BkD 5-4-2024 16:27) let op: werkt nog niet. Wijzigt ALLE records en niet 1... class Product nakijken
    if ($result) {
        //echo "<p>Product {$omschrijving} ({$artikelnr} en id= {$id}) is aangepast</p><br>";
        header('refresh: 1; url=voorraad.php');
        exit();
    } else {
//        echo "<p>Product {$omschrijving} ({$artikelnr}) is NIET aangepast</p><br>
//                <br>";
        header('refresh: 4; url=voorraad.php');
        exit();
    }
}

//id, artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal FROM product
function newProduct()
{
    //nog niet geregeld: controle of artikelnummer al bestaat... Zou wel moeten natuurlijk!!
    global $dbconn;
    $artikelnr = isset($_POST['artikelnummer']) ? addslashes($_POST['artikelnummer']) : "";
    $omschrijving = isset($_POST['omschrijving']) ? addslashes($_POST['omschrijving']) : "";
    $leverancier = isset($_POST['leverancier']) ? addslashes($_POST['leverancier']) : "";
    $artikelgroep = isset($_POST['artikelgroep']) ? $_POST['artikelgroep'] : "";
    $eenheid = isset($_POST['eenheid']) ? $_POST['eenheid'] : "";
    $prijs = isset($_POST['prijs']) ? addslashes($_POST['prijs']) : "";
    $prijs = str_replace(",", ".", $prijs);
    $aantal = isset($_POST['aantal']) ? $_POST['aantal'] : "";
    $oNewProduct = new Product($dbconn);

    $result = $oNewProduct->insertProduct($artikelnr, $omschrijving, $leverancier, $artikelgroep, $eenheid, $prijs, $aantal);
    if ($result) {
        //echo "<p>Product {$omschrijving} is toegevoegd</p><br>";
        header('refresh: 1; url=voorraad.php');
        exit();
    } else {
        //echo "<p>Product {$omschrijving} is NIET toegevoegd...</p><br>";
        header('refresh: 10; url=voorraad.php');
        exit();
    }
}

function importCSV()
{
    global $dbconn;
    $extension = getFileExtension($_FILES["csvbestand"]["name"]);
    $filename = $_FILES['csvbestand']['tmp_name'];
    $fileInfo = pathinfo($filename);
    echo '<h2>Voorraad bijwerken</h2>';
    if ($extension == 'csv' and $_FILES['csvbestand']['size'] > 0) { // importeren...
        $oProductImport = new Product($dbconn);
        // bestand openen
        $importFile = fopen($filename, "r");
        $update = 0;
        $new = 0;
        while (!feof($importFile)) {

            //[0] => artikelnummer [1] => omschrijving [2] => leverancier
            //[3] => artikelgroep [4] => eenheid [5] => prijs [6] => aantal
            $record = fgetcsv($importFile, 255, ";");
            if (is_array($record)) { //lege regels vermijden...
                $field_one = $record[0];
                $field_one = substr($field_one, -13); // artikelnummer...

                if ($field_one != 'artikelnummer') {
                    // controle voorraad product; bestaat niet=>-1 anders >=0
                    $voorraad = $oProductImport->getProductVoorraad($record[0]);
                    if ($voorraad >= 0) { //bestaat...
                        $voorraadTotaal = $voorraad + $record[6];
                        $oProductImport->updateProductVoorraad($record[0],str_replace(",", ".", $record[5]),$voorraadTotaal);
                        $update++;
                    } else { // bestaat niet=>insert
                        $oProductImport->insertProduct($record[0], $record[1], $record[2], $record[3], $record[4], str_replace(",", ".", $record[5]), $record[6]);
                        $new++;
                    }
                }
            }
        }
        // msg update/new
        $strMsg = '<p>Vooraadverwerking geslaagd</p>';
        $strMsg .= '<dl>
                        <dt>Producten:</dt>
                        <dd>Bijgewerkt: ' . $update . '</dd>
                        <dd>Nieuw:' . $new . '</dd>
                    </dl>';
        $oLogImport = new Logging($dbconn);
        $oLogImport->ImportLog($filename, $_SESSION['inlognaam'], $update, $new);
    } else { // niet het juiste format...
        $strMsg = '<p>Helaas, geen juist bestand</p>';
    }
    fclose($importFile);
    echo $strMsg;
}

?>

<?php
//echo '</div>'; //frmDetail afsluiten
echo '</main>'; //main afsluiten 
include("inc/footer.php");
?>