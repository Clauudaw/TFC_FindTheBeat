<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
          <!-- Marca o título -->
          <a class="navbar-brand" href="/">
            <img src="/assets/images/logo_FindTheBeat_verde_img.png" alt="Logo findTheBeat" >
            <img src="/assets/images/logo_FindTheBeat_verde_letras.png" alt="Logo findTheBeat">
          </a>
      
          <!-- Botón toggle para dispositivos móviles -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
      
          <!-- Links de navegación -->
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" href="/">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/espacios.php">Explorar espacios</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="/contacto.html">Contacto</a></li>
              <li class="nav-item"><a class="nav-link" href="/sobre_nosotros.html">Sobre nosotros</a></li>
              <a href="/login.php" class="btn btn-primary ms-3">Iniciar Sesión</a>
            </ul>
          </div>
        </div>
      </nav>
      
      <style>
      /* Estilos personalizados */
         #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Asegúrate de que esté encima de otros elementos */
        }
        body {
            padding-top: 60px; /* Ajusta este valor según la altura de tu header */
        }
      .navbar {
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        z-index: 1030; /* Mantenerla sobre otros elementos */
      }
      
      .navbar .nav-link {
        color: var(--text-color);
        text-decoration: none;
      }
      
      .navbar .nav-link:hover {
        color: var(--primary-color);
      }
      
      /* Ajustar el espacio del contenido principal debido a la barra fija */
      .main-content {
        padding-top: 4.5rem; /* Altura de la navbar para evitar que el contenido quede debajo */
      }
      
      @media (max-width: 1024px) {
        .navbar-toggler {
          border: none;
        }
      
        .navbar-toggler-icon {
          color: var(--primary-color);
        }
      }
      </style>
      
</header>