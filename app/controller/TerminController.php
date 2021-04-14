<?php

class TerminController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                      . DIRECTORY_SEPARATOR
                      . 'termin'
                      . DIRECTORY_SEPARATOR;
    
    public function index()
    {
        $this->view->render($this->viewDir . 'index',
        [
            'termini'=>Termin::ucitajSve()
        ]);
    }
}