<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['error'] = "❌ Todos los campos son obligatorios.";
        header('Location: admin_dashboard.php');
        exit();
    }

    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "❌ El correo electrónico ya está registrado.";
        header('Location: admin_dashboard.php');
        exit();
    }

    $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $password, $role]);

    $_SESSION['success'] = "✅ El nuevo usuario ha sido creado correctamente.";
    header('Location: admin_dashboard.php');
    exit();
}
?>
