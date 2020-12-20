CREATE TABLE `rareza` (
                          `id` int(4) NOT NULL COMMENT 'Identificador único de la tabla',
                          `codigo` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de rareza',
                          `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del código de rareza',
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `idx_rareza_codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Información de códigos de rarezas seleccionables';

INSERT INTO `rareza` (`id`, `codigo`, `descripcion`) VALUES
(0, '', 'Ave no considerada rareza'),
(1, 'AB', 'Ave considerda rareza en Albacete'),
(2, 'E', 'Ave considerda rareza en España'),
(3, '2013', 'Ave considerda rareza en España hasta el año 2013'),
(4, '2015', 'Ave considerda rareza en España hasta el año 2015'),
(5, '2016', 'Ave considerda rareza en España hasta el año 2016');







