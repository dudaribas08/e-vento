drop database if exists checkin;
create database if not exists checkin;
use checkin;

create table Participante (
id_participante integer not null auto_increment primary key,
nome_participante varchar (200),
email varchar (200),
cpf varchar(11) unique,
origem varchar(200)
);
create table Usuario (
id_usuario integer not null auto_increment primary key,
login varchar (200),
senha varchar (200)
);

create table Atividade(
id_atividade integer not null auto_increment primary key,
nome_atividade varchar (200),
local_evento varchar(200),
data_atividade timestamp,
descricao varchar(360)
);

create table Presenca(
id_atividade integer not null unique references atividade,
id_participante integer not null unique references participante
);

insert into Usuario values (null , 'larissa' , '123');

create user if not exists 'checkin'@'localhost' identified by '123';
grant all privileges on checkin.* to 'checkin'@'localhost';
