set names utf8;

create table teste (
id int auto_increment primary key,
nome varchar(255) not null,
slug varchar(255) not null,
imagem varchar(255) not null,
descricao text,
tags text
) character set utf8;

create table resultado (
id int auto_increment primary key,
teste_id int not null,
titulo varchar(255) not null,
imagem varchar(255) not null,
descricao text,
template text
) character set utf8;

create table pessoa_resultado (
id char(40) primary key,
resultado_id int not null,
pessoa_id varchar(100) not null,
imagem varchar(255) not null
) character set utf8;

create table pessoa (
id varchar(100) not null,
token text not null
) character set utf8;

alter table resultado add foreign key (teste_id) references teste(id);
alter table pessoa_resultado add foreign key (resultado_id) references resultado(id);
alter table pessoa_resultado add foreign key (pessoa_id) references pessoa(id);