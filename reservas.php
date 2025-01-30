<?php
// Iniciar sesión para obtener el user_id del usuario logueado
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir al login o mostrar un mensaje de error
    die("Debes iniciar sesión para hacer una reserva.");
}

// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Conectar a la base de datos
include 'db.php';

// Obtener el ID del espacio desde la URL
$space_id = isset($_GET['space_id']) ? (int)$_GET['space_id'] : 0;

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $dni = htmlspecialchars($_POST['dni']);
    $correo = htmlspecialchars($_POST['correo']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = htmlspecialchars($_POST['telefono']);
    $metodo_pago = $_POST['metodo_pago'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    // Insertar la reserva en la base de datos
    $stmt = $db->prepare("INSERT INTO bookings 
        (space_id, user_id, nombre, apellidos, dni, correo, fecha_nacimiento, telefono, metodo_pago, fecha_reserva, hora_inicio, hora_fin, estado, created_at, updated_at) 
        VALUES 
        (:space_id, :user_id, :nombre, :apellidos, :dni, :correo, :fecha_nacimiento, :telefono, :metodo_pago, :fecha_reserva, :hora_inicio, :hora_fin, 'pendiente', NOW(), NOW())");

    $stmt->execute([
        ':space_id' => $space_id,
        ':user_id' => $user_id,
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':dni' => $dni,
        ':correo' => $correo,
        ':fecha_nacimiento' => $fecha_nacimiento,
        ':telefono' => $telefono,
        ':metodo_pago' => $metodo_pago,
        ':fecha_reserva' => $fecha_reserva,
        ':hora_inicio' => $hora_inicio,
        ':hora_fin' => $hora_fin
    ]);

    // Si la inserción es exitosa, guarda el estado en una variable de sesión
    $_SESSION['reservation_success'] = true;

    // Redirigir al mismo formulario después de la reserva
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Espacio</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            background-color: #f4f4f4;
        }
        h1 {
            color: #3D8168;
            font-size: 2.5rem;
        }
        .form-label {
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 5px;
            border: 2px solid #3D8168;
        }
        .form-select {
            border-radius: 5px;
            border: 2px solid #3D8168;
        }
        .btn-primary {
            background-color: #3D8168;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
        }
        .btn-primary:hover {
            background-color: #316f53;
        }
        .btn-primary:focus {
            box-shadow: 0 0 0 0.25rem rgba(61, 129, 104, 0.5);
        }
    </style>
</head>
<body>

<?php include_once './components/header.php'; ?>

<div class="container">
    <br><br>
    <h1 class="mb-4">Reservar Espacio</h1>
    <form method="POST" class="row g-3 needs-validation" novalidate>
        <input type="hidden" name="space_id" value="<?php echo $space_id; ?>">

        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Apellidos</label>
            <input type="text" class="form-control" name="apellidos" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">DNI</label>
            <input type="text" class="form-control" name="dni" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" name="correo" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="fecha_nacimiento" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="telefono" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Método de Pago</label>
            <select class="form-select" name="metodo_pago" required>
                <option value="tarjeta">Tarjeta de Crédito</option>
                <option value="paypal">PayPal</option>
                <option value="transferencia">Transferencia Bancaria</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Fecha de Reserva</label>
            <input type="date" class="form-control" name="fecha_reserva" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Hora de Inicio</label>
            <input type="time" class="form-control" name="hora_inicio" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Hora de Fin</label>
            <input type="time" class="form-control" name="hora_fin" required>
        </div>
        <div class="col-12">
        <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
        </div>
    </form>
    <br>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="reservaConfirmadaModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Reserva Confirmada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ✅ ¡Tu reserva ha sido confirmada con éxito!  
                    Puedes verla en tu <a href="user_dashboard.php">panel personal</a>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function mostrarModalReserva() {
        var modal = new bootstrap.Modal(document.getElementById('reservaConfirmadaModal'));
        modal.show();
    }

    document.addEventListener("DOMContentLoaded", function () {
    // Verificar si la variable de sesión está presente (se puede pasar desde PHP)
    <?php if (isset($_SESSION['reservation_success']) && $_SESSION['reservation_success'] == true): ?>
        mostrarModalReserva(); // Muestra el modal si la variable está definida
        <?php unset($_SESSION['reservation_success']); // Eliminar la variable de sesión después de mostrar el modal ?>
    <?php endif; ?>
});
</script>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
