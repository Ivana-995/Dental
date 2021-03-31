<?php 

class Usluga
{
    public static function ucitajSve()
    {
        $veza= DB::getInstanca();
        $izraz=$veza->prepare('
        
        select a.sifra, b.vrsta, a.proizvod, a.opis, a.cijena
        from usluga a
        inner join specijalizacija b on a.sifra =b.sifra
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }



    public static function dodajNovo($usluga)
    {
        $veza= DB::getInstanca();
        $izraz=$veza->prepare('
        
        insert into usluga (vrsta,proizvod,opis,cijena)
        values (:vrsta,:proizvod,:opis,:cijena)
        
        ');
        $izraz->execute((array)$usluga);
        return $izraz->fetchAll();
    }
}