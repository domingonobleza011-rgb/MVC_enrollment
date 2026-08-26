<?php

class StudentRegistrationController extends Controller
{
    public function index()
    {
 
     require(MODELS_PATH . '/student.class.php');
    $studenteusebia->create_student();

        $this->view('pages/student_registration', get_defined_vars());
    }
}
