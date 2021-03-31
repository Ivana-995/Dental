#c:\xampp\mysql\bin\mysql -uedunova -pedunova < D:\pp22\polaznik34.edunova.hr\dental.sql
drop database if exists dental;
create database dental character set utf8mb4
collate utf8mb4_croatian_ci;
use dental;

alter database ereb_dental default character set utf8mb4;

create table stomatolog(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
specijalizacija int not null,
email varchar(50) not null
);

create table specijalizacija(
sifra int not null primary key auto_increment,
vrsta varchar(40) not null
);

create table usluga(
sifra int not null primary key auto_increment,
vrsta int not null,
proizvod varchar(60),
opis text,
cijena int not null
);

create table termin(
sifra int not null primary key auto_increment,
datum datetime,
usluga int not null,
pacijent int not null
);


create table pacijent(
sifra int not null primary key auto_increment,
ime varchar(50),
prezime varchar(50),
email varchar(50)
);

create table operater(
sifra int not null primary key auto_increment,
email varchar(50) not null,
lozinka varchar(65) not null,
ime varchar(50) not null,
prezime varchar(50) not null,
uloga varchar(10) not null 
);

alter table stomatolog add foreign key (specijalizacija) references specijalizacija(sifra);
alter table usluga add foreign key (vrsta) references specijalizacija(sifra);
alter table termin add foreign key (usluga) references usluga(sifra);
alter table termin add foreign key (pacijent) references pacijent(sifra);
