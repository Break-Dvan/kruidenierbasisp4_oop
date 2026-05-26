<?php
include("inc/header.php");
?>
<main class="main-content">
    <div id="login">
        <div>
            <form action="authorisatie.php" method="POST" class="frmlogin">
                <label for="fInlog">Inlognaam:</label><input type="text" name="inlognaam" id="fInlog" size="25" placeholder="inlognaam..."><br>
                <label for="fWachtwoord">Wachtwoord:</label><input type="password" id="fWachtwoord" name="wachtwoord" size="25" placeholder="wachtwoord..."><br>
                <input type="submit" name="submit" value="login"><br>
            </form>
        </div>
    </div>
</main>
<?php
include ("inc/footer.php");
?>

