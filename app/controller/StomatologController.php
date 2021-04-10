<?php

class StomatologController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                      . DIRECTORY_SEPARATOR
                      . 'stomatolog'
                      . DIRECTORY_SEPARATOR;
    
    private $entitet=null;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',
        [
            'stomatolozi'=>Stomatolog::ucitajSve()
        ]);
    }
}

