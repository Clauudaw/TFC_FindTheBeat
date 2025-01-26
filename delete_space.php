<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar espacio
    $stmt = $db->prepare("DELETE FROM spaces WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: admin_dashboard.php');
    exit();
}
