<?php

class AdmnStaffCrudController extends Controller
{
    public function index()
    {
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/staff.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    $staffeusebia->update_staff();
    $staffeusebia->create_staff();
    $staffeusebia->delete_staff();

    $view       = $staffeusebia->view_staff();
    $staffcount = $staffeusebia->count_staff();

        $this->view('pages/admn_staff_crud', get_defined_vars());
    }
}
