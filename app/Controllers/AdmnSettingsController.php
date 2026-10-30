<?php

class AdmnSettingsController extends Controller
{
    public function index()
    {
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/main.class.php');
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    // Handle the settings form submit (enrollment_open toggle + schedule + per-grade capacity)
    $eusebia->save_enrollment_settings();

    // Current values to populate the form
    $manual_enrollment_open = $eusebia->is_enrollment_manually_enabled();
    $enrollment_schedule    = $eusebia->get_enrollment_schedule();
    $enrollment_open        = $eusebia->is_enrollment_open();

        $this->view('pages/admn_settings', get_defined_vars());
    }
}
