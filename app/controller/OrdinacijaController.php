<?php

class OrdinacijaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                       . DIRECTORY_SEPARATOR
                       . 'ordinacija'
                       . DIRECTORY_SEPARATOR;

    public function index()
    {
        $ordinacije = Ordinacija::ucitajSve();

        foreach($ordinacije as $red)
        {
         if(file_exists(BP . 'public' . DIRECTORY_SEPARATOR .
            'img' . DIRECTORY_SEPARATOR . 'ordinacija' . 
            DIRECTORY_SEPARATOR . $red->sifra . '.png'))
            {
                $red->slika = App::config('url') . 
                'public/img/ordinacija/' . $red->sifra . '.png';
            }else
                {
                    $red->slika = App::config('url') . 
                    'public/img/ordinacija/nepoznato.png';
                }
        }
        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>$ordinacije
        ]);
    }

    public function novo()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $this->noviEntitet();
            return;
        }
        $this->entitet = (object) $_POST;
        try {
            $this->kontrola();
            Ordinacija::spremiNovo($this->entitet);
            $this->index();
        } catch (Exception $e) {
            $this->poruka=$e->getMessage();
            $this->novoView();
        }       
    }

    public function promjena()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if(!isset($_GET['sifra'])){
                $ic = new IndexController();
                $ic->logout();
                return;
            }
            $this->entitet = Ordinacija::ucitaj($_GET['sifra']);
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }
        $this->entitet = (object) $_POST;
        try {
            $this->kontrola();
            Ordinacija::promjeniPostojeci($this->entitet);
            $this->index();
        } catch (Exception $e) {
            $this->poruka=$e->getMessage();
            $this->promjenaView();
        }       
    }


    public function brisanje()
    {
        if(!isset($_GET['sifra'])){
            $ic = new IndexController();
            $ic->logout();
            return;
        }
        Ordinacija::obrisiPostojeci($_GET['sifra']);
        header('location: ' . App::config('url') . 'ordinacija/index');
        
    }


    private function noviEntitet()
    {
        $this->entitet = new stdClass();
        $this->entitet->grad='';
        $this->entitet->adresa='';
        $this->entitet->kontakt='';
        $this->poruka='Unesite tražene podatke';
        $this->novoView();
    }

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
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
        $this->kontrolaGrad();
        $this->kontrolaAdresa();
        $this->kontrolaKontakt();
    }


    
    private function kontrolaGrad()
    {
        if(strlen(trim($this->entitet->grad))==0){
            throw new Exception('Unesite grad');
        }

        if(strlen(trim($this->entitet->grad))>70){
            throw new Exception('Naziv grada mora biti kraći od 70 znakova');
        }
    }

    private function kontrolaAdresa()
    {
        if(strlen(trim($this->entitet->adresa))==0){
            throw new Exception('Adresa i kućni broj obavezno');
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

