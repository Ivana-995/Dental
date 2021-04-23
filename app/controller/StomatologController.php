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
       try {
           $this->kontrola();
           Stomatolog::spremiNovo($this->entitet);
           $this->index();
       }
       catch (Exception $e) {
           $this->poruka=$e->getMessage();
           $this->novoView();
       }    
    }

    public function promjena()
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            if(!isset($_GET['sifra']))
            {
                $ic = new IndexController();
                $ic->logout();
                return;
            }
            $this->entitet = Stomatolog::ucitaj($_GET['sifra']);
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }
        $this->entitet = (object) $_POST;
        try{
            $this->kontrola();
            Stomatolog::promjeniPostojeci($this->entitet);
            $this->index();
        }
        catch (Exception $e)
            {
            $this->poruka=$e->getMessage();
            $this->promjenaView();
            }
    }

    public function brisanje()
    {
        if(!isset($_GET['sifra']))
        {
            $ic = new IndexController();
            $ic->logout();
            return;
        }
        Stomatolog::obrisiPostojeci($_GET['sifra']);
        header('location: ' . App::config('url') . 'stomatolog/index');
    }

    private function noviEntitet()
    {
        $this->entitet = new stdClass();
        $this->entitet->ime='';
        $this->entitet->prezime='';
        $this->entitet->specijalizacija='';
        $this->entitet->email='';
        $this->entitet->grad='';
        $this->entitet->adresa='';
        $this->entitet->kontakt='';
        $this->poruka='Unesite tražene podatke';
        $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',
        [
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka,
        ]);
    }

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',
        [
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);

    }

    private function kontrola()
    {
        $this->kontrolaStomatolog();
        $this->kontrolaOrdinacija();
       
    }

    private function kontrolaStomatolog()
    {
        $this->kontrolaIme();
        $this->kontrolaPrezime();
        $this->kontrolaSpecijalizacija();
    }

    private function kontrolaOrdinacija()
    {
        $this->kontrolaGrad();
        $this->kontrolaAdresa();
        $this->kontrolaKontakt();
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

        if(strlen(trim($this->entitet->prezime))>50){
            throw new Exception('Prezime predugačko');
        }
    }

    private function kontrolaSpecijalizacija()
    {
        if(strlen(trim($this->entitet->specijalizacija))==0){
            throw new Exception('Unesite specijalizaciju');
        }
    }

    private function kontrolaGrad()
    {
        if(strlen(trim($this->entitet->grad))==0){
            throw new Exception('Unesite grad');
        }
    }

    private function kontrolaAdresa()
    {
        if(strlen(trim($this->entitet->adresa))==0){
            throw new Exception('Unesite adresu');
        }
    }

    private function kontrolaKontakt()
    {
        $this->entitet->kontakt=str_replace(',','.',$this->entitet->kontakt);
        if(!is_numeric($this->entitet->kontakt)
              || ((float)$this->entitet->kontakt)<=0){
                $this->poruka='Unesite broj kontakta';
              $this->novoView();
              return false;
        }
         return true;
    }
    


}

