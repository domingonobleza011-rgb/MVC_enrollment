<?php

class AdmnPromotionRequestsController extends Controller
{
    public function index()
    {
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);
require(MODELS_PATH . '/student.class.php');

$userdetails = $eusebia->get_userdata();
$eusebia->validate_admin();

// Handle POSTs
$eusebia->admin_approve_promotion_request();
$eusebia->admin_reject_promotion_request();
$eusebia->admin_bulk_delete_promotion_requests();

$status_filter = $_GET['status'] ?? '';
$requests = $eusebia->admin_get_promotion_requests($status_filter);

$swal = $_SESSION['swal'] ?? null;
unset($_SESSION['swal']);

        $this->view('pages/admn_promotion_requests', get_defined_vars());
    }
}
