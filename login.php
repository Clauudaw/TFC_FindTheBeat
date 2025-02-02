<?php 
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = :username AND email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($password === $user['password']) {  
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
        
            header('Location: ' . ($user['role'] === 'admin' ? 'admin_dashboard.php' : 'index.php'));
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - FindTheBeat</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
  <style>
    body {
      background-color: #f4f4f4;
    }
    .login-container {
      max-width: 600px;
      margin: 3.5em auto;
      padding: 2rem;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .btn-custom {
      background-color: #3D8168;
      color: white;
    }
    .btn-custom:hover {
      background-color: #2e634e;
      color: white;
    }
    .card-header {
      background-color: #3D8168;
      color: white;
      text-align: center;
    }
    .links a {
      display: block;
      text-align: center;
      margin-top: 10px;
      color: #3D8168;
    }
  </style>
</head>
<body>
<?php include 'components/header.php'; ?> 
<div class="container mt-5">
  <div class="login-container">
    <div class="card">
      <div class="card-header">
        <h3>Iniciar Sesión</h3>
      </div>
      <div class="card-body">
        <?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" required>
              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <button type="submit" class="btn btn-custom w-100">Iniciar Sesión</button>
        </form>
      </div>
      <div class="text-center mt-3">
        <a href="register.php">¿No tienes cuenta? Regístrate</a>
      </div>
      <div class="text-center mt-2">
        <a href="/index.php" class="btn btn-secondary w-50">Volver</a> 
      </div>
      <br>
    </div>
  </div>
</div>
<div id="footer"></div>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>
