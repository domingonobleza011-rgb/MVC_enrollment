<?php

class AdmnElevenController extends Controller
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
    $eusebia->admin_add_enrollee('eleven');
    $eusebia->mark_requirements_complete('eleven');
    $current_sort  = isset($_GET['sort'])  ? $_GET['sort']  : 'lname';
    $current_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    $view = $eusebia->view_eleven($current_sort, $current_order);
    $id_student = $_GET['id_student'] ?? null;
    $student    = $id_student ? $studenteusebia->get_single_eleven($id_student) : null;
    $stem_count  = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'STEM');
    $abm_count   = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'ABM');
    $gas_count   = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'GAS');
    $ict_count   = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'TVL-ICT');
    $he_count    = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'TVL-HE');

        $this->view('pages/admn_eleven', get_defined_vars());
    }
}
