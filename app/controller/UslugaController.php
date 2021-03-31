<?php

class UslugaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR 
                        . 'usluga' 
                        . DIRECTORY_SEPARATOR;

    private $entitet = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',
        [
            'entiteti'=> Usluga::ucitajSve()
        ]);
    }

    public function novo()
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
           {
               $this->noviEntitet();
               return;
           }
                
            
    }

    private function noviEntitet()
    {
        $this->entitet = new stdClass();
        $this->entitet->vrsta='';
        $this->entitet->proizvod='';
        $this->entitet->opis='';
        $this->entitet->cijena='';
        $this->entitet='Unesite tražene podatke';
        $this-> novoView();
        return;
    }
    

    private function novaUsluga()
    {
        $this->usluga = new stdClass();
        $this->usluga->vrsta='';
        $this->usluga->proizvod='';
        $this->usluga->opis='';
        $this->usluga->cijena='';
        $this->poruka='Unesite tražene podatke';
        $this-> novoView();
        return;
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',
        [
            'usluga'=>$this->usluga,
            'poruka'=>$this->poruka
        ]);
    
    }

}