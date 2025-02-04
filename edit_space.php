<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $direccion = $_POST['direccion'];
    $provincia = $_POST['provincia'];
    $comunidad_autonoma = $_POST['comunidad_autonoma'];
    $capacidad = $_POST['capacidad'];
    $tipo = $_POST['tipo'];

    $stmt = $db->prepare("UPDATE spaces SET titulo = ?, descripcion = ?, precio = ?, direccion = ?, provincia = ?, comunidad_autonoma = ?, capacidad = ?, tipo = ? WHERE id = ?");
    $stmt->execute([$titulo, $descripcion, $precio, $direccion, $provincia, $comunidad_autonoma, $capacidad, $tipo, $id]);

     // Guardar mensaje y redirigir
     $_SESSION['success'] = "✅ Se ha editado el espacio con exito.";
     header('Location: admin_dashboard.php');
     exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM spaces WHERE id = ?");
    $stmt->execute([$id]);
    $space = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: admin_dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Espacio</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-light">
<?php include './components/header.php' ?><br>

<!-- Breadcrumb de navegación -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin_dashboard.php" class="breadcrumb-link">Panel de Administración</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Editar Espacio</a></li>
  </ol>
</nav>

<div class="container d-flex justify-content-center align-items-center my-5">
    <div class="col-md-6">
        <div class="card shadow-sm rounded p-4">
            <h3 class="mb-4 text-center">Editar Espacio</h3>
            <form action="edit_space.php" method="POST">
                <input type="hidden" name="id" value="<?= $space['id']; ?>">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" 
                           value="<?= $space['titulo']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required><?= $space['descripcion']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio (€)</label>
                    <input type="number" id="precio" name="precio" class="form-control"
                           value="<?= $space['precio']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" id="direccion" name="direccion" class="form-control"
                           value="<?= $space['direccion']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="provincia" class="form-label">Provincia</label>
                    <input type="text" id="provincia" name="provincia" class="form-control"
                           value="<?= $space['provincia']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="comunidad_autonoma" class="form-label">Comunidad Autónoma</label>
                    <input type="text" id="comunidad_autonoma" name="comunidad_autonoma" class="form-control"
                           value="<?= $space['comunidad_autonoma']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="capacidad" class="form-label">Capacidad</label>
                    <input type="number" id="capacidad" name="capacidad" class="form-control"
                           value="<?= $space['capacidad']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="grabación" <?= $space['tipo'] === 'grabación' ? 'selected' : ''; ?>>Estudio de Grabación</option>
                        <option value="ensayo" <?= $space['tipo'] === 'ensayo' ? 'selected' : ''; ?>>Sala de Ensayo</option>
                        <option value="eventos" <?= $space['tipo'] === 'eventos' ? 'selected' : ''; ?>>Sala de Eventos</option>
                    </select>
                </div>

                <button type="submit" class="btn w-100 text-white" style="background-color: #3D8168; padding: 10px 20px; border: none; cursor: pointer;"
        onmouseover="this.style.backgroundColor='#2C614E'"
        onmouseout="this.style.backgroundColor='#3D8168'">Actualizar Espacio</button>
            </form>
        </div>
    </div>
</div>

<div id="footer"></div>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
