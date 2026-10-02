<?php

class AddAdminController extends Controller
{
    public function index()
    {
        // Adding administrators now lives in the Registered Accounts page (admn_students.php).
        // This old URL used to accept the form without any login check, so it now only
        // redirects (and only for a logged-in admin).
        require(MODELS_PATH . '/main.class.php');
        $eusebia->validate_admin();
        header('Location: admn_students.php');
        exit;
    }
}
