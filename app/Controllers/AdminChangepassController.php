<?php

class AdminChangepassController extends Controller
{
    public function index()
    {

    
    require(MODELS_PATH . '/main.class.php');
    $eusebia->admin_changepass();
    $userdetails = $eusebia->get_userdata();

        $this->view('pages/admin_changepass', get_defined_vars());
    }
}
