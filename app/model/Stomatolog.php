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

    public static function spremiNovo($entitet)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        
        insert into stomatolog
        (ime,prezime,specijalizacija,email) values
        (:ime, :prezime, :specijalizacija, :email)
        
        ');
        $izraz->execute([
            'ime'=>$entitet->ime,
            'prezime'=>$entitet->prezime,
            'specijalizacija'=>$entitet->specijalizacija,
            'email'=>$entitet->email
        ]);

       $veza->commit(); 
    }
}