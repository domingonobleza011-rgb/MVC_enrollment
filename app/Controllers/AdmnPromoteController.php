<?php

class AdmnPromoteController extends Controller
{
    public function index()
    {

    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 0);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    // Handle promotion POST request
    $promote_result = null;
    if (isset($_POST['promote_grade'])) {
        $promote_result = $eusebia->promote_students(
            $_POST['from_grade'],
            $_POST['to_grade'],
            $_POST['new_sy'],
            $_POST['selected_ids'] ?? []
        );
    }

    // Load preview list based on selected "from_grade"
    $preview_grade = $_GET['from_grade'] ?? '';
    $preview_list = [];
    if ($preview_grade !== '') {
        $preview_list = $eusebia->get_students_for_promotion($preview_grade);
    }

    // Grade options
    $grade_map = [
        '7'  => ['label' => 'Grade 7',  'next' => '8'],
        '8'  => ['label' => 'Grade 8',  'next' => '9'],
        '9'  => ['label' => 'Grade 9',  'next' => '10'],
        '10' => ['label' => 'Grade 10', 'next' => '11'],
        '11' => ['label' => 'Grade 11', 'next' => '12'],
        '12' => ['label' => 'Grade 12', 'next' => null],
    ];

        $this->view('pages/admn_promote', get_defined_vars());
    }
}
