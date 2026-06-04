<?php
include 'inc/init.php';
include 'inc/header.php';
// header tags toevoegen
echo '<header class="head">';
// url voor handmatige voorraad...
echo "<a href='product_new.php' class='btn-new'><i class='material-icons md-24'>add</i></a>";
echo "<a href='voorraad_import.php' class='btn-new'><i class='material-icons md-24'>file_upload</i></a>";

echo '</header>'; //afsluiten header
// voor gridopmaak alvast de main-content
echo '<main class="main-content">';
if (isset($_SESSION['error_voorraad'])) {
    echo $_SESSION['error_voorraad'];
    unset($_SESSION['error_voorraad']);
}
if (isset($_SESSION['msg_voorraad'])) {
    echo $_SESSION['msg_voorraad'];
    unset($_SESSION['msg_voorraad']);
}
?>
    <!-- tabelkop met Voorraad als HTML-->
    <table id="voorraad">
        <tr>
            <th>artikelnummer</th>
            <th>omschrijving</th>
            <th>leverancier</th>
            <th>artikelgroep</th>
            <th>eenheid</th>
            <th>prijs</th>
            <th>aantal</th>
            <th>actie</th>
        </tr>
<?php
//bepaling 'page' voor paginering
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
else {
    $page=1;
}
//start vanaf
$start_from = ($page-1) * RECORDS_PER_PAGE;
//aantal pagina's bepalen t.b.v. paginering
$oProduct = new Product($dbconn);
$total_rows = $oProduct->getCountProduct();
$total_pages = ceil($total_rows / RECORDS_PER_PAGE);

// ophalen producten uit database
$result = $oProduct->getProductPerPage($start_from, RECORDS_PER_PAGE);
$aantal=$result->rowCount();
$contentTable="";
// tabel aanvullen met klantgegevens
if ($aantal>0){ //controle of er wel wat opgehaald wordt...
    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        $contentTable.="<tr>
                            <td>".$row['artikelnummer']."</td>                       
                            <td>".$row['omschrijving']."</td>                       
                            <td>".$row['leverancier']."</td>                       
                            <td>".$row['artikelgroep']."</td>                       
                            <td>".$row['eenheid']."</td>                      
                            <td>".$row['prijs']."</td>                      
                            <td>".$row['aantal']."</td>
                            <td>
                                <a href='product_edit.php?id={$row['id']}' class='btn-edit'><i class='material-icons md-24'>edit</i></a>
                                <a href='product_delete.php?id={$row['id']}' class='btn-delete'><i class='material-icons md-24'>delete</i></a>
                            </td>
                        </tr>";
    }
}
else {
    $contentTable='<tr>
                        <td colspan="9">Geen gegevens om op te halen...</td>
                    </tr>';
}
// weergave van de rest van de tabel;
$contentTable.='</table><br>';
echo $contentTable;
// paginering van de tabel
$page_url="voorraad.php";
include_once 'inc/paginering.php';

// include footer
echo '</main>'; //main afsluiten
include ("inc/footer.php") ;
?>