<?php

/**
 * Global search (top bar of every admin page).
 *
 * GET global_search.php?q=juan   ->  JSON  { success, q, groups: [ { key, label, total, items: [...] } ] }
 *
 * Searches by name / LRN / email / phone across:
 *   - Enrollees        tbl_seven ... tbl_twelve   (not archived)   -> that grade's page
 *   - Archived         tbl_seven ... tbl_twelve   (archived)       -> Archive page
 *   - Accounts         tbl_student                                 -> Registered Accounts page
 *   - Staff / Admins   tbl_user, tbl_admin
 *
 * Admin-only. Every value reaches SQL through a bound parameter (LIKE wildcards in the typed
 * text are escaped), and the JSON is rendered by the browser with textContent (no HTML).
 */
class GlobalSearchController extends Controller
{
    // key => [table, grade number, page]
    const GRADES = [
        'seven'  => ['tbl_seven',  7,  'admn_seven.php'],
        'eight'  => ['tbl_eight',  8,  'admn_eight.php'],
        'nine'   => ['tbl_nine',   9,  'admn_nine.php'],
        'ten'    => ['tbl_ten',    10, 'admn_ten.php'],
        'eleven' => ['tbl_eleven', 11, 'admn_eleven.php'],
        'twelve' => ['tbl_twelve', 12, 'admn_twelve.php'],
    ];
    const PER_TABLE = 15;   // rows fetched per table
    const PER_GROUP = 8;    // rows shown per group

    public function index()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');

