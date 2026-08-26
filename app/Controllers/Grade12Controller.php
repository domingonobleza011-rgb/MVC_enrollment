<?php

class Grade12Controller extends Controller
{
    public function index()
    {
 
error_reporting(E_ALL ^ E_WARNING);
require(MODELS_PATH . '/main.class.php');
require(MODELS_PATH . '/student.class.php');

$userdetails = $eusebia->get_userdata();
$eusebia->create_twelve(); // handles Grade 12 enrollment submission

// One account = one enrollment: auto-detect this student's approved Grade 11 record.
$prev_enrollment = $eusebia->get_prev_grade_record($userdetails['id_student'] ?? 0, 'tbl_eleven');

// Open/close enrollment period toggle (admin System Settings page).
$enrollment_open = $eusebia->is_enrollment_open();

$edit_id  = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$existing = $edit_id ? $eusebia->get_editable_submission('tbl_twelve', 'id_twelve', $edit_id, $userdetails['id_student'] ?? 0) : null;

$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$current_date = $dt->format('l, F j, Y');

        $this->view('pages/grade12', get_defined_vars());
    }
}
