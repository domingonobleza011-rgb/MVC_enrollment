<?php

class IctelevenController extends Controller
{
    public function index()
    {
 
    session_start();
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 0);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();
    $eusebia->delete_eleven();
    $eusebia->approve_eleven();
    $eusebia->reject_eleven();
    $eusebia->bulk_approve_eleven();
    $eusebia->bulk_reject_eleven();
    $eusebia->bulk_archive_eleven();
    $eusebia->mark_requirements_complete('eleven');
    $view = $studenteusebia->view_eleven_ict();

        $this->view('pages/icteleven', get_defined_vars());
    }
}
