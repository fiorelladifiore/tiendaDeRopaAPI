-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2024 a las 03:59:01
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
-- Base de datos: `db_tiendaderopa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ropa`
--

CREATE TABLE `ropa` (
  `id_ropa` int(11) NOT NULL,
  `tipo` varchar(250) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `precio` double(10,2) NOT NULL,
  `talle` int(11) NOT NULL,
  `imagen` varchar(250) NOT NULL,
  `id_tienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ropa`
--

INSERT INTO `ropa` (`id_ropa`, `tipo`, `descripcion`, `precio`, `talle`, `imagen`, `id_tienda`) VALUES
(1, 'Remera', 'Marrón', 250.00, 2, 'remeraLargaMarron.png', 1),
(2, 'Pantalón nylon', 'Blanco', 900.00, 3, 'pantNylonBlanco.png', 1),
(3, 'Buzo', 'Azul', 500.00, 2, 'buzoCeleste.png', 1),
(4, 'Jogging', 'Gris', 750.00, 3, 'joggingGris.png', 2),
(5, 'Campera', 'Negra', 300.00, 1, 'camperaNegra.png', 2),
(6, 'Bermuda', 'Verde', 900.00, 1, 'bermudaVerde.png', 2),
(7, 'Remera', 'Verde', 250.00, 3, 'remeraVerde.png', 3),
(8, 'Musculosa', 'Blanca', 600.00, 2, 'musculosaBlanca.png', 3),
(11, 'Buzo', 'Gris', 400.00, 3, 'buzoGris.png', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `id_tienda` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`id_tienda`, `nombre`, `direccion`, `telefono`, `email`) VALUES
(1, 'Urban clothing BA', 'Montevideo 181', 11617287, 'urbanclothingba@gmail.com'),
(2, 'Urban clothing Cba', 'Ameghino 110', 351569877, 'urbanclothingcba@gmail.com'),
(3, 'Urban clothing SF', 'Alvear 678', 342413982, 'urbanclothingsf@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'webadmin', '$2y$10$2/mZFGAPzleQi.qHtcxICe/xOQ8qFyjPfc1dfd1ahtR1JlI67buRW', 'admin'),
(2, 'webuser', '$2y$10$vxKSdjhrr1zq2wEgCi6zD.BJxYJ1tZLeX/8JyknzXzrBBJz8s71Eu', 'default');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ropa`
--
ALTER TABLE `ropa`
  ADD PRIMARY KEY (`id_ropa`),
  ADD KEY `FK_ROPA_TIENDA` (`id_tienda`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id_tienda`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `ak_username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ropa`
--
ALTER TABLE `ropa`
  MODIFY `id_ropa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `tienda`
--
ALTER TABLE `tienda`
  MODIFY `id_tienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ropa`
--
ALTER TABLE `ropa`
  ADD CONSTRAINT `FK_ROPA_TIENDA` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
