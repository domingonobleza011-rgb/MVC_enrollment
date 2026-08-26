<?php

class GoogleCallbackController extends Controller
{
    public function index()
    {
/**
 * google_callback.php
 * -------------------------------------------------------
 * Place in ROOT of your project (same folder as index.php / login.php).
 * 
 * Google redirects here after user approves the consent screen.
 * This file:
 *   1. Exchanges the code for an access token
 *   2. Fetches the Google profile (name + email)
 *   3. If email found in tbl_student  → logs them in
 *   4. If email NOT found              → auto-registers in tbl_student, then logs in
 *   5. Redirects to student_homepage.php
 */

session_start();

// ── Database connection ───────────────────────────────────────────────────────
require_once(MODELS_PATH . '/conn.php');       // provides $conn (PDO)
require_once(MODELS_PATH . '/main.class.php'); // EUSEBIAClass (has set_userdata)

// ── Your Google OAuth credentials (from Google Cloud Console) ────────────────
$client_id     = '240563055427-rjbnika18eosfvn9m7mepdr4uumrr10n.apps.googleusercontent.com';
$client_secret = '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'; // <-- add this from Cloud Console
$redirect_uri  = 'https://eusebianationalhighschool.gt.tc/google_callback.php';
// ─────────────────────────────────────────────────────────────────────────────

// Error from Google (user cancelled, etc.)
if (isset($_GET['error'])) {
    $_SESSION['google_error'] = 'Google login was cancelled or failed: ' . htmlspecialchars($_GET['error']);
    header('Location: login.php');
    exit();
}

// No code = bad redirect
if (empty($_GET['code'])) {
    $_SESSION['google_error'] = 'Google login failed: no authorization code received.';
    header('Location: login.php');
    exit();
}

// ── Step 1: Exchange code for access token ────────────────────────────────────
$token_url  = 'https://oauth2.googleapis.com/token';
$post_data  = http_build_query([
    'code'          => $_GET['code'],
    'client_id'     => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri'  => $redirect_uri,
    'grant_type'    => 'authorization_code',
]);

$context = stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $post_data,
        'timeout' => 10,
    ],
]);

$token_response = @file_get_contents($token_url, false, $context);
$token_data     = json_decode($token_response, true);

if (empty($token_data['access_token'])) {
    $_SESSION['google_error'] = 'Google login failed: could not obtain access token. Please try again.';
    header('Location: login.php');
    exit();
}

// ── Step 2: Fetch Google user profile ────────────────────────────────────────
$profile_context = stream_context_create([
    'http' => [
        'method'  => 'GET',
        'header'  => "Authorization: Bearer " . $token_data['access_token'] . "\r\n",
        'timeout' => 10,
    ],
]);

$profile_response = @file_get_contents('https://www.googleapis.com/oauth2/v2/userinfo', false, $profile_context);
$profile          = json_decode($profile_response, true);

if (empty($profile['email'])) {
    $_SESSION['google_error'] = 'Google login failed: could not retrieve your Google profile.';
    header('Location: login.php');
    exit();
}

// ── Extract profile data ──────────────────────────────────────────────────────
$google_email  = trim($profile['email']);
$google_fname  = $profile['given_name']  ?? '';
$google_lname  = $profile['family_name'] ?? '';

$eusebia = new EUSEBIAClass();

// ── Step 3a: Check ADMIN first (mirrors the password-login lookup order) ─────
$stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE email = ? LIMIT 1");
$stmt->execute([$google_email]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    $eusebia->set_userdata($admin);
    header('Location: admn_dashboard.php');
    exit();
}

// ── Step 3b: Check STAFF/TEACHER — catches accounts promoted from student to staff ──
$stmt = $conn->prepare("SELECT * FROM tbl_user WHERE email = ? LIMIT 1");
$stmt->execute([$google_email]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

if ($staff) {
    $eusebia->set_userdata($staff);
    header('Location: staff_dashboard.php');
    exit();
}

// ── Step 3c: Check if student already exists ──────────────────────────────────
$stmt = $conn->prepare("SELECT * FROM tbl_student WHERE email = ? LIMIT 1");
$stmt->execute([$google_email]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if ($student) {
    // ── EXISTING: route by verification / approval status ────────────────────
    $vstatus         = $eusebia->get_student_verification_status($student['id_student']);
    $email_verified  = $vstatus['email_verified']  ?? 1;
    $approval_status = $vstatus['approval_status'] ?? 'approved';

    if ((int) $email_verified === 0) {
        // Registered before but never finished entering the code — resend it.
        $eusebia->generate_and_send_verification_code($student['id_student']);
        $_SESSION['pending_verify_id'] = $student['id_student'];
        header('Location: verify_email.php');
        exit();
    }

    if ($approval_status === 'pending') {
        $_SESSION['pending_approval_name'] = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
        header('Location: pending_approval.php');
        exit();
    }

    if ($approval_status === 'rejected') {
        $_SESSION['google_error'] = 'Your account registration was not approved. Please visit the school for more information.';
        header('Location: login.php');
        exit();
    }

    // approved → log in as normal
    $eusebia->set_userdata($student);
    header('Location: student_homepage.php');
    exit();
}

// ── Step 4: NEW STUDENT — auto-register, then require email code + admin approval ──
try {
    $stmt = $conn->prepare("
        INSERT INTO tbl_student (
            `email`, `phone_number`, `password`,
            `lname`, `fname`, `mi`,
            `age`, `sex`, `status`,
            `houseno`, `street`, `brgy`, `municipal`,
            `contact`, `bdate`, `bplace`, `nationality`,
            `addedby`
        ) VALUES (
            ?, NULL, ?,
            ?, ?, '',
            0, '', '',
            '', '', '', '',
            '', '', '', '',
            'Google'
        )
    ");

    // Random secure password — login is via Google so it will never be used directly
    $random_password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

    $stmt->execute([
        $google_email,
        $random_password,
        $google_lname,
        $google_fname,
    ]);

    $new_id = $conn->lastInsertId();

    // NOT logged in yet — they must verify their email, then wait for admin approval.
    $eusebia->generate_and_send_verification_code($new_id);
    $_SESSION['pending_verify_id'] = $new_id;
    header('Location: verify_email.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['google_error'] = 'Registration error: ' . $e->getMessage();
    header('Location: login.php');
    exit();
}

    }
}
