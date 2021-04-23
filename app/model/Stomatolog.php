<?php

class stomatolog
{
    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select a.sifra, a.ime, a.prezime, a.specijalizacija,
            a.email, b.grad, b.adresa, b.kontakt
            from stomatolog a 
            inner join ordinacija b on a.ordinacija=b.sifra
            where a.sifra=:sifra
        
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
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        
            insert into ordinacija
            (grad, adresa, kontakt) values
            (:grad, :adresa, :kontakt)

        ');
        $izraz->execute([
            'grad'=>$entitet->grad,
            'adresa'=>$entitet->adresa,
            'kontakt'=>$entitet->kontakt

        ]);
        $zadnjaSifra=$veza->lastInsertId();
        $izraz=$veza->prepare('
        
            insert into stomatolog
            (ime,prezime,specijalizacija,email, ordinacija) values
            (:ime, :prezime, :specijalizacija, :email, :ordinacija)
        
        ');
        $izraz->execute([
            'ime'=>$entitet->ime,
            'prezime'=>$entitet->prezime,
            'specijalizacija'=>$entitet->specijalizacija,
            'email'=>$entitet->email,
            'ordinacija'=>$zadnjaSifra
        ]);

       
        $veza->commit();
    }

    public static function promjeniPostojeci($entitet)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('

            select ordinacija from stomatolog 
            where sifra=:sifra
       
        ');
       $izraz->execute(['sifra'=>$entitet->sifra]);
       $sifraOrdinacija=$izraz->fetchColumn();

       $izraz=$veza->prepare('
       
            update ordinacija 
            set grad=:grad, adresa=:adresa, kontakt=:kontakt
            where sifra=:sifra
       
       ');
        $izraz->execute([
            'grad'=>$entitet->grad,
            'adresa'=>$entitet->adresa,
            'kontakt'=>$entitet->kontakt,
            'sifra'=>$sifraOrdinacija
        ]);

        $izraz=$veza->prepare('
        
            update stomatolog
            set ime=:ime, prezime=:prezime, 
            specijalizacija=:specijalizacija,
            email=:email
            where sifra=:sifra
        
        ');
        $izraz->execute([

            'ime'=>$entitet->ime,
            'prezime'=>$entitet->prezime,
            'specijalizacija'=>$entitet->specijalizacija,
            'email'=>$entitet->email,
            'sifra'=>$entitet->sifra
            
        ]);

        $veza->commit();

    }

    public static function obrisiPostojeci($sifra)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        
        select ordinacija from stomatolog where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        $sifraOrdinacija=$izraz->fetchColumn();

        $izraz=$veza->prepare('
        
        delete from stomatolog where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);

        $izraz=$veza->prepare('
        
        delete from ordinacija where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifraOrdinacija]);

        $veza->commit();
    }
}