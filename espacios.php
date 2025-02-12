<?php
session_start();
include './db.php';

$provincia = isset($_GET['provincia']) ? $_GET['provincia'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

$query = "SELECT * FROM spaces WHERE 1=1";
$params = [];

if ($provincia) {
    $query .= " AND provincia = :provincia";
    $params[':provincia'] = $provincia;
}
if ($tipo) {
    $query .= " AND tipo = :tipo";
    $params[':tipo'] = $tipo;
}

try {
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log('Error al ejecutar la consulta: ' . $e->getMessage());
    echo json_encode(['error' => 'Hubo un problema al cargar los espacios.']);
    exit;
}


if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode($spaces);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindTheBeat - Espacios</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include_once './components/header.php'; ?>
    <br>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/index.php" class="breadcrumb-link">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/espacios.php" class="breadcrumb-link">Explorar Espacios</a></li>
        </ol>
    </nav>

    <div class="filtros container my-4">
        <div class="row justify-content-center">
            <div class="col-md-3 col-sm-4 mb-3">
                <select id="filterProvincia" class="form-select form-select-sm mx-auto">
                    <option value="" selected disabled>Seleccione una provincia</option>
                    <option value="">Cualquiera</option>
                    <option value="Madrid">Madrid</option>
                    <option value="Sevilla">Sevilla</option>
                    <option value="Barcelona">Barcelona</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-4 mb-3">
                <select id="filterTipo" class="form-select form-select-sm mx-auto">
                    <option value="" selected disabled>Seleccione un tipo de espacio</option>
                    <option value="">Cualquiera</option>
                    <option value="ensayo">Sala de ensayo</option>
                    <option value="grabacion">Estudio de grabación</option>
                    <option value="eventos">Sala de eventos</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-4 mb-3">
                <button id="applyFilters" class="btn btn-primary btn-sm w-100 mx-auto">Aplicar filtros</button>
            </div>
        </div>
    </div>

    <div id="spaces" class="espacios container my-4 col-12 row">
        <?php foreach ($spaces as $space): ?>
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card" style="width: 100%; max-width: 450px;">
                    <img src="<?php echo htmlspecialchars($space['imagen']); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($space['titulo']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($space['titulo']); ?></h5>
                        <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($space['provincia']); ?></p>
                        <p><strong>Tipo:</strong> <?php echo htmlspecialchars($space['tipo']); ?></p>
                        <p><strong>Precio:</strong> <?php echo htmlspecialchars($space['precio']); ?> €/hora</p>
                        <a href="detalles.php?id=<?php echo $space['id']; ?>" class="btn btn-primary btn-sm">Ver más</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="newsletter"></div>
    <div id="footer"></div>
    <div id="arrowup"></div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>

    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body .btn {
            margin-top: auto;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.30);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .card {
            min-height: 350px;
        }

        .espacios {
            margin-left: 3em;
        }

        @media (max-width: 1024px) {
            .espacios {
                margin: auto;
            }
        }
    </style>

</body>

</html>