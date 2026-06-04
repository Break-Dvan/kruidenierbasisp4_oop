<?php
class Gebruiker {
    private $db;
    public $rol;
    private $auth;


    public function __construct($dbconn) {
        $this->db=$dbconn;
    }
    public function getAuthorisation($user, $pw)
    {
        $query = "SELECT m.id, m.inlognaam, m.wachtwoord, r.naam as rol FROM medewerker m
            INNER JOIN rol r ON m.rol_id=r.id
            where m.inlognaam= :inlognaam;";
        try {
            $stmt = $this->db;
            $stmt = $stmt->prepare($query);
            $stmt->bindParam(':inlognaam', $user);
            $stmt->execute();
            $aantal = $stmt->rowCount();
            if ($aantal == 1) { // inloggen akkoord, nu nog controle op hash...
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $pw_database = $row['wachtwoord']; // hash!!
                if (password_verify($pw, $pw_database)) {
                    $this->auth = true;
                    $this->rol = $row['rol'];
                } else {
                    $this->auth = false;
                }
            } else {
                $this->auth = false;
            }
        } catch (PDOException $e) {
            $this->auth = false;
        }
        return $this->auth;
    }
}


?>