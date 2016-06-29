-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-08-2013 a las 17:56:36
-- Versión del servidor: 5.1.69
-- Versión de PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `goreLosLagosStarted`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activacionProceso`
--

CREATE TABLE IF NOT EXISTS `activacionProceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo_id` int(11) DEFAULT NULL,
  `nombre_contenedor` varchar(255) DEFAULT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk1` (`periodo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `activacionProceso`
--

INSERT INTO `activacionProceso` (`id`, `periodo_id`, `nombre_contenedor`, `inicio`, `fin`) VALUES
(1, 1, 'procesoPlanificacionInstitucional', '2012-10-01 16:36:07', '2013-02-01 16:36:12'),
(2, 1, 'procesoControlGestion', '2013-01-25 00:00:00', '2013-02-10 00:00:00'),
(3, 1, 'evaluacionGestion', '2013-01-25 00:00:00', '2013-03-12 16:37:48'),
(5, 16, 'procesoPlanificacionInstitucional', '2013-01-01 00:00:00', '2013-08-31 00:00:00'),
(6, 16, 'procesoControlGestion', '2013-03-01 00:00:00', '2013-03-14 00:00:00'),
(7, 16, 'evaluacionGestion', '2013-03-10 00:00:00', '2013-04-30 00:00:00'),
(8, 14, 'procesoPlanificacionInstitucional', '2013-03-01 00:00:00', '2013-11-01 00:00:00'),
(9, 14, 'procesoControlGestion', '2013-11-01 00:00:00', '2013-12-01 00:00:00'),
(10, 14, 'evaluacionGestion', '2013-11-01 00:00:00', '2014-01-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ActiveRecordLog`
--

CREATE TABLE IF NOT EXISTS `ActiveRecordLog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `model` varchar(45) DEFAULT NULL,
  `idModel` varchar(10) DEFAULT NULL,
  `field` varchar(45) DEFAULT NULL,
  `creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userid` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `ActiveRecordLog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indicador_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `verificacion` text,
  `cantidad` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `actividad_parent` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `descripcion` text,
  `avance_anterior` int(11) DEFAULT NULL,
  `avance_actual` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_relationship_29` (`indicador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asociaciones`
--

CREATE TABLE IF NOT EXISTS `asociaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `asociaciones`
--

INSERT INTO `asociaciones` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Mejora de Gestión - LA', 'Mejora de Gestión - LA', 1),
(2, 'Mejora de Gestión -AMI', 'Mejora de Gestión -AMI', 1),
(3, 'PMG', 'PMG', 1),
(4, 'Producto Estratégico del Negocio', 'Producto Estratégico del Negocio', 1),
(5, 'Producto Estratégico de Apoyo', 'Producto Estratégico de Apoyo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `fk2_users` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', 1, NULL, NULL),
('gestor', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 2, 'Administrador', NULL, NULL),
('finanzas', 1, 'Encargado de Finanzas', NULL, NULL),
('gestor', 1, 'Gestor', NULL, NULL),
('supervisor', 2, 'Supervisor Evidencia EG', NULL, NULL),
('supervisor2', 2, 'Supervisor Indicadores', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('admin', 'finanzas'),
('admin', 'gestor'),
('admin', 'supervisor'),
('admin', 'supervisor2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `estado` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `nombre`, `estado`) VALUES
(1, 'Jefe de proyecto', 1),
(2, 'Encargado de Finanzas ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros_costos`
--

CREATE TABLE IF NOT EXISTS `centros_costos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `division_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_relationship_11` (`division_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Volcado de datos para la tabla `centros_costos`
--

INSERT INTO `centros_costos` (`id`, `division_id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 1, 'Jefe DIPLAN', 'Jefe DIPLAN', 1),
(2, 1, 'Municipios', 'Municipios', 1),
(3, 1, 'Planificación y OT[1]', 'Planificación y OT[1]', 1),
(15, 13, 'Evaluación Expost', 'Descripción Evaluación Expost', 1),
(16, 14, 'Contabilidad', 'Descripción Contabilidad', 1),
(18, 1, 'UGIT', 'UGIT', 1),
(19, 1, 'Borde Costero', 'Borde Costero', 1),
(20, 1, 'Programas SUBDERE', 'Programas SUBDERE', 1),
(21, 1, 'Producción Limpia', 'Producción Limpia', 1),
(22, 1, ' URAI', ' URAI', 1),
(23, 1, ' Fomento Productivo', ' Fomento Productivo', 1),
(24, 1, 'U. Provincial Osorno', 'U. Provincial Osorno', 1),
(25, 1, 'U. Provincial Chiloé', 'U. Provincial Chiloé', 1),
(26, 1, 'U. Provincial Palena', 'U. Provincial Palena', 1),
(27, 1, ' FIC', ' FIC', 1),
(28, 13, 'Jefe DACG[2]', 'Jefe DACG[2]', 1),
(29, 13, 'Programación Presupuestaria', 'Programación Presupuestaria', 1),
(30, 13, 'Estudios e Inversiones', 'Estudios e Inversiones', 1),
(31, 13, 'Inversión Complementaria', 'Inversión Complementaria', 1),
(32, 13, 'Jurídica DACG', 'Jurídica DACG', 1),
(33, 14, 'Jefe DAF', 'Jefe DAF', 1),
(34, 14, 'Finanzas', 'Departamento Finanzas y presupuestos y contemplas las unidades de Remuneraciones, presupuesto 01, presupuesto 02, Tesorer??a y Core.', 1),
(35, 14, 'Recursos Humanos', 'Recursos Humanos', 1),
(36, 14, 'Recursos Humanos', 'Recursos Humanos', 1),
(37, 14, 'Tic’s', 'Tic’s', 1),
(38, 14, 'Archivo', 'Archivo', 1),
(39, 14, 'Control Gestión', 'Control Gestión', 1),
(40, 14, 'Partes', 'Partes', 1),
(41, 14, 'Auditoría Interna', 'Auditoría Interna', 1),
(42, 14, 'Jurídica DAF', 'Jurídica DAF', 1),
(43, 14, 'Secretaría Core', 'Secretaría Core', 1),
(44, 14, 'Comunicaciones', 'Comunicaciones', 1),
(47, 1, 'Centro de costo de prueba asociado a un usuario', 'Centro de costo de prueba asociado a un usuario', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_internos`
--

CREATE TABLE IF NOT EXISTS `cierres_internos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_etapa` int(11) NOT NULL,
  `observaciones` text NOT NULL,
  `archivo` varchar(200) NOT NULL,
  `fecha_cierre` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  `id_planificacion` int(11) NOT NULL,
  `cierre_etapa` tinyint(1) DEFAULT '0',
  `formulario_h` varchar(200) DEFAULT NULL,
  `formulario_a1` varchar(200) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fkcierreInterno` (`id_etapa`),
  KEY `fkcierreInternoUsuario` (`id_usuario`),
  KEY `fkcierreplanificaion` (`id_planificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificaciones_ambitos`
--

CREATE TABLE IF NOT EXISTS `clasificaciones_ambitos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `clasificaciones_ambitos`
--

INSERT INTO `clasificaciones_ambitos` (`id`, `nombre`, `estado`) VALUES
(1, 'Producto', 1),
(2, 'Proceso', 1),
(3, 'Resultado Intermedio', 1),
(4, 'Resultado Final o Impacto', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificaciones_dimensiones`
--

CREATE TABLE IF NOT EXISTS `clasificaciones_dimensiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `clasificaciones_dimensiones`
--

INSERT INTO `clasificaciones_dimensiones` (`id`, `nombre`, `estado`) VALUES
(1, 'Eficacia', 1),
(2, 'Eficiencia', 1),
(3, 'Economía', 1),
(4, 'Calidad de Servicio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificaciones_tipos`
--

CREATE TABLE IF NOT EXISTS `clasificaciones_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Volcado de datos para la tabla `clasificaciones_tipos`
--

INSERT INTO `clasificaciones_tipos` (`id`, `nombre`, `estado`) VALUES
(1, 'Cobertura', 1),
(11, 'Cofinanciamiento', 1),
(14, 'Fiscalizaciones/Fiscalizador', 1),
(23, 'Tasa Variación de Producción', 1),
(24, 'Tiempo Promedio de Respuesta', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_cliente_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_relationship_9` (`tipo_cliente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_cliente_id`, `nombre`, `estado`) VALUES
(2, 1, 'Consejeros Regionales', 1),
(9, 1, 'Secretarios Regionales Ministeriales', 1),
(10, 1, 'Servicios Públicos Región', 1),
(11, 1, 'Gobernaciones Provinciales', 1),
(12, 1, 'Municipios de la Región', 1),
(13, 1, 'Organizaciones Sociales de la Región', 1),
(14, 1, 'Entidades sin fines de lucro', 1),
(15, 1, 'Instituciones de seguridad pública y defensa', 1),
(16, 1, 'Instituciones de Educación Superior', 1),
(18, 2, 'Poblacion flotante', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterios`
--

CREATE TABLE IF NOT EXISTS `criterios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `n_criterio` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `criterios`
--

INSERT INTO `criterios` (`id`, `nombre`, `descripcion`, `estado`, `n_criterio`) VALUES
(1, '1. Liderazgo', 'Descripción Liderazgo', 1, 1),
(2, '2. Ciudadanía, Socios y Colaboradores', 'Ciudadanía, Socios y Colaboradores', 1, 2),
(3, '3. Personas', 'Personas', 1, 3),
(4, '4. Gestión de la Planificación Estratégica Regional', 'Gestión de la Planificación Estratégica Regional', 1, 4),
(5, '5. Gestión de Inversiones y Desarrollo Regional Territorial', 'Gestión de Inversiones y Desarrollo Regional Territorial', 1, 5),
(6, '6. Gestión de Recursos', 'Gestión de Recursos', 1, 6),
(7, '7. Planificación Institucional, Información y Conocimiento', 'Planificación Institucional, Información y Conocimiento', 1, 7),
(10, '8. Resultados', 'Resultados', 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desafios_estrategicos`
--

CREATE TABLE IF NOT EXISTS `desafios_estrategicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perspectiva_estrategica_id` int(11) DEFAULT NULL,
  `planificacion_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_reference_1` (`perspectiva_estrategica_id`),
  KEY `fk_reference_3` (`planificacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desafios_objetivos`
--

CREATE TABLE IF NOT EXISTS `desafios_objetivos` (
  `desafio_estrategico_id` int(11) NOT NULL,
  `objetivo_estrategico_id` int(11) NOT NULL,
  PRIMARY KEY (`desafio_estrategico_id`,`objetivo_estrategico_id`),
  KEY `fk_reference_66` (`objetivo_estrategico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desafio_desafio`
--

CREATE TABLE IF NOT EXISTS `desafio_desafio` (
  `desafio_estrategico_id` int(11) NOT NULL,
  `desafio_estrategico_mm_id` int(11) NOT NULL,
  PRIMARY KEY (`desafio_estrategico_id`,`desafio_estrategico_mm_id`),
  KEY `desafio_estrategico_mm_id` (`desafio_estrategico_mm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones`
--

CREATE TABLE IF NOT EXISTS `divisiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `divisiones`
--

INSERT INTO `divisiones` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'DIPLAN', 'Divisi??n de Planificaci??n y Desarrollo Regional', 1),
(13, 'DACG', 'Divisi??n de An?°lisis y Control de Gesti??n', 1),
(14, 'DAF', 'Divisi??n de Administraci??n y Finanzas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecucion_presupuestaria`
--

CREATE TABLE IF NOT EXISTS `ejecucion_presupuestaria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_division` int(11) NOT NULL,
  `id_centro_costo` int(11) NOT NULL,
  `id_planificacion` int(11) NOT NULL,
  `id_item_presupuestario` int(11) NOT NULL,
  `monto_asignado` bigint(20) NOT NULL,
  `acumulado` bigint(20) DEFAULT NULL,
  `saldo` bigint(20) DEFAULT NULL,
  `mes1` bigint(20) DEFAULT NULL,
  `mes2` bigint(20) DEFAULT NULL,
  `mes3` bigint(20) DEFAULT NULL,
  `mes4` bigint(20) DEFAULT NULL,
  `mes5` bigint(20) DEFAULT NULL,
  `mes6` bigint(20) DEFAULT NULL,
  `mes7` bigint(20) DEFAULT NULL,
  `mes8` bigint(20) DEFAULT NULL,
  `mes9` bigint(20) DEFAULT NULL,
  `mes10` bigint(20) DEFAULT NULL,
  `mes11` bigint(20) DEFAULT NULL,
  `mes12` bigint(20) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_division` (`id_division`,`id_centro_costo`,`id_planificacion`,`id_item_presupuestario`),
  KEY `centro_costo1` (`id_centro_costo`),
  KEY `planificacion1` (`id_planificacion`),
  KEY `item_presupuestario` (`id_item_presupuestario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=329 ;

--
-- Volcado de datos para la tabla `ejecucion_presupuestaria`
--

INSERT INTO `ejecucion_presupuestaria` (`id`, `id_division`, `id_centro_costo`, `id_planificacion`, `id_item_presupuestario`, `monto_asignado`, `acumulado`, `saldo`, `mes1`, `mes2`, `mes3`, `mes4`, `mes5`, `mes6`, `mes7`, `mes8`, `mes9`, `mes10`, `mes11`, `mes12`, `estado`) VALUES
(279, 1, 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(280, 1, 1, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(281, 1, 1, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(282, 1, 1, 2, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(283, 1, 1, 2, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(284, 1, 1, 2, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(285, 1, 1, 2, 15, 457457878, 10, 457457868, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 1),
(286, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(287, 1, 1, 1, 2, 8577742, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(288, 1, 1, 1, 3, 1024000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(289, 1, 1, 1, 4, 40000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(290, 1, 1, 1, 13, 50000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(291, 1, 1, 1, 14, 30000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(292, 1, 1, 1, 15, 20000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(293, 1, 1, 3, 1, 19311500, 0, 19311500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1),
(294, 1, 1, 3, 2, 4380773, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(295, 1, 1, 3, 3, 3888096, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(296, 1, 1, 3, 4, 550000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(297, 1, 1, 3, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(298, 1, 1, 3, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(299, 1, 1, 3, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(300, 1, 3, 1, 1, 80000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(301, 1, 2, 1, 2, 800000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(302, 1, 3, 1, 2, 65000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(303, 1, 2, 1, 3, 40000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(304, 1, 3, 1, 3, 140000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(305, 1, 3, 1, 4, 330000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(306, 1, 3, 1, 13, 70000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(307, 1, 3, 1, 14, 25000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(308, 1, 3, 1, 15, 5000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(309, 1, 2, 3, 1, 401768086, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(310, 1, 3, 3, 1, 20000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(311, 1, 20, 3, 1, 60000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(312, 14, 35, 3, 1, 1040000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(313, 1, 2, 3, 2, 16617177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(314, 1, 20, 3, 2, 1140000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(315, 1, 2, 3, 3, 392928012, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(316, 1, 20, 3, 3, 420000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(317, 1, 3, 3, 4, 170000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(318, 1, 20, 3, 4, 240000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(319, 1, 3, 3, 13, 30000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(320, 1, 20, 3, 13, 60000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(321, 1, 3, 3, 14, 50000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(322, 1, 3, 3, 15, 5000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(323, 13, 15, 3, 1, 111500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(324, 14, 16, 3, 1, 83200000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(325, 13, 15, 3, 2, 1133029, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(326, 14, 37, 3, 2, 103458244, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(327, 13, 15, 3, 3, 128000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(328, 14, 37, 3, 3, 3760096, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_gestion`
--

CREATE TABLE IF NOT EXISTS `elementos_gestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_subcriterio` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `n_elementogestion` char(1) NOT NULL,
  `responsable_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk1_324` (`id_subcriterio`),
  KEY `responsable_id` (`responsable_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Volcado de datos para la tabla `elementos_gestion`
--

INSERT INTO `elementos_gestion` (`id`, `id_subcriterio`, `nombre`, `estado`, `n_elementogestion`, `responsable_id`) VALUES
(1, 1, '1. 1. a. ¿Cómo el Equipo Directivo establece/actualiza y comunica la misión, visión y valores a la organización?', 1, 'a', 1),
(2, 1, '1. 1. b. ¿Cómo el Equipo Directivo gestiona la relación con el gestiona la relación con el Consejo Regional (CORE)?', 1, 'b', 1),
(3, 1, '1. 1. c. ¿Cómo el Equipo Directivo desarrolla e implementa un sistema para gestionar la organización, establece las metas, comunicarlas y medir el desempeño?', 1, 'c', 1),
(4, 1, '1. 1. d. ¿Cómo el Equipo Directivo se comunica con el personal y equipos de trabajo, motiva su participación y reconoce sus aportes?', 1, 'd', 1),
(6, 1, '1. 1. e. ¿Cómo el Equipo Directivo crea y/o refuerza un ambiente de entrega de facultades (empowerment) e innovación, así como el aprendizaje individual y de la organización?', 1, 'e', 1),
(7, 1, '1. 1. f. ¿Cómo el Equipo Directivo evalúa los aspectos clave del desempeño de la organización? ¿Cómo utiliza estos resultados y la retroalimentación del personal, para mejorar la efectividad de su propio liderazgo y de la gestión en general?', 1, 'f', 1),
(8, 1, '1. 1. g. ¿Cómo el Equipo Directivo genera un ambiente propicio para la búsqueda de excelencia en las prácticas de gestión y en los resultados de la organización?', 1, 'g', 1),
(9, 1, '1. 1. h. ¿Cómo el equipo directivo promueve el trabajo en equipo, la colaboración y la coordinación dentro de la organización?', 1, 'h', 1),
(10, 1, '1. 1. i. ¿Cómo la organización evalúa el desempeño del Equipo Directivo y cómo utiliza dicha información para mejorar su efectividad?', 1, 'i', 1),
(11, 2, '1. 2. a. ¿Cómo se definen las orientaciones estratégicas para el desarrollo regional?', 1, 'a', 1),
(12, 2, '1. 2. b. ¿Cómo se definen los actores clave para el desarrollo y gobernabilidad de la región?', 1, 'b', 1),
(13, 2, '1. 2. c. ¿Cómo se realizan las actividades de coordinación y se les da atención privilegiada a actores clave?', 1, 'c', 1),
(14, 2, '1. 2. d. ¿Cómo se comunican y consensan las orientaciones estratégicas con los actores clave?', 1, 'd', 1),
(15, 2, '1. 2. e. ¿Cómo se negocia con los actores clave y se da seguimiento y acompaamiento a las acciones clave para la región?', 1, 'e', 1),
(16, 3, '1. 3. a. ¿Cómo se diseñan políticas internas, prácticas recurrentes o estándares de gestión en relación a la transparencia en la gestión del GORE o a la rendición de cuentas?', 1, 'a', 1),
(17, 3, '1. 3. b. ¿Cómo se controlan, se hace seguimiento y mejoran las políticas internas, prácticas recurrentes o estándares de gestión en relación a la transparencia en la gestión del GORE o la rendición de cuentas?', 1, 'b', 1),
(18, 3, '1. 3. c. ¿Cómo se mide la situación actual de las políticas internas, prácticas recurrentes o estándares de gestión asociados a la transparencia en la gestión del GORE o la rendición de cuentas?', 1, 'c', 1),
(19, 3, '1. 3. d. ¿Cómo el Equipo Directivo estimula y asegura el comportamiento tico a nivel directivo y como lo promueve en toda la organización y entre sus socios y colaboradores?', 1, 'd', 1),
(20, 3, '1. 3. e. ¿Cómo se ejerce fiscalización y/o supervigilancia a los servicios públicos creados por ley que cumplen funciones administrativas en la región? (pudiendo solicitar informes, antecedentes u otro dato que requiera para dicho fin).', 1, 'e', 1),
(21, 4, '2. 1. a. ¿Cómo el Gobierno Regional obtiene la opinión de la ciudadanía, respecto a los canales y formas deseables de participación ciudadana, en los ámbitos de competencia del GORE?', 1, 'a', 1),
(22, 4, '2. 1. b. ¿Cómo se utiliza esta información para identificar los canales y formas que permitan promover, incentivar y asegurar la participación ciudadana?', 1, 'b', 1),
(23, 4, '2. 1. c. ¿Cómo se determinan los socios y colaboradores del GORE?', 1, 'c', 1),
(24, 4, '2. 1. d. ¿Cómo se mide la percepción de la ciudadanía, socios y colaboradores respecto a su participación en los canales y formas emprendidas por el GORE, la intención de participar nuevamente y su satisfacción e insatisfacción en general?', 1, 'd', 1),
(25, 4, '2. 1. e. ¿Cómo utiliza la información sobre la satisfacción e insatisfacción de la ciudadanía, socios y colaboradores, para incrementar los niveles de satisfacción de estos y superar sus expectativas?', 1, 'e', 1),
(26, 4, '2. 1. f. ¿Cómo la organización gestiona las quejas, reclamos y sugerencias de la ciudadanía, socios y colaboradores? ¿Cómo se asegura que sean resueltas de manera eficaz y oportuna? ¿Cómo agrupa y analiza esta información para el uso del mejoramiento global de la organización, implementa acciones y las comunica al personal así como a la ciudadanía, socios y colaboradores?', 1, 'f', 1),
(27, 5, '2. 2. a. ¿Cómo se diseña la identidad e imagen del GORE y su estrategia de posicionamiento?, o sea, la forma en que pretende ser percibido por la sociedad en su conjunto y ser diferenciado de otros Servicios.', 1, 'a', 1),
(28, 5, '2. 2. b. ¿Cómo se desarrolla y gestiona la identidad y su posicionamiento, considerando la difusión y comunicación del concepto estratégico que está detrás de la identidad del GORE, así como tambión la imagen que se pretende exteriorizar?', 1, 'b', 1),
(29, 5, '2. 2. c. ¿Cómo se evalúa la percepción de la identidad e imagen del GORE entre los actores clave y la ciudadanía?', 1, 'c', 1),
(30, 6, '3. 1. a. ¿Cómo se identifican las competencias y habilidades del personal, requeridas para el desarrollo de sus labores?', 1, 'a', 1),
(31, 6, '3. 1. b. ¿Cómo se recluta, selecciona y contrata al personal, de acuerdo a las necesidades del GORE?', 1, 'b', 1),
(32, 6, '3. 1. c. ¿Cómo se mantiene actualizada la información respecto a las caractersticas del personal del GORE?', 1, 'c', 1),
(33, 6, '3. 1. d. ¿Cómo se consideran los objetivos, planes de acción, compromisos y metas del GORE en el desarrollo de planes y políticas de gestión de personal?', 1, 'd', 1),
(34, 6, '3. 1. e. ¿Cómo se organiza y administra el trabajo de las personas que participan en el GORE, de acuerdo con las necesidades de la organización?', 1, 'e', 1),
(35, 7, '3. 2. a. ¿Cómo se asegura que los objetivos y funciones asignadas al personal están alineados con los objetivos del GORE?', 1, 'a', 1),
(36, 7, '3. 2. b. ¿Cómo se evalúa el desempeño del personal del GORE para el desarrollo organizacional?', 1, 'b', 1),
(37, 7, '3. 2. c. ¿Cómo se refuerza, motiva y reconoce al personal del GORE para que éstos desarrollen sus potencialidades?', 1, 'c', 1),
(38, 8, '3. 3. a. ¿Cómo se detectan las necesidades de capacitación del personal del GORE?', 1, 'a', 1),
(39, 8, '3. 3. b. ¿Cómo se asegura que el plan de capacitación recoge, tanto los intereses del personal como las necesidades del GORE?', 1, 'b', 1),
(40, 8, '3. 3. c. ¿Cómo se prioriza y planifica la entrega de la capacitación y determinan los recursos necesarios para su desarrollo?', 1, 'c', 1),
(41, 8, '3. 3. d. ¿Cómo se imparte y evalúa la capacitación del personal del GORE?', 1, 'd', 1),
(42, 8, '3. 3. e. ¿Cómo se refuerzan los conocimientos y habilidades del personal?', 1, 'e', 1),
(43, 9, '3. 4. a. ¿Cómo el personal presenta sus ideas y sugerencias para la mejora de los procesos del GORE?', 1, 'a', 1),
(44, 9, '3. 4. b. ¿Cómo se incentiva el trabajo en equipo del personal del GORE, para el mejoramiento de los procesos?', 1, 'b', 1),
(45, 9, '3. 4. c. ¿Cómo se comparten los conocimientos entre el personal del GORE, otros Gobiernos Regionales y Servicios públicos?', 1, 'c', 1),
(46, 9, '3. 4. d. ¿Cómo se asignan las facultades y atribuciones para la toma de decisiones del personal?', 1, 'd', 1),
(47, 9, '3. 4. e. ¿Cómo se involucran en el proceso de mejoramiento de calidad y sus resultados a las organizaciones del personal? (formales e informales).', 1, 'e', 1),
(48, 10, '3. 5. a. ¿Cómo se determinan los factores críticos de éxito que afectan al bienestar, satisfacción y motivación del personal del GORE?', 1, 'a', 1),
(49, 10, '3. 5. b. ¿Cómo se evalúa y mejora el nivel de bienestar, satisfacción y la motivación del personal del GORE?', 1, 'b', 1),
(50, 10, '3. 5. c. ¿Cómo participa el personal, incluyendo sus directivos, en laidentificación de las condiciones del lugar de trabajo, de salud y de seguridad?', 1, 'c', 1),
(51, 10, '3. 5. d. ¿Cómo se evalúa y mejoran las condiciones del lugar de trabajo, de salud y de seguridad del personal del GORE?', 1, 'd', 1),
(52, 11, '4. 1. a. ¿Cómo se formula/ actualiza y aprueba la Estrategia Regional de Desarrollo?', 1, 'a', 1),
(53, 11, '4. 1. b. ¿Cómo se asegura en la formulación de la ERD, el enfoque territorial, los intereses de toda la ciudadanía, el enfoque de género, la protección del medioambiente y los recursos naturales y otros propios de la región?', 1, 'b', 1),
(54, 11, '4. 1. c. ¿Cómo se asegura la articulación de la ERD con los Planes de Desarrollo Comunal (PLADECO)?', 1, 'c', 1),
(55, 11, '4. 1. d. ¿Cómo se hace seguimiento y evaluación de la ERD, en cuanto a su consistencia con las operaciones del GORE, la dinmica regional, y el cumplimiento de metas definidas?', 1, 'd', 1),
(56, 12, '4. 2. a. ¿Cómo se formulan los instrumentos indicativos de ordenamiento territorial y se establece su relación con la Estrategia Regional de Desarrollo (ERD) y las políticas públicas regionales?', 1, 'a', 1),
(57, 12, '4. 2. b. ¿Cómo el gobierno regional participa en la elaboración, y aprueba los instrumentos de planificación urbana? (Ej. Planes Reguladores).', 1, 'b', 1),
(58, 12, '4. 2. c. ¿Cómo el gobierno regional considera en su planificación el desarrollo de los territorios definidos y afectados por normas legales especficas? (ej. Zona de Inters turstico (ZOIT), área de Desarrollo Indgena (ADIS), entre otras).', 1, 'c', 1),
(59, 12, '4. 2. d. ¿Cómo se incorporan los riesgos naturales del territorio en los instrumentos de planificación de su competencia?', 1, 'd', 1),
(60, 12, '4. 2. e. ¿Cómo se hace seguimiento y evaluación a los planes reguladores metropolitanos, intercomunales, comunales y seccionales?', 1, 'e', 1),
(61, 13, '4. 3. a. ¿Cómo se formulan / actualizan y aprueban las políticas públicas, planes y programas regionales?', 1, 'a', 1),
(62, 13, '4. 3. b. ¿Cómo se asegura el financiamiento de los planes y programas regionales?', 1, 'b', 1),
(63, 13, '4. 3. c. cómo en estas formulaciones se toma en cuenta los lineamientos del Gobierno Central, de la Estrategia Regional de Desarrollo y de los requerimientos de las Municipalidades y ciudadanía?', 1, 'c', 1),
(64, 13, '4. 3. d. ¿Cómo se definen los indicadores y metas de los planes y programas?', 1, 'd', 1),
(65, 13, '4. 3. e. ¿Cómo se asegura en la formulación de las políticas públicas, planes y programas regionales; el enfoque territorial, los intereses de toda la ciudadanía, el enfoque de género, la protección del medioambiente y los recursos naturales y otros propios de la región?', 1, 'e', 1),
(66, 13, '4. 3. f. ¿Cómo se asegura que el presupuesto de la región sea coherente con los instrumentos de planificación regional?', 1, 'f', 1),
(67, 13, '4. 3. g. ¿Cómo se hace Seguimiento/Control de las políticas públicas, planes y programas regionales y se definen acciones correctivas y preventivas, si corresponde?', 1, 'g', 1),
(68, 14, '4. 4. a. ¿Cómo se levanta y recopila información clave para el desarrollo regional?', 1, 'a', 1),
(69, 14, '4. 4. b. ¿Cómo se analiza, evalúa y utiliza la información recopilada?', 1, 'b', 1),
(70, 14, '4. 4. c. ¿Cómo se genera información estructurada, ya sea, mediante estadísticas, informes, estudios, investigaciones, etc.?', 1, 'c', 1),
(71, 14, '4. 4. d. ¿Cómo se publica, difunde y comunica la información generada: al interior del GORE, a los actores clave y a la comunidad en general, tanto dentro como fuera de la región?', 1, 'd', 1),
(72, 15, '5. 1. a. ¿Cómo se estructura el proceso de Inversiones públicas y se realizan las articulaciones necesarias?', 1, 'a', 1),
(73, 15, '5. 1. b. ¿Cómo se articula con las Municipalidades el proceso de inversiones públicas para la región?', 1, 'b', 1),
(74, 15, '5. 1. c. ¿Cómo se asegura la participación de la ciudadanía y la inclusión de sus expectativas en el proceso de Inversiones públicas?', 1, 'c', 1),
(75, 15, '5. 1. d. ¿Cómo se ejecuta la selección, evaluación y decisión de inversiones con recursos propios?', 1, 'd', 1),
(76, 15, '5. 1. e. ¿Cómo se asignan, licitan y adjudican las Inversiones con recursos propios?', 1, 'e', 1),
(77, 15, '5. 1. f. ¿Cómo se realiza la programación, ejecución, control y cierre de inversiones con recursos propios?', 1, 'f', 1),
(78, 15, '5. 1. g. ¿Cómo se efecta la evaluación ex-post de inversiones con recursos propios?', 1, 'g', 1),
(79, 15, '5. 1. h. ¿Cómo se asegura que las inversiones con recursos propios se ejecutan en trminos generales dentro de los tiempos y costos originalmente previstos?', 1, 'h', 1),
(80, 15, '5. 1. i. ¿Cómo se atraen recursos y articula con el sector público y/o privado, programas de inversión conjunta o complementaria en la región?', 1, 'i', 1),
(81, 16, '5. 2. a. ¿Cómo se asegura que los Programas regionales en materias sociales y culturales que se ejecutan, sean coherentes con la ERD, políticas públicas, Planes y Programas regionales?', 1, 'a', 1),
(82, 16, '5. 2. b. ¿Cómo se coordina con las municipalidades, sectores y otros actores clave, el diseo y ejecución de Programas en materias sociales y culturales para la región?', 1, 'b', 1),
(83, 16, '5. 2. c. ¿Cómo se implementan y difunden las acciones definidas en este ámbito?', 1, 'c', 1),
(84, 16, '5. 2. d. ¿Cómo se hace seguimiento y evaluación de las acciones desarrolladas en este ámbito?', 1, 'd', 1),
(85, 17, '5. 3. a. ¿Cómo se asegura que los Programas asociados a los ámbitos del desarrollo económico y fomento productivo que se ejecutan, son coherentes con la ERD, políticas públicas, Planes y Programas regionales?', 1, 'a', 1),
(86, 17, '5. 3. b. ¿Cómo se coordina con las municipalidades, sectores y otros actores clave, para el diseo y ejecución de Programas de Desarrollo económico y Fomento Productivo para la región?', 1, 'b', 1),
(87, 17, '5. 3. c. ¿Cómo se implementan y difunden las acciones establecidas en este ámbito?', 1, 'c', 1),
(88, 17, '5. 3. d. ¿Cómo se hace seguimiento y evaluación de las acciones desarrolladas en este ámbito?', 1, 'd', 1),
(89, 18, '5. 4. a. ¿Cómo se asegura que las acciones de cooperación internacional en la región, son coherentes con la ERD, políticas públicas, Planes y Programas regionales?', 1, 'a', 1),
(90, 18, '5. 4. b. ¿Cómo se formulan las acciones de cooperación internacional?', 1, 'b', 1),
(91, 18, '5. 4. c. ¿Cómo se ejecutan y difunden las acciones de cooperación internacional?', 1, 'c', 1),
(92, 18, '5. 4. d. ¿Cómo se hace seguimiento y evaluación de las acciones desarrolladas en este ámbito?', 1, 'd', 1),
(93, 19, '6. 1. a. ¿Cómo se asegura que el plan informático, documentado y formalizado, sirve como marco de referencia para los desarrollos actuales y futuros?', 1, 'a', 1),
(94, 19, '6. 1. b. ¿Cómo se asegura que los sistemas informáticos de la organización (incluyendo Intranet y sitio Web), son compatibles entre s, están integrados, son confiables y adecuados a las necesidades del GORE?', 1, 'b', 1),
(95, 19, '6. 1. c. ¿Cómo se asegura el cumplimiento del programa de mantenimiento de Hardware y asistencia técnica de Software?', 1, 'c', 1),
(96, 20, '6. 2. a. ¿Cómo se asegura que los procesos y procedimientos contables están formalizados, cuentan con indicadores que permiten verificar su calidad, oportunidad y, cumplen las normas y leyes asociadas (por ejemplo registro contable en SIGFE)?', 1, 'a', 1),
(97, 20, '6. 2. b. ¿Cómo se planifica, optimiza y programa el presupuesto de funcionamiento del GORE, para cubrir de manera equilibrada las necesidades de todas las unidades?', 1, 'b', 1),
(98, 20, '6. 2. c. ¿Cómo se asegura la ejecución y seguimiento del presupuesto de funcionamiento del GORE?', 1, 'c', 1),
(99, 20, '6. 2. d. ¿Cómo se hace una evaluación de la ejecución del presupuesto de funcionamiento del GORE?', 1, 'd', 1),
(100, 21, '6. 3. a. ¿Cómo se asegura que los procesos de Administración de bienes, se realizan de manera eficiente y según políticas existentes?', 1, 'a', 1),
(101, 21, '6. 3. b. ¿Cómo se asegura que los procesos de Administración de servicios, se efectan de manera eficiente, expedita, oportuna y confiable, satisfaciendo los requerimientos de las áreas solicitantes?', 1, 'b', 1),
(102, 22, '6. 4. a. ¿Cómo se identifican las necesidades y planifica la adquisición de recursos materiales, equipos, infraestructura o servicios para el funcionamiento del GORE?', 1, 'a', 1),
(103, 22, '6. 4. b. ¿Cómo se gestionan las compras de bienes y servicios para el funcionamiento del GORE?', 1, 'b', 1),
(104, 22, '6. 4. c. ¿De qué manera se determinan los indicadores de desempeño de los proveedores y asociados y sus estándares? ¿Cómo se asegura el GORE que los proveedores y asociados cumplen con los estándares establecidos?', 1, 'c', 1),
(105, 22, '6. 4. d. ¿Cómo se genera comunicación permanente con los proveedores, de manera de conocer sus necesidades, expectativas y preferencias y tambión, entregarles retroalimentación?', 1, 'd', 1),
(106, 22, '6. 4. e. ¿Cómo se realiza la gestión de Unidades Técnicas? Esto incluye: conocer sus necesidades, expectativas y preferencias; generar canales y medios pertinentes de comunicación en ambos sentidos y realizar su fortalecimiento institucional, técnico y profesional.', 1, 'e', 1),
(107, 23, '7. 1. a. ¿Cómo se realiza el proceso de Planificación Institucional?', 1, 'a', 1),
(108, 23, '7. 1. b. ¿Cómo se considera en la Planificación el análisis de la situación actual, el análisis prospectivo del GORE y su entorno y las necesidades y expectativas de todos los grupos de inters?', 1, 'b', 1),
(109, 23, '7. 1. c. ¿Cómo se asegura que el personal del GORE conoce la planificación institucional?', 1, 'c', 1),
(110, 23, '7. 1. d. ¿Cómo se definen los planes de acción que permiten el cumplimiento de los objetivos y metas definidas en la planificación institucional?', 1, 'd', 1),
(111, 23, '7. 1. e. ¿De qué manera se involucra al personal en la definición e implementación de los planes de acción?', 1, 'e', 1),
(112, 23, '7. 1. f. ¿Cómo se monitorean, ajustan y mejoran los planes de acción y se retroalimenta al personal?', 1, 'f', 1),
(113, 24, '7. 2. a. ¿Cómo se obtiene y recopila la información, respecto de los resultados obtenidos por la institución, para medir su desempeño?', 1, 'a', 1),
(114, 24, '7. 2. b. ¿Cómo se analiza y evalúa la información de resultados del punto anterior?', 1, 'b', 1),
(115, 24, '7. 2. c. ¿Cómo se comunica y utiliza el resultado de los análisis para establecer prioridades y diseñar planes de mejora del desempeño del GORE?', 1, 'c', 1),
(116, 24, '7. 2. d. ¿Cómo se asegura que el Plan de Auditoria Anual de la Institución considera la evaluación permanente del sistema de control interno del Servicio?', 1, 'd', 1),
(117, 24, '7. 2. e. ¿Cómo se promueve la adopción de mecanismos de autocontrol y probidad en las distintas unidades de la organización?', 1, 'e', 1),
(118, 24, '7. 2. f. ¿Cómo se lleva a cabo el seguimiento de las medidas preventivas y correctivas, emanadas de los informes de auditora?', 1, 'f', 1),
(119, 24, '7. 2. g. ¿Cómo se asegura el proceso de gestión de riesgos de la Institución, según las directrices entregadas por el Consejo de Auditoria (CAIGG)?', 1, 'g', 1),
(120, 25, '7. 3. a. ¿Cómo se comparte el conocimiento tácito y explícito que se obtiene de las experiencias personales y de actividades formales?', 1, 'a', 1),
(121, 25, '7. 3. b. ¿Cómo se formaliza y documenta el conocimiento organizacional?', 1, 'b', 1),
(122, 25, '7. 3. c. ¿Cómo se divulgan y comunican los conocimientos generados y formalizados del GORE, con objeto de que éstos sean aplicados dentro de la organización?', 1, 'c', 1),
(123, 26, '8. 1. a. ¿Cuáles son los resultados de satisfacción e insatisfacción de la ciudadanía, socios y colaboradores?', 1, 'a', 1),
(124, 26, '8. 1. b. ¿Cuáles son los resultados del (los) indicador(es) de desempeño relativos a la participación ciudadana?', 1, 'b', 1),
(125, 26, '8. 1. c. ¿Cuáles son los resultados del (los) indicador(es) de desempeño relativos a quejas, reclamos y sugerencias de la ciudadanía, socios y colaboradores?', 1, 'c', 1),
(126, 27, '8. 2. a. ¿Cuáles son los resultados del (los) indicador(es) de desempeño financiero? Incluya indicadores asociados a la gestión presupuestaria, financiera y contable.', 1, 'a', 1),
(127, 27, '8. 2. b. ¿Cuáles son los resultados de indicadores de impacto de los programas desarrollados por el GORE? Incluya indicadores asociados al desarrollo económico y la inversión pública de la región, desarrollo social y cultural, de innovación y de cooperación internacional en la región.', 1, 'b', 1),
(128, 28, '8. 3. a. ¿Cuáles son los resultados del indicador(es) de desempeño de los procesos de gestión del GORE? Incluya indicadores para los procesos de Gestión de la Planificación estratégica', 1, 'a', 1),
(129, 28, '8. 3. b. ¿Cuáles son los resultados de los indicadores de la calidad de las acciones desarrolladas? Incluya indicadores para los procesos de Gestión de la Planificación estratégica Regional, Gestión de Inversiones, Desarrollo Social y Cultural, Desarrollo económico y Fomento Productivo, Cooperación Internacional, entre otros.', 1, 'b', 1),
(130, 29, '8. 4. a. ¿Cuáles son los resultados del (los) indicador(es) de satisfacción, desarrollo y compromiso del personal, incluyendo al equipo directivo?', 1, 'a', 1),
(131, 29, '8. 4. b. ¿Cuáles son los resultados de indicadores del personal? Incluya en su respuesta la dotación de personal, su rotación y sus perfiles de competencia; entre otros?', 1, 'b', 1),
(132, 29, '8. 4. c. ¿Cuáles son los resultados de indicadores clave de clima laboral, seguridad y salud ocupacional, servicios de bienestar y beneficios para el personal?', 1, 'c', 1),
(133, 30, '8. 5. a. ¿Cuáles son los resultados de indicadores clave de desempeño de las Unidades Técnicas y otros proveedores y asociados externos? Incluya en su respuesta cómo estos proveedores contribuyen al mejoramiento del desempeño del GORE.', 1, 'a', 1),
(134, 30, '8. 5. b. ¿Cuáles son los resultados de indicadores de satisfacción de las Unidades Técnicas? Tambión puede incluir a otros proveedores y asociados, si corresponde.', 1, 'b', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_gestion_priorizados`
--

CREATE TABLE IF NOT EXISTS `elementos_gestion_priorizados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_elemento_gestion` int(11) NOT NULL,
  `id_planificacion` int(11) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fkElementoGestion` (`id_elemento_gestion`),
  KEY `fkPlanificacion` (`id_planificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_gestion_responsable`
--

CREATE TABLE IF NOT EXISTS `elementos_gestion_responsable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `elemento_gestion_id` int(11) NOT NULL,
  `planificacion_id` int(11) NOT NULL,
  `responsable_id` int(11) NOT NULL,
  `centro_costo_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `puntaje_actual` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `elemento_gestion_id` (`elemento_gestion_id`),
  KEY `planificacion_id` (`planificacion_id`),
  KEY `responsable_id` (`responsable_id`),
  KEY `centro_costo_id` (`centro_costo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

--
-- Volcado de datos para la tabla `elementos_gestion_responsable`
--

INSERT INTO `elementos_gestion_responsable` (`id`, `elemento_gestion_id`, `planificacion_id`, `responsable_id`, `centro_costo_id`, `estado`, `puntaje_actual`) VALUES
(1, 1, 3, 1, 1, 1, 1),
(2, 2, 3, 1, 1, 1, 2),
(3, 3, 3, 1, 1, 1, 0),
(4, 4, 3, 1, 1, 1, 1),
(5, 6, 3, 1, 1, 1, 0),
(6, 7, 3, 1, 1, 1, 0),
(7, 8, 3, 1, 1, 1, 0),
(8, 9, 3, 1, 1, 1, 0),
(9, 10, 3, 1, 1, 1, 0),
(10, 11, 3, 1, 1, 1, 2),
(11, 12, 3, 1, 1, 1, 1),
(12, 13, 3, 1, 1, 1, 0),
(13, 14, 3, 1, 1, 1, 1),
(14, 15, 3, 1, 1, 1, 0),
(15, 16, 3, 1, 1, 1, 1),
(16, 17, 3, 1, 1, 1, 0),
(17, 18, 3, 1, 1, 1, 0),
(18, 19, 3, 1, 1, 1, 0),
(19, 20, 3, 1, 1, 1, 2),
(20, 21, 3, 1, 1, 1, 0),
(21, 22, 3, 1, 1, 1, 0),
(22, 23, 3, 1, 1, 1, 1),
(23, 24, 3, 1, 1, 1, 1),
(24, 25, 3, 1, 1, 1, 0),
(25, 26, 3, 1, 1, 1, 0),
(26, 27, 3, 1, 1, 1, 1),
(27, 28, 3, 1, 1, 1, 0),
(28, 29, 3, 1, 1, 1, 0),
(29, 30, 3, 1, 1, 1, 1),
(30, 31, 3, 1, 2, 1, 1),
(31, 32, 3, 1, 1, 1, 2),
(32, 33, 3, 1, 1, 1, 0),
(33, 34, 3, 1, 1, 1, 1),
(34, 35, 3, 1, 1, 1, 1),
(35, 36, 3, 1, 1, 1, 3),
(36, 37, 3, 1, 1, 1, 1),
(37, 38, 3, 1, 1, 1, 2),
(38, 39, 3, 1, 1, 1, 2),
(39, 40, 3, 1, 1, 1, 1),
(40, 41, 3, 1, 1, 1, 1),
(41, 42, 3, 1, 1, 1, 0),
(42, 43, 3, 1, 1, 1, 1),
(43, 44, 3, 1, 1, 1, 2),
(44, 45, 3, 1, 1, 1, 1),
(45, 46, 3, 1, 1, 1, 2),
(46, 47, 3, 1, 1, 1, 2),
(47, 48, 3, 1, 1, 1, 2),
(48, 49, 3, 1, 1, 1, 2),
(49, 50, 3, 1, 1, 1, 2),
(50, 51, 3, 1, 1, 1, 2),
(51, 52, 3, 1, 1, 1, 3),
(52, 53, 3, 1, 1, 1, 2),
(53, 54, 3, 1, 1, 1, 1),
(54, 55, 3, 1, 1, 1, 1),
(55, 56, 3, 1, 1, 1, 1),
(56, 57, 3, 1, 1, 1, 2),
(57, 58, 3, 1, 1, 1, 1),
(58, 59, 3, 1, 1, 1, 2),
(59, 60, 3, 1, 1, 1, 0),
(60, 61, 3, 1, 1, 1, 1),
(61, 62, 3, 1, 1, 1, 2),
(62, 63, 3, 1, 1, 1, 2),
(63, 64, 3, 1, 1, 1, 1),
(64, 65, 3, 1, 1, 1, 1),
(65, 66, 3, 1, 1, 1, 1),
(66, 67, 3, 1, 1, 1, 1),
(67, 68, 3, 1, 1, 1, 1),
(68, 69, 3, 1, 1, 1, 1),
(69, 70, 3, 1, 1, 1, 1),
(70, 71, 3, 1, 1, 1, 1),
(71, 72, 3, 1, 1, 1, 2),
(72, 73, 3, 1, 1, 1, 2),
(73, 74, 3, 1, 1, 1, 0),
(74, 75, 3, 1, 1, 1, 2),
(75, 76, 3, 1, 1, 1, 2),
(76, 77, 3, 1, 1, 1, 2),
(77, 78, 3, 1, 1, 1, 0),
(78, 79, 3, 1, 1, 1, 1),
(79, 80, 3, 1, 1, 1, 1),
(80, 81, 3, 1, 1, 1, 1),
(81, 82, 3, 1, 1, 1, 1),
(82, 83, 3, 1, 1, 1, 1),
(83, 84, 3, 1, 1, 1, 1),
(84, 85, 3, 1, 1, 1, 1),
(85, 86, 3, 1, 1, 1, 2),
(86, 87, 3, 1, 1, 1, 1),
(87, 88, 3, 1, 1, 1, 1),
(88, 89, 3, 1, 1, 1, 1),
(89, 90, 3, 1, 1, 1, 0),
(90, 91, 3, 1, 1, 1, 1),
(91, 92, 3, 1, 1, 1, 0),
(92, 93, 3, 1, 1, 1, 3),
(93, 94, 3, 1, 1, 1, 3),
(94, 95, 3, 1, 1, 1, 2),
(95, 96, 3, 1, 1, 1, 2),
(96, 97, 3, 1, 1, 1, 2),
(97, 98, 3, 1, 1, 1, 2),
(98, 99, 3, 1, 1, 1, 2),
(99, 100, 3, 1, 1, 1, 1),
(100, 101, 3, 1, 1, 1, 1),
(101, 102, 3, 1, 1, 1, 2),
(102, 103, 3, 1, 1, 1, 2),
(103, 104, 3, 1, 1, 1, 0),
(104, 105, 3, 1, 1, 1, 0),
(105, 106, 3, 1, 1, 1, 1),
(106, 107, 3, 1, 1, 1, 1),
(107, 108, 3, 1, 1, 1, 1),
(108, 109, 3, 1, 1, 1, 1),
(109, 110, 3, 1, 1, 1, 1),
(110, 111, 3, 1, 1, 1, 1),
(111, 112, 3, 1, 1, 1, 1),
(112, 113, 3, 1, 1, 1, 2),
(113, 114, 3, 1, 1, 1, 2),
(114, 115, 3, 1, 1, 1, 1),
(115, 116, 3, 1, 1, 1, 1),
(116, 117, 3, 1, 1, 1, 0),
(117, 118, 3, 1, 1, 1, 2),
(118, 119, 3, 1, 1, 1, 2),
(119, 120, 3, 1, 1, 1, 0),
(120, 121, 3, 1, 1, 1, 1),
(121, 122, 3, 1, 1, 1, 1),
(122, 123, 3, 1, 1, 1, 0),
(123, 124, 3, 1, 1, 1, 0),
(124, 125, 3, 1, 1, 1, 0),
(125, 126, 3, 1, 1, 1, 3),
(126, 127, 3, 1, 1, 1, 0),
(127, 128, 3, 1, 1, 1, 1),
(128, 129, 3, 1, 1, 1, 0),
(129, 130, 3, 1, 1, 1, 0),
(130, 131, 3, 1, 1, 1, 3),
(131, 132, 3, 1, 1, 1, 1),
(132, 133, 3, 1, 1, 1, 0),
(133, 134, 3, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_planificaciones`
--

CREATE TABLE IF NOT EXISTS `estados_planificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `estados_planificaciones`
--

INSERT INTO `estados_planificaciones` (`id`, `nombre`) VALUES
(1, 'En proceso'),
(2, 'En Pausa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas`
--

CREATE TABLE IF NOT EXISTS `etapas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `etapas`
--

INSERT INTO `etapas` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Definiciones Estratégicas', 'Corresponde a la etapa en donde se han definido: los desafíos estratégicos, misión, visión, objetivos estrat?©gicos, productos estratégicos del negocio, productos estratégicos de apoyo y las Áreas de mejora de la gestión.', 1),
(2, 'Indicadores y Metas de Gestion', 'Corresponde a la etapa en donde se han definido: ', 1),
(3, 'Planificacion Operativa', '', 1),
(4, 'Ajuste Final del Plan', '', 1),
(5, 'Proceso de control', '', 1),
(6, 'Evaluacion de la gestion', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_jornada`
--

CREATE TABLE IF NOT EXISTS `evaluacion_jornada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `fecha_jornada` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `planificacion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `planificacion_id` (`planificacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_jornada_documentos`
--

CREATE TABLE IF NOT EXISTS `evaluacion_jornada_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archivo` varchar(300) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `evaluacion_jornada_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `evaluacion_jornada_id` (`evaluacion_jornada_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencias_controles`
--

CREATE TABLE IF NOT EXISTS `frecuencias_controles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `plazo_maximo` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `frecuencias_controles`
--

INSERT INTO `frecuencias_controles` (`id`, `nombre`, `estado`, `plazo_maximo`) VALUES
(2, 'Trimestral', 1, 3),
(3, 'Mensual', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hitos_actividades`
--

CREATE TABLE IF NOT EXISTS `hitos_actividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_actividad` int(11) NOT NULL,
  `avance_actual` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `actividad_mes` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_actividad` (`id_actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hitos_indicadores`
--

CREATE TABLE IF NOT EXISTS `hitos_indicadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes` varchar(12) NOT NULL,
  `meta_parcial` decimal(11,2) DEFAULT '0.00',
  `meta_reportada` decimal(11,2) DEFAULT NULL,
  `id_indicador` int(11) NOT NULL,
  `conceptoa` varchar(200) DEFAULT NULL,
  `conceptob` varchar(200) DEFAULT NULL,
  `conceptoc` varchar(200) DEFAULT NULL,
  `evidencia` varchar(300) DEFAULT NULL,
  `evidencia_actividad` varchar(300) DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  `fecha` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_indicador` (`id_indicador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

CREATE TABLE IF NOT EXISTS `indicadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asociacion_id` int(11) NOT NULL,
  `responsable_id` int(11) NOT NULL,
  `frecuencia_control_id` int(11) DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `clasificacion_tipo_id` int(11) DEFAULT NULL,
  `producto_especifico_id` int(11) DEFAULT NULL,
  `tipo_formula_id` int(11) DEFAULT NULL,
  `clasificacion_dimension_id` int(11) DEFAULT NULL,
  `clasificacion_ambito_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `ascendente` int(11) NOT NULL,
  `conceptoa` text,
  `conceptob` text,
  `conceptoc` text,
  `formula` text,
  `medio_verificacion` text,
  `notas` text,
  `efectivot3` varchar(200) DEFAULT NULL,
  `efectivot2` varchar(200) DEFAULT NULL,
  `efectivot1` varchar(200) DEFAULT NULL,
  `meta_anual` varchar(200) DEFAULT NULL,
  `meta_parcial` varchar(200) DEFAULT NULL,
  `supuestos` text,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_relationship_20` (`producto_especifico_id`),
  KEY `fk_relationship_21` (`clasificacion_ambito_id`),
  KEY `fk_relationship_22` (`clasificacion_dimension_id`),
  KEY `fk_relationship_23` (`clasificacion_tipo_id`),
  KEY `fk_relationship_24` (`unidad_id`),
  KEY `fk_relationship_25` (`tipo_formula_id`),
  KEY `fk_relationship_26` (`frecuencia_control_id`),
  KEY `fk8_relationship_users` (`responsable_id`),
  KEY `fk9_qqq` (`asociacion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores_instrumentos`
--

CREATE TABLE IF NOT EXISTS `indicadores_instrumentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_indicador` int(11) NOT NULL,
  `id_instrumento` int(11) NOT NULL,
  `ponderacion` float(10,2) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fkInstrumentosID` (`id_instrumento`),
  KEY `fk2indicadores` (`id_indicador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores_observaciones`
--

CREATE TABLE IF NOT EXISTS `indicadores_observaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_indicador` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `observacion` text NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipo_observacion` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_indicador` (`id_indicador`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores_tipos_indicadores`
--

CREATE TABLE IF NOT EXISTS `indicadores_tipos_indicadores` (
  `tipo_indicador_id` int(11) NOT NULL,
  `indicador_id` int(11) NOT NULL,
  PRIMARY KEY (`tipo_indicador_id`,`indicador_id`),
  KEY `fk_relationships_27` (`indicador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumentos`
--

CREATE TABLE IF NOT EXISTS `instrumentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `instrumentos`
--

INSERT INTO `instrumentos` (`id`, `nombre`, `estado`) VALUES
(1, 'PMG', 1),
(2, 'CDC', 1),
(3, 'MG', 1),
(4, 'T', 1),
(5, 'FH', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemes_actividades`
--

CREATE TABLE IF NOT EXISTS `itemes_actividades` (
  `item_presupuestario_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `monto` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_presupuestario_id`,`actividad_id`),
  KEY `fk_relationship_30` (`actividad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemes_presupuestarios`
--

CREATE TABLE IF NOT EXISTS `itemes_presupuestarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_item_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_relationship_28` (`tipo_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `itemes_presupuestarios`
--

INSERT INTO `itemes_presupuestarios` (`id`, `tipo_item_id`, `nombre`, `estado`) VALUES
(1, 1, 'Inversión FIC', 1),
(2, 1, 'Viáticos', 1),
(3, 1, 'Estudios', 1),
(4, 2, 'Honorarios', 1),
(13, 2, 'test elimina', 1),
(14, 2, 'Transbordos', 1),
(15, 2, 'test tide', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `la_actores`
--

CREATE TABLE IF NOT EXISTS `la_actores` (
  `id_usuario` int(11) NOT NULL,
  `id_la` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_la`),
  KEY `actores_la` (`id_la`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `la_elem_gestion`
--

CREATE TABLE IF NOT EXISTS `la_elem_gestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_la` int(11) DEFAULT NULL,
  `id_elem_gestion` int(11) NOT NULL,
  `id_planificacion` int(11) NOT NULL,
  `puntaje_actual` int(11) DEFAULT NULL,
  `puntaje_esperado` int(11) DEFAULT NULL,
  `puntaje_real` int(11) DEFAULT NULL,
  `puntaje_revisado` int(11) DEFAULT NULL,
  `archivo` varchar(300) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `evidencia` text,
  PRIMARY KEY (`id`),
  KEY `laelem_la` (`id_la`),
  KEY `elem_gestion` (`id_elem_gestion`),
  KEY `id_planificacion_la` (`id_planificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `la_elem_gestion_documentos`
--

CREATE TABLE IF NOT EXISTS `la_elem_gestion_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `la_elem_id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `la_elemt1` (`la_elem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leyes_mandatos`
--

CREATE TABLE IF NOT EXISTS `leyes_mandatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `url` varchar(300) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `leyes_mandatos`
--

INSERT INTO `leyes_mandatos` (`id`, `nombre`, `descripcion`, `url`, `estado`) VALUES
(10, 'Test Nueva Ley', 'Descripción de la LEY', 'http://www.google.cl', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_accion`
--

CREATE TABLE IF NOT EXISTS `lineas_accion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_la` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `descripcion` text NOT NULL,
  `id_responsable_implementacion` int(11) NOT NULL,
  `id_responsable_mantencion` int(11) NOT NULL,
  `id_indicador` int(11) NOT NULL,
  `producto_estrategico_id` int(11) NOT NULL,
  `centro_costo_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `la_tipola` (`id_tipo_la`),
  KEY `la_indicador` (`id_indicador`),
  KEY `userimplementacion` (`id_responsable_implementacion`),
  KEY `usermantencion` (`id_responsable_mantencion`),
  KEY `producto_estrategico_id` (`producto_estrategico_id`),
  KEY `centro_costo_id` (`centro_costo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 25600 kB; (`id_centro_responsabilidad`) REFER `' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mailbox_conversation`
--

CREATE TABLE IF NOT EXISTS `mailbox_conversation` (
  `conversation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `initiator_id` int(10) NOT NULL,
  `interlocutor_id` int(10) NOT NULL,
  `subject` varchar(100) NOT NULL DEFAULT '',
  `bm_read` tinyint(3) NOT NULL DEFAULT '0',
  `bm_deleted` tinyint(3) NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL,
  `is_system` enum('yes','no') NOT NULL DEFAULT 'no',
  `initiator_del` tinyint(1) unsigned DEFAULT '0',
  `interlocutor_del` tinyint(1) unsigned DEFAULT '0',
  `tipo_mensaje_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`conversation_id`),
  KEY `initiator_id` (`initiator_id`),
  KEY `interlocutor_id` (`interlocutor_id`),
  KEY `conversation_ts` (`modified`),
  KEY `subject` (`subject`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mailbox_message`
--

CREATE TABLE IF NOT EXISTS `mailbox_message` (
  `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_id` int(10) unsigned NOT NULL DEFAULT '0',
  `recipient_id` int(10) unsigned NOT NULL DEFAULT '0',
  `text` mediumtext NOT NULL,
  `crc64` bigint(20) NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `sender_profile_id` (`sender_id`),
  KEY `recipient_profile_id` (`recipient_id`),
  KEY `conversation_id` (`conversation_id`),
  KEY `timestamp` (`created`),
  KEY `crc64` (`crc64`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_principal`
--

CREATE TABLE IF NOT EXISTS `menu_principal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `nivel` int(1) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` int(1) DEFAULT '1',
  `controller` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `menu_principal`
--

INSERT INTO `menu_principal` (`id`, `nombre`, `parent_id`, `nivel`, `descripcion`, `estado`, `controller`) VALUES
(1, 'Proceso de Planificación Institucional', NULL, 1, 'etapasPlanificacion', 1, NULL),
(2, 'Formulación Definiciones Estratégicas', 1, 2, 'etapasPlanificacionFormulacion', 1, NULL),
(3, 'Formulación de Indicadores & Metas de Gestión', 1, 2, 'etapasPlanificacionFormulacionIndicadores', 1, NULL),
(4, 'Planificación Operativa y Formulación Presupuestaria', 1, 2, 'etapasPlanificacionOperativa', 1, NULL),
(5, 'Ajuste Final Plan', 1, 2, '', 1, NULL),
(6, 'Definición de Desafíos Estratégicos', 2, 3, '', 1, 'desafiosEstrategicos'),
(7, 'Definición de Misión', 2, 3, '', 1, 'MisionesVisiones'),
(8, 'Definición de Objetivos Estratégicos', 2, 3, '', 1, 'objetivosEstrategicos'),
(9, 'Productos Estratégicos del Negocio', 2, 3, '', 1, 'productosEstrategicos'),
(10, 'Productos Estratégicos de Apoyo', 2, 3, '', 1, 'productosEstrategicos'),
(11, 'Áreas de Mejora de la Gestión', 2, 3, '', 1, 'elementosGestionPriorizados'),
(12, 'Cierre Interno de la Etapa', 2, 3, '', 1, NULL),
(13, 'Definir Indicadores y Metas', 3, 3, '', 1, 'indicadores'),
(14, 'Definición de Líneas de Acción y AMI', 3, 3, '', 1, 'lineasAccion'),
(15, 'Asignar Indicadores', 3, 3, '', 1, 'indicadoresInstrumentos'),
(16, 'Cierre Interno de la Etapa', 3, 3, '', 1, NULL),
(20, 'Reporte General de Avance', 19, 2, NULL, 1, 'panelAvances'),
(19, 'Proceso de Control de Gestión', NULL, 1, 'etapasControl', 1, NULL),
(18, 'Asignación de Presupuesto por Centro de Costo Asociado a Productos Estratégicos', 4, 3, NULL, 1, 'presupuestoCentrosCostos'),
(17, 'Planificación de Actividades y Presupuesto por Indicador', 4, 3, NULL, 1, 'actividades'),
(21, 'Autoevaluación - Registro de Evidencia', 19, 3, NULL, 1, 'controlElementosGestion'),
(25, 'Evaluación de la Gestión Anual', 24, 2, NULL, 1, 'evaluacionElementosGestion'),
(24, 'Evaluación de La Gestión', NULL, 1, 'etapasEvaluacion', 1, NULL),
(26, 'Autoevaluación GORE', 24, 2, NULL, 1, 'evaluacionJornada'),
(27, 'Asociación de Desafíos Estratégicos', 2, 3, NULL, 1, 'mapaEstrategico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `misiones_visiones`
--

CREATE TABLE IF NOT EXISTS `misiones_visiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `planificacion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `misionvision_planificacion` (`planificacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `misiones_visiones`
--

INSERT INTO `misiones_visiones` (`id`, `nombre`, `descripcion`, `planificacion_id`) VALUES
(1, 'Misión', '<p><b style="text-align: justify;"><i><span style="background-color: transparent;">Llevar a cabo la administración superior de la región, liderando las instituciones desdentralizadas y desconcentradas, estableciendo alianzas estratégicas para avanzar en el desarrollo sustentable, arm</span></i></b><b style="text-align: justify;"><i><span style="background-color: transparent;"><b style="text-align: justify;"><i><span style="background-color: transparent;">ó<span id="pastemarkerend"></span></span></i></b>nico y equitativo de la regi</span></i></b><b style="text-align: justify;"><i><span style="background-color: transparent;"><b style="text-align: justify;"><i><span style="background-color: transparent;">ó<span id="pastemarkerend"></span></span></i></b>n, sus territorios y habitantes.</span><span id="pastemarkerend">&nbsp;</span></i></b><br>\r\n\r\n</p>\r\n', 1),
(2, 'VISIÓN', '<b style="text-align: justify;"><i>Llevar a cabo la administración superior de la región, liderando las instituciones desdentralizadas y desconcentradas, estableciendo alianzas estratégicas para avanzar en el desarrollo sustentable, armónico y equitativo de la región, sus territorios y habitantes.<span id="pastemarkerend">&nbsp;<span id="pastemarkerend">&nbsp;</span></span></i></b><br>\r\n', 1),
(3, 'Misión', '<p align="center"><b style="text-align: justify"><i><span style="background-color: transparent"><span style="color: #c0504d">llevar a cabo la administración superior de la región, liderando las instituciones desdentralizadas y desconcentradas, estableciendo alianzas estratégicas para avanzar en el desarrollo sustentable, armónico y equitativo de la región, sus territorios y habitantes.</span></span><span id="pastemarkerend">&nbsp;</span></i></b><br>\r\n\r\n</p>\r\n\r\n<p><b style="text-align: justify"><i>------</i></b></p>\r\n', 3),
(4, 'VISIÓN', '<b style="text-align: justify;"><em><span style="color: #fac08f;">llevar a cabo la administraci??n superior de la regi??n, liderando las instituciones desdentralizadas y desconcentradas, estableciendo alianzas estrat?©gicas para avanzar en el desarrollo sustentable, arm??nico y equitativo de la regi??n, sus territorios y habitantes.</span></em><span id="pastemarkerend">&nbsp;<span id="pastemarkerend">&nbsp;</span></span></b><br>\r\n\r\n<p><b style="text-align: justify;"><i><br>\r\n\r\n</i></b></p>\r\n\r\n<p><b style="text-align: justify;"><i>------</i></b></p>\r\n', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos_estrategicos`
--

CREATE TABLE IF NOT EXISTS `objetivos_estrategicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perspectiva_estrategica_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_reference_5` (`perspectiva_estrategica_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos_ministeriales`
--

CREATE TABLE IF NOT EXISTS `objetivos_ministeriales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `objetivos_ministeriales`
--

INSERT INTO `objetivos_ministeriales` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Promover la descentralización política, administrativa y fiscal', 'Promover la descentralización política, administrativa y fiscal', 1),
(3, 'Contribuir al desarrollo de las regiones y comunas, fortaleciendo su capacidad de buen gobierno, en coherencia con el proceso de descentralización', 'Contribuir al desarrollo de las regiones y comunas, fortaleciendo su capacidad de buen gobierno, en coherencia con el proceso de descentralización', 1),
(9, 'Promover la descentralización política, administrativa y fiscal', 'Promover la descentralización política, administrativa y fiscal', 1),
(10, 'Contribuir al desarrollo de las regiones y comunas, fortaleciendo su capacidad de buen gobierno, en coherencia con el proceso de descentralización', 'Contribuir al desarrollo de las regiones y comunas, fortaleciendo su capacidad de buen gobierno, en coherencia con el proceso de descentralización', 1),
(11, 'hacer campaña para la proxima elección presidencial', 'Estan todos convocados a partir de marzo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos_objetivos`
--

CREATE TABLE IF NOT EXISTS `objetivos_objetivos` (
  `objetivo_estrategico_id` int(11) NOT NULL,
  `objetivo_ministerial_id` int(11) NOT NULL,
  PRIMARY KEY (`objetivo_estrategico_id`,`objetivo_ministerial_id`),
  KEY `fk_relationship_77` (`objetivo_ministerial_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos_productos`
--

CREATE TABLE IF NOT EXISTS `objetivos_productos` (
  `objetivo_estrategico_id` int(11) NOT NULL,
  `producto_estrategico_id` int(11) NOT NULL,
  PRIMARY KEY (`objetivo_estrategico_id`,`producto_estrategico_id`),
  KEY `fk_relationship_8` (`producto_estrategico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos_procesos`
--

CREATE TABLE IF NOT EXISTS `periodos_procesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `periodos_procesos`
--

INSERT INTO `periodos_procesos` (`id`, `descripcion`) VALUES
(1, '2012'),
(14, '2011'),
(16, '2013');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perspectivas_estrategicas`
--

CREATE TABLE IF NOT EXISTS `perspectivas_estrategicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `perspectivas_estrategicas`
--

INSERT INTO `perspectivas_estrategicas` (`id`, `nombre`, `estado`) VALUES
(1, 'Mandante Superior', 1),
(2, 'Clientes', 1),
(3, 'Procesos', 1),
(4, 'Aprendizaje y Desarrollo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planificaciones`
--

CREATE TABLE IF NOT EXISTS `planificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado_planificacion_id` int(11) DEFAULT NULL,
  `periodo_proceso_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_reference_2` (`periodo_proceso_id`),
  KEY `fk_reference_4` (`estado_planificacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `planificaciones`
--

INSERT INTO `planificaciones` (`id`, `estado_planificacion_id`, `periodo_proceso_id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 1, 1, 'Planificaciones Uno', 'Descripcion de planificacion uno.', 1),
(2, 1, 14, 'Planificación 2', 'Descripción de planificación 2', 1),
(3, 1, 16, 'Planificación 2013', 'Descripcion de planificacion uno.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_clientes`
--

CREATE TABLE IF NOT EXISTS `productos_clientes` (
  `cliente_id` int(11) NOT NULL,
  `producto_estrategico_id` int(11) NOT NULL,
  PRIMARY KEY (`cliente_id`,`producto_estrategico_id`),
  KEY `fk_relationship_100` (`producto_estrategico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_especificos`
--

CREATE TABLE IF NOT EXISTS `productos_especificos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subproducto_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_relationship_15` (`subproducto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_estrategicos`
--

CREATE TABLE IF NOT EXISTS `productos_estrategicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_producto_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `gestion_territorial` int(11) DEFAULT '0',
  `desagregado_sexo` int(11) DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT '1',
  `desagregado_sexo_descripcion` text,
  `gestion_territorial_descripcion` text,
  `nombre_corto` varchar(20) DEFAULT NULL,
  `orden` int(2) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_relationship_17` (`tipo_producto_id`),
  KEY `fk_relationship_19` (`division_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_itemes`
--

CREATE TABLE IF NOT EXISTS `productos_itemes` (
  `centro_costo_id` int(11) NOT NULL,
  `item_presupuestario_id` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `planificacion_id` int(11) NOT NULL,
  PRIMARY KEY (`centro_costo_id`,`item_presupuestario_id`,`planificacion_id`),
  KEY `fk_relationship_31` (`item_presupuestario_id`),
  KEY `planificacion_id` (`planificacion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos_itemes`
--

INSERT INTO `productos_itemes` (`centro_costo_id`, `item_presupuestario_id`, `monto`, `planificacion_id`) VALUES
(1, 4, 40000, 1),
(1, 13, 50000, 1),
(1, 14, 30000, 1),
(1, 15, 20000, 1),
(3, 1, 20000, 1),
(3, 2, 5000, 1),
(3, 4, 10000, 1),
(3, 4, 10000, 3),
(3, 13, 30000, 1),
(3, 13, 30000, 3),
(3, 14, 5000, 1),
(3, 14, 5000, 3),
(3, 15, 5000, 1),
(3, 15, 5000, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_estrategico_centro_costo`
--

CREATE TABLE IF NOT EXISTS `producto_estrategico_centro_costo` (
  `producto_estrategico_id` int(11) NOT NULL DEFAULT '0',
  `centro_costo_id` int(11) NOT NULL DEFAULT '0',
  `porcentaje` int(11) DEFAULT NULL,
  PRIMARY KEY (`producto_estrategico_id`,`centro_costo_id`),
  KEY `FK_CC` (`centro_costo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`user_id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles_fields`
--

CREATE TABLE IF NOT EXISTS `profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcriterios`
--

CREATE TABLE IF NOT EXISTS `subcriterios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_criterio` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `cantidad_elementos` int(11) NOT NULL,
  `factor` float NOT NULL,
  `puntaje_elemento` float NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `n_subcriterio` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk1_22` (`id_criterio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `subcriterios`
--

INSERT INTO `subcriterios` (`id`, `id_criterio`, `nombre`, `descripcion`, `cantidad_elementos`, `factor`, `puntaje_elemento`, `estado`, `n_subcriterio`) VALUES
(1, 1, '1. 1. Liderazgo Interno de Alta Dirección', 'Liderazgo Interno de Alta Dirección', 9, 15, 0.33, 1, 1),
(2, 1, '1. 2. Liderazgo Regional y Gestión de Alianzas y Colaboradores', 'Liderazgo Regional y Gestión de Alianzas y Colaboradores', 5, 15, 0.6, 1, 2),
(3, 1, '1. 3. Gestión de la Transparencia, rendición de cuentas y supervisión', 'Gestión de la Transparencia, rendición de cuentas y supervisión', 5, 15, 0.6, 1, 3),
(4, 2, '2. 1. Gestión de la participación ciudadana, socios y colaboradores', 'Gestión de la participación ciudadana, socios y colaboradores', 6, 20, 0.67, 1, 1),
(5, 2, '2. 2. Gestión de la identidad e imagen de marca del GORE', 'Gestión de la identidad e imagen de marca del GORE', 3, 20, 1.33, 1, 2),
(6, 3, '3. 1. Gestión del Personal', 'Gestión del Personal', 5, 12, 0.48, 1, 1),
(7, 3, '3. 2. Desempeño, compensación y reconocimiento', 'Desempeño, compensación y reconocimiento', 3, 12, 0.8, 1, 2),
(8, 3, '3. 3. Capacitación y Desarrollo', 'Capacitación y Desarrollo', 5, 12, 0.48, 1, 3),
(9, 3, '3. 4. Participación del personal y sus representantes en le proceso de gestión de calidad', 'Participación del personal y sus representantes en le proceso de gestión de calidad', 5, 12, 0.48, 1, 4),
(10, 3, '3. 5. Calidad de vida y prevención de riesgos en el trabajo', 'Calidad de vida y prevención de riesgos en el trabajo', 4, 12, 0.6, 1, 5),
(11, 4, '4. 1. Formulación, Aprobación y Seguimiento de la Estrategia Regional de Desarrollo', 'Formulación, Aprobación y Seguimiento de la Estrategia Regional de Desarrollo', 4, 18.75, 0.94, 1, 1),
(12, 4, '4. 2. Planificación y Ordenamiento Territorial', 'Planificación y Ordenamiento Territorial', 5, 18.75, 0.75, 1, 2),
(13, 4, '4. 3. Formulación, aprobación y seguimiento de Políticas Públicas, Planes y Programas', 'Formulación, aprobación y seguimiento de Políticas Públicas, Planes y Programas', 7, 18.75, 0.54, 1, 3),
(14, 4, '4. 4. Gestión de la información regional', 'Gestión de la información regional', 4, 18.75, 0.94, 1, 4),
(15, 5, '5. 1. Gestión de Inversiones', 'Gestión de Inversiones', 9, 22.5, 0.5, 1, 1),
(16, 5, '5. 2. Programa de Desarrollo Social y Cultural', 'Programa de Desarrollo Social y Cultural', 4, 22.5, 1.13, 1, 2),
(17, 5, '5. 3. Programa de Desarrollo Econ??mico y Fomento Productivo', 'Programa de Desarrollo Econ??mico y Fomento Productivo', 4, 22.5, 1.13, 1, 3),
(18, 5, '5. 4. Programa de Coorperación Internacional', 'Programa de Coorperación Internacional', 4, 22.5, 1.13, 1, 4),
(19, 6, '6. 1. Administración, soporte y asesoría en tecnología de Información y Comunicación', 'Administración, soporte y asesoría en tecnología de Información y Comunicación', 3, 12.5, 0.83, 1, 1),
(20, 6, '6. 2. Gestión Financiera-Contable', 'Gestión Financiera-Contable', 4, 12.5, 0.63, 1, 2),
(21, 6, '6. 3. Administración en bienes y servicios', 'Administración en bienes y servicios', 2, 12.5, 1.25, 1, 3),
(22, 6, '6. 4. Gestión de Proveedores y asociados', 'Gestión de Proveedores y asociados', 5, 12.5, 0.5, 1, 4),
(23, 7, '7. 1. Planificación del desarrollo institucional y control de gestión corporativo', 'Planificación del desarrollo institucional y control de gestión corporativo', 6, 13.4, 0.45, 1, 1),
(24, 7, '7. 2. Evaluación de la gestión de la organización', 'Evaluación de la gestión de la organización', 7, 13.3, 0.38, 1, 2),
(25, 7, '7. 3. Gestión del conocimiento organizacional', 'Gestión del conocimiento organizacional', 3, 13.3, 0.89, 1, 3),
(26, 10, '8. 1. Resultados en la satisfacción de la cuidadanía,socios y colaboradores', 'Resultados en la satisfacción de la cuidadanía,socios y colaboradores', 3, 20, 1.33, 1, 1),
(27, 10, '8. 2. Resultados de desempeño financiero y de impacto', 'Resultados de desempeño financiero y de impacto', 2, 20, 2, 1, 2),
(28, 10, '8. 3. Resultados de la efectividad organizacional ', 'Resultados de la efectividad organizacional\r\n', 2, 20, 2, 1, 3),
(29, 10, '8. 4. Resultados en la satisfacción del personal ', 'Resultados en la satisfacción del personal\r\n', 3, 20, 1.33, 1, 4),
(30, 10, '8. 5. Resultados en la calidad de los proveedores ', 'Resultados en la calidad de los proveedores\r\n', 2, 20, 2, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subproductos`
--

CREATE TABLE IF NOT EXISTS `subproductos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `centro_costo_id` int(11) DEFAULT NULL,
  `producto_estrategico_id` int(11) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_relationship_14` (`producto_estrategico_id`),
  KEY `fk_relationship_18` (`centro_costo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_clientes`
--

CREATE TABLE IF NOT EXISTS `tipos_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos_clientes`
--

INSERT INTO `tipos_clientes` (`id`, `nombre`, `estado`) VALUES
(1, 'Negocio', 1),
(2, 'Apoyo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_formulas`
--

CREATE TABLE IF NOT EXISTS `tipos_formulas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `formula` varchar(200) DEFAULT NULL,
  `unidad_id` int(11) NOT NULL,
  `tipo_resultado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkunidades_id` (`unidad_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `tipos_formulas`
--

INSERT INTO `tipos_formulas` (`id`, `nombre`, `estado`, `formula`, `unidad_id`, `tipo_resultado`) VALUES
(1, 'A: Dicotómico (Existe o no Existe)', 1, 'A', 4, '0'),
(2, '% de 2 Variables (A/B)*100', 1, '(A/B)*100', 1, '1'),
(3, 'Promedio Variable: (A/B)', 1, '(A/B)', 2, '0'),
(4, 'Tres Variables 1: ((A-B)/C)', 1, '((A-B)/C)', 7, '0'),
(5, 'Tres Variables 2: ((A-B)*C)', 1, '((A-B)*C)', 7, '0'),
(11, 'Tres Variables 3: (((A/B)/C)*100)', 1, '(((A/B)/C)*100)', 7, '0'),
(13, 'Tres Variables 4: (A*B)/C', 1, '(A*B)/C', 7, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_indicadores`
--

CREATE TABLE IF NOT EXISTS `tipos_indicadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_itemes`
--

CREATE TABLE IF NOT EXISTS `tipos_itemes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos_itemes`
--

INSERT INTO `tipos_itemes` (`id`, `nombre`, `estado`) VALUES
(1, 'Item Presupuesto Actividades', 1),
(2, 'Item Presupuesto Operativo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_la`
--

CREATE TABLE IF NOT EXISTS `tipos_la` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos_la`
--

INSERT INTO `tipos_la` (`id`, `nombre`, `estado`) VALUES
(1, 'AMI', 1),
(2, 'LA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_mensajes`
--

CREATE TABLE IF NOT EXISTS `tipos_mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `tipos_mensajes`
--

INSERT INTO `tipos_mensajes` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(2, 'Observación a Evidencia', 'Observación a Evidencia', 1),
(4, 'Modificación de Puntaje', 'Modificación de Puntaje', 1),
(5, 'Visto Bueno', 'Visto Bueno', 1),
(7, 'Faltan adjuntos', 'Faltan adjuntos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_productos`
--

CREATE TABLE IF NOT EXISTS `tipos_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos_productos`
--

INSERT INTO `tipos_productos` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Del Negocio', 'Producto estratégico del negocio', 1),
(2, 'De Apoyo', 'Producto estratégico de apoyo.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE IF NOT EXISTS `unidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `estado`) VALUES
(1, 'Porcentaje', 1),
(2, 'Promedio', 1),
(4, 'Existe o No Existe', 1),
(7, 'Numérica', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `rut` varchar(10) DEFAULT NULL,
  `nombres` varchar(200) DEFAULT NULL,
  `ape_paterno` varchar(200) DEFAULT NULL,
  `ape_materno` varchar(200) DEFAULT NULL,
  `cargo_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`),
  KEY `cargo_id` (`cargo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`, `rut`, `nombres`, `ape_paterno`, `ape_materno`, `cargo_id`, `estado`) VALUES
(1, 'adminspcg', '21232f297a57a5a743894a0e4a801fc3', 'marcelo.ceballos@tide.cl', 'a437f2e14d8047e5ddac702202eeda97', '2013-04-01 19:21:01', '2013-07-26 20:21:48', 1, 1, '5123123-4', 'Admin', 'Ceballos', 'Pavez', 1, 1),
(3, 'tide', 'e10adc3949ba59abbe56e057f20f883e', 'r.ceballos@tide.cl', '21e496bb0de80fc2f9b15141b127b36b', '2013-08-05 20:50:36', '2013-08-05 20:50:36', 0, 1, '10234245-K', 'Javier', 'Ceballos', 'Pavez', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_centros`
--

CREATE TABLE IF NOT EXISTS `users_centros` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `centro_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`centro_id`),
  KEY `fk22_centro` (`centro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users_centros`
--

INSERT INTO `users_centros` (`user_id`, `centro_id`) VALUES
(1, 1),
(3, 1),
(1, 2),
(1, 3),
(1, 15),
(1, 16),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaticos`
--

CREATE TABLE IF NOT EXISTS `viaticos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto_100` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `grado_desde` int(11) NOT NULL,
  `grado_hasta` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Volcado de datos para la tabla `viaticos`
--

INSERT INTO `viaticos` (`id`, `monto_100`, `estado`, `grado_desde`, `grado_hasta`) VALUES
(1, 10000, 1, 1, 4),
(38, 10000, 1, 3, 4),
(39, 100000, 1, 5, 6),
(41, 60000, 1, 1, 2),
(43, 15000, 1, 1, 9),
(46, 234508, 1, 12, 13),
(47, 123412, 1, 2, 13),
(48, 102345, 1, 3, 8),
(49, 102345, 1, 3, 8),
(50, 18900, 1, 1, 3),
(51, 233, 1, 1, 12),
(53, 123456, 1, 100, 1000);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activacionProceso`
--
ALTER TABLE `activacionProceso`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`periodo_id`) REFERENCES `periodos_procesos` (`id`);

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `fk_relationship_29` FOREIGN KEY (`indicador_id`) REFERENCES `indicadores` (`id`);

--
-- Filtros para la tabla `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2_users` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `centros_costos`
--
ALTER TABLE `centros_costos`
  ADD CONSTRAINT `fk_relationship_11` FOREIGN KEY (`division_id`) REFERENCES `divisiones` (`id`);

--
-- Filtros para la tabla `cierres_internos`
--
ALTER TABLE `cierres_internos`
  ADD CONSTRAINT `fkcierreInterno` FOREIGN KEY (`id_etapa`) REFERENCES `etapas` (`id`),
  ADD CONSTRAINT `fkcierreInternoUsuario` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fkcierreplanificaion` FOREIGN KEY (`id_planificacion`) REFERENCES `planificaciones` (`id`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_relationship_9` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipos_clientes` (`id`);

--
-- Filtros para la tabla `desafios_estrategicos`
--
ALTER TABLE `desafios_estrategicos`
  ADD CONSTRAINT `fk_reference_1` FOREIGN KEY (`perspectiva_estrategica_id`) REFERENCES `perspectivas_estrategicas` (`id`),
  ADD CONSTRAINT `fk_reference_3` FOREIGN KEY (`planificacion_id`) REFERENCES `planificaciones` (`id`);

--
-- Filtros para la tabla `desafios_objetivos`
--
ALTER TABLE `desafios_objetivos`
  ADD CONSTRAINT `fk_reference_6` FOREIGN KEY (`desafio_estrategico_id`) REFERENCES `desafios_estrategicos` (`id`),
  ADD CONSTRAINT `fk_reference_66` FOREIGN KEY (`objetivo_estrategico_id`) REFERENCES `objetivos_estrategicos` (`id`);

--
-- Filtros para la tabla `desafio_desafio`
--
ALTER TABLE `desafio_desafio`
  ADD CONSTRAINT `desafio_desafio_ibfk_1` FOREIGN KEY (`desafio_estrategico_id`) REFERENCES `desafios_estrategicos` (`id`),
  ADD CONSTRAINT `desafio_desafio_ibfk_2` FOREIGN KEY (`desafio_estrategico_mm_id`) REFERENCES `desafios_estrategicos` (`id`);

--
-- Filtros para la tabla `ejecucion_presupuestaria`
--
ALTER TABLE `ejecucion_presupuestaria`
  ADD CONSTRAINT `centro_costo1` FOREIGN KEY (`id_centro_costo`) REFERENCES `centros_costos` (`id`),
  ADD CONSTRAINT `division` FOREIGN KEY (`id_division`) REFERENCES `divisiones` (`id`),
  ADD CONSTRAINT `item_presupuestario` FOREIGN KEY (`id_item_presupuestario`) REFERENCES `itemes_presupuestarios` (`id`),
  ADD CONSTRAINT `planificacion1` FOREIGN KEY (`id_planificacion`) REFERENCES `planificaciones` (`id`);

--
-- Filtros para la tabla `elementos_gestion`
--
ALTER TABLE `elementos_gestion`
  ADD CONSTRAINT `elementos_gestion_ibfk_1` FOREIGN KEY (`responsable_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk1_324` FOREIGN KEY (`id_subcriterio`) REFERENCES `subcriterios` (`id`);

--
-- Filtros para la tabla `elementos_gestion_priorizados`
--
ALTER TABLE `elementos_gestion_priorizados`
  ADD CONSTRAINT `fkElementoGestion` FOREIGN KEY (`id_elemento_gestion`) REFERENCES `elementos_gestion` (`id`),
  ADD CONSTRAINT `fkPlanificacion` FOREIGN KEY (`id_planificacion`) REFERENCES `planificaciones` (`id`);

--
-- Filtros para la tabla `elementos_gestion_responsable`
--
ALTER TABLE `elementos_gestion_responsable`
  ADD CONSTRAINT `elementos_gestion_responsable_ibfk_1` FOREIGN KEY (`elemento_gestion_id`) REFERENCES `elementos_gestion` (`id`),
  ADD CONSTRAINT `elementos_gestion_responsable_ibfk_2` FOREIGN KEY (`planificacion_id`) REFERENCES `planificaciones` (`id`),
  ADD CONSTRAINT `elementos_gestion_responsable_ibfk_3` FOREIGN KEY (`responsable_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `elementos_gestion_responsable_ibfk_4` FOREIGN KEY (`centro_costo_id`) REFERENCES `centros_costos` (`id`);

--
-- Filtros para la tabla `evaluacion_jornada`
--
ALTER TABLE `evaluacion_jornada`
  ADD CONSTRAINT `evaluacion_jornada_ibfk_1` FOREIGN KEY (`planificacion_id`) REFERENCES `planificaciones` (`id`);

--
-- Filtros para la tabla `evaluacion_jornada_documentos`
--
ALTER TABLE `evaluacion_jornada_documentos`
  ADD CONSTRAINT `evaluacion_jornada_documentos_ibfk_1` FOREIGN KEY (`evaluacion_jornada_id`) REFERENCES `evaluacion_jornada` (`id`);

--
-- Filtros para la tabla `hitos_actividades`
--
ALTER TABLE `hitos_actividades`
  ADD CONSTRAINT `hitos_actividades_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`);

--
-- Filtros para la tabla `hitos_indicadores`
--
ALTER TABLE `hitos_indicadores`
  ADD CONSTRAINT `fk1_11` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id`);

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `fk8_relationship_users` FOREIGN KEY (`responsable_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk9_qqq` FOREIGN KEY (`asociacion_id`) REFERENCES `asociaciones` (`id`),
  ADD CONSTRAINT `fk_relationship_20` FOREIGN KEY (`producto_especifico_id`) REFERENCES `productos_especificos` (`id`),
  ADD CONSTRAINT `fk_relationship_21` FOREIGN KEY (`clasificacion_ambito_id`) REFERENCES `clasificaciones_ambitos` (`id`),
  ADD CONSTRAINT `fk_relationship_22` FOREIGN KEY (`clasificacion_dimension_id`) REFERENCES `clasificaciones_dimensiones` (`id`),
  ADD CONSTRAINT `fk_relationship_23` FOREIGN KEY (`clasificacion_tipo_id`) REFERENCES `clasificaciones_tipos` (`id`),
  ADD CONSTRAINT `fk_relationship_24` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`),
  ADD CONSTRAINT `fk_relationship_25` FOREIGN KEY (`tipo_formula_id`) REFERENCES `tipos_formulas` (`id`),
  ADD CONSTRAINT `fk_relationship_26` FOREIGN KEY (`frecuencia_control_id`) REFERENCES `frecuencias_controles` (`id`);

--
-- Filtros para la tabla `indicadores_instrumentos`
--
ALTER TABLE `indicadores_instrumentos`
  ADD CONSTRAINT `fk2indicadores` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id`),
  ADD CONSTRAINT `fkInstrumentosID` FOREIGN KEY (`id_instrumento`) REFERENCES `instrumentos` (`id`);

--
-- Filtros para la tabla `indicadores_observaciones`
--
ALTER TABLE `indicadores_observaciones`
  ADD CONSTRAINT `indicadores_observaciones_ibfk_1` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id`),
  ADD CONSTRAINT `indicadores_observaciones_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `indicadores_tipos_indicadores`
--
ALTER TABLE `indicadores_tipos_indicadores`
  ADD CONSTRAINT `fk_relationships_27` FOREIGN KEY (`indicador_id`) REFERENCES `indicadores` (`id`),
  ADD CONSTRAINT `fk_relationships_277` FOREIGN KEY (`tipo_indicador_id`) REFERENCES `tipos_indicadores` (`id`);

--
-- Filtros para la tabla `itemes_actividades`
--
ALTER TABLE `itemes_actividades`
  ADD CONSTRAINT `fk_relationship_30` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`),
  ADD CONSTRAINT `fk_relationship_300` FOREIGN KEY (`item_presupuestario_id`) REFERENCES `itemes_presupuestarios` (`id`);

--
-- Filtros para la tabla `itemes_presupuestarios`
--
ALTER TABLE `itemes_presupuestarios`
  ADD CONSTRAINT `fk_relationship_28` FOREIGN KEY (`tipo_item_id`) REFERENCES `tipos_itemes` (`id`);

--
-- Filtros para la tabla `la_actores`
--
ALTER TABLE `la_actores`
  ADD CONSTRAINT `actores_la` FOREIGN KEY (`id_la`) REFERENCES `lineas_accion` (`id`),
  ADD CONSTRAINT `actores_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `la_elem_gestion`
--
ALTER TABLE `la_elem_gestion`
  ADD CONSTRAINT `elem_gestion` FOREIGN KEY (`id_elem_gestion`) REFERENCES `elementos_gestion` (`id`),
  ADD CONSTRAINT `id_planificacion_la` FOREIGN KEY (`id_planificacion`) REFERENCES `planificaciones` (`id`),
  ADD CONSTRAINT `laelem_la` FOREIGN KEY (`id_la`) REFERENCES `lineas_accion` (`id`);

--
-- Filtros para la tabla `la_elem_gestion_documentos`
--
ALTER TABLE `la_elem_gestion_documentos`
  ADD CONSTRAINT `la_elemt1` FOREIGN KEY (`la_elem_id`) REFERENCES `la_elem_gestion` (`id`);

--
-- Filtros para la tabla `lineas_accion`
--
ALTER TABLE `lineas_accion`
  ADD CONSTRAINT `la_indicador` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id`),
  ADD CONSTRAINT `la_tipola` FOREIGN KEY (`id_tipo_la`) REFERENCES `tipos_la` (`id`),
  ADD CONSTRAINT `lineas_accion_ibfk_1` FOREIGN KEY (`producto_estrategico_id`) REFERENCES `productos_estrategicos` (`id`),
  ADD CONSTRAINT `lineas_accion_ibfk_2` FOREIGN KEY (`centro_costo_id`) REFERENCES `centros_costos` (`id`),
  ADD CONSTRAINT `userimplementacion` FOREIGN KEY (`id_responsable_implementacion`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usermantencion` FOREIGN KEY (`id_responsable_mantencion`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `misiones_visiones`
--
ALTER TABLE `misiones_visiones`
  ADD CONSTRAINT `misionvision_planificacion` FOREIGN KEY (`planificacion_id`) REFERENCES `planificaciones` (`id`);

--
-- Filtros para la tabla `objetivos_estrategicos`
--
ALTER TABLE `objetivos_estrategicos`
  ADD CONSTRAINT `fk_reference_5` FOREIGN KEY (`perspectiva_estrategica_id`) REFERENCES `perspectivas_estrategicas` (`id`);

--
-- Filtros para la tabla `objetivos_objetivos`
--
ALTER TABLE `objetivos_objetivos`
  ADD CONSTRAINT `fk_relationship_7` FOREIGN KEY (`objetivo_estrategico_id`) REFERENCES `objetivos_estrategicos` (`id`),
  ADD CONSTRAINT `fk_relationship_77` FOREIGN KEY (`objetivo_ministerial_id`) REFERENCES `objetivos_ministeriales` (`id`);

--
-- Filtros para la tabla `objetivos_productos`
--
ALTER TABLE `objetivos_productos`
  ADD CONSTRAINT `fk_relationship_8` FOREIGN KEY (`producto_estrategico_id`) REFERENCES `productos_estrategicos` (`id`),
  ADD CONSTRAINT `fk_relationship_88` FOREIGN KEY (`objetivo_estrategico_id`) REFERENCES `objetivos_estrategicos` (`id`);

--
-- Filtros para la tabla `planificaciones`
--
ALTER TABLE `planificaciones`
  ADD CONSTRAINT `fk_reference_2` FOREIGN KEY (`periodo_proceso_id`) REFERENCES `periodos_procesos` (`id`),
  ADD CONSTRAINT `fk_reference_4` FOREIGN KEY (`estado_planificacion_id`) REFERENCES `estados_planificaciones` (`id`);

--
-- Filtros para la tabla `productos_clientes`
--
ALTER TABLE `productos_clientes`
  ADD CONSTRAINT `fk_relationship_10` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_relationship_100` FOREIGN KEY (`producto_estrategico_id`) REFERENCES `productos_estrategicos` (`id`);

--
-- Filtros para la tabla `productos_especificos`
--
ALTER TABLE `productos_especificos`
  ADD CONSTRAINT `fk_relationship_15` FOREIGN KEY (`subproducto_id`) REFERENCES `subproductos` (`id`);

--
-- Filtros para la tabla `productos_estrategicos`
--
ALTER TABLE `productos_estrategicos`
  ADD CONSTRAINT `fk_relationship_17` FOREIGN KEY (`tipo_producto_id`) REFERENCES `tipos_productos` (`id`),
  ADD CONSTRAINT `fk_relationship_19` FOREIGN KEY (`division_id`) REFERENCES `divisiones` (`id`);

--
-- Filtros para la tabla `productos_itemes`
--
ALTER TABLE `productos_itemes`
  ADD CONSTRAINT `fk_relationship_31` FOREIGN KEY (`item_presupuestario_id`) REFERENCES `itemes_presupuestarios` (`id`),
  ADD CONSTRAINT `fk_relationship_32_2` FOREIGN KEY (`centro_costo_id`) REFERENCES `centros_costos` (`id`),
  ADD CONSTRAINT `productos_itemes_ibfk_1` FOREIGN KEY (`planificacion_id`) REFERENCES `planificaciones` (`id`);

--
-- Filtros para la tabla `producto_estrategico_centro_costo`
--
ALTER TABLE `producto_estrategico_centro_costo`
  ADD CONSTRAINT `FK_CC` FOREIGN KEY (`centro_costo_id`) REFERENCES `centros_costos` (`id`),
  ADD CONSTRAINT `FK_PE` FOREIGN KEY (`producto_estrategico_id`) REFERENCES `productos_estrategicos` (`id`);

--
-- Filtros para la tabla `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subcriterios`
--
ALTER TABLE `subcriterios`
  ADD CONSTRAINT `fk1_22` FOREIGN KEY (`id_criterio`) REFERENCES `criterios` (`id`);

--
-- Filtros para la tabla `subproductos`
--
ALTER TABLE `subproductos`
  ADD CONSTRAINT `fk2` FOREIGN KEY (`centro_costo_id`) REFERENCES `centros_costos` (`id`),
  ADD CONSTRAINT `fk_relationship_14` FOREIGN KEY (`producto_estrategico_id`) REFERENCES `productos_estrategicos` (`id`);

--
-- Filtros para la tabla `tipos_formulas`
--
ALTER TABLE `tipos_formulas`
  ADD CONSTRAINT `fkunidades_id` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`);

--
-- Filtros para la tabla `users_centros`
--
ALTER TABLE `users_centros`
  ADD CONSTRAINT `fk11_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk22_centro` FOREIGN KEY (`centro_id`) REFERENCES `centros_costos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
