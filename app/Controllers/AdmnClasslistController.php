<?php

class AdmnClasslistController extends Controller
{
    public function index()
    {
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 0);
    require(MODELS_PATH . '/student.class.php');
    $userdetails = $eusebia->get_userdata();
    $eusebia->validate_admin();

    $school_name = 'Eusebia Paz Arroyo Memorial National High School';
    $school_year = $_GET['sy']   ?? '';
    $grade       = $_GET['grade'] ?? '';

    $grade_map = [
        'seven'  => ['label' => 'Grade 7',  'table' => 'tbl_seven',  'shs' => false],
        'eight'  => ['label' => 'Grade 8',  'table' => 'tbl_eight',  'shs' => false],
        'nine'   => ['label' => 'Grade 9',  'table' => 'tbl_nine',   'shs' => false],
        'ten'    => ['label' => 'Grade 10', 'table' => 'tbl_ten',    'shs' => false],
        'eleven' => ['label' => 'Grade 11', 'table' => 'tbl_eleven', 'shs' => true],
        'twelve' => ['label' => 'Grade 12', 'table' => 'tbl_twelve', 'shs' => true],
    ];

    // Get all available school years across all tables for the filter dropdown
    $all_sy = [];
    $conn   = $eusebia->openConn();
    foreach ($grade_map as $g => $info) {
        $r = $conn->query("SELECT DISTINCT sy FROM {$info['table']} WHERE is_archived = 0 OR is_archived IS NULL ORDER BY sy DESC");
        foreach ($r->fetchAll(PDO::FETCH_COLUMN) as $s) {
            if ($s) $all_sy[$s] = true;
        }
    }
    krsort($all_sy);
    $all_sy = array_keys($all_sy);

