<?php

/**
 * StudentMessagesApiController
 * ---------------------------------------------------------------------
 * Student-only JSON endpoint behind student_messages.php.
 *   GET  student_messages_api.php?action=fetch&after=
 *   POST student_messages_api.php  action=send  message  csrf_token
 * The conversation is always the logged-in student's own (identity 's<id>'),
 * never taken from the request, so one student can't read another's thread.
 */
class StudentMessagesApiController extends Controller
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
        require_once(HELPERS_PATH . '/csrf.php');
        require_once(MODELS_PATH . '/main.class.php');

        try {
            $userdetails = $eusebia->validate_student();
            $ident = $eusebia->chat_student_ident($userdetails['id_student']);
            $action = $_POST['action'] ?? $_GET['action'] ?? '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'send') {
                csrf_verify();
                $this->respond($eusebia->chat_visitor_send('', '', '', $_POST['message'] ?? '', $ident));
            }
            if ($action === 'fetch') {
                $this->respond($eusebia->chat_visitor_fetch('', (int)($_GET['after'] ?? 0), $ident));
            }
            $this->respond(['ok' => false, 'error' => 'Bad request'], 400);
        } catch (Throwable $e) {
            $this->respond(['ok' => false, 'error' => 'Could not complete the request. Please try again.'], 500);
        }
    }
}
