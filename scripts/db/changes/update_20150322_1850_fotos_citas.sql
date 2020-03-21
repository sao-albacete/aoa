ALTER TABLE `%prefix%cita`
ADD COLUMN `indFoto` TINYINT(1) NOT NULL DEFAULT 0 AFTER `indPrivacidad`;

ALTER TABLE `%prefix%cita_historico`
ADD COLUMN `indFoto` TINYINT(1) NOT NULL DEFAULT 0 AFTER `indPrivacidad`;

UPDATE %prefix%cita SET indFoto = 1 WHERE id IN (SELECT cita_id FROM %prefix%fichero);