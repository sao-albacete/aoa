-- `cita`
ALTER TABLE `%prefix%_cita`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha de alta de la cita' ;


-- `cita_historico`
ALTER TABLE `%prefix%_cita_historico`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha de alta de la cita' ;


-- `fichero`
ALTER TABLE `%prefix%_fichero`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha en la que se dio de alta el fichero' ;


-- `tokens`
ALTER TABLE `%prefix%_tokens`
CHANGE COLUMN `created` `created` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `modified` `modified` DATETIME NULL DEFAULT NULL ;
