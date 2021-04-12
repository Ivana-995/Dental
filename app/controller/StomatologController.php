<?php

class StomatologController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                      . DIRECTORY_SEPARATOR
                      . 'stomatolog'
                      . DIRECTORY_SEPARATOR;
    
    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',
        [
            'entiteti'=>Stomatolog::ucitajSve()
        ]);
    }

    public function novo()
    {
       if($_SERVER['REQUEST_METHOD']==='GET')
       {
           $this->noviEntitet();
           return;
       }
       $this->entitet = (object) $_POST;
       try
       {
           $this->kontrola();
           $this->kontrolaSpecijalizacija();
           Stomatolog::spremiNovo($this->entitet);
           $this->index();
       }
       catch (Exception $e)
       {
           $this->poruka=$e->getMessage();
           $this->novoView();
       }    
    }

    private function noviEntitet()
    {
        $this->entitet = new stdClass();
        $this->entitet->ime='';
        $this->entitet->prezime='';
        $this->entitet->specijalizacija='';
        $this->entitet->email='';
        $this->poruka='Unesite tražene podatke';
        $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }

    private function kontrola()
    {
        $this->kontrolaImePrezime();
        $this->kontrolaSpecijalizacija();
        $this->kontrolaEmail();
    }

    private function kontrolaImePrezime()
    {
        $this->kontrolaIme();
        $this->kontrolaPrezime();
    }
    
    private function kontrolaIme()
    {
        if(strlen(trim($this->entitet->ime))==0){
            throw new Exception('Unesite ime');
        }

        if(strlen(trim($this->entitet->ime))>50){
            throw new Exception('Ime predugačko');
        }
    }
    private function kontrolaPrezime()
    {
        if(strlen(trim($this->entitet->prezime))==0){
            throw new Exception('Unesite prezime');
        }
    }

    private function kontrolaSpecijalizacija()
    {
        if(strlen(trim($this->entitet->specijalizacija))==0){
            throw new Exception('Unesite specijalizaciju');
        }
    }

    private function kontrolaEmail()
    {
        if(strlen(trim($this->entitet->email))==0){
            throw new Exception('Unesite email');
        }
    }
}

