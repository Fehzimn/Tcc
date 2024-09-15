create database TCC;

USE TCC;

create table usuario(
idUsuario int auto_increment not null primary key,
nome varchar(50) not null,
emailInstitucional varchar(100) not null unique,
senha varchar(50) not null,
isAdm bool not null
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
IdcompTec int null,
IdArquivo int null,
IdcompBncSerie int null,
titulo varchar(100) not null,
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

INSERT INTO serie(ano)
VALUES
(1),
(2),
(3);

INSERT INTO compBnc(nome)
VALUES
(''),
('');

select * from serie;

INSERT INTO Curso(nome)
VALUES
('Informática'),
('Administração'),
('Logística'),
('Marketing'),
('Logística Reversa');

select * from Curso;

INSERT INTO compTec(IdCurso,nome)
VALUES
(1,'Projeto Web'),
(1,'Interfaces Web I'),
(1,'Fundamentos da Informática'),
(1,'Arte Digital'),
(1,'Programação e Algoritimo'),
(1,'Nuvem'),
(1,'Dispositivos Móveis I'),
(1,'Sistemas Web I'),
(1,'Banco de Dados'),
(1,'Interfaces Web II'),
(1,'Acessibilidade Digital'),
(1,'Dispositivos Móveis II'),
(1,'Sistemas Web II'),
(1,'Segurança Digital'),
(1,'TCC');

INSERT INTO compTec(IdCurso,nome)
VALUES
(2,'Projeto Integrador'),
(2,'Legislação Empresarial'),
(2,'Des. Ações de Marketing'),
(2,'Plan. Rotinas Adminitrativas'),
(2,'Custos,Processos e operações'),
(2,'Projeto Integrador II'),
(2,'Planejamento de DP'),
(2,'A.I'),
(2,'Administração de RH'),
(2,'TCC'),
(2,'Estudos ADM. Pública'),
(2,'Processos Logísticos'),
(2,'Estudos de economia'),
(2,'Administração Financeira'),
(2,'Administração da produção'),
(2,'TIAL'),
(2,'DES. Modelos de negocios');

INSERT INTO compTec(IdCurso,nome)
VALUES
(3,'Marketing a Logística'),
(3,'Estudos de Logística'),
(3,'POAL'),
(3,'A.I'),
(3,'Processos de Espedição'),
(3,'Controle da Produção'),
(3,'Processo de materiais'),
(3,'Projeto Integrador'),
(3,'PLAN. Custos logísticos'),
(3,'Estudos da cadeia'),
(3,'Organização de tranportes'),
(3,'Organização de RH'),
(3,'Estudos da LOG. Internacional'),
(3,'Logística Reversa'),
(3,'TCC'),
(3,'TIAL'),
(3,'Saude e segurança do Trabalho');


INSERT INTO compTec(IdCurso,nome)
VALUES
(4,'Introdução ao Marketing'),
(4,'A.I'),
(4,'Projeto Integrador'),
(4,'Pesquisa de Mercado');

select * from usuario;

select * from pergunta;













