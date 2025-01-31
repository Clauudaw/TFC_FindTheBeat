<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$username, $email, $role, $id]);

       // Guardar mensaje en sesión y redirigir
       $_SESSION['success'] = "✅ Se ha editado el usuario con exito.";
       header('Location: admin_dashboard.php');
       exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Editar Usuario</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-light">
<?php include './components/header.php' ?><br>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin_dashboard.php" class="breadcrumb-link">Panel de Administración</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Editar usuario</a></li>
  </ol>
</nav>

    <div class="container d-flex justify-content-center align-items-center my-5">
        <div class="col-md-6">
            <div class="card shadow-sm rounded p-4">
                <h3 class="mb-4 text-center">Editar Usuario</h3>
                <form action="edit_user.php" method="POST">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" 
                               value="<?= $user['username']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="<?= $user['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Rol</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="normal" <?= $user['role'] === 'normal' ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>

                    <button type="submit" class="btn w-100 text-white" style="background-color: #3D8168; padding: 10px 20px; border: none; cursor: pointer;"
        onmouseover="this.style.backgroundColor='#2C614E'"
        onmouseout="this.style.backgroundColor='#3D8168'">Actualizar Usuario</button>
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
