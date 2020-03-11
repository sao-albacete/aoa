SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aso_cita_clase_edad_sexo`
--

DROP TABLE IF EXISTS `aso_cita_clase_edad_sexo`;
CREATE TABLE IF NOT EXISTS `aso_cita_clase_edad_sexo` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla',
  `cita_id` int(11) NOT NULL COMMENT 'Identificador de la cita',
  `clase_edad_sexo_id` int(4) NOT NULL COMMENT 'Identificador de la clase-edad-sexo',
  `cantidad` int(4) NOT NULL COMMENT 'Cantidad de individuos por clase de edad-sexo',
  PRIMARY KEY (`id`),
  KEY `idx_cita_clases_edad_sexo_cita_id` (`cita_id`),
  KEY `idx_cita_clases_edad_sexo_clase_edad_sexo_id` (`clase_edad_sexo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Relación de edad y sexo de las especie por cita' AUTO_INCREMENT=9886 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aso_cita_observador`
--

DROP TABLE IF EXISTS `aso_cita_observador`;
CREATE TABLE IF NOT EXISTS `aso_cita_observador` (
  `cita_id` int(11) NOT NULL COMMENT 'Identificador de la cita',
  `observador_secundario_id` int(11) NOT NULL COMMENT 'Identificador del observador',
  PRIMARY KEY (`cita_id`,`observador_secundario_id`),
  KEY `idx_aso_cita_obs_observador_id` (`observador_secundario_id`),
  KEY `idx_aso_cita_obs_cita_id` (`cita_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Asocia cita y observadores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aso_cuadricula_utm_municipio`
--

DROP TABLE IF EXISTS `aso_cuadricula_utm_municipio`;
CREATE TABLE IF NOT EXISTS `aso_cuadricula_utm_municipio` (
  `municipio_id` int(4) NOT NULL COMMENT 'Identificador del municipio',
  `cuadricula_utm_id` int(4) NOT NULL,
  PRIMARY KEY (`municipio_id`,`cuadricula_utm_id`),
  KEY `fk_aso_cudricula_utm_municipio_municipio_id_idx` (`municipio_id`),
  KEY `fk_aso_cudricula_utm_municipio_cuadricula_utm_id` (`cuadricula_utm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Almacena la relación entre municipios y cuadrículas UTM';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aso_especie_privacidad`
--

DROP TABLE IF EXISTS `aso_especie_privacidad`;
CREATE TABLE IF NOT EXISTS `aso_especie_privacidad` (
  `id_especie_id` int(4) NOT NULL,
  `id_privacidad_id` int(4) NOT NULL,
  `orden` int(2) NOT NULL,
  PRIMARY KEY (`id_especie_id`,`id_privacidad_id`),
  KEY `fk_aso_especie_privacidad_especie_id_idx` (`id_especie_id`),
  KEY `fk_aso_especie_privacidad_privacidad_id_idx` (`id_privacidad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Relación de especie y privacidad';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS `cita`;
CREATE TABLE IF NOT EXISTS `cita` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la cita',
  `fechaAlta` date NOT NULL COMMENT 'Fecha de alta de la cita',
  `cantidad` int(4) NOT NULL COMMENT 'Número de individuos de la especie citada',
  `observaciones` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL COMMENT 'Observaciones sobre la cita',
  `indSeleccionada` tinyint(1) DEFAULT NULL COMMENT 'Indica si la cita es seleccionada para el anuario (1) o no (0)',
  `lugar_id` int(11) NOT NULL COMMENT 'Identificador del lugar donde se produjo la cita',
  `indRarezaHomologada` int(1) DEFAULT NULL COMMENT 'Indica si la cita es de una rareza homologada (1) o no (0)',
  `observador_principal_id` int(11) NOT NULL,
  `clase_reproduccion_id` int(4) DEFAULT NULL,
  `fuente_id` int(4) NOT NULL DEFAULT '1',
  `indHabitatRaro` tinyint(1) DEFAULT NULL COMMENT 'Indica si la cita fue en un habitat raro para la especie vista (1) o no (0)',
  `indCriaHabitatRaro` tinyint(1) DEFAULT NULL COMMENT 'Indica si la cita es de una especie criando en un habitat raro (1) o no (0)',
  `indHerido` tinyint(1) DEFAULT NULL COMMENT 'Indica si el individuo/s citado/s estaba/n herido/s (1) o no (0)',
  `indComportamiento` tinyint(1) DEFAULT NULL COMMENT 'Descripción del comportamiento de la especie',
  `especie_id` int(4) NOT NULL COMMENT 'Identificador de la especie',
  `criterio_seleccion_cita_id` int(4) NOT NULL COMMENT 'Criterio utilizado en la selección de la cita',
  `indActivo` tinyint(1) DEFAULT '1',
  `importancia_cita_id` int(1) NOT NULL DEFAULT '13' COMMENT 'Identificador de la importancia de la cita',
  `estudio_id` int(2) NOT NULL DEFAULT '1',
  `indPrivacidad` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Indica si los datos sensibles de la cita de la especie deben ser privados (0) o públicos (1)',
  `indFoto` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_cita_especie_id` (`especie_id`),
  KEY `idx_cita_cri_selec_id` (`criterio_seleccion_cita_id`),
  KEY `idx_cita_fuente_id` (`fuente_id`),
  KEY `idx_cita_lugar_id` (`lugar_id`),
  KEY `idx_cita_clase_reproduccion_id` (`clase_reproduccion_id`),
  KEY `idx_cita_observador_id` (`observador_principal_id`),
  KEY `idx_cita_importancia_cita_id` (`importancia_cita_id`),
  KEY `fk_cita_estudio_id_idx` (`estudio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='cita recopiladas' AUTO_INCREMENT=12558 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_historico`
--

DROP TABLE IF EXISTS `cita_historico`;
CREATE TABLE IF NOT EXISTS `cita_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la cita',
  `fechaHistorico` datetime NOT NULL COMMENT 'Fecha de alta del registro histórico',
  `usuarioHistorico` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Usuario que realizó el cambio',
  `cita_id` int(11) NOT NULL COMMENT 'Id de cita',
  `fechaAlta` date NOT NULL COMMENT 'Fecha de alta de la cita',
  `cantidad` int(4) NOT NULL COMMENT 'Número de individuos de la especie citada',
  `observaciones` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL COMMENT 'Observaciones sobre la cita',
  `indSeleccionada` tinyint(1) DEFAULT NULL COMMENT 'Indica si la cita es seleccionada para el anuario (1) o no (0)',
  `lugar_id` int(11) NOT NULL COMMENT 'Identificador del lugar donde se produjo la cita',
  `indRarezaHomologada` int(1) DEFAULT NULL COMMENT 'Indica si la cita es de una rareza homologada (1) o no (0)',
  `observador_principal_id` int(11) NOT NULL,
  `clase_reproduccion_id` int(4) DEFAULT NULL,
  `fuente_id` int(4) NOT NULL,
  `indHabitatRaro` tinyint(1) DEFAULT NULL COMMENT 'Indica si la cita fue en un habitat raro para la especie vista (1) o no (0)',
  `indCriaHabitatRaro` tinyint(1) DEFAULT NULL COMMENT 'Indica si la cita es de una especie criando en un habitat raro (1) o no (0)',
  `indHerido` tinyint(1) DEFAULT NULL COMMENT 'Indica si el individuo/s citado/s estaba/n herido/s (1) o no (0)',
  `indComportamiento` tinyint(1) DEFAULT NULL COMMENT 'Descripción del comportamiento de la especie',
  `especie_id` int(4) NOT NULL COMMENT 'Identificador de la especie',
  `criterio_seleccion_cita_id` int(4) NOT NULL COMMENT 'Criterio utilizado en la selección de la cita',
  `importancia_cita_id` int(1) DEFAULT '13',
  `estudio_id` int(2) NOT NULL DEFAULT '1',
  `indPrivacidad` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Indica si los datos sensibles de la cita de la especie deben ser privados (0) o públicos (1)',
  `indFoto` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_cita_historico_cita_id` (`cita_id`),
  KEY `idx_cita_historico_lugar_id` (`lugar_id`),
  KEY `idx_cita_historico_clase_reproduccion_id` (`clase_reproduccion_id`),
  KEY `idx_cita_historico_fuente_id` (`fuente_id`),
  KEY `idx_cita_historico_especie_id` (`especie_id`),
  KEY `idx_cita_historico_criterio_seleccion_cita_id` (`criterio_seleccion_cita_id`),
  KEY `idx_cita_historico_observador_principal_id` (`observador_principal_id`),
  KEY `fk_cita_historico_importancia_cita_id_idx` (`importancia_cita_id`),
  KEY `fk_cita_historico_estudio_id_idx` (`estudio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Históricos de cita recopiladas' AUTO_INCREMENT=8520 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase_edad_sexo`
--

DROP TABLE IF EXISTS `clase_edad_sexo`;
CREATE TABLE IF NOT EXISTS `clase_edad_sexo` (
  `id` int(4) NOT NULL COMMENT 'Identificador de la clase edad-sexo',
  `nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la clase de edad-sexo',
  `codigo` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de datado europeo. La primera cifra se refiere a la edad, y la segunda al sexo. Sexo: 0 son aves indeterminadas, 1 son macho y 2 son hembras. Edad: 2 son aves de edad indeteminada, 3 aves jóvenes, 5 aves de segundo año, 9 aves adultas.',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_clase_edad_sexo_codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Información de clase de edad y sexo seleccionables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase_reproduccion`
--

DROP TABLE IF EXISTS `clase_reproduccion`;
CREATE TABLE IF NOT EXISTS `clase_reproduccion` (
  `id` int(4) NOT NULL COMMENT 'Identificador del tipo de clase de reproducción',
  `codigo` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código del tipo de clase de reproducción',
  `tipoCria` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del tipo de cria',
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción de la clase de reproducción',
  `indActivo` tinyint(4) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  `idTipoCria` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Clases de reproducción';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion_criterio_esp`
--

DROP TABLE IF EXISTS `clasificacion_criterio_esp`;
CREATE TABLE IF NOT EXISTS `clasificacion_criterio_esp` (
  `id` int(4) NOT NULL COMMENT 'Identificador de la clasificación de criterio',
  `codigo` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de la clasificación de criterio',
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la clasificación de criterio',
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción de la clasificación de criterio',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Clasificación de criterios a nivel nacional';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comarca`
--

DROP TABLE IF EXISTS `comarca`;
CREATE TABLE IF NOT EXISTS `comarca` (
  `id` int(4) NOT NULL COMMENT 'Identificador de la comarca',
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la comarca',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='comarca de la provincia de Albacete';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterio_seleccion_cita`
--

DROP TABLE IF EXISTS `criterio_seleccion_cita`;
CREATE TABLE IF NOT EXISTS `criterio_seleccion_cita` (
  `id` int(4) NOT NULL COMMENT 'Identificador del criterio de selección',
  `codigo` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código del criterio de selección',
  `tipoCita` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tipo de cita',
  `nombre` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción breve del criterio de selección',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Criterios utilizados para seleccionar una cita';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadricula_utm`
--

DROP TABLE IF EXISTS `cuadricula_utm`;
CREATE TABLE IF NOT EXISTS `cuadricula_utm` (
  `id` int(4) NOT NULL COMMENT 'Identificador de la cuadrícula UTM',
  `codigo` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de la cuadrículas UTM',
  `coordenadaX` int(4) NOT NULL COMMENT 'Coordenada X de la cuadricula',
  `coordenadaY` int(4) NOT NULL COMMENT 'Coordenada Y de la cuadrícula',
  `area` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `indActivo` tinyint(4) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Cuadrículas UTM 10X10 de la provincia de Albacete';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribucion_ab`
--

DROP TABLE IF EXISTS `distribucion_ab`;
CREATE TABLE IF NOT EXISTS `distribucion_ab` (
  `id` int(4) NOT NULL COMMENT 'Identificador de distribucion',
  `codigo` char(4) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de distribución',
  `nombre` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción de la abundancia de una espcie',
  `indActivo` tinyint(4) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Distribución según la Lista de Aves de AB';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especie`
--

DROP TABLE IF EXISTS `especie`;
CREATE TABLE IF NOT EXISTS `especie` (
  `id` int(4) NOT NULL COMMENT 'Identificador de la especie',
  `codigo` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Abreviatura del nombre científico de la especie\n',
  `categoria` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Categoría asignada en la lista de las aves de España',
  `codigoPresenteCanarias` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Indica si está presente en las Islas Canarias',
  `codigoPresentePiYBaleares` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Indica si esta presente en le Península Ibérica o en las Islas Baleares',
  `nombreComun` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre común de la especie',
  `nombreIngles` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre en inglés de la especie',
  `codigoEuring` int(4) DEFAULT NULL COMMENT 'Código utilizado por la institución EURING, que dirige el anillamiento científico a nivel europeo. Este código sirve para ordenar sistemáticamente las especie por su orden evolutivo',
  `codigoAerc` int(4) DEFAULT NULL COMMENT 'Código de orden taxonómico utilizado por la AERC a nivel europeo. El número lo hemos asignado nosotros para ordenar las especie por este orden. Las especie se ordenarán prioritariamente por este orden. Este orden irá cambiado según se vaya actualizando',
  `familia_id` int(4) NOT NULL COMMENT 'Identificador de la familia',
  `indRareza` int(1) DEFAULT '0' COMMENT 'Indica si es una rareza en España',
  `comentarioHistorico` longtext COLLATE utf8_unicode_ci,
  `codigoEstatusEsp` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Código de estatus español',
  `clasificacion_criterio_esp_id` int(4) DEFAULT NULL COMMENT 'Identificador de la clasificación de criterio nacional',
  `indCitadaAlbacete` tinyint(1) DEFAULT NULL COMMENT 'Indica si ha sido citada en la provincia de Albacete',
  `genero` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Género al que pertenece la especie',
  `especie` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Especie que identifica a una especie dentro de un género.',
  `subespecie` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Subespecie a la que pertenece dentro de la misma especie',
  `distribucion_ab_id` int(4) DEFAULT NULL COMMENT 'Identificador de distribucion en la provincia',
  `estatus_cuantitativo_ab_id` int(4) DEFAULT NULL COMMENT 'Identificador del estatus cuantitativo provincial',
  `proteccion_clm_id` int(4) DEFAULT NULL COMMENT 'Identificador del nivel de protección CLM',
  `proteccion_lr_id` int(4) DEFAULT NULL COMMENT 'Indentificador del nivel de proteccion LR',
  `estatus_reproductivo_ab_id` int(4) NOT NULL COMMENT 'Identificador del estatus reproductivo en la provincia de Albacete',
  `estatus` longtext COLLATE utf8_unicode_ci,
  `reproduccion` longtext COLLATE utf8_unicode_ci,
  `poblacion` longtext COLLATE utf8_unicode_ci,
  `distribucion` longtext COLLATE utf8_unicode_ci,
  `habitat` longtext COLLATE utf8_unicode_ci,
  `migracion` longtext COLLATE utf8_unicode_ci,
  `amenazas` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `idx_especie_abundancia_id` (`distribucion_ab_id`),
  KEY `idx_especie_estatus_cuantitativo_ab_id` (`estatus_cuantitativo_ab_id`),
  KEY `idx_especie_proteccion_clm_id` (`proteccion_clm_id`),
  KEY `idx_especie_proteccion_lr_id` (`proteccion_lr_id`),
  KEY `idx_especie_familia_id` (`familia_id`),
  KEY `idx_especie_clasificacion_criterio_esp_id` (`clasificacion_criterio_esp_id`),
  KEY `fk_especie_estatus_reproductivo_ab_id` (`estatus_reproductivo_ab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Información general de las especies';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_cuantitativo_ab`
--

DROP TABLE IF EXISTS `estatus_cuantitativo_ab`;
CREATE TABLE IF NOT EXISTS `estatus_cuantitativo_ab` (
  `id` int(4) NOT NULL COMMENT 'Identificador del estatus',
  `codigo` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código del estatus',
  `nombre` varchar(256) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del estatus',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Estatus cuantitativo según la "Lista de Aves de Albacete"';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_reproductivo_ab`
--

DROP TABLE IF EXISTS `estatus_reproductivo_ab`;
CREATE TABLE IF NOT EXISTS `estatus_reproductivo_ab` (
  `id` int(4) NOT NULL COMMENT 'Identificador del estatus reproductivo',
  `codigo` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código del estatus reproductivo',
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del estatus reproductivo',
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del estatus reproductivo',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Estatus reproductivo en la provincia de Albacete';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudio`
--

DROP TABLE IF EXISTS `estudio`;
CREATE TABLE IF NOT EXISTS `estudio` (
  `id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estudio',
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del estudio',
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del estudio',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tipos de estudio de una cita' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

DROP TABLE IF EXISTS `familia`;
CREATE TABLE IF NOT EXISTS `familia` (
  `id` int(4) NOT NULL COMMENT 'Identificador de la familia',
  `nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la familia',
  `orden_taxonomico_id` int(4) NOT NULL COMMENT 'Identificador del orden taxonómico',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`),
  KEY `idx_familia_orden_taxonomico_id` (`orden_taxonomico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='familia de las aves europeas.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichero`
--

DROP TABLE IF EXISTS `fichero`;
CREATE TABLE IF NOT EXISTS `fichero` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del fichero',
  `ruta` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ruta donde está alojado el fichero',
  `tipoMime` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tipo MIME del fichero',
  `nombreFisico` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre físico del fichero formado por los segundos pasados desde la Época Unix (1 de Enero de 1970 00:00:00 GMT) hasta el momento actual y el id de la cita.',
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del fichero',
  `descripcion` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Descripción del fichero',
  `fechaAlta` date NOT NULL COMMENT 'Fecha en la que se dio de alta el fichero',
  `cita_id` int(11) DEFAULT NULL COMMENT 'Identificador de la cita',
  `indImagenPortada` tinyint(1) DEFAULT NULL COMMENT 'Indica si la imagen se debe mostrar en la portada de la web',
  PRIMARY KEY (`id`),
  KEY `idx_fichero_cita_id` (`cita_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='fichero asociados en las cita.' AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fuente`
--

DROP TABLE IF EXISTS `fuente`;
CREATE TABLE IF NOT EXISTS `fuente` (
  `id` int(4) NOT NULL COMMENT 'Identificador de la fuente',
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la fuente',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='fuente de las que provienen algunas cita';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importancia_cita`
--

DROP TABLE IF EXISTS `importancia_cita`;
CREATE TABLE IF NOT EXISTS `importancia_cita` (
  `id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unívoco',
  `codigo` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de la importancia de la cita',
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción de la importancia de la cita',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Contiene los tipos de importancia de las citas' AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

DROP TABLE IF EXISTS `lugar`;
CREATE TABLE IF NOT EXISTS `lugar` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del lugar',
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del lugar',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  `municipio_id` int(4) NOT NULL COMMENT 'Identificador del municipio',
  `cuadricula_utm_id` int(4) NOT NULL COMMENT 'Identificador de la cuadrícula UTM',
  `comarca_id` int(4) NOT NULL COMMENT 'Identificador de la comarca',
  `coordenadaX` int(4) DEFAULT NULL,
  `coordenadaY` int(4) DEFAULT NULL,
  `observador_principal_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lugar_municipio_id_idx` (`municipio_id`),
  KEY `fk_lugar_comarca_id_idx` (`comarca_id`),
  KEY `fk_lugar_cuadricula_utm_id_idx` (`cuadricula_utm_id`),
  KEY `fk_lugar_observador_principal_id_idx` (`observador_principal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='lugar en los que se realizaron cita' AUTO_INCREMENT=975 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

DROP TABLE IF EXISTS `municipio`;
CREATE TABLE IF NOT EXISTS `municipio` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del municipio',
  `nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del municipio',
  `indActivo` tinyint(4) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  `comarca_id` int(4) NOT NULL COMMENT 'Identificador de la comarca',
  PRIMARY KEY (`id`),
  KEY `fk_municipio_comarca_id` (`comarca_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='municipio de la provincia de Albacete' AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observador_principal`
--

DROP TABLE IF EXISTS `observador_principal`;
CREATE TABLE IF NOT EXISTS `observador_principal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del observador',
  `nombre` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'Nombre del observador',
  `codigo` char(3) CHARACTER SET utf8 NOT NULL COMMENT 'Código a modo de abreviatura del observador',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UQ_OBSERVADOR_PRINCIPAL_CODIGO` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Datos de los observador' AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observador_secundario`
--

DROP TABLE IF EXISTS `observador_secundario`;
CREATE TABLE IF NOT EXISTS `observador_secundario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del observador',
  `nombre` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'Nombre del observador',
  `codigo` char(3) CHARACTER SET utf8 NOT NULL COMMENT 'Código a modo de abreviatura del observador',
  `observador_principal_id` int(11) NOT NULL COMMENT 'Observador principal que creo el observador secundario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UQ_OBSERVADOR_CODIGO` (`codigo`),
  KEY `fk_observador_secundario_observador_principal_id_idx` (`observador_principal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Datos de los observador' AUTO_INCREMENT=175 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_taxonomico`
--

DROP TABLE IF EXISTS `orden_taxonomico`;
CREATE TABLE IF NOT EXISTS `orden_taxonomico` (
  `id` int(4) NOT NULL COMMENT 'Identificador del orden taxonómico',
  `nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del orden taxonómico',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Ordenes taxonómicos de las aves europeas.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(4) NOT NULL COMMENT 'Identificador del perfil',
  `nombre` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'Nombre del perfil',
  `descripcion` varchar(500) CHARACTER SET utf8 NOT NULL COMMENT 'Descripción del perfil',
  `indActivo` enum('0','1') CHARACTER SET utf8 DEFAULT '1' COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='perfil disponibles en la aplicación.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privacidad`
--

DROP TABLE IF EXISTS `privacidad`;
CREATE TABLE IF NOT EXISTS `privacidad` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del nivel de privacidad',
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripcion del nivel de privacidad',
  `indActivo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Niveles de privacidad de datos de una especie' AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proteccion_clm`
--

DROP TABLE IF EXISTS `proteccion_clm`;
CREATE TABLE IF NOT EXISTS `proteccion_clm` (
  `id` int(4) NOT NULL COMMENT 'Identificador del nivel de proteccion CLM',
  `codigo` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código del nivel de proteccion CLM',
  `nombre` varchar(62) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del nivel de proteccion CLM',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nivel de proteccion en Castilla-La Mancha';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proteccion_lr`
--

DROP TABLE IF EXISTS `proteccion_lr`;
CREATE TABLE IF NOT EXISTS `proteccion_lr` (
  `id` int(4) NOT NULL COMMENT 'Identificador del nivel de protección LR',
  `codigo` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código del nivel de protección LR',
  `nombre` varchar(256) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del estatus',
  `indActivo` tinyint(1) DEFAULT NULL COMMENT 'Indica si el registro está activo (1) o no (0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nivel de protección según Libro Rojo de las Aves de España';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'e.g.:activate,reactivate',
  `key` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'can transport some information',
  `used` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `unlimited` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'used will never be set to 1',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del usuario',
  `email` varchar(150) CHARACTER SET utf8 NOT NULL COMMENT 'Correo electrónico del usuario',
  `password` varchar(40) CHARACTER SET utf8 NOT NULL COMMENT 'Clave de acceso del usuario a la aplicacion',
  `perfil_id` int(1) NOT NULL DEFAULT '2' COMMENT 'Identificador del perfil',
  `indActivo` tinyint(1) DEFAULT '1' COMMENT 'Indica si el usuario está o no activo en la aplicación',
  `username` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'Nombre completo del usuario',
  `observador_principal_id` int(11) NULL,
  `fichero_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uq_usuario_mail` (`email`),
  UNIQUE KEY `fichero_id_UNIQUE` (`fichero_id`),
  KEY `idx_usuario_perfil_id` (`perfil_id`),
  KEY `fk_usuario_observador_principal_id_idx` (`observador_principal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='usuario dados de alta en la aplicación' AUTO_INCREMENT=30 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aso_cita_clase_edad_sexo`
--
ALTER TABLE `aso_cita_clase_edad_sexo`
  ADD CONSTRAINT `fk_aso_cita_clase_edad_sexo_cita_id` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aso_cita_clase_edad_sexo_clase_edad_sexo_id` FOREIGN KEY (`clase_edad_sexo_id`) REFERENCES `clase_edad_sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `aso_cita_observador`
--
ALTER TABLE `aso_cita_observador`
  ADD CONSTRAINT `fk_aso_cita_observador_cita_id` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aso_cita_observador_observador_secundario_id` FOREIGN KEY (`observador_secundario_id`) REFERENCES `observador_secundario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `aso_cuadricula_utm_municipio`
--
ALTER TABLE `aso_cuadricula_utm_municipio`
  ADD CONSTRAINT `fk_aso_cudricula_utm_municipio_cuadricula_utm_id` FOREIGN KEY (`cuadricula_utm_id`) REFERENCES `cuadricula_utm` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aso_cudricula_utm_municipio_municipio_id` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `aso_especie_privacidad`
--
ALTER TABLE `aso_especie_privacidad`
  ADD CONSTRAINT `fk_aso_especie_privacidad_especie_id` FOREIGN KEY (`id_especie_id`) REFERENCES `especie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aso_especie_privacidad_privacidad_id` FOREIGN KEY (`id_privacidad_id`) REFERENCES `privacidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_clase_reproduccion_id` FOREIGN KEY (`clase_reproduccion_id`) REFERENCES `clase_reproduccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_criterio_seleccion_cita_id` FOREIGN KEY (`criterio_seleccion_cita_id`) REFERENCES `criterio_seleccion_cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_especie_id` FOREIGN KEY (`especie_id`) REFERENCES `especie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_estudio_id` FOREIGN KEY (`estudio_id`) REFERENCES `estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_fuente_id` FOREIGN KEY (`fuente_id`) REFERENCES `fuente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_importancia_cita_id` FOREIGN KEY (`importancia_cita_id`) REFERENCES `importancia_cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_lugar_id` FOREIGN KEY (`lugar_id`) REFERENCES `lugar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_observador_principal_id` FOREIGN KEY (`observador_principal_id`) REFERENCES `observador_principal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita_historico`
--
ALTER TABLE `cita_historico`
  ADD CONSTRAINT `fk_cita_historico_cita_id` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_clase_reproduccion_id` FOREIGN KEY (`clase_reproduccion_id`) REFERENCES `clase_reproduccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_criterio_seleccion_cita_id` FOREIGN KEY (`criterio_seleccion_cita_id`) REFERENCES `criterio_seleccion_cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_especie_id` FOREIGN KEY (`especie_id`) REFERENCES `especie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_estudio_id` FOREIGN KEY (`estudio_id`) REFERENCES `estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_fuente_id` FOREIGN KEY (`fuente_id`) REFERENCES `fuente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_importancia_cita_id` FOREIGN KEY (`importancia_cita_id`) REFERENCES `importancia_cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_lugar_id` FOREIGN KEY (`lugar_id`) REFERENCES `lugar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_historico_observador_principal_id` FOREIGN KEY (`observador_principal_id`) REFERENCES `observador_principal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `especie`
--
ALTER TABLE `especie`
  ADD CONSTRAINT `fk_especie_clasificaicon_criterio_esp_id` FOREIGN KEY (`clasificacion_criterio_esp_id`) REFERENCES `clasificacion_criterio_esp` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_especie_distribucion_ab_id` FOREIGN KEY (`distribucion_ab_id`) REFERENCES `distribucion_ab` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_especie_estatus_cuantitativo_ab_id` FOREIGN KEY (`estatus_cuantitativo_ab_id`) REFERENCES `estatus_cuantitativo_ab` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_especie_estatus_reproductivo_ab_id` FOREIGN KEY (`estatus_reproductivo_ab_id`) REFERENCES `estatus_reproductivo_ab` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_especie_familia_id` FOREIGN KEY (`familia_id`) REFERENCES `familia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_especie_proteccion_clm_id` FOREIGN KEY (`proteccion_clm_id`) REFERENCES `proteccion_clm` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_especie_proteccion_lr_id` FOREIGN KEY (`proteccion_lr_id`) REFERENCES `proteccion_lr` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `familia`
--
ALTER TABLE `familia`
  ADD CONSTRAINT `fk_familia_orden_taxonomico_id` FOREIGN KEY (`orden_taxonomico_id`) REFERENCES `orden_taxonomico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fichero`
--
ALTER TABLE `fichero`
  ADD CONSTRAINT `fk_fichero_cita_id` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD CONSTRAINT `fk_lugar_comarca_id` FOREIGN KEY (`comarca_id`) REFERENCES `comarca` (`id`),
  ADD CONSTRAINT `fk_lugar_cuadricula_utm_id` FOREIGN KEY (`cuadricula_utm_id`) REFERENCES `cuadricula_utm` (`id`),
  ADD CONSTRAINT `fk_lugar_municipio_id` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`),
  ADD CONSTRAINT `fk_lugar_observador_principal_id` FOREIGN KEY (`observador_principal_id`) REFERENCES `observador_principal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `fk_municipio_comarca_id` FOREIGN KEY (`comarca_id`) REFERENCES `comarca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `observador_secundario`
--
ALTER TABLE `observador_secundario`
  ADD CONSTRAINT `fk_observador_secundario_observador_principal_id` FOREIGN KEY (`observador_principal_id`) REFERENCES `observador_principal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_fichero_id` FOREIGN KEY (`fichero_id`) REFERENCES `fichero` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_observador_principal_id` FOREIGN KEY (`observador_principal_id`) REFERENCES `observador_principal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
