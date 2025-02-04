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
?>