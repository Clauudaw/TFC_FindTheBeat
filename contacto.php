<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - FindTheBeat</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include_once './components/header.php' ?>

    <div class="container my-5">
        <div class="row align-items-center">
            <!-- Imagen a la izquierda -->
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="/assets/images/contacto.jpg" alt="Contáctanos" class="img-fluid rounded shadow">
            </div>
            
            <!-- Formulario a la derecha -->
            <div class="col-md-6">
                <h2 class="mb-4">Contáctanos</h2>
                <form action="procesar_contacto.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>

    <div id="newsletter"></div> <!-- Aquí se cargará el formulario de Newsletter -->
    <div id="footer"></div> <!-- Aquí se cargará el Footer -->
    <div id="arrowup"></div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
    <style>
        /* Estilos adicionales para el formulario */
form {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Botón verde personalizado */
.btn-success {
    background-color: #3D8168;
    border: none;
}

.btn-success:hover {
    background-color: #2b5e4c;
}

    </style>
</body>
</html>
