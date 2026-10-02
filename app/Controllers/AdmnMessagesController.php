<?php

class AdmnMessagesController extends Controller
{
    public function index()
    {
        error_reporting(E_ALL ^ E_WARNING);
        ini_set('display_errors', 1);
        require_once(HELPERS_PATH . '/csrf.php');
        require(MODELS_PATH . '/main.class.php');
        require(MODELS_PATH . '/student.class.php');
        $userdetails = $eusebia->get_userdata();
        $eusebia->validate_admin();

        $csrf_value   = csrf_token();
        $initial_conv = (int)($_GET['c'] ?? 0);

        $this->view('pages/admn_messages', get_defined_vars());
    }
}
