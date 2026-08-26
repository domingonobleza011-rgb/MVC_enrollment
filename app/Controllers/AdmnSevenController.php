<?php

class AdmnSevenController extends Controller
{
    public function index()
    {
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();
    $eusebia->delete_seven();
    $eusebia->approve_seven();
    $eusebia->reject_seven();
    $eusebia->bulk_approve_seven();
    $eusebia->bulk_reject_seven();
    $eusebia->bulk_archive_seven();
    $eusebia->admin_add_enrollee('seven');
    $eusebia->mark_requirements_complete('seven');
    $view = $eusebia->view_seven();
    $id_student = $_GET['id_student'] ?? null;
    $student = $id_student ? $studenteusebia->get_single_seven($id_student) : null;

        $this->view('pages/admn_seven', get_defined_vars());
    }
}
