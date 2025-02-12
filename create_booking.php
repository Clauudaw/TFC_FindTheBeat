<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $space_id = $_POST['space_id'];
    $estado = 'pendiente'; 
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $metodo_pago = $_POST['metodo_pago'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $stmt = $db->prepare("INSERT INTO bookings (user_id, space_id, estado, nombre, apellidos, dni, correo, fecha_nacimiento, telefono, metodo_pago, fecha_reserva, hora_inicio, hora_fin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $space_id, $estado, $nombre, $apellidos, $dni, $correo, $fecha_nacimiento, $telefono, $metodo_pago, $fecha_reserva, $hora_inicio, $hora_fin]);

    $_SESSION['success'] = "✅ La reserva ha sido creada correctamente.";
    header('Location: admin_dashboard.php');
    exit();
}
?>
