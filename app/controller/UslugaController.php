<?php

class UslugaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR 
                        . 'usluga' 
                        . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'usluge'=> Usluga::ucitajSve()
        ]);
    }
}
