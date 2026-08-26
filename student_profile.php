<?php
require_once __DIR__ . '/core/init.php';
require_once __DIR__ . '/app/Controllers/StudentProfileController.php';
(new StudentProfileController())->index();
