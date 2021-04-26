<?php

class Ordinacija
{
    public static function brojStomatologaPoOrdinacijama()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select a.grad as name, count(b.ordinacija) as y
        from ordinacija a
        left join stomatolog b
        on a.sifra=b.ordinacija 
        group by a.grad;
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();

    }

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select * from ordinacija where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function ucitajSve($stranica,$uvjet)
    {
        $rps=App::config('rezultataPoStranici'); 
        $od = $stranica * $rps - $rps;

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.*, count(b.ordinacija) as ukupnostomatologa 
            from ordinacija a
            left join stomatolog b on a.sifra=b.ordinacija
            where concat(a.grad, \'\', a.adresa) like :uvjet
            group by a.sifra, a.grad, a.adresa, 
            a.kontakt limit :od, :rps
        
        ');
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->bindValue('od',$od, PDO::PARAM_INT);
        $izraz->bindValue('rps',$rps, PDO::PARAM_INT);
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function ucitajZaStomatologa()
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

    public static function ukupnoOrdinacija($uvjet)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select count(b.ordinacija) from ordinacija a 
        inner join stomatolog b on a.sifra=b.ordinacija 
        where concat(a.grad, \' \', a.adresa) like :uvjet

        ');
       
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();
        return $izraz->fetchColumn();

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