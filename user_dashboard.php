<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'normal') {
    echo "<script>window.location.href='login.php';</script>";
}

$is_normal = $_SESSION['role'] === 'normal';
$user_id = $_SESSION['user_id'];

function fetchUser($db, $user_id)
{
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchUserBookings($db, $user_id)
{
    $stmt = $db->prepare("
        SELECT 
            b.id,
            b.user_id,
            b.space_id,
            b.estado,
            b.created_at,
            b.nombre,
            b.apellidos,
            b.dni,
            b.correo,
            b.fecha_nacimiento,
            b.telefono,
            b.metodo_pago,
            b.fecha_reserva,
            b.hora_inicio,
            b.hora_fin,
            s.titulo AS space_title  -- Aquí obtenemos el título del espacio
        FROM bookings b
        JOIN spaces s ON b.space_id = s.id  -- Realizamos un JOIN con la tabla 'spaces'
        WHERE b.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchUserReviews($db, $user_id)
{
    $stmt = $db->prepare("
        SELECT 
            r.id, 
            r.space_id, 
            r.comment, 
            r.rating, 
            s.titulo AS space_title  -- Obtenemos el nombre del espacio
        FROM reviews r
        JOIN spaces s ON r.space_id = s.id  -- Hacemos JOIN con la tabla spaces
        WHERE r.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


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
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>

    <?php include 'components/header.php'; ?>
    <br>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="container mt-5">
        <h2>Bienvenido al Panel de Usuario</h2>

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
                    <div class="tab-pane fade show active" id="profile">
                        <h3>Mi Perfil</h3>
                        <form action="update_user.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" value="<?= $user['password']; ?>" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Actualizar Información</button>
                        </form><br>
                    </div>

                    <div class="tab-pane fade" id="bookings">
                        <h3>Mis Reservas</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
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
                                    <th>Fecha de Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td><?= $booking['space_title']; ?></td> 
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
                                        <td>
                                            <a href="delete_booking.php?id=<?= $booking['id']; ?>" class="btn btn-danger btn-sm">Cancelar Reserva</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>

                    <div class="tab-pane fade" id="reviews">
                        <h3>Mis Reseñas</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Espacio</th>
                                    <th>Comentario</th>
                                    <th>Calificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reviews as $review): ?>
                                    <tr>
                                        <td><?= $review['space_title']; ?></td>
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
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>


</body>
<style>
@media (max-width: 768px) {
    h3 {
        margin-top: 20px; /* Ajusta el valor según sea necesario */
    }
}
</style>



</html>