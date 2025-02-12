<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "❌ ID de reserva no válido.";
    header('Location: user_dashboard.php');
    exit();
}

$booking_id = $_GET['id'];

try {
    if ($user_role === 'admin') {
        $stmt = $db->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$booking_id]);

        $_SESSION['success'] = "✅ La reserva ha sido eliminada correctamente.";
        header('Location: admin_dashboard.php');
        exit();
    } elseif ($user_role === 'normal') {
        $stmt = $db->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
        $stmt->execute([$booking_id, $user_id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "✅ Tu reserva ha sido eliminada.";
        } else {
            $_SESSION['error'] = "❌ No puedes eliminar esta reserva.";
        }

        header('Location: user_dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = "❌ No tienes permisos para realizar esta acción.";
        header('Location: login.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = "❌ Error al eliminar la reserva: " . $e->getMessage();
    header('Location: user_dashboard.php');
    exit();
}
?>

