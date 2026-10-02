<?php
require_once __DIR__ . '/core/init.php';

// Public chat endpoint is served through login.php (?chat=1) because some hosts
// block direct requests to chat_api.php with 403.
if (isset($_GET['chat'])) {
    require_once __DIR__ . '/app/Controllers/ChatApiController.php';
    (new ChatApiController())->index();
    exit;
}

require_once __DIR__ . '/app/Controllers/LoginController.php';
(new LoginController())->index();
