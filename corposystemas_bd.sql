-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2024 a las 17:56:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `corposystemas_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos_a`
--

CREATE TABLE `contratos_a` (
  `id_contrato` int(11) NOT NULL,
  `nombre_emisor` varchar(100) NOT NULL,
  `edad_emisor` int(11) NOT NULL,
  `dpi_emisor` varchar(13) NOT NULL,
  `nombre_receptor` varchar(100) NOT NULL,
  `edad_receptor` int(11) NOT NULL,
  `domicilio_receptor` varchar(200) NOT NULL,
  `dpi_receptor` varchar(13) NOT NULL,
  `departamento_emision` varchar(100) NOT NULL,
  `municipio_emision` varchar(100) NOT NULL,
  `nombre_contratante` varchar(100) NOT NULL,
  `fecha_patente` date NOT NULL,
  `numero_inscripcion` varchar(50) NOT NULL,
  `folio_registro` varchar(50) NOT NULL,
  `libro_registro` varchar(50) NOT NULL,
  `actividad_economica` text NOT NULL,
  `nit` varchar(15) NOT NULL,
  `tarifa_mensual` decimal(10,2) NOT NULL,
  `rango_documentos` varchar(50) NOT NULL,
  `cobro_unico` decimal(10,2) NOT NULL,
  `fecha_validez` date NOT NULL,
  `direccion_contratante` varchar(200) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contratos_a`
--

INSERT INTO `contratos_a` (`id_contrato`, `nombre_emisor`, `edad_emisor`, `dpi_emisor`, `nombre_receptor`, `edad_receptor`, `domicilio_receptor`, `dpi_receptor`, `departamento_emision`, `municipio_emision`, `nombre_contratante`, `fecha_patente`, `numero_inscripcion`, `folio_registro`, `libro_registro`, `actividad_economica`, `nit`, `tarifa_mensual`, `rango_documentos`, `cobro_unico`, `fecha_validez`, `direccion_contratante`, `fecha_creacion`) VALUES
(7, 'Pablo', 22, '192556811601', 'Juan Torres', 22, '8av 3-12 zona 2', '170689241601', 'Alta verapaz', 'coban', 'Los Juanes', '2024-10-28', '1002', '1000', '12', 'Venta carnes', '19959699', 200.00, '200', 200.00, '2024-10-28', '9av 4-14 zona 7 coban av', '2024-10-28 17:10:30'),
(8, 'Juan Pérez', 40, '1234567890101', 'Carlos López', 35, 'Ciudad de Guatemala', '9876543210102', 'Guatemala', 'Zona 1', 'Empresa XYZ', '0000-00-00', '123456', '45', 'Libro A', 'Consultoría', '12345678-9', 500.00, 'A001-A100', 1000.00, '0000-00-00', 'Avenida Central 5-10', '2024-10-29 23:49:49'),
(9, 'Juan Pérez', 40, '1234567890101', 'Carlos López', 35, 'Ciudad de Guatemala', '9876543210102', 'Guatemala', 'Zona 1', 'Empresa XYZ', '0000-00-00', '123456', '45', 'Libro A', 'Consultoría', '12345678-9', 500.00, 'A001-A100', 1000.00, '0000-00-00', 'Avenida Central 5-10', '2024-10-30 00:19:04'),
(10, 'Carlos López', 40, '1234567890101', 'Juan Pérez', 35, 'Ciudad de Guatemala', '9876543210102', 'Guatemala', 'Zona 1', 'Empresa XYZ', '2023-01-10', '123456', '45', 'Libro A', 'Consultoría', '12345678-9', 500.00, 'A001-A100', 1000.00, '2024-01-10', 'Avenida Central 5-10', '2024-11-04 06:41:01'),
(11, 'Carlos López', 40, '1234567890101', 'Juan Pérez', 35, 'Ciudad de Guatemala', '9876543210102', 'Guatemala', 'Zona 1', 'Empresa XYZ', '2023-01-10', '123456', '45', '25', 'Consultoría', '12345678-9', 500.00, '200', 1000.00, '2024-01-10', 'Avenida Central 5-10', '2024-11-04 06:43:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato_b`
--

CREATE TABLE `contrato_b` (
  `id_contrato` int(11) NOT NULL,
  `nombre_emisor` varchar(100) NOT NULL,
  `edad_emisor` int(11) NOT NULL,
  `dpi_emisor` varchar(20) NOT NULL,
  `nombre_distribuidor` varchar(100) NOT NULL,
  `edad_distribuidor` int(11) NOT NULL,
  `domicilio_distribuidor` varchar(200) NOT NULL,
  `dpi_distribuidor` varchar(20) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `representante_legal` enum('Propietario','Representante') NOT NULL,
  `entidad` varchar(100) NOT NULL,
  `tipo_documento` enum('Patente','Acta') NOT NULL,
  `notario` varchar(100) NOT NULL,
  `registro_mercantil` int(11) NOT NULL,
  `folio` int(11) NOT NULL,
  `libro` int(11) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `direccion_distribuidora` varchar(200) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contrato_b`
--

INSERT INTO `contrato_b` (`id_contrato`, `nombre_emisor`, `edad_emisor`, `dpi_emisor`, `nombre_distribuidor`, `edad_distribuidor`, `domicilio_distribuidor`, `dpi_distribuidor`, `municipio`, `departamento`, `representante_legal`, `entidad`, `tipo_documento`, `notario`, `registro_mercantil`, `folio`, `libro`, `nit`, `fecha_inicio`, `fecha_fin`, `direccion_distribuidora`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(2, 'Pablo', 22, '192556811601', 'Juan Torres', 22, 'Coban', '1921681001', 'Coban', 'Alta verapaz ', 'Propietario', 'Los Juanes', 'Patente', 'Perez gomez', 1500, 100, 15, '19959699', '2024-10-28', '2025-10-28', '8av 3-12 zona 5', '2024-10-28 17:25:08', '2024-10-28 17:25:08'),
(4, 'Pedro Gómez', 50, '1234567890001', 'Distribuidora XYZ', 45, 'Zona 10, Guatemala', '9876543210001', 'Guatemala', 'Guatemala', 'Propietario', 'Distribuidora ABC S.A.', 'Patente', 'Carlos Martínez', 98765, 12, 15, '78945612-3', '2024-05-01', '2025-05-01', 'Avenida Reforma 12-34, Guatemala', '2024-11-04 13:10:23', '2024-11-04 13:10:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato_c`
--

CREATE TABLE `contrato_c` (
  `id_contrato` int(11) NOT NULL,
  `edad_corpo` int(11) NOT NULL,
  `nombre_emisor` varchar(100) NOT NULL,
  `edad_emisor` int(11) NOT NULL,
  `dpi_emisor` varchar(20) NOT NULL,
  `departamento_emision_emisor` varchar(50) NOT NULL,
  `municipio_emision_emisor` varchar(50) NOT NULL,
  `representante_emisor` enum('Propietario','Representante') NOT NULL,
  `entidad_emisor` varchar(100) NOT NULL,
  `acredita_emisor` enum('Patente','Acta') NOT NULL,
  `notario_emisor` varchar(100) NOT NULL,
  `registro_mercantil_emisor` int(11) NOT NULL,
  `folio_emisor` int(11) NOT NULL,
  `libro_emisor` int(11) NOT NULL,
  `nombre_distribuidor` varchar(100) NOT NULL,
  `edad_distribuidor` int(11) NOT NULL,
  `dpi_distribuidor` varchar(20) NOT NULL,
  `departamento_emision_distribuidor` varchar(50) NOT NULL,
  `municipio_emision_distribuidor` varchar(50) NOT NULL,
  `representante_distribuidor` enum('Propietario','Representante') NOT NULL,
  `entidad_distribuidor` varchar(100) NOT NULL,
  `acredita_distribuidor` enum('Patente','Acta') NOT NULL,
  `notario_distribuidor` varchar(100) NOT NULL,
  `registro_mercantil_distribuidor` int(11) NOT NULL,
  `folio_distribuidor` int(11) NOT NULL,
  `libro_distribuidor` int(11) NOT NULL,
  `actividad_economica` varchar(150) NOT NULL,
  `nit_emisor` varchar(15) NOT NULL,
  `nit_distribuidor` varchar(15) NOT NULL,
  `fecha_vigencia` date NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contrato_c`
--

INSERT INTO `contrato_c` (`id_contrato`, `edad_corpo`, `nombre_emisor`, `edad_emisor`, `dpi_emisor`, `departamento_emision_emisor`, `municipio_emision_emisor`, `representante_emisor`, `entidad_emisor`, `acredita_emisor`, `notario_emisor`, `registro_mercantil_emisor`, `folio_emisor`, `libro_emisor`, `nombre_distribuidor`, `edad_distribuidor`, `dpi_distribuidor`, `departamento_emision_distribuidor`, `municipio_emision_distribuidor`, `representante_distribuidor`, `entidad_distribuidor`, `acredita_distribuidor`, `notario_distribuidor`, `registro_mercantil_distribuidor`, `folio_distribuidor`, `libro_distribuidor`, `actividad_economica`, `nit_emisor`, `nit_distribuidor`, `fecha_vigencia`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(5, 48, 'Pablo Santos', 22, '192556811601', 'Alta verapaz ', 'Coban ', 'Propietario', 'Trifuerza Card Games', 'Acta', 'Astrid Carolina Hernadez', 1980, 1002, 20, 'Juan Torres', 25, '19216813001', 'Alta Verapaz ', 'Coban ', 'Representante', 'Carnicería los pepes ', 'Acta', 'Joviel Obredo ', 10002, 1156, 4, 'Venta de Pollos y Carnes', '', '199599669', '2024-11-04', '2024-11-03 20:47:38', '2024-11-03 20:47:38'),
(6, 48, 'Pablo Santos', 40, '192556811601', 'Guatemala', 'Zona 1', 'Representante', 'Empresa Emisora S.A.', 'Patente', 'Lic. Juan López', 123456, 45, 150, 'Juan Torres', 45, '19216813001', 'Guatemala', 'Guatemala', 'Propietario', 'Distribuidora XYZ', 'Patente', 'Lic. Carlos Martínez', 987654, 12, 15, 'Venta al por mayor', '', '123456789-1', '2024-05-16', '2024-11-04 13:15:53', '2024-11-04 13:15:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `correo`, `usuario`, `password`, `fecha_registro`) VALUES
(1, 'Pablo', 'Santos', 'Carol@gmail.com', '465', '$2y$10$W.gfC48wpe2jMV8oGT6zSOvA90OkCiubEf/htysBIfgbKGDtbLUze', '2024-10-15 20:34:38'),
(2, 'Pablo', 'Santos', 'Andres2905@gmail.com', '', '$2y$10$JgFPkkdwrHzcybdsRUVU0eDR67TC6docRIF2Pla2dF3J003tBNZYO', '2024-10-15 21:19:01'),
(3, 'Pablo', 'Santos', 'mlpdbz300@gmail.com', 'mlpdbz300@gmail.com', '$2y$10$/PZY16Cv4miqptgxfGRmKuZQF1R1gC1hc9qsLl5uxH9PUX3IQqzSy', '2024-10-15 21:21:56'),
(5, 'Sheily ', 'Gonzalez', 'sheilyGonzalezAdmin@gmail.com', 'sheilyGonzalezAdmin@gmail.com', '$2y$10$uErTAuacRfyebMffPOuylu0tseZJeIOEqTePpERdB1h.Wwbk8Bmn.', '2024-10-21 22:48:07'),
(8, 'UsuarioPrueba', 'ApellidoPrueba', 'wfbhkogs@gmail.com', 'TestUser', '$2y$10$RVg9OfSUWpMnx80.laL3Ge4XHZHRE5/pByNqMoi2YEyoDNzOb9/Y2', '2024-10-30 02:37:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contratos_a`
--
ALTER TABLE `contratos_a`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `contrato_b`
--
ALTER TABLE `contrato_b`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `contrato_c`
--
ALTER TABLE `contrato_c`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contratos_a`
--
ALTER TABLE `contratos_a`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `contrato_b`
--
ALTER TABLE `contrato_b`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `contrato_c`
--
ALTER TABLE `contrato_c`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
