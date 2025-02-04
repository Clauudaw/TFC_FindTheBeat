<?php
// Configuración de la base de datos
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_NAME", "findthebeat");

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
/*
<?php
  $host_name = 'db5017147270.hosting-data.io';
  $database = 'dbs13781720';
  $user_name = 'dbu682517';
  $password = 'Edgar.allan.poe.1704';
  $dbh = null;

  try {
    $dbh = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  } catch (PDOException $e) {
    echo "Error!:" . $e->getMessage() . "<br/>";
    die();
  }
?>*/
?>

