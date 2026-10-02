<?php

require_once(PHPMAILER_PATH . '/Exception.php');
require_once(PHPMAILER_PATH . '/PHPMailer.php');
require_once(PHPMAILER_PATH . '/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordController extends Controller
{
    public function index()
    {
error_reporting(E_ALL ^ E_WARNING);
session_start();

require_once(MODELS_PATH . '/conn.php');

$message      = '';
$message_type = '';

// ---- Phone number + security question recovery (students only) ----------
$active_tab     = 'email';
$phone_step     = 'phone';   // 'phone' | 'answer' | 'done'
$phone_question = null;
$phone_message  = '';
$phone_message_type = '';

// ---- Email + security question recovery (students only, instant path) --
$email_step     = 'email';   // 'email' | 'answer' | 'done'
$email_question = null;
$email_message  = '';
$email_message_type = '';

if (isset($_POST['phone_lookup'])) {
    $active_tab = 'phone';
    require_once(MODELS_PATH . '/student.class.php');

    $phone = trim($_POST['phone'] ?? '');
    if ($phone === '') {
        $phone_message = 'Please enter your phone number.';
        $phone_message_type = 'danger';
    } else {
        $result = $studenteusebia->forgot_password_lookup_phone($phone);
        if ($result['found']) {
            $phone_step     = 'answer';
            $phone_question = $result['question'];
        } else {
            $phone_message = "We couldn't find a student account with that phone number and a security question set. Try the Email tab instead, or contact the registrar.";
            $phone_message_type = 'danger';
        }
    }
}

if (isset($_POST['phone_reset'])) {
    $active_tab = 'phone';
    require_once(MODELS_PATH . '/student.class.php');

    $answer        = $_POST['security_answer'] ?? '';
    $newpassword   = $_POST['newpassword'] ?? '';
    $checkpassword = $_POST['checkpassword'] ?? '';

    $result = $studenteusebia->forgot_password_reset_via_phone($answer, $newpassword, $checkpassword);

    if ($result['success']) {
        $phone_step = 'done';
        $phone_message = $result['message'];
        $phone_message_type = 'success';
    } else {
        $phone_message = $result['message'];
        $phone_message_type = 'danger';

        // Re-show the answer step with the same question, unless the
        // recovery session itself expired — then send them back to step 1.
        $id_student = $_SESSION['pwd_recovery_student_id'] ?? null;
        $phone_question = $id_student ? $studenteusebia->get_current_security_question($id_student) : null;
        $phone_step = $phone_question ? 'answer' : 'phone';
    }
}

if (isset($_POST['email_reset'])) {
    $active_tab = 'email';
    require_once(MODELS_PATH . '/student.class.php');

    $answer        = $_POST['security_answer'] ?? '';
    $newpassword   = $_POST['newpassword'] ?? '';
    $checkpassword = $_POST['checkpassword'] ?? '';

    $result = $studenteusebia->forgot_password_reset_via_email($answer, $newpassword, $checkpassword);

    if ($result['success']) {
        $email_step = 'done';
        $email_message = $result['message'];
        $email_message_type = 'success';
    } else {
        $email_message = $result['message'];
        $email_message_type = 'danger';

        // Re-show the answer step with the same question, unless the
        // recovery session itself expired — then send them back to step 1.
        $id_student = $_SESSION['pwd_recovery_student_id'] ?? null;
        $email_question = $id_student ? $studenteusebia->get_current_security_question($id_student) : null;
        $email_step = $email_question ? 'answer' : 'email';
    }
}

if (isset($_POST['send_reset'])) {
    $active_tab = 'email';
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $message = 'Please enter your email address.';
        $message_type = 'danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $message_type = 'danger';
    } else {
        // If this email belongs to a student who has a security question set
        // up, offer an instant reset via that question instead of making
        // them wait on an emailed link.
        require_once(MODELS_PATH . '/student.class.php');
        $sq_result = $studenteusebia->forgot_password_lookup_email($email);

        if ($sq_result['found']) {
            $email_step     = 'answer';
            $email_question = $sq_result['question'];
        } else {
        // Ensure the reset-tracking table (and its account_type column) exists.
        // Lazily created/upgraded so this works even if the table predates this change.
        try {
            $conn->exec("CREATE TABLE IF NOT EXISTS password_resets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(190) NOT NULL,
                token VARCHAR(64) NOT NULL,
                account_type VARCHAR(20) NOT NULL DEFAULT 'student',
                expires_at DATETIME NOT NULL,
                INDEX (email), INDEX (token)
            )");
        } catch (PDOException $e) {}
        try { $conn->exec("ALTER TABLE password_resets ADD COLUMN account_type VARCHAR(20) NOT NULL DEFAULT 'student'"); } catch (PDOException $e) {}

        // Check the same three account tables login() checks, in the same order,
        // so a password reset works for admins and staff too, not just students.
        $account_type = null;
        $fname = $lname = '';

        $stmt = $conn->prepare("SELECT fname, lname FROM tbl_admin WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $account_type = 'admin'; $fname = $row['fname']; $lname = $row['lname'];
        }

        if (!$account_type) {
            $stmt = $conn->prepare("SELECT fname, lname FROM tbl_user WHERE email = ? AND role = 'staff' LIMIT 1");
            $stmt->execute([$email]);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $account_type = 'staff'; $fname = $row['fname']; $lname = $row['lname'];
            }
        }

        if (!$account_type) {
            $stmt = $conn->prepare("SELECT fname, lname FROM tbl_student WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $account_type = 'student'; $fname = $row['fname']; $lname = $row['lname'];
            }
        }

        if ($account_type) {
            $token      = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $conn->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);
            $conn->prepare("INSERT INTO password_resets (email, token, account_type, expires_at) VALUES (?, ?, ?, ?)")
                 ->execute([$email, $token, $account_type, $expires_at]);

            $reset_link = 'https://eusebianationalhighschool.gt.tc/reset_password.php?token=' . $token;
            $name       = htmlspecialchars($fname . ' ' . $lname);

            // ── PHPMailer via Gmail SMTP ──────────────────────────────────
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'eusebiahighschool@gmail.com';
                $mail->Password   = 'ilfb ajcy gaiy iybg';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('eusebiahighschool@gmail.com', 'EPAMHS Portal');
                $mail->addAddress($email, $name);
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset - EPAMHS Portal';
                $mail->Body    = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; background:#f0f4fe; margin:0; padding:0; }
  .wrap { max-width:520px; margin:40px auto; background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,.1); }
  .header { background:linear-gradient(135deg,#0b2b5c,#1f5a9e); padding:32px 28px; text-align:center; }
  .header img { width:70px; height:70px; border-radius:50%; background:#fff; padding:8px; }
  .header h2 { color:#fff; font-size:20px; margin:14px 0 4px; }
  .header p  { color:rgba(255,255,255,.75); font-size:13px; margin:0; }
  .body { padding:32px 28px; }
  .body p { color:#334155; font-size:15px; line-height:1.7; margin:0 0 18px; }
  .btn-wrap { text-align:center; margin:28px 0; }
  .btn { display:inline-block; background:linear-gradient(135deg,#0b2b5c,#1f5a9e); color:#fff !important;
         text-decoration:none; padding:14px 36px; border-radius:40px; font-size:15px; font-weight:600; }
  .link-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:12px 16px;
              font-size:12px; color:#64748b; word-break:break-all; margin-bottom:18px; }
  .footer { background:#f8fafc; border-top:1px solid #e2e8f0; padding:18px 28px; text-align:center;
            font-size:12px; color:#94a3b8; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <img src="https://eusebianationalhighschool.gt.tc/icons/Documents/eusebia.png" alt="School Seal">
    <h2>EPAMHS Portal</h2>
    <p>Eusebia Paz Arroyo Memorial National High School</p>
  </div>
  <div class="body">
    <p>Hello <strong>' . $name . '</strong>,</p>
    <p>We received a request to reset your EPAMHS Portal password. Click the button below to set a new password. This link expires in <strong>1 hour</strong>.</p>
    <div class="btn-wrap">
      <a href="' . $reset_link . '" class="btn">Reset My Password</a>
    </div>
    <p>Or copy and paste this link into your browser:</p>
    <div class="link-box">' . $reset_link . '</div>
    <p>If you did not request a password reset, you can safely ignore this email. Your password will not change.</p>
    <p style="margin:0;">– EPAMHS Portal Team</p>
  </div>
  <div class="footer">
    &copy; ' . date('Y') . ' Eusebia Paz Arroyo Memorial National High School &bull; Buluang, Baao, Camarines Sur
  </div>
</div>
</body>
</html>';
                $mail->AltBody = "Hello $name,\n\nReset your EPAMHS password here (expires in 1 hour):\n\n$reset_link\n\nIf you did not request this, ignore this email.\n\n– EPAMHS Portal Team";

                $mail->send();
                $message      = 'A password reset link has been sent to your email. Please check your inbox (and spam folder).';
                $message_type = 'success';

            } catch (Exception $e) {
                // Log error silently, show generic success to user (security)
                error_log('Mailer Error: ' . $mail->ErrorInfo);
                $message      = 'A password reset link has been sent to your email. Please check your inbox (and spam folder).';
                $message_type = 'success';
            }
        } else {
            // Same message whether found or not (prevents email enumeration)
            $message      = 'If that email is registered, a password reset link has been sent. Please check your inbox (and spam folder).';
            $message_type = 'success';
        }
        }
    }
}

        $this->view('pages/forgot_password', get_defined_vars());
    }
}
