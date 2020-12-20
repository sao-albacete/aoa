CREATE TABLE `categoria_especie` (
                          `id` int(4) NOT NULL COMMENT 'Identificador único de la tabla',
                          `codigo` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de categoría',
                          `descripcion` varchar(512) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descripción de la categoría',
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `idx_rareza_codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='El Anuario Ornitológico de Abacete sigue la metodología utilizada en la lista de aves de España 2019. https://www.seo.org/wp-content/uploads/2019/05/ListaAvesdeEspa%C3%B1a2019.pdf';

INSERT INTO `categoria_especie` (`id`, `codigo`, `descripcion`) VALUES
(0, 'A', 'Especies que han sido registradas en estado aparentemente natural al menos una vez a partir del 1 de enero de 1950'),
(1, 'B', 'Especies que han sido registradas, al menos una vez en estado aparentemente natural, desde el 1 de enero de 1800 hasta el 31 de diciembre de 1949, pero no después de esta última fecha.'),
(2, 'C', 'Especies exóticas que, habiendo sido introducidas deliberada o accidentalmente por el hombre, han establecido poblaciones reproductoras regulares que se mantienen de forma autosuficiente, independiente y estable, o bien incrementan su demografía manifestando características invasoras. Se incluyen también aquellas especies exóticas que, sin reproducirse regularmente en nuestro país, están establecidas en países vecinos desde donde llegan ejemplares de forma regular.'),
(3, 'C*', 'Especies exóticas que llegan procedentes de poblaciones no naturales establecidas en otros países o en otro de los territorios.'),
(4, 'D', 'Especies que no es posible asignar con plena seguridad a las categorías A o B por existir la razonable posibilidad de que todos sus registros provengan de aves de origen no natural.'),
(5, 'E1', 'Especies exóticas, introducidas deliberada o accidentalmente por el hombre, que no presentan poblaciones establecidas pero con poblaciones que se reproducen regularmente y que se consideran próximas a establecerse.'),
(6, '(i)', 'Algunas poblaciones o un porción significativa de los individuos de especies consideradas nativas proceden  de introducciones realizadas deliberada o accidntalmente por el hombre. ');
