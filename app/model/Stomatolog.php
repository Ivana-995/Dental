<?php

class stomatolog
{
    public static function ucitajSve()
    {

        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select * from stomatolog 
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    
}