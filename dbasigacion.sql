-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2021 a las 00:08:01
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbasigacion`
--

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `insert_asignacion` (`fch` VARCHAR(255), `des` VARCHAR(255), `cant` VARCHAR(255), `usua` INT(11), `idus` INT(11)) RETURNS VARCHAR(50) CHARSET latin1 BEGIN
 
  DECLARE id INT(11);

 INSERT INTO asignacion (fecha,idusu,cat_peticion,descripcion,usuario) 
 		VALUES (fch,idus,cant,des,usua);
  SET id = last_insert_id();
 
  RETURN id;
 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

CREATE TABLE `asignacion` (
  `idasig` int(11) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `cat_peticion` varchar(255) NOT NULL,
  `usuario` int(11) NOT NULL,
  `idusu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asignacion`
--

INSERT INTO `asignacion` (`idasig`, `fecha`, `descripcion`, `cat_peticion`, `usuario`, `idusu`) VALUES
(1, '2021-02-13', 'dsfsdfdsfsdfsdsdffdsfdssdfdsfdfsdfssdfds jfgykdhfksdkjfhkjsdhfhkdf sdkjfhksdhfkhsdkjhfkjsdkjfhkdsf hsdfjhsdfjhkjsdf', '1', 1, 2),
(2, '2021-02-13', 'dfsdfhhdfsjsdfkk jhidfksdfksdf sdfkjhksdflsdflkkfsd fsdjlhsdfkjhkhkjlsdf sdfljkliufsddsf', '1', 1, 3),
(3, '2021-04-08', 'asdasdasd', '10', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_asigna`
--

CREATE TABLE `detalle_asigna` (
  `iddtlle` int(11) NOT NULL,
  `idmedi` int(11) NOT NULL,
  `idasig` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_asigna`
--

INSERT INTO `detalle_asigna` (`iddtlle`, `idmedi`, `idasig`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `idmedi` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `idtipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`idmedi`, `nombre`, `cantidad`, `idtipo`) VALUES
(1, 'ibuprofeno', '19', 1),
(2, 'diclofenac', '19', 1),
(3, 'atamel', '19', 2),
(4, 'rivotril', '35', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `idsede` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`idsede`, `descripcion`) VALUES
(1, 'Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_medicamento`
--

CREATE TABLE `tipo_medicamento` (
  `idtipo` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_medicamento`
--

INSERT INTO `tipo_medicamento` (`idtipo`, `descripcion`) VALUES
(1, 'PASTILLA'),
(2, 'JARABE'),
(3, 'INTRAVENOSO'),
(4, 'UNIDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_persona`
--

CREATE TABLE `tipo_persona` (
  `idtipopersona` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_persona`
--

INSERT INTO `tipo_persona` (`idtipopersona`, `descripcion`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'FARMACEUTA'),
(3, 'PACIENTE'),
(4, 'EMPLEADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusu` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `nombreusu` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `estatus` int(11) NOT NULL,
  `nacionalidad` varchar(255) NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `fch_nacimi` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telef` varchar(255) NOT NULL,
  `idsede` int(11) NOT NULL,
  `idtipopersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusu`, `nombre`, `apellido`, `cedula`, `nombreusu`, `pass`, `estatus`, `nacionalidad`, `sexo`, `fch_nacimi`, `direccion`, `telef`, `idsede`, `idtipopersona`) VALUES
(1, 'adm', 'adm', '111111', 'adm', 'YWRt', 1, '1', '1', '1991-10-12', '', '', 1, 1),
(2, 'ppppp', 'prueba', '123654', '', '', 1, '1', '1', '2020-12-01', 'ddddddd', '0416555555', 1, 3),
(3, 'ssss', 'ssss', '21323112', '', '', 1, '1', '1', '2020-12-04', 'asdasdasd', '234234', 1, 3),
(4, 'wewe', 'qwe', '2342', '', '', 1, '1', '1', '2020-03-07', 'qewqwe', '2342', 1, 4),
(5, 'kkñlk', 'ñ{lñ', '6863856', 'jjju', 'NTUyNTU=', 1, '1', '2', '2019-05-05', '{loñ', 'ñ{lñ', 1, 2),
(6, 'ljk', 'ljljl', '25828', 'lj.j', 'bGtqbC4=', 1, '2', '1', '2017-01-04', 'lñj', 'kljmkjm', 1, 1),
(7, '68lñ--', 'ñlñ-ñ-', '3658', '', '', 1, '1', '1', '1199-02-05', 'ñ{-lñ-', 'ñk,ñ-', 1, 3),
(8, 'hhh', 'hhh', '999', 'dd', 'ZGQ=', 1, '1', '1', '2020-05-09', 'dhdhd', '888', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD PRIMARY KEY (`idasig`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `detalle_asigna`
--
ALTER TABLE `detalle_asigna`
  ADD PRIMARY KEY (`iddtlle`),
  ADD KEY `idmedi` (`idmedi`),
  ADD KEY `idasig` (`idasig`);

--
-- Indices de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`idmedi`),
  ADD KEY `idtipo` (`idtipo`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`idsede`);

--
-- Indices de la tabla `tipo_medicamento`
--
ALTER TABLE `tipo_medicamento`
  ADD PRIMARY KEY (`idtipo`);

--
-- Indices de la tabla `tipo_persona`
--
ALTER TABLE `tipo_persona`
  ADD PRIMARY KEY (`idtipopersona`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusu`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD KEY `idsede` (`idsede`),
  ADD KEY `idtipopersona` (`idtipopersona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  MODIFY `idasig` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `detalle_asigna`
--
ALTER TABLE `detalle_asigna`
  MODIFY `iddtlle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `idmedi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `idsede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipo_medicamento`
--
ALTER TABLE `tipo_medicamento`
  MODIFY `idtipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tipo_persona`
--
ALTER TABLE `tipo_persona`
  MODIFY `idtipopersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD CONSTRAINT `asignacion_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `detalle_asigna`
--
ALTER TABLE `detalle_asigna`
  ADD CONSTRAINT `detalle_asigna_ibfk_1` FOREIGN KEY (`idasig`) REFERENCES `asignacion` (`idasig`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_asigna_ibfk_2` FOREIGN KEY (`idmedi`) REFERENCES `medicamento` (`idmedi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`idtipo`) REFERENCES `tipo_medicamento` (`idtipo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idtipopersona`) REFERENCES `tipo_persona` (`idtipopersona`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idsede`) REFERENCES `sede` (`idsede`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
