<?php

class stomatolog
{
    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select * from stomatolog where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();

    }

    public static function ucitajSve()
    {

        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select a.*, count(b.sifra) as ukupnotermina
        from stomatolog a
        left join termin b on a.sifra=b.stomatolog
        group by a.sifra,a.ime,a.prezime,
        a.specijalizacija,a.email;
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function spremiNovo($stomatolog)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        
        insert into stomatolog
        (ime,prezime,specijalizacija,email) values
        (:ime, :prezime, :specijalizacija, :email)
        
        ');
        $izraz->execute([
            'ime'=>$stomatolog->ime,
            'prezime'=>$stomatolog->prezime,
            'specijalizacija'=>$stomatolog->specijalizacija,
            'email'=>$stomatolog->email
        ]);

       $veza->commit(); 
    }

    public static function promjenaPostojeci($stomatolog)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
            update stomatolog set 
            ime=:ime,prezime=:prezime,
            specijalizacija=:specijalizacija,
            email=:email 
            where sifra=:sifra
       ');
       $izraz->execute((array)$stomatolog);

    }

    public static function obrisiPostojeci($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        delete from stomatolog where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
    }
}