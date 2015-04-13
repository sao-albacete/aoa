ALTER TABLE `%prefix%usuario`
DROP FOREIGN KEY `fk_usuario_observador_principal_id`;
ALTER TABLE `%prefix%usuario`
CHANGE COLUMN `observador_principal_id` `observador_principal_id` INT(11) NOT NULL ;
ALTER TABLE `%prefix%usuario`
ADD CONSTRAINT `fk_usuario_observador_principal_id`
FOREIGN KEY (`observador_principal_id`)
REFERENCES `%prefix%observador_principal` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
