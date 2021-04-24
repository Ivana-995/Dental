<?php

class Pacijent
{
    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select * from pacijent where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select a.*, count(b.pacijent) as ukupnotermina
            from pacijent a
            left join termin b on a.sifra=b.pacijent
            group by a.sifra,a.ime,a.prezime,a.email ;
            
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function spremiNovo($entitet)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        
        insert into pacijent 
        (ime, prezime, email) values
        (:ime, :prezime, :email)
        
        ');
        $izraz->execute([
            'ime'=>$entitet->ime,
            'prezime'=>$entitet->prezime,
            'email'=>$entitet->email,
        ]);

        $veza->commit();
    }

    public static function promjenaPostojeci($entitet)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        
        update pacijent set 
        ime=:ime,prezime=:prezime,email=:email 
        where sifra=:sifra
        
        ');
        $izraz->execute((array)$entitet);
    }

    public static function obrisiPostojeci($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        delete from pacijent where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
    }
}