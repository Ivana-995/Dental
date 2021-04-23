#c:\xampp\mysql\bin\mysql -uedunova -pedunova < D:\pp22\polaznik34.edunova.hr\dental.sql
drop database if exists dental;
create database dental character set utf8mb4
collate utf8mb4_croatian_ci;
use dental;

#alter database ereb_dental default character set utf8mb4;

create table operater(
sifra int not null primary key auto_increment,
email varchar(50) not null,
lozinka varchar(65) not null,
ime varchar(50) not null,
prezime varchar(50) not null,
uloga varchar(10) not null 
);

create table ordinacija(
sifra int not null primary key auto_increment,
grad varchar(70) not null,
adresa varchar(150)not null,
kontakt varchar(20)not null 
);

create table stomatolog(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
specijalizacija varchar(70)not null,
email varchar(50),
ordinacija int not null
);

create table pacijent(
sifra int not null primary key auto_increment,
ime varchar(50),
prezime varchar(50),
email varchar(50)
);

create table termin(
pacijent int not null,
stomatolog int not null
);

alter table stomatolog add foreign key (ordinacija) references ordinacija(sifra);
alter table termin add foreign key (stomatolog) references stomatolog(sifra);
alter table termin add foreign key (pacijent) references pacijent(sifra);


