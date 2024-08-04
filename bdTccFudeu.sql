create database TCCFudeu;

USE TCCFudeu;

create table usuario(
IdUsuario int auto_increment not null primary key,
EmailIsntitucional varchar(100) not null unique,
nome varchar(50) not null,
senha varchar(50) not null,
IsAdm bool not null
);

create table Curso(
IdCurso int auto_increment not null primary key,
nome varchar(20) not null
);

create table compTec(
IdcompTec int auto_increment not null primary key,
IdCurso int not null,
nome varchar(30) not null
);

alter table compTec add constraint fkCompTec_Curso
foreign key(idCurso) references Curso(IdCurso);


create table serie(
IdSerie int auto_increment not null primary key,
ano int(1) not null
);

create table compBnc(
IdcompBnc int auto_increment not null primary key,
nome varchar(20) not null
);

create table compBncSerie(
IdcompBncSerie int auto_increment not null primary key,
IdcompBnc int not null,
IdSerie int not null
);

alter table compBncSerie add constraint FkcompBncSerie_Serie
foreign key(IdSerie) references serie(IdSerie);

alter table compBncSerie add constraint FkcompBncSerie_compBnc
foreign key(IdcompBnc) references compBnc(IdcompBnc);

Create table arquivo(
IdArquivo int auto_increment not null primary key,
nomeArquivo varchar(40) not null
);

create table Pergunta(
Idpergunta int auto_increment not null primary key,
IdUsuario int not null,
IdcompTec int not null,
IdArquivo int,
IdcompBncSerie int not null,
conteudo VARCHAR(500) not null,
dataHora datetime not null
);

alter table Pergunta add constraint FkPergunta_Arquivo
foreign key(IdArquivo) references Arquivo(IdArquivo);

alter table Pergunta add constraint FkPergunta_Usuario
foreign key(IdUsuario) references Usuario(IdUsuario);

alter table Pergunta add constraint FkPergunta_CompTec
foreign key(IdcompTec) references CompTec(IdcompTec);

alter table Pergunta add constraint FkPergunta_CompBncSerie
foreign key(IdcompBncSerie) references compBncSerie(IdcompBncSerie);

Create table Resposta(
IdResposta int auto_increment not null primary key,
IdUsuario int not null,
IdPergunta int not null,
IdArquivo int,
conteudo varchar(500) not null,
dataHora datetime not null
);

alter table Resposta add constraint FkResporta_Usuario
foreign key(IdUsuario) references Usuario(IdUsuario);

alter table Resposta add constraint FkResporta_Arquivo
foreign key(IdArquivo) references Arquivo(IdArquivo);

alter table Resposta add constraint FkResporta_Pergunta
foreign key(IdPergunta) references Pergunta(IdPergunta);









