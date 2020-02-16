-- `cita`
ALTER TABLE `%prefix%cita`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha de alta de la cita' ;


-- `cita_historico`
ALTER TABLE `%prefix%cita_historico`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha de alta de la cita' ;


-- `fichero`
ALTER TABLE `%prefix%fichero`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha en la que se dio de alta el fichero' ;


-- `tokens`
ALTER TABLE `%prefix%tokens`
CHANGE COLUMN `created` `created` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `modified` `modified` DATETIME NULL DEFAULT NULL ;


ALTER TABLE `%prefix%cita`
ADD COLUMN `fechaCreacion` DATETIME NOT NULL AFTER `indFoto`;
