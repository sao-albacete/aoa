
-- Lugar volviendo a integer
UPDATE cowctkq_lugar SET  lng = NULL WHERE true;
ALTER TABLE `%prefix%_lugar`
CHANGE COLUMN `lng` `coordenadaX` INT  COMMENT 'Coordenada X UTM' ;

UPDATE cowctkq_lugar SET  lat = NULL WHERE true;
ALTER TABLE `%prefix%_lugar`
CHANGE COLUMN `lat` `coordenadaY` INT COMMENT 'Coordenada Y UTM' ;
