<?php

class AdmnStudentsController extends Controller
{
    public function index()
    {
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    require_once(MODELS_PATH . '/staff.class.php');
    $staffeusebia->promote_student_to_staff();

    // Fetch all registered student accounts
    $connection = $eusebia->openConn();
    $stmt = $connection->prepare("SELECT * FROM tbl_student ORDER BY lname ASC, fname ASC");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('pages/admn_students', get_defined_vars());
    }
}
