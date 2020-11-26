-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2020 a las 00:21:23
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
  `guid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `download_links`
--

INSERT INTO `download_links` (`id`, `authorization`, `creation_date`, `expiration_date`, `client_ip`, `guid`) VALUES
(1, 'ybg54rdfs236hbg10', '2020-11-26 14:10:45', '2020-11-26 14:15:45', '189.176.16.58', 'b76b721f-301d-11eb-91ea-7c8ae14076e6'),
(2, 'qwerty', '2020-11-26 20:45:45', '2020-11-26 21:00:00', '127.0.0.1', ''),
(3, 'qwerty', '2020-11-26 20:45:45', '2020-11-26 21:00:00', '127.0.0.1', ''),
(4, 'qwerty', '2020-11-26 20:45:45', '2020-11-26 21:00:00', '127.0.0.1', 'dacc39e4-3039-11eb-b8f8-7c8ae14076e6'),
(5, 'qwerty', '2020-11-26 18:24:41', '2020-11-26 18:24:41', '127.0.0.1', 'dc6cf129-303d-11eb-b8f8-7c8ae14076e6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `download_links`
--
ALTER TABLE `download_links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `download_links`
--
ALTER TABLE `download_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
