<?php

class UslugaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR 
                        . 'usluga' 
                        . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',
        [
            'usluge'=> Usluga::ucitajSve()
        ]);
    }

    public function novo()
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $usluga = new stdClass();
            $usluga->naziv='';
            $usluga->vrsta='ddd';
            $usluga->cijena=1000;
            $this->novoView($usluga,'Popunite sva polja');
            return;
        }

        $usluga = (object) $_POST;   
        
        if(strlen(trim($usluga->naziv))===0)
        { 
             $this->novoView($usluga,'Naziv obavezno');
             return;
   

        }

        if(strlen(trim($usluga->naziv))>50)
        { 
             $this->novoView($usluga,'Naziv ne može imati više od 50 znakova');
            return;
        }

        if(strlen(trim($usluga->vrsta))===0)
        { 
             $this->novoView($usluga,'Vrsta obavezno');
             return;
   

        }

        if(strlen(trim($usluga->vrsta))>50)
        { 
             $this->novoView($usluga,'Vrsta ne može imati više od 50 znakova');
             return;
        }

        $usluga->cijena=str_replace(',','.',$usluga->cijena);
        if(!is_numeric($usluga->cijena)
        || ((float)$usluga->cijena)<=0)
        {
            $this->novoView($usluga,'Cijena mora biti pozitivan broj ');
            return;
        }

        Usluga::dodajNovi($usluga);
        $this->index();
    }

    private function novoView($usluga, $poruka)
    {
        $this->view->render($this->viewDir . 'novo',
        [
            'usluga'=>$usluga,
            'poruka'=>$poruka
        ]);
        return;
    }
}
