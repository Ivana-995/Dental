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
        $this->loginView('','');
    }

    public function logout()
    {
        unset($_SESSION['autoriziran']);
        session_destroy();
        $this->index();
    }

    public function autorizacija()
    {
        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return; //short curcuiting
        }

        if(strlen(trim($_POST['email']))===0){
            $this->loginView('','Obavezno email');
            return;
        }

        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select * from operater where email=:email
        
        ');
        $izraz->execute(['email'=>$_POST['email']]);
        $rezultat = $izraz->fetch();

        if($rezultat==null){
            $this->loginView($_POST['email'],'Email ne postoji u bazi');
            return;
        }
        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->loginView($_POST['email'],'Kombinacija email i lozinka ne odgovaraju');
            return;
    }

    unset($rezultat->lozinka);
    $_SESSION['autoriziran']=$rezultat;
    $np = new NadzornaplocaController();
    $np->index();

    }

    private function loginView($email,$poruka)
    {
        $this->view->render('login',[
            'email'=>$email,
            'poruka'=>$poruka
        ]);
    }

    /*
    public function test()
    {
        echo password_hash('plavizub',PASSWORD_BCRYPT);
    }
    */
}