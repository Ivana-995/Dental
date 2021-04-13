<?php

class StomatologController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                      . DIRECTORY_SEPARATOR
                      . 'stomatolog'
                      . DIRECTORY_SEPARATOR;
    
    private $stomatolog=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',
        [
            'stomatolozi'=>Stomatolog::ucitajSve()
        ]);
    }

    public function novo()
    {
       if($_SERVER['REQUEST_METHOD']==='GET')
       {
           $this->novoStomatolog();
           return;
       }
       $this->stomatolog = (object) $_POST;
       try
       {
           $this->kontrola();
           Stomatolog::spremiNovo($this->stomatolog);
           $this->index();
       }
       catch (Exception $e)
       {
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
            $this->stomatolog = Stomatolog::ucitaj($_GET['sifra']);
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }
        $this->stomatolog = (object) $_POST;
        try{
            $this->kontrola();
            Stomatolog::promjenaPostojeci($this->stomatolog);
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

    private function novoStomatolog()
    {
        $this->stomatolog = new stdClass();
        $this->stomatolog->ime='';
        $this->stomatolog->prezime='';
        $this->stomatolog->specijalizacija='';
        $this->stomatolog->email='';
        $this->poruka='Unesite tražene podatke';
        $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',
        [
            'stomatolog'=>$this->stomatolog,
            'poruka'=>$this->poruka
        ]);
    }

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',
        [
            'stomatolog'=>$this->stomatolog,
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
        if(strlen(trim($this->stomatolog->ime))==0){
            throw new Exception('Unesite ime');
        }

        if(strlen(trim($this->stomatolog->ime))>50){
            throw new Exception('Ime predugačko');
        }
    }
    private function kontrolaPrezime()
    {
        if(strlen(trim($this->stomatolog->prezime))==0){
            throw new Exception('Unesite prezime');
        }
    }

    private function kontrolaSpecijalizacija()
    {
        if(strlen(trim($this->stomatolog->specijalizacija))==0){
            throw new Exception('Unesite specijalizaciju');
        }
    }

    private function kontrolaEmail()
    {
        if(strlen(trim($this->stomatolog->email))==0){
            throw new Exception('Unesite email');
        }
    }
}

