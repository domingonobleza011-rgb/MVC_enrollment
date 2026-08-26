<?php

class AdmnCrudController extends Controller
{
    public function index()
    {
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require(MODELS_PATH . '/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_staff();
    $staffbmis->create_staff();
    $upstaff = $staffbmis->update_staff();
    $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_staff();
    

        $this->view('pages/admn_crud', get_defined_vars());
    }
}
