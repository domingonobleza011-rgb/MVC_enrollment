<?php

class LogoutController extends Controller
{
    public function index()
    {
 
    require_once(MODELS_PATH . '/main.class.php');
    $eusebia->logout();

    // Make sure logout.php itself is never cached/bfcache'd either.
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    header("Location: index.php");
    exit();

    }
}
