<?php

class AddAdminController extends Controller
{
    public function index()
    {
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    require(MODELS_PATH . '/main.class.php');
    $eusebia->create_admin(); 
    $userdetails = $eusebia->get_userdata();

        $this->view('pages/add_admin', get_defined_vars());
    }
}
