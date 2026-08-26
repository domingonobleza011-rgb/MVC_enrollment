<?php

class VerifyEmailController extends Controller
{
    public function index()
    {
error_reporting(E_ALL ^ E_WARNING);
session_start();

require_once(MODELS_PATH . '/conn.php');
require_once(MODELS_PATH . '/main.class.php'); // provides $eusebia

// Must have arrived here from google_callback.php with a pending id.
if (empty($_SESSION['pending_verify_id'])) {
    header('Location: login.php');
    exit();
}

$id_student = (int) $_SESSION['pending_verify_id'];

$stmt = $conn->prepare("SELECT fname, lname, email FROM tbl_student WHERE id_student = ? LIMIT 1");
$stmt->execute([$id_student]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    unset($_SESSION['pending_verify_id']);
    header('Location: login.php');
    exit();
}

$message      = '';
$message_type = '';

// Mask the email for display, e.g. jo***@gmail.com
$email_display = $student['email'];
if (strpos($email_display, '@') !== false) {
    [$local, $domain] = explode('@', $email_display, 2);
    $email_display = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 1)) . '@' . $domain;
}

if (isset($_POST['resend_code'])) {
    $result = $eusebia->generate_and_send_verification_code($id_student);
    if ($result['success']) {
        $message      = 'A new code has been sent to your email.';
        $message_type = 'success';
    } else {
        $message      = 'Could not send the code. Please try again in a moment.';
        $message_type = 'danger';
    }
}

if (isset($_POST['verify_code'])) {
    $code_input = trim($_POST['code'] ?? '');
    $result = $eusebia->verify_student_email_code($id_student, $code_input);

    if ($result['success']) {
        unset($_SESSION['pending_verify_id']);
        $_SESSION['pending_approval_name'] = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
        header('Location: pending_approval.php');
        exit();
    } else {
        $message      = $result['error'];
        $message_type = 'danger';
    }
}

        $this->view('pages/verify_email', get_defined_vars());
    }
}
