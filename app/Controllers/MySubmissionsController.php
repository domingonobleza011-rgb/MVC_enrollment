<?php

class MySubmissionsController extends Controller
{
    public function index()
    {
 
error_reporting(E_ALL ^ E_WARNING);
include(MODELS_PATH . '/student.class.php');

$userdetails = $eusebia->get_userdata();
$current_user_id = $userdetails['id_student'];

// Fetch promotion requests for display
$my_promotion_requests = $eusebia->get_my_promotion_requests();

$connection = $eusebia->openConn();

$grades = [
    ['table' => 'tbl_seven',  'pk' => 'id_seven',  'label' => 'Grade 7',  'level' => 'Junior High - 1st Year', 'page' => 'student_enrollment.php', 'grade' => 7],
    ['table' => 'tbl_eight',  'pk' => 'id_eight',  'label' => 'Grade 8',  'level' => 'Junior High - 2nd Year', 'page' => 'student_enrollment.php', 'grade' => 8],
    ['table' => 'tbl_nine',   'pk' => 'id_nine',   'label' => 'Grade 9',  'level' => 'Junior High - 3rd Year', 'page' => 'student_enrollment.php', 'grade' => 9],
    ['table' => 'tbl_ten',    'pk' => 'id_ten',    'label' => 'Grade 10', 'level' => 'Junior High - 4th Year', 'page' => 'student_enrollment.php', 'grade' => 10],
    ['table' => 'tbl_eleven', 'pk' => 'id_eleven', 'label' => 'Grade 11', 'level' => 'Senior High - 11th',     'page' => 'student_enrollment.php', 'grade' => 11],
    ['table' => 'tbl_twelve', 'pk' => 'id_twelve', 'label' => 'Grade 12', 'level' => 'Senior High - 12th',     'page' => 'student_enrollment.php', 'grade' => 12],
];

$all_submissions = [];
foreach ($grades as $g) {
    try {
        $stmt = $connection->prepare(
            "SELECT * FROM {$g['table']} 
             WHERE id_student = ? AND (is_archived = 0 OR is_archived IS NULL)"
        );
        $stmt->execute([$current_user_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $row['grade_label'] = $g['label'];
            $row['grade_level'] = $g['level'];
            $row['edit_page']   = $g['page'];
            $row['edit_grade']  = $g['grade'];
            $row['edit_pk']     = $row[$g['pk']];
            $all_submissions[] = $row;
        }
    } catch (PDOException $e) {
        // Skip tables that don't exist or have issues
        continue;
    }
}

$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$current_date = $dt->format('l, F j, Y');

$total    = count($all_submissions);
$pending  = count(array_filter($all_submissions, fn($r) => strtolower($r['enrollment_status'] ?? 'pending') === 'pending'));
$approved = count(array_filter($all_submissions, fn($r) => strtolower($r['enrollment_status'] ?? '') === 'approved'));
$rejected = count(array_filter($all_submissions, fn($r) => strtolower($r['enrollment_status'] ?? '') === 'rejected'));

        $this->view('pages/my_submissions', get_defined_vars());
    }
}
