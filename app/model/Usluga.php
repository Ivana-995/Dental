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
}