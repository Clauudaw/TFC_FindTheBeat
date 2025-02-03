<?php
session_start();
require_once './db.php'; // Asegúrate de que este archivo conecta a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validación básica
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['error'] = "❌ Todos los campos son obligatorios.";
        header('Location: contacto.php');
        exit();
    }

    try {
        // Insertar el mensaje en la base de datos
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
