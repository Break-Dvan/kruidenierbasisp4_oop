<?php
class Product {
    private $db;
    public $count;

    public function __construct($dbconn) {
        $this->db=$dbconn;
    }
    public function getProductPerPage($start, $iRecords) {
        $qryProduct = "SELECT id, artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal FROM product
        ORDER BY omschrijving, artikelgroep, artikelnummer
        LIMIT :start, :iRecords;";
        try {
            $stmt = $this->db->prepare($qryProduct);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':iRecords', $iRecords, PDO::PARAM_INT);
            $stmt->execute();
//            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt;
        } catch (PDOException $e) {
            return 'FOUTJE: ' . $e;
        }
    }
    public function deleteProduct($id)
    {
        $qryDelProduct = "DELETE FROM product
                              WHERE id = :artikelnr ;";
        try {
            $stmt = $this->db->prepare($qryDelProduct);
            $stmt->bindParam(':artikelnr', $id);
            $stmt->execute();
            $msg = "Product {$id} verwijderd!";
        } catch (PDOException $e) {
            $msg = "Product {$id} is NIET verwijderd!";
        }
        return $msg;
    }
    public function updateProduct($id, $prijs, $aantal, $omschrijving, $leverancier, $artikelgroep) {
        $updateQry = "UPDATE product
                    SET prijs=:prijs, aantal=:aantal, omschrijving=:omschrijving, leverancier=:leverancier, artikelgroep=:artikelgroep
                    WHERE id=:id;";
        try {
            $stmt = $this->db->prepare($updateQry);
            $stmt->bindParam(':prijs', $prijs);
            $stmt->bindParam(':aantal', $aantal);
            $stmt->bindParam(':omschrijving', $omschrijving);
            $stmt->bindParam(':leverancier', $leverancier);
            $stmt->bindParam(':artikelgroep', $artikelgroep);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function updateProductVoorraad($artikelnr, $prijs, $aantal) {
        $updateQry = "UPDATE product
                    SET prijs=:prijs, aantal=:aantal, omschrijving=:omschrijving, leverancier=:leverancier, artikelgroep=:artikelgroep
                    WHERE artikelnummer=:artikelnr;";
        try {
            $stmt = $this->db->prepare($updateQry);
            $stmt->bindParam(':prijs', $prijs);
            $stmt->bindParam(':aantal', $aantal);
            $stmt->bindParam(':artikelnr', $artikelnr);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function insertProduct ($artikelnummer, $omschrijving, $leverancier, $artikelgroep, $eenheid, $prijs, $aantal){
        $qryInsert = "INSERT INTO product
                    (artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal)
                    VALUES (?,  ?, ?, ?, ?, ?, ?);";
        try {
            $stmt = $this->db->prepare($qryInsert);
            $arParameters = array($artikelnummer, $omschrijving, $leverancier, $artikelgroep, $eenheid, $prijs, $aantal);
            $stmt->execute($arParameters);
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }
    public function getCountProduct() {
        $qryCount = "SELECT count(id) as aantal FROM product";
        try {
            $stmt = $this->db->prepare($qryCount);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->count = $result['aantal'];
            return $this->count;
        } catch (PDOException $e) {
            return 0;
        }
    }
    public function getProductDetails($artikelnummer)
    {
        $qryProduct = "SELECT id, artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal
                        FROM product
                        WHERE id=:artikelnummer;";
        try {
            $stmt = $this->db->prepare($qryProduct);
            $stmt->bindParam(':artikelnummer', $artikelnummer);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getProductGroups()
    {
        $qryProductGroup = "SELECT distinct artikelgroep FROM product
                            ORDER BY artikelgroep;";
        try {
            $stmt = $this->db->prepare($qryProductGroup);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function NewProduct($artikelnummer, $omschrijving, $leverancier, $artikelgroep, $eenheid, $prijs, $aantal)
    {
        $qryInsertProduct = "INSERT INTO product 
                            (artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal)
                             values(':artikelnummer', ':omschrijving', ':leverancier', ':artikelgroep', ':eenheid',':prijs', :aantal);";
        try {
            $stmt = $this->db->prepare($qryInsertProduct);
            $stmt->bindParam(':artikelnummer', $artikelnummer);
            $stmt->bindParam(':omschrijving', $omschrijving);
            $stmt->bindParam(':leverancier', $leverancier);
            $stmt->bindParam(':artikelgroep', $artikelgroep);
            $stmt->bindParam(':eenheid', $eenheid);
            $stmt->bindParam(':prijs', $prijs);
            $stmt->bindParam(':aantal', $aantal);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return  false;
        }
    }
    public function getProductVoorraad($artikelnummer) {
        $query = "SELECT id, aantal FROM product 
                    WHERE artikelnummer=:artikelnummer;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':artikelnummer', $artikelnummer);
        $stmt->execute();
        if ($stmt->rowCount()==1) {
            $product=$stmt->fetch(PDO::FETCH_ASSOC);
            $voorraad = $product['aantal'];
        } else {
            $voorraad = 0;
        }
        return $voorraad;
    }
    public function ImportCSV($file, $extension) {

    }

}


?>