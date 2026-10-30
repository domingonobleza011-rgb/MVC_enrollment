<?php

class NotificationsMarkReadController extends Controller
{
    public function index()
    {
/**
 * AJAX endpoint: deletes the notifications the student just opened (ids[] posted by the bell).
 * Falls back to marking everything read if no ids are sent.
 * Called from student_navbar.php when the notification bell is opened.
 */
error_reporting(E_ALL ^ E_WARNING);
require(MODELS_PATH . '/student.class.php');
header('Content-Type: application/json');

$userdetails = $eusebia->get_userdata();
$id_student  = $userdetails['id_student'] ?? null;

if ($id_student) {
    // Opened notifications are deleted: remove exactly the ones the student was shown.
    $ids = isset($_POST['ids']) && is_array($_POST['ids']) ? $_POST['ids'] : [];
    if (!empty($ids)) {
        $eusebia->delete_notifications($id_student, $ids);
    } else {
        $eusebia->mark_all_notifications_read($id_student);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
}

    }
}
