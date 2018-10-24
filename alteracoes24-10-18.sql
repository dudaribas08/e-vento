use checkin;

alter table Presenca add constraint UC_presenca UNIQUE (id_atividade,id_participante);