        require(MODELS_PATH . '/student.class.php');   // provides $eusebia (extends the main class)
        $user = $eusebia->get_userdata();
        if (!$user || ($user['role'] ?? '') !== 'administrator') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Not allowed.']);
            return;
        }

        $q = trim((string)($_GET['q'] ?? ''));
        try {
            $groups = self::search($eusebia->openConn(), $q);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Search failed.']);
            return;
        }
        echo json_encode(['success' => true, 'q' => $q, 'groups' => $groups], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    }

    // mbstring is optional on some hosts: use it when present, plain PHP otherwise.
    private static function cut(string $s, int $n): string { return function_exists('mb_substr') ? mb_substr($s, 0, $n) : (preg_match('/^.{0,' . $n . '}/us', $s, $m) ? $m[0] : substr($s, 0, $n)); }
    private static function len(string $s): int { return function_exists('mb_strlen') ? mb_strlen($s) : (int)preg_match_all('/./us', $s); }
    private static function lower(string $s): string { return function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); }

    /** Pure search logic (takes a PDO) so it can be tested without a web request. */
    public static function search(PDO $db, string $q): array
    {
        $q = self::cut($q, 60);
        $tokens = array_slice(preg_split('/[\s,]+/u', $q, -1, PREG_SPLIT_NO_EMPTY), 0, 5);
        if (self::len($q) < 2 || !$tokens) return [];

        $like = fn($t) => '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $t) . '%';
        // every typed word must match at least one of the columns
        $where = function (array $cols) use ($tokens, $like) {
            $sql = []; $params = [];
            foreach ($tokens as $t) {
                $sql[] = '(' . implode(' OR ', array_map(fn($c) => "`$c` LIKE ? ESCAPE '!'", $cols)) . ')';
                foreach ($cols as $_) $params[] = $like($t);
            }
            return [implode(' AND ', $sql), $params];
        };
        $fetch = function (string $table, array $cols, string $extra, int $limit) use ($db, $where) {
            [$w, $p] = $where($cols);
            $st = $db->prepare("SELECT * FROM `$table` WHERE ($w) $extra LIMIT $limit");
            $st->execute($p);
            return $st->fetchAll(PDO::FETCH_ASSOC);
        };
        $nameOf = fn($r) => trim(($r['lname'] ?? '') . ', ' . trim(($r['fname'] ?? '') . ' ' . ($r['mi'] ?? '')), ', ');
        $first = self::lower($tokens[0]);
        $starts = fn($s) => strncmp(self::lower((string)$s), $first, strlen($first)) === 0;
        $rank  = fn($r) => ($starts($r['lname'] ?? '') || $starts($r['fname'] ?? '')) ? 0 : 1;
        $sorter = function (array &$items) {
            usort($items, fn($a, $b) => [$a['_r'], self::lower($a['name'])] <=> [$b['_r'], self::lower($b['name'])]);
        };
        $clean = function (array $items) { foreach ($items as &$i) unset($i['_r']); return array_values($items); };
        $link  = fn($page, $params) => $page . '?' . http_build_query($params);

        $enrollees = []; $archived = [];
        $gradeCols = ['lname', 'fname', 'mi', 'lrn', 'email'];
        foreach (self::GRADES as $key => [$table, $num, $page]) {
            foreach ($fetch($table, $gradeCols, "AND (is_archived = 0 OR is_archived IS NULL)", self::PER_TABLE) as $r) {
                $enrollees[] = [
                    'name' => $nameOf($r), 'badge' => 'Grade ' . $num,
                    'sub'  => trim(($r['lrn'] ? 'LRN ' . $r['lrn'] : '') . ($r['sy'] ? '  ·  SY ' . $r['sy'] : '')),
                    'status' => $r['enrollment_status'] ?? '',
                    'url'  => $link($page, ['search' => $r['lname']]), '_r' => $rank($r),
                ];
            }
            foreach ($fetch($table, $gradeCols, "AND is_archived = 1", self::PER_TABLE) as $r) {
                $archived[] = [
                    'name' => $nameOf($r), 'badge' => 'Grade ' . $num,
                    'sub'  => trim(($r['lrn'] ? 'LRN ' . $r['lrn'] : '') . ($r['archived_at'] ? '  ·  Archived ' . substr($r['archived_at'], 0, 10) : '')),
                    'status' => '',
                    'url'  => $link('admn_archive.php', ['grade' => $key, 'keyword' => $r['lrn'] ?: $r['lname']]), '_r' => $rank($r),
                ];
            }
        }

        $accounts = [];
        foreach ($fetch('tbl_student', ['lname', 'fname', 'mi', 'email', 'phone_number', 'contact'], '', self::PER_TABLE) as $r) {
            $accounts[] = [
                'name' => $nameOf($r), 'badge' => 'Student',
                'sub' => trim(($r['email'] ?: ($r['phone_number'] ?: ($r['contact'] ?? '')))), 'status' => '',
                'url' => $link('admn_students.php', ['search' => $r['lname']]), '_r' => $rank($r),
            ];
        }

        $people = [];
        foreach ($fetch('tbl_user', ['lname', 'fname', 'mi', 'email', 'phone_number', 'position'], '', self::PER_TABLE) as $r) {
            $people[] = [
                'name' => $nameOf($r), 'badge' => 'Staff',
                'sub' => trim(($r['position'] ?? '') . (($r['position'] ?? '') && ($r['email'] ?? '') ? '  ·  ' : '') . ($r['email'] ?: ($r['phone_number'] ?? ''))), 'status' => '',
                'url' => 'admn_staff_crud.php', '_r' => $rank($r),
            ];
        }
        foreach ($fetch('tbl_admin', ['lname', 'fname', 'mi', 'email', 'phone_number'], '', self::PER_TABLE) as $r) {
            $people[] = [
                'name' => $nameOf($r), 'badge' => (strtolower($r['role'] ?? '') === 'staff') ? 'Staff' : 'Admin',
                'sub' => trim($r['email'] ?: ($r['phone_number'] ?? '')), 'status' => '',
                'url' => '', '_r' => $rank($r),           // no page lists admin accounts
            ];
        }

        $groups = [];
        foreach ([['enrollees', 'Enrollees', $enrollees], ['archived', 'Archived', $archived],
                  ['accounts', 'Accounts', $accounts], ['people', 'Staff & Admins', $people]] as [$key, $label, $items]) {
            if (!$items) continue;
            $sorter($items);
            $groups[] = ['key' => $key, 'label' => $label, 'total' => count($items),
                         'items' => $clean(array_slice($items, 0, self::PER_GROUP))];
        }
        return $groups;
    }
}
