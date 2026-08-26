<?php
require_once __DIR__ . '/core/init.php';
require_once __DIR__ . '/app/Controllers/AdmnSettingsController.php';
(new AdmnSettingsController())->index();
