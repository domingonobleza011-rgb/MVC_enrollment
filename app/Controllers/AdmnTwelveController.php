<?php

class AdmnTwelveController extends Controller
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
    $eusebia->admin_add_enrollee('twelve');
    $eusebia->mark_requirements_complete('twelve');
    $eusebia->edit_enrollee('twelve');
    $current_sort  = isset($_GET['sort'])  ? $_GET['sort']  : 'lname';
    $current_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    $view = $eusebia->view_twelve($current_sort, $current_order);
    $id_student = $_GET['id_student'] ?? null;
    $student    = $id_student ? $studenteusebia->get_single_twelve($id_student) : null;
    $stem_count  = $studenteusebia->count_by_grade('tbl_twelve', 'course', 'STEM');
    $abm_count   = $studenteusebia->count_by_grade('tbl_twelve', 'course', 'ABM');
    $gas_count   = $studenteusebia->count_by_grade('tbl_twelve', 'course', 'GAS');
    $ict_count   = $studenteusebia->count_by_grade('tbl_twelve', 'course', 'TVL-ICT');
    $he_count    = $studenteusebia->count_by_grade('tbl_twelve', 'course', 'TVL-HE');

        $this->view('pages/admn_twelve', get_defined_vars());
    }
}
