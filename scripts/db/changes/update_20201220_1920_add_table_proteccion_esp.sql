CREATE TABLE `proteccion_esp` (
                          `id` int(4) NOT NULL COMMENT 'Identificador único de la tabla',
                          `codigo` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de nivel de protección',
                          `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del nivel de protección',
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `idx_rareza_codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nivel de proteccion en España';

INSERT INTO `proteccion_esp` (`id`, `codigo`, `descripcion`) VALUES
(0, '1', 'En peligro de extinción'),
(1, '2', 'Vulnerable'),
(2, '3', 'No catalogada');







