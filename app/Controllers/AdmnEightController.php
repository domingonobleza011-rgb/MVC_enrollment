<?php

class AdmnEightController extends Controller
{
    public function index()
    {
 
    session_start();
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();
    $eusebia->delete_eight();
    $eusebia->approve_eight();
    $eusebia->reject_eight();
    $eusebia->bulk_approve_eight();
    $eusebia->bulk_reject_eight();
    $eusebia->bulk_archive_eight();
    $eusebia->admin_add_enrollee('eight');
    $eusebia->mark_requirements_complete('eight');
    $eusebia->edit_enrollee('eight');
    $view = $eusebia->view_eight();
    $id_student = $_GET['id_student'] ?? null;
    $student = $id_student ? $studenteusebia->get_single_eight($id_student) : null;

        $this->view('pages/admn_eight', get_defined_vars());
    }
}
