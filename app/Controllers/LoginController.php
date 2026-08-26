<?php

class LoginController extends Controller
{
    public function index()
    {
 

ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION)) {
    $showdate = date("Y-m-d");
    date_default_timezone_set('Asia/Manila');
    $showtime = date("h:i:a");
    $_SESSION['storedate'] = $showdate;
    $_SESSION['storetime'] = $showdate;
    session_start();
}

require(MODELS_PATH . '/main.class.php');
$eusebia->login();

        $this->view('pages/login', get_defined_vars());
    }
}
