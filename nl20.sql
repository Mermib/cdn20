-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2020 a las 06:28:04
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nl20`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `download_links`
--

CREATE TABLE `download_links` (
  `id` int(11) NOT NULL,
  `authorization` varchar(30) NOT NULL,
  `creation_date` datetime NOT NULL,
  `expiration_date` datetime NOT NULL,
  `client_ip` varchar(30) NOT NULL,
  `guid` varchar(50) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `download_links`
--

INSERT INTO `download_links` (`id`, `authorization`, `creation_date`, `expiration_date`, `client_ip`, `guid`, `used`) VALUES
(1, '1XG19764BF102810C', '2020-11-27 00:20:00', '2020-11-27 00:25:00', '127.0.0.1', '328835d9-3070-11eb-843c-7c8ae14076e6', 1),
(2, '2C441452AE441500B', '2020-11-27 00:26:15', '2020-11-27 00:31:15', '127.0.0.1', '11ac8323-3071-11eb-843c-7c8ae14076e6', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `download_links`
--
ALTER TABLE `download_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guid` (`guid`),
  ADD UNIQUE KEY `authorization` (`authorization`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `download_links`
--
ALTER TABLE `download_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
