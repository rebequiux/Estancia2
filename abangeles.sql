CREATE DATABASE abangeles;

USE abangeles;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2024 a las 15:27:52
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
-- Base de datos: `abangeles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Panaderia y mas', 'mas pan'),
(2, 'Carnes Frias', 'Carnes procesadas'),
(4, 'Alcohol', 'Bebidas alcoh?licas'),
(5, 'Limpieza', 'Productos de limpieza'),
(6, 'Lacteos', 'Leche fresca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(3, 3, 1, 3, 600.00),
(4, 3, 2, 5, 20.00),
(5, 0, 1, 5, 600.00),
(6, 0, 2, 5, 20.00),
(7, 0, 1, 2, 600.00),
(8, 0, 2, 5, 20.00),
(9, 0, 1, 6, 600.00),
(10, 0, 2, 5, 20.00),
(15, 10, 1, 6, 600.00),
(16, 10, 2, 5, 20.00),
(32, 19, 1, 2, 550.00),
(33, 19, 2, 5, 20.00),
(34, 20, 1, 2, 550.00),
(35, 20, 2, 5, 20.00),
(36, 21, 3, 2, 400.00),
(37, 22, 6, 1, 500.00),
(40, 102, 5, 3, 200.00),
(41, 102, 6, 2, 10.00),
(42, 103, 1, 5, 550.00),
(43, 103, 6, 5, 10.00),
(44, 104, 6, 2, 10.00),
(45, 104, 5, 1, 200.00),
(46, 105, 3, 1, 400.00),
(47, 105, 5, 1, 200.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Pagado','Cancelado') NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `venta_estado` enum('Sin Venta','Vendido') DEFAULT 'Sin Venta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `fecha`, `total`, `estado`, `venta_id`, `venta_estado`) VALUES
(1, 4, '2024-11-27 19:43:00', 1900.00, 'Pendiente', 0, 'Sin Venta'),
(3, 4, '2024-11-29 00:00:00', 1900.00, 'Pagado', 0, 'Sin Venta'),
(4, 3, '2024-11-25 00:00:00', 3100.00, 'Pagado', 0, 'Sin Venta'),
(5, 3, '2024-11-29 10:21:00', 1300.00, 'Pendiente', 0, 'Sin Venta'),
(6, 4, '2024-11-30 10:28:00', 3700.00, 'Pendiente', 0, 'Sin Venta'),
(10, 3, '2024-11-28 00:00:00', 3700.00, 'Pendiente', 0, 'Sin Venta'),
(19, 4, '2024-11-29 00:00:00', 1200.00, 'Pagado', 0, 'Sin Venta'),
(20, 0, '2024-11-29 00:00:00', 1200.00, 'Pendiente', 0, 'Sin Venta'),
(21, 4, '2024-11-29 00:00:00', 800.00, 'Pagado', 0, 'Sin Venta'),
(22, 4, '2024-11-29 00:00:00', 500.00, 'Pagado', 0, 'Sin Venta'),
(103, 4, '2024-11-30 00:00:00', 2800.00, '', 0, 'Sin Venta'),
(105, 11, '2024-11-29 00:00:00', 600.00, 'Pagado', 0, 'Sin Venta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `proveedor` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `total_vendido` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `producto`, `descripcion`, `precio`, `fecha_vencimiento`, `proveedor`, `categoria_id`, `imagen`, `total_vendido`) VALUES
(1, 'Barritas', 'Producto de pan', 30.00, '2024-11-26', 2, 1, '', 38),
(3, 'Donitas blancas', 'Producto del proveedor Bimbo', 400.00, '2024-11-29', 1, 1, '', 2),
(5, 'Doritos', 'Producto del proveedor Sabritas', 200.00, '2024-11-30', 1, 1, '', 3),
(6, 'Mirinda', 'Producto relacionado con el proveedor', 10.00, '2024-11-26', 2, 1, '', 13),
(19, 'Pingüinos', 'Producto relacionado con el proveedor', 200.00, '2024-11-27', 5, 1, '', 0),
(21, 'Papas', 'Papitas', 20.00, '2024-12-07', 3, 1, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_abastecimiento` date NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `descripcion`, `fecha_abastecimiento`, `precio`) VALUES
(2, 'Pepsi', 'refresco', '2024-11-26', 500.00),
(3, 'Sabritas', 'Trae cosas de sabritas', '2024-11-26', 3000.00),
(4, 'Coca Cola', 'Trae la coca', '2024-11-30', 200.00),
(6, 'Marinela', 'Marinela', '2024-12-07', 500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `contrasena` varchar(10) NOT NULL,
  `correo` varchar(111) NOT NULL,
  `tipo_usuario` enum('empleado','cliente','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `usuario`, `contrasena`, `correo`, `tipo_usuario`) VALUES
(1, 'admin_user', 'admin123', 'admin@correo.com', 'admin'),
(2, 'empleado1', 'empleado12', 'empleado1@correo.com', 'empleado'),
(3, 'cliente1', 'cliente123', 'cliente1@correo.com', 'cliente'),
(4, 'rebe', '123', 'ae@akjsd.com', 'cliente'),
(7, 'cinthia', '123', 'ei@gmail.com', 'cliente'),
(11, 'cliente3', '123', 'e@sjkfdj.com', 'cliente'),
(12, 'cliente3', '123', 'af@akjsd.com', 'cliente'),
(13, 'cliente2', '1234', 'u@sjkfdj.com', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_pedidos`
--

CREATE TABLE `usuario_pedidos` (
  `usuario_id` int(11) NOT NULL COMMENT 'Identificador del usuario que realiza el pedido',
  `pedido_id` int(11) NOT NULL COMMENT 'Identificador del pedido realizado por el usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Pagado','Cancelado') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `fecha`, `total`, `estado`) VALUES
(1, 1, '2024-11-28', 250.00, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalle`
--

CREATE TABLE `ventas_detalle` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `venta_id` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_detalle`
--

INSERT INTO `ventas_detalle` (`id`, `producto_id`, `cantidad`, `fecha_venta`, `venta_id`, `precio_unitario`) VALUES
(1, 2, 3, '0000-00-00', 1, 0.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalles_pedido_ibfk_1` (`pedido_id`),
  ADD KEY `detalles_pedido_ibfk_2` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`),
  ADD KEY `id_usuarios` (`id_usuarios`);

--
-- Indices de la tabla `usuario_pedidos`
--
ALTER TABLE `usuario_pedidos`
  ADD PRIMARY KEY (`usuario_id`,`pedido_id`) COMMENT 'Llave primaria compuesta de usuario y pedido',
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `venta_id` (`venta_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
