<?php

class AdmnManageAdminsController extends Controller
{
    public function index()
    {
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/main.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    // Add Admin form (modal on this page). Admin-only: validate_admin() has already run.
    $eusebia->create_admin();

    // Fetch all administrator accounts saved in the system
    $connection = $eusebia->openConn();
    $stmt = $connection->prepare("SELECT * FROM tbl_admin ORDER BY lname ASC, fname ASC");
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('pages/admn_manage_admins', get_defined_vars());
    }
}
