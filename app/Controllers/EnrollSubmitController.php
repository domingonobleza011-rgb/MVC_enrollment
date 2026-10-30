<?php

/**
 * EnrollSubmitController
 * ---------------------------------------------------------------------
 * Single shared submission target for the unified enrollment modal on
 * student_homepage.php. The modal lets the student pick ANY grade level
 * (7-12) from one dropdown instead of visiting a separate page per grade;
 * this controller reads that choice from `grade_level` and dispatches to
 * the existing, already-battle-tested create_seven()...create_twelve()
 * handlers in main.class.php — so all validation, LRN dedupe checks,
 * document uploads, and DB writes are reused unchanged, just triggered
 * from one endpoint instead of six.
 */
class EnrollSubmitController extends Controller
{
    public function index()
    {
        error_reporting(E_ALL ^ E_WARNING);
        require(MODELS_PATH . '/main.class.php');
        require(MODELS_PATH . '/student.class.php');

        // Also enforces that a student is logged in, same as every grade page did.
        $userdetails = $eusebia->get_userdata();

        $map = [
            '7'  => ['method' => 'create_seven',  'flag' => 'create_seven'],
            '8'  => ['method' => 'create_eight',  'flag' => 'create_eight'],
            '9'  => ['method' => 'create_nine',   'flag' => 'create_nine'],
            '10' => ['method' => 'create_ten',    'flag' => 'create_ten'],
            '11' => ['method' => 'create_eleven', 'flag' => 'create_eleven'],
            '12' => ['method' => 'create_twelve', 'flag' => 'create_twelve'],
        ];

        $grade = trim($_POST['grade_level'] ?? '');

        if (!isset($map[$grade])) {
            $_SESSION['swal'] = [
                'icon'  => 'error',
                'title' => 'Invalid Grade Level',
                'text'  => 'Please choose a grade level and try again.'
            ];
            header('Location: student_homepage.php');
            exit();
        }

        // Sequential progression guard (server-side): a student who already
        // has a Pending/Approved record may only enroll into the next grade.
        // Resubmitting a rejected form (edit_id) stays on its own grade.
        $student_id = (int)($userdetails['id_student'] ?? 0);
        if (empty($_POST['edit_id'])) {
            $next_grade = $eusebia->get_next_enrollable_grade($student_id);
            if ($next_grade !== null && (int)$grade !== $next_grade) {
                $_SESSION['swal'] = [
                    'icon'  => 'error',
                    'title' => 'Invalid Grade Level',
                    'text'  => 'You can only enroll in Grade ' . $next_grade . ' next.'
                ];
                header('Location: student_homepage.php');
                exit();
            }
        }

        // Age is always derived from the date of birth (never trusted from the form
        // or from an older record), so it is current for this enrollment.
        if (!empty($_POST['bdate'])) {
            try {
                $dob = new DateTime($_POST['bdate']);
                $_POST['age'] = (string)$dob->diff(new DateTime('today'))->y;
            } catch (Exception $e) { /* keep submitted value if the date is unparseable */ }
        }

        // Continuing students: Previous Education comes from their own approved
        // record in the previous grade (grade completed + that record's school year).
        $prev_tbl = trim($_POST['prev_grade_table'] ?? '');
        $prev_id  = (int)($_POST['prev_grade_id'] ?? 0);
        $grade_by_table = ['tbl_seven'=>7,'tbl_eight'=>8,'tbl_nine'=>9,'tbl_ten'=>10,'tbl_eleven'=>11,'tbl_twelve'=>12];
        // (Also applies when resubmitting a rejected enrollment.)
        if ($prev_tbl !== '' && isset($grade_by_table[$prev_tbl])
            && $grade_by_table[$prev_tbl] === ((int)$grade - 1)) {
            $prev_row = $eusebia->get_prev_grade_record($student_id, $prev_tbl);
            if ($prev_row) {
                $_POST['lglc'] = 'Grade ' . $grade_by_table[$prev_tbl];
                if (!empty($prev_row['sy'])) {
                    $_POST['lysc'] = $prev_row['sy'];
                    if (preg_match('/^(\d{4})-(\d{4})$/', $prev_row['sy'], $m)) {
                        $_POST['sy'] = ((int)$m[1] + 1) . '-' . ((int)$m[2] + 1);
                    }
                }
            }
        }

        // Each create_X() method still gates itself on isset($_POST['create_X']),
        // so set that flag here based on the grade the student actually chose —
        // the modal itself only ever sends `grade_level`.
        $_POST[$map[$grade]['flag']] = '1';

        $method = $map[$grade]['method'];
        $eusebia->$method();

        // create_X() always redirects and exit()s on every path (success,
        // validation failure, lock, closed period, etc). Reaching this line
        // would mean it didn't — fail safe back to the homepage.
        header('Location: student_homepage.php');
        exit();
    }
}
