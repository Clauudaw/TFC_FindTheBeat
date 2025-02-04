<?php
session_start();
require_once './db.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['error'] = "❌ Todos los campos son obligatorios.";
            header('Location: user_dashboard.php');
            exit();
        }

        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $email, $password, $user_id]);

        $_SESSION['success'] = "✅ Tu perfil se ha actualizado correctamente.";
    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al actualizar: " . $e->getMessage();
    }

    header('Location: user_dashboard.php');
    exit();
} else {
    $_SESSION['error'] = "❌ Solicitud no válida.";
    header('Location: user_dashboard.php');
    exit();
}
?>
