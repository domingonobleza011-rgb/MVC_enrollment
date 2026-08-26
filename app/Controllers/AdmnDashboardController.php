<?php

class AdmnDashboardController extends Controller
{
    public function index()
    {
    ini_set('display_errors',1);
    error_reporting(E_ALL ^ E_WARNING);
    include(MODELS_PATH . '/student.class.php');
    $eusebia->validate_admin();
    $userdetails = $eusebia->get_userdata();
    $studenteusebia = new StudentClass();

    // Fetching all 6 grades
    $g7  = $studenteusebia->count_by_grade('tbl_seven');
    $g8  = $studenteusebia->count_by_grade('tbl_eight');
    $g9  = $studenteusebia->count_by_grade('tbl_nine');
    $g10 = $studenteusebia->count_by_grade('tbl_ten');
    $g11 = $studenteusebia->count_by_grade('tbl_eleven');
    $g12 = $studenteusebia->count_by_grade('tbl_twelve');

    // SHS strand counts
    $stem_count = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'STEM')
                + $studenteusebia->count_by_grade('tbl_twelve', 'course', 'STEM');
    $abm_count  = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'ABM')
                + $studenteusebia->count_by_grade('tbl_twelve', 'course', 'ABM');
    $gas_count  = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'GAS')
                + $studenteusebia->count_by_grade('tbl_twelve', 'course', 'GAS');
    $ict_count  = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'TVL-ICT')
                + $studenteusebia->count_by_grade('tbl_twelve', 'course', 'TVL-ICT');
    $he_count   = $studenteusebia->count_by_grade('tbl_eleven', 'course', 'TVL-HE')
                + $studenteusebia->count_by_grade('tbl_twelve', 'course', 'TVL-HE');

    // Totals
    $total_jhs   = $g7 + $g8 + $g9 + $g10;
    $total_shs   = $g11 + $g12;
    $grand_total = $total_jhs + $total_shs;

    // Enrollment trend (last 30 days) — requires date_enrolled column,
    // see migration_add_date_enrolled.sql. If the column doesn't exist yet
    // this will throw, so it's wrapped defensively below.
    $trend = [];
    $trend_available = true;
    try {
        $trend = $studenteusebia->get_enrollment_trend(30);
    } catch (Exception $e) {
        $trend_available = false;
    }

    // JHS/SHS split, used for the hero's proportion bar
    $jhs_pct = $grand_total > 0 ? round(($total_jhs / $grand_total) * 100) : 0;
    $shs_pct = 100 - $jhs_pct;

    // "Last enrollee" pulse — most recent day in the trend window with
    // at least one new enrollee, expressed as a relative label.
    $last_active_label = 'No recent activity';
    if ($trend_available && !empty($trend)) {
        $active_days = array_filter($trend, fn($c) => $c > 0);
        if (!empty($active_days)) {
            $last_day = array_key_last($active_days);
            $diff = (new DateTime('today'))->diff(new DateTime($last_day))->days;
            if ($diff === 0) $last_active_label = 'Today';
            elseif ($diff === 1) $last_active_label = 'Yesterday';
            else $last_active_label = $diff . ' days ago';
        }
    }

        $this->view('pages/admn_dashboard', get_defined_vars());
    }
}
