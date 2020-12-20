CREATE TABLE `estatus_esp` (
                          `id` int(4) NOT NULL COMMENT 'Identificador único de la tabla',
                          `codigo` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de estatus',
                          `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción del estatus',
                          `rareza` tinyint(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Taxones cuyas citas son sometidas a homologación por el Comité de Rarezas de SEO/BirdLife.',
                          `exotica` tinyint(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Especies exóticas, introducidas deliberada o accidentalmente por el hombre, que no presentan poblaciones establecidas.',
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `idx_rareza_codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Estatus nacional';

INSERT INTO `estatus_esp` (`id`, `codigo`, `descripcion`, `rareza`, `exotica`) VALUES
(0, 'res', 'Residente', 0, 0),
(1, 'est', 'Estival', 0, 0),
(2, 'inv', 'Invernante', 0, 0),
(3, 'pas', 'De Paso', 0, 0),
(4, '?', 'Con estatus desconocido', 0, 0),
(5, 'R1', 'Especies o subespecies que, a 31 de diciembre de 2018, cuentan con entre 1 y 12 citas homologadas', 1, 0),
(6, 'R2', 'Especies con más de 12 citas homologadas. Los taxones de nueva inclusión en la lista de rarezas por causa de una disminución de sus efectivos en los últimos años, se califican también como R2, aunque tengan menos de 12 registros homologados', 1, 0),
(7, 'Cat E1', 'Con poblaciones que se reproducen regularmente y que se consideran próximas a establecerse', 0, 1),
(8, 'Cat E2', 'Especies de las que se ha comprobado su reproducción de forma ocasional o irregular, pero no hay indicios de que se encuentren en proceso de establecimiento', 0, 1),
(9, 'Cat E3', 'Especies observadas solo de forma ocasional, sin haberse constatado su reproducción', 0, 1);







