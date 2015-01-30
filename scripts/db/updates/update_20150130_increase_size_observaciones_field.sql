ALTER TABLE `anuario_bbdd`.`%prefix%cita`
CHANGE COLUMN `observaciones` `observaciones` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL COMMENT 'Observaciones sobre la cita' ;

ALTER TABLE `anuario_bbdd`.`%prefix%cita_historico`
CHANGE COLUMN `observaciones` `observaciones` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL COMMENT 'Observaciones sobre la cita' ;