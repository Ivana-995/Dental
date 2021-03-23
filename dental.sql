c:\xampp\mysql\bin\mysql -uedunova -pedunova < D:\pp22\polaznik34.edunova.hr\dental.sql
drop database if exists dental;
create database dental character set utf8mb4
collate utf8mb4_croatian_ci;
use dental;

create table stomatolog(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
kontakt int(15) not null,
email varchar(50) not null
);

create table pacijent(
sifra int not null primary key auto_increment,
ime varchar(50),
prezime varchar(50),
kontakt int(15),
email varchar(50)
);

create table usluga(
sifra int not null primary key auto_increment,
ime varchar (40) not null,
cijena decimal (12,2),
opis text
);

create table posjeta(
sifra int not null primary key auto_increment,
stomatolog int not null,
pacijent int not null
);

create table stavka(
sifra int not null,
posjeta int not null,
usluga int not null
);

create table operater(
sifra int not null primary key auto_increment,
email varchar(50) not null,
lozinka varchar(65) not null,
ime varchar(50) not null,
prezime varchar(50) not null,
uloga varchar(10) not null 
);

insert into operater values(null,'ilalic110@gmail.com',
'$2y$10$UKqqzzvf3rhylzcXjsIAW.u9xDMmq1gV6cMHy0yYanbs1bMV/BFG6',
'Ivana', 'Lalić', 'operater'); 
insert into operater values(null,'bluetooth@gmail.com',
'$2y$10$L1/Vyydt.F0YYDgBNQ.uIu8Gk5ZyDkU6xBzgrb9JsDfKXEs5a/JQ.',
'Marko', 'Marulić', 'admin');

alter table posjeta add foreign key (stomatolog) references stomatolog(sifra);
alter table posjeta add foreign key (pacijent) references pacijent(sifra);
alter table stavka add foreign key (usluga) references usluga(sifra);
alter table stavka add foreign key (posjeta) references posjeta(sifra);