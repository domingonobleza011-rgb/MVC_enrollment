<?php

class PendingApprovalController extends Controller
{
    public function index()
    {
error_reporting(E_ALL ^ E_WARNING);
session_start();

$name = $_SESSION['pending_approval_name'] ?? '';
unset($_SESSION['pending_approval_name']);

$contact_type = $_SESSION['pending_approval_contact_type'] ?? 'email';
unset($_SESSION['pending_approval_contact_type']);

        $this->view('pages/pending_approval', get_defined_vars());
    }
}
