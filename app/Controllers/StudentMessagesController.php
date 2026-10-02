<?php

class StudentMessagesController extends Controller
{
    public function index()
    {
        error_reporting(E_ALL ^ E_WARNING);
        require_once(HELPERS_PATH . '/csrf.php');
        include(MODELS_PATH . '/student.class.php');

        // Blocks anyone who isn't a logged-in student.
        $userdetails     = $eusebia->validate_student();
        $current_user_id = $userdetails['id_student'];
        $csrf_value      = csrf_token();

        $this->view('pages/student_messages', get_defined_vars());
    }
}
