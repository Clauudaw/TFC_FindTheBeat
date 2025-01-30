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

// Obtener el ID del espacio desde la URL
$space_id = isset($_GET['space_id']) ? (int) $_GET['space_id'] : 0;

// Obtener información del espacio
$stmt = $db->prepare("SELECT titulo, imagen, precio, direccion, descripcion FROM spaces WHERE id = :space_id");
$stmt->execute([':space_id' => $space_id]);
$space = $stmt->fetch(PDO::FETCH_ASSOC);
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
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #3D8168;
            border-color: #3D8168;
        }
        .btn-primary:hover {
            background-color: #316f53;
        }
        .form-floating > label {
            color: #6c757d;
        }
    </style>
</head>
<body>

<?php include_once './components/header.php'; ?>

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-lg-10">
<div class="row">
    <!-- caja de la izquierda-->
    <div class="col-md-4">
                    <div class="card shadow">
                        <img src="<?php echo $space['imagen']; ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($space['titulo']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($space['direccion']); ?></p>
                            <p class="card-text"><?php echo substr(htmlspecialchars($space['descripcion']), 0, 100) . '...'; ?></p>
                            <p class="fw-bold">Precio: <?php echo number_format($space['precio'], 2); ?>€/hora</p>
                        </div>
                    </div>
                </div>

<div class="col-md-8">
<div class="card shadow p-4">
    <h1 class="mb-4">Reservar este Espacio</h1>
    <form method="POST" class="row g-3 needs-validation" novalidate>
        <input type="hidden" name="space_id" value="<?php echo $space_id; ?>">

        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" name="nombre" required>
            <label class="form-label">Nombre</label>       
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" name="apellidos" required>
            <label class="form-label">Apellidos</label>        
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" name="dni" required>
            <label class="form-label">DNI</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="email" class="form-control" name="correo" required>
            <label class="form-label">Correo Electrónico</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="date" class="form-control" name="fecha_nacimiento" required>
            <label class="form-label">Fecha de Nacimiento</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="tel" class="form-control" name="telefono" required>
            <label class="form-label">Teléfono</label>
        </div>
        <div class="col-md-4 form-floating">
            <select class="form-select" name="metodo_pago" required>
                <option value="" selected disabled>Seleccione una opcion</option>
                <option value="tarjeta">Tarjeta de Crédito</option>
                <option value="paypal">PayPal</option>
                <option value="bizum">Transferencia Bancaria</option>
            </select>
            <label class="form-label">Método de Pago</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="date" class="form-control" name="fecha_reserva" required>
            <label class="form-label">Fecha de Reserva</label>
        </div>
        <div class="col-md-3 form-floating">
            <input type="time" class="form-control" name="hora_inicio" required>
            <label class="form-label">Hora de Inicio</label>
        </div>
        <div class="col-md-3 form-floating">
            <input type="time" class="form-control" name="hora_fin" required>
            <label class="form-label">Hora de Fin</label>
        </div>
        <div class="col-12 w-100">
        <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
        </div>
    </form>
    </div>
    </div>
    </div>
</div>
    </div>
    
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
<div id="footer"></div>
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
