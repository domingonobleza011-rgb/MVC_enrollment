<?php

class AdmnTenController extends Controller
{
    public function index()
    {
 
    session_start();
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();
    $eusebia->delete_ten();
    $eusebia->approve_ten();
    $eusebia->reject_ten();
    $eusebia->bulk_approve_ten();
    $eusebia->bulk_reject_ten();
    $eusebia->bulk_archive_ten();
    $eusebia->admin_add_enrollee('ten');
    $eusebia->mark_requirements_complete('ten');
    $view = $eusebia->view_ten();
    $id_student = $_GET['id_student'] ?? null;
    $student = $id_student ? $studenteusebia->get_single_ten($id_student) : null;

        $this->view('pages/admn_ten', get_defined_vars());
    }
}
