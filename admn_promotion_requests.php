<?php
require_once __DIR__ . '/core/init.php';
require_once __DIR__ . '/app/Controllers/AdmnPromotionRequestsController.php';
(new AdmnPromotionRequestsController())->index();
