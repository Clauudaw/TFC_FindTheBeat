<?php
session_start();

// Conectar a la base de datos
include './db.php';
// Obtener el ID del espacio
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    die("Espacio no encontrado.");
}

// Obtener detalles del espacio
$stmt = $db->prepare("SELECT * FROM spaces WHERE id = :id");
$stmt->execute([':id' => $id]);
$space = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$space) {
    die("Espacio no encontrado.");
}

// Ruta base de las imágenes
$imagenBase = "assets/images/" . $space['tipo'] . "/" . $space['titulo'] . "/";

// Buscar imágenes en la carpeta (img1.png, img2.png, ..., img6.png)
$imagenes = [];
for ($i = 1; $i <= 6; $i++) {
    $rutaImagen = $imagenBase . "img{$i}.png";
    if (file_exists($rutaImagen)) {
        $imagenes[] = $rutaImagen;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles - <?php echo htmlspecialchars($space['titulo']); ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .detalle-container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .carousel-container {
            width: 40%;
            min-width: 300px;
        }

        .carousel img {
            border-radius: 10px;
        }

        .info-container {
            width: 60%;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .info-container h2 {
            color: #343a40;
        }

        .info-container p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            .detalle-container {
                flex-direction: column;
            }
            .carousel-container, .info-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php include './components/header.php'; ?>
<br>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/index.php" class="breadcrumb-link">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/espacios.php" class="breadcrumb-link">Explorar Espacios</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link"><?php echo htmlspecialchars($space['titulo']); ?></a></li>
  </ol>
</nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4"><?php echo htmlspecialchars($space['titulo']); ?></h1>
        
        <div class="detalle-container">
            <!-- Carrusel -->
            <div class="carousel-container">
                <?php if (!empty($imagenes)): ?>
                    <div id="carouselEspacio" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($imagenes as $index => $img): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo htmlspecialchars($img); ?>" class="d-block w-100">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Controles del carrusel -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselEspacio" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselEspacio" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                <?php else: ?>
                    <p>No hay imágenes disponibles para este espacio.</p>
                <?php endif; ?>
            </div>

            <!-- Información del Espacio -->
            <div class="info-container">
                <h2>Información del Espacio</h2>
                <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($space['provincia']); ?></p>
                <p><strong>Comunidad Autónoma:</strong> <?php echo htmlspecialchars($space['comunidad_autonoma']); ?></p>
                <p><strong>Dirección:</strong> <?php echo htmlspecialchars($space['direccion']); ?></p>
                <p><strong>Tipo:</strong> <?php echo htmlspecialchars($space['tipo']); ?></p>
                <p><strong>Capacidad:</strong> <?php echo htmlspecialchars($space['capacidad']); ?> personas</p>
                <p><strong>Precio:</strong> <?php echo htmlspecialchars($space['precio']); ?> €/hora</p>
                <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($space['descripcion'])); ?></p>

                <a href="espacios.php" class="btn btn-primary mt-3">Volver</a>
                <?php if (isset($_SESSION['user_id'])): ?>
    <a href="reservas.php?space_id=<?php echo $space['id']; ?>" class="btn btn-success mt-3 ms-2">Reservar</a>
<?php else: ?>
    <button class="btn btn-success mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#loginModal">Reservar</button>
<?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de inicio de sesión requerido -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Iniciar sesión requerido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        Debes iniciar sesión para poder hacer una reserva.
      </div>
      <div class="modal-footer">
        <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


    <?php
// Obtener comentarios del espacio
$stmt = $db->prepare("SELECT r.rating, r.comment, r.created_at, u.username FROM reviews r 
                      JOIN users u ON r.user_id = u.id 
                      WHERE r.space_id = :space_id ORDER BY r.created_at DESC");
$stmt->execute([':space_id' => $id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Sección de Comentarios -->
<div class="container mt-5">
    <h3 class="mb-4">Opiniones y Reseñas</h3>

    <!-- Mostrar comentarios existentes -->
    <?php if (!empty($reviews)): ?>
        <div class="list-group">
            <?php foreach ($reviews as $review): ?>
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($review['username']); ?></h5>
                    <p class="mb-1"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                    <div>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi <?php echo $i <= $review['rating'] ? 'bi-star-fill text-warning' : 'bi-star'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">Aún no hay comentarios. Sé el primero en dejar tu opinión.</p>
    <?php endif; ?>

    <!-- Formulario para dejar un comentario -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="card mt-4">
            <div class="card-header">Deja tu Reseña</div>
            <div class="card-body">
                <form action="procesar_review.php" method="POST">
                    <input type="hidden" name="space_id" value="<?php echo $id; ?>">
                    
                    <!-- Rating con estrellas -->
                    <div class="mb-3">
                        <label class="form-label">Calificación:</label>
                        <div id="rating-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star text-secondary" data-value="<?php echo $i; ?>"></i>
                            <?php endfor; ?>
                            <input type="hidden" name="rating" id="rating-value" required>
                        </div>
                    </div>

                    <!-- Cuadro de comentario -->
                    <div class="mb-3">
                        <label for="comment" class="form-label">Tu comentario:</label>
                        <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Reseña</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <p class="text-muted">Debes <a href="login.php">iniciar sesión</a> para dejar una reseña.</p>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('#rating-stars i');
    const ratingInput = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            resetStars();
            highlightStars(this.dataset.value);
        });

        star.addEventListener('click', function () {
            ratingInput.value = this.dataset.value;
        });

        star.addEventListener('mouseleave', function () {
            resetStars();
            highlightStars(ratingInput.value);
        });
    });

    function highlightStars(value) {
        stars.forEach(star => {
            if (star.dataset.value <= value) {
                star.classList.add('text-warning', 'bi-star-fill');
                star.classList.remove('text-secondary', 'bi-star');
            }
        });
    }

    function resetStars() {
        stars.forEach(star => {
            star.classList.add('text-secondary', 'bi-star');
            star.classList.remove('text-warning', 'bi-star-fill');
        });
    }
});
</script>

    <div id="newsletter"></div> <!-- Aquí se cargará el formulario de Newsletter -->
    <div id="footer"></div> <!-- Aquí se cargará el Footer -->
    <div id="arrowup"></div>


    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
