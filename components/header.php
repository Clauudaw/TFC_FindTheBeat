<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/index.php">
                <img src="assets/images/logo_FindTheBeat_verde_img.png" alt="Find The Beat Logo" class="logo-find-the-beat">
                <img src="assets/images/logo_FindTheBeat_verde_letras.png" alt="Find The Beat Logo" class="logo-find-the-beat_letras">
            </a>

            <!-- Botón menú en móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="/espacios.php">Explorar espacios</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contacto.php">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="/sobre_nosotros.php">Sobre nosotros</a></li>

                    <?php if (isset($_SESSION['username'])): ?>
                        <?php 
                            $dashboardLink = ($_SESSION['role'] === 'admin') ? '/admin_dashboard.php' : '/user_dashboard.php';
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $dashboardLink ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#3D8168">
                                    <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/>
                                </svg> <?= htmlspecialchars($_SESSION['username']); ?>
                            </a>
                        </li>
                        <li class="nav-item"><a class="btn btn-danger ms-3" href="/logout.php">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="/login.php" class="btn btn-primary ms-3">
                                <svg xmlns="http://www.w3.org/2000/svg" height="30px" width="30px" fill="#e8eaed" viewBox="0 -960 960 960">
                                    <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360Zm0 360Z"/>
                                </svg>
                            </a>
                        </li>
                    <?php endif; ?>
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

        .logo-find-the-beat {
            max-width: 3.5em;
        }

        .logo-find-the-beat_letras {
            max-width: 7em;
        }
      
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            z-index: 1030; /* Mantenerla sobre otros elementos */
        }
      
        .navbar .nav-link {
            color: #000; /* Asegúrate de que tenga un color visible */
            text-decoration: none;
        }
      
        .navbar .nav-link:hover {
            color: #3D8168; /* Color en hover */
        }
      
        /* Botón de inicio de sesión */
        .btn-primary {
            background-color: #3D8168 !important;
            border-color: #3D8168 !important;
        }
      
        .btn-primary:hover {
            background-color: #336B56 !important; /* Color más oscuro en hover */
            border-color: #336B56 !important;
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
                color: #3D8168;
            }
        }
    </style>
</header>
