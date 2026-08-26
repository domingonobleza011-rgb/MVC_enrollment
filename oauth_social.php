<?php
require_once __DIR__ . '/core/init.php';
require_once __DIR__ . '/app/Controllers/OauthSocialController.php';
(new OauthSocialController())->index();
