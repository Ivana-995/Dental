c:\xampp\mysql\bin\mysql -uedunova -pedunova < D:\pp22\polaznik34.edunova.hr\dental.sql
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
kontakt int(15) not null,
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
kontakt int(15),
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
/*
insert into usluga (naziv,cijena,vrsta) values
('Implantologija',5500,'Implantant Nobel'),
('Implantologija',1800,'Superstruktura Nobel'),
('Protetika',1800,'Keramička kruna na wirron metalu'),
('Protetika',3700,'Totalna proteza(akrilat)'),
('Ortodoncija',200,'Specijalistički ortodontski pregled'),
('Ortodoncija',9000,'Bijele bravice - Ortodonski aparat - po čeljusti');
*/

insert into operater (sifra,email,lozinka,ime,prezime,uloga)values
(null,'ilalic110@gmail.com',
'$2y$10$UKqqzzvf3rhylzcXjsIAW.u9xDMmq1gV6cMHy0yYanbs1bMV/BFG6',
'Ivana', 'Lalić', 'operater'), 
(null,'bluetooth@gmail.com',
'$2y$10$L1/Vyydt.F0YYDgBNQ.uIu8Gk5ZyDkU6xBzgrb9JsDfKXEs5a/JQ.',
'Marko', 'Marulić', 'admin');


alter table stomatolog add foreign key (specijalizacija) references specijalizacija(sifra);
alter table usluga add foreign key (vrsta) references specijalizacija(sifra);
alter table termin add foreign key (usluga) references usluga(sifra);
alter table termin add foreign key (pacijent) references pacijent(sifra);