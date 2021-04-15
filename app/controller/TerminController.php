<?php

class TerminController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                      . DIRECTORY_SEPARATOR
                      . 'termin'
                      . DIRECTORY_SEPARATOR;
    
    private $entitet=null;
    private $poruka='';
    private $pacijenti=null;
    private $stomatolozi=null;

    public function __construct()
    {
        parent::__construct();
        $this->pacijenti=Pacijent::ucitajSve();
        
        $s=new stdClass();
        $s->sifra=-1;
        $s->ime=' - - - -';
        $s->prezime='';
        array_unshift($this->pacijenti,$s);

        $this->stomatolozi=Stomatolog::ucitajSve();
        
        $s=new stdClass();
        $s->sifra=-1;
        $s->ime=' - - - -';
        $s->prezime='';
        array_unshift($this->stomatolozi,$s);
    }

    public function index()
    {
        $this->view->render($this->viewDir . 'index',
        [
            'entiteti'=>Termin::ucitajSve()
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
            Termin::dodajNovo($this->entitet);
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
        $this->entitet->pacijent=-1;
        $this->entitet->stomatolog=-1;
        $this->poruka='Odaberite pacijenta i stomatologa';
        $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka,
            'pacijenti'=>$this->pacijenti,
            'stomatolozi'=>$this->stomatolozi
        ]);
    }

    private function kontrola()
    {
        $this->kontrolaPacijent();
        $this->kontrolaStomatolog();
    }

    private function kontrolaPacijent()
    {
        if($this->entitet->pacijent==-1){
            throw new Exception('Pacijent obavezno');
        }
    }

    private function kontrolaStomatolog()
    {
        if($this->entitet->stomatolog==-1){
            throw new Exception('Stomatolog obavezno');
        }
    }
}