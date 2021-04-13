<?php

class Pacijent
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select a.*, count(b.sifra) as ukupnotermina
        from pacijent a
        left join termin b on a.sifra=b.pacijent
        group by a.sifra,a.ime,a.prezime,a.email ;
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }
}