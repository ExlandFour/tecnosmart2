-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2024 a las 01:02:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecnosmart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'Telefonos'),
(2, 'Carcasas'),
(12, 'Figuras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `c_id` int(11) NOT NULL,
  `c_nombre` varchar(50) NOT NULL,
  `c_apellido` varchar(50) NOT NULL,
  `c_direccion` varchar(250) NOT NULL,
  `c_rut` varchar(20) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datalle_compra`
--

CREATE TABLE `datalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `especificaciones` text NOT NULL,
  `precio_normal` decimal(10,2) NOT NULL,
  `precio_rebajado` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `modelo_3d` text NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `especificaciones`, `precio_normal`, `precio_rebajado`, `cantidad`, `imagen`, `modelo_3d`, `id_categoria`, `activo`) VALUES
(10, 'Apple', 'Apple iPhone 15 128Gb\r\n', '<ul>\r\n    <li><strong>Cámara principal:</strong> Sobre 40MP</li>\r\n    <li><strong>Cámara frontal:</strong> Sobre 40MP</li>\r\n    <li><strong>Tamaño de la pantalla:</strong> 6.1 pulgadas</li>\r\n    <li><strong>Memoria interna:</strong> 128GB</li>\r\n    <li><strong>Núcleos del procesador:</strong> Hexa Core</li>\r\n    <li><strong>Características de la pantalla:</strong> Touch</li>\r\n    <li><strong>Cuenta con bluetooth:</strong> Sí</li>\r\n    <li><strong>Alto:</strong> 146,6 mm</li>\r\n    <li><strong>Ancho:</strong> 70,6 mm</li>\r\n    <li><strong>País de origen:</strong> China</li>\r\n    <li><strong>Plazo de disponibilidad de repuestos:</strong> 3 Meses</li>\r\n    <li><strong>Condicion del producto:</strong> Nuevo</li>\r\n</ul>', 963.00, 1048.00, 10, '20240620115530.jpg', '<div class=\"sketchfab-embed-wrapper\"> <iframe title=\"iPhone 15 Pro Max\" frameborder=\"0\" allowfullscreen mozallowfullscreen=\"true\" webkitallowfullscreen=\"true\" allow=\"autoplay; fullscreen; xr-spatial-tracking\" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width=\"229\" height=\"229\" src=\"https://sketchfab.com/models/5b7b35513a154ac69619dc2b2fe15686/embed\"> </iframe> <p style=\"font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;\"> <a href=\"https://sketchfab.com/3d-models/iphone-15-pro-max-5b7b35513a154ac69619dc2b2fe15686?utm_medium=embed&utm_campaign=share-popup&utm_content=5b7b35513a154ac69619dc2b2fe15686\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> iPhone 15 Pro Max </a> by <a href=\"https://sketchfab.com/MG990?utm_medium=embed&utm_campaign=share-popup&utm_content=5b7b35513a154ac69619dc2b2fe15686\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> MpPower™ </a> on <a href=\"https://sketchfab.com?utm_medium=embed&utm_campaign=share-popup&utm_content=5b7b35513a154ac69619dc2b2fe15686\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\">Sketchfab</a></p></div>', 1, 0),
(11, 'Apple', 'Apple iPad 10.2\" (Wi-Fi, 256GB) 9a Generación\r\n', '<ul>\r\n    <li><strong>Incluye:</strong> No aplica</li>\r\n    <li><strong>Memoria RAM:</strong> No aplica</li>\r\n    <li><strong>Hecho en:</strong> China</li>\r\n    <li><strong>Conexión Bluetooth:</strong> Sí</li>\r\n    <li><strong>Ancho:</strong> 13.5 cm</li>\r\n    <li><strong>País de origen:</strong> China</li>\r\n    <li><strong>Cámara principal:</strong> 8MP</li>\r\n    <li><strong>Garantía del proveedor:</strong> 12 meses</li>\r\n    <li><strong>Conectividad/conexión:</strong> Wifi</li>\r\n    <li><strong>Tamaño de la pantalla:</strong> 10.1 pulgadas</li>\r\n    <li><strong>Capacidad de almacenamiento:</strong> 256GB</li>\r\n    <li><strong>Núcleos del procesador:</strong> Dual core</li>\r\n</ul>\r\n', 748.00, 545.00, 22, '20240620120033.jpg', '<div class=\"sketchfab-embed-wrapper\"> <iframe title=\"IPAD\" frameborder=\"0\" allowfullscreen mozallowfullscreen=\"true\" webkitallowfullscreen=\"true\" allow=\"autoplay; fullscreen; xr-spatial-tracking\" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width=\"229\" height=\"229\" src=\"https://sketchfab.com/models/1d90f062779b4a1ba9d5b6f4a7fbc4f7/embed\"> </iframe> <p style=\"font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;\"> <a href=\"https://sketchfab.com/3d-models/ipad-1d90f062779b4a1ba9d5b6f4a7fbc4f7?utm_medium=embed&utm_campaign=share-popup&utm_content=1d90f062779b4a1ba9d5b6f4a7fbc4f7\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> IPAD </a> by <a href=\"https://sketchfab.com/pranav27?utm_medium=embed&utm_campaign=share-popup&utm_content=1d90f062779b4a1ba9d5b6f4a7fbc4f7\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> pranav27 </a> on <a href=\"https://sketchfab.com?utm_medium=embed&utm_campaign=share-popup&utm_content=1d90f062779b4a1ba9d5b6f4a7fbc4f7\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\">Sketchfab</a></p></div>', 1, 0),
(20, 'XIAOMI', 'Celular Xiaomi Redmi 13C 256GB', '                                <ul>\r\n                                    <li><strong>Cámara principal: </strong> Sobre 40MP</li>\r\n                                    <li><strong>Cámara frontal:</strong> 16MP</li>\r\n                                    <li><strong>Tamaño de la pantalla:</strong> 6.7 pulgadas</li>\r\n                                    <li><strong>Núcleos del procesador:</strong> 256GB</li>\r\n                                    <li><strong>Características de la pantalla: </strong> Amoled</li>\r\n                                    <li><strong>Cuenta con bluetooth: </strong> Sí</li>\r\n                                    <li><strong>Alto:</strong> 162.3 mm</li>\r\n                                    <li><strong>Ancho:</strong> 75.5 mm</li>\r\n                                    <li><strong>País de origen:</strong> China</li>\r\n                                    <li><strong>Plazo de disponibilidad de repuestos: </strong> 2 años</li>\r\n                                    <li><strong>Condicion del producto: </strong> Nuevo</li>\r\n                               </ul>', 114.00, 210.00, 10, '20240620113449.jpg', '<iframe src=\"https://lumalabs.ai/embed/29ae3bf9-3bb3-4065-8f0b-c309cab1c17f?mode=sparkles&background=%23ffffff&color=%23000000&showTitle=true&loadBg=true&logoPosition=bottom-left&infoPosition=bottom-right&cinematicVideo=undefined&showMenu=false\" frameborder=\"0\" title=\"luma embed\" style=\"border: none;\"></iframe>', 1, 0),
(21, 'XIAOMI', 'Celular Smartphone Xiaomi Redmi Note 13 256GB', '<ul>\r\n    <li><strong>Cámara principal:</strong> Sobre 40MP</li>\r\n    <li><strong>Cámara frontal:</strong> 16MP</li>\r\n    <li><strong>Tamaño de la pantalla:</strong> 6.7 pulgadas</li>\r\n    <li><strong>Memoria interna:</strong> 256GB</li>\r\n    <li><strong>Núcleos del procesador:</strong> Octa Core</li>\r\n    <li><strong>Características de la pantalla:</strong> Amoled</li>\r\n    <li><strong>Cuenta con bluetooth:</strong> Sí</li>\r\n    <li><strong>Alto:</strong> 162.3 mm</li>\r\n    <li><strong>Ancho:</strong> 75.5 mm</li>\r\n    <li><strong>País de origen:</strong> China</li>\r\n    <li><strong>Plazo de disponibilidad de repuestos:</strong> 2 años</li>\r\n    <li><strong>Condicion del producto:</strong> Nuevo</li>\r\n</ul>', 208.00, 120.00, 10, '20240620111217.jpg', '<div class=\"sketchfab-embed-wrapper\"> <iframe title=\"Glass Smartphone Design\" frameborder=\"0\" allowfullscreen mozallowfullscreen=\"true\" webkitallowfullscreen=\"true\" allow=\"autoplay; fullscreen; xr-spatial-tracking\" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src=\"https://sketchfab.com/models/d0b0c3c0d2064788934be731daeeb65b/embed\"> </iframe> <p style=\"font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;\"> <a href=\"https://sketchfab.com/3d-models/glass-smartphone-design-d0b0c3c0d2064788934be731daeeb65b?utm_medium=embed&utm_campaign=share-popup&utm_content=d0b0c3c0d2064788934be731daeeb65b\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> Glass Smartphone Design </a> by <a href=\"https://sketchfab.com/sidbeyond?utm_medium=embed&utm_campaign=share-popup&utm_content=d0b0c3c0d2064788934be731daeeb65b\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> Jeferson Camargo Brasil </a> on <a href=\"https://sketchfab.com?utm_medium=embed&utm_campaign=share-popup&utm_content=d0b0c3c0d2064788934be731daeeb65b\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\">Sketchfab</a></p></div>', 1, 0),
(22, 'NEON GENESIS EVANGELION', '**Legítimo** Great Eastern Evangelion Rei Traje de Peluche Relleno, 8\" - GE-52302', '<ul>\r\n    <li><strong>Marca:</strong> Generic</li>\r\n    <li><strong>Línea:</strong> #1</li>\r\n    <li><strong>Modelo:</strong> Rei Plugsuit</li>\r\n    <li><strong>Es kit:</strong> Sí</li>\r\n    <li><strong>Forma del peluche:</strong> Estrella</li>\r\n    <li><strong>Personaje:</strong> As Picture</li>\r\n    <li><strong>Tamaño:</strong> Mediano</li>\r\n    <li><strong>Altura x Ancho:</strong> 11111 cm x 111 cm</li>\r\n    <li><strong>Peso:</strong> 0 kg</li>\r\n    <li><strong>Materiales:</strong> PP</li>\r\n    <li><strong>Es material hipoalergénico:</strong> Sí</li>\r\n</ul>', 200.00, 120.00, 12, '20240620112141.jpg', '<div class=\"sketchfab-embed-wrapper\"> <iframe title=\"Rei Plush - Neon Genesis Evangelion\" frameborder=\"0\" allowfullscreen mozallowfullscreen=\"true\" webkitallowfullscreen=\"true\" allow=\"autoplay; fullscreen; xr-spatial-tracking\" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width=\"235\" height=\"235\" src=\"https://sketchfab.com/models/e1f655cae06849e4a4c3c71ffdbfa93c/embed\"> </iframe> <p style=\"font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;\"> <a href=\"https://sketchfab.com/3d-models/rei-plush-neon-genesis-evangelion-e1f655cae06849e4a4c3c71ffdbfa93c?utm_medium=embed&utm_campaign=share-popup&utm_content=e1f655cae06849e4a4c3c71ffdbfa93c\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> Rei Plush - Neon Genesis Evangelion </a> by <a href=\"https://sketchfab.com/tofokyo?utm_medium=embed&utm_campaign=share-popup&utm_content=e1f655cae06849e4a4c3c71ffdbfa93c\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> tofokyo </a> on <a href=\"https://sketchfab.com?utm_medium=embed&utm_campaign=share-popup&utm_content=e1f655cae06849e4a4c3c71ffdbfa93c\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\">Sketchfab</a></p></div>', 1, 0),
(23, 'GENERICO', 'Carcasa Transparente Magsafe Para iPhone 13 Normal\r\n', '<ul>\r\n    <li><strong>Detalle de la Condición:</strong> Nuevo</li>\r\n    <li><strong>País de origen:</strong> China</li>\r\n    <li><strong>Condicion del producto:</strong> Nuevo</li>\r\n    <li><strong>Detalle de la garantía:</strong> 1 Producto tiene que estar como nuevo</li>\r\n    <li><strong>Modelo:</strong> iP13normal</li>\r\n    <li><strong>Dimensiones:</strong> Alto 16 cm x Largo 1 cm x Ancho 7 cm</li>\r\n</ul>', 18.00, 8.00, 14, '20240621010045.jpg', '<div class=\"sketchfab-embed-wrapper\"> <iframe title=\"Iphone 14 Case\" frameborder=\"0\" allowfullscreen mozallowfullscreen=\"true\" webkitallowfullscreen=\"true\" allow=\"autoplay; fullscreen; xr-spatial-tracking\" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width=\"230\" height=\"230\" src=\"https://sketchfab.com/models/13735fd5c1cf47b8933addefdb7af6ea/embed\"> </iframe> <p style=\"font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;\"> <a href=\"https://sketchfab.com/3d-models/iphone-14-case-13735fd5c1cf47b8933addefdb7af6ea?utm_medium=embed&utm_campaign=share-popup&utm_content=13735fd5c1cf47b8933addefdb7af6ea\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> Iphone 14 Case </a> by <a href=\"https://sketchfab.com/SKAJ?utm_medium=embed&utm_campaign=share-popup&utm_content=13735fd5c1cf47b8933addefdb7af6ea\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\"> SKAJ </a> on <a href=\"https://sketchfab.com?utm_medium=embed&utm_campaign=share-popup&utm_content=13735fd5c1cf47b8933addefdb7af6ea\" target=\"_blank\" rel=\"nofollow\" style=\"font-weight: bold; color: #1CAAD9;\">Sketchfab</a></p></div>', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `clave`) VALUES
(1, 'admin', 'Marcelo Quinchagual', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'admin', 'Víctor Ceballos', '\r\nviceballosvg\r\n');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datalle_compra`
--
ALTER TABLE `datalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_compra` (`id_compra`) USING BTREE,
  ADD KEY `id_producto` (`id_producto`) USING BTREE;

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datalle_compra`
--
ALTER TABLE `datalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datalle_compra`
--
ALTER TABLE `datalle_compra`
  ADD CONSTRAINT `datalle_compra_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `datalle_compra_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
