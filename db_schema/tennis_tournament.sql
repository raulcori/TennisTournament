-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2024 a las 05:10:19
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
-- Base de datos: `tennis_tournament`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `gender` varchar(1) NOT NULL,
  `winner` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tournaments`
--

INSERT INTO `tournaments` (`id`, `startDate`, `gender`, `winner`) VALUES
(1, '2020-01-01', 'M', 'Carlos H'),
(2, '2020-01-02', 'M', 'Mariano D'),
(3, '2020-01-01', 'F', 'Laura S'),
(4, '2020-01-02', 'F', 'Wanda Z'),
(5, '2020-01-01', 'M', 'Jorge T'),
(6, '2020-01-02', 'M', 'Yamil H'),
(7, '2020-01-01', 'F', 'Florencia E'),
(8, '2020-01-01', 'M', 'Jugador08'),
(9, '2020-01-01', 'M', 'Jugador09'),
(10, '2020-01-01', 'M', 'Jugador02'),
(11, '2020-01-01', 'M', 'Jugador08'),
(12, '2020-01-01', 'M', 'Jugador07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
