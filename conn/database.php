<?php
//initialiseren
define('HOST', 'db');
define('DATABASE', 'kruidenierp4');
define('USER', 'root');
define('PASSWORD','H00rnb33ck');
$dbconn='';
//connectie maken
try {
    $dbconn = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4", USER,PASSWORD);
    $dbconn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
catch (exception $e) {
    $dbconn = $e->getMessage();
}

?>