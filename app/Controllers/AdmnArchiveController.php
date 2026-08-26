<?php

class AdmnArchiveController extends Controller
{
    public function index()
    {
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 1);
    require(MODELS_PATH . '/main.class.php');
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    // Handle restore actions
    $eusebia->restore_seven();
    $eusebia->restore_eight();
    $eusebia->restore_nine();
    $eusebia->restore_ten();
    $eusebia->restore_eleven();
    $eusebia->restore_twelve();

    // Handle permanent delete (single)
    // Handle permanent delete (single)
if (isset($_POST['permanent_delete'])) {
    $grade_table = $_POST['grade_table'];
    $record_id   = $_POST['record_id'];
    $allowed_tables = ['seven','eight','nine','ten','eleven','twelve'];
    if (in_array($grade_table, $allowed_tables)) {
        $connection = $eusebia->openConn();
        $id_col = 'id_' . $grade_table;

        // Delete uploaded files first
        $fetch = $connection->prepare("SELECT documents FROM tbl_{$grade_table} WHERE {$id_col} = ?");
        $fetch->execute([$record_id]);
        $row = $fetch->fetch();
        if ($row && !empty($row['documents'])) {
            $docs = json_decode($row['documents'], true);
            if (is_array($docs)) {
                foreach ($docs as $filePath) {
                    $absPath = ROOT_PATH . '/' . $filePath;
                    if (file_exists($absPath)) unlink($absPath);
                }
            }
        }

        $stmt = $connection->prepare("DELETE FROM tbl_{$grade_table} WHERE {$id_col} = ? AND is_archived = 1");
        $stmt->execute([$record_id]);
    }
    header("Location: admn_archive.php");
    exit();
}

    // Handle BULK restore
    if (isset($_POST['bulk_restore']) && !empty($_POST['selected_records'])) {
        $allowed_tables = ['seven','eight','nine','ten','eleven','twelve'];
        $connection = $eusebia->openConn();
        foreach ($_POST['selected_records'] as $entry) {
            list($grade_table, $record_id) = explode(':', $entry, 2);
            if (in_array($grade_table, $allowed_tables) && is_numeric($record_id)) {
                $id_col = 'id_' . $grade_table;
                $stmt = $connection->prepare("UPDATE tbl_{$grade_table} SET is_archived = 0, archived_at = NULL WHERE {$id_col} = ? AND is_archived = 1");
                $stmt->execute([$record_id]);
            }
        }
        header("Location: admn_archive.php");
        exit();
    }

    // Handle BULK delete
if (isset($_POST['bulk_delete']) && !empty($_POST['selected_records'])) {
    $allowed_tables = ['seven','eight','nine','ten','eleven','twelve'];
    $connection = $eusebia->openConn();
    foreach ($_POST['selected_records'] as $entry) {
        list($grade_table, $record_id) = explode(':', $entry, 2);
        if (in_array($grade_table, $allowed_tables) && is_numeric($record_id)) {
            $id_col = 'id_' . $grade_table;

            // Delete uploaded files first
            $fetch = $connection->prepare("SELECT documents FROM tbl_{$grade_table} WHERE {$id_col} = ?");
            $fetch->execute([$record_id]);
            $row = $fetch->fetch();
            if ($row && !empty($row['documents'])) {
                $docs = json_decode($row['documents'], true);
                if (is_array($docs)) {
                    foreach ($docs as $filePath) {
                        $absPath = ROOT_PATH . '/' . $filePath;
                        if (file_exists($absPath)) unlink($absPath);
                    }
                }
            }

            $stmt = $connection->prepare("DELETE FROM tbl_{$grade_table} WHERE {$id_col} = ? AND is_archived = 1");
            $stmt->execute([$record_id]);
        }
    }
    header("Location: admn_archive.php");
    exit();
}

    // Collect all archived records
    $archived_seven   = $eusebia->view_archived_seven()   ?: [];
    $archived_eight   = $eusebia->view_archived_eight()   ?: [];
    $archived_nine    = $eusebia->view_archived_nine()    ?: [];
    $archived_ten     = $eusebia->view_archived_ten()     ?: [];
    $archived_eleven  = $eusebia->view_archived_eleven()  ?: [];
    $archived_twelve  = $eusebia->view_archived_twelve()  ?: [];

    $all_archived = array_merge(
        $archived_seven, $archived_eight, $archived_nine,
        $archived_ten, $archived_eleven, $archived_twelve
    );

    // Sort by archived_at descending
    usort($all_archived, function($a, $b) {
        return strtotime($b['archived_at'] ?? '0') - strtotime($a['archived_at'] ?? '0');
    });

    // Filter by grade if requested
    $filter_grade = $_GET['grade'] ?? 'all';

    // Search keyword
    $keyword = strtolower(trim($_GET['keyword'] ?? ''));

        $this->view('pages/admn_archive', get_defined_vars());
    }
}
