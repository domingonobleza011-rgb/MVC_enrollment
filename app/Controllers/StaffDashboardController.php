<?php

class StaffDashboardController extends Controller
{
    public function index()
    {
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);
session_start();
require(MODELS_PATH . '/main.class.php');

$userdetails = $eusebia->get_userdata();
if (!$userdetails || $userdetails['role'] !== 'staff') {
    header('Location: login.php'); exit();
}

$adviser_grade   = $userdetails['adviser_grade']   ?? '';
$subject_handled = $userdetails['subject_handled'] ?? '';
$subject_grades  = $userdetails['subject_grades']  ?? '';
$subjects        = array_filter(array_map('trim', explode(',', $subject_handled)));
$subject_list    = array_filter(array_map('trim', explode(',', $subject_grades)));

// Grade → table/strand config
$grade_url_map = [
    'Grade 7'            => ['url'=>'staff_students.php?grade=7',                'table'=>'tbl_seven',  'strand'=>null],
    'Grade 8'            => ['url'=>'staff_students.php?grade=8',                'table'=>'tbl_eight',  'strand'=>null],
    'Grade 9'            => ['url'=>'staff_students.php?grade=9',                'table'=>'tbl_nine',   'strand'=>null],
    'Grade 10'           => ['url'=>'staff_students.php?grade=10',               'table'=>'tbl_ten',    'strand'=>null],
    'Grade 11 - STEM'    => ['url'=>'staff_students.php?grade=11&strand=STEM',   'table'=>'tbl_eleven', 'strand'=>'STEM'],
    'Grade 11 - ABM'     => ['url'=>'staff_students.php?grade=11&strand=ABM',    'table'=>'tbl_eleven', 'strand'=>'ABM'],
    'Grade 11 - GAS'     => ['url'=>'staff_students.php?grade=11&strand=GAS',    'table'=>'tbl_eleven', 'strand'=>'GAS'],
    'Grade 11 - TVL-ICT' => ['url'=>'staff_students.php?grade=11&strand=TVL-ICT','table'=>'tbl_eleven', 'strand'=>'TVL-ICT'],
    'Grade 11 - TVL-HE'  => ['url'=>'staff_students.php?grade=11&strand=TVL-HE', 'table'=>'tbl_eleven', 'strand'=>'TVL-HE'],
    'Grade 12 - STEM'    => ['url'=>'staff_students.php?grade=12&strand=STEM',   'table'=>'tbl_twelve', 'strand'=>'STEM'],
    'Grade 12 - ABM'     => ['url'=>'staff_students.php?grade=12&strand=ABM',    'table'=>'tbl_twelve', 'strand'=>'ABM'],
    'Grade 12 - GAS'     => ['url'=>'staff_students.php?grade=12&strand=GAS',    'table'=>'tbl_twelve', 'strand'=>'GAS'],
    'Grade 12 - TVL-ICT' => ['url'=>'staff_students.php?grade=12&strand=TVL-ICT','table'=>'tbl_twelve', 'strand'=>'TVL-ICT'],
    'Grade 12 - TVL-HE'  => ['url'=>'staff_students.php?grade=12&strand=TVL-HE', 'table'=>'tbl_twelve', 'strand'=>'TVL-HE'],
];

// Count students in assigned class
$adviser_count = 0;
if ($adviser_grade && isset($grade_url_map[$adviser_grade])) {
    $cfg  = $grade_url_map[$adviser_grade];
    $conn = $eusebia->openConn();
    try {
        // Check if table has enrollment_status
        $probe = $conn->prepare("SELECT enrollment_status FROM `{$cfg['table']}` LIMIT 1");
        $probe->execute();
        $has_status = true;
    } catch (PDOException $e) { $has_status = false; }

    $status_clause = $has_status ? " AND enrollment_status='Approved'" : "";
    $where = "(is_archived=0 OR is_archived IS NULL){$status_clause}";
    $params = [];
    if ($cfg['strand']) { $where .= " AND course=?"; $params[] = $cfg['strand']; }

    try {
        $s = $conn->prepare("SELECT COUNT(*) FROM `{$cfg['table']}` WHERE {$where}");
        $s->execute($params);
        $adviser_count = (int)$s->fetchColumn();
    } catch (PDOException $e) { $adviser_count = 0; }
}

        $this->view('pages/staff_dashboard', get_defined_vars());
    }
}
