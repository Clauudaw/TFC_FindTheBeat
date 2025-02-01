<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Verifica si se ha pasado el ID de la reserva
if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php');
    exit();
}

$booking_id = $_GET['id'];

// Preparar y ejecutar la consulta SQL para eliminar la reserva
$stmt = $db->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);

// Guardar mensaje en sesión y redirigir
$_SESSION['success'] = "✅ La reserva ha sido eliminada correctamente.";
header('Location: admin_dashboard.php');
exit();
?>
