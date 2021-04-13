<?php

class PacijentController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                       . DIRECTORY_SEPARATOR .
                       'pacijent'
                       . DIRECTORY_SEPARATOR;
    

    public function index()
    {
        $this->view->render($this->viewDir .'index',
        [
            'entiteti'=>Pacijent::ucitajSve()
        ]);
    }
}