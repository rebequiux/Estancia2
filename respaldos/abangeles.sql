DROP TABLE IF EXISTS categorias;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO categorias VALUES("3","carnes frias","carnes","2024-11-29 12:33:28");
INSERT INTO categorias VALUES("5","Panaderia","pan","2024-11-29 12:37:43");



DROP TABLE IF EXISTS detalles_pedido;

CREATE TABLE `detalles_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `detalles_pedido_ibfk_1` (`pedido_id`),
  KEY `detalles_pedido_ibfk_2` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO detalles_pedido VALUES("4","3","2","5","20.00");
INSERT INTO detalles_pedido VALUES("6","0","2","5","20.00");
INSERT INTO detalles_pedido VALUES("8","0","2","5","20.00");
INSERT INTO detalles_pedido VALUES("10","0","2","5","20.00");
INSERT INTO detalles_pedido VALUES("16","10","2","5","20.00");
INSERT INTO detalles_pedido VALUES("33","19","2","5","20.00");
INSERT INTO detalles_pedido VALUES("35","20","2","5","20.00");
INSERT INTO detalles_pedido VALUES("50","107","23","1","23.00");
INSERT INTO detalles_pedido VALUES("51","107","24","1","30.00");
INSERT INTO detalles_pedido VALUES("52","107","21","1","20.00");
INSERT INTO detalles_pedido VALUES("60","111","23","1","23.00");
INSERT INTO detalles_pedido VALUES("65","112","23","1","23.00");
INSERT INTO detalles_pedido VALUES("66","113","25","1","28.00");
INSERT INTO detalles_pedido VALUES("67","113","24","1","30.00");
INSERT INTO detalles_pedido VALUES("70","113","23","1","23.00");



DROP TABLE IF EXISTS pedidos;

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Pagado','Cancelado') NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `venta_estado` enum('Sin Venta','Vendido') DEFAULT 'Sin Venta',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO pedidos VALUES("1","4","2024-11-27 19:43:00","1900.00","Pendiente","0","Sin Venta");
INSERT INTO pedidos VALUES("3","4","2024-11-29 00:00:00","1900.00","Pagado","0","Sin Venta");
INSERT INTO pedidos VALUES("4","3","2024-11-25 00:00:00","3100.00","Pagado","0","Sin Venta");
INSERT INTO pedidos VALUES("5","3","2024-11-29 10:21:00","1300.00","Pendiente","0","Sin Venta");
INSERT INTO pedidos VALUES("6","4","2024-11-30 10:28:00","3700.00","Pendiente","0","Sin Venta");
INSERT INTO pedidos VALUES("10","3","2024-11-28 00:00:00","3700.00","Pendiente","0","Sin Venta");
INSERT INTO pedidos VALUES("19","4","2024-11-29 00:00:00","1200.00","Pagado","0","Sin Venta");
INSERT INTO pedidos VALUES("20","0","2024-11-29 00:00:00","1200.00","Pendiente","0","Sin Venta");
INSERT INTO pedidos VALUES("21","4","2024-11-29 00:00:00","800.00","Pendiente","0","Sin Venta");
INSERT INTO pedidos VALUES("22","4","2024-11-29 00:00:00","500.00","Pagado","0","Sin Venta");
INSERT INTO pedidos VALUES("106","3","2024-11-29 09:37:55","90.00","Pendiente","","Sin Venta");
INSERT INTO pedidos VALUES("107","3","2024-11-29 09:38:50","73.00","Pendiente","","Sin Venta");
INSERT INTO pedidos VALUES("108","3","2024-11-29 00:00:00","105.00","Pagado","","Sin Venta");
INSERT INTO pedidos VALUES("111","3","2024-11-29 11:58:32","102.00","Pendiente","","Sin Venta");
INSERT INTO pedidos VALUES("112","3","2024-11-29 12:04:42","56.00","Pendiente","","Sin Venta");
INSERT INTO pedidos VALUES("113","3","2024-11-29 12:20:34","183.00","Pendiente","","Sin Venta");



DROP TABLE IF EXISTS productos;

CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `proveedor` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `total_vendido` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO productos VALUES("23","Leche Lala","lacteo","23.00","2024-12-04","6","6","","0");
INSERT INTO productos VALUES("24","cocacola","refresco dieta","30.00","2024-11-27","4","6","","0");
INSERT INTO productos VALUES("25","pepsi","refresco","28.00","2024-12-25","2","6","","0");
INSERT INTO productos VALUES("26","pan casero","Producto relacionado con el proveedor","15.00","2024-12-04","7","3","","0");
INSERT INTO productos VALUES("28","coca con azucar","Producto relacionado con el proveedor","45.00","2024-12-03","8","1","","0");
INSERT INTO productos VALUES("29","mantequilla","Producto del proveedor Marinela","45.00","2024-12-03","6","1","","0");



DROP TABLE IF EXISTS proveedores;

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_abastecimiento` date NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO proveedores VALUES("3","Sabritas","Trae cosas de sabritas","2024-11-26","3000.00");
INSERT INTO proveedores VALUES("4","Coca Cola","Trae la coca","2024-11-30","200.00");
INSERT INTO proveedores VALUES("6","Marinela","pan","2024-12-07","500.00");
INSERT INTO proveedores VALUES("7","molinera","pancito","2024-12-04","15.00");



DROP TABLE IF EXISTS usuario_pedidos;

CREATE TABLE `usuario_pedidos` (
  `usuario_id` int(11) NOT NULL COMMENT 'Identificador del usuario que realiza el pedido',
  `pedido_id` int(11) NOT NULL COMMENT 'Identificador del pedido realizado por el usuario',
  PRIMARY KEY (`usuario_id`,`pedido_id`) COMMENT 'Llave primaria compuesta de usuario y pedido',
  KEY `pedido_id` (`pedido_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) NOT NULL,
  `contrasena` varchar(10) NOT NULL,
  `correo` varchar(111) NOT NULL,
  `tipo_usuario` enum('empleado','cliente','admin') NOT NULL,
  PRIMARY KEY (`id_usuarios`),
  KEY `id_usuarios` (`id_usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO usuarios VALUES("1","admin_user","admin123","admin@correo.com","admin");
INSERT INTO usuarios VALUES("2","empleado1","empleado12","empleado1@correo.com","empleado");
INSERT INTO usuarios VALUES("3","cliente1","cliente123","cliente1@correo.com","cliente");
INSERT INTO usuarios VALUES("4","rebe","123","ae@akjsd.com","cliente");
INSERT INTO usuarios VALUES("7","cinthia","123","ei@gmail.com","cliente");
INSERT INTO usuarios VALUES("11","cliente3","123","sdfgfdse@sjkfdj.com","cliente");
INSERT INTO usuarios VALUES("12","cliente3","123","af@akjsd.com","cliente");
INSERT INTO usuarios VALUES("13","cliente2","1234","u@sjkfdj.com","cliente");
INSERT INTO usuarios VALUES("15","cliente10","cjejfi","cliente10@gmail.com","cliente");



DROP TABLE IF EXISTS ventas;

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Pagado','Cancelado') DEFAULT 'Pendiente',
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO ventas VALUES("1","1","2024-11-28","250.00","Pendiente");



DROP TABLE IF EXISTS ventas_detalle;

CREATE TABLE `ventas_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `venta_id` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`),
  KEY `venta_id` (`venta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO ventas_detalle VALUES("1","2","3","0000-00-00","1","0.00");



