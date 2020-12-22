ALTER TABLE `cowctkq_familia` DROP COLUMN `posicion`;

DELETE FROM `cowctkq_familia` WHERE `id` = 90;
DELETE FROM `cowctkq_familia` WHERE `id` = 91;
DELETE FROM `cowctkq_familia` WHERE `id` = 92;
DELETE FROM `cowctkq_familia` WHERE `id` = 93;
DELETE FROM `cowctkq_familia` WHERE `id` = 94;
DELETE FROM `cowctkq_familia` WHERE `id` = 95;
DELETE FROM `cowctkq_familia` WHERE `id` = 96;
DELETE FROM `cowctkq_familia` WHERE `id` = 97;
DELETE FROM `cowctkq_familia` WHERE `id` = 98;
DELETE FROM `cowctkq_familia` WHERE `id` = 99;
DELETE FROM `cowctkq_familia` WHERE `id` = 100;
DELETE FROM `cowctkq_familia` WHERE `id` = 101;

UPDATE `cowctkq_familia` SET `nombre` = 'Otidae' WHERE `nombre` = 'Otididae';
UPDATE `cowctkq_familia` SET `nombre` = 'Pteroclididae'WHERE `nombre` = 'Pteroclidae';
