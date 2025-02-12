<?php
session_start();
require_once './db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['error'] = "❌ Todos los campos son obligatorios.";
        header('Location: contacto.php');
        exit();
    }

    try {
        $stmt = $db->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);

        $_SESSION['success'] = "✅ Tu mensaje ha sido enviado con éxito.";
    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al enviar el mensaje: " . $e->getMessage();
    }

    header('Location: contacto.php');
    exit();
} else {
    $_SESSION['error'] = "❌ Solicitud no válida.";
    header('Location: contacto.php');
    exit();
}
?>