    // Fetch students
    $students = [];
    $grade_info = null;
    if ($grade && isset($grade_map[$grade])) {
        $grade_info = $grade_map[$grade];
        $table = $grade_info['table'];
        try { $conn->exec("ALTER TABLE $table ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
        if ($school_year) {
            $stmt = $conn->prepare("SELECT * FROM $table WHERE (is_archived = 0 OR is_archived IS NULL) AND enrollment_status = 'Approved' AND sy = ? ORDER BY lname, fname");
            $stmt->execute([$school_year]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM $table WHERE (is_archived = 0 OR is_archived IS NULL) AND enrollment_status = 'Approved' ORDER BY lname, fname");
            $stmt->execute();
        }
        $students = $stmt->fetchAll();
    }

    // Group SHS by course
    $grouped = [];
    if ($grade_info && $grade_info['shs']) {
        foreach ($students as $s) {
            $course = trim($s['course'] ?? 'Unassigned');
            $grouped[$course][] = $s;
        }
        ksort($grouped);
    } else {
        $grouped['__all__'] = $students;
    }

    if (isset($_GET['export']) && $_GET['export'] === 'excel' && $grade_info) {
        $this->exportExcel($grade_info, $school_year, $grouped);
        exit();
    }

        $this->view('pages/admn_classlist', get_defined_vars());
    }

    private function exportExcel($grade_info, $school_year, $grouped)
    {
        $filename = 'ClassList_' . preg_replace('/[^A-Za-z0-9]+/', '_', $grade_info['label'])
            . ($school_year ? '_' . preg_replace('/[^A-Za-z0-9]+/', '_', $school_year) : '') . '.xls';

        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: public');
        header('Cache-Control: max-age=0');

        $colCount = $grade_info['shs'] ? 19 : 18;
        $mergeAcross = $colCount - 1;

        $esc = function ($v) {
            return htmlspecialchars((string)$v, ENT_QUOTES | ENT_XML1, 'UTF-8');
        };
        $cell = function ($value, $style = 'Cell') use ($esc) {
            return '<Cell ss:StyleID="' . $style . '"><Data ss:Type="String">' . $esc($value) . '</Data></Cell>';
        };

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
        echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
 <Styles>
  <Style ss:ID="Title"><Font ss:Bold="1" ss:Size="14" ss:Color="#0B2B5C"/></Style>
  <Style ss:ID="Sub"><Font ss:Italic="1" ss:Size="10" ss:Color="#555555"/></Style>
  <Style ss:ID="Strand">
   <Font ss:Bold="1" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#0B2B5C" ss:Pattern="Solid"/>
   <Borders>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="Header">
   <Font ss:Bold="1" ss:Color="#0B2B5C"/>
   <Interior ss:Color="#D9E4F5" ss:Pattern="Solid"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="Cell">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="CellLeft">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
 </Styles>
 <Worksheet ss:Name="' . $esc($grade_info['label']) . '">
  <Table>
   <Column ss:Width="30"/>
   <Column ss:Width="90"/>
   <Column ss:Width="100"/>
   <Column ss:Width="100"/>
   <Column ss:Width="50"/>
   <Column ss:Width="60"/>
   <Column ss:Width="40"/>
   <Column ss:Width="70"/>
   <Column ss:Width="80"/>
   <Column ss:Width="150"/>
   <Column ss:Width="160"/>
   <Column ss:Width="160"/>
   <Column ss:Width="150"/>
   <Column ss:Width="90"/>
   <Column ss:Width="150"/>
   <Column ss:Width="90"/>
   <Column ss:Width="60"/>
   <Column ss:Width="60"/>' . "\n";

        echo '<Row ss:Height="20"><Cell ss:StyleID="Title" ss:MergeAcross="' . $mergeAcross . '"><Data ss:Type="String">'
            . $esc($grade_info['label'] . ' — ' . ($school_year ?: 'All School Years')) . '</Data></Cell></Row>' . "\n";
        echo '<Row></Row>' . "\n";

        foreach ($grouped as $course => $rows) {
            if ($grade_info['shs']) {
                echo '<Row><Cell ss:StyleID="Strand" ss:MergeAcross="' . $mergeAcross . '"><Data ss:Type="String">'
                    . $esc($course . ' — ' . count($rows) . ' student' . (count($rows) != 1 ? 's' : '')) . '</Data></Cell></Row>' . "\n";
            }

            echo '<Row>';
            echo $cell('#', 'Header') . $cell('LRN', 'Header') . $cell('Last Name', 'Header') . $cell('First Name', 'Header')
                . $cell('M.I.', 'Header') . $cell('Sex', 'Header') . $cell('Age', 'Header') . $cell('Birthday', 'Header')
                . $cell('Contact', 'Header') . $cell('Email', 'Header')
                . $cell('Current Address', 'Header') . $cell('Permanent Address', 'Header')
                . $cell("Father's Name", 'Header') . $cell("Father's Contact", 'Header')
                . $cell("Mother's Name", 'Header') . $cell("Mother's Contact", 'Header')
                . $cell('4Ps Beneficiary', 'Header') . $cell('Indigenous People', 'Header');
            if ($grade_info['shs']) {
                echo $cell('Strand', 'Header');
            }
            echo '</Row>' . "\n";

            $n = 1;
            foreach ($rows as $s) {
                $father = trim(($s['ffname'] ?? '') . ' ' . ($s['fmi'] ?? '') . ' ' . ($s['flname'] ?? ''));
                $father = preg_replace('/\s+/', ' ', $father);
                $mother = trim(($s['mfname'] ?? '') . ' ' . ($s['mmi'] ?? '') . ' ' . ($s['mlname'] ?? ''));
                $mother = preg_replace('/\s+/', ' ', $mother);

                $is4ps = trim($s['is_4ps'] ?? '') ?: 'No';
                $fourpsId = trim($s['fourps_id'] ?? '');
                $fourpsLabel = $is4ps;
                if (strcasecmp($is4ps, 'Yes') === 0 && $fourpsId !== '') {
                    $fourpsLabel .= ' (' . $fourpsId . ')';
                }

                $isIp = trim($s['is_ip'] ?? '') ?: 'No';
                $ipGroup = trim($s['ip_group'] ?? '');
                $ipLabel = $isIp;
                if (strcasecmp($isIp, 'Yes') === 0 && $ipGroup !== '') {
                    $ipLabel .= ' (' . $ipGroup . ')';
                }

                echo '<Row>';
                echo $cell($n++);
                echo $cell($s['lrn'] ?? '');
                echo $cell($s['lname'] ?? '', 'CellLeft');
                echo $cell($s['fname'] ?? '', 'CellLeft');
                echo $cell($s['mi'] ?? '');
                echo $cell($s['sex'] ?? '');
                echo $cell($s['age'] ?? '');
                echo $cell($s['bdate'] ?? '');
                echo $cell($s['contact'] ?? '');
                echo $cell($s['email'] ?? '', 'CellLeft');
                echo $cell($s['current_address'] ?? '', 'CellLeft');
                echo $cell($s['perm_address'] ?? '', 'CellLeft');
                echo $cell($father, 'CellLeft');
                echo $cell($s['contact_f'] ?? '');
                echo $cell($mother, 'CellLeft');
                echo $cell($s['contact_m'] ?? '');
                echo $cell($fourpsLabel);
                echo $cell($ipLabel);
                if ($grade_info['shs']) {
                    echo $cell($s['course'] ?? '');
                }
                echo '</Row>' . "\n";
            }
            echo '<Row></Row>' . "\n";
        }

        echo '  </Table>
 </Worksheet>
</Workbook>';
    }
}
