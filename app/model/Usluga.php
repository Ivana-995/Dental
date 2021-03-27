<?php 

class Usluga
{
    public static function ucitajSve()
    {
        $veza= DB::getInstanca();
        $izraz=$veza->prepare('
        
        select * from usluga
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($usluga)
    {
        $veza= DB::getInstanca();
        $izraz=$veza->prepare('
        
        insert into usluga (naziv,vrsta,cijena)
        values (:naziv,:vrsta,:cijena)
        
        ');
        $izraz->execute((array)$usluga);
        return $izraz->fetchAll();
    }
}