<?php
// include header.php
include 'inc/header.php';
// header tags toevoegen
echo '
<header class="head">';
// url voor handmatige voorraad...
echo "<a href='voorraad.php' class='btn-new'><i class='material-icons md-24'>list</i></a>";

//echo '<span class="material-icons-outlined">
//import_export
//</span> ';
echo '
</header>'; //afsluiten header
// voor gridopmaak alvast de main-content
echo '
<main class="main-content">';
echo '<h2>Importeren voorraad...</h2>';
?>
<div id="import">
        <div> <!-- enctype="multipart/form-data" is nodig om $_FILES terug te krijgen...-->
            <form action="dataverwerken.php" method="POST" class="frmImport" enctype="multipart/form-data">
                <!-- button!! -->
                <input type="file" name="csvbestand" id="fBestand" size="25" placeholder="selecteer bestand..." accept=".csv"><br><br>
                <input type="hidden" name="action" value="ImportVoorraad">
                <input class="importbtn" type="submit" name="submit" value="Start Import"><br>
            </form>
        </div>
    </div>

<?php
// include footer
echo '</div>'; //frmDetail afsluiten
echo '
</main>'; //main afsluiten
include("inc/footer.php");
?>