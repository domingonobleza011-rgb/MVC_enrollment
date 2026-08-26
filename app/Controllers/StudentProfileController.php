<?php

class StudentProfileController extends Controller
{
    public function index()
    {
 
    error_reporting(E_ALL ^ E_WARNING);
    require(MODELS_PATH . '/student.class.php');
    ini_set('display_errors',0);
    $userdetails = $studenteusebia->get_userdata();
    $id_student = $_GET['id_student'];
    $student = $studenteusebia->get_single_student($id_student);
    

    $studenteusebia->profile_update();

        $this->view('pages/student_profile', get_defined_vars());
    }
}
