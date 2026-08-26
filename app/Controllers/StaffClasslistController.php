<?php

class StaffClasslistController extends Controller
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
    $subject_grades  = $userdetails['subject_grades']  ?? '';
    $subject_list    = array_filter(array_map('trim', explode(',', $subject_grades)));

    $school_name = 'Eusebia Paz Arroyo Memorial National High School';
    $school_year = $_GET['sy'] ?? '';
    $do_print    = isset($_GET['print']);

    // Full catalogue of grade/strand combinations, keyed the same way adviser_grade / subject_grades are stored.
    $all_classes = [
        'Grade 7'            => ['label'=>'Grade 7',            'table'=>'tbl_seven',  'shs'=>false, 'grade'=>7,  'strand'=>null],
        'Grade 8'            => ['label'=>'Grade 8',            'table'=>'tbl_eight',  'shs'=>false, 'grade'=>8,  'strand'=>null],
        'Grade 9'            => ['label'=>'Grade 9',            'table'=>'tbl_nine',   'shs'=>false, 'grade'=>9,  'strand'=>null],
        'Grade 10'           => ['label'=>'Grade 10',           'table'=>'tbl_ten',    'shs'=>false, 'grade'=>10, 'strand'=>null],
        'Grade 11 - STEM'    => ['label'=>'Grade 11 — STEM',    'table'=>'tbl_eleven', 'shs'=>true,  'grade'=>11, 'strand'=>'STEM'],
        'Grade 11 - ABM'     => ['label'=>'Grade 11 — ABM',     'table'=>'tbl_eleven', 'shs'=>true,  'grade'=>11, 'strand'=>'ABM'],
        'Grade 11 - GAS'     => ['label'=>'Grade 11 — GAS',     'table'=>'tbl_eleven', 'shs'=>true,  'grade'=>11, 'strand'=>'GAS'],
        'Grade 11 - TVL-ICT' => ['label'=>'Grade 11 — TVL-ICT', 'table'=>'tbl_eleven', 'shs'=>true,  'grade'=>11, 'strand'=>'TVL-ICT'],
        'Grade 11 - TVL-HE'  => ['label'=>'Grade 11 — TVL-HE',  'table'=>'tbl_eleven', 'shs'=>true,  'grade'=>11, 'strand'=>'TVL-HE'],
        'Grade 12 - STEM'    => ['label'=>'Grade 12 — STEM',    'table'=>'tbl_twelve', 'shs'=>true,  'grade'=>12, 'strand'=>'STEM'],
        'Grade 12 - ABM'     => ['label'=>'Grade 12 — ABM',     'table'=>'tbl_twelve', 'shs'=>true,  'grade'=>12, 'strand'=>'ABM'],
        'Grade 12 - GAS'     => ['label'=>'Grade 12 — GAS',     'table'=>'tbl_twelve', 'shs'=>true,  'grade'=>12, 'strand'=>'GAS'],
        'Grade 12 - TVL-ICT' => ['label'=>'Grade 12 — TVL-ICT', 'table'=>'tbl_twelve', 'shs'=>true,  'grade'=>12, 'strand'=>'TVL-ICT'],
        'Grade 12 - TVL-HE'  => ['label'=>'Grade 12 — TVL-HE',  'table'=>'tbl_twelve', 'shs'=>true,  'grade'=>12, 'strand'=>'TVL-HE'],
    ];

    // Only the classes this staff member actually teaches/advises can be selected.
    $allowed_keys = array_filter(array_unique(array_merge(
        $adviser_grade ? [$adviser_grade] : [],
        $subject_list
    )));
    $class_options = array_intersect_key($all_classes, array_flip($allowed_keys));

    $requested_key = $_GET['class'] ?? '';
    $class_info    = null;
    if ($requested_key && isset($class_options[$requested_key])) {
        $class_info = $class_options[$requested_key];
    }

    // Get available school years for this class only
    $all_sy = [];
    $conn   = $eusebia->openConn();
    if ($class_info) {
        $table = $class_info['table'];
        try { $conn->exec("ALTER TABLE $table ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
        $r = $conn->query("SELECT DISTINCT sy FROM {$table} WHERE (is_archived = 0 OR is_archived IS NULL) ORDER BY sy DESC");
        foreach ($r->fetchAll(PDO::FETCH_COLUMN) as $s) { if ($s) $all_sy[$s] = true; }
        krsort($all_sy);
        $all_sy = array_keys($all_sy);
    }

    // Fetch APPROVED students only
    $students = [];
    if ($class_info) {
        $table  = $class_info['table'];
        $where  = ["(is_archived = 0 OR is_archived IS NULL)", "enrollment_status = 'Approved'"];
        $params = [];
        if ($class_info['strand']) { $where[] = "course = ?"; $params[] = $class_info['strand']; }
        if ($school_year)          { $where[] = "sy = ?";     $params[] = $school_year; }
        $stmt = $conn->prepare("SELECT * FROM $table WHERE " . implode(' AND ', $where) . " ORDER BY lname, fname");
        $stmt->execute($params);
        $students = $stmt->fetchAll();
    }

        $this->view('pages/staff_classlist', get_defined_vars());
    }
}
