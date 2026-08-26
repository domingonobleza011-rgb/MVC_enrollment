<?php

class Grade9Controller extends Controller
{
    public function index()
    {
 
 error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
require(MODELS_PATH . '/main.class.php');
require(MODELS_PATH . '/student.class.php');

$userdetails = $eusebia->get_userdata();
$eusebia->create_nine(); // handles Grade 10 enrollment submission

// One account = one enrollment: auto-detect this student's approved Grade 8 record.
$prev_enrollment = $eusebia->get_prev_grade_record($userdetails['id_student'] ?? 0, 'tbl_eight');

// Open/close enrollment period toggle (admin System Settings page).
$enrollment_open = $eusebia->is_enrollment_open();

// Forward lock — hide/disable this grade's form once the account has
// already advanced to a later grade level.
$grade_locked = $eusebia->has_advanced_beyond($userdetails['id_student'] ?? 0, 'tbl_nine');

$edit_id  = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$existing = $edit_id ? $eusebia->get_editable_submission('tbl_nine', 'id_nine', $edit_id, $userdetails['id_student'] ?? 0) : null;

$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$current_date = $dt->format('l, F j, Y');

        $this->view('pages/grade9', get_defined_vars());
    }
}
