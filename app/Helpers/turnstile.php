<?php
/**
 * Cloudflare Turnstile helper.
 *
 *   require_once(HELPERS_PATH . '/turnstile.php');
 *   turnstile_widget();                 // inside a <form>, echoes the widget
 *   turnstile_script();                 // once per page, echoes the api.js tag
 *   if (!turnstile_verify()) { ... }    // in the POST handler
 */

require_once(MODELS_PATH . '/turnstile_config.php');

function turnstile_script() {
    echo '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>';
}

function turnstile_widget() {
    echo '<div class="cf-turnstile" data-sitekey="' . htmlspecialchars(TURNSTILE_SITE_KEY) . '" data-theme="light"></div>';
}

/**
 * Verifies the token Turnstile put in $_POST['cf-turnstile-response'].
 * Tokens are single-use, so call this once per submission.
 * Fails closed: any network/parse error counts as a failed check.
 */
function turnstile_verify() {
    $token = $_POST['cf-turnstile-response'] ?? '';
    if ($token === '' || strlen($token) > 2048) {
        return false;
    }

    $fields = http_build_query([
        'secret'   => TURNSTILE_SECRET_KEY,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
    ]);
    $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $body = false;

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $fields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);
        $body = curl_exec($ch);
        curl_close($ch);
    }

    // Fallback for hosts that block curl (e.g. some free hosting).
    if ($body === false || $body === null) {
        $ctx = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => $fields,
            'timeout' => 10,
        ]]);
        $body = @file_get_contents($url, false, $ctx);
    }

    $result = $body ? json_decode($body, true) : null;
    return is_array($result) && !empty($result['success']);
}
