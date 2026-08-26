<?php

class ResetPasswordController extends Controller
{
    public function index()
    {
error_reporting(E_ALL ^ E_WARNING);
session_start();

require_once(MODELS_PATH . '/conn.php');

$token   = trim($_GET['token'] ?? '');
$message = '';
$message_type = '';
$valid_token  = false;
$student_email = '';
$account_type  = 'student';

// ── Validate token ────────────────────────────────────────────────────────────
if (empty($token)) {
    $message = 'Invalid or missing reset link. Please request a new one.';
    $message_type = 'danger';
} else {
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1");
    $stmt->execute([$token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reset) {
        $message = 'This reset link is invalid or has expired. Please request a new one.';
        $message_type = 'danger';
    } else {
        $valid_token    = true;
        $student_email = $reset['email'];
        $account_type  = $reset['account_type'] ?? 'student';
    }
}

// ── Handle password reset submission ─────────────────────────────────────────
if (isset($_POST['do_reset']) && $valid_token) {
    $new_password    = $_POST['new_password']    ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($new_password)) {
        $message = 'Please enter a new password.';
        $message_type = 'danger';
    } elseif (strlen($new_password) < 6) {
        $message = 'Password must be at least 6 characters.';
        $message_type = 'danger';
    } elseif ($new_password !== $confirm_password) {
        $message = 'Passwords do not match.';
        $message_type = 'danger';
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in whichever table this account actually lives in.
        $table_map = [
            'admin'   => 'tbl_admin',
            'staff'   => 'tbl_user',
            'student' => 'tbl_student',
        ];
        $table = $table_map[$account_type] ?? 'tbl_student';

        $stmt = $conn->prepare("UPDATE `{$table}` SET password = ? WHERE email = ?");
        $updated = $stmt->execute([$hashed, $student_email]);

        if ($updated && $stmt->rowCount() > 0) {
            // Delete used token
            $conn->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

            $message = 'Your password has been reset successfully! You can now log in.';
            $message_type = 'success';
            $valid_token  = false; // hide form
        } else {
            $message = 'Something went wrong. Please try again.';
            $message_type = 'danger';
        }
    }
}

        $this->view('pages/reset_password', get_defined_vars());
    }
}
