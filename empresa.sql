-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2023 a las 23:11:38
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `empresa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaPedido` date NOT NULL,
  `estado` varchar(250) DEFAULT NULL,
  `detalles` varchar(250) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `idUsuario`, `fechaPedido`, `estado`, `detalles`, `total`) VALUES
(64, 12, '2023-06-16', 'En proceso', 'GTA V x1, Minecraft: Java Edition (PC) x5', 44993),
(65, 12, '2023-06-16', 'Completado', 'Minecraft: Java Edition (PC) x2, Dragon Ball: Xenoverse 2  x1', 10498),
(67, 12, '2023-06-17', 'En proceso', 'Minecraft: Java Edition (PC) x4', 19996),
(69, 12, '2023-06-17', 'Pendiente', 'Mortal Kombat 11 x2, God of War x1', 2333),
(70, 12, '2023-06-17', 'En proceso', 'Mortal Kombat 11 x6, God of War x1', 6777),
(71, 12, '2023-06-17', 'Completado', 'FIFA 23 x3, 7 Days to Die x1, Minecraft: Java Edition (PC) x1, Mortal Kombat 11 x2', 695846),
(73, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6 - $31231 x 1\n7 Days to Die - $312312 x 1\n', 343543),
(78, 12, '2023-06-17', 'Pendiente', 'Juego: GTA V, Cantidad: 1, Subtotal: 19998\nJuego: Minecraft: Java Edition (PC), Cantidad: 1, Subtotal: 312312\n', 332310),
(80, 12, '2023-06-17', 'Pendiente', 'Juego: God of War, Cantidad: 1Juego: Tekken 7, Cantidad: 1', 312423),
(81, 12, '2023-06-17', 'Pendiente', 'Juego: GTA V, x 1Juego: Minecraft: Java Edition (PC), x 1', 332310),
(82, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6, x 1God of War, x 1Tekken 7, x 1', 343654),
(83, 12, '2023-06-17', 'Pendiente', '', 343654),
(84, 12, '2023-06-17', 'Pendiente', 'Tekken 7, x 1Ready or Not (PC), x 1', 325543),
(85, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6 x 1Dragon Ball: Xenoverse 2  x 1', 31731),
(86, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6 x 1Dragon Ball: Xenoverse 2  x 1FIFA 23 x 1', 54731),
(87, 12, '2023-06-17', 'Pendiente', 'Tekken 7 x  1 , God of War x  1 , ', 312423),
(88, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6 x  1 ,Tekken 7 x  2 ,', 655855),
(89, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6 x  1 ,', 31231),
(90, 12, '2023-06-17', 'Pendiente', 'God of War x  1 ,Tekken 7 x  1 ,', 312423),
(91, 12, '2023-06-17', 'Pendiente', '', 312423),
(92, 12, '2023-06-17', 'Pendiente', '', 312423),
(93, 12, '2023-06-17', 'En proceso', '', 312423),
(94, 12, '2023-06-17', 'Pendiente', '', 312423),
(95, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6 x  1 ,God of War x  1 ,', 31342),
(96, 12, '2023-06-17', 'Pendiente', 'Tekken 7 x  1 ,Dragon Ball: Xenoverse 2  x  1 ,', 312812),
(97, 12, '2023-06-17', 'Pendiente', 'Street Fighter 6 x  1 ,Tekken 7 x  1 ,', 343543),
(98, 12, '2023-06-17', 'Pendiente', 'Dragon Ball: Xenoverse 2  x  1 ,FIFA 23 x  1 ,', 23500),
(99, 12, '2023-06-17', 'Pendiente', 'Tekken 7 x  1 ,Minecraft: Java Edition (PC) x  1 ,', 624624),
(100, 12, '2023-06-17', 'Pendiente', 'GTA V x  1 ,Minecraft: Java Edition (PC) x  1 ,', 332310),
(101, 12, '2023-06-17', 'Pendiente', 'GTA V x  1 ,Minecraft: Java Edition (PC) x  1 ,', 332310),
(103, 12, '2023-06-17', 'Pendiente', 'Minecraft: Java Edition (PC) x  1 ,', 312312),
(104, 12, '2023-06-17', 'Pendiente', 'Dragon Ball: Xenoverse 2  x  1 ,', 500),
(105, 12, '2023-06-17', 'Pendiente', 'Minecraft: Java Edition (PC) x  1 ,', 312312),
(106, 12, '2023-06-17', 'Pendiente', 'Minecraft: Java Edition (PC) x  1 ,', 312312),
(107, 12, '2023-06-17', 'Pendiente', 'Minecraft: Java Edition (PC) x  1 ,Ready or Not (PC) x  1 ,', 325543),
(108, 12, '2023-06-17', 'Pendiente', 'FIFA 23 x  1 ,Dragon Ball: Xenoverse 2  x  1 ,', 23500),
(109, 12, '2023-06-17', 'Pendiente', 'GTA V x  1 ,FIFA 23 x  1 ,', 42998),
(110, 12, '2023-06-18', 'Pendiente', 'FIFA 23 x  1 ,', 23000),
(111, 12, '2023-06-18', 'Pendiente', 'GTA V x  1 ,', 19998),
(112, 12, '2023-06-18', 'Completado', '', 19998),
(113, 12, '2023-06-18', 'Pendiente', 'Dragon Ball: Xenoverse 2  x  1 ,GTA V x  1 ,', 20498),
(114, 12, '2023-06-18', 'Pendiente', 'GTA V x  1 ,Minecraft: Java Edition (PC) x  1 ,', 332310),
(115, 12, '2023-06-18', 'Pendiente', 'GTA V x  4 ,Minecraft: Java Edition (PC) x  2 ,', 704616),
(116, 2, '2023-06-18', 'Pendiente', 'GTA V x  1 ,Minecraft: Java Edition (PC) x  1 ,', 332310),
(117, 2, '2023-06-18', 'Pendiente', 'GTA V x  1 ,Minecraft: Java Edition (PC) x  1 ,', 332310),
(118, 2, '2023-06-18', 'Pendiente', 'Ready or Not (PC) x  2 ,', 26462),
(119, 2, '2023-06-18', 'Pendiente', 'GTA V x  3 ,Minecraft: Java Edition (PC) x  2 ,Ready or Not (PC) x  2 ,', 711080),
(120, 2, '2023-06-18', 'Pendiente', 'GTA V x  1 ,', 19998),
(121, 2, '2023-06-18', 'Pendiente', 'Minecraft: Java Edition (PC) x  1 ,Ready or Not (PC) x  2 ,', 338774),
(122, 2, '2023-06-18', 'Pendiente', '7 Days to Die x  1 ,', 312312),
(123, 2, '2023-06-18', 'Pendiente', 'Minecraft: Java Edition (PC) x  59 ,', 18426408),
(124, 2, '2023-06-18', 'Pendiente', 'Minecraft: Java Edition (PC) x  4 ,Ready or Not (PC) x  36 ,NBA 2K23 (PC) x  1 ,', 1727696),
(125, 2, '2023-06-18', 'Pendiente', '', 1727696),
(126, 2, '2023-06-18', 'Pendiente', '7 Days to Die x  2 ,', 624624),
(127, 2, '2023-06-18', 'Pendiente', 'Dragon Ball: Xenoverse 2  x  3 ,', 1500),
(128, 12, '2023-06-18', 'Pendiente', 'NBA 2K23 (PC) x  13 ,', 27716),
(129, 12, '2023-06-18', 'Pendiente', 'NBA 2K23 (PC) x  11 ,', 23452),
(130, 12, '2023-06-18', 'Pendiente', 'NBA 2K23 (PC) x  7 ,', 14924),
(131, 12, '2023-06-18', 'Pendiente', '', 14924),
(132, 12, '2023-06-18', 'Pendiente', 'Mortal Kombat 11 x  1 ,God of War x  1 ,Tekken 7 x  1 ,', 16997),
(133, 12, '2023-06-18', 'Pendiente', 'FIFA 23 x  5 ,Mortal Kombat 11 x  3 ,God of War x  4 ,', 109993),
(134, 12, '2023-06-18', 'Pendiente', 'Mortal Kombat 11 x  8 ,', 79992),
(135, 12, '2023-06-18', 'Pendiente', 'Mortal Kombat 11 x  25 ,', 249975),
(136, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  2 ,GTA V x  4 ,Street Fighter 6 x  1 ,', 101989),
(137, 12, '2023-06-19', 'Pendiente', '', 101989),
(138, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(139, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(140, 12, '2023-06-19', 'Pendiente', '', 9999),
(141, 12, '2023-06-19', 'Pendiente', '7 Days to Die x  1 ,', 7999),
(142, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(143, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  6 ,', 59994),
(144, 12, '2023-06-19', 'Pendiente', '7 Days to Die x  1 ,', 7999),
(145, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(146, 12, '2023-06-19', 'Pendiente', '', 9999),
(147, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(148, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(149, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(150, 12, '2023-06-19', 'Pendiente', '', 9999),
(151, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(152, 12, '2023-06-19', 'Pendiente', '', 9999),
(153, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(154, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,7 Days to Die x  18 ,', 153981),
(155, 12, '2023-06-19', 'Pendiente', 'Street Fighter 6 x  1 ,Tekken 7 x  1 ,', 0),
(156, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  2 ,', 19998),
(157, 12, '2023-06-19', 'Pendiente', '', 19998),
(158, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  2 ,', 19998),
(159, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(160, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  3 ,', 29997),
(161, 12, '2023-06-19', 'Pendiente', 'Street Fighter 6 x  4 ,', 7996),
(162, 12, '2023-06-19', 'Pendiente', '', 7996),
(163, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  5 ,', 49995),
(164, 12, '2023-06-19', 'Pendiente', '', 49995),
(165, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  2 ,', 19998),
(166, 12, '2023-06-19', 'Pendiente', '', 19998),
(167, 12, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  2 ,', 19998),
(168, 22, '2023-06-19', 'Pendiente', 'Minecraft: Java Edition (PC) x  2 ,', 624624),
(169, 22, '2023-06-19', 'Pendiente', 'Mortal Kombat 11 x  1 ,', 9999),
(170, 22, '2023-06-19', 'Pendiente', '', 9999),
(171, 12, '2023-06-22', 'Pendiente', 'Tekken 7 x  12 ,', 23988),
(172, 12, '2023-06-22', 'Pendiente', 'Tekken 7 x  1 ,Mortal Kombat 11 x  1 ,', 11998),
(173, 22, '2023-06-25', 'Pendiente', 'Street Fighter 6 x  3 ,', 5997),
(174, 1, '2023-06-25', 'Pendiente', 'FIFA 23 x  20 ,', 240000),
(175, 4, '2023-06-26', 'Pendiente', 'Tekken 7 x  4 ,', 7996),
(176, 4, '2023-06-26', 'Pendiente', 'Tekken 7 x  3 ,', 5997),
(177, 4, '2023-06-26', 'Pendiente', '', 5997),
(178, 4, '2023-06-26', 'Pendiente', 'Tekken 7 x  4 ,', 7996),
(179, 4, '2023-06-26', 'Pendiente', 'Tekken 7 x  2 ,', 3998),
(180, 4, '2023-06-26', 'Pendiente', 'MoveOrDie x  2 ,', 400),
(181, 4, '2023-06-26', 'Pendiente', '7 Days to Die x  5 ,Tekken 7 x  3 ,', 45992),
(182, 4, '2023-06-27', 'Pendiente', 'Dragon Ball: Xenoverse 2  x  6 ,', 59994),
(183, 4, '2023-06-27', 'En proceso', 'Mortal Kombat 11 x  1 ,7 Days to Die x  1 ,Street Fighter 6 x  1 ,', 22999),
(184, 4, '2023-06-27', 'Pendiente', 'Mortal Kombat 11 x  1 ,7 Days to Die x  1 ,', 17998),
(185, 51, '2023-06-27', 'Pendiente', 'Mortal Kombat 11 x  1 ,Tekken 7 x  1 ,Dragon Ball: Xenoverse 2  x  1 ,', 21997),
(186, 12, '2023-06-27', 'Pendiente', '7 Days to Die x  1 ,Street Fighter 6 x  1 ,', 13000),
(187, 54, '2023-06-27', 'Pendiente', 'Mortal Kombat 11 x  1 ,God of War x  1 ,', 14998),
(188, 59, '2023-06-27', 'Pendiente', 'Mortal Kombat 11 x  1 ,God of War x  1 ,', 14998),
(189, 12, '2023-06-27', 'Pendiente', 'Atlas Fallen x  2 ,', 90000),
(190, 12, '2023-06-27', 'En proceso', '7 Days to Die x  2 ,', 15998),
(191, 12, '2023-06-27', 'Pendiente', 'Tiny Tina\'s Wonderlands  x  5 ,', 615655),
(192, 12, '2023-07-04', 'Pendiente', 'Ready or Not (PC) x  3 ,', 39693),
(193, 12, '2023-07-05', 'Pendiente', 'Elden Ring x  4 ,', 10220),
(194, 12, '2023-07-05', 'Pendiente', 'Minecraft: Java Edition (PC) x  3 ,Ready or Not (PC) x  1 ,Move or Die x  2 ,Atlas Fallen x  1 ,', 1000967),
(195, 12, '2023-07-06', 'Pendiente', 'Minecraft: Java Edition (PC) x  1 ,Ready or Not (PC) x  1 ,', 326),
(196, 12, '2023-07-06', 'Pendiente', 'Ready or Not (PC) x  3 ,', 39693),
(197, 12, '2023-07-06', 'Pendiente', 'Ready or Not (PC) x  1 ,Minecraft: Java Edition (PC) x  1 ,', 325543),
(198, 12, '2023-07-06', 'Pendiente', '', 325543),
(199, 12, '2023-07-06', 'Pendiente', '', 325543),
(200, 12, '2023-07-06', 'Pendiente', 'Move or Die x  2 ,', 5800),
(201, 12, '2023-07-06', 'Pendiente', '', 5800),
(202, 12, '2023-07-06', 'Pendiente', '', 5800),
(203, 12, '2023-07-06', 'Pendiente', '', 5800),
(204, 12, '2023-07-06', 'Pendiente', 'Minecraft: Java Edition (PC) x  2 ,', 624624),
(205, 71, '2023-07-06', 'Pendiente', 'Dragon Ball: Xenoverse 2  x  7 ,FIFA 23 x  1 ,Minecraft: Java Edition (PC) x  1 ,', 394305);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL,
  `Rol` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID`, `Rol`) VALUES
(1, 'Administrador'),
(2, 'Trabajador'),
(3, 'Jefe'),
(4, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `correoUsuario` varchar(250) NOT NULL,
  `passUsuario` varchar(250) NOT NULL,
  `ID_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `correoUsuario`, `passUsuario`, `ID_Rol`) VALUES
(1, 'lucasjimenez@gmail.com', 'Lucas2000', 1),
(3, 'lucasjefe@gmail.com', 'Lucas2000', 3),
(12, 'usuario@gmail.com', 'Lucas2000', 4),
(50, 'lucastrabajador@gmail.com', 'Lucas2000', 2),
(52, 'qwertyxz@gmail.com', '3123123', 1),
(71, 'usuarioPr@gmail.com', 'Lucas2000', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojuego`
--

CREATE TABLE `videojuego` (
  `idJuego` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `precio` int(11) NOT NULL,
  `imagen` varchar(250) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `videojuego`
--

INSERT INTO `videojuego` (`idJuego`, `titulo`, `descripcion`, `precio`, `imagen`, `stock`) VALUES
(13, 'Dragon Ball: Xenoverse 2 ', 'Crees que Dragon Ball es lo mejor que ha pasado nunca? Con Dragon Ball Xenoverse 2 key, podrás nuevamente adentrarte en el mundo del popular anime, crear tu personaje y seguir las historias que amas, tomando ventaja de la nueva ciudad central, gráfic', 9999, 'imagenesJuegos/dragonball.jpg', 97),
(14, 'FIFA 23', 'FIFA World Cup™ para hombres y mujeres, equipos de clubes, funciones de juego cruzado y aún más en forma de clave de FIFA 23 (PC) Origin. Marca un acontecimiento histórico y un cambio en el género de los juegos deportivos. Desde 1993, los juegos de l', 12000, 'imagenesJuegos/fifa23.jpg', 11),
(15, 'GTA V', 'Al comprar Grand Theft Auto V: Edición online Premium te sumergirás en el inmenso mundo de GTA online con un montón de contenido. No sólo obtendrás el juego base, Grand Theft Auto V, sino que también encontrarás Criminal Enterprise Starter Pack. ¡Val', 19998, 'imagenesJuegos/gtav.jpeg', 0),
(16, 'Minecraft: Java Edition (PC)', '¡El mundo entero a tu alrededor está hecho de bloques, toda la realidad está hecha de bloques! ¡Aves, ovejas, nubes y agua son bloques! Un mundo sin fin, o más bien, eterno, lleno de cuevas, mazmorras, monstruos… Y la mejor parte es que puedes recole', 312312, 'imagenesJuegos/minecrafttt.jpeg', 92),
(19, 'Ready or Not (PC)', 'El juego Ready or Not (PC) Código de Steam es un intenso shooter en primera persona, ambientado en la época moderna, donde el jugador controla una unidad SWAT en peligrosos encuentros con terroristas y entornos realistas. Los desarrolladores de este ', 13231, 'imagenesJuegos/Read.jpg', 35),
(28, 'NBA 2K23 (PC)', '¿Quién está preparado para convertirse en una leyenda de la NBA? La emoción del baloncesto te espera en NBA 2K23. Prepárate para los distintos modos de juego y las nuevas características que ofrece el nuevo juego de la serie. El modo Carrera es aún m', 2132, 'imagenesjuegos/nba.jpg', 0),
(29, 'Move or Die', 'La clave Move or Die en Steam es el sello distintivo de los títulos de acción, ¡listo para llevar a los jugadores a una experiencia de juego única! Presentado por los famosos That Awesome Guys, el título supera las expectativas y brinda entretenimien', 2900, 'imagenesjuegos/moveordie.jpeg', 251),
(42, 'Atlas Fallen', 'Abraza tu destino como el salvador de la humanidad y libérate de las garras de las deidades malévolas con Atlas Fallen Steam key. Atraviesa la vasta extensión atemporal de una tierra impregnada de antigüedad, repleta de peligros, enigmas y restos de ', 45000, 'imagenesjuegos/atlas.jpg', 4),
(43, 'Tiny Tina\'s Wonderlands ', 'Sumérgete en una épica y extraña aventura llena de misterios y poderosas armas. Balas, magia y espadas se estrellan en el caótico mundo de Tiny Tina\'s Wonderlands de Epic Games, presentado por la propia Tiny Tina. Crea tu propio personaje de varias c', 123131, 'imagenesjuegos/tiny.jpeg', 0),
(44, 'Euro Truck Simulator 2', 'Este es el segundo juego de la serie Euro Truck Simulator en este caso Euro Truck Simulator 2 te hara vivir lo que es ser un conductor de camiones de larga distancia. Este simulador le permite elegir su camión, recoger la carga y entregarla al punto ', 1455, 'imagenesjuegos/euro.jpg', 5),
(45, 'Black Skylands', '¡Sumérgete en una aventura de acción de mundo abierto donde el único límite es el propio cielo! Hungry Couch Games y tinyBuild se enorgullecen de presentar su más reciente proyecto: un juego sandbox atmosférico con un gran énfasis en la exploración, ', 4444, 'imagenesjuegos/BlackSky.jpeg', 5),
(46, 'Escape from Tarkov', 'Escape from Tarkov es shooter táctico en primera persona desarrollado y publicado por Battlestate Games. Sumérgete en el centro de un gran escándalo político y juega como uno de los supervivientes encerrados en el punto caliente de la zona de guerra.', 29000, 'imagenesjuegos/escapedrom.jpeg', 3),
(47, 'Marvel\'s Spider-Man: Miles Morales', 'Insomniac Games y Sony Interactive Entertainment presentan una nueva versión de su exitoso lanzamiento, Marvel\'s Spider-Man, con un spinoff más pequeño que captura la magia del original. ¡Ponte el traje mejorado de Spider-Man y prepárate para protege', 25500, 'imagenesjuegos/Marvels.jpg', 999),
(48, 'Sea of Thieves', 'Includes a copy of the game plus a wide-ranging assortment of extra cosmetics and collector’s items: Hunter Cutlass, Hunter Pistol, Hunter Compass, Hunter Hat, Hunter Jacket, Hunter Sails and 10,000 gold, Black Phoenix Figurehead, Black Phoenix Sails', 13333, 'imagenesjuegos/seaofthieves.jpg', 4),
(49, 'Project Zomboid', '¿Buscas un juego de simulación de supervivencia zombie realista? ¡No busques más allá de Project Zomboid! En lugar de centrarse en crear los zombis más aterradores, los efectos de sonido más espeluznantes o producir los mejores (o peores) saltos de m', 43222, 'imagenesjuegos/projectzomboid.jpg', 2400),
(50, 'SCUM', '¿Te interesan los juegos de supervivencia de mundo abierto detallados e hiperrealistas como DayZ o 1H1Z? ¿Quizás quieras probar uno? Compra el código de SCUM, ¡porque este juego es justo para ti! Los juegos de supervivencia de mundo abierto son para ', 2555, 'imagenesjuegos/scum.jpeg', 66),
(51, 'Elden Ring', 'Las Tierras Intermedias, empañadas por la guerra, sólo pueden sentir la gracia de la Gran Voluntad una vez más cuando un nuevo Señor de los Elden blande el Anillo de los Elden. Levántate, Tarnished, y sigue el camino más allá del mar de niebla para e', 2555, 'imagenesjuegos/eldenring.jpeg', 0),
(52, 'Tom Clancy\'s Rainbow Six: Siege ', 'Tom Clancy\'s Rainbow Six: Siege key ofrece el último FPS multijugador de Ubisoft que da infinita acción rápida y tensa en cada combate. Dos equipos de jugadores se dividen entre atacantes y defensores y deben competir en uno de los numerosos modos de', 5555, 'imagenesjuegos/RainbowSix.jpg', 2),
(53, 'No Man\'s Sky', 'No Man’s Sky key presenta un mundo abierto de ciencia-ficción y supervivencia desarrollado por Helio Gmaes. Primero, No Man’s Sky es una experiencia. Viaja a través de un universo sin fin, literalmente, el universo al completo es generado proceduralm', 39999, 'imagenesjuegos/Nomans.jpg', 55),
(54, 'Diablo lV', 'Crea y personaliza a tu propio héroe para librar la guerra contra los terrores innombrables que asolan la tierra. Seleccione de un grupo de cinco clases distintas, descubra y pruebe una amplia variedad de equipos potentes, y elija cuidadosamente sus ', 50000, 'imagenesjuegos/Diblo lv.jpg', 44),
(55, 'Hollow Knight', 'Una de las mejores cosas de Hollow Knight es el hecho de que no estás obligado a entrar en la historia, sino que la descubres tú mismo. Hay una belleza en la no linealidad que es difícil de describir. No hay dos jugadas iguales, no hay dos juegos idé', 4444, 'imagenesjuegos/HollowKnight.jpeg', 24),
(56, 'Cyberpunk 2077 ', 'Compra Cyberpunk 2077 key y sumérgete en un mundo abierto donde serás capaz de explorar Night City: una enorme, distópica metrópolis, donde todos están obsesionados con tecnología sci-fi y modificación corporales. Esta experiencia RPG de CD Project R', 5552, 'imagenesjuegos/cyberpunk.jpeg', 100),
(57, 'PayDay 2 (PC)', 'La Clave de Steam de PAYDAY 2 presenta un juego FPS Co-Op desarrollado por Overkill Software. ¿Conoces esos atracos geniales que se ven en las películas, donde un grupo de tipos hace unos planes increíbles para llenarse los bolsillos y terminar relaj', 2555, 'imagenesjuegos/payday2.jpg', 5),
(59, 'Dying Light', 'Tu ciudad ha sido atacada por una pandemia letal, convirtiendo un gran número de sus habitantes en monstruos horribles, sólo los más fuertes de cuerpo y mente han sobrevivido, y tú eres uno de ellos en Dying Light, un juego rol de supervivencia y hor', 24124, 'imagenesjuegos/Dying.jpg', 44),
(60, 'Dead Island', '¡Hazte con la increíble reelaboración de Dead Island con Dead Island: Riptide Definitive Edition de Techland!  ¡Sigue la historia familiar que incluye todos los DLC que se lanzaron anteriormente, pero esta vez hazlo en HD impecable! ¡Se han actualiza', 2555, 'imagenesjuegos/dead.jpeg', 3),
(61, 'Marvel\'s Spider-Man Remastered', 'Sumérgete en la caótica vida de Spider-Man con la nueva y mejorada versión del título original aclamado por la crítica: ¡Marvel\'s Spider-Man: Remasterizado (PC)! Insomniac Games y Sony Interactive Entertainment se han unido para rediseñar por complet', 5525, 'imagenesjuegos/spidermanremastered.jpg', 10),
(62, 'Left 4 Dead 2', 'La secuela de uno de los juegos cooperativos más exitosos de 2008, Left 4 Dead, Left 4 Dead 2 key no solo iguala la excelencia de su precuela, sino que la reemplaza como el mejor FPS de acción y terror cooperativo de todos los tiempos. En este juego,', 5521, 'imagenesjuegos/lef4.jpg', 52),
(63, 'Dark Souls 3', 'Dark Souls III key ofrece un RPG de acción oscuro y enrevesado de los desarrolladores FromSoftware. El fuego casi se ha extinguido, y allá donde el fuego muere viene la oscuridad que sumerge a la humanidad profunda en sí misma, ¿puedes mantener vivo ', 5521, 'imagenesjuegos/dark.jpg', 2),
(64, 'The Outlast Trials', 'El The Outlast Trials en Steam es el sello distintivo de los títulos de horror, ¡listo para llevar a los jugadores a una experiencia de juego única! Hecho para jugadores como tú por el famoso Red Barrels, ¡el título supera las expectativas y proporci', 1000, 'imagenesjuegos/outlast.jpg', 12),
(65, 'Far Cry 6', '¡Ten la oportunidad de experimentar la sexta entrega de la serie de acción en primera persona de mundo abierto comprando el código Far Cry 6 Uplay! El editor y desarrollador Ubisoft debería entregar un juego que utilice todas las mejores característi', 312312, 'imagenesjuegos/farkcry.jpeg', 45),
(67, 'Borderlands 3 Ultimate Edition', 'Es oficial, Borderlands 3 ya se puede comprar. Aparentemente, el desarrollador de Gearbox Software no se durmió durante entre los dos lanzamie', 4442, 'imagenesjuegos/borderlans.jpeg', 12),
(68, 'The Last of Us Part I', '¿Buscas formas de utilizar tu gran capacidad de reacción y de pensar de forma creativa? Entonces el género de acción y aventura es el adecuado para ti. The Last of Us Part I Steam al mejor precio es uno de los juegos más emocionantes y cautivadores q', 4123, 'imagenesjuegos/thelast.jpg', 4),
(69, 'Potion Permit', '¿Buscas un videojuego original para refrescar tu tiempo libre? ¡Tenemos una oferta espléndida para ti! Bellamente diseñada por desarrolladores capaces de MassHive Media y publicada por PQube Limited el 2022-09-22, la clave Potion Permit en Steam trae', 23123, 'imagenesjuegos/Potion.jpg', 2),
(70, 'Shadow Warrior 2 ', 'Shadow Warrior 2 es un juego de acción en primera persona desarrollado por Flying Wold Hog. Es el segundo juego de la serie y es más sangriento, intenso y lleno de acción que nunca. Puedes usar más armas que un ejército combinado, también eres un nin', 2223, 'imagenesjuegos/Warrior.jpeg', 34),
(71, 'LEGO: Marvel Super Heroes 2 ', 'Ambientado en el mundo de LEGO, LEGO: Marvel Super Heroes 2 te da la oportunidad de jugar como tus superhéroes favoritos de Marvel para luchar contra poderosos enemigos en la ciudad de Chronopolis. Repleto del humor característico de LEGO para fanáti', 1999, 'imagenesjuegos/lego.jpeg', 23),
(72, 'Resident Evil 2 / Biohazard RE:2 ', 'El 25 de enero de 2019 es el día que marca el regreso de este legendario juego, pero ahora mejorado. Resident Evil 2 Remake ofrece un toque moderno al clásico de Capcom en 1998 y, si bien es un remake, no es una repetición, lo que significa que los f', 1323, 'imagenesjuegos/residentevil2.jpeg', 3),
(73, 'Subnautica', 'Hay muchas cosas que hacen que el juego Sunautica sea una experiencia especial tanto para los jugadores como para los entusiastas de la ciencia. El desarrollador y editor Unknown Worlds Entertainment lanzó el título en 2018 y hasta el día de hoy sigu', 32323, 'imagenesjuegos/subnautica.jpeg', 2),
(74, 'The Long Dark: Survival Edition', 'The Long Dark es una experiencia de supervivencia realista. No hay zombis u otras amenazas similares. El peligro proviene del ambiente frío que te rodea. Sin embargo, eso solo lo hace más aprensivo.   Puedes dispararle a un zombi, pero no hay nada qu', 1999, 'imagenesjuegos/longdark.jpg', 51),
(75, 'STAR WARS Jedi: Survivor', 'Respawn vuelve a la galaxia muy, muy lejana con una secuela del título de Star Wars favorito de los fans: Jedi: Fallen Order. Domando el género de los juegos de almas, el primer juego hizo exactamente lo que todo fan de Star Wars quería, es decir, pe', 19999, 'imagenesjuegos/StarWars.jpg', 55),
(76, 'Grand Theft Auto IV', 'Grand Theft Auto IV es otra edición de la icónica serie de juegos de Rockstar Games.  Aquí jugarás como Niko Bellic, un hombre que ha venido a los Estados Unidos a cumplir el Señor Americano. Desgraciadamente, pronto se da cuenta de que la vida al ot', 12399, 'imagenesjuegos/GTAlV.jpg', 5),
(77, 'Starsand', 'Starsand es un juego místico de supervivencia ambientado en las dunas de un desierto arcano. ¡Te espera un mundo abierto lleno de peligros, entornos gigantescos y sucesos misteriosos! Explora, caza, fabrica, construye y... SOBREVIVE.', 31231, 'imagenesjuegos/stardsand.jpeg', 6),
(78, 'Fobia - St. Dinfna Hotel', 'Desarrollado por un estudio de juegos tan distinguido como Pulsatrix Studios y publicado por Maximum Games, mundialmente conocido, Fobia - St. Dinfna Hotel key ofrece una experiencia electrizante que uno simplemente no podría pasar por alto. Lanzado ', 3123, 'imagenesjuegos/Fobia.jpg', 3),
(79, 'Limbo', 'limbo, en la teología católica romana, el lugar fronterizo entre el cielo y el infierno donde habitan aquellas almas que, aunque no están condenadas al castigo, están privadas del gozo de la existencia eterna con Dios en el cielo', 312312, 'imagenesjuegos/Limbo.jpeg', 3),
(80, 'Little Nightmares', 'Los desarrolladores de Sumo Digital y el estudio Focus Home Interactive te traen un juego que redefine la experiencia del MMORPG de acción. Embárcate en aventuras de proporciones épicas, participa en luchas rápidas y brutales, y conviértete en una le', 1993, 'imagenesjuegos/Little.jpg', 122),
(81, 'Little Nightmares 2', 'Los desarrolladores de Sumo Digital y el estudio Focus Home Interactive te traen un juego que redefine la experiencia del MMORPG de acción. Embárcate en aventuras de proporciones épicas, participa en luchas rápidas y brutales, y conviértete en una le', 5999, 'imagenesjuegos/Littlenight2.jpeg', 24),
(82, 'Resident Evil Village / Resident Evil 8', '¡Las pesadillas del pasado vuelven a perseguirte! Vuelve a convertirte en Ethan Winters, el protagonista del aclamado Resident Evil 7: Biohazard, y adéntrate en una misteriosa aldea llena de terrores procedentes de las más profundas fosas del infiern', 31232, 'imagenesjuegos/Village.jpeg', 4),
(83, 'Assetto Corsa (Ultimate Edition)', '¿Listo para correr en el confort de tu casa? El simulador de carreras Assetto Corsa te tiene cubierto. El juego es apreciado por su experiencia de rally realista y la posibilidad de personalizar la mayoría de sus características. Lanzado en 2013, el ', 9999, 'imagenesjuegos/aSSETE.jpg', 4),
(84, 'Resident Evil 4 Remake', 'Disfruta del remake del juego de survival horror que cambió por completo el género. Resident Evil 4, adaptado a las consolas y PC modernos con gráficos y mecánicas de juego renovados, te lleva de vuelta a un remoto pueblo europeo infectado por el par', 14888, 'imagenesjuegos/residentevil4remake.jpg', 5),
(85, 'Hogwarts Legacy', 'Nunca has recibido tu carta de Hogwarts. Gran cosa, ahora puedes visitar y estudiar en la famosa Escuela de Magia y Hechicería en el juego RPG de acción de mundo abierto desarrollado por Avalanche Software - Hogwarts Legacy. Como estudiante, experime', 58888, 'imagenesjuegos/Howarts.jpg', 54),
(86, 'Friday the 13th', 'Friday The 13th: The Games key ofrece un juego multijugador asimétrico que le da un giro único a toda la serie de películas. A diferencia de muchos juegos de terror y supervivencia, este te permite jugar tanto como el cazador como el cazado, ya que c', 3133, 'imagenesjuegos/Friday13.jpeg', 67),
(87, 'LEGO: Harry Potter', '¿Te consideras un gran fan de la serie Harry Potter? ¿Quizá te gustan los videojuegos de LEGO? Si tu respuesta a ambas preguntas es afirmativa, entonces LEGO: Harry Potter Años 1-4 Código de Steam es justo para ti. Vive la historia de los 4 primeros ', 4124, 'imagenesjuegos/LegoHarryporter.jpeg', 3),
(88, 'The Elder Scrolls V: Skyrim', 'El juego The Elder Scrolls V: Skyrim es otro capítulo de la famosa saga Elder Scrolls, desarrollado por Bethesda Game Studios. Una experiencia de mundo abierto, una emocionante historia de antaño que cuenta leyendas de gloriosos guerreros que lucharo', 3139, 'imagenesjuegos/ElderScrols.jpg', 45),
(89, 'Fallout 3', 'Fallout 3 key es un RPG de acción y aventura desarrollado por Bethesda Game Studios. Fallout 3 es una aventura post apocalíptica ambientada en una linea temporal alternativa, donde te encontrarás uno de los mundos más intensos y gigantescos creados j', 1244, 'imagenesjuegos/Fallout3.jpg', 15),
(90, 'Hunt: Showdown', '¡Maldita Louisiana, das miedo! El Estado del Pelícano ha sido embrujado por monstruos que acechan en sus pantanos y pueblos, y ya están hartos, poniendo mucho dinero sobre la mesa por cada cabeza de monstruo. ¡Conviértete en un caza recompensas en el', 3123, 'imagenesjuegos/HUNT.jpeg', 3),
(91, 'The Witcher 3: Wild Hunt', '¡The Witcher 3: Wild Hunt key ofrece un RPG mundo abierto de acción que simplemente no puedes dejar pasar! Controla a Geralt de Rivia, también conocido como El Brujo: un cazador altamente entrenado que cuenta con sentidos mejorados y un alto conocimi', 9993, 'imagenesjuegos/TheWitcher3.jpg', 4),
(92, 'Dead by Daylight', 'Dead by Daylight es un juego multijugador cooperativo de supervivencia desarrollado por Behaviour Digital Inc. En él, te sumergirás en el emocionante juego del escondite cuyo premio principal es tu vida. Juega como uno de los supervivientes que lucha', 31231, 'imagenesjuegos/DeeadbyDaylight.jpeg', 55),
(93, 'Star Wars Jedi: Fallen Order', 'Star Wars Jedi: Fallen Order Origin key trae un juego de acción y aventuras para un jugador desarrollado por Respawn Entertainment. Controla a uno de los últimos Jedi en pie, Cal Kestis, y enfréntate al control del Imperio en constante expansión. Usa', 4999, 'imagenesjuegos/starwarsjedi.jpeg', 12),
(94, 'Resident Evil 7 - Biohazard ', 'La clave de Resident Evil 7-Biohazard marca el regreso de la serie a sus raíces de horror de supervivencia. El juego está menos orientado a la acción y se pone más énfasis en la exploración. El protagonista principal del juego es Ethan Winters, un ci', 3990, 'imagenesjuegos/ResidentEvil7.jpg', 43),
(95, 'Prey 2017', 'Los videojuegos nos sirven como una ventana para volar hacia mundos ficticios donde podemos interactuar con las cosas y participar en el juego como participantes activos, ¡y Prey key en Steam lo lleva a otro nivel! 2017-05-05 marca el día en que el e', 14999, 'imagenesjuegos/Prey2017.jpg', 99),
(96, 'The Forest', 'Como el único sobreviviente de un accidente de un avión de pasajeros, te encuentras en un bosque misterioso luchando por sobrevivir contra una sociedad de mutantes caníbales. Construye, explora y sobrevive en este terrorífico simulador de terror y su', 2555, 'imagenesjuegos/TheForest.jpg', 99),
(97, 'Days Gone', '¿Sobrevivirás a los horrores de un mundo moribundo o tu búsqueda de una razón para vivir será en vano? Pon a prueba tu determinación en la nueva entrega de SIE Bend Studio y Sony Interactive Entertainment que combina la acción y la aventura con eleme', 3334, 'imagenesjuegos/DaysGone.jpeg', 9),
(98, 'Rust PC', 'Si quieres ponerte a prueba a través de un desafío real, ¡compra la clave de Rust y participa en lo que podría decirse que es el juego más difícil de Steam! Publicado y desarrollado por Facepunch Studios, Rust es un cruel juego de supervivencia de mu', 15999, 'imagenesjuegos/Rush.jpg', 9),
(99, 'The Evil Within', 'Tango Gameworks y Bethesda Softworks ofrecen una experiencia de supervivencia de terror única que cautiva a los jugadores con su espeluznante historia. The Evil Within key es todo lo que un amante del terror podría desear: una narrativa llena de giro', 3999, 'imagenesjuegos/EvilWithin.jpg', 5),
(100, 'The Evil Within 2 Day One', 'Compra la clave Evil Within 2 Day One Edition y aventúrate en los reinos de pesadilla. Lucha contra criaturas aterradoras que están decididas a destrozarte. Elige cómo quieres sobrevivir y supera muchos obstáculos que te presenta el juego. Siente cóm', 8489, 'imagenesjuegos/TheEvilWihitn2.jpg', 156);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `correoUsuario` (`correoUsuario`);

--
-- Indices de la tabla `videojuego`
--
ALTER TABLE `videojuego`
  ADD PRIMARY KEY (`idJuego`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `videojuego`
--
ALTER TABLE `videojuego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
