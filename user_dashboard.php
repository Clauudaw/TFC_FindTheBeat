<?php
// Comprobar si el usuario está autenticado
session_start();
require_once 'db.php';

// Asegúrate de que la sesión está activa y que el usuario tiene el rol de 'normal'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'normal') {
    header('Location: login.php'); // Redirige al login si no es usuario normal
    exit();
}

// Verifica si el usuario es admin o normal
$is_normal = $_SESSION['role'] === 'normal';
$user_id = $_SESSION['user_id'];

// Función para obtener la información de los usuarios
function fetchUser($db, $user_id) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para obtener las reservas de un usuario
function fetchUserBookings($db, $user_id) {
    $stmt = $db->prepare("SELECT * FROM bookings WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener los comentarios de un usuario
function fetchUserReviews($db, $user_id) {
    $stmt = $db->prepare("SELECT * FROM reviews WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Si el usuario es normal, puede ver solo su información
if ($is_normal) {
    $user = fetchUser($db, $user_id);
}

$bookings = fetchUserBookings($db, $user_id);
$reviews = fetchUserReviews($db, $user_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Usuario</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<div class="container mt-5">
    <h2>Bienvenido al Panel de Usuario</h2>
    <p>Has iniciado sesión correctamente como <?= $_SESSION['role']; ?>.</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#profile" class="list-group-item list-group-item-action" data-bs-toggle="tab">Mi Perfil</a>
                <a href="#bookings" class="list-group-item list-group-item-action" data-bs-toggle="tab">Mis Reservas</a>
                <a href="#reviews" class="list-group-item list-group-item-action" data-bs-toggle="tab">Mis Reseñas</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
                <!-- Mi Perfil -->
                <div class="tab-pane fade show active" id="profile">
                    <h3>Mi Perfil</h3>
                    <!-- Solo el usuario puede editar su propio perfil -->
                    <form action="update_user.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Información</button>
                    </form>
                </div>

                <!-- Mis Reservas -->
                <div class="tab-pane fade" id="bookings">
                    <h3>Mis Reservas</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Espacio</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?= $booking['id']; ?></td>
                                    <td><?= $booking['space_id']; ?></td>
                                    <td><?= $booking['reservation_date']; ?></td>
                                    <td><?= $booking['status']; ?></td>
                                    <td>
                                        <a href="cancel_booking.php?id=<?= $booking['id']; ?>" class="btn btn-danger btn-sm">Cancelar Reserva</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mis Reseñas -->
                <div class="tab-pane fade" id="reviews">
                    <h3>Mis Reseñas</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Espacio</th>
                                <th>Comentario</th>
                                <th>Calificación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $review): ?>
                                <tr>
                                    <td><?= $review['id']; ?></td>
                                    <td><?= $review['space_id']; ?></td>
                                    <td><?= $review['comment']; ?></td>
                                    <td><?= $review['rating']; ?></td>
                                    <td>
                                        <a href="edit_review.php?id=<?= $review['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="delete_review.php?id=<?= $review['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>