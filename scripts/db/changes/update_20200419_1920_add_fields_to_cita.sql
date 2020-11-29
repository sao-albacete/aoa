-- Cita
alter table `%prefix%_cita`
    add `dormidero` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado en un dormidero' AFTER `indComportamiento`;
alter table `%prefix%_cita`
    add `colonia_de_cria` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado en una colonia de cría' AFTER `indComportamiento`;
alter table `%prefix%_cita`
    add `migracion_activa` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado durante el periodo de migración activa de la especie' AFTER `indComportamiento`;
alter table `%prefix%_cita`
    add `sedimentado` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos sedimentados' AFTER `indComportamiento`;
alter table `%prefix%_cita`
    add `electrocutado` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido electrocución' AFTER `indComportamiento`;
alter table `%prefix%_cita`
    add `atropellado` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido un atropello' AFTER `indComportamiento`;

alter table `%prefix%_cita`
    add `cantidad_exacta` boolean DEFAULT false COMMENT 'Indica si el conteo de invividuos ha sido exacto' AFTER `cantidad`;
alter table `%prefix%_cita`
    add `cantidad_aproximada` boolean DEFAULT false COMMENT 'Indica si el conteo de individuos ha sido aproximado' AFTER `cantidad`;
alter table `%prefix%_cita`
    add `cantidad_precisa` boolean DEFAULT false COMMENT 'Indica si el conteo de individuos ha sido preciso pero no exacto' AFTER `cantidad`;
alter table `%prefix%_cita`
    add `cantidad_estimada` boolean DEFAULT false COMMENT 'Indica si el conteo de invididuos ha sido por estimación' AFTER `cantidad`;

-- Cita histórico
alter table `%prefix%_cita_historico`
    add `dormidero` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado en un dormidero' AFTER `indComportamiento`;
alter table `%prefix%_cita_historico`
    add `colonia_de_cria` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado en una colonia de cría' AFTER `indComportamiento`;
alter table `%prefix%_cita_historico`
    add `migracion_activa` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado durante el periodo de migración activa de la especie' AFTER `indComportamiento`;
alter table `%prefix%_cita_historico`
    add `sedimentado` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos sedimentados' AFTER `indComportamiento`;
alter table `%prefix%_cita_historico`
    add `electrocutado` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido electrocución' AFTER `indComportamiento`;
alter table `%prefix%_cita_historico`
    add `atropellado` boolean DEFAULT false COMMENT 'Indica si la observación se ha realizado sobre un individuo o individuos que han sufrido un atropello' AFTER `indComportamiento`;

alter table `%prefix%_cita_historico`
    add `cantidad_exacta` boolean DEFAULT false COMMENT 'Indica si el conteo de invividuos ha sido exacto' AFTER `cantidad`;
alter table `%prefix%_cita_historico`
    add `cantidad_aproximada` boolean DEFAULT false COMMENT 'Indica si el conteo de individuos ha sido aproximado' AFTER `cantidad`;
alter table `%prefix%_cita_historico`
    add `cantidad_precisa` boolean DEFAULT false COMMENT 'Indica si el conteo de individuos ha sido preciso pero no exacto' AFTER `cantidad`;
alter table `%prefix%_cita_historico`
    add `cantidad_estimada` boolean DEFAULT false COMMENT 'Indica si el conteo de invididuos ha sido por estimación' AFTER `cantidad`;
