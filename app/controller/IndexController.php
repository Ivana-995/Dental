<?php

class IndexController extends Controller
{
    public function index()
    {
        $this->view->render('index');
        
    }
    public function novosti()
    {
        $this->view->render('novosti');
    }

    public function login()
    {
        $this->view->render('login');
    }
}