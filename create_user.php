<?php
session_start();
require_once './db.php';

// Verifica que el usuario sea un administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validar los datos
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['error'] = "❌ Todos los campos son obligatorios.";
        header('Location: admin_dashboard.php');
        exit();
    }

    // Comprobar si el correo electrónico ya está registrado
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "❌ El correo electrónico ya está registrado.";
        header('Location: admin_dashboard.php');
        exit();
    }

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar y ejecutar la consulta SQL para insertar los datos
    $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password, $role]);

    // Guardar mensaje en sesión y redirigir
    $_SESSION['success'] = "✅ El nuevo usuario ha sido creado correctamente.";
    header('Location: admin_dashboard.php');
    exit();
}
?>
