<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'];
    $direccion = $_POST['direccion'] ?? null;
    $provincia = $_POST['provincia'] ?? null;
    $comunidad_autonoma = $_POST['comunidad_autonoma'];
    $capacidad = $_POST['capacidad'] ?? null;
    $tipo = $_POST['tipo'];

    $stmt = $db->prepare("INSERT INTO spaces (titulo, descripcion, precio, direccion, provincia, comunidad_autonoma, capacidad, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$titulo, $descripcion, $precio, $direccion, $provincia, $comunidad_autonoma, $capacidad, $tipo]);

    $_SESSION['success'] = "✅ El nuevo espacio ha sido creado correctamente.";
    header('Location: admin_dashboard.php');
    exit();
}
