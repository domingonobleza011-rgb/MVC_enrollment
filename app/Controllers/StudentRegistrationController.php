<?php

class StudentRegistrationController extends Controller
{
    public function index()
    {
     if (session_status() === PHP_SESSION_NONE) { session_start(); }
     // Snapshot then clear — the view only needs this local copy to prefill
     // the form on this render; keeping it in session any longer than one
     // page load risks prefilling a stale identity on a later, unrelated visit.
     $google_pending = $_SESSION['google_pending'] ?? null;
     unset($_SESSION['google_pending']);

     require(MODELS_PATH . '/student.class.php');
    $studenteusebia->create_student();

        $this->view('pages/student_registration', get_defined_vars());
    }
}
