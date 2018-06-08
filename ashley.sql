-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-06-2018 a las 19:52:04
-- Versión del servidor: 10.0.32-MariaDB-0+deb8u1
-- Versión de PHP: 7.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ashley`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `eliminado` enum('0','1') NOT NULL DEFAULT '0',
  `bloqueado` enum('0','1') NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL,
  `rol` varchar(50) NOT NULL DEFAULT 'Administrador'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `usuario`, `nombre`, `apellido`, `correo`, `clave`, `telefono`, `eliminado`, `bloqueado`, `fecha`, `rol`) VALUES
(1, 'maye', 'mayerly', 'rios', 'admin@correo.com', '$2a$10$vaOOjhNCJzp4cBwuYS4/deXx5z55ohxUoO42QlFjKWcqm7ewQReei', '74564', '0', '0', '2018-06-02 00:00:00', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `balance_punto`
--

CREATE TABLE `balance_punto` (
  `id` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `credito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `balance_punto`
--

INSERT INTO `balance_punto` (`id`, `id_administrador`, `id_usuario`, `concepto`, `credito`, `debito`, `fecha`) VALUES
(1, 1, 1, 'es', '11.00', '0.00', '2018-05-03 00:00:00'),
(2, 1, 1, 'cdxs', '5.00', '0.00', '2018-06-01 12:29:00'),
(3, 1, 1, 'es', '34.00', '0.00', '2018-05-03 00:00:00'),
(4, 1, 1, 'cdxs', '0.00', '5.00', '2018-06-01 12:29:00'),
(5, 1, 3, '', '100.00', '0.00', '2018-06-02 18:21:44'),
(6, 1, 3, 'asd sdasd', '0.00', '50.00', '2018-06-02 18:24:40'),
(7, 1, 3, 'zxc as asd', '55.00', '0.00', '2018-06-02 18:25:09'),
(8, 1, 1, 'sdfsdff', '350.00', '0.00', '2018-06-02 18:39:59'),
(9, 1, 1, 'decuento', '0.00', '7.00', '2018-06-02 18:44:01'),
(10, 1, 1, 'sdfsdf', '0.00', '3.00', '2018-06-02 18:44:34'),
(11, 1, 1, 'ihj', '120.00', '0.00', '2018-06-03 07:39:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `eliminado` enum('0','1') NOT NULL DEFAULT '0',
  `bloqueado` enum('0','1') NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL,
  `rol` varchar(50) DEFAULT 'Empleado'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `id_administrador`, `usuario`, `nombre`, `apellido`, `correo`, `clave`, `telefono`, `direccion`, `eliminado`, `bloqueado`, `fecha`, `rol`) VALUES
(1, 1, 'laura', 'laura', 'sanchez', 'correo@correo.com', '$2a$10$kzH8K.eGDStCqG.CjSpZpe.idtB7Yvj0PwEV9Opi8v/y4iIYklRyq', '300459834', 'calle 32 numero 34', '0', '0', '0000-00-00 00:00:00', 'Empleado'),
(2, 1, 'fulano', 'fulano', 'fulano', 'fulano@correo.com', '12345', '300456534534', 'avebjis32 numero 34', '1', '0', '0000-00-00 00:00:00', 'Empleado'),
(3, 1, '', 'carlos', 'perez', 'carlos@carlos.com', '1', '234234234', 'calle 56', '0', '0', '2018-06-02 16:54:58', 'Empleado'),
(4, 1, '', '2311', '13321', '31213213@asdas.dasd', '13132', '133', '13', '1', '0', '2018-06-02 16:58:38', 'Empleado'),
(5, 1, '', 'josefina', 'toress', 'jose@torres.com', 'werwerewrwerwerwerwerwer', '3993423423', 'calle 43', '0', '0', '2018-06-02 16:59:19', 'Empleado'),
(6, 1, '', '1323', '1213', '13232@asd.asds', '31231', '3213132132', '3132132', '0', '0', '2018-06-03 06:48:48', 'Empleado'),
(7, 1, '', 'dfasdf', 'asdfasdf', 'correo5@correo.com', '', 'sdfdsf', 'sdfasdf', '0', '0', '2018-06-03 06:57:16', 'Empleado'),
(8, 1, '', 'tertwe', 'twewet', 'correo2@correo.comDel0603061326', '', 'ertert', 'etert', '1', '0', '2018-06-03 06:57:22', 'Empleado'),
(9, 1, '', '1', '1', '1@sd.sdsd', '12345', '1', '1', '0', '0', '2018-06-03 07:05:18', 'Empleado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `balance_punto`
--
ALTER TABLE `balance_punto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `balance_punto`
--
ALTER TABLE `balance_punto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
