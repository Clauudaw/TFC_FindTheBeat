<?php
$host = 'localhost';
$dbname = 'findTheBeat';
$username = 'root';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
