<?php
include 'inc/init.php';

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
                header('location: voorraad.php');
            } else {
                header('location: voorraad.php');
            }
            break;
        case "LEEG":
        default:
            $_SESSION['error_voorraad'] =  'Geen geldige actie';
            header('location: voorraad.php');
            exit;
    }
} else {
    header('location: index.php');
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
    $result = $oUpdateProduct->updateProduct($id, $prijs, $aantal, $omschrijving, $leverancier, $artikelgroep);
    if ($result) {
        $_SESSION['msg_voorraad'] = "Gegevens zijn bijgewerkt!";
        header('location: voorraad.php');
        exit();
    } else {
        $_SESSION['error_voorraad'] = "Gegevens zijn NIET bijgewerkt!";
        header('location: voorraad.php');
        exit();
    }
}
//id, artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal FROM product
function newProduct()
{
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
        $_SESSION['msg_voorraad'] = "Nieuw product is toegevoegd.";
        header('location: voorraad.php');
        exit();
    } else {
        //echo "<p>Product {$omschrijving} is NIET toegevoegd...</p><br>";
        $_SESSION['error_voorraad'] = "Nieuw product is NIET toegevoegd...";
        header('location: voorraad.php');
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
    include "inc/header.php";
    echo '<main class="main-content">';
    echo $strMsg;

    echo '</main>'; //main afsluiten
    include("inc/footer.php");
}
?>

<?php
//echo '</div>'; //frmDetail afsluiten

?>