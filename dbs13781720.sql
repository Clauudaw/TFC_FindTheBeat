-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: db5017147270.hosting-data.io
-- Tiempo de generación: 12-02-2025 a las 19:19:38
-- Versión del servidor: 8.0.36
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbs13781720`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `space_id` int DEFAULT NULL,
  `estado` enum('pendiente','confirmada','cancelada') COLLATE utf8mb4_general_ci DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `dni` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `metodo_pago` enum('Tarjeta','PayPal','Bizum') COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_reserva` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `space_id`, `estado`, `created_at`, `nombre`, `apellidos`, `dni`, `correo`, `fecha_nacimiento`, `telefono`, `metodo_pago`, `fecha_reserva`, `hora_inicio`, `hora_fin`) VALUES
(7, 14, 3, 'pendiente', '2025-02-04 12:25:52', 'john', 'Doe', '78161507D', 'johndoe@gmail.com', '2002-02-25', '622589674', 'PayPal', '2025-02-25', '23:30:00', '00:23:00'),
(8, 1, 8, 'confirmada', '2025-02-04 13:10:57', 'Claudia', 'Benito', '47586914S', 'miguel@gmial.com', '2002-02-25', '622131197', 'Tarjeta', '2025-03-25', '15:30:00', '17:30:00'),
(11, 23, 1, 'confirmada', '2025-02-04 20:11:52', 'Marta', 'Smith', '76323234C', 'martar@gmail.com', '1980-10-04', '623123423', 'Tarjeta', '2025-02-04', '20:11:00', '21:12:00'),
(12, 24, 2, 'pendiente', '2025-02-05 14:09:16', 'Marina', 'Herreros', '98356773L', 'marinaherreros@gmail.com', '2006-02-09', '607787706', 'Bizum', '2025-02-21', '12:05:00', '14:15:00'),
(13, 25, 1, 'pendiente', '2025-02-05 18:17:05', 'B', 'B', '77355191g', 'B@b.com', '1984-06-11', '666666666', 'Bizum', '2025-02-06', '20:00:00', '21:00:00'),
(14, 26, 1, 'pendiente', '2025-02-07 01:52:59', 'Rocio', 'Matres ', '56893687G', 'akaramtm07@gmail.com', '1973-03-07', '653862078', 'Bizum', '2025-02-14', '17:30:00', '20:45:00'),
(15, 27, 9, 'pendiente', '2025-02-08 10:53:15', 'manolo', 'dechristian', '87897654B', 'holamellamomanolo@gmail.com', '1940-02-14', '567809432', 'Bizum', '2025-02-20', '11:52:00', '11:52:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'john', 'johndoe@gmail.com', 'reserva', 'FGHFGH', '2025-02-02 20:25:13'),
(2, 'pepito', 'pepito@gmail.com', 'reserva', 'dfgdfgdfg', '2025-02-02 20:28:09'),
(3, 'lolo', 'lolo@gmail.com', 'reserva', 'he tenido un problema con una cosa', '2025-02-04 19:08:02'),
(4, 'Rocio', 'akaramtm07@gmail.com', 'Mala comunicación con el personal', 'Venimos de Galicia, somos un grupo reducido pero con mucho talento. ¿En el establecimiento se pueden alquilar algún instrumento más o solo los que llevamos nosotros personales?', '2025-02-07 01:58:59'),
(5, 'Pepe', 'Pepe@gmail.com', 'Como hago la reserva', 'no se como hacer la reserva de un espacio, necesito una sala de ensayo', '2025-02-12 19:10:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `space_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `space_id`, `rating`, `comment`, `created_at`) VALUES
(2, 3, 7, 5, 'me ha gustado', '2025-01-23 00:45:14'),
(4, 1, 3, 4, 'me ha gustado mucho pero siempre se puede mejorar', '2025-01-23 01:32:12'),
(5, 17, 1, 3, 'Me ha encantado, muy espacioso y buena acusticaaa', '2025-01-23 18:11:45'),
(6, 14, 3, 4, 'muy bonitooo', '2025-01-23 19:10:07'),
(10, 23, 1, 5, 'Me gusto mucho, espacio amplio y buena acustica', '2025-02-04 20:17:23'),
(11, 23, 1, 4, 'muy contenta con la reserva de hoy', '2025-02-04 20:20:43'),
(12, 24, 1, 4, 'Muy contenta de tener este espacio cerca', '2025-02-05 14:13:21'),
(13, 26, 1, 2, 'Tiene una acústica muy buena pero en recepción no nos dejaron entrar con nuestras cosas, un poco feo eso por su parte ', '2025-02-07 01:54:21'),
(14, 26, 3, 2, 'No encontramos bien el sitio, estaba bastante mal señalizado necesitamos hora y media para aparcar, igualmente sitio muy bueno ', '2025-02-07 01:55:40'),
(15, 27, 9, 5, 'Estancia agradable y acojedora, todo limpio👍🏻👍🏻', '2025-02-08 10:58:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spaces`
--

CREATE TABLE `spaces` (
  `id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `precio` decimal(10,2) NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comunidad_autonoma` enum('Andalucía','Madrid','Cataluña') COLLATE utf8mb4_general_ci NOT NULL,
  `capacidad` int DEFAULT NULL,
  `tipo` enum('grabacion','ensayo','eventos') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `spaces`
--

INSERT INTO `spaces` (`id`, `titulo`, `descripcion`, `precio`, `direccion`, `provincia`, `comunidad_autonoma`, `capacidad`, `tipo`, `created_at`, `imagen`) VALUES
(1, 'Estudio de grabación Rocket Room', 'Una sala de mezclas insonorizada y con aire acondicionado y una espaciosa cabina vocal adjunta con intercomunicador. - Consola Apollo 8 - Micrófono Neumann - Preamplificador UA MK11 - Monitores Quested - Monitores Yamaha - Teclado de tamaño completo - Guitarra eléctrica. Pregunte por las tarifas para reservas en bloque: rocketroomstudios@gmail.com', '31.00', 'Calle Gran Vía, 45', 'Madrid', 'Madrid', 4, 'grabacion', '2025-01-15 09:00:00', 'assets\\images\\grabacion\\1\\img1.png'),
(2, 'Gran espacio para composición y enseñanza de canciones', 'Una sala grande y luminosa, ideal para colaboraciones creativas, práctica o enseñanza. Con techos altos, buena resonancia y una linda vista, este es un espacio encantador para relajarse y trabajar en ideas, para albergar su práctica de enseñanza o para sesiones creativas más largas. Es un espacio de buen tamaño con excelente acústica para voces e instrumentos solistas. Los conjuntos y las bandas semiacústicas también suenan muy bien aquí. Tenemos dos profesores de música que también dirigen su práctica desde esta sala, y un pequeño espacio de descanso también disponible. Reserva mínima de 4 horas. Piano vertical, piano eléctrico Roland (con peso), amplificador de guitarra, amplificador de bajo, atriles, PA, soportes de micrófono y varias percusiones pequeñas incluidas. Guitarra/Bajo/Batería eléctrica/Batería acústica disponibles para alquilar con cita previa. Cocina y baño privados. Área de descanso. Tablón de anuncios. Almacenamiento para usuarios habituales.', '15.00', 'Calle Mayor, 18', 'Madrid', 'Madrid', 5, 'ensayo', '2025-01-15 09:00:00', '\\assets\\images\\ensayo\\2\\img1.png'),
(3, 'Teatro y sala de conciertos', 'Un teatro de caja negra totalmente accesible en la planta baja con piso de madera y escenario modular. Sin asientos fijos, por lo que es ideal para ensayos y sesiones de producción. Excelente acústica. Dimensiones de la sala: 10,50 m de ancho x 11,70 m de largo. Crédito de la foto: © Tim Boddy', '69.00', 'Avenida de América, 10', 'Madrid', 'Madrid', 30, 'eventos', '2025-01-15 09:00:00', 'assets\\images\\eventos\\3\\img1.png'),
(4, 'TEN87 Studios - El Club', 'Dentro de su diseño de vanguardia, encontrará nuestra nueva sala en vivo, completa con techos altos, acústica precisa, una gran cantidad de instrumentos que incluyen un Yamaha C3 Grand y un piano Fender Rhodes, y espacio para un conjunto de 10 piezas. En el corazón de la sala de control a gran escala, se encuentra un SSL6032E vintage completamente cargado con el legendario ecualizador 232 (Pultec), completo con automatización y recuperación. Tenemos monitoreo personalizado de Yamaha y ATC, los mejores sistemas de reproducción de audio del juego. Una lista completa de equipos externos y de línea de fondo proporciona el equilibrio perfecto entre sonido vintage y flujo de trabajo ultramoderno. Si está buscando encender un nuevo proyecto de escritura, clavar una mezcla o capturar un nuevo sonido, nuestro nuevo espacio tiene todo lo que necesita para subir de nivel su próximo disco.', '80.00', 'Carrer de Balmes, 32', 'Barcelona', 'Cataluña', 12, 'grabacion', '2025-01-15 09:00:00', 'assets\\images\\grabacion\\4\\img1.png'),
(5, 'Iglesia de Santa María Magdalena, Sala de ensayos', 'Esta sala se utiliza con regularidad, por lo que la disponibilidad es limitada. Tenemos una hermosa iglesia con buena acústica y un piano de cola y un órgano recientemente renovado. Tenemos dos salas, la pequeña es adecuada para un conjunto pequeño y la grande para un grupo más grande de cantantes o músicos. Los coros pueden preferir usar la iglesia, pero las salas también son adecuadas. No tenemos estacionamiento, pero el estacionamiento en la calle es gratuito y está permitido.', '40.00', 'Carrer d\'Aragó, 122', 'Barcelona', 'Cataluña', 10, 'ensayo', '2025-01-15 09:00:00', 'assets\\images\\ensayo\\5\\img1.png'),
(6, 'Sala de música para alquiler de conciertos y películas', 'Hay una reserva mínima de 3 horas para alquileres de conciertos. Reserva como ubicación de película: 200€ / hr (reserva mínima de 1 hora). Reserva para sesiones de grabación: 200€ / hr (reserva mínima de 1 hora). La histórica sala de música con paneles de madera es el espacio perfecto para conciertos de cámara íntimos. Con un piano de media cola Blüthner de la década de 1920 y una acústica cálida, la sala puede acomodar hasta 70 miembros de la audiencia para recitales. El piano de media cola Blüthner está incluido en el precio y podemos publicar sus conciertos en nuestro sitio web.', '200.00', 'Rambla de Catalunya, 24', 'Barcelona', 'Cataluña', 70, 'eventos', '2025-01-15 09:00:00', 'assets\\images\\eventos\\6\\img1.png'),
(7, 'Estudios Supervox', 'Estudio profesional insonorizado, equipado con tecnología avanzada para grabaciones de música, voz y producción audiovisual.', '40.00', 'Calle San Fernando, 25', 'Sevilla', 'Andalucía', 8, 'grabacion', '2025-01-15 09:00:00', 'assets\\images\\grabacion\\7\\img1.png'),
(8, 'Práctica en solitario o acompañado, sin teclado', 'Sala según disponibilidad. En muy raras ocasiones, puede ser necesario cambiar de sala a mitad de la sesión para que haya instrumentos disponibles para otras personas. La acústica varía de excelente a buena. El software del sitio web no admite precios variables, por lo que el precio que se muestra para sesiones de varias horas será demasiado alto: lo ajustaré al aceptar reservas. Los honorarios se destinan a la investigación sobre el Parkinson.', '8.00', 'Calle Feria, 12', 'Sevilla', 'Andalucía', 4, 'ensayo', '2025-01-15 09:00:00', 'assets\\images\\ensayo\\8\\img1.png'),
(9, 'Cine La Estrella', 'El Cine La Estrella es un cine independiente de arte y ensayo, ubicado a pocos metros de la Avenida de la Constitución en Sevilla. Inaugurado en 1935, es uno de los espacios más icónicos para los amantes del cine en la ciudad. Ofrece una programación única con sesiones excepcionales, como veladas de ópera y proyecciones especiales los fines de semana. Además de sus proyecciones, el cine organiza conciertos en vivo, creando una experiencia cultural completa que combina cine y música en un ambiente acogedor.', '215.00', 'Avenida de la Constitución, 3', 'Sevilla', 'Andalucía', 180, 'eventos', '2025-01-15 09:00:00', 'assets\\images\\eventos\\9\\img1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('normal','admin') COLLATE utf8mb4_general_ci DEFAULT 'normal',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '1234', 'admin', '2025-01-22 22:12:48'),
(3, 'JuanGomez', 'juan.gomez@example.com', '4321', 'normal', '2025-01-15 19:04:42'),
(5, 'CarlosPerez', 'carlos.perez@example.com', '4321', 'normal', '2025-01-15 19:04:42'),
(6, 'AnaRuiz', 'ana.ruiz@example.com', '4321', 'normal', '2025-01-15 19:04:42'),
(14, 'johndoe', 'johndoe@gmail.com', '43215', 'normal', '2025-01-22 23:31:32'),
(17, 'clauu', 'clauu@gmail.com', '43211', 'normal', '2025-01-23 18:10:55'),
(23, 'martar', 'martar@gmail.com', '1qa2ws3ed4', 'admin', '2025-02-04 19:45:21'),
(24, 'Marina', 'marinaherreros@gmail.com', 'macarrones1234', 'normal', '2025-02-05 14:05:09'),
(25, 'B', 'b@b.com', 'b', 'normal', '2025-02-05 18:12:18'),
(26, 'Roros', 'akaramtm07@gmail.com', 'AbCdEfG1234', 'normal', '2025-02-07 01:50:31'),
(27, 'Manolo', 'holamellamomanolo@gmail.com', 'joputa3', 'normal', '2025-02-08 10:50:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `space_id` (`space_id`),
  ADD KEY `dni` (`dni`) USING BTREE;

--
-- Indices de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `space_id` (`space_id`);

--
-- Indices de la tabla `spaces`
--
ALTER TABLE `spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `spaces`
--
ALTER TABLE `spaces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`);

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
