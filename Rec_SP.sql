-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-12-2022 a las 00:08:07
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `recu_SP`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cripto`
--

CREATE TABLE `cripto` (
  `id` int(11) NOT NULL,
  `precio` float NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `nacionalidad` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cripto`
--

INSERT INTO `cripto` (`id`, `precio`, `nombre`, `foto`, `nacionalidad`) VALUES
(1, 50000, 'eterium', 'alemana_eterium.gif', 'alemana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` varchar(16) NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `usuario`, `clave`, `nombre`) VALUES
(2, 'admin', 'user01', '$2y$10$VQapi2UwXSfmUvpB31xHTOzdhXGa7iXWXGJF6b/EAU/22h/BeCeJy', 'Usuario 1'),
(3, 'cliente', 'user02', '$2y$10$WjmrTBaHIkooRSVBcAcIJOcYRY9.pCgqxZAKkBwP4HiXVo2z4GnMm', 'Usuario 2'),
(5, 'cliente', 'user03', '$2y$10$T3Bbty9aoUxKmsWCgBTNRun5RYesbYQN/Zu737zMvjiydvDBHYaQK', 'Usuario 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `nombreCripto` varchar(60) NOT NULL,
  `precio` float NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `nombreCripto`, `precio`, `usuario`, `foto`, `fecha`, `cantidad`) VALUES
(7, 'eterium', 300000, 'user02', 'eterium_user02_2022-12-06.gif', '2022-12-06', 12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cripto`
--
ALTER TABLE `cripto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cripto`
--
ALTER TABLE `cripto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;
