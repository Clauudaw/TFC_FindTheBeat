<?php
include './db.php';
include './components/header.php';

// Obtener los espacios destacados (IDs 1, 5 y 9)
$query = "SELECT * FROM spaces WHERE id IN (1, 5, 9)";
$stmt = $db->prepare($query);
$stmt->execute();
$featuredSpaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindTheBeat - Destacados</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- Destacados Section -->
<div class="container my-5">
    <div class="destacados">
        <h2 class="text-center mb-4">Descubre los espacios más populares</h2>
        <div class="row">
            <?php foreach ($featuredSpaces as $space): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($space['imagen']); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($space['titulo']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($space['titulo']); ?></h5>
                            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($space['provincia']); ?></p>
                            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($space['tipo']); ?></p>
                            <p><strong>Precio:</strong> <?php echo htmlspecialchars($space['precio']); ?> €/hora</p>
                            <a href="detalles.php?id=<?php echo $space['id']; ?>" class="btn btn-primary w-100">Reservar ahora</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>

<style>
    .destacados {
        margin: 5em 0;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        display: flex;
        flex-direction: column;
        height: 100%; /* Hace que todas las tarjetas tengan la misma altura */
    }
    .card-body {
        flex-grow: 1; /* Hace que el contenido crezca para llenar el espacio disponible */
        display: flex;
        flex-direction: column;
    }
    .card-body .btn {
        margin-top: auto; /* Hace que el botón se empuje hacia el fondo de la tarjeta */
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.30);
    }

    /* Asegurarse de que las tarjetas tengan al menos la misma altura */
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    /* Opcional: Poner un mínimo de altura para las tarjetas */
    .card {
        min-height: 350px;
    }
</style>



</body>
</html>
