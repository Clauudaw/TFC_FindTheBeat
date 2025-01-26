<?php session_start(); ?>
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
            <h2 class="mb-3 text-center custom-title">¿Tienes alguna duda? Contáctanos</h2>
            <p class="text-center text-muted">
                Completa el formulario y te responderemos lo más rápido posible.  
                También puedes llamarnos al <strong>+34 612 345 678</strong>. <br>
                <span class="fw-bold">Horario de atención:</span> Lunes a Viernes, 9:00h - 18:00h.
            </p>

            <!-- Imagen a la izquierda -->
            <div class="col-md-4 mb-4 mb-md-0 text-center">
                <img src="/assets/images/contacto.jpg" alt="Contáctanos" class="img-fluid contact-img">
            </div>
            
            <!-- Formulario a la derecha -->
            <div class="col-md-8">
                <form id="contactForm" class="contacto">
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

    <!-- Modal de confirmación -->
    <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thankYouModalLabel">¡Mensaje Recibido!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Gracias por ponerte en contacto con nosotros, te llamaremos lo antes posible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="newsletter"></div> 
    <div id="footer"></div>
    <div id="arrowup"></div>

    <!-- Bootstrap JS -->
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/app.js"></script>
    
    
    <style>
        /* Estilos adicionales */
        .contacto {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .contact-img {
            max-width: 250px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 10px;
        }

        .custom-title {
            color: #3D8168;
            font-weight: bold;
        }

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
