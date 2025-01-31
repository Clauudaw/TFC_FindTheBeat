<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar reseña
    $stmt = $db->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->execute([$id]);

    // Guardar mensaje en sesión y redirigir
    $_SESSION['success'] = "✅ Se ha eliminado la reseña con exito.";
    header('Location: admin_dashboard.php');
    exit();
}

