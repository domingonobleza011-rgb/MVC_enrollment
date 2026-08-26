<?php

class NotificationsStaffMarkReadController extends Controller
{
    public function index()
    {
/**
 * AJAX endpoint: marks the logged-in teacher's notifications as read.
 * Called from staff_sidebar_start.php when the notification bell is opened.
 */
error_reporting(E_ALL ^ E_WARNING);
require(MODELS_PATH . '/student.class.php');
header('Content-Type: application/json');

$userdetails = $eusebia->get_userdata();
$id_user     = $userdetails['id_user'] ?? null;

if ($id_user) {
    $eusebia->mark_all_staff_notifications_read($id_user);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
}

    }
}
