<?php
class Logging {
    private $db;

    public function __construct($dbconn) {
        $this->db=$dbconn;
    }
    public function ImportLog($file, $user, $iUpdate, $iNew)
    {
        $qryInsertLog = "INSERT INTO `log_import` 
                        (`bestand`, `medewerker`, `update`, `new`)
                        values(:file, :user, :iUpdate, :iNew);";
        try {
            $stmt = $this->db->prepare($qryInsertLog);
            $stmt->bindParam(':file', $file, PDO::PARAM_INT);
            $stmt->bindParam(':user', $user, PDO::PARAM_INT);
            $stmt->bindParam(':iUpdate', $iUpdate, PDO::PARAM_INT);
            $stmt->bindParam(':iNew', $iNew, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>