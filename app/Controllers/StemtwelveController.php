<?php

class StemtwelveController extends Controller
{
    public function index()
    {
 
    session_start();
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 0);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();
    $eusebia->delete_twelve();
    $eusebia->approve_twelve();
    $eusebia->reject_twelve();
    $eusebia->bulk_approve_twelve();
    $eusebia->bulk_reject_twelve();
    $eusebia->bulk_archive_twelve();
    $eusebia->mark_requirements_complete('twelve');
    $view = $studenteusebia->view_twelve_stem();

        $this->view('pages/stemtwelve', get_defined_vars());
    }
}
