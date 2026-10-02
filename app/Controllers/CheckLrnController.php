<?php

class CheckLrnController extends Controller
{
    public function index()
    {
// AJAX: check if LRN is already taken
// For old/transferee students moving to grade 8:
//   - Their LRN exists in a previous grade table — that's fine
//   - Block only if they're already enrolled in tbl_eight
//
// A LRN found in a grade-level table can be in one of these states:
//   - Approved  -> the LRN is already registered
//   - Pending   -> the LRN's application is still being processed
//   - Rejected  -> does NOT block re-registration
header('Content-Type: application/json');
error_reporting(0);
require MODELS_PATH . '/conn.php';

$lrn          = trim($_GET['lrn'] ?? '');
$student_type = trim($_GET['student_type'] ?? 'new');   // new | old | transferee
$source_table = trim($_GET['source_table'] ?? '');      // table their LRN came from (e.g. tbl_seven)

// The grade the student is actually enrolling INTO right now (e.g. tbl_nine).
// Defaults to tbl_eight to keep the original grade8.php behavior unchanged
// for any caller that doesn't pass this explicitly.
$valid_targets = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
$target_table  = trim($_GET['target_table'] ?? 'tbl_eight');
if (!in_array($target_table, $valid_targets, true)) {
    $target_table = 'tbl_eight';
}

if ($lrn === '') {
    echo json_encode(['taken' => false, 'status' => null, 'message' => null]);
    exit;
}

$all_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];

// Looks up the LRN in a single grade table and returns its enrollment_status
// ('Approved' or 'Pending'; Rejected rows are ignored so they don't block
// re-registration), or null if the LRN isn't present in a blocking state.
$lookupStatus = function ($conn, $table, $lrn) {
    try {
        $stmt = $conn->prepare(
            "SELECT enrollment_status FROM `{$table}`
             WHERE `lrn` = ?
               AND (is_archived = 0 OR is_archived IS NULL)
               AND (enrollment_status IS NULL OR enrollment_status IN ('Approved','Pending'))
             ORDER BY FIELD(enrollment_status, 'Approved', 'Pending')
             LIMIT 1"
        );
        $stmt->execute([$lrn]);
        $status = $stmt->fetchColumn();
        if ($status === false) return null;
        // Column defaults to 'Pending' — treat NULL/empty the same way.
        return $status ?: 'Pending';
    } catch (Exception $e) {
        return null;
    }
};

$buildResponse = function ($status) {
    if ($status === 'Approved') {
        return [
            'taken'   => true,
            'status'  => 'approved',
            'message' => 'LRN already registered.',
        ];
    }
    if ($status === 'Pending') {
        return [
            'taken'   => true,
            'status'  => 'pending',
            'message' => 'LRN already registered and is in pending process.',
        ];
    }
    return ['taken' => false, 'status' => null, 'message' => null];
};

if ($student_type === 'old' || $student_type === 'transferee') {
    // Only check the target grade — old/transferee students are ALLOWED to
    // have their LRN sitting in a previous grade table already.
    $status = $lookupStatus($conn, $target_table, $lrn);
    echo json_encode($buildResponse($status));
    exit;
}

// New student: LRN must not exist (Approved/Pending) in any grade level table
$status = null;
foreach ($all_tables as $tbl) {
    $status = $lookupStatus($conn, $tbl, $lrn);
    if ($status !== null) { break; }
}

echo json_encode($buildResponse($status));
$conn = null;

    }
}
