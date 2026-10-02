<?php

/**
 * AdmnMessagesApiController
 * ---------------------------------------------------------------------
 * Admin-only JSON endpoint used by admn_messages.php and the sidebar
 * notification bell.
 *
 *   GET  admn_messages_api.php?action=list&q=
 *   GET  admn_messages_api.php?action=thread&id=&after=
 *   GET  admn_messages_api.php?action=summary
 *   POST admn_messages_api.php  action=reply|delete  (+ csrf_token)
 */
class AdmnMessagesApiController extends Controller
{
    public function index()
    {
        error_reporting(0);
        require_once(HELPERS_PATH . '/csrf.php');
        require_once(MODELS_PATH . '/main.class.php');
        $eusebia->validate_admin();

        header('Content-Type: application/json');
        header('Cache-Control: no-store');
        ob_start();

        try {
            $this->handle($eusebia);
        } catch (Throwable $e) {
            while (ob_get_level() > 0) { ob_end_clean(); }
            http_response_code(500);
            header('Content-Type: application/json');
            while (ob_get_level() > 0) { ob_end_clean(); } echo json_encode(['ok' => false, 'error' => 'Server error. Please try again.']);
        }
    }

    private function handle($eusebia)
    {
        $action = $_POST['action'] ?? $_GET['action'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            csrf_verify();
            if ($action === 'reply') {
                while (ob_get_level() > 0) { ob_end_clean(); } echo json_encode($eusebia->chat_admin_reply((int)($_POST['id'] ?? 0), $_POST['message'] ?? ''));
                exit;
            }
            if ($action === 'delete') {
                while (ob_get_level() > 0) { ob_end_clean(); } echo json_encode($eusebia->chat_admin_delete((int)($_POST['id'] ?? 0)));
                exit;
            }
        } else {
            if ($action === 'list') {
                while (ob_get_level() > 0) { ob_end_clean(); } echo json_encode(['ok' => true, 'conversations' => $eusebia->chat_admin_list($_GET['q'] ?? '')]);
                exit;
            }
            if ($action === 'thread') {
                while (ob_get_level() > 0) { ob_end_clean(); } echo json_encode($eusebia->chat_admin_thread((int)($_GET['id'] ?? 0), (int)($_GET['after'] ?? 0)));
                exit;
            }
            if ($action === 'summary') {
                while (ob_get_level() > 0) { ob_end_clean(); } echo json_encode(['ok' => true] + $eusebia->chat_unread_summary(5));
                exit;
            }
        }

        http_response_code(400);
        while (ob_get_level() > 0) { ob_end_clean(); } echo json_encode(['ok' => false, 'error' => 'Bad request']);
    }
}
