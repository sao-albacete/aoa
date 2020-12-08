alter table `%prefix%_cita` drop column `dormidero`;
alter table `%prefix%_cita` drop column `colonia_de_cria`;
alter table `%prefix%_cita` drop column `migracion_activa`;
alter table `%prefix%_cita` drop column `sedimentado`;
alter table `%prefix%_cita` drop column `electrocutado`;
alter table `%prefix%_cita` drop column `atropellado`;

alter table `%prefix%_cita` drop column `cantidad_exacta`;
alter table `%prefix%_cita` drop column `cantidad_aproximada`;
alter table `%prefix%_cita` drop column `cantidad_precisa`;
alter table `%prefix%_cita` drop column `cantidad_estimada`;

alter table `%prefix%_cita_historico` drop column `dormidero`;
alter table `%prefix%_cita_historico` drop column `colonia_de_cria`;
alter table `%prefix%_cita_historico` drop column `migracion_activa`;
alter table `%prefix%_cita_historico` drop column `sedimentado`;
alter table `%prefix%_cita_historico` drop column `electrocutado`;
alter table `%prefix%_cita_historico` drop column `atropellado`;

alter table `%prefix%_cita_historico` drop column `cantidad_exacta`;
alter table `%prefix%_cita_historico` drop column `cantidad_aproximada`;
alter table `%prefix%_cita_historico` drop column `cantidad_precisa`;
alter table `%prefix%_cita_historico` drop column `cantidad_estimada`;
