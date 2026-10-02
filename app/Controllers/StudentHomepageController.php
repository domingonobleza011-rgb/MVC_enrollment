<?php

class StudentHomepageController extends Controller
{
    public function index()
    {
 
error_reporting(E_ALL ^ E_WARNING);
include(MODELS_PATH . '/student.class.php');

// Block direct URL access when no one (or a non-student) is logged in
$userdetails = $eusebia->validate_student();
$current_user_id = $userdetails['id_student'];

// Date and time for display
$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$current_date = $dt->format('l, F j, Y');

// ===== Unified enrollment modal: precompute status + auto-fill data for
// every grade level (7-12) up front, so the single modal on this page can
// switch between them instantly with no extra page loads. =====
$grade_defs = [
    7  => ['table' => 'tbl_seven',  'id_col' => 'id_seven',  'prev' => null,        'label' => 'Grade 7',  'tier' => 'junior'],
    8  => ['table' => 'tbl_eight',  'id_col' => 'id_eight',  'prev' => 'tbl_seven', 'label' => 'Grade 8',  'tier' => 'junior'],
    9  => ['table' => 'tbl_nine',   'id_col' => 'id_nine',   'prev' => 'tbl_eight', 'label' => 'Grade 9',  'tier' => 'junior_course'],
    10 => ['table' => 'tbl_ten',    'id_col' => 'id_ten',    'prev' => 'tbl_nine',  'label' => 'Grade 10', 'tier' => 'junior_course'],
    11 => ['table' => 'tbl_eleven', 'id_col' => 'id_eleven', 'prev' => 'tbl_ten',   'label' => 'Grade 11', 'tier' => 'senior'],
    12 => ['table' => 'tbl_twelve', 'id_col' => 'id_twelve', 'prev' => 'tbl_eleven','label' => 'Grade 12', 'tier' => 'senior'],
];

$enrollment_open = $eusebia->is_enrollment_open();
$grade_status  = [];
$prev_data_map = [];

foreach ($grade_defs as $g => $def) {
    $locked            = $eusebia->has_advanced_beyond($current_user_id, $def['table']);
    $has_record        = $eusebia->has_grade_level_record($current_user_id, $def['table'], $def['id_col']);
    $pending_elsewhere = $eusebia->get_pending_enrollment_elsewhere($current_user_id, $def['table']);
    $prev_record       = $def['prev'] ? $eusebia->get_prev_grade_record($current_user_id, $def['prev']) : null;

    $available = $enrollment_open && !$locked && !$has_record && !$pending_elsewhere;
    $reason = '';
    if ($locked) {
        $reason = 'Already advanced beyond this grade.';
    } elseif ($has_record) {
        $reason = 'You already have a record for this grade.';
    } elseif ($pending_elsewhere) {
        $reason = 'Pending enrollment in ' . $pending_elsewhere . '.';
    } elseif (!$enrollment_open) {
        $reason = 'Enrollment is currently closed.';
    }

    $grade_status[$g] = [
        'label'     => $def['label'],
        'tier'      => $def['tier'],
        'available' => $available,
        'reason'    => $reason,
    ];
    $prev_data_map[$g] = $prev_record;
}

        $this->view('pages/student_homepage', get_defined_vars());
    }
}
