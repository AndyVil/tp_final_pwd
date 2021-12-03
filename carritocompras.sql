-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2021 a las 11:40:41
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `carritocompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idusuario` bigint(20) NOT NULL,
  `coprecio` float(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `cofecha`, `idusuario`, `coprecio`) VALUES
(97, '2021-12-03 02:54:28', 1, 106939.99),
(98, '2021-12-03 10:26:21', 1, 8440.00),
(99, '2021-12-03 10:17:02', 1, 0.00),
(100, '2021-12-03 10:27:28', 1, 5500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT current_timestamp(),
  `cefechafin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestado`
--

INSERT INTO `compraestado` (`idcompraestado`, `idcompra`, `idcompraestadotipo`, `cefechaini`, `cefechafin`) VALUES
(84, 97, 2, '2021-12-02 14:54:06', '2021-12-03 10:10:50'),
(85, 98, 2, '2021-12-03 10:11:03', '2021-12-03 10:27:20'),
(86, 99, 2, '2021-12-03 10:17:02', '2021-12-03 10:17:02'),
(87, 100, 2, '2021-12-03 10:27:24', '2021-12-03 10:32:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'confirmada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'cancelada', 'cuando el usuario administrador envia a uno de las compras en estado =2 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL,
  `ciprecio` float(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraitem`
--

INSERT INTO `compraitem` (`idcompraitem`, `idproducto`, `idcompra`, `cicantidad`, `ciprecio`) VALUES
(200, 1220, 97, 8, 3760.00),
(201, 1219, 97, 4, 8000.00),
(202, 1221, 97, 1, 99999.99),
(206, 1220, 98, 2, 940.00),
(207, 1219, 98, 2, 4000.00),
(208, 1217, 98, 1, 3500.00),
(209, 1219, 100, 1, 2000.00),
(210, 1217, 100, 1, 3500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT current_timestamp() COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) VALUES
(1, 'admin_ini', 'Administrador', NULL, NULL),
(2, 'dep_ini', 'Deposito', NULL, NULL),
(3, 'cliente_ini', 'Catalogo', NULL, NULL),
(4, 'login', 'Log in', NULL, NULL),
(5, 'registro', 'Registrarse', NULL, NULL),
(6, 'cuenta', 'Cuenta', NULL, NULL),
(7, 'carrito', 'Carrito', 3, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menurol`
--

INSERT INTO `menurol` (`idmenu`, `idrol`) VALUES
(1, 1),
(1, 4),
(2, 2),
(2, 4),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(4, 4),
(5, 4),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(7, 3),
(7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `pronombre` varchar(15) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `procantstock` int(11) NOT NULL,
  `proprecio` float NOT NULL,
  `prodeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `pronombre`, `prodetalle`, `procantstock`, `proprecio`, `prodeshabilitado`) VALUES
(1217, 'remera', 'Remera algodon  S, M, L', 7, 3500, '0000-00-00 00:00:00'),
(1219, 'pantalon', 'pantalon XL', 46, 2000, '0000-00-00 00:00:00'),
(1220, 'otro', 'Gorra S', 47, 470, '0000-00-00 00:00:00'),
(1221, 'remera', 'Sin stock S', 50, 343000, '0000-00-00 00:00:00'),
(1227, 'otro', 'Campera S, M, L, XL', 41, 7000, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `roldescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `roldescripcion`) VALUES
(1, 'Admin'),
(2, 'Deposito'),
(3, 'Cliente'),
(4, 'superuser');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(50) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) VALUES
(1, '63a9f0ea7bb98050796b649e85481845', '63a9f0ea7bb98050796b649e85481845', 'root@root.com', '0000-00-00 00:00:00'),
(2, '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', '0000-00-00 00:00:00'),
(3, 'caaf856169610904e4f188e6ee23e88c', 'caaf856169610904e4f188e6ee23e88c', 'deposito@deposito.com', '0000-00-00 00:00:00'),
(4, '4983a0ab83ed86e0e7213c8783940193', '4983a0ab83ed86e0e7213c8783940193', 'cliente@cliente.com', '0000-00-00 00:00:00'),
(39, '7215ee9c7d9dc229d2921a40e899ec5f', '7215ee9c7d9dc229d2921a40e899ec5f', ' asdasdasd', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(3, 2),
(4, 3),
(39, 3),
(39, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1232;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
