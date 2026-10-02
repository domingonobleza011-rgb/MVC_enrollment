<?php

class StudentSecurityQuestionController extends Controller
{
    public function index()
    {

error_reporting(E_ALL ^ E_WARNING);
require(MODELS_PATH . '/student.class.php');

$userdetails = $studenteusebia->get_userdata();
$studenteusebia->student_set_security_question();
$current_security_question = $studenteusebia->get_current_security_question($userdetails['id_student'] ?? null);

        $this->view('pages/student_security_question', get_defined_vars());
    }
}
