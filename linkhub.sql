-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-10-2024 a las 06:25:01
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
-- Base de datos: `linkhub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_Cliente` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` int(20) NOT NULL,
  `Direccion` varchar(150) NOT NULL,
  `Edad` int(100) NOT NULL,
  `TypeClient` enum('Potencial','Recurrente','Fiel') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_Cliente`, `Nombre`, `Apellido`, `Correo`, `Telefono`, `Direccion`, `Edad`, `TypeClient`) VALUES
(1, 'Monica ', 'Ehuan Cisneros', 'moni@gmail.com', 2147483647, 'Violeta', 23, 'Recurrente'),
(2, 'Javier', 'Salazar', 'javi@gmail.com', 2147483647, 'Tacubaya', 45, 'Potencial'),
(3, 'Rocio', 'Blanco', 'roci@gmail.com', 981744698, 'Girasol', 34, 'Fiel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `ID_Empresas` int(11) NOT NULL,
  `Nom_Empresa` varchar(100) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `CorreoEmp` varchar(100) NOT NULL,
  `CantEmp` int(255) NOT NULL,
  `Rubro` varchar(100) NOT NULL,
  `NombreRepresentante` varchar(255) NOT NULL,
  `Cargo` enum('Director General','Gerente General','Director Comercial','Otro') NOT NULL,
  `NumTelefono` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`ID_Empresas`, `Nom_Empresa`, `Direccion`, `CorreoEmp`, `CantEmp`, `Rubro`, `NombreRepresentante`, `Cargo`, `NumTelefono`) VALUES
(12, 'LinkHub Ultra', 'Calle argentina 88A', 'linkhub@gmail.com', 3, 'Entretenimiento', 'Manuel David', 'Otro', '9811757780');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresaventas`
--

CREATE TABLE `empresaventas` (
  `ID_VentasEmpresa` int(11) NOT NULL,
  `Producto` varchar(100) NOT NULL,
  `Precio` int(255) NOT NULL,
  `EstadoVenta` varchar(25) NOT NULL,
  `Detalles` varchar(100) NOT NULL,
  `ID_Trabajador` int(11) NOT NULL,
  `ID_Empresas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresaventas`
--

INSERT INTO `empresaventas` (`ID_VentasEmpresa`, `Producto`, `Precio`, `EstadoVenta`, `Detalles`, `ID_Trabajador`, `ID_Empresas`) VALUES
(3, 'Computadoras de oficina', 120000, 'Cancelada', 'Computadoras con procesador i5 de 10ma generacion.', 2, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

CREATE TABLE `soporte` (
  `ID_Soporte` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `ID_Trabajador` int(11) NOT NULL,
  `Asunto` varchar(100) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `soporte`
--

INSERT INTO `soporte` (`ID_Soporte`, `ID_Cliente`, `ID_Trabajador`, `Asunto`, `Descripcion`) VALUES
(2, 3, 2, 'Problemas con algun producto.', 'El cliente afirma que el producto llegó defectuoso.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporteempresarial`
--

CREATE TABLE `soporteempresarial` (
  `ID_SoporteEmp` int(11) NOT NULL,
  `ID_Empresas` int(11) NOT NULL,
  `ID_Trabajador` int(11) NOT NULL,
  `Asunto` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `ID_Trabajador` int(11) NOT NULL,
  `Namefull` varchar(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `TypeAccount` enum('Administrador','Trabajador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`ID_Trabajador`, `Namefull`, `Username`, `Correo`, `Pass`, `TypeAccount`) VALUES
(1, 'Superusuario', 'Administrador 1', 'su@gmail.com', '$2y$10$mpWVSH4dA3sic5ZDLDRanOzze8Iu6qbABKUESeFM7dt.hLnOEUDFu', 'Administrador'),
(2, 'Manuel David', 'Manu169', 'manu@gmail.com', '$2y$10$ZaFuYaYYNGGHuQjGHeFe5.0qHpsZYWcXz7U1cIeOySmDji3vK8CFa', 'Trabajador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `ID_Ventas` int(11) NOT NULL,
  `Producto` varchar(255) NOT NULL,
  `Precio` int(255) NOT NULL,
  `Estado` enum('En Proceso','Finalizada','Cancelada') NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `ID_Trabajador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`ID_Ventas`, `Producto`, `Precio`, `Estado`, `ID_Cliente`, `ID_Trabajador`) VALUES
(1, 'Laptop', 2500, 'En Proceso', 1, 2),
(2, 'PC GAMER', 23500, 'En Proceso', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`ID_Empresas`);

--
-- Indices de la tabla `empresaventas`
--
ALTER TABLE `empresaventas`
  ADD PRIMARY KEY (`ID_VentasEmpresa`),
  ADD KEY `ID_Trabajador` (`ID_Trabajador`,`ID_Empresas`),
  ADD KEY `ID_Empresas` (`ID_Empresas`);

--
-- Indices de la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`ID_Soporte`),
  ADD KEY `ID_Cliente` (`ID_Cliente`,`ID_Trabajador`),
  ADD KEY `ID_Trabajador` (`ID_Trabajador`);

--
-- Indices de la tabla `soporteempresarial`
--
ALTER TABLE `soporteempresarial`
  ADD PRIMARY KEY (`ID_SoporteEmp`),
  ADD KEY `ID_Empresas` (`ID_Empresas`,`ID_Trabajador`),
  ADD KEY `ID_Trabajador` (`ID_Trabajador`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`ID_Trabajador`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`ID_Ventas`),
  ADD KEY `ID_Cliente` (`ID_Cliente`,`ID_Trabajador`),
  ADD KEY `ID_Trabajador` (`ID_Trabajador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `ID_Empresas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `empresaventas`
--
ALTER TABLE `empresaventas`
  MODIFY `ID_VentasEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `soporte`
--
ALTER TABLE `soporte`
  MODIFY `ID_Soporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `soporteempresarial`
--
ALTER TABLE `soporteempresarial`
  MODIFY `ID_SoporteEmp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `ID_Trabajador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `ID_Ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empresaventas`
--
ALTER TABLE `empresaventas`
  ADD CONSTRAINT `empresaventas_ibfk_1` FOREIGN KEY (`ID_Trabajador`) REFERENCES `trabajadores` (`ID_Trabajador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresaventas_ibfk_2` FOREIGN KEY (`ID_Empresas`) REFERENCES `empresas` (`ID_Empresas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `soporte_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soporte_ibfk_2` FOREIGN KEY (`ID_Trabajador`) REFERENCES `trabajadores` (`ID_Trabajador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `soporteempresarial`
--
ALTER TABLE `soporteempresarial`
  ADD CONSTRAINT `soporteempresarial_ibfk_1` FOREIGN KEY (`ID_Empresas`) REFERENCES `empresas` (`ID_Empresas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soporteempresarial_ibfk_2` FOREIGN KEY (`ID_Trabajador`) REFERENCES `trabajadores` (`ID_Trabajador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`ID_Trabajador`) REFERENCES `trabajadores` (`ID_Trabajador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
