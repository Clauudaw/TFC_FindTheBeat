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
    <?php include_once './components/header.php'; ?>
    <br>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/index.php" class="breadcrumb-link">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Contacto</a></li>
  </ol>
</nav>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

    <div class="container my-5">
        <div class="row align-items-center">
            <h2 class="mb-3 text-center custom-title">¿Tienes alguna duda? Contáctanos</h2>
            <p class="text-center text-muted">
                Completa el formulario y te responderemos lo más rápido posible.  
                También puedes llamarnos al <strong>+34 612 345 678</strong>. <br>
                <span class="fw-bold">Horario de atención:</span> Lunes a Viernes, 9:00h - 18:00h.
            </p>

  
            <div class="col-md-4 mb-4 mb-md-0 text-center">
                <img src="/assets/images/contacto.jpg" alt="Contáctanos" class="img-fluid contact-img">
            </div>
            
            <div class="col-md-8">
                <form id="contactForm" class="contacto" action="process_contact.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa tu nombre">
                        <span id="nameError" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electrónico">
                        <span id="emailError" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Indica el asunto">
                        <span id="subjectError" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Escribe tu mensaje"></textarea>
                        <span id="messageError" class="text-danger"></span>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thankYouModalLabel"> ✅ ¡Mensaje Recibido!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Gracias por ponerte en contacto con nosotros, te llamaremos lo antes posible
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include './components/newsletter.php'?> 
    <div id="footer"></div>
    <div id="arrowup"></div>

    <!-- Bootstrap JS -->
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/app.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let contactForm = document.getElementById("contactForm");
            let thankYouModal = new bootstrap.Modal(document.getElementById("thankYouModal"));

            const nameRegex = /^[a-zA-Z\s]+$/; 
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            const subjectRegex = /.+/; 
            const messageRegex = /.+/;


            function validateForm() {
                let isValid = true;

  
                const name = document.getElementById("name");
                const nameError = document.getElementById("nameError");
                if (!name.value.match(nameRegex)) {
                    nameError.textContent = "El nombre solo puede contener letras y espacios.";
                    isValid = false;
                } else {
                    nameError.textContent = "";
                }


                const email = document.getElementById("email");
                const emailError = document.getElementById("emailError");
                if (!email.value.match(emailRegex)) {
                    emailError.textContent = "Por favor, ingresa un correo electrónico válido.";
                    isValid = false;
                } else {
                    emailError.textContent = "";
                }

                const subject = document.getElementById("subject");
                const subjectError = document.getElementById("subjectError");
                if (!subject.value.match(subjectRegex)) {
                    subjectError.textContent = "El asunto no debe de estar vacío.";
                    isValid = false;
                } else {
                    subjectError.textContent = "";
                }


                const message = document.getElementById("message");
                const messageError = document.getElementById("messageError");
                if (!message.value.match(messageRegex)) {
                    messageError.textContent = "El mensaje no puede estar vacío.";
                    isValid = false;
                } else {
                    messageError.textContent = "";
                }

                return isValid;
            }

            contactForm.addEventListener("submit", function (event) {
                event.preventDefault(); 

                if (validateForm()) {
                thankYouModal.show(); 

                document.querySelector(".btn-success[data-bs-dismiss='modal']").addEventListener("click", function() {
                    contactForm.submit();
                });
                
                }
            });
        });
    </script>

    <style>
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
