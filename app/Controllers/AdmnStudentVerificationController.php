<?php

class AdmnStudentVerificationController extends Controller
{
    public function index()
    {
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);
require(MODELS_PATH . '/student.class.php');

$userdetails = $eusebia->get_userdata();
$eusebia->validate_admin();

// Handle POSTs
$eusebia->admin_approve_student_account();
$eusebia->admin_reject_student_account();

$pending = $eusebia->admin_get_pending_student_verifications();

$swal = $_SESSION['swal'] ?? null;
unset($_SESSION['swal']);

        $this->view('pages/admn_student_verification', get_defined_vars());
    }
}
