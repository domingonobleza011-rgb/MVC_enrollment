<?php

class AdmnClasslistController extends Controller
{
    public function index()
    {
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 0);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    $school_name = 'Eusebia Paz Arroyo Memorial National High School';
    $school_year = $_GET['sy']   ?? '';
    $grade       = $_GET['grade'] ?? '';
    $do_print    = isset($_GET['print']);

    $grade_map = [
        'seven'  => ['label' => 'Grade 7',  'table' => 'tbl_seven',  'shs' => false],
        'eight'  => ['label' => 'Grade 8',  'table' => 'tbl_eight',  'shs' => false],
        'nine'   => ['label' => 'Grade 9',  'table' => 'tbl_nine',   'shs' => false],
        'ten'    => ['label' => 'Grade 10', 'table' => 'tbl_ten',    'shs' => false],
        'eleven' => ['label' => 'Grade 11', 'table' => 'tbl_eleven', 'shs' => true],
        'twelve' => ['label' => 'Grade 12', 'table' => 'tbl_twelve', 'shs' => true],
    ];

    // Get all available school years across all tables for the filter dropdown
    $all_sy = [];
    $conn   = $eusebia->openConn();
    foreach ($grade_map as $g => $info) {
        $r = $conn->query("SELECT DISTINCT sy FROM {$info['table']} WHERE is_archived = 0 OR is_archived IS NULL ORDER BY sy DESC");
        foreach ($r->fetchAll(PDO::FETCH_COLUMN) as $s) {
            if ($s) $all_sy[$s] = true;
        }
    }
    krsort($all_sy);
    $all_sy = array_keys($all_sy);

    // Fetch students
    $students = [];
    $grade_info = null;
    if ($grade && isset($grade_map[$grade])) {
        $grade_info = $grade_map[$grade];
        $table = $grade_info['table'];
        try { $conn->exec("ALTER TABLE $table ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
        if ($school_year) {
            $stmt = $conn->prepare("SELECT * FROM $table WHERE (is_archived = 0 OR is_archived IS NULL) AND enrollment_status = 'Approved' AND sy = ? ORDER BY lname, fname");
            $stmt->execute([$school_year]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM $table WHERE (is_archived = 0 OR is_archived IS NULL) AND enrollment_status = 'Approved' ORDER BY lname, fname");
            $stmt->execute();
        }
        $students = $stmt->fetchAll();
    }

    // Group SHS by course
    $grouped = [];
    if ($grade_info && $grade_info['shs']) {
        foreach ($students as $s) {
            $course = trim($s['course'] ?? 'Unassigned');
            $grouped[$course][] = $s;
        }
        ksort($grouped);
    } else {
        $grouped['__all__'] = $students;
    }

        $this->view('pages/admn_classlist', get_defined_vars());
    }
}
