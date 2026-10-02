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
$client_id     = '240563055427-f8m83d6t72de5ck1leqrvuduenbghoon.apps.googleusercontent.com';
$client_secret = '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'; // <-- add this from Cloud Console
$redirect_uri  = 'https://eusebianationalhighschool.fwh.is/google_callback.php';
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
        $_SESSION['pending_approval_contact_type'] = 'email'; // Google sign-in is always email-based
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

// ── Step 4: NEW STUDENT — Google only verifies their identity here.
//    They must still complete the actual registration form (personal info,
//    address, contact number, password, terms) before an account exists.
//    We stash the Google-verified email/name in session so the form can
//    prefill and lock the email, then let student_registration.php handle
//    the real INSERT via the normal create_student() flow. ──────────────
$_SESSION['google_pending'] = [
    'email' => $google_email,
    'fname' => $google_fname,
    'lname' => $google_lname,
];
header('Location: student_registration.php');
exit();

    }
}