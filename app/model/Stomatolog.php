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
        
            select a.sifra, a.ime, a.prezime, a.specijalizacija,
            a.email, b.grad as ordinacija,
            count(c.stomatolog) as ukupnotermina 
            from stomatolog a
            inner join ordinacija b on a.ordinacija=b.sifra
            left join termin c on a.sifra=c.stomatolog
            group by a.sifra, a.ime, a.prezime,
            a.specijalizacija, a.email, b.grad, b.adresa, b.kontakt
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function spremiNovo($entitet)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            insert into stomatolog
            (ime,prezime,specijalizacija,email,ordinacija) values
            (:ime, :prezime, :specijalizacija, :email, :ordinacija)

        ');
        $izraz->execute((array)$entitet);
    }

    public static function promjeniPostojeci($entitet)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            update stomatolog set
            ime=:ime, prezime=:prezime, 
            specijalizacija=:specijalizacija,
            email=:email, ordinacija=:ordinacija
            where sifra=:sifra
        ');
       $izraz->execute((array)$entitet);
       
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