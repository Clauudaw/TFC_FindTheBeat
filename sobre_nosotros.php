<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - FindTheBeat</title>
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
    <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Sobre Nosotros</a></li>
  </ol>
</nav>
       

    <div class="container mt-5 col-sm-10">
    
    <h2 class="text-center mb-4">Sobre Nosotros</h2>
        <p class="text-center fs-5 text-muted">En FindTheBeat, conectamos músicos con espacios diseñados para la creatividad y la excelencia.</p>
        
        <div class="row align-items-center mb-5">
            <div class="col-md-6 ">
                <img src="assets/images/sobre_nosotros.jpg" alt="Equipo de FindTheBeat" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h3>Nuestra Misión</h3>
                <p>FindTheBeat nació con el propósito de facilitar a músicos, bandas y productores el acceso a estudios de grabación y salas de ensayo equipadas con la mejor tecnología.</p>
                <p>Creemos que el talento musical merece el mejor espacio posible para desarrollarse. Por eso, ofrecemos una plataforma intuitiva donde puedes encontrar, reservar y disfrutar del lugar perfecto para tu música.</p>
            </div>
        </div>

        <div class="row align-items-center flex-row-reverse mb-5">
            <div class="col-md-6">
                <img src="assets/images/sala7.png" alt="Estudio de música" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h3>Nuestra Visión</h3>
                <p>Queremos ser la plataforma líder en la reserva de espacios musicales, permitiendo que músicos de todo el mundo encuentren lugares que impulsen su creatividad.</p>
                <p>Trabajamos con estudios profesionales y espacios acústicamente optimizados para garantizar la mejor experiencia musical posible.</p>
            </div>
        </div>
    </div>
    
    <div class="container text-center mb-5">
        <h3>Nuestros Valores</h3>
        <div class="row">
            <div class="col-md-4">
                <img src="assets/images/calidad.jpg" alt="Calidad" class="img-fluid mb-3" style="max-width: 350px;">
                <h5>Calidad</h5>
                <p>Espacios profesionales con el mejor equipo acústico.</p>
            </div>
            <div class="col-md-4">
                <img src="assets/images/comunidad.jpg" alt="Comunidad" class="img-fluid mb-3" style="max-width: 350px;">
                <h5>Comunidad</h5>
                <p>Conectamos músicos con espacios y oportunidades únicas.</p>
            </div>
            <div class="col-md-4">
                <img src="assets/images/innovacion.jpg" alt="Innovación" class="img-fluid mb-3" style="max-width: 350px;">
                <h5>Innovación</h5>
                <p>Facilitamos la reserva de espacios con tecnología avanzada.</p>
            </div>
        </div>
    </div>
    
    <div id="newsletter"></div> <!-- Aquí se cargará el formulario de Newsletter -->
    <div id="footer"></div> <!-- Aquí se cargará el Footer -->
    <div id="arrowup"></div>
    
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>