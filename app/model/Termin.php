<?php

class Termin
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        

        select concat(b.ime, \' \', b.prezime) as stomatolog,
        concat(d.ime, \' \', d.prezime) as pacijent
        from termin a 
        inner join stomatolog b on a.stomatolog=b.sifra
        right join ordinacija c on b.ordinacija=c.sifra
        inner join pacijent d on a.pacijent=d.sifra
      

        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovo($entitet)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            insert into termin (pacijent,stomatolog)
            values (:pacijent, :stomatolog)
        
        ');
        $izraz->execute((array)$entitet);
        return $veza->lastInsertId();
    }
}