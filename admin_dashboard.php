<?php
session_start();
require_once 'db.php'; // Conexión a la base de datos

// Verifica que el usuario es admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

function fetchAll($db, $table) {
  $stmt = $db->prepare("SELECT * FROM $table");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$users = fetchAll($db, 'users');
$spaces = fetchAll($db, 'spaces');
$reviews = fetchAll($db, 'reviews');
$bookings = fetchAll($db, 'bookings');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  
</head>
<body>

<?php include 'components/header.php'; ?> 

<div class="container mt-5">
    <h2>Bienvenido al Panel de Administración</h2>
    <p>Has iniciado sesión correctamente como administrador.</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#users" class="list-group-item list-group-item-action" data-bs-toggle="tab">Usuarios</a>
                <a href="#spaces" class="list-group-item list-group-item-action" data-bs-toggle="tab">Espacios</a>
                <a href="#reviews" class="list-group-item list-group-item-action" data-bs-toggle="tab">Reseñas</a>
                <a href="#bookings" class="list-group-item list-group-item-action" data-bs-toggle="tab">Reservas</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Tabla de Usuarios -->
                <div class="tab-pane fade show active" id="users">
                    <h3>Usuarios</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Creado el</th>
                                <th>Actualizado el</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id']; ?></td>
                                    <td><?= $user['username']; ?></td>
                                    <td><?= $user['email']; ?></td>
                                    <td><?= $user['role']; ?></td>
                                    <td><?= $user['created_at']; ?></td>
                                    <td><?= $user['updated_at']; ?></td>
                                    <td>
                                        <a href="edit_user.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="delete_user.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Formulario para Crear Usuario -->
                <h4>Crear Usuario</h4>
                    <form action="create_user.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Rol</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </form>
                </div>
                
                <!-- Tabla de Espacios -->
                <div class="tab-pane fade" id="spaces">
                    <h3>Espacios</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Dirección</th>
                                <th>Provincia</th>
                                <th>Comunidad Autónoma</th>
                                <th>Capacidad</th>
                                <th>Tipo</th>
                                <th>Creado el</th>
                                <th>Actualizado el</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($spaces as $space): ?>
                                <tr>
                                    <td><?= $space['id']; ?></td>
                                    <td><?= $space['titulo']; ?></td>
                                    <td><?= $space['descripcion']; ?></td>
                                    <td><?= $space['precio']; ?>€</td>
                                    <td><?= $space['direccion']; ?></td>
                                    <td><?= $space['provincia']; ?></td>
                                    <td><?= $space['comunidad_autonoma']; ?></td>
                                    <td><?= $space['capacidad']; ?></td>
                                    <td><?= $space['tipo']; ?></td>
                                    <td><?= $space['created_at']; ?></td>
                                    <td><?= $space['updated_at']; ?></td>
                                    <td>
                                        <a href="edit_space.php?id=<?= $space['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="delete_space.php?id=<?= $space['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Formulario para Crear Espacio -->
                <h4>Crear Espacio</h4>
                    <form action="create_space.php" method="POST">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio (€)</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="provincia" class="form-label">Provincia</label>
                            <input type="text" class="form-control" id="provincia" name="provincia" required>
                        </div>
                        <div class="mb-3">
                            <label for="comunidad_autonoma" class="form-label">Comunidad Autónoma</label>
                            <input type="text" class="form-control" id="comunidad_autonoma" name="comunidad_autonoma" required>
                        </div>
                        <div class="mb-3">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="number" class="form-control" id="capacidad" name="capacidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="salon">Salón</option>
                                <option value="auditorio">Auditorio</option>
                                <option value="estudio">Estudio</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Espacio</button>
                    </form>
                </div>

                <!-- Tabla de Reseñas -->
                <div class="tab-pane fade" id="reviews">
                    <h3>Reseñas</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Espacio</th>
                                <th>Rating</th>
                                <th>Comentario</th>
                                <th>Creado el</th>
                                <th>Actualizado el</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $review): ?>
                                <tr>
                                    <td><?= $review['id']; ?></td>
                                    <td><?= $review['user_id']; ?></td>
                                    <td><?= $review['space_id']; ?></td>
                                    <td><?= $review['rating']; ?></td>
                                    <td><?= $review['comment']; ?></td>
                                    <td><?= $review['created_at']; ?></td>
                                    <td><?= $review['updated_at']; ?></td>
                                    <td>
                                        <a href="delete_review.php?id=<?= $review['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Formulario para añadir una nueva reseña -->
<div class="mt-4">
    <h4>Añadir Nueva Reseña</h4>
    <form action="add_review.php" method="POST">
        <div class="mb-3">
            <label for="user_id" class="form-label">ID de Usuario</label>
            <input type="number" class="form-control" id="user_id" name="user_id" required>
        </div>
        <div class="mb-3">
            <label for="space_id" class="form-label">ID de Espacio</label>
            <input type="number" class="form-control" id="space_id" name="space_id" required>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Calificación</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Comentario</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Añadir Reseña</button>
    </form>
</div>

                
                <!-- Tabla de Reservas -->
                <div class="tab-pane fade" id="bookings">
                    <h3>Reservas</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Espacio</th>
                                <th>Estado</th>
                                <th>Fecha de Reserva</th>
                                <th>Hora de Inicio</th>
                                <th>Hora de Fin</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Teléfono</th>
                                <th>Método de Pago</th>
                                <th>Creado el</th>
                                <th>Actualizado el</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?= $booking['id']; ?></td>
                                    <td><?= $booking['user_id']; ?></td>
                                    <td><?= $booking['space_id']; ?></td>
                                    <td><?= $booking['estado']; ?></td>
                                    <td><?= $booking['fecha_reserva']; ?></td>
                                    <td><?= $booking['hora_inicio']; ?></td>
                                    <td><?= $booking['hora_fin']; ?></td>
                                    <td><?= $booking['nombre']; ?></td>
                                    <td><?= $booking['apellidos']; ?></td>
                                    <td><?= $booking['dni']; ?></td>
                                    <td><?= $booking['correo']; ?></td>
                                    <td><?= $booking['fecha_nacimiento']; ?></td>
                                    <td><?= $booking['telefono']; ?></td>
                                    <td><?= $booking['metodo_pago']; ?></td>
                                    <td><?= $booking['created_at']; ?></td>
                                    <td><?= $booking['updated_at']; ?></td>
                                    <td>
                                        <a href="edit_booking.php?id=<?= $booking['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="delete_booking.php?id=<?= $booking['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Formulario para añadir una nueva reserva -->
<div class="mt-4">
    <h4>Añadir Nueva Reserva</h4>
    <form action="add_booking.php" method="POST">
        <div class="mb-3">
            <label for="user_id" class="form-label">ID de Usuario</label>
            <input type="number" class="form-control" id="user_id" name="user_id" required>
        </div>
        <div class="mb-3">
            <label for="space_id" class="form-label">ID de Espacio</label>
            <input type="number" class="form-control" id="space_id" name="space_id" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="pendiente">Pendiente</option>
                <option value="confirmada">Confirmada</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_reserva" class="form-label">Fecha de Reserva</label>
            <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" required>
        </div>
        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
        </div>
        <div class="mb-3">
            <label for="hora_fin" class="form-label">Hora de Fin</label>
            <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de Pago</label>
            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                <option value="tarjeta">Tarjeta</option>
                <option value="paypal">PayPal</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Añadir Reserva</button>
    </form>
</div>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
    // Función para confirmar la eliminación
    function confirmDelete(event) {
        // Evitar que el enlace se ejecute automáticamente
        event.preventDefault();

        // Mostrar la alerta de confirmación
        const isConfirmed = confirm("¿Estás seguro? No podrás deshacer esta acción.");

        // Si el usuario confirma, redirige a la URL de eliminación
        if (isConfirmed) {
            window.location.href = event.target.href;
        }
    }

    // Añadir el evento a todos los botones de eliminar
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', confirmDelete);
    });
</script>

</body>
</html>