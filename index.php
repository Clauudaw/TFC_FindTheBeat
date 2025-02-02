<?php
session_start();
include './components/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindTheBeat</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div id="carousel"></div> 

    <?php include './components/destacados.php'; ?>
    <?php include './components/newsletter.php'; ?>

    <div id="footer"></div> 
    <div id="arrowup"></div>
    
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>

</body>
</html>
