<?php
/**
 * Minimal CSRF token helper.
 * Include this after session_start() on any page that has a POST form,
 * and on the page/endpoint that handles that POST.
 */

function csrf_token() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Echoes a ready-to-use hidden input. Drop this inside every <form method="post">.
 */
function csrf_field() {
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '">';
}

/**
 * Call this as the FIRST thing inside any POST handler (top of login(), a CRUD
 * function, etc.) before touching $_POST data. Kills the request on mismatch.
 */
function csrf_verify() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $submitted = $_POST['csrf_token'] ?? '';
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $submitted)) {
        http_response_code(403);
        die('Invalid or expired form submission. Please go back and try again.');
    }
}
