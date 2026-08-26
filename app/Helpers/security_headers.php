<?php
/**
 * Sends standard security headers. Include this at the very top of every
 * page, before any HTML output (right after session_start()/require calls).
 *
 * require_once(HELPERS_PATH . '/security_headers.php');
 */

// Prevents the page from being loaded in an <iframe> on another site (clickjacking).
header('X-Frame-Options: DENY');

// Stops browsers from guessing/sniffing a different MIME type than declared.
header('X-Content-Type-Options: nosniff');

// Only send the origin (not full URL/query string) in the Referer header on cross-site requests.
header('Referrer-Policy: strict-origin-when-cross-origin');

// Disables browser features this app doesn't use.
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

// Forces HTTPS for a year once a browser has seen it once on your live domain.
// Safe to leave in for local Laragon (http://) — browsers ignore HSTS over plain http.
if (($_SERVER['HTTPS'] ?? '') === 'on') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

// Content-Security-Policy: restricts where scripts/styles/images can load from.
// Adjust the domains below if you add new CDNs later.
header("Content-Security-Policy: " .
    "default-src 'self'; " .
    "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; " .
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; " .
    "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
    "img-src 'self' data: https:; " .
    "connect-src 'self' https://accounts.google.com https://www.facebook.com; " .
    "frame-ancestors 'none';"
);
