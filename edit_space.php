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
    <title>Editar Espacio</title>
</head>
<body>
    <h3>Editar Espacio</h3>
    <form action="edit_space.php" method="POST">
        <input type="hidden" name="id" value="<?= $space['id']; ?>">
        <div>
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?= $space['titulo']; ?>" required>
        </div>
        <div>
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required><?= $space['descripcion']; ?></textarea>
        </div>
        <div>
            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" value="<?= $space['precio']; ?>" required>
        </div>
        <div>
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" value="<?= $space['direccion']; ?>" required>
        </div>
        <div>
            <label for="provincia">Provincia</label>
            <input type="text" id="provincia" name="provincia" value="<?= $space['provincia']; ?>" required>
        </div>
        <div>
            <label for="comunidad_autonoma">Comunidad Autónoma</label>
            <input type="text" id="comunidad_autonoma" name="comunidad_autonoma" value="<?= $space['comunidad_autonoma']; ?>" required>
        </div>
        <div>
            <label for="capacidad">Capacidad</label>
            <input type="number" id="capacidad" name="capacidad" value="<?= $space['capacidad']; ?>" required>
        </div>
        <div>
            <label for="tipo">Tipo</label>
            <select id="tipo" name="tipo" required>
                <option value="grabación" <?= $space['tipo'] === 'grabación' ? 'selected' : ''; ?>>Estudio de Grabación</option>
                <option value="ensayo" <?= $space['tipo'] === 'ensayo' ? 'selected' : ''; ?>>Sala de Ensayo</option>
                <option value="eventos" <?= $space['tipo'] === 'eventos' ? 'selected' : ''; ?>>Sala de Eventos</option>
            </select>
        </div>
        <button type="submit">Actualizar Espacio</button>
    </form>
</body>
</html>
