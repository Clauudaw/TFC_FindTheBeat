<?php 
session_start();
include 'db.php';

// Inicializar variables de mensaje
$mensaje = "";
$tipo_mensaje = "";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Verificar si el usuario o email ya existen
    $sql_check = "SELECT id FROM users WHERE username = :username OR email = :email";
    $stmt_check = $db->prepare($sql_check);
    $stmt_check->bindParam(':username', $username);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        $mensaje = "❌ Error: El usuario o el correo ya están registrados.";
        $tipo_mensaje = "danger";
    } else {
        $role = 'normal'; // Por defecto, usuario normal

        // Insertar usuario en la base de datos
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); 
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            $mensaje = "✅ Registro exitoso. Ahora puedes <a href='/login.php' class='alert-link'>iniciar sesión</a>.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "❌ Error en el registro.";
            $tipo_mensaje = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - FindTheBeat</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <style>
    body {
      background-color: #f4f4f4;
    }
    .register-container {
      max-width: 600px;
      margin:  3.5em auto;
      padding: 2rem;
      background: white;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .btn-register {
      background-color: #3D8168;
      border: white;
      color: white;
    }
    .btn-register:hover {
      background-color: #2e634e;
      color: white;
    }
    .btn-back {
      background-color: #6c757d;
      color: white;
      border: none;
    }
    .card-header {
      background-color: #3D8168;
      color: white;
      text-align: center;
    }
    .btn-back:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>
<?php include 'components/header.php'; ?> 

<div class="container">
  <div class="register-container">
  <div class="card">
  <div class="card-header">
        <h3>Registro</h3>
      </div>
        <div class="card-body">
    <?php if (!empty($mensaje)) echo "<div class='alert alert-$tipo_mensaje'>$mensaje</div>"; ?>
    <form action="register.php" method="POST">
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
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-register w-100">Registrarse</button>
    </form>
    <div class="text-center mt-3">
      <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
    <div class="text-center mt-2">
      <a href="/index.php" class="btn btn-back w-50">Volver</a>
    </div>
    </div>
  </div>
  </div>
</div>
<div id="footer"></div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
