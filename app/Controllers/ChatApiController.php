<?php

/**
 * ChatApiController
 * ---------------------------------------------------------------------
 * Public JSON endpoint behind the "send us a message" chat in the
 * enrollment-closed modal on login.php. No login is required (the
 * visitor was just signed out); a secret conversation token kept in the
 * visitor's browser identifies their thread.
 *
 *   POST chat_api.php  action=send   token?, name?, contact?, message
 *   GET  chat_api.php  action=fetch  token, after
 *
 * Every path answers with clean JSON: stray output (warnings, DB error
 * text, BOMs) is discarded and any exception becomes {ok:false,error}.
 */
class ChatApiController extends Controller
{
    private function respond(array $data, int $code = 200)
    {
        while (ob_get_level() > 0) { ob_end_clean(); }
        http_response_code($code);
        header('Content-Type: application/json');
        header('Cache-Control: no-store');
        echo json_encode($data);
        exit;
    }

    public function index()
    {
        error_reporting(0);
        ob_start();

        try {
            require_once(MODELS_PATH . '/main.class.php');

            $action = $_POST['action'] ?? $_GET['action'] ?? '';

            // Account that just hit the closed-enrollment popup (set server-side at login).
            if (session_status() === PHP_SESSION_NONE) { session_start(); }
            $ident = (isset($_SESSION['ec_identity']) && is_array($_SESSION['ec_identity'])) ? $_SESSION['ec_identity'] : null;
            session_write_close();

            if ($action === 'send' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                // Honeypot: real users never fill this hidden field.
                if (!empty($_POST['hp'])) { $this->respond(['ok' => true]); }
                $this->respond($eusebia->chat_visitor_send(
                    $_POST['token'] ?? '',
                    $_POST['name'] ?? '',
                    $_POST['contact'] ?? '',
                    $_POST['message'] ?? '',
                    $ident
                ));
            }

            if ($action === 'fetch') {
                $this->respond($eusebia->chat_visitor_fetch($_GET['token'] ?? '', (int)($_GET['after'] ?? 0), $ident));
            }

            $this->respond(['ok' => false, 'error' => 'Bad request'], 400);
        } catch (Throwable $e) {
            $this->respond(['ok' => false, 'error' => 'The server could not save your message right now. Please try again later.'], 500);
        }
    }
}
