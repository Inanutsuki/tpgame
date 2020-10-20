<?php

namespace App\Controller;

class AppController extends BaseController {

    public function home(){
        $this->render("home.html.php");
    }

    public function lobby(){
        echo "Lobby";
        die();
    }

    public function arena(){

    }

    public function error404(){

    }
}