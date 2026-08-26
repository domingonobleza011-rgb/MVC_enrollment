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

    // Handle the settings form submit (enrollment_open toggle + per-grade capacity)
    $eusebia->save_enrollment_settings();

    // Current values to populate the form
    $enrollment_open = $eusebia->is_enrollment_open();

    $grades = [
        'seven'  => 'Grade 7',
        'eight'  => 'Grade 8',
        'nine'   => 'Grade 9',
        'ten'    => 'Grade 10',
        'eleven' => 'Grade 11',
        'twelve' => 'Grade 12',
    ];
    $capacities = [];
    foreach ($grades as $key => $label) {
        $capacities[$key] = $eusebia->get_capacity($key); // null = unlimited
    }

        $this->view('pages/admn_settings', get_defined_vars());
    }
}
