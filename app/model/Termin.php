<?php

class Termin
{
    public static function ucitajSve()
    {
        $veza= DB::getInstanca();
        $izraz=$veza->prepare('
        
        select b.ime, b.prezime, a.datum, c.specijalizacija as usluga,
        c.prezime as stomatolog
        from termin a 
        inner join pacijent b on a.pacijent=b.sifra 
        inner join stomatolog c on a.stomatolog =c.sifra 
        group by b.ime, b.prezime, a.datum, c.specijalizacija, c.prezime 
      
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }
}