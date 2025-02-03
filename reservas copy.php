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
                <!-- Caja de la izquierda -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <img src="<?php echo $space['imagen']; ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $space['titulo']; ?></h5>
                            <p class="card-text"><?php echo $space['descripcion']; ?></p>
                            <p class="card-text"><strong>Precio:</strong> €<?php echo $space['precio']; ?></p>
                        </div>
                    </div>
                </div>
                <!-- Formulario de reserva -->
                <div class="col-md-8">
                <div class="card shadow p-4">
                <h1 class="text-center mb-4">Reservar este Espacio</h1>
                
                <form id="reservationForm" method="POST">
                <div class="row">
    <div class="col-md-6 mb-3 form-floating">
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre">
        <label for="nombre">Nombre</label>
        <span id="nombreError" class="text-danger"></span>
    </div>
    <div class="col-md-6 mb-3 form-floating">
        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingresa tus apellidos">
        <label for="apellidos">Apellidos</label>
        <span id="apellidosError" class="text-danger"></span>
    </div>
    <div class="col-md-6 mb-3 form-floating">
        <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingresa tu DNI">
        <label for="dni">DNI</label>
        <span id="dniError" class="text-danger"></span>
    </div>
    <div class="col-md-6 mb-3 form-floating">
        <input type="text" class="form-control" id="correo" name="correo" placeholder="Ingresa tu correo electrónico">
        <label for="correo">Correo Electrónico</label>
        <span id="correoError" class="text-danger"></span>
    </div>
    <div class="col-md-6 mb-3 form-floating">
        <input type="date" class="form-control" id="fecha_nacimiento" required>
        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
        <span id="edadError" class="text-danger"></span>
    </div>
    <div class="col-md-6 mb-3 form-floating">
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresa tu número de teléfono">
        <label for="telefono">Teléfono</label>
        <span id="telefonoError" class="text-danger"></span>
    </div>
</div>

    <div class="mb-3 form-floating">
        <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva">
        <label for="fecha_reserva">Fecha de Reserva</label>
    </div>
    <div class="row"> 
    1<div class="col-md-6 mb-3 form-floating">
        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
        <label for="hora_inicio">Hora de Inicio</label>
    </div>
    <div class="col-md-6 mb-3 form-floating">
        <input type="time" class="form-control" id="hora_fin" name="hora_fin">
        <label for="hora_fin">Hora de Fin</label>
    </div>
</div>
   
    <div class="mb-3 form-floating">
        <select class="form-control" id="metodo_pago" name="metodo_pago">
        <option value="" selected disabled>Selecciona una opción</option>
            <option value="tarjeta">Tarjeta</option>
            <option value="paypal">PayPal</option>
            <option value="Bizum">Bizum</option>
        </select>
        <label for="metodo_pago">Método de Pago</label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Confirmar Reserva</button>
</form>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer"></div>

<!-- Modal de confirmación -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="thankYouModalLabel">¡Reserva Confirmada!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tu reserva ha sido realizada exitosamente. Puedes verla en tu <a href="./user_dashboard.php">panel personal</a>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('reservationForm');
    const thankYouModal = new bootstrap.Modal(document.getElementById('thankYouModal'));

    const nameRegex = /^[a-zA-Z\s]+$/;
    const dniRegex = /^[0-9]{8}[A-Za-z]$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    const phoneRegex = /^[0-9]{9}$/;

    function validateForm() {
        let isValid = true;

        const nombre = document.getElementById('nombre');
        const nombreError = document.getElementById('nombreError');
        if (!nombre.value.match(nameRegex)) {
            nombreError.textContent = "El nombre solo puede contener letras y espacios.";
            isValid = false;
        } else {
            nombreError.textContent = "";
        }

        const apellidos = document.getElementById('apellidos');
        const apellidosError = document.getElementById('apellidosError');
        if (!apellidos.value.match(nameRegex)) {
            apellidosError.textContent = "Los apellidos solo pueden contener letras y espacios.";
            isValid = false;
        } else {
            apellidosError.textContent = "";
        }

        const dni = document.getElementById('dni');
        const dniError = document.getElementById('dniError');
        if (!dni.value.match(dniRegex)) {
            dniError.textContent = "Introduce un DNI válido.";
            isValid = false;
        } else {
            dniError.textContent = "";
        }

        const correo = document.getElementById('correo');
        const correoError = document.getElementById('correoError');
        if (!correo.value.match(emailRegex)) {
            correoError.textContent = "Introduce un correo electrónico válido.";
            isValid = false;
        } else {
            correoError.textContent = "";
        }

        const telefono = document.getElementById('telefono');
        const telefonoError = document.getElementById('telefonoError');
        if (!telefono.value.match(phoneRegex)) {
            telefonoError.textContent = "Introduce un número de teléfono válido.";
            isValid = false;
        } else {
            telefonoError.textContent = "";
        }

        const fechaNacimiento = document.getElementById('fecha_nacimiento');
        const edadError = document.getElementById('edadError');

        const birthDate = new Date(fechaNacimiento.value);
        const currentDate = new Date();
        const age = currentDate.getFullYear() - birthDate.getFullYear();
        const month = currentDate.getMonth() - birthDate.getMonth();
        const day = currentDate.getDate() - birthDate.getDate();

        // Ajustar la edad si aún no ha cumplido años este año
        if (month < 0 || (month === 0 && day < 0)) {
            age--;
        }

        if (age < 18) {
            edadError.textContent = "Debes ser mayor de 18 años.";
            isValid = false; // Marcar como inválido si no es mayor de 18 años
        } else {
            edadError.textContent = "";
        }

        return isValid;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        if (validateForm()) {
            // Aquí puedes enviar los datos al servidor si es necesario
            thankYouModal.show();

            // Agregar el evento de clic en el botón "Aceptar"
            document.querySelector(".btn-success[data-bs-dismiss='modal']").addEventListener("click", function() {
                form.submit();  // Enviar el formulario cuando el usuario haga clic en "Aceptar"
            });
        }
    });
});

</script>


</body>
</html>
