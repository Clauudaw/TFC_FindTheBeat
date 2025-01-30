<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    die("Debes iniciar sesión para hacer una reserva.");
}

$user_id = $_SESSION['user_id'];

// Conectar a la base de datos
include 'db.php';

// Verificar conexión
if (!$db) {
    die("Error de conexión a la base de datos.");
}

// Obtener el ID del espacio desde la URL
$space_id = isset($_GET['space_id']) ? (int) $_GET['space_id'] : 0;

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    try {
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

        // Confirmación de reserva
        $_SESSION['reservation_success'] = true;
        header('Location: espacios.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['reservation_error'] = "Error al reservar: " . $e->getMessage();
        header('Location: espacios.php');
        exit();
    }
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

<?php include './components/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <!-- Columna Izquierda: Card del Espacio -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <img src="<?php echo $space['imagen']; ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($space['titulo']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($space['direccion']); ?></p>
                            <p class="card-text"><?php echo substr(htmlspecialchars($space['descripcion']), 0, 100) . '...'; ?></p>
                            <p class="fw-bold">Precio: €<?php echo number_format($space['precio'], 2); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Formulario de Reserva -->
                <div class="col-md-8">
                    <div class="card shadow p-4">
                        <h1 class="text-center mb-4">Reservar este Espacio</h1>

                        <form id="reservaForm" class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
                                <label for="nombre">Nombre</label>
                                <div class="invalid-feedback">Nombre inválido.</div>
                            </div>

                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" required>
                                <label for="apellidos">Apellidos</label>
                                <div class="invalid-feedback">Apellidos inválidos.</div>
                            </div>

                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="dni" placeholder="DNI" required>
                                <label for="dni">DNI</label>
                                <div class="invalid-feedback">DNI inválido (Ejemplo: 12345678A).</div>
                            </div>

                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="correo" placeholder="Correo Electrónico" required>
                                <label for="correo">Correo Electrónico</label>
                                <div class="invalid-feedback">Correo inválido.</div>
                            </div>

                            <div class="col-md-6 form-floating">
                                <input type="date" class="form-control" id="fecha_nacimiento" required>
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <div class="invalid-feedback">Debes ser mayor de 18 años.</div>
                            </div>

                            <div class="col-md-6 form-floating">
                                <input type="tel" class="form-control" id="telefono" placeholder="Teléfono" required>
                                <label for="telefono">Teléfono</label>
                                <div class="invalid-feedback">Teléfono inválido.</div>
                            </div>

                            <div class="col-md-4">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-select" id="metodo_pago" required>
                                    <option value="tarjeta">Tarjeta de Crédito</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                                </select>
                            </div>

                            <div class="col-md-4 form-floating">
                                <input type="date" class="form-control" id="fecha_reserva" required>
                                <label for="fecha_reserva">Fecha de Reserva</label>
                            </div>

                            <div class="col-md-2 form-floating">
                                <input type="time" class="form-control" id="hora_inicio" required>
                                <label for="hora_inicio">Hora Inicio</label>
                            </div>

                            <div class="col-md-2 form-floating">
                                <input type="time" class="form-control" id="hora_fin" required>
                                <label for="hora_fin">Hora Fin</label>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">Confirmar Reserva</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- Fin Row -->
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="reservaConfirmadaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">¡Reserva Confirmada!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tu reserva se ha realizado con éxito.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div id="footer"></div>

<script>
document.getElementById("reservaForm").addEventListener("submit", function(event) {
    event.preventDefault();
    let valid = true;

    const regexNombre = /^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]{2,}$/;
    const regexDNI = /^[0-9]{8}[A-Za-z]$/;
    const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexTelefono = /^(?:\+34)?[6-9][0-9]{8}$/;

    function validarCampo(id, regex, mensaje) {
        let input = document.getElementById(id);
        if (!regex.test(input.value)) {
            valid = false;
            input.classList.add("is-invalid");
        } else {
            input.classList.remove("is-invalid");
        }
    }

    validarCampo("nombre", regexNombre, "Nombre inválido.");
    validarCampo("apellidos", regexNombre, "Apellidos inválidos.");
    validarCampo("dni", regexDNI, "DNI inválido.");
    validarCampo("correo", regexCorreo, "Correo inválido.");
    validarCampo("telefono", regexTelefono, "Teléfono inválido.");

    let fechaNacimiento = new Date(document.getElementById("fecha_nacimiento").value);
    let edad = new Date().getFullYear() - fechaNacimiento.getFullYear();
    if (edad < 18) {
        valid = false;
        document.getElementById("fecha_nacimiento").classList.add("is-invalid");
    } else {
        document.getElementById("fecha_nacimiento").classList.remove("is-invalid");
    }

    if (valid) {
        var modal = new bootstrap.Modal(document.getElementById('reservaConfirmadaModal'));
        modal.show();

        document.getElementById("reservaForm").submit();
    }
});

</script>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
