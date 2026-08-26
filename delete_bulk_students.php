<?php
require_once __DIR__ . '/core/init.php';
require_once __DIR__ . '/app/Controllers/DeleteBulkStudentsController.php';
(new DeleteBulkStudentsController())->index();
