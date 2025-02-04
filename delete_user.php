<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si el usuario tiene reservas para que no se pueda eliminar
    $stmt = $db->prepare("SELECT COUNT(*) FROM bookings WHERE user_id = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $_SESSION['error'] = "❌ El usuario tiene reservas asociadas y no puede ser eliminado.";
    } else {
        // Eliminar usuario
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "✅ Usuario eliminado correctamente.";
    }

    header('Location: admin_dashboard.php'); // Redirigir con mensaje
    exit();
}
?>
