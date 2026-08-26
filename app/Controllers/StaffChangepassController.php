<?php

class StaffChangepassController extends Controller
{
    public function index()
    {
    session_start();
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/main.class.php');

    $userdetails = $eusebia->get_userdata();
    if (!$userdetails || $userdetails['role'] !== 'staff') {
        header('Location: login.php'); exit();
    }

    $eusebia->staff_changepass();

        $this->view('pages/staff_changepass', get_defined_vars());
    }
}
