<?php

class Ordinacija
{
    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select * from ordinacija where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.*, count(b.ordinacija) as ukupnostomatologa 
            from ordinacija a
            left join stomatolog b on a.sifra=b.ordinacija
            group by a.sifra, a.grad, a.adresa, a.kontakt
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function spremiNovo($entitet)
    {
        $veza= DB::getInstanca();
        $izraz=$veza->prepare('
        
            insert into ordinacija
            (grad, adresa, kontakt) values
            (:grad, :adresa, :kontakt)
        
        ');
        $izraz->execute((array)$entitet);
    }

    public static function promjeniPostojeci($entitet)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            update ordinacija set
            grad=:grad, adresa=:adresa, kontakt=:kontakt
            where sifra=:sifra
        
        ');
        $izraz->execute((array)$entitet);
    }

    public static function obrisiPostojeci($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        delete from ordinacija where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
    }

    

}