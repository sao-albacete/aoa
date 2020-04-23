-- Cita
alter table `cowctkq_cita_cita`
	add `dormidero` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado en un dormidero';
alter table `cowctkq_cita_cita`
	add `colonia_de_cria` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado en una colonia de cría';
alter table `cowctkq_cita_cita`
	add `migracion_activa` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado durante el periodo de migración activa de la especie';
alter table `cowctkq_cita_cita`
	add `sedimentado` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos sedimentados';
alter table `cowctkq_cita_cita`
	add `electrocutado` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido electrocución';
alter table `cowctkq_cita_cita`
	add `atropellado` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido un atropello';

alter table `cowctkq_cita_cita`
	add `cantidad_exacta` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de invividuos ha sido exacto';
alter table `cowctkq_cita_cita`
	add `cantidad_aproximada` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de individuos ha sido aproximado';
alter table `cowctkq_cita_cita`
	add `cantidad_precisa` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de individuos ha sido preciso pero no exacto';
alter table `cowctkq_cita_cita`
	add `cantidad_estimada` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de invididuos ha sido por estimación';

-- Cita histórico
alter table `cowctkq_cita_cita_historico`
	add `dormidero` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado en un dormidero';
alter table `cowctkq_cita_cita_historico`
	add `colonia_de_cria` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado en una colonia de cría';
alter table `cowctkq_cita_cita_historico`
	add `migracion_activa` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado durante el periodo de migración activa de la especie';
alter table `cowctkq_cita_cita_historico`
	add `sedimentado` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos sedimentados';
alter table `cowctkq_cita_cita_historico`
	add `electrocutado` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido electrocución';
alter table `cowctkq_cita_cita_historico`
	add `atropellado` boolean DEFAULT false AFTER `indComportamiento` COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido un atropello';

alter table `cowctkq_cita_cita_historico`
	add `cantidad_exacta` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de invividuos ha sido exacto';
alter table `cowctkq_cita_cita_historico`
	add `cantidad_aproximada` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de individuos ha sido aproximado';
alter table `cowctkq_cita_cita_historico`
	add `cantidad_precisa` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de individuos ha sido preciso pero no exacto';
alter table `cowctkq_cita_cita_historico`
	add `cantidad_estimada` boolean DEFAULT false AFTER `cantidad` COMMENT 'Indica si el conteo de invididuos ha sido por estimación';
