-- `cita`
ALTER TABLE `cowctkq_cita`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha de alta de la cita' ;


-- `cita_historico`
ALTER TABLE `cowctkq_cita_historico`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha de alta de la cita' ;


-- `fichero`
ALTER TABLE `cowctkq_fichero`
CHANGE COLUMN `fechaAlta` `fechaAlta` DATETIME NOT NULL COMMENT 'Fecha en la que se dio de alta el fichero' ;


-- `tokens`
ALTER TABLE `cowctkq_tokens`
CHANGE COLUMN `created` `created` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `modified` `modified` DATETIME NULL DEFAULT NULL ;
