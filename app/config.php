<?php

$dev=$_SERVER['REMOTE_ADDR']==='127.0.0.1' ? true : false;
if($dev)
    {
        $baza=[
            'server'=>'localhost',
            'baza'=>'dental',
            'korisnik'=>'edunova',
            'lozinka'=>'edunova'
        
        ];
    }else{
                $baza=[
                'server'=>'localhost',
                'baza'=>'ereb_dental',
                'korisnik'=>'ereb_ivana',
                'lozinka'=>'PlaviZub?777'
            ];
        }
    return [
        'url'=>'http://polaznik34.edunova.hr/',
        'nazivApp'=>'DENTAL',
        'baza'=>$baza,
        'rezultataPoStranici'=>4
    ];