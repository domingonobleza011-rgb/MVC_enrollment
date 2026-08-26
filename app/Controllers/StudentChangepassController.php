<?php

class StudentChangepassController extends Controller
{
    public function index()
    {
 
error_reporting(E_ALL ^ E_WARNING);
require(MODELS_PATH . '/student.class.php');

$userdetails = $studenteusebia->get_userdata();
$studenteusebia->student_changepass();

$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$current_date = $dt->format('l, F j, Y');

        $this->view('pages/student_changepass', get_defined_vars());
    }
}
