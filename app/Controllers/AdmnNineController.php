<?php

class AdmnNineController extends Controller
{
    public function index()
    {
 
    session_start();
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();
    $eusebia->delete_nine();
    $eusebia->approve_nine();
    $eusebia->reject_nine();
    $eusebia->bulk_approve_nine();
    $eusebia->bulk_reject_nine();
    $eusebia->bulk_archive_nine();
    $eusebia->admin_add_enrollee('nine');
    $eusebia->mark_requirements_complete('nine');
    $eusebia->edit_enrollee('nine');
    $view = $eusebia->view_nine();
    $id_student = $_GET['id_student'] ?? null;
    $student = $id_student ? $studenteusebia->get_single_nine($id_student) : null;

        $this->view('pages/admn_nine', get_defined_vars());
    }
}
