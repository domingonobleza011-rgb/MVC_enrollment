<?php

class StaffStudentsController extends Controller
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
$subject_list    = array_filter(array_map('trim', explode(',', $subject_grades)));

// Per-table config
$grade_config = [
    7  => ['table'=>'tbl_seven',  'label'=>'Grade 7',  'has_course'=>false, 'has_status'=>true,  'strand'=>null],
    8  => ['table'=>'tbl_eight',  'label'=>'Grade 8',  'has_course'=>false, 'has_status'=>true,  'strand'=>null],
    9  => ['table'=>'tbl_nine',   'label'=>'Grade 9',  'has_course'=>true,  'has_status'=>true,  'strand'=>null],
    10 => ['table'=>'tbl_ten',    'label'=>'Grade 10', 'has_course'=>true,  'has_status'=>false, 'strand'=>null],
    11 => ['table'=>'tbl_eleven', 'label'=>'Grade 11', 'has_course'=>true,  'has_status'=>false, 'strand'=>null],
    12 => ['table'=>'tbl_twelve', 'label'=>'Grade 12', 'has_course'=>true,  'has_status'=>true,  'strand'=>null],
];

$grade  = isset($_GET['grade'])  ? (int)$_GET['grade'] : 0;
$strand = isset($_GET['strand']) ? trim($_GET['strand']) : '';

// Build the key the way adviser_grade is stored e.g. "Grade 7" or "Grade 11 - STEM"
$requested_key = $grade <= 10 ? "Grade {$grade}" : "Grade {$grade} - {$strand}";

// BLOCK ACCESS: allow only if matches advisory class OR is in subject_grades list
$is_adviser   = ($adviser_grade === $requested_key);
$is_subject   = in_array($requested_key, $subject_list);
if (!$is_adviser && !$is_subject) {
    header('Location: staff_dashboard.php'); exit();
}

if (!isset($grade_config[$grade])) {
    header('Location: staff_dashboard.php'); exit();
}

$cfg   = $grade_config[$grade];
$table = $cfg['table'];
$label = $cfg['label'] . ($strand ? ' — ' . $strand : '');

$conn   = $eusebia->openConn();
$where  = ["(is_archived=0 OR is_archived IS NULL)"];
$params = [];

if ($cfg['has_status'])                                              $where[] = "enrollment_status='Approved'";
if ($cfg['has_course'] && in_array($grade,[11,12]) && $strand!=='') { $where[] = "course=?"; $params[] = $strand; }

$sql = "SELECT * FROM `{$table}` WHERE " . implode(' AND ', $where) . " ORDER BY lname ASC, fname ASC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $students = [];
}

$is_shs = in_array($grade, [11,12]);

        $this->view('pages/staff_students', get_defined_vars());
    }
}
