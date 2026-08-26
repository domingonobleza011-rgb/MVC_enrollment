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

        $this->view('pages/student_homepage', get_defined_vars());
    }
}
