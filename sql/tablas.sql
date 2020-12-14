create database repaso;
-- create user usuexamen@'localhost' identified by "secret0";
grant all on repaso.* to usuexamen@'localhost';
use repaso;
create table usuarios(
    id int PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(40) unique not null,
    pass varchar(64) not null,
    mail varchar(300) unique not null
);
insert into usuarios(nombre, pass, mail) values("admin", sha2("passadmin", 256), "admin@correo.es");
insert into usuarios(nombre, pass, mail) values("usuario", sha2("passusu", 256), "usuario@mail.es");

