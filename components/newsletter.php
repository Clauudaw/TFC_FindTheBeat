<style>
   /* Estilos personalizados para el modal de la newsletter */
.modal-newsletter .modal-content {
  border-radius: 10px;
  border: 2px solid rgb(53, 112, 90);
}

@media (max-width: 1024px) {
  .newsletter {
    margin: 0 1em;
  }
}

.modal-newsletter .modal-header {
  background-color: #3D8168;
  color: white;
}

.modal-newsletter .modal-footer button {
  background-color: rgb(126, 126, 126);
  color: white;
  border-radius: 5px;
}

.modal-newsletter .modal-footer button:hover {
  background-color: rgb(114, 114, 114);
}

.modal-newsletter .modal-body {
  font-size: 16px;
  color: #555;
}

.modal-newsletter .modal-title {
  font-weight: bold;
}

.modal-newsletter .modal-icon {
  font-size: 3rem;
  color: #28a745;
  margin-right: 10px;
}

  </style>
<section class="py-5 bg-light text-center">
    <div class="newsletter" id="newsletter">
      <h3>Suscríbete a nuestro boletín</h3>
      <p>Recibe las últimas novedades y ofertas especiales en tu correo.</p>
      <form class="d-flex justify-content-center mt-3" id="newsletter-form">
        <input type="email" class="form-control w-50" id="newsletteremail" placeholder="Ingresa tu correo" required>
        <button type="button" class="btn btn-primary ms-3" id="subscribeButton" onclick="showAlert()">Suscribirme</button>
      </form>
    </div>
  </section>


  <!-- Modal -->
  <div class="modal fade modal-newsletter" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="alertModalLabel">
            <i class="modal-icon fas fa-check-circle"></i>Suscripción Exitosa
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalMessage">
          <!-- Aquí se mostrará el mensaje del modal -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script JS -->
  <script>
    // Función que muestra el modal con el mensaje adecuado
    function showAlert() {
      const email = document.getElementById('newsletteremail').value.trim(); // Obtener el correo ingresado
      console.log('Correo ingresado:', email); // Verificamos que se esté obteniendo el correo

      let message = '';
      if (email) {
        message = `¡Gracias por suscribirte! Hemos enviado un correo de confirmación a ${email}.`;
      } else {
        message = 'Por favor, ingresa un correo válido.';
      }

      // Cambiar el contenido del modal
      document.getElementById('modalMessage').textContent = message;

      // Mostrar el modal
      const myModal = new bootstrap.Modal(document.getElementById('alertModal'));
      myModal.show();
    }
  </script>