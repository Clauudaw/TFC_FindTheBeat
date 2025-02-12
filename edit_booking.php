<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $booking_id = $_POST['id'];

    $user_id = $_POST['user_id'];
    $space_id = $_POST['space_id'];
    $estado = $_POST['estado'];
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

    $stmt = $db->prepare("UPDATE bookings SET user_id = ?, space_id = ?, estado = ?, nombre = ?, apellidos = ?, dni = ?, correo = ?, fecha_nacimiento = ?, telefono = ?, metodo_pago = ?, fecha_reserva = ?, hora_inicio = ?, hora_fin = ? WHERE id = ?");
    $stmt->execute([$user_id, $space_id, $estado, $nombre, $apellidos, $dni, $correo, $fecha_nacimiento, $telefono, $metodo_pago, $fecha_reserva, $hora_inicio, $hora_fin, $booking_id]);

    $_SESSION['success'] = "✅ La reserva ha sido actualizada correctamente.";
    header('Location: admin_dashboard.php');
    exit();
}

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "⚠️ No se encontró la reserva.";
    header('Location: admin_dashboard.php');
    exit();
}

$booking_id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    $_SESSION['error'] = "❌ La reserva no existe.";
    header('Location: admin_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-light">
<?php include './components/header.php' ?><br>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin_dashboard.php" class="breadcrumb-link">Panel de Administración</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Editar Reserva</a></li>
  </ol>
</nav>

<div class="container d-flex justify-content-center align-items-center my-5">
    <div class="col-md-8">
        <div class="card shadow-sm rounded p-4">
            <h3 class="mb-4 text-center">Editar Reserva</h3>
            <form action="edit_booking.php" method="POST">
                <input type="hidden" name="id" value="<?= $booking['id']; ?>">

                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuario</label>
                    <input type="text" id="user_id" name="user_id" class="form-control" 
                           value="<?= $booking['user_id']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="space_id" class="form-label">Espacio</label>
                    <input type="text" id="space_id" name="space_id" class="form-control" 
                           value="<?= $booking['space_id']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select id="estado" name="estado" class="form-select" required>
                        <option value="pendiente" <?= $booking['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="confirmada" <?= $booking['estado'] === 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                        <option value="cancelada" <?= $booking['estado'] === 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" 
                           value="<?= $booking['nombre']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" class="form-control" 
                           value="<?= $booking['apellidos']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" id="dni" name="dni" class="form-control" 
                           value="<?= $booking['dni']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" id="correo" name="correo" class="form-control" 
                           value="<?= $booking['correo']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" 
                           value="<?= $booking['fecha_nacimiento']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" 
                           value="<?= $booking['telefono']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="metodo_pago" class="form-label">Método de Pago</label>
                    <select id="metodo_pago" name="metodo_pago" class="form-select" required>
                        <option value="Tarjeta" <?= $booking['metodo_pago'] === 'Tarjeta' ? 'selected' : ''; ?>>Tarjeta</option>
                        <option value="PayPal" <?= $booking['metodo_pago'] === 'PayPal' ? 'selected' : ''; ?>>PayPal</option>
                        <option value="Bizum" <?= $booking['metodo_pago'] === 'Bizum' ? 'selected' : ''; ?>>Bizum</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_reserva" class="form-label">Fecha de Reserva</label>
                    <input type="date" id="fecha_reserva" name="fecha_reserva" class="form-control" 
                           value="<?= $booking['fecha_reserva']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" 
                           value="<?= $booking['hora_inicio']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="hora_fin" class="form-label">Hora de Fin</label>
                    <input type="time" id="hora_fin" name="hora_fin" class="form-control" 
                           value="<?= $booking['hora_fin']; ?>" required>
                </div>

                <button type="submit" class="btn w-100 text-white" style="background-color: #3D8168; padding: 10px 20px; border: none; cursor: pointer;"
        onmouseover="this.style.backgroundColor='#2C614E'" onmouseout="this.style.backgroundColor='#3D8168'">Actualizar Reserva</button>
            </form>
        </div>
    </div>
</div>

<div id="footer"></div>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>