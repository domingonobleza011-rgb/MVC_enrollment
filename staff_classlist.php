<?php
require_once __DIR__ . '/core/init.php';
require_once __DIR__ . '/app/Controllers/StaffClasslistController.php';
(new StaffClasslistController())->index();
