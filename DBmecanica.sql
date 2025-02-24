-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2025 a las 00:58:13
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
-- Base de datos: `mecanica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adeudos`
--

CREATE TABLE `adeudos` (
  `id_adeudos` int(11) NOT NULL,
  `matricula` int(7) NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estatus` varchar(20) NOT NULL DEFAULT '',
  `id_prestamo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adeudos`
--

INSERT INTO `adeudos` (`id_adeudos`, `matricula`, `fecha`, `monto`, `estatus`, `id_prestamo`) VALUES
(2, 2230099, '2025-02-01', 260.00, '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `matricula` int(7) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `pe` varchar(50) NOT NULL,
  `grado` int(2) NOT NULL,
  `grupo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`matricula`, `nombre`, `pe`, `grado`, `grupo`) VALUES
(2230099, 'Mariana López Martínez', 'Mecánica', 1, 'A'),
(2230100, 'José Luis Pérez Sánchez', 'Mecánica', 7, 'B'),
(2230101, 'Daniela González Ramírez', 'Mecánica', 4, 'C'),
(2230102, 'Ricardo Hernández Flores', 'Mecánica', 10, 'D'),
(2230103, 'Carla Torres Rodríguez', 'Mecánica', 1, 'A'),
(2230104, 'Miguel Ángel Vargas Rivera', 'Mecánica', 1, 'A'),
(2230105, 'Fernanda Morales Romero', 'Mecánica', 1, 'C'),
(2230106, 'Luis Fernando Ortega Silva', 'Mecánica', 4, 'B'),
(2230107, 'Andrea Sánchez Guzmán', 'Mecánica', 7, 'B'),
(2230108, 'Carlos Jiménez Velázquez', 'Mecánica', 7, 'B'),
(2230109, 'Gabriela Ruiz García', 'Mecánica', 7, 'B'),
(2230110, 'Javier Martínez Castillo', 'Mecánica', 7, 'A'),
(2230111, 'Sandra Vázquez Pérez', 'Mecánica', 1, 'A'),
(2230112, 'Roberto García Hernández', 'Mecánica', 1, 'A'),
(2230113, 'Patricia Delgado López', 'Mecánica', 1, 'A'),
(2230114, 'Alejandro Ríos Pineda', 'Mecánica', 1, 'A'),
(2230115, 'Teresa Domínguez Torres', 'Mecánica', 1, 'C'),
(2230116, 'Manuel Castillo Vargas', 'Mecánica', 1, 'C'),
(2230117, 'Beatriz González Ramírez', 'Mecánica', 1, 'C'),
(2230118, 'Eduardo Morales Jiménez', 'Mecánica', 1, 'C'),
(2230119, 'Ana María Cruz García', 'Mecánica', 1, 'C'),
(2230120, 'Fernando López Rodríguez', 'Mecánica', 1, 'A'),
(2230121, 'Laura Ramírez Martínez', 'Mecánica', 1, 'A'),
(2230122, 'Jesús Hernández Ortega', 'Mecánica', 4, 'A'),
(2230123, 'Karina Reyes González', 'Mecánica', 4, 'A'),
(2230124, 'Mauricio Torres Salazar', 'Mecánica', 4, 'A'),
(2230125, 'Miriam Sánchez Pineda', 'Mecánica', 4, 'A'),
(2230126, 'Juan Carlos Rivera Domínguez', 'Mecánica', 4, 'B'),
(2230127, 'Rosario Pérez Vázquez', 'Mecánica', 4, 'B'),
(2230128, 'Sergio Flores Ruiz', 'Mecánica', 10, 'B'),
(2230129, 'Claudia Guzmán Delgado', 'Mecánica', 10, 'B'),
(2230130, 'Rafael Silva Castillo', 'Mecánica', 10, 'B'),
(2230131, 'María Fernanda Ortega Ramírez', 'Mecánica', 10, 'C'),
(2230132, 'Francisco Herrera Reyes', 'Mecánica', 4, 'C'),
(2230133, 'Susana Villanueva Morales', 'Mecánica', 7, 'C'),
(2230134, 'Enrique García Sánchez', 'Mecánica', 1, 'C'),
(2230135, 'Guadalupe Soto García', 'Mecánica', 1, 'A'),
(2230136, 'Pedro Luna Torres', 'Mecánica', 7, 'A'),
(2230137, 'Fabiola Ortiz Ruiz', 'Mecánica', 7, 'A'),
(2230138, 'Jorge Campos Hernández', 'Mecánica', 10, 'A'),
(2230139, 'Alejandra Rodríguez Ríos', 'Mecánica', 10, 'A'),
(2230140, 'Rubén Mendoza Jiménez', 'Mecánica', 10, 'B'),
(2230141, 'Ximena Morales Flores', 'Mecánica', 7, 'B'),
(2230142, 'Ignacio Reyes Ortega', 'Mecánica', 4, 'B'),
(2230143, 'Mónica Vargas Guzmán', 'Mecánica', 4, 'C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_adeudo`
--

CREATE TABLE `detalle_adeudo` (
  `id_detaAde` int(11) NOT NULL,
  `id_adeudos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `grado` varchar(10) NOT NULL,
  `grupo` varchar(10) NOT NULL,
  `pe` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_adeudo`
--

INSERT INTO `detalle_adeudo` (`id_detaAde`, `id_adeudos`, `nombre`, `grado`, `grupo`, `pe`, `descripcion`, `cantidad`, `monto`) VALUES
(3, 2, 'Mariana López Martínez', '1', 'A', 'Mecánica', 'Lapiz electrico para grabar ', 1, 250.00),
(4, 2, 'Mariana López Martínez', '1', 'A', 'Mecánica', 'Juego de adaptado de sistemas', 1, 10.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_prestamo`
--

CREATE TABLE `detalle_prestamo` (
  `id_detalle` int(11) NOT NULL,
  `id_prestamos` int(11) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `pe` varchar(50) DEFAULT NULL,
  `grado` int(2) DEFAULT NULL,
  `grupo` varchar(1) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_prestamo`
--

INSERT INTO `detalle_prestamo` (`id_detalle`, `id_prestamos`, `nombre`, `pe`, `grado`, `grupo`, `codigo`, `cantidad`, `descripcion`) VALUES
(1, 1, 'Mariana López Martínez', 'Mecánica', 1, 'A', '5510', 1, 'Tacometro'),
(2, 1, 'Mariana López Martínez', 'Mecánica', 1, 'A', '5511', 1, 'Lata de nitrocelulosa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecuciones`
--

CREATE TABLE `ejecuciones` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejecuciones`
--

INSERT INTO `ejecuciones` (`id`, `fecha`) VALUES
(1, '2025-01-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `codigo` varchar(20) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `medidas` varchar(255) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `tipo_inventario` varchar(255) DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`codigo`, `descripcion`, `cantidad`, `categoria`, `medidas`, `ubicacion`, `tipo_inventario`, `fecha_actualizacion`) VALUES
('000012', 'Prensas tipo C ', 11, 'Herramienta', '4-6 Plg ', '1', 'Donado', '2024-12-13 16:03:38'),
('000141', 'Lapiz electrico para grabar ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('000210', 'Analizador para generedor ', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('000222', 'Monitor 4O TC', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('000223', 'Controlodaor de cargo portatil ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('002271', 'Tacometro ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:00:50'),
('002299', 'Juego de adaptado de sistemas', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('002300', 'Juego de medicion para sistema electronico', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('002301', 'Complemento de prueba de arnes ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('002302', 'Herramienta de acceso al codigo ', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('002304', 'Comprobador de sensor con prueba ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('002306', 'Etestocopio', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('002307', 'Comprobador de medidor con prueba ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('002308', 'Comprobador de 7 maneras ', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('002311', 'Medidor de vacio de presion en bomba ', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('002312', 'Adaptador de medicion de precision ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('002314', 'Juego de probador de extrangulador', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('002315', 'Balanceador de sistemas', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('002316', 'Juego de Medidor de presion ', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:00:50'),
('002321', 'Martillo grande ', 1, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('002332', 'Multimetro ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('009443', 'Cautin para soldar ', 5, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('014129', 'Monitor 17 plg ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('555', 'MARTILLO', 2, 'HERRAMIENTA', 'SN', '1', 'General', '2024-12-13 16:10:08'),
('888', 'TORNILLO', 2, 'METAL', '5', '2', 'General', '2024-12-13 16:11:55'),
('SC0', 'Bascula ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC1', 'Caja de letras de mecanica para cada mes ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC10', 'Tinta al aceite Alquidalíco ', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC11', 'Tinta al aceite universal ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC12', 'Aceite lubricante para transmision estandar ', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC13', 'Trapos para limpieza (Nuevos) ', 18, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC14', 'Esmalte Alquidálico ', 2, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC15', 'Esmalte acrílico de secado rapido ', 2, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC16', 'Esmalte acrílico fluorescente de secado rapido ', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC17', 'Esmalte acrílico de secado rapido con abado metálico ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC18', 'Anti salpicaduras', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC19', 'Esmalte indutrial en aerosol interiores y Exteriores Secado Rocket', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC2', 'Lata de nitrocelulosa ', 2, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC20', 'Esmalte acrílico en aerosol', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC21', 'Esmate alquidálico en aerosol ', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC22', 'Esmalte premium de maxima durabilidad', 3, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC23', 'WD-40', 4, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC24', 'Garlubsa SAE 60', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC25', 'Aceirte para motores de dos tiempos enfriados por aire', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC26', 'Rellenador de poliéster Ultra-Ligero/Massade Enchimento Productiva Body Filler ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC27', 'Alcohol 96 GL puro de caña ', 4, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC28', 'Fundente Flux Weld 246 Para usar en bronce', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC29', 'Pasta para soldar Plata 7445', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC3', 'Sellador concentrado ', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC30', 'Sellador para roscas ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC31', 'Estopas', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC32', 'Grasa superlubricante ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC33', 'Petos de carnaza (Usados)', 14, 'Proteccion personal para soldadura', 'SN', '3', 'UTVM', '2024-12-13 16:03:38'),
('SC34', 'Petos de carnaza (Nuevos )', 20, 'Proteccion personal para soldadura', 'SN', '3', 'Donado', '2024-12-13 16:03:38'),
('SC35', 'Guantes de carnaza (Usados)', 18, 'Proteccion personal para soldadura', 'SN', '3', 'UTVM', '2024-12-13 16:03:38'),
('SC36', 'Guantes de carnaza (Nuevos )', 20, 'Proteccion personal para soldadura', 'SN', '3', 'Donado', '2024-12-13 16:03:38'),
('SC37', 'Guantes de carnaza largos (Nuevos )', 5, 'Proteccion personal para soldadura', 'SN', '3', 'UTVM', '2024-12-13 16:03:38'),
('SC38', 'Escuadras magneticas ', 11, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC39', 'Batery Hydrometer ', 5, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('SC4', 'Repintado automotriz ', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC40', 'Probetas de aluminio ', 9, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('SC41', 'Baterias ', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC42', 'Llaves stilson ', 2, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC43', 'Niveles ', 6, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC44', 'Refaccion de fresador con torreta ', 3, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('SC45', 'Desarmadores con adaptador ', 16, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC46', 'Juego de avellanadores ', 3, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('SC47', 'Remachadora', 1, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC48', 'Desarmadoes de cruz ', 16, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('SC49', 'Desarmadores planos ', 10, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC5', 'Rellenador ligero ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC50', 'Brochas ', 18, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('SC51', 'Flexometros ', 18, 'Herramienta', 'SN', '1', 'UTVM', '2024-12-13 16:03:38'),
('SC52', 'Multimetros', 2, 'Herramienta', 'SN', '1', 'Donado', '2024-12-13 16:03:38'),
('SC6', 'Resanador para madera ', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC7', 'Resanador Automotriz Ultra ligero ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38'),
('SC8', 'Removedor especial lavable', 1, 'Pinturas', 'SN', '2', 'UTVM', '2024-12-13 16:03:38'),
('SC9', 'Tinta al aceite ', 1, 'Pinturas', 'SN', '2', 'Donado', '2024-12-13 16:03:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id_prestamos` int(11) NOT NULL,
  `matricula` int(7) DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `pdf_nombre` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'SIN ENTREGAR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id_prestamos`, `matricula`, `fecha`, `fecha_devolucion`, `pdf_nombre`, `status`) VALUES
(1, 2230099, '2024-12-11', '2024-12-11', 'prestamo_2230099_20241211052627.pdf', 'ENTREGADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `fecha`, `archivo`) VALUES
(1, '2025-02-01', 'reporte_adeudos_2025-02-01_16-19-41.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `usuario`, `contrasena`) VALUES
(1, 'admin', 'A]Y&o7W2(4M]');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adeudos`
--
ALTER TABLE `adeudos`
  ADD PRIMARY KEY (`id_adeudos`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `detalle_adeudo`
--
ALTER TABLE `detalle_adeudo`
  ADD PRIMARY KEY (`id_detaAde`),
  ADD KEY `id_adeudos` (`id_adeudos`),
  ADD KEY `id_adeudos_2` (`id_adeudos`);

--
-- Indices de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_prestamos` (`id_prestamos`),
  ADD KEY `codigo` (`codigo`);

--
-- Indices de la tabla `ejecuciones`
--
ALTER TABLE `ejecuciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id_prestamos`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adeudos`
--
ALTER TABLE `adeudos`
  MODIFY `id_adeudos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_adeudo`
--
ALTER TABLE `detalle_adeudo`
  MODIFY `id_detaAde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ejecuciones`
--
ALTER TABLE `ejecuciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id_prestamos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adeudos`
--
ALTER TABLE `adeudos`
  ADD CONSTRAINT `adeudos_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `alumnos` (`matricula`);

--
-- Filtros para la tabla `detalle_adeudo`
--
ALTER TABLE `detalle_adeudo`
  ADD CONSTRAINT `detalle_adeudo_ibfk_1` FOREIGN KEY (`id_adeudos`) REFERENCES `adeudos` (`id_adeudos`),
  ADD CONSTRAINT `fk_id_adeudos` FOREIGN KEY (`id_adeudos`) REFERENCES `adeudos` (`id_adeudos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
