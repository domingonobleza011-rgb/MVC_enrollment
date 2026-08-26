<?php

class NotificationDeleteController extends Controller
{
    public function index()
    {
/**
 * AJAX endpoint: deletes one of the logged-in student's own notifications.
 * Called from student_navbar.php when the delete (×) button on a
 * notification item is clicked.
 */
error_reporting(E_ALL ^ E_WARNING);
require(MODELS_PATH . '/student.class.php');
header('Content-Type: application/json');

$userdetails    = $eusebia->get_userdata();
$id_student     = $userdetails['id_student'] ?? null;
$id_notification = $_POST['id_notification'] ?? null;

if (!$id_student) {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
    exit();
}
if (!$id_notification) {
    echo json_encode(['success' => false, 'error' => 'Missing notification id.']);
    exit();
}

$deleted = $eusebia->delete_notification($id_student, $id_notification);
echo json_encode(['success' => $deleted]);

    }
}
