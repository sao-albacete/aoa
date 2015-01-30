
ALTER TABLE `anuario_bbdd`.`%prefix%cita`
CHANGE COLUMN `observaciones` `observaciones` VARCHAR(256) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL COMMENT 'Observaciones sobre la cita' ;

ALTER TABLE `anuario_bbdd`.`%prefix%cita_historico`
CHANGE COLUMN `observaciones` `observaciones` VARCHAR(256) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL COMMENT 'Observaciones sobre la cita' ;