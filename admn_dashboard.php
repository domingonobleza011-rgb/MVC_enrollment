<?php
require_once __DIR__ . '/core/init.php';
require_once __DIR__ . '/app/Controllers/AdmnDashboardController.php';
(new AdmnDashboardController())->index();
