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
