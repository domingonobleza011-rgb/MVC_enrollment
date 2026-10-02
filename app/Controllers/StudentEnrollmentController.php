<?php

/**
 * StudentEnrollmentController
 * ---------------------------------------------------------------------
 * Full-page, step-by-step replacement for the "Enroll Now" modal that
 * used to live on student_homepage.php. Tapping "Enroll Now" now
 * navigates here instead of opening a modal. Submits to the same
 * enroll_submit.php target as before, so EnrollSubmitController and
 * every create_seven()...create_twelve() handler are untouched.
 */
class StudentEnrollmentController extends Controller
{
    public function index()
    {
        error_reporting(E_ALL ^ E_WARNING);
        include(MODELS_PATH . '/student.class.php');

        // Block direct URL access when no one (or a non-student) is logged in
        $userdetails = $eusebia->validate_student();
        $current_user_id = $userdetails['id_student'];

        $grade_defs = [
            7  => ['table' => 'tbl_seven',  'id_col' => 'id_seven',  'prev' => null,        'label' => 'Grade 7',  'tier' => 'junior'],
            8  => ['table' => 'tbl_eight',  'id_col' => 'id_eight',  'prev' => 'tbl_seven', 'label' => 'Grade 8',  'tier' => 'junior'],
            9  => ['table' => 'tbl_nine',   'id_col' => 'id_nine',   'prev' => 'tbl_eight', 'label' => 'Grade 9',  'tier' => 'junior_course'],
            10 => ['table' => 'tbl_ten',    'id_col' => 'id_ten',    'prev' => 'tbl_nine',  'label' => 'Grade 10', 'tier' => 'junior_course'],
            11 => ['table' => 'tbl_eleven', 'id_col' => 'id_eleven', 'prev' => 'tbl_ten',   'label' => 'Grade 11', 'tier' => 'senior'],
            12 => ['table' => 'tbl_twelve', 'id_col' => 'id_twelve', 'prev' => 'tbl_eleven','label' => 'Grade 12', 'tier' => 'senior'],
        ];

        $enrollment_open = $eusebia->is_enrollment_open();

        // ---------------------------------------------------------------
        // Edit / Resubmit mode: a rejected submission's "Edit & Resubmit"
        // button on my_submissions.php links here as
        // student_enrollment.php?edit=<id>&grade=<7-12>. Load that row
        // (ownership + "must be Rejected" is enforced by
        // get_editable_submission(), same guard the old grade7.php...
        // grade12.php forms used) so the wizard can be pre-filled with it.
        // ---------------------------------------------------------------
        $editing_record = null;
        $editing_grade  = null;
        $editing_id     = (int)($_GET['edit'] ?? 0);
        $requested_grade = (int)($_GET['grade'] ?? 0);

        if ($editing_id > 0) {
            $def = $grade_defs[$requested_grade] ?? null;
            $row = $def ? $eusebia->get_editable_submission($def['table'], $def['id_col'], $editing_id, $current_user_id) : null;
            if ($row) {
                $editing_record = $row;
                $editing_grade  = $requested_grade;
            } else {
                $_SESSION['swal'] = [
                    'icon'  => 'error',
                    'title' => 'Cannot Edit',
                    'text'  => 'This submission can no longer be edited.'
                ];
                header('Location: my_submissions.php');
                exit();
            }
        }

        // ---------------------------------------------------------------
        // Sequential progression: once the student has a Pending/Approved
        // record in a grade (e.g. Grade 7), the ONLY grade they may enroll
        // into is the very next level (Grade 8) - no skipping ahead.
        // Students with no record yet (new / transferee) may still pick
        // any grade as their entry point.
        // ---------------------------------------------------------------
        $next_grade = $eusebia->get_next_enrollable_grade($current_user_id);

        $grade_status  = [];
        $prev_data_map = [];

        foreach ($grade_defs as $g => $def) {
            $locked            = $eusebia->has_advanced_beyond($current_user_id, $def['table']);
            $has_record        = $eusebia->has_grade_level_record($current_user_id, $def['table'], $def['id_col']);
            $pending_elsewhere = $eusebia->get_pending_enrollment_elsewhere($current_user_id, $def['table']);
            $prev_record       = $def['prev'] ? $eusebia->get_prev_grade_record($current_user_id, $def['prev']) : null;

            $not_next = ($next_grade !== null && $g !== $next_grade);

            $available = $enrollment_open && !$locked && !$has_record && !$pending_elsewhere && !$not_next;
            $reason = '';
            if ($locked) {
                $reason = 'Already advanced beyond this grade.';
            } elseif ($has_record) {
                $reason = 'You already have a record for this grade.';
            } elseif ($pending_elsewhere) {
                $reason = 'Pending enrollment in ' . $pending_elsewhere . '.';
            } elseif ($not_next) {
                $reason = 'You can only enroll in ' . $grade_defs[$next_grade]['label'] . ' next.';
            } elseif (!$enrollment_open) {
                $reason = 'Enrollment is currently closed.';
            }

            // The grade being resubmitted is always selectable, regardless
            // of the checks above (a Rejected row never counts toward
            // has_record/pending/locked, and resubmission is allowed even
            // while enrollment is otherwise closed — same as the old
            // per-grade forms).
            if ($editing_grade !== null && $g === $editing_grade) {
                $available = true;
                $reason = '';
            }

            $grade_status[$g] = [
                'label'     => $def['label'],
                'tier'      => $def['tier'],
                'available' => $available,
                'reason'    => $reason,
            ];
            $prev_data_map[$g] = $prev_record;
        }

        // If the student already has a PENDING enrollment (in any grade), the
        // page shows just "Pending enrollment in Grade X" instead of the wizard.
        $pending_label = null;
        foreach ($grade_defs as $def) {
            $p = $eusebia->get_pending_enrollment_elsewhere($current_user_id, $def['table']);
            if ($p) { $pending_label = $p; break; }
        }
        $pending_block = ($pending_label !== null && $editing_record === null);

        // Grade the wizard should pre-select (only when the next level is open)
        $auto_grade = ($next_grade !== null && !empty($grade_status[$next_grade]['available'])) ? $next_grade : null;

        $this->view('pages/student_enrollment', get_defined_vars());
    }
}
