<?php 

require_once __DIR__ . '/DocumentAI.php';

class EUSEBIAClass {

//------------------------------------------ DATABASE CONNECTION ----------------------------------------------------
    
    protected $server = "mysql:host=sql300.infinityfree.com;dbname=if0_41932978_eusebia_final";
    protected $user = "if0_41932978";
    protected $pass = "eusebia011";
    protected $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    protected $con;


    public function show_404()
    {
        http_response_code(404);
        include __DIR__ . '/../Views/errors/404.php';
        exit;
    }

    public function show_403()
    {
        http_response_code(403);
        include __DIR__ . '/../Views/errors/403.php';
        exit;
    }

    public function openConn() {
        try {
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;
        }

        catch(PDOException $e) {
            echo "Datbase Connection Error! ", $e->getMessage();
        }
    }

    //eto yung nag c close ng connection ng db
    public function closeConn() {
        $this->con = null;
    }

    // Echoes a styled toast notification (replaces the old raw `echo
    // "<script>alert(...)</script>"` pattern, which breaks when the message
    // contains a quote and — when followed by header() — causes a "headers
    // already sent" crash). $after controls what happens once the toast has
    // shown: 'reload' refreshes the current page, a string is treated as a
    // redirect URL, or null does nothing further.
    public function notif($message, $type = 'success', $after = null) {
        $msg = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $palette = [
            'success' => [
                'border' => '#1D9E75', 'iconbg' => '#E1F5EE', 'title' => '#085041', 'text' => '#0F6E56',
                'label'  => 'Success!',
                'icon'   => "<circle cx='12' cy='12' r='10' fill='#1D9E75'/><path d='M7.5 12.5l3 3 6-6' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>",
            ],
            'error' => [
                'border' => '#E24B4A', 'iconbg' => '#FCEBEB', 'title' => '#501313', 'text' => '#A32D2D',
                'label'  => 'Error',
                'icon'   => "<circle cx='12' cy='12' r='10' fill='#E24B4A'/><path d='M15 9l-6 6M9 9l6 6' stroke='#fff' stroke-width='2' stroke-linecap='round'/>",
            ],
            'warning' => [
                'border' => '#D9A404', 'iconbg' => '#FDF3D8', 'title' => '#6B4E00', 'text' => '#8A6400',
                'label'  => 'Warning',
                'icon'   => "<circle cx='12' cy='12' r='10' fill='#D9A404'/><path d='M12 7v6' stroke='#fff' stroke-width='2' stroke-linecap='round'/><circle cx='12' cy='16.2' r='1.1' fill='#fff'/>",
            ],
            'info' => [
                'border' => '#3661D5', 'iconbg' => '#E8F0FE', 'title' => '#1B3A8A', 'text' => '#2C54C1',
                'label'  => 'Notice',
                'icon'   => "<circle cx='12' cy='12' r='10' fill='#3661D5'/><path d='M12 11v5.5' stroke='#fff' stroke-width='2' stroke-linecap='round'/><circle cx='12' cy='7.7' r='1.1' fill='#fff'/>",
            ],
        ];
        $c = $palette[$type] ?? $palette['success'];

        echo <<<HTML
        <div id="bmisToast" style="
            position:fixed; top:24px; right:24px; z-index:99999;
            background:#fff; border-left:4px solid {$c['border']};
            border-radius:10px; box-shadow:0 8px 32px rgba(0,0,0,0.13);
            padding:16px 20px 16px 18px; min-width:300px; max-width:380px;
            display:flex; align-items:flex-start; gap:14px;
            font-family:Georgia,serif;
            animation:bmisSlideIn .4s cubic-bezier(.22,1,.36,1) both;
        ">
            <div style="width:36px;height:36px;border-radius:50%;background:{$c['iconbg']};display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">{$c['icon']}</svg>
            </div>
            <div>
                <div style="font-weight:700;color:{$c['title']};font-size:15px;margin-bottom:3px;">{$c['label']}</div>
                <div style="color:{$c['text']};font-size:13px;">{$msg}</div>
            </div>
            <button onclick="document.getElementById('bmisToast').remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:{$c['border']};font-size:20px;line-height:1;padding:0;flex-shrink:0;">&times;</button>
        </div>
        <style>
            @keyframes bmisSlideIn { from{opacity:0;transform:translateX(60px)} to{opacity:1;transform:translateX(0)} }
            @keyframes bmisSlideOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(60px)} }
            @media (max-width: 480px) {
                #bmisToast { left:16px; right:16px; top:16px; min-width:unset; max-width:unset; }
            }
        </style>
        <script>
            setTimeout(function () {
                var t = document.getElementById('bmisToast');
                if (t) {
                    t.style.animation = 'bmisSlideOut .35s ease forwards';
                    setTimeout(function () {
                        if (t && t.parentNode) { t.parentNode.removeChild(t); }
                    }, 350);
                }
            }, 3000);
        </script>
        HTML;

        // Do the "refresh/redirect" client-side instead of calling header()
        // here — by the time notif() runs, output has already started, so a
        // real header() redirect would crash with "headers already sent".
        if ($after === 'reload') {
            echo "<script>setTimeout(function(){ window.location.reload(); }, 1400);</script>";
        } elseif (is_string($after) && $after !== '') {
            echo "<script>setTimeout(function(){ window.location.href = " . json_encode($after) . "; }, 1400);</script>";
        }
    }

    // Deletes the physical files referenced by a `documents` JSON column value
    // (e.g. '["uploads/documents/seven/12345_0_report_card.pdf", ...]').
    // Used when an admin rejects an enrollment so the student's uploaded
    // documents don't linger on the server. Safe to call with null/empty/
    // malformed input — it just does nothing in that case.
    protected function delete_uploaded_documents($documents_json) {
        if (empty($documents_json)) return;

        $paths = json_decode($documents_json, true);
        if (!is_array($paths)) return;

        foreach ($paths as $relativePath) {
            if (!is_string($relativePath) || $relativePath === '') continue;

            // Resolve relative to the project root (app/Models/ is one level down).
            $fullPath = ROOT_PATH . '/' . $relativePath;
            $realPath = realpath($fullPath);
            $realBase = realpath(ROOT_PATH . '/uploads/');

            // Guard against deleting anything outside the uploads/ directory.
            if ($realPath === false || $realBase === false) continue;
            if (strpos($realPath, $realBase) !== 0) continue;

            if (is_file($realPath)) {
                @unlink($realPath);
            }
        }
    }

    // Fetches individual pending enrollees (per student) across all grade levels, for a
    // Facebook-style notification dropdown. Skips tables that don't yet have the
    // enrollment_status column (it's added lazily the first time an admin approves/
    // rejects a student in that grade), rather than erroring out.
    public function get_pending_enrollees($limit_per_grade = 15) {
        $tables = [
            'tbl_seven'  => ['label' => 'Grade 7',  'link' => 'admn_seven.php',  'pk' => 'id_seven'],
            'tbl_eight'  => ['label' => 'Grade 8',  'link' => 'admn_eight.php',  'pk' => 'id_eight'],
            'tbl_nine'   => ['label' => 'Grade 9',  'link' => 'admn_nine.php',   'pk' => 'id_nine'],
            'tbl_ten'    => ['label' => 'Grade 10', 'link' => 'admn_ten.php',    'pk' => 'id_ten'],
            'tbl_eleven' => ['label' => 'Grade 11', 'link' => 'admn_eleven.php', 'pk' => 'id_eleven'],
            'tbl_twelve' => ['label' => 'Grade 12', 'link' => 'admn_twelve.php', 'pk' => 'id_twelve'],
        ];

        $connection = $this->openConn();
        $items = [];

        foreach ($tables as $table => $info) {
            try {
                $stmt = $connection->prepare(
                    "SELECT `{$info['pk']}` AS id, fname, lname, sy FROM `$table`
                     WHERE LOWER(enrollment_status) = 'pending'
                     AND (is_archived = 0 OR is_archived IS NULL)
                     ORDER BY `{$info['pk']}` DESC
                     LIMIT " . (int) $limit_per_grade
                );
                $stmt->execute();
                $rows = $stmt->fetchAll();
            } catch (PDOException $e) {
                // Column/table not ready yet on this install — treat as no pending records.
                $rows = [];
            }

            foreach ($rows as $row) {
                $items[] = [
                    'id'    => $row['id'],
                    'name'  => trim(($row['fname'] ?? '') . ' ' . ($row['lname'] ?? '')),
                    'grade' => $info['label'],
                    'sy'    => $row['sy'] ?? '',
                    'link'  => $info['link'],
                ];
            }
        }

        $this->closeConn();

        return ['total' => count($items), 'items' => $items];
    }

    // Small per-grade badge counts for the sidebar (Grade 7-12 links).
    public function count_pending_by_grade() {
        $tables = [
            'tbl_seven'  => 'id_seven',
            'tbl_eight'  => 'id_eight',
            'tbl_nine'   => 'id_nine',
            'tbl_ten'    => 'id_ten',
            'tbl_eleven' => 'id_eleven',
            'tbl_twelve' => 'id_twelve',
        ];

        $connection = $this->openConn();
        $counts = [];

        foreach ($tables as $table => $pk) {
            try {
                $stmt = $connection->prepare(
                    "SELECT COUNT(*) FROM `$table`
                     WHERE LOWER(enrollment_status) = 'pending'
                     AND (is_archived = 0 OR is_archived IS NULL)"
                );
                $stmt->execute();
                $counts[$table] = (int) $stmt->fetchColumn();
            } catch (PDOException $e) {
                // Column/table not ready yet on this install — treat as no pending records.
                $counts[$table] = 0;
            }
        }

        $this->closeConn();

        return $counts;
    }


    //------------------------------------------ AUTHENTICATION & SESSION HANDLING --------------------------------------------
        //authentication function para sa sa tatlong type ng accounts
public function login() {
    if(isset($_POST['login'])) {
        $identity = trim($_POST['login_identity']);
        $password_input = $_POST['password'];

        // Reject identities that are neither a plausible email (has @ and
        // a domain) nor a plausible phone number — e.g. a typo'd email
        // that's missing the @ — before touching the database at all.
        $is_phone = (bool) preg_match('/^[0-9+\-\s()]{7,15}$/', $identity);
        $is_email = (bool) filter_var($identity, FILTER_VALIDATE_EMAIL);
        if (!$is_phone && !$is_email) {
            echo "<script type='text/javascript'>alert('Enter a valid email address (must include @) or a valid phone number.');</script>";
            return;
        }

        $connection = $this->openConn();

        // 1. Check ADMIN - Only check EMAIL
        // 1. Check ADMIN - Now checking BOTH Email and Phone
$stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ? OR phone_number = ?");
$stmt->execute([$identity, $identity]); // We pass the same input to both '?' placeholders
$user = $stmt->fetch();

if($user && password_verify($password_input, $user['password'])) {
    $this->set_userdata($user);
    header('Location: admn_dashboard.php');
    exit(); 
}

        // 2. Check USER (Staff) - Only check EMAIL
        $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE email = ?");
        $stmt->execute([$identity]);
        $user = $stmt->fetch();

        if($user && password_verify($password_input, $user['password'])) {
            $this->set_userdata($user);
            echo "<script>window.location.href='staff_dashboard.php';</script>";
            exit(); 
        }

        // 3. Check STUDENT - Check EMAIL OR PHONE_NUMBER
        // We only use phone_number here because we are sure this table has it.
        $stmt = $connection->prepare("SELECT * FROM tbl_student WHERE email = ? OR phone_number = ?");
        $stmt->execute([$identity, $identity]);
        $user = $stmt->fetch();

        if($user && password_verify($password_input, $user['password'])) {
            // Self-registered / Google student accounts must be reviewed by an
            // admin before they can access the portal.
            $this->ensure_student_verification_columns($connection);
            $vstatus         = $this->get_student_verification_status($user['id_student']);
            $approval_status = $vstatus['approval_status'] ?? 'approved';

            if ($approval_status === 'pending') {
                $_SESSION['pending_approval_name'] = trim(($user['fname'] ?? '') . ' ' . ($user['lname'] ?? ''));
                header('Location: pending_approval.php');
                exit();
            }

            if ($approval_status === 'rejected') {
                $reason = $vstatus['reject_reason'] ?? '';
                echo "<script>alert('Your account registration was not approved." .
                     (!empty($reason) ? ' Reason: ' . addslashes($reason) : '') .
                     " Please visit the school for more information.');</script>";
                return;
            }

            $this->set_userdata($user);
            header('Location: student_homepage.php');
            exit();
        }

        // Only shows if NONE of the above found a match
        echo "<script type='text/javascript'>alert('Invalid Credentials.');</script>";
    }
}

    //eto yung function na mag e end ng session tas i l logout ka 
    public function logout(){
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Wipe all session data, not just userdata, so nothing lingers.
        $_SESSION = array();

        // Kill the session cookie itself so the browser can't replay the old session id.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    // etong method na get_userdata() kukuha ng session mo na 'userdata' mo na i identify sino yung naka login sa site 
public function get_userdata() {
    
    // 1. Start session if it hasn't been started yet
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2. Check if the key exists FIRST before returning it
    if (isset($_SESSION['userdata'])) {
        return $_SESSION['userdata'];
    } 

    // 3. Return null if no user data is found (e.g., not logged in)
    return null;
}

    //------------------------------------------ STUDENT NOTIFICATIONS ----------------------------------------------------
    // Facebook-style in-app notifications for enrollment / promotion approve-reject actions.

    private function ensure_notifications_table($connection) {
        try {
            $connection->exec("CREATE TABLE IF NOT EXISTS tbl_notifications (
                id_notification INT AUTO_INCREMENT PRIMARY KEY,
                id_student INT NOT NULL,
                title VARCHAR(150) NOT NULL,
                message TEXT NOT NULL,
                type VARCHAR(20) NOT NULL DEFAULT 'info',
                is_read TINYINT(1) NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                INDEX (id_student),
                INDEX (is_read)
            )");
        } catch (PDOException $e) {}
    }

    // Creates a notification for a student. $type is 'approved', 'rejected', or 'info'.
    public function add_notification($id_student, $title, $message, $type = 'info') {
        if (empty($id_student)) return;
        $connection = $this->openConn();
        $this->ensure_notifications_table($connection);
        $stmt = $connection->prepare(
            "INSERT INTO tbl_notifications (id_student, title, message, type) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$id_student, $title, $message, $type]);
        $this->closeConn();
    }

    // Most recent notifications for the bell dropdown.
    public function get_notifications($id_student, $limit = 10) {
        if (empty($id_student)) return [];
        $connection = $this->openConn();
        $this->ensure_notifications_table($connection);
        $stmt = $connection->prepare(
            "SELECT * FROM tbl_notifications WHERE id_student = ? ORDER BY created_at DESC LIMIT " . (int)$limit
        );
        $stmt->execute([$id_student]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $rows;
    }

    // Unread count for the little badge on the bell icon.
    public function get_unread_notification_count($id_student) {
        if (empty($id_student)) return 0;
        $connection = $this->openConn();
        $this->ensure_notifications_table($connection);
        $stmt = $connection->prepare(
            "SELECT COUNT(*) FROM tbl_notifications WHERE id_student = ? AND is_read = 0"
        );
        $stmt->execute([$id_student]);
        $count = (int)$stmt->fetchColumn();
        $this->closeConn();
        return $count;
    }

    // Marks all of a student's notifications as read (called when the bell dropdown is opened).
    public function mark_all_notifications_read($id_student) {
        if (empty($id_student)) return;
        $connection = $this->openConn();
        $this->ensure_notifications_table($connection);
        $stmt = $connection->prepare(
            "UPDATE tbl_notifications SET is_read = 1 WHERE id_student = ? AND is_read = 0"
        );
        $stmt->execute([$id_student]);
        $this->closeConn();
    }

    // Deletes a single notification — scoped to the owning student so one
    // student can never delete another's notification by guessing an id.
    public function delete_notification($id_student, $id_notification) {
        if (empty($id_student) || empty($id_notification)) return false;
        $connection = $this->openConn();
        $this->ensure_notifications_table($connection);
        $stmt = $connection->prepare(
            "DELETE FROM tbl_notifications WHERE id_notification = ? AND id_student = ?"
        );
        $stmt->execute([(int)$id_notification, $id_student]);
        $deleted = $stmt->rowCount() > 0;
        $this->closeConn();
        return $deleted;
    }

    //------------------------------------------ STAFF NOTIFICATIONS ----------------------------------------------------
    // Same Facebook-style in-app notifications as above, but for teacher/staff accounts (tbl_user), keyed by id_user.

    private function ensure_staff_notifications_table($connection) {
        try {
            $connection->exec("CREATE TABLE IF NOT EXISTS tbl_staff_notifications (
                id_notification INT AUTO_INCREMENT PRIMARY KEY,
                id_user INT NOT NULL,
                title VARCHAR(150) NOT NULL,
                message TEXT NOT NULL,
                type VARCHAR(20) NOT NULL DEFAULT 'info',
                is_read TINYINT(1) NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                INDEX (id_user),
                INDEX (is_read)
            )");
        } catch (PDOException $e) {}
    }

    // Creates a notification for a staff/teacher account. $type is 'approved', 'rejected', or 'info'.
    public function add_staff_notification($id_user, $title, $message, $type = 'info') {
        if (empty($id_user)) return;
        $connection = $this->openConn();
        $this->ensure_staff_notifications_table($connection);
        $stmt = $connection->prepare(
            "INSERT INTO tbl_staff_notifications (id_user, title, message, type) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$id_user, $title, $message, $type]);
        $this->closeConn();
    }

    // Most recent notifications for the staff bell dropdown.
    public function get_staff_notifications($id_user, $limit = 10) {
        if (empty($id_user)) return [];
        $connection = $this->openConn();
        $this->ensure_staff_notifications_table($connection);
        $stmt = $connection->prepare(
            "SELECT * FROM tbl_staff_notifications WHERE id_user = ? ORDER BY created_at DESC LIMIT " . (int)$limit
        );
        $stmt->execute([$id_user]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $rows;
    }

    // Unread count for the staff bell badge.
    public function get_unread_staff_notification_count($id_user) {
        if (empty($id_user)) return 0;
        $connection = $this->openConn();
        $this->ensure_staff_notifications_table($connection);
        $stmt = $connection->prepare(
            "SELECT COUNT(*) FROM tbl_staff_notifications WHERE id_user = ? AND is_read = 0"
        );
        $stmt->execute([$id_user]);
        $count = (int)$stmt->fetchColumn();
        $this->closeConn();
        return $count;
    }

    // Marks all of a staff member's notifications as read (called when the bell dropdown is opened).
    public function mark_all_staff_notifications_read($id_user) {
        if (empty($id_user)) return;
        $connection = $this->openConn();
        $this->ensure_staff_notifications_table($connection);
        $stmt = $connection->prepare(
            "UPDATE tbl_staff_notifications SET is_read = 1 WHERE id_user = ? AND is_read = 0"
        );
        $stmt->execute([$id_user]);
        $this->closeConn();
    }

    // Deletes a single staff notification — scoped to the owning user.
    public function delete_staff_notification($id_user, $id_notification) {
        if (empty($id_user) || empty($id_notification)) return false;
        $connection = $this->openConn();
        $this->ensure_staff_notifications_table($connection);
        $stmt = $connection->prepare(
            "DELETE FROM tbl_staff_notifications WHERE id_notification = ? AND id_user = ?"
        );
        $stmt->execute([(int)$id_notification, $id_user]);
        $deleted = $stmt->rowCount() > 0;
        $this->closeConn();
        return $deleted;
    }

    //eto yung condition na mag s set userdata na gagamiting pagkakakilala sayo sa buong session kapag nag login in ka
    public function set_userdata($array) {

        //i ch check nito kung naka set naba yung session, kapag hindi pa naka set i r run niya yung session_start();
        if(!isset($_SESSION)) {
            session_start();
        }

        //eto si userdata yung mag s set ng name mo tsaka role/access habang ikaw ay nag b browse at gumagamit ng store management
        // Every field is read with ?? '' because the source row can come from tbl_admin,
        // tbl_user (staff), or tbl_student — each table has a different set of columns,
        // so reading a missing key directly would throw "Undefined array key" warnings.
        $_SESSION['userdata'] = array(
            "id_admin" => $array['id_admin'] ?? null,
            "id_student" => $array['id_student'] ?? null,
            "id_user" => $array['id_user'] ?? null,
            "emailadd" => $array['email'] ?? '',
            "password" => $array['password'] ?? '',
            //"fullname" => $array['lname']. " ".$array['fname']. " ".$array['mi'],
            "surname" => $array['lname'] ?? '',
            "firstname" => $array['fname'] ?? '',
            "mname" => $array['mi'] ?? '',
            "age" => $array['age'] ?? '',
            "sex" => $array['sex'] ?? '',
            "status" => $array['status'] ?? '',
            "address" => $array['address'] ?? '',
            "contact" => $array['contact'] ?? '',
            "bdate" => $array['bdate'] ?? '',
            "bplace" => $array['bplace'] ?? '',
            "nationality" => $array['nationality'] ?? '',
            "family_role" => $array['family_role'] ?? '',
            "role" => $array['role'] ?? '',
            "houseno" => $array['houseno'] ?? '',
            "street" => $array['street'] ?? '',
            "brgy" => $array['brgy'] ?? '',
            "municipal" => $array['municipal'] ?? '',
            // Staff/Teacher fields (null-safe for students/admins)
            "lname"           => $array['lname']            ?? $array['surname']   ?? '',
            "fname"           => $array['fname']            ?? $array['firstname'] ?? '',
            "position"        => $array['position']         ?? '',
            "subject_handled" => $array['subject_handled']  ?? '',
            "adviser_grade"   => $array['adviser_grade']    ?? '',
            "subject_grades"  => $array['subject_grades']   ?? ''
        );
        return $_SESSION['userdata'];
    }



 //----------------------------------------------------- ADMIN CRUD ---------------------------------------------------------
  public function create_admin() {
    if(isset($_POST['add_admin'])) {
        // 1. Use ?? '' to prevent warnings if the field is missing from HTML
        $login_identity = $_POST['login_identity'] ?? ''; 
        $password_input = $_POST['password'] ?? '';
        
        // Hash the password for security
        $password = password_hash($password_input, PASSWORD_DEFAULT); 
        
        $lname = $_POST['lname'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mi = $_POST['mi'] ?? '';
        $role = $_POST['role'] ?? 'Admin';

        // 2. Logic to separate Email from Phone
        $email_to_save = NULL;
        $phone_to_save = NULL;

        if (filter_var($login_identity, FILTER_VALIDATE_EMAIL)) {
            $email_to_save = $login_identity;
        } else {
            $phone_to_save = $login_identity;
        }

        // 3. Validation: Make sure the identity isn't empty
        if (empty($login_identity)) {
            echo "<script>alert('Please provide an email or phone number.');</script>";
            return;
        }

        if ($this->check_admin($login_identity) == 0 ) {
            $connection = $this->openConn();
            // Ensure phone_number column exists in tbl_admin or remove it from the query
            $stmt = $connection->prepare("INSERT INTO tbl_admin (`email`, `phone_number`, `password`, `lname`, `fname`, `mi`, `role`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$email_to_save, $phone_to_save, $password, $lname, $fname, $mi, $role]);
            
            echo "<script>alert('Administrator account added'); window.location.href='add_admin.php';</script>";
        } else {
            echo "<script>alert('Account already exists');</script>";
        }
    }
}

   public function admin_changepass() {
    if(isset($_POST['admin_changepass'])) {
        
        // 1. Capture the ID and password inputs
        $id_admin = $_POST['id_admin'] ?? null;
        $oldpassword = $_POST['oldpassword'] ?? '';
        $newpassword = $_POST['newpassword'] ?? '';
        $checkpassword = $_POST['checkpassword'] ?? '';

        if (empty($id_admin)) {
            echo "<script>alert('Error: Admin ID is missing. Please re-login.');</script>";
            return;
        }

        $connection = $this->openConn();
        
        // 2. Fetch the current hashed password from the database
        $stmt = $connection->prepare("SELECT `password` FROM tbl_admin WHERE id_admin = ?");
        $stmt->execute([$id_admin]);
        $result = $stmt->fetch();

        if (!$result) {
            echo "<script>alert('Admin user not found.');</script>";
            return;
        }

        // 3. Verify Old Password (checks input against the Bcrypt hash)
        if (!password_verify($oldpassword, $result['password'])) { 
            echo "<script>alert('Old Password is Incorrect');</script>";
        } 
        // 4. Ensure New Password and Confirm Password match
        elseif ($newpassword !== $checkpassword) {
            echo "<script>alert('New Passwords do not match');</script>";
        } 
        // 5. Ensure the new password isn't empty
        elseif (empty($newpassword)) {
            echo "<script>alert('New password cannot be empty');</script>";
        }
        else {
            // 6. Success: Hash the NEW password and update
            $hashed_new = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("UPDATE tbl_admin SET password = ? WHERE id_admin = ?");
            $stmt->execute([$hashed_new, $id_admin]);
            
            echo "<script type='text/javascript'>
                alert('Password Updated Successfully'); 
                window.location.href='admn_dashboard.php';
            </script>";
        }
    }
}


    public function check_admin($email) {

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ?");
        $stmt->Execute([$email]);
        $total = $stmt->rowCount(); 

        return $total;
    }

    // Tells the browser never to cache this page, so hitting "back" after
    // logout can't just replay a stashed copy of a protected page instead
    // of asking the server (and getting redirected to login) again.
    private function no_cache_headers() {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    //eto yung function na mag bibigay restriction sa mga admin pages
    public function validate_admin(){
        $this->no_cache_headers();
        $userdetails = $this->get_userdata();

        // Not logged in at all (e.g. direct/URL-edited access) -> send to login,
        // instead of silently falling through with $userdetails left unset.
        if (!$userdetails) {
            header('Location: login.php?msg=auth');
            exit();
        }

        // Logged in, but not an admin -> forbidden, not "missing".
        if ($userdetails['role'] != "administrator") {
            $this->show_403();
        }

        return $userdetails;
    }

    // Blocks direct URL access to student-only pages (e.g. typing
    // student_homepage.php in the address bar without being logged in).
    // Unlike validate_admin()/validate_staff(), this also catches the
    // "not logged in at all" case, not just the "wrong role" case.
    public function validate_student() {
        $this->no_cache_headers();
        $userdetails = $this->get_userdata();

        if (!$userdetails || empty($userdetails['id_student'])) {
            header('Location: login.php?msg=auth');
            exit();
        }

        return $userdetails;
    }

    public function validate_staff() {
        $this->no_cache_headers();

        if(isset($userdetails)) {
            if($userdetails['role'] != "administrator" || $userdetails['role'] != "user") {
                $this->show_404();
            }

            else {
                return $userdetails;
            }
        }
    }















    //----------------------------------------- DOCUMENT PROCESSING FUNCTIONS -------------------------------------
    //-------------------------------------------------------------------------------------------------------------

    /**
     * Runs the AI document reviewer for one enrollment record and stores the
     * result. Never throws — if the AI call fails (bad/missing key, host
     * blocks outgoing requests, etc.) the enrollment submission still goes
     * through; the stored result just records the failure so staff/the
     * "Re-analyze" button can retry later.
     */
    public function run_ai_document_review($table, $idColumn, $recordId, array $relativeDocPaths, array $formData) {
        try {
            $connection = $this->openConn();

            try { $connection->exec("ALTER TABLE `{$table}` ADD COLUMN ai_analysis LONGTEXT NULL DEFAULT NULL"); }
            catch (PDOException $e) {}

            if (empty($relativeDocPaths)) {
                $result = ['success' => false, 'error' => 'No documents were uploaded.', 'analyzed_at' => date('Y-m-d H:i:s')];
            } else {
                $absPaths = array_map(function($p) { return ROOT_PATH . '/' . $p; }, $relativeDocPaths);
                $result = DocumentAI::analyze($absPaths, $formData);
            }

            $stmt = $connection->prepare("UPDATE `{$table}` SET ai_analysis = ? WHERE `{$idColumn}` = ?");
            $stmt->execute([json_encode($result), $recordId]);
        } catch (\Throwable $e) {
            // Swallow — a broken AI review must never block or break enrollment.
        }
    }

/**
 * Used by the student-facing grade7-12.php forms to let a student edit and
 * resubmit an enrollment that an admin has rejected. Returns the row only if
 * it belongs to the logged-in student, is currently Rejected, and isn't
 * archived — otherwise returns null so the page falls back to a blank form.
 */
public function get_editable_submission($table, $pk, $id, $id_student) {
    $allowed = [
        'tbl_seven'  => 'id_seven',
        'tbl_eight'  => 'id_eight',
        'tbl_nine'   => 'id_nine',
        'tbl_ten'    => 'id_ten',
        'tbl_eleven' => 'id_eleven',
        'tbl_twelve' => 'id_twelve',
    ];
    if (!isset($allowed[$table]) || $allowed[$table] !== $pk) return null;
    $id = (int)$id;
    $id_student = (int)$id_student;
    if ($id <= 0 || $id_student <= 0) return null;

    $connection = $this->openConn();
    $stmt = $connection->prepare(
        "SELECT * FROM `$table` WHERE `$pk` = ? AND id_student = ?
         AND LOWER(enrollment_status) = 'rejected' AND (is_archived = 0 OR is_archived IS NULL)"
    );
    $stmt->execute([$id, $id_student]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

/**
 * One-enrollment-per-account rule.
 * Returns true if this student already has a PENDING enrollment sitting
 * in ANY grade table (7-12), excluding archived rows. While a submission
 * is pending, the student can't submit any other enrollment (same or
 * different grade level) until it's approved or rejected.
 * Approved enrollments do NOT block — once approved, the student is free
 * to enroll in a different grade level (e.g. moving up a year).
 * Rejected enrollments don't count either — those go through the
 * resubmission (edit) flow instead, which is why this is only checked
 * when NOT editing.
 */
public function has_active_enrollment($id_student, $exclude_table = null, $exclude_id = null) {
    $id_student = (int)$id_student;
    if ($id_student <= 0) return false;

    $tables = [
        'tbl_seven'  => 'id_seven',
        'tbl_eight'  => 'id_eight',
        'tbl_nine'   => 'id_nine',
        'tbl_ten'    => 'id_ten',
        'tbl_eleven' => 'id_eleven',
        'tbl_twelve' => 'id_twelve',
    ];
    $connection = $this->openConn();
    foreach ($tables as $table => $pk) {
        $sql = "SELECT COUNT(*) FROM `$table` WHERE `id_student` = ?
                AND LOWER(enrollment_status) = 'pending'
                AND (is_archived = 0 OR is_archived IS NULL)";
        $params = [$id_student];
        if ($exclude_table === $table && $exclude_id) {
            $sql .= " AND `$pk` != ?";
            $params[] = (int)$exclude_id;
        }
        $stmt = $connection->prepare($sql);
        $stmt->execute($params);
        if ($stmt->fetchColumn() > 0) return true;
    }
    return false;
}

/**
 * One account = one continuous enrollment.
 * Looks up this student's own APPROVED record in the immediately preceding
 * grade table (matched by id_student, not LRN) so the next grade's form can
 * skip the New/Old/Transferee question entirely and auto-fill itself.
 * Returns null if the student has no approved record there (i.e. they really
 * are new or a transferee for this grade).
 */
public function get_prev_grade_record($id_student, $prev_table) {
    $id_student = (int)$id_student;
    if ($id_student <= 0) return null;

    $pk_map = [
        'tbl_seven'  => 'id_seven',
        'tbl_eight'  => 'id_eight',
        'tbl_nine'   => 'id_nine',
        'tbl_ten'    => 'id_ten',
        'tbl_eleven' => 'id_eleven',
        'tbl_twelve' => 'id_twelve',
    ];
    if (!isset($pk_map[$prev_table])) return null;
    $pk = $pk_map[$prev_table];

    $connection = $this->openConn();
    try {
        $stmt = $connection->prepare(
            "SELECT * FROM `{$prev_table}`
             WHERE `id_student` = ? AND LOWER(enrollment_status) = 'approved'
             AND (is_archived = 0 OR is_archived IS NULL)
             ORDER BY `{$pk}` DESC LIMIT 1"
        );
        $stmt->execute([$id_student]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
    if (!$row) return null;

    $row['source_table'] = $prev_table;
    $row['source_id']    = $row[$pk];
    return $row;
}

/**
 * ================== ENROLLMENT PERIOD SETTINGS ==================
 * Backs the admin "System Settings" page (open/close enrollment +
 * per-grade capacity). Self-heals tbl_settings the same way the rest
 * of this class self-heals its own tables, so no separate migration
 * step is required to use the feature.
 */
private function ensure_settings_table($connection) {
    try {
        $connection->exec("CREATE TABLE IF NOT EXISTS tbl_settings (
            setting_key   VARCHAR(100) NOT NULL PRIMARY KEY,
            setting_value VARCHAR(255) NOT NULL DEFAULT '',
            updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
    } catch (PDOException $e) {}
}

private function get_setting($key, $default = null) {
    $connection = $this->openConn();
    $this->ensure_settings_table($connection);
    $stmt = $connection->prepare("SELECT setting_value FROM tbl_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $val = $stmt->fetchColumn();
    return ($val === false) ? $default : $val;
}

private function set_setting($key, $value) {
    $connection = $this->openConn();
    $this->ensure_settings_table($connection);
    $stmt = $connection->prepare(
        "INSERT INTO tbl_settings (setting_key, setting_value) VALUES (?, ?)
         ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
    );
    $stmt->execute([$key, $value]);
}

// Whether the public enrollment forms currently accept NEW submissions.
// Defaults to OPEN (true) when the setting has never been saved before.
public function is_enrollment_open() {
    return $this->get_setting('enrollment_open', '1') === '1';
}

// Per-grade seat cap. Returns null when unset/blank, meaning unlimited.
public function get_capacity($grade_key) {
    $val = $this->get_setting('capacity_' . $grade_key, '');
    return ($val === '' || $val === null) ? null : (int)$val;
}

// Handles the admin settings form submit (enrollment_open toggle + per-grade capacity).
public function save_enrollment_settings() {
    if (!isset($_POST['save_enrollment_settings'])) return;

    $this->set_setting('enrollment_open', isset($_POST['enrollment_open']) ? '1' : '0');

    $grades = ['seven','eight','nine','ten','eleven','twelve'];
    foreach ($grades as $g) {
        $raw = trim($_POST['capacity'][$g] ?? '');
        $this->set_setting('capacity_' . $g, ($raw === '') ? '' : (string)max(0, (int)$raw));
    }

    $_SESSION['swal'] = [
        'icon'  => 'success',
        'title' => 'Settings Saved',
        'text'  => 'Enrollment settings have been updated.'
    ];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

/**
 * Grade-level lock. Once a student's account has a Pending or Approved
 * (i.e. not archived, not rejected) record in a given grade table, that
 * grade is "locked" for them — they can't submit a second enrollment
 * into the SAME grade table. Rejected records don't count here since
 * those go through the resubmit/edit flow instead.
 */
public function has_grade_level_record($id_student, $table, $pk_col, $exclude_id = null) {
    $id_student = (int)$id_student;
    if ($id_student <= 0) return false;
    $connection = $this->openConn();
    $sql = "SELECT COUNT(*) FROM `{$table}` WHERE `id_student` = ?
            AND LOWER(enrollment_status) IN ('pending','approved')
            AND (is_archived = 0 OR is_archived IS NULL)";
    $params = [$id_student];
    if ($exclude_id) {
        $sql .= " AND `{$pk_col}` != ?";
        $params[] = (int)$exclude_id;
    }
    $stmt = $connection->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn() > 0;
}

/**
 * Forward grade lock. Once a student's account has a Pending or Approved
 * record in ANY grade table further along than the one given (e.g. they
 * already have a Grade 9 enrollment on record), every grade table BEHIND
 * that one is locked — the account has moved past those grade levels, so
 * grade7.php/grade8.php/etc. for those earlier grades must refuse to open.
 */
public function has_advanced_beyond($id_student, $table) {
    $id_student = (int)$id_student;
    if ($id_student <= 0) return false;

    $order = [
        'tbl_seven'  => 1,
        'tbl_eight'  => 2,
        'tbl_nine'   => 3,
        'tbl_ten'    => 4,
        'tbl_eleven' => 5,
        'tbl_twelve' => 6,
    ];
    if (!isset($order[$table])) return false;
    $level = $order[$table];

    $higher_tables = array_keys(array_filter($order, function ($v) use ($level) {
        return $v > $level;
    }));
    if (empty($higher_tables)) return false;

    $connection = $this->openConn();
    foreach ($higher_tables as $tbl) {
        $stmt = $connection->prepare(
            "SELECT COUNT(*) FROM `{$tbl}` WHERE `id_student` = ?
             AND LOWER(enrollment_status) IN ('pending','approved')
             AND (is_archived = 0 OR is_archived IS NULL)"
        );
        $stmt->execute([$id_student]);
        if ($stmt->fetchColumn() > 0) return true;
    }
    return false;
}

public function create_seven() {
    if(isset($_POST['create_seven'])) {
        $sy = $_POST['sy'] ?? '';
        $lrn = $_POST['lrn'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mi = $_POST['mi'] ?? '';
        $bdate = $_POST['bdate'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $age = $_POST['age'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_address = $_POST['current_address'] ?? '';
        $perm_address = $_POST['perm_address'] ?? '';
        $ffname = $_POST['ffname'] ?? '';
        $flname = $_POST['flname'] ?? '';
        $fmi = $_POST['fmi'] ?? '';
        $contact_f = $_POST['contact_f'] ?? ''; 
        $mlname = $_POST['mlname'] ?? '';
        $mfname = $_POST['mfname'] ?? '';
        $mmi = $_POST['mmi'] ?? '';
        $contact_m = $_POST['contact_m'] ?? '';
        $lglc = $_POST['lglc'] ?? '';
        $lsa = $_POST['lsa'] ?? '';
        $lysc = $_POST['lysc'] ?? '';
        $school_id = $_POST['school_id'] ?? '';
        // Add this to link the record to the logged-in user
        $id_student = $_POST['id_student'] ?? '';
        $is_ip    = $_POST['is_ip']    ?? 'No';
        $ip_group = ($is_ip === 'Yes') ? ($_POST['ip_group'] ?? '') : '';
        $is_4ps   = $_POST['is_4ps']   ?? 'No';
        $fourps_id = ($is_4ps === 'Yes') ? ($_POST['fourps_id'] ?? '') : '';
 
        // Handle multiple document uploads
        $uploadedPaths = [];
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = ROOT_PATH . '/uploads/documents/seven/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png',
                             'application/msword',
                             'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            foreach ($_FILES['documents']['tmp_name'] as $idx => $tmpName) {
                if ($_FILES['documents']['error'][$idx] !== UPLOAD_ERR_OK) continue;
                if ($_FILES['documents']['size'][$idx] > $maxSize) continue;
                $ftype = mime_content_type($tmpName);
                if (!in_array($ftype, $allowedTypes)) continue;
                $origName = basename($_FILES['documents']['name'][$idx]);
                $safeName = time() . '_' . $idx . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $dest)) {
                    $uploadedPaths[] = 'uploads/documents/seven/' . $safeName;
                }
            }
        }
        $documents_json = !empty($uploadedPaths) ? json_encode($uploadedPaths) : null;
 
        $connection = $this->openConn();

        // If edit_id is present, the student is resubmitting a previously
        // rejected enrollment rather than creating a brand new one.
        $edit_id = (int)($_POST['edit_id'] ?? 0);
        $editing_row = null;
        if ($edit_id > 0) {
            $editing_row = $this->get_editable_submission('tbl_seven', 'id_seven', $edit_id, $id_student);
            if (!$editing_row) {
                echo "<script>alert('This submission can no longer be edited.'); window.location.href='my_submissions.php';</script>";
                exit();
            }
        }

        // Enrollment period gate — only new submissions are blocked; a student
        // mid-resubmission of a rejected application can still finish that.
        if (!$editing_row && !$this->is_enrollment_open()) {
            $_SESSION['swal'] = [
                'icon'  => 'info',
                'title' => 'Enrollment Closed',
                'text'  => 'Enrollment is currently closed. Please check back once the school reopens enrollment.'
            ];
            header('Location: grade7.php');
            exit();
        }

        // One enrollment per account — only new submissions are checked;
        // resubmitting a rejected enrollment (editing_row set) is exempt.
        if (!$editing_row && $this->has_active_enrollment($id_student)) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Already Enrolled',
                'text'  => 'This account already has a pending enrollment. Please wait for it to be approved or rejected before submitting another.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Grade lock — this account already has a Pending/Approved Grade 7
        // record. Once approved, Grade 7 is locked; the student proceeds to
        // Grade 8 instead of re-enrolling in the same grade.
        if (!$editing_row && $this->has_grade_level_record($id_student, 'tbl_seven', 'id_seven')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 7 Already on Record',
                'text'  => 'This account already has a Grade 7 enrollment. If it was approved, please proceed to Grade 8 instead.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Forward lock — this account has already advanced to a later grade
        // level. Grade 7 is permanently locked for it, edit/resubmit included.
        if ($this->has_advanced_beyond($id_student, 'tbl_seven')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 7 Locked',
                'text'  => 'This account has already advanced beyond Grade 7. This grade level is locked.'
            ];
            header('Location: my_submissions.php');
            exit();
        }
 
        // LRN duplicate check — only for new students (old/transferee re-use their existing LRN)
        // Skip the student's own row when resubmitting.
        $student_type = trim($_POST['student_type'] ?? 'new');
        if ($student_type === 'new') {
            $lrn_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
            $lrn_taken = false;
            foreach ($lrn_tables as $_lrn_tbl) {
                $sql = "SELECT COUNT(*) FROM `{$_lrn_tbl}` WHERE `lrn` = ? AND (is_archived = 0 OR is_archived IS NULL)";
                $params = [trim($lrn)];
                if ($editing_row && $_lrn_tbl === 'tbl_seven') { $sql .= " AND id_seven != ?"; $params[] = $edit_id; }
                $lrn_stmt = $connection->prepare($sql);
                $lrn_stmt->execute($params);
                if ($lrn_stmt->fetchColumn() > 0) { $lrn_taken = true; break; }
            }
            if ($lrn_taken) {
                $safe_lrn = urlencode(trim($lrn));
                $ref = $_SERVER['HTTP_REFERER'] ?? 'javascript:history.back()';
                $sep = (strpos($ref, '?') !== false) ? '&' : '?';
                header('Location: ' . $ref . $sep . 'lrn_error=' . $safe_lrn);
                exit();
            }
        }

        // Keep the previously uploaded documents if the student didn't attach new ones
        if (empty($uploadedPaths) && $editing_row) {
            $documents_json = $editing_row['documents'] ?? null;
        }

        if ($editing_row) {
            // Resubmission: update the same row, reset status back to Pending
            $query = "UPDATE tbl_seven SET
                `sy` = ?, `lrn` = ?, `lname` = ?, `fname` = ?, `mi` = ?, `bdate` = ?, `sex` = ?, `age` = ?, `contact` = ?, `email` = ?,
                `current_address` = ?, `perm_address` = ?, `ffname` = ?, `flname` = ?, `fmi` = ?,
                `contact_f` = ?, `mlname` = ?, `mfname` = ?, `mmi` = ?, `contact_m` = ?, `lglc` = ?,
                `lsa` = ?, `lysc` = ?, `school_id` = ?, `documents` = ?,
                `is_ip` = ?, `ip_group` = ?, `is_4ps` = ?, `fourps_id` = ?,
                `enrollment_status` = 'Pending', `reject_reason` = NULL
                WHERE id_seven = ? AND id_student = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $documents_json,
                $is_ip, $ip_group, $is_4ps, $fourps_id,
                $edit_id, $id_student
            ]);
            $record_id = $edit_id;
        } else {
            // I have added `id_student` here so you know which user owns the enrollment
            $query = "INSERT INTO tbl_seven (
                `sy`, `lrn`, `lname`, `fname`, `mi`, `bdate`, `sex`, `age`, `contact`, `email`, 
                `current_address`, `perm_address`, `ffname`, `flname`, `fmi`, 
                `contact_f`, `mlname`, `mfname`, `mmi`, `contact_m`, `lglc`, 
                `lsa`, `lysc`, `school_id`, `id_student`, `documents`,
                `is_ip`, `ip_group`, `is_4ps`, `fourps_id`
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
            $stmt = $connection->prepare($query);
            
            // Ensure the count of elements in this array matches the number of '?' (30 total)
            $stmt->execute([
                $sy, $lrn, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
                $current_address, $perm_address, $ffname, $flname, $fmi, 
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
                $lsa, $lysc, $school_id, $id_student, $documents_json,
                $is_ip, $ip_group, $is_4ps, $fourps_id
            ]);
            $record_id = $connection->lastInsertId();
        }

        // Only re-run AI document review when new files were actually uploaded
        if (!empty($uploadedPaths)) {
            $this->run_ai_document_review('tbl_seven', 'id_seven', $record_id, $uploadedPaths, [
                'Full Name'                => trim("$lname, $fname $mi"),
                'Birthdate'                => $bdate,
                'LRN'                      => $lrn,
                'Last School Attended'     => $lsa,
                'Last Grade Level Completed' => $lglc,
                'Is 4Ps Beneficiary'       => $is_4ps,
                '4Ps Household ID'         => $fourps_id,
                'Is IP Member'             => $is_ip,
                'IP Group'                 => $ip_group,
            ]);
        }
 
        $successText = $editing_row ? 'Grade 7 Enrollment Resubmitted Successfully' : 'Grade 7 Enrollment Submitted Successfully';
        $redirectTo  = $editing_row ? 'my_submissions.php' : 'grade7.php';

        $_SESSION['swal'] = [
            'icon'  => 'success',
            'title' => 'Submitted!',
            'text'  => $successText
        ];
        header('Location: ' . $redirectTo);
        exit(); 
    }
}

/**
 * Lets an admin manually add an enrollee straight into Grade 7-12, mirroring the
 * public grade7.php-grade12.php forms, but WITHOUT requiring document uploads.
 * Instead of files, the admin marks the requirements as Complete, or leaves a
 * note describing what documents are still missing.
 *
 * $grade must be one of: seven, eight, nine, ten, eleven, twelve
 */
public function admin_add_enrollee($grade) {
    if (!isset($_POST['admin_add_enrollee']) || ($_POST['grade_table'] ?? '') !== $grade) return;

    $map = [
        'seven'  => ['table' => 'tbl_seven',  'id' => 'id_seven',  'course' => false, 'prev' => false],
        'eight'  => ['table' => 'tbl_eight',  'id' => 'id_eight',  'course' => false, 'prev' => true],
        'nine'   => ['table' => 'tbl_nine',   'id' => 'id_nine',   'course' => true,  'prev' => true],
        'ten'    => ['table' => 'tbl_ten',    'id' => 'id_ten',    'course' => true,  'prev' => true],
        'eleven' => ['table' => 'tbl_eleven', 'id' => 'id_eleven', 'course' => true,  'prev' => true],
        'twelve' => ['table' => 'tbl_twelve', 'id' => 'id_twelve', 'course' => true,  'prev' => true],
    ];
    if (!isset($map[$grade])) return;
    $table     = $map[$grade]['table'];
    $idCol     = $map[$grade]['id'];
    $hasCourse = $map[$grade]['course'];
    $hasPrev   = $map[$grade]['prev'];

    $sy               = trim($_POST['sy'] ?? '');
    $lrn              = trim($_POST['lrn'] ?? '');
    $course           = trim($_POST['course'] ?? '');
    $lname            = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['lname'] ?? '')));
    $fname            = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['fname'] ?? '')));
    $mi               = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['mi'] ?? '')));
    $bdate            = $_POST['bdate'] ?? '';
    $sex              = $_POST['sex'] ?? '';
    $age              = $_POST['age'] ?? '';
    $contact          = trim($_POST['contact'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $current_address  = trim($_POST['current_address'] ?? '');
    $perm_address     = trim($_POST['perm_address'] ?? '');
    $ffname           = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['ffname'] ?? '')));
    $flname           = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['flname'] ?? '')));
    $fmi              = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['fmi'] ?? '')));
    $contact_f        = trim($_POST['contact_f'] ?? '');
    $mlname           = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['mlname'] ?? '')));
    $mfname           = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['mfname'] ?? '')));
    $mmi              = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['mmi'] ?? '')));
    $contact_m        = trim($_POST['contact_m'] ?? '');
    $lglc             = trim($_POST['lglc'] ?? '');
    $lsa              = trim($_POST['lsa'] ?? '');
    $lysc             = trim($_POST['lysc'] ?? '');
    $school_id        = trim($_POST['school_id'] ?? '');
    $is_ip            = $_POST['is_ip']    ?? 'No';
    $ip_group         = ($is_ip === 'Yes') ? trim($_POST['ip_group'] ?? '') : '';
    $is_4ps           = $_POST['is_4ps']   ?? 'No';
    $fourps_id        = ($is_4ps === 'Yes') ? trim($_POST['fourps_id'] ?? '') : '';
    $prev_grade_table = trim($_POST['prev_grade_table'] ?? '');
    $prev_grade_id    = (int)($_POST['prev_grade_id'] ?? 0);

    // Requirements status instead of actual document uploads
    $requirements_status = (($_POST['requirements_status'] ?? 'Complete') === 'Incomplete') ? 'Incomplete' : 'Complete';
    $missing_docs_note   = $requirements_status === 'Incomplete' ? trim($_POST['missing_docs_note'] ?? '') : null;
    $documents_note_json = json_encode(['admin_marked' => $requirements_status, 'note' => $missing_docs_note]);

    $connection = $this->openConn();

    // Make sure the tracking columns exist (safe no-op if they already do)
    try { $connection->exec("ALTER TABLE `{$table}` ADD COLUMN `added_by_admin` TINYINT(1) NOT NULL DEFAULT 0"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE `{$table}` ADD COLUMN `requirements_status` VARCHAR(20) NOT NULL DEFAULT 'Complete'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE `{$table}` ADD COLUMN `missing_docs_note` TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE `{$table}` ADD COLUMN `enrollment_status` VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE `{$table}` ADD COLUMN `reject_reason` TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}

    // LRN duplicate check (same rule as the public enrollment forms)
    $student_type = trim($_POST['student_type'] ?? 'new');
    if ($student_type === 'new') {
        $lrn_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
        foreach ($lrn_tables as $_lrn_tbl) {
            $lrn_stmt = $connection->prepare("SELECT COUNT(*) FROM `{$_lrn_tbl}` WHERE `lrn` = ? AND (is_archived = 0 OR is_archived IS NULL)");
            $lrn_stmt->execute([$lrn]);
            if ($lrn_stmt->fetchColumn() > 0) {
                $_SESSION['swal'] = ['icon' => 'error', 'title' => 'LRN Already Registered', 'text' => 'LRN "' . $lrn . '" is already used by another enrollment.'];
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'admn_dashboard.php'));
                exit();
            }
        }
    }

    $cols = ['sy','lrn'];
    $vals = [$sy, $lrn];
    if ($hasCourse) { $cols[] = 'course'; $vals[] = $course; }
    $cols = array_merge($cols, ['lname','fname','mi','bdate','sex','age','contact','email',
        'current_address','perm_address','ffname','flname','fmi','contact_f','mlname','mfname',
        'mmi','contact_m','lglc','lsa','lysc','school_id','id_student','documents',
        'is_ip','ip_group','is_4ps','fourps_id']);
    $vals = array_merge($vals, [$lname,$fname,$mi,$bdate,$sex,$age,$contact,$email,
        $current_address,$perm_address,$ffname,$flname,$fmi,$contact_f,$mlname,$mfname,
        $mmi,$contact_m,$lglc,$lsa,$lysc,$school_id, 0, $documents_note_json,
        $is_ip,$ip_group,$is_4ps,$fourps_id]);
    if ($hasPrev) { $cols = array_merge($cols, ['prev_grade_table','prev_grade_id']); $vals = array_merge($vals, [$prev_grade_table, $prev_grade_id]); }
    $cols = array_merge($cols, ['added_by_admin','requirements_status','missing_docs_note']);
    $vals = array_merge($vals, [1, $requirements_status, $missing_docs_note]);

    // Complete requirements = auto-approved on the spot. Incomplete stays Pending
    // until an admin later marks it complete (see mark_requirements_complete()).
    $enrollment_status = ($requirements_status === 'Complete') ? 'Approved' : 'Pending';
    $cols[] = 'enrollment_status';
    $vals[] = $enrollment_status;

    $colSql = '`' . implode('`,`', $cols) . '`';
    $qMarks = implode(',', array_fill(0, count($vals), '?'));
    $stmt = $connection->prepare("INSERT INTO `{$table}` ({$colSql}) VALUES ({$qMarks})");
    $stmt->execute($vals);
    $newId = $connection->lastInsertId();

    if ($enrollment_status === 'Approved') {
        $this->add_notification(0, "Grade " . ucfirst($grade) . " Enrollment Approved",
            trim("$fname $lname") . "'s enrollment was added with complete requirements and auto-approved.", 'approved');
    }

    $_SESSION['swal'] = [
        'icon'  => 'success',
        'title' => 'Student Added',
        'text'  => trim("$fname $lname") . ' was enrolled successfully' .
                   ($requirements_status === 'Incomplete'
                        ? ' (requirements marked incomplete — status left Pending until completed).'
                        : ' and automatically approved (requirements complete).'),
    ];
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'admn_dashboard.php'));
    exit();
}

/**
 * Called when an admin edits a record whose requirements were previously marked
 * Incomplete and now flips it to Complete. Auto-approves the enrollment, same
 * as pressing "Approve" would, and notifies/emails the student.
 * $grade must be one of: seven, eight, nine, ten, eleven, twelve.
 */
public function mark_requirements_complete($grade) {
    if (!isset($_POST['mark_requirements_complete']) || ($_POST['grade_table'] ?? '') !== $grade) return;

    $map = [
        'seven'  => ['table' => 'tbl_seven',  'id' => 'id_seven'],
        'eight'  => ['table' => 'tbl_eight',  'id' => 'id_eight'],
        'nine'   => ['table' => 'tbl_nine',   'id' => 'id_nine'],
        'ten'    => ['table' => 'tbl_ten',    'id' => 'id_ten'],
        'eleven' => ['table' => 'tbl_eleven', 'id' => 'id_eleven'],
        'twelve' => ['table' => 'tbl_twelve', 'id' => 'id_twelve'],
    ];
    if (!isset($map[$grade])) return;
    $table = $map[$grade]['table'];
    $idCol = $map[$grade]['id'];
    $id    = $_POST[$idCol] ?? null;
    if (!$id) return;

    $connection = $this->openConn();

    $fetch = $connection->prepare("SELECT id_student, email, fname, lname, enrollment_status, documents FROM `{$table}` WHERE `{$idCol}` = ?");
    $fetch->execute([$id]);
    $student = $fetch->fetch();
    if (!$student) { $this->closeConn(); return; }

    // The Documents column reads its own "Incomplete"/"Complete" badge out of the
    // `documents` JSON blob (set when the admin added the enrollee). Keep it in
    // sync so it doesn't still show "Incomplete" after this action.
    $docsJson = json_decode($student['documents'] ?? '', true);
    $docsUpdate = '';
    $docsParams = [];
    if (is_array($docsJson) && array_key_exists('admin_marked', $docsJson)) {
        $docsJson['admin_marked'] = 'Complete';
        $docsJson['note'] = null;
        $docsUpdate = ', documents = ?';
        $docsParams[] = json_encode($docsJson);
    }

    $update = $connection->prepare(
        "UPDATE `{$table}` SET requirements_status = 'Complete', missing_docs_note = NULL,
         enrollment_status = 'Approved', reject_reason = NULL{$docsUpdate} WHERE `{$idCol}` = ?"
    );
    $update->execute(array_merge($docsParams, [$id]));
    $this->closeConn();

    $name = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
    $this->add_notification($student['id_student'] ?? null, 'Enrollment Approved',
        'Your requirements are now complete and your enrollment has been approved.', 'approved');

    $email = $student['email'] ?? '';
    if (!empty($email)) {
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#0b2b5c;'>Requirements Completed — Enrollment Approved</h3>
                <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                <p>Your submitted requirements are now complete and your enrollment has been
                   <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nYour requirements are now complete and your enrollment has been APPROVED.";
        $this->sendMail($email, $name, 'Enrollment Approved — Eusebia High School', $html, $alt);
    }

    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Marked Complete', 'text' => trim($name) . '\'s requirements are complete — enrollment auto-approved.'];
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'admn_dashboard.php'));
    exit();
}

public function get_single_seven($id_student){

        $id_student = $_GET['id_student'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_seven where id_student = ?");
        $stmt->execute([$id_student]);
        $student = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $student;
        }
        else{
            return false;
        }
    }


public function view_seven(){ // Changed name to match the table
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_seven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare("SELECT * from tbl_seven WHERE is_archived = 0 OR is_archived IS NULL ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

public function delete_seven(){
    if(isset($_POST['delete_seven'])) {
        $id_seven = $_POST['id_seven'];
        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_seven SET is_archived = 1, archived_at = NOW() WHERE id_seven = ?");
        $stmt->execute([$id_seven]);
        header("Refresh:0");
    }
}
private function sendMail($toEmail, $toName, $subject, $htmlBody, $altBody = '') {
    require_once __DIR__ . '/../phpmailer/Exception.php';
    require_once __DIR__ . '/../phpmailer/PHPMailer.php';
    require_once __DIR__ . '/../phpmailer/SMTP.php';
 
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'eusebiahighschool@gmail.com';
        $mail->Password   = 'ilfb ajcy gaiy iybg';
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
 
        $mail->setFrom('eusebiahighschool@gmail.com', 'Eusebia High School');
        $mail->addAddress($toEmail, $toName ?: 'Student');
 
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $altBody ?: strip_tags($htmlBody);
 
        $mail->send();
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'error' => $mail->ErrorInfo];
    }
}

/* ================================================================
   GENERIC BULK ACTION HELPERS (used by bulk_approve_*, bulk_reject_*,
   bulk_archive_* for every grade level table)
   ================================================================ */
private function bulk_update_status($table, $idCol, $gradeLabel, array $ids, $newStatus, $reject_reason = '') {
    $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
    if (empty($ids)) return 0;

    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE {$table} ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE {$table} ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}

    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $fetch = $connection->prepare("SELECT {$idCol} AS rec_id, id_student, email, fname, lname, documents, enrollment_status FROM {$table} WHERE {$idCol} IN ({$placeholders})");
    $fetch->execute($ids);
    $allRows = $fetch->fetchAll();

    // Skip records already at the target status — e.g. a Bulk Approve on a
    // mixed selection should only touch Pending/Rejected rows, leaving
    // already-Approved rows untouched (no re-update, no duplicate email).
    $students = array_values(array_filter($allRows, function ($s) use ($newStatus) {
        $current = $s['enrollment_status'] ?: 'Pending';
        return $current !== $newStatus;
    }));

    if (empty($students)) {
        $this->closeConn();
        return 0;
    }

    $actionableIds = array_column($students, 'rec_id');
    $actionablePlaceholders = implode(',', array_fill(0, count($actionableIds), '?'));

    if ($newStatus === 'Approved') {
        $update = $connection->prepare("UPDATE {$table} SET enrollment_status = 'Approved', reject_reason = NULL WHERE {$idCol} IN ({$actionablePlaceholders})");
        $update->execute($actionableIds);
    } else {
        foreach ($students as $s) {
            $this->delete_uploaded_documents($s['documents'] ?? null);
        }
        $update = $connection->prepare("UPDATE {$table} SET enrollment_status = 'Rejected', reject_reason = ?, documents = NULL WHERE {$idCol} IN ({$actionablePlaceholders})");
        $update->execute(array_merge([$reject_reason], $actionableIds));
    }

    $this->closeConn();

    foreach ($students as $s) {
        $email = $s['email'] ?? '';
        $name  = trim(($s['fname'] ?? '') . ' ' . ($s['lname'] ?? ''));

        if ($newStatus === 'Approved') {
            $this->add_notification($s['id_student'] ?? null, "{$gradeLabel} Enrollment Approved", "Your {$gradeLabel} enrollment has been approved. Please visit the school to complete your enrollment requirements.", 'approved');
            if (!empty($email)) {
                $html = "
                <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                    <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                        <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                        <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
                    </div>
                    <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                        <h3 style='color:#0b2b5c;'>&#127881; Enrollment Approved!</h3>
                        <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                        <p>We are pleased to inform you that your <strong>{$gradeLabel} enrollment</strong> has been
                           <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                        <p>Please visit the school to complete your enrollment requirements and for further instructions.</p>
                        <br>
                        <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
                    </div>
                </div>";
                $alt = "Dear $name,\n\nYour {$gradeLabel} enrollment has been APPROVED. Eusebia High School";
                $this->sendMail($email, $name, "{$gradeLabel} Enrollment Approved  Eusebia High School", $html, $alt);
            }
        } else {
            $this->add_notification($s['id_student'] ?? null, "{$gradeLabel} Enrollment Rejected", "Your {$gradeLabel} enrollment was not approved." . (!empty($reject_reason) ? " Reason: {$reject_reason}" : ''), 'rejected');
            if (!empty($email)) {
                $reasonHtml = !empty($reject_reason) ? "<p><strong>Reason:</strong> " . htmlspecialchars($reject_reason) . "</p>" : "";
                $reasonAlt  = !empty($reject_reason) ? "\nReason: $reject_reason\n" : "";
                $html = "
                <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                    <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                        <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                        <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
                    </div>
                    <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                        <h3 style='color:#c0392b;'>Enrollment Not Approved</h3>
                        <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                        <p>We regret to inform you that your <strong>{$gradeLabel} enrollment</strong> has been
                           <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                        {$reasonHtml}
                        <p>If you have questions or would like to appeal, please visit the school during office hours.</p>
                        <br>
                        <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
                    </div>
                </div>";
                $alt = "Dear $name,\n\nYour {$gradeLabel} enrollment has been REJECTED.{$reasonAlt}\nEusebia High School";
                $this->sendMail($email, $name, "{$gradeLabel} Enrollment Update  Eusebia High School", $html, $alt);
            }
        }
    }

    return count($students);
}

private function bulk_archive_records($table, $idCol, array $ids) {
    $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
    if (empty($ids)) return 0;

    $connection = $this->openConn();
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $update = $connection->prepare("UPDATE {$table} SET is_archived = 1, archived_at = NOW() WHERE {$idCol} IN ({$placeholders})");
    $update->execute($ids);
    return $update->rowCount();
}

public function approve_seven() {
    if (!isset($_POST['approve_seven'])) return;
 
    $id_seven = $_POST['id_seven'] ?? null;
    if (!$id_seven) {
        $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Invalid record.'];
        header('Location: ' . $_SERVER['PHP_SELF']); exit;
    }
 
    $connection = $this->openConn();
 
    try { $connection->exec("ALTER TABLE tbl_seven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); }
    catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_seven ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); }
    catch (PDOException $e) {}
 
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname FROM tbl_seven WHERE id_seven = ?");
    $fetch->execute([$id_seven]);
    $student = $fetch->fetch();
 
    $update = $connection->prepare("UPDATE tbl_seven SET enrollment_status = 'Approved', reject_reason = NULL WHERE id_seven = ?");
    $update->execute([$id_seven]);
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 7 Enrollment Approved', 'Your Grade 7 enrollment has been approved. Please visit the school to complete your enrollment requirements.', 'approved');
 
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
 
    if (!empty($email)) {
        $html = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#0b2b5c;'>&#127881; Enrollment Approved!</h3>
                <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                <p>We are pleased to inform you that your <strong>Grade 7 enrollment</strong> has been
                   <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                <p>Please visit the school to complete your enrollment requirements and for further instructions.</p>
                <br>
                <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div>
        </div>";
 
        $alt = "Dear $name,\n\nYour Grade 7 enrollment has been APPROVED. Eusebia High School";
 
        $result = $this->sendMail($email, $name, 'Grade 7 Enrollment Approved  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Approved!', 'text' => 'Enrollment approved and email sent to ' . $email];
        } else {
            $_SESSION['swal'] = ['icon' => 'warning', 'title' => 'Approved (Email Failed)', 'text' => 'Status updated but email could not be sent. ' . ($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Approved!', 'text' => 'Enrollment approved. No email address on record.'];
    }
 
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}
 
public function reject_seven() {
    if (!isset($_POST['reject_seven'])) return;
 
    $id_seven      = $_POST['id_seven'] ?? null;
    $reject_reason = trim($_POST['reject_reason'] ?? '');
 
    if (!$id_seven) {
        $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Invalid record.'];
        header('Location: ' . $_SERVER['PHP_SELF']); exit;
    }
 
    $connection = $this->openConn();
 
    try { $connection->exec("ALTER TABLE tbl_seven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); }
    catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_seven ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); }
    catch (PDOException $e) {}
 
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname, documents FROM tbl_seven WHERE id_seven = ?");
    $fetch->execute([$id_seven]);
    $student = $fetch->fetch();
 
    // Delete the student's uploaded documents from disk since the enrollment is being rejected.
    $this->delete_uploaded_documents($student['documents'] ?? null);
 
    $update = $connection->prepare("UPDATE tbl_seven SET enrollment_status = 'Rejected', reject_reason = ?, documents = NULL WHERE id_seven = ?");
    $update->execute([$reject_reason, $id_seven]);
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 7 Enrollment Rejected', 'Your Grade 7 enrollment was not approved.' . (!empty($reject_reason) ? ' Reason: ' . $reject_reason : ''), 'rejected');
 
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
 
    if (!empty($email)) {
        $reasonHtml = !empty($reject_reason)
            ? "<p><strong>Reason:</strong> " . htmlspecialchars($reject_reason) . "</p>"
            : "";
        $reasonAlt = !empty($reject_reason) ? "\nReason: $reject_reason\n" : "";
 
        $html = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#c0392b;'>Enrollment Not Approved</h3>
                <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                <p>We regret to inform you that your <strong>Grade 7 enrollment</strong> has been
                   <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                {$reasonHtml}
                <p>If you have questions or would like to appeal, please visit the school during office hours.</p>
                <br>
                <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div>
        </div>";
 
        $alt = "Dear $name,\n\nWe regret to inform you that your Grade 7 enrollment has been REJECTED.{$reasonAlt}\nPlease visit the school if you have questions.\n\n– Eusebia High School";
 
        $result = $this->sendMail($email, $name, 'Grade 7 Enrollment Update – Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon' => 'info', 'title' => 'Rejected', 'text' => 'Enrollment rejected and email sent to ' . $email];
        } else {
            $_SESSION['swal'] = ['icon' => 'warning', 'title' => 'Rejected (Email Failed)', 'text' => 'Status updated but email could not be sent. ' . ($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon' => 'info', 'title' => 'Rejected', 'text' => 'Enrollment rejected. No email address on record.'];
    }
 
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_approve_seven() {
    if (!isset($_POST['bulk_approve_seven'])) return;
    $count = $this->bulk_update_status('tbl_seven', 'id_seven', 'Grade 7', $_POST['bulk_ids'] ?? [], 'Approved');
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Approve Complete', 'text' => $count . ' enrollment(s) approved.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_reject_seven() {
    if (!isset($_POST['bulk_reject_seven'])) return;
    $reason = trim($_POST['bulk_reject_reason'] ?? '');
    $count = $this->bulk_update_status('tbl_seven', 'id_seven', 'Grade 7', $_POST['bulk_ids'] ?? [], 'Rejected', $reason);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Reject Complete', 'text' => $count . ' enrollment(s) rejected.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_archive_seven() {
    if (!isset($_POST['bulk_archive_seven'])) return;
    $count = $this->bulk_archive_records('tbl_seven', 'id_seven', $_POST['bulk_ids'] ?? []);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Archive Complete', 'text' => $count . ' enrollment(s) archived.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}
 
 
public function view_archived_seven(){
    $connection = $this->openConn();
    $stmt = $connection->prepare("SELECT *, 'Grade 7' AS grade_label, id_seven AS record_id, 'seven' AS grade_table FROM tbl_seven WHERE is_archived = 1");
    $stmt->execute();
    return $stmt->fetchAll();
}

public function restore_seven(){
    if(isset($_POST['restore_seven'])) {
        $id_seven = $_POST['id_seven'];
        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_seven SET is_archived = 0, archived_at = NULL WHERE id_seven = ?");
        $stmt->execute([$id_seven]);
        header("Location: admn_archive.php");
        exit();
    }
}
public function update_seven() {
    if (isset($_POST['update_seven'])) {
        $id_seven = $_GET['id_seven']; // Getting ID from URL
        $sy = $_POST['sy'];
        $lrn = $_POST['lrn'];
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mi = $_POST['mi'];
        $bdate = $_POST['bdate'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $current_address = $_POST['current_address'];
        $perm_address = $_POST['perm_address'];
        $ffname = $_POST['ffname'];
        $flname = $_POST['flname'];
        $fmi = $_POST['fmi'];
        $contact_f = $_POST['contact_f']; 
        $mlname = $_POST['mlname'];
        $mfname = $_POST['mfname'];
        $mmi = $_POST['mmi'];
        $contact_m = $_POST['contact_m'];
        $lglc = $_POST['lglc'];
        $lsa = $_POST['lsa'];
        $lysc = $_POST['lysc'];
        $school_id = $_POST['school_id'];

        $connection = $this->openConn();
        // FIXED: Removed trailing comma before WHERE and corrected column names
        $stmt = $connection->prepare("UPDATE tbl_seven SET 
            sy = ?, lrn = ?, lname = ?, fname = ?, mi = ?, bdate = ?, 
            sex = ?, age = ?, contact = ?, email = ?, current_address = ?, perm_address = ?, 
            ffname = ?, flname = ?, fmi = ?, contact_f = ?, mlname = ?, 
            mfname = ?, mmi = ?, contact_m = ?, lglc = ?, lsa = ?, 
            lysc = ?, school_id = ? 
            WHERE id_seven = ?");
            
        $stmt->execute([
            $sy, $lrn, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
            $current_address, $perm_address, $ffname, $flname, $fmi, 
            $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
            $lsa, $lysc, $school_id, $id_seven
        ]);
        
        $this->notif('Grade 7 Data Updated', 'success', 'reload');
    }
}

public function create_eight() {
    if(isset($_POST['create_eight'])) {
        $sy = $_POST['sy'] ?? '';
        $lrn = $_POST['lrn'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mi = $_POST['mi'] ?? '';
        $bdate = $_POST['bdate'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $age = $_POST['age'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_address = $_POST['current_address'] ?? '';
        $perm_address = $_POST['perm_address'] ?? '';
        $ffname = $_POST['ffname'] ?? '';
        $flname = $_POST['flname'] ?? '';
        $fmi = $_POST['fmi'] ?? '';
        $contact_f = $_POST['contact_f'] ?? ''; 
        $mlname = $_POST['mlname'] ?? '';
        $mfname = $_POST['mfname'] ?? '';
        $mmi = $_POST['mmi'] ?? '';
        $contact_m = $_POST['contact_m'] ?? '';
        $lglc = $_POST['lglc'] ?? '';
        $lsa = $_POST['lsa'] ?? '';
        $lysc = $_POST['lysc'] ?? '';
        $school_id = $_POST['school_id'] ?? '';
        // Add this to link the record to the logged-in user
        $id_student = $_POST['id_student'] ?? '';
        $is_ip    = $_POST['is_ip']    ?? 'No';
        $ip_group = ($is_ip === 'Yes') ? ($_POST['ip_group'] ?? '') : '';
        $is_4ps   = $_POST['is_4ps']   ?? 'No';
        $fourps_id = ($is_4ps === 'Yes') ? ($_POST['fourps_id'] ?? '') : '';
        $prev_grade_table = trim($_POST['prev_grade_table'] ?? '');
        $prev_grade_id    = (int)($_POST['prev_grade_id']    ?? 0); 
 
        // Handle multiple document uploads
        $uploadedPaths = [];
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = ROOT_PATH . '/uploads/documents/eight/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png',
                             'application/msword',
                             'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            foreach ($_FILES['documents']['tmp_name'] as $idx => $tmpName) {
                if ($_FILES['documents']['error'][$idx] !== UPLOAD_ERR_OK) continue;
                if ($_FILES['documents']['size'][$idx] > $maxSize) continue;
                $ftype = mime_content_type($tmpName);
                if (!in_array($ftype, $allowedTypes)) continue;
                $origName = basename($_FILES['documents']['name'][$idx]);
                $safeName = time() . '_' . $idx . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $dest)) {
                    $uploadedPaths[] = 'uploads/documents/eight/' . $safeName;
                }
            }
        }
        $documents_json = !empty($uploadedPaths) ? json_encode($uploadedPaths) : null;
 
        $connection = $this->openConn();

        $edit_id = (int)($_POST['edit_id'] ?? 0);
        $editing_row = null;
        if ($edit_id > 0) {
            $editing_row = $this->get_editable_submission('tbl_eight', 'id_eight', $edit_id, $id_student);
            if (!$editing_row) {
                echo "<script>alert('This submission can no longer be edited.'); window.location.href='my_submissions.php';</script>";
                exit();
            }
        }

        // Enrollment period gate — only new submissions are blocked; a student
        // mid-resubmission of a rejected application can still finish that.
        if (!$editing_row && !$this->is_enrollment_open()) {
            $_SESSION['swal'] = [
                'icon'  => 'info',
                'title' => 'Enrollment Closed',
                'text'  => 'Enrollment is currently closed. Please check back once the school reopens enrollment.'
            ];
            header('Location: grade8.php');
            exit();
        }

        // One enrollment per account — only new submissions are checked;
        // resubmitting a rejected enrollment (editing_row set) is exempt.
        if (!$editing_row && $this->has_active_enrollment($id_student)) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Already Enrolled',
                'text'  => 'This account already has a pending enrollment. Please wait for it to be approved or rejected before submitting another.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Grade lock — this account already has a Pending/Approved Grade 8
        // record. Once approved, Grade 8 is locked; the student proceeds to
        // Grade 9 instead of re-enrolling in the same grade.
        if (!$editing_row && $this->has_grade_level_record($id_student, 'tbl_eight', 'id_eight')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 8 Already on Record',
                'text'  => 'This account already has a Grade 8 enrollment. If it was approved, please proceed to Grade 9 instead.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Forward lock — this account has already advanced to a later grade
        // level. Grade 8 is permanently locked for it, edit/resubmit included.
        if ($this->has_advanced_beyond($id_student, 'tbl_eight')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 8 Locked',
                'text'  => 'This account has already advanced beyond Grade 8. This grade level is locked.'
            ];
            header('Location: my_submissions.php');
            exit();
        }
 
        // LRN duplicate check — only for new students (old/transferee re-use their existing LRN)
        $student_type = trim($_POST['student_type'] ?? 'new');
        if ($student_type === 'new') {
            $lrn_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
            $lrn_taken = false;
            foreach ($lrn_tables as $_lrn_tbl) {
                $sql = "SELECT COUNT(*) FROM `{$_lrn_tbl}` WHERE `lrn` = ? AND (is_archived = 0 OR is_archived IS NULL)";
                $params = [trim($lrn)];
                if ($editing_row && $_lrn_tbl === 'tbl_eight') { $sql .= " AND id_eight != ?"; $params[] = $edit_id; }
                $lrn_stmt = $connection->prepare($sql);
                $lrn_stmt->execute($params);
                if ($lrn_stmt->fetchColumn() > 0) { $lrn_taken = true; break; }
            }
            if ($lrn_taken) {
                $safe_lrn = urlencode(trim($lrn));
                $ref = $_SERVER['HTTP_REFERER'] ?? 'javascript:history.back()';
                $sep = (strpos($ref, '?') !== false) ? '&' : '?';
                header('Location: ' . $ref . $sep . 'lrn_error=' . $safe_lrn);
                exit();
            }
        }

        if (empty($uploadedPaths) && $editing_row) {
            $documents_json = $editing_row['documents'] ?? null;
        }

        if ($editing_row) {
            $query = "UPDATE tbl_eight SET
                `sy` = ?, `lrn` = ?, `lname` = ?, `fname` = ?, `mi` = ?, `bdate` = ?, `sex` = ?, `age` = ?, `contact` = ?, `email` = ?,
                `current_address` = ?, `perm_address` = ?, `ffname` = ?, `flname` = ?, `fmi` = ?,
                `contact_f` = ?, `mlname` = ?, `mfname` = ?, `mmi` = ?, `contact_m` = ?, `lglc` = ?,
                `lsa` = ?, `lysc` = ?, `school_id` = ?, `documents` = ?, `is_ip` = ?, `ip_group` = ?, `is_4ps` = ?, `fourps_id` = ?,
                `prev_grade_table` = ?, `prev_grade_id` = ?,
                `enrollment_status` = 'Pending', `reject_reason` = NULL
                WHERE id_eight = ? AND id_student = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id,
                $prev_grade_table, $prev_grade_id,
                $edit_id, $id_student
            ]);
            $record_id = $edit_id;
        } else {
            // I have added `id_student` here so you know which user owns the enrollment
            $query = "INSERT INTO tbl_eight (
                `sy`, `lrn`, `lname`, `fname`, `mi`, `bdate`, `sex`, `age`, `contact`, `email`, 
                `current_address`, `perm_address`, `ffname`, `flname`, `fmi`, 
                `contact_f`, `mlname`, `mfname`, `mmi`, `contact_m`, `lglc`, 
                `lsa`, `lysc`, `school_id`, `id_student`, `documents`, `is_ip`, `ip_group`, `is_4ps`, `fourps_id`, `prev_grade_table`, `prev_grade_id`
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
            $stmt = $connection->prepare($query);
            
            // Exact 28 element balance mapping
            $stmt->execute([
                $sy, $lrn, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
                $current_address, $perm_address, $ffname, $flname, $fmi, 
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
                $lsa, $lysc, $school_id, $id_student, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id, $prev_grade_table, $prev_grade_id
            ]);
            $record_id = $connection->lastInsertId();
        }

        if (!empty($uploadedPaths)) {
            $this->run_ai_document_review('tbl_eight', 'id_eight', $record_id, $uploadedPaths, [
                'Full Name'                => trim("$lname, $fname $mi"),
                'Birthdate'                => $bdate,
                'LRN'                      => $lrn,
                'Last School Attended'     => $lsa,
                'Last Grade Level Completed' => $lglc,
                'Is 4Ps Beneficiary'       => $is_4ps,
                '4Ps Household ID'         => $fourps_id,
                'Is IP Member'             => $is_ip,
                'IP Group'                 => $ip_group,
            ]);
        }
 
        $successText = $editing_row ? 'Grade 8 Enrollment Resubmitted Successfully' : 'Grade 8 Enrollment Submitted Successfully';
        $redirectTo  = $editing_row ? 'my_submissions.php' : 'grade8.php';

        $_SESSION['swal'] = [
            'icon'  => 'success',
            'title' => 'Submitted!',
            'text'  => $successText
        ];
        header('Location: ' . $redirectTo);
        exit(); 
    }
}
public function get_single_eight($id_student){
    $id_student = $_GET['id_student'];
    
    $connection = $this->openConn();
    $stmt = $connection->prepare("SELECT * FROM tbl_eight WHERE id_student = ?");
    $stmt->execute([$id_student]);
    $student = $stmt->fetch();
    $total = $stmt->rowCount();

    if($total > 0 )  {
        return $student;
    }
    else {
        return false;
    }
}

public function view_eight(){ 
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eight ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare("SELECT * FROM tbl_eight WHERE is_archived = 0 OR is_archived IS NULL ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

public function delete_eight(){
    if(isset($_POST['delete_eight'])) {
        $id_eight = $_POST['id_eight']; 
        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_eight SET is_archived = 1, archived_at = NOW() WHERE id_eight = ?");
        $stmt->execute([$id_eight]); 
        header("Refresh:0");
    }
}
public function approve_eight() {
    if (!isset($_POST['approve_eight'])) return;
    $id_eight = $_POST['id_eight'] ?? null;
    if (!$id_eight) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eight ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_eight ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname FROM tbl_eight WHERE id_eight = ?");
    $fetch->execute([$id_eight]);
    $student = $fetch->fetch();
    $update = $connection->prepare("UPDATE tbl_eight SET enrollment_status = 'Approved', reject_reason = NULL WHERE id_eight = ?");
    $update->execute([$id_eight]);

    // Auto-archive the previous grade record when this enrollment is approved
    $prev_tbl = null;
    $prev_pk  = 0;
    $prev_stmt = $connection->prepare("SELECT prev_grade_table, prev_grade_id FROM `tbl_eight` WHERE `id_eight` = ?");
    $prev_stmt->execute([$id_eight]);
    $prev_row = $prev_stmt->fetch(PDO::FETCH_ASSOC);
    if ($prev_row) {
        $prev_tbl = $prev_row['prev_grade_table'];
        $prev_pk  = (int)$prev_row['prev_grade_id'];
    }
    $allowed_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
    if ($prev_tbl && $prev_pk > 0 && in_array($prev_tbl, $allowed_tables)) {
        $pk_map = [
            'tbl_seven'  => 'id_seven',
            'tbl_eight'  => 'id_eight',
            'tbl_nine'   => 'id_nine',
            'tbl_ten'    => 'id_ten',
            'tbl_eleven' => 'id_eleven',
            'tbl_twelve' => 'id_twelve',
        ];
        $prev_pk_col = $pk_map[$prev_tbl];
        $archive_stmt = $connection->prepare(
            "UPDATE `{$prev_tbl}` SET is_archived = 1, archived_at = NOW() WHERE `{$prev_pk_col}` = ?"
        );
        $archive_stmt->execute([$prev_pk]);
    }
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 8 Enrollment Approved', 'Your Grade 8 enrollment has been approved. Please visit the school to complete your enrollment requirements.', 'approved');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#0b2b5c;'>&#127881; Enrollment Approved!</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We are pleased to inform you that your <strong>Grade 8 enrollment</strong> has been
                   <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                <p>Please visit the school to complete your enrollment requirements and for further instructions.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nYour Grade 8 enrollment has been APPROVED.\nPlease visit the school to complete your enrollment requirements.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 8 Enrollment Approved  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Approved (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}
 
public function reject_eight() {
    if (!isset($_POST['reject_eight'])) return;
    $id_eight      = $_POST['id_eight'] ?? null;
    $reject_reason = trim($_POST['reject_reason'] ?? '');
    if (!$id_eight) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eight ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_eight ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname, documents FROM tbl_eight WHERE id_eight = ?");
    $fetch->execute([$id_eight]);
    $student = $fetch->fetch();
    
    // Delete the student's uploaded documents from disk since the enrollment is being rejected.
    $this->delete_uploaded_documents($student['documents'] ?? null);

    $update = $connection->prepare("UPDATE tbl_eight SET enrollment_status = 'Rejected', reject_reason = ?, documents = NULL WHERE id_eight = ?");
    $update->execute([$reject_reason, $id_eight]);
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 8 Enrollment Rejected', 'Your Grade 8 enrollment was not approved.' . (!empty($reject_reason) ? ' Reason: ' . $reject_reason : ''), 'rejected');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $reasonHtml = !empty($reject_reason) ? "<p><strong>Reason:</strong> ".htmlspecialchars($reject_reason)."</p>" : "";
        $reasonAlt  = !empty($reject_reason) ? "\nReason: $reject_reason\n" : "";
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#c0392b;'>Enrollment Not Approved</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We regret to inform you that your <strong>Grade 8 enrollment</strong> has been
                   <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                {$reasonHtml}
                <p>If you have questions or would like to appeal, please visit the school during office hours.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nWe regret to inform you that your Grade 8 enrollment has been REJECTED.{$reasonAlt}\nPlease visit the school if you have questions.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 8 Enrollment Update  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Rejected (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}

public function bulk_approve_eight() {
    if (!isset($_POST['bulk_approve_eight'])) return;
    $count = $this->bulk_update_status('tbl_eight', 'id_eight', 'Grade 8', $_POST['bulk_ids'] ?? [], 'Approved');
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Approve Complete', 'text' => $count . ' enrollment(s) approved.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_reject_eight() {
    if (!isset($_POST['bulk_reject_eight'])) return;
    $reason = trim($_POST['bulk_reject_reason'] ?? '');
    $count = $this->bulk_update_status('tbl_eight', 'id_eight', 'Grade 8', $_POST['bulk_ids'] ?? [], 'Rejected', $reason);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Reject Complete', 'text' => $count . ' enrollment(s) rejected.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_archive_eight() {
    if (!isset($_POST['bulk_archive_eight'])) return;
    $count = $this->bulk_archive_records('tbl_eight', 'id_eight', $_POST['bulk_ids'] ?? []);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Archive Complete', 'text' => $count . ' enrollment(s) archived.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}
 
public function view_archived_eight(){
    $connection = $this->openConn();
    $stmt = $connection->prepare("SELECT *, 'Grade 8' AS grade_label, id_eight AS record_id, 'eight' AS grade_table FROM tbl_eight WHERE is_archived = 1");
    $stmt->execute();
    return $stmt->fetchAll();
}

public function restore_eight(){
    if(isset($_POST['restore_eight'])) {
        $id_eight = $_POST['id_eight'];
        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_eight SET is_archived = 0, archived_at = NULL WHERE id_eight = ?");
        $stmt->execute([$id_eight]);
        header("Location: admn_archive.php");
        exit();
    }
}

public function update_eight() {
    if (isset($_POST['update_eight'])) {
        $id_eight = $_GET['id_eight']; 
        $sy = $_POST['sy'];
        $lrn = $_POST['lrn'];
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mi = $_POST['mi'];
        $bdate = $_POST['bdate'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $current_address = $_POST['current_address'];
        $perm_address = $_POST['perm_address'];
        $ffname = $_POST['ffname'];
        $flname = $_POST['flname'];
        $fmi = $_POST['fmi'];
        $contact_f = $_POST['contact_f']; 
        $mlname = $_POST['mlname'];
        $mfname = $_POST['mfname'];
        $mmi = $_POST['mmi'];
        $contact_m = $_POST['contact_m'];
        $lglc = $_POST['lglc'];
        $lsa = $_POST['lsa'];
        $lysc = $_POST['lysc'];
        $school_id = $_POST['school_id'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_eight SET 
            sy = ?, lrn = ?, lname = ?, fname = ?, mi = ?, bdate = ?, 
            sex = ?, age = ?, contact = ?, email = ?, current_address = ?, perm_address = ?, 
            ffname = ?, flname = ?, fmi = ?, contact_f = ?, mlname = ?, 
            mfname = ?, mmi = ?, contact_m = ?, lglc = ?, lsa = ?, 
            lysc = ?, school_id = ? 
            WHERE id_eight = ?");
            
        $stmt->execute([
            $sy, $lrn, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
            $current_address, $perm_address, $ffname, $flname, $fmi, 
            $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
            $lsa, $lysc, $school_id, $id_eight
        ]);
        
        $this->notif('Grade 8 Data Updated', 'success', 'reload');
    }
}

public function create_nine() {
    if(isset($_POST['create_nine'])) {
        $sy = $_POST['sy'] ?? '';
        $lrn = $_POST['lrn'] ?? '';
        $course = $_POST['course'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mi = $_POST['mi'] ?? '';
        $bdate = $_POST['bdate'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $age = $_POST['age'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_address = $_POST['current_address'] ?? '';
        $perm_address = $_POST['perm_address'] ?? '';
        $ffname = $_POST['ffname'] ?? '';
        $flname = $_POST['flname'] ?? '';
        $fmi = $_POST['fmi'] ?? '';
        $contact_f = $_POST['contact_f'] ?? '';
        $mlname = $_POST['mlname'] ?? '';
        $mfname = $_POST['mfname'] ?? '';
        $mmi = $_POST['mmi'] ?? '';
        $contact_m = $_POST['contact_m'] ?? '';
        $lglc = $_POST['lglc'] ?? '';
        $lsa = $_POST['lsa'] ?? '';
        $lysc = $_POST['lysc'] ?? '';
        $school_id = $_POST['school_id'] ?? '';
        $id_student = $_POST['id_student'] ?? '';
        $prev_grade_table = trim($_POST['prev_grade_table'] ?? '');
        $prev_grade_id    = (int)($_POST['prev_grade_id']    ?? 0);
        $is_ip    = $_POST['is_ip']    ?? 'No';
        $ip_group = ($is_ip === 'Yes') ? ($_POST['ip_group'] ?? '') : '';
        $is_4ps   = $_POST['is_4ps']   ?? 'No';
        $fourps_id = ($is_4ps === 'Yes') ? ($_POST['fourps_id'] ?? '') : '';

        // Handle multiple document/picture uploads
        $uploadedPaths = [];
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = ROOT_PATH . '/uploads/documents/nine/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $allowedTypes = [
                'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $maxSize = 5 * 1024 * 1024; // 5MB
            foreach ($_FILES['documents']['tmp_name'] as $idx => $tmpName) {
                if ($_FILES['documents']['error'][$idx] !== UPLOAD_ERR_OK) continue;
                if ($_FILES['documents']['size'][$idx] > $maxSize) continue;
                $ftype = mime_content_type($tmpName);
                if (!in_array($ftype, $allowedTypes)) continue;
                $origName = basename($_FILES['documents']['name'][$idx]);
                $safeName = time() . '_' . $idx . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $dest)) {
                    $uploadedPaths[] = 'uploads/documents/nine/' . $safeName;
                }
            }
        }
        $documents_json = !empty($uploadedPaths) ? json_encode($uploadedPaths) : null;

        $connection = $this->openConn();

        $edit_id = (int)($_POST['edit_id'] ?? 0);
        $editing_row = null;
        if ($edit_id > 0) {
            $editing_row = $this->get_editable_submission('tbl_nine', 'id_nine', $edit_id, $id_student);
            if (!$editing_row) {
                echo "<script>alert('This submission can no longer be edited.'); window.location.href='my_submissions.php';</script>";
                exit();
            }
        }

        // Enrollment period gate — only new submissions are blocked; a student
        // mid-resubmission of a rejected application can still finish that.
        if (!$editing_row && !$this->is_enrollment_open()) {
            $_SESSION['swal'] = [
                'icon'  => 'info',
                'title' => 'Enrollment Closed',
                'text'  => 'Enrollment is currently closed. Please check back once the school reopens enrollment.'
            ];
            header('Location: grade9.php');
            exit();
        }

        // One enrollment per account — only new submissions are checked;
        // resubmitting a rejected enrollment (editing_row set) is exempt.
        if (!$editing_row && $this->has_active_enrollment($id_student)) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Already Enrolled',
                'text'  => 'This account already has a pending enrollment. Please wait for it to be approved or rejected before submitting another.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Grade lock — this account already has a Pending/Approved Grade 9
        // record. Once approved, Grade 9 is locked; the student proceeds to
        // Grade 10 instead of re-enrolling in the same grade.
        if (!$editing_row && $this->has_grade_level_record($id_student, 'tbl_nine', 'id_nine')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 9 Already on Record',
                'text'  => 'This account already has a Grade 9 enrollment. If it was approved, please proceed to Grade 10 instead.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Forward lock — this account has already advanced to a later grade
        // level. Grade 9 is permanently locked for it, edit/resubmit included.
        if ($this->has_advanced_beyond($id_student, 'tbl_nine')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 9 Locked',
                'text'  => 'This account has already advanced beyond Grade 9. This grade level is locked.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // LRN duplicate check — only for new students (old/transferee re-use their existing LRN)
        $student_type = trim($_POST['student_type'] ?? 'new');
        if ($student_type === 'new') {
            $lrn_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
            $lrn_taken = false;
            foreach ($lrn_tables as $_lrn_tbl) {
                $sql = "SELECT COUNT(*) FROM `{$_lrn_tbl}` WHERE `lrn` = ? AND (is_archived = 0 OR is_archived IS NULL)";
                $params = [trim($lrn)];
                if ($editing_row && $_lrn_tbl === 'tbl_nine') { $sql .= " AND id_nine != ?"; $params[] = $edit_id; }
                $lrn_stmt = $connection->prepare($sql);
                $lrn_stmt->execute($params);
                if ($lrn_stmt->fetchColumn() > 0) { $lrn_taken = true; break; }
            }
            if ($lrn_taken) {
                $safe_lrn = urlencode(trim($lrn));
                $ref = $_SERVER['HTTP_REFERER'] ?? 'javascript:history.back()';
                $sep = (strpos($ref, '?') !== false) ? '&' : '?';
                header('Location: ' . $ref . $sep . 'lrn_error=' . $safe_lrn);
                exit();
            }
        }

        if (empty($uploadedPaths) && $editing_row) {
            $documents_json = $editing_row['documents'] ?? null;
        }

        if ($editing_row) {
            $query = "UPDATE tbl_nine SET
                `sy` = ?, `lrn` = ?, `course` = ?, `lname` = ?, `fname` = ?, `mi` = ?, `bdate` = ?, `sex` = ?, `age` = ?, `contact` = ?, `email` = ?,
                `current_address` = ?, `perm_address` = ?, `ffname` = ?, `flname` = ?, `fmi` = ?,
                `contact_f` = ?, `mlname` = ?, `mfname` = ?, `mmi` = ?, `contact_m` = ?, `lglc` = ?,
                `lsa` = ?, `lysc` = ?, `school_id` = ?, `documents` = ?, `is_ip` = ?, `ip_group` = ?, `is_4ps` = ?, `fourps_id` = ?,
                `prev_grade_table` = ?, `prev_grade_id` = ?,
                `enrollment_status` = 'Pending', `reject_reason` = NULL
                WHERE id_nine = ? AND id_student = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id,
                $prev_grade_table, $prev_grade_id,
                $edit_id, $id_student
            ]);
            $record_id = $edit_id;
        } else {
            // FIXED: Added 2 additional '?' tokens to hit exactly 29 parameters
            $query = "INSERT INTO tbl_nine (
                `sy`, `lrn`, `course`, `lname`, `fname`, `mi`, `bdate`, `sex`, `age`, `contact`, `email`,
                `current_address`, `perm_address`, `ffname`, `flname`, `fmi`,
                `contact_f`, `mlname`, `mfname`, `mmi`, `contact_m`, `lglc`,
                `lsa`, `lysc`, `school_id`, `id_student`, `documents`, `is_ip`, `ip_group`, `is_4ps`, `fourps_id`, `prev_grade_table`, `prev_grade_id`
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $id_student, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id, $prev_grade_table, $prev_grade_id
            ]);
            $record_id = $connection->lastInsertId();
        }

        if (!empty($uploadedPaths)) {
            $this->run_ai_document_review('tbl_nine', 'id_nine', $record_id, $uploadedPaths, [
                'Full Name'                => trim("$lname, $fname $mi"),
                'Birthdate'                => $bdate,
                'LRN'                      => $lrn,
                'Course/Strand'            => $course,
                'Last School Attended'     => $lsa,
                'Last Grade Level Completed' => $lglc,
                'Is 4Ps Beneficiary'       => $is_4ps,
                '4Ps Household ID'         => $fourps_id,
                'Is IP Member'             => $is_ip,
                'IP Group'                 => $ip_group,
            ]);
        }

        $successText = $editing_row ? 'Grade 9 Enrollment Resubmitted Successfully' : 'Grade 9 Enrollment Submitted Successfully';
        $redirectTo  = $editing_row ? 'my_submissions.php' : 'grade9.php';

        $_SESSION['swal'] = [
            'icon'  => 'success',
            'title' => 'Submitted!',
            'text'  => $successText
        ];
        header('Location: ' . $redirectTo);
        exit();
    }
}
    public function get_single_nine($id_student){
        // Removed the $_GET overwrite so it uses the passed ID correctly
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_nine WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $student = $stmt->fetch();

        return $student ?: false;
    }

    public function view_nine(){ 
        $connection = $this->openConn();
        try { $connection->exec("ALTER TABLE tbl_nine ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
        $stmt = $connection->prepare("SELECT * FROM tbl_nine WHERE is_archived = 0 OR is_archived IS NULL ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function delete_nine(){
        if(isset($_POST['delete_nine'])) {
            $id_nine = $_POST['id_nine']; 
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_nine SET is_archived = 1, archived_at = NOW() WHERE id_nine = ?");
            $stmt->execute([$id_nine]); 
            header("Refresh:0");
            exit();
        }
    }
public function approve_nine() {
    if (!isset($_POST['approve_nine'])) return;
    $id_nine = $_POST['id_nine'] ?? null;
    if (!$id_nine) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_nine ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_nine ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname FROM tbl_nine WHERE id_nine = ?");
    $fetch->execute([$id_nine]);
    $student = $fetch->fetch();
    $update = $connection->prepare("UPDATE tbl_nine SET enrollment_status = 'Approved', reject_reason = NULL WHERE id_nine = ?");
    $update->execute([$id_nine]);

    // Auto-archive the previous grade record when this enrollment is approved
    $prev_tbl = null;
    $prev_pk  = 0;
    $prev_stmt = $connection->prepare("SELECT prev_grade_table, prev_grade_id FROM `tbl_nine` WHERE `id_nine` = ?");
    $prev_stmt->execute([$id_nine]);
    $prev_row = $prev_stmt->fetch(PDO::FETCH_ASSOC);
    if ($prev_row) {
        $prev_tbl = $prev_row['prev_grade_table'];
        $prev_pk  = (int)$prev_row['prev_grade_id'];
    }
    $allowed_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
    if ($prev_tbl && $prev_pk > 0 && in_array($prev_tbl, $allowed_tables)) {
        $pk_map = [
            'tbl_seven'  => 'id_seven',
            'tbl_eight'  => 'id_eight',
            'tbl_nine'   => 'id_nine',
            'tbl_ten'    => 'id_ten',
            'tbl_eleven' => 'id_eleven',
            'tbl_twelve' => 'id_twelve',
        ];
        $prev_pk_col = $pk_map[$prev_tbl];
        $archive_stmt = $connection->prepare(
            "UPDATE `{$prev_tbl}` SET is_archived = 1, archived_at = NOW() WHERE `{$prev_pk_col}` = ?"
        );
        $archive_stmt->execute([$prev_pk]);
    }

    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 9 Enrollment Approved', 'Your Grade 9 enrollment has been approved. Please visit the school to complete your enrollment requirements.', 'approved');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#0b2b5c;'>&#127881; Enrollment Approved!</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We are pleased to inform you that your <strong>Grade 9 enrollment</strong> has been
                   <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                <p>Please visit the school to complete your enrollment requirements and for further instructions.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nYour Grade 9 enrollment has been APPROVED.\nPlease visit the school to complete your enrollment requirements.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 9 Enrollment Approved  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Approved (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}
 
public function reject_nine() {
    if (!isset($_POST['reject_nine'])) return;
    $id_nine       = $_POST['id_nine'] ?? null;
    $reject_reason = trim($_POST['reject_reason'] ?? '');
    if (!$id_nine) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_nine ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_nine ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname, documents FROM tbl_nine WHERE id_nine = ?");
    $fetch->execute([$id_nine]);
    $student = $fetch->fetch();
    
    // Delete the student's uploaded documents from disk since the enrollment is being rejected.
    $this->delete_uploaded_documents($student['documents'] ?? null);

    $update = $connection->prepare("UPDATE tbl_nine SET enrollment_status = 'Rejected', reject_reason = ?, documents = NULL WHERE id_nine = ?");
    $update->execute([$reject_reason, $id_nine]);
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 9 Enrollment Rejected', 'Your Grade 9 enrollment was not approved.' . (!empty($reject_reason) ? ' Reason: ' . $reject_reason : ''), 'rejected');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $reasonHtml = !empty($reject_reason) ? "<p><strong>Reason:</strong> ".htmlspecialchars($reject_reason)."</p>" : "";
        $reasonAlt  = !empty($reject_reason) ? "\nReason: $reject_reason\n" : "";
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#c0392b;'>Enrollment Not Approved</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We regret to inform you that your <strong>Grade 9 enrollment</strong> has been
                   <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                {$reasonHtml}
                <p>If you have questions or would like to appeal, please visit the school during office hours.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nWe regret to inform you that your Grade 9 enrollment has been REJECTED.{$reasonAlt}\nPlease visit the school if you have questions.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 9 Enrollment Update  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Rejected (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}

public function bulk_approve_nine() {
    if (!isset($_POST['bulk_approve_nine'])) return;
    $count = $this->bulk_update_status('tbl_nine', 'id_nine', 'Grade 9', $_POST['bulk_ids'] ?? [], 'Approved');
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Approve Complete', 'text' => $count . ' enrollment(s) approved.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_reject_nine() {
    if (!isset($_POST['bulk_reject_nine'])) return;
    $reason = trim($_POST['bulk_reject_reason'] ?? '');
    $count = $this->bulk_update_status('tbl_nine', 'id_nine', 'Grade 9', $_POST['bulk_ids'] ?? [], 'Rejected', $reason);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Reject Complete', 'text' => $count . ' enrollment(s) rejected.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_archive_nine() {
    if (!isset($_POST['bulk_archive_nine'])) return;
    $count = $this->bulk_archive_records('tbl_nine', 'id_nine', $_POST['bulk_ids'] ?? []);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Archive Complete', 'text' => $count . ' enrollment(s) archived.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

    public function view_archived_nine(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT *, 'Grade 9' AS grade_label, id_nine AS record_id, 'nine' AS grade_table FROM tbl_nine WHERE is_archived = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function restore_nine(){
        if(isset($_POST['restore_nine'])) {
            $id_nine = $_POST['id_nine'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_nine SET is_archived = 0, archived_at = NULL WHERE id_nine = ?");
            $stmt->execute([$id_nine]);
            header("Location: admn_archive.php");
            exit();
        }
    }

    public function update_nine() {
        if (isset($_POST['update_nine'])) {
            // Get ID from the URL or hidden field
            $id_nine = $_GET['id_nine'] ?? $_POST['id_nine']; 
            
            $sy = $_POST['sy'];
            $lrn = $_POST['lrn'];
            $course = $_POST['course'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bdate = $_POST['bdate'];
            $sex = $_POST['sex'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $current_address = $_POST['current_address'];
            $perm_address = $_POST['perm_address'];
            $ffname = $_POST['ffname'];
            $flname = $_POST['flname'];
            $fmi = $_POST['fmi'];
            $contact_f = $_POST['contact_f']; 
            $mlname = $_POST['mlname'];
            $mfname = $_POST['mfname'];
            $mmi = $_POST['mmi'];
            $contact_m = $_POST['contact_m'];
            $lglc = $_POST['lglc'];
            $lsa = $_POST['lsa'];
            $lysc = $_POST['lysc'];
            $school_id = $_POST['school_id'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_nine SET 
                sy = ?, lrn = ?, course = ?, lname = ?, fname = ?, mi = ?, bdate = ?, 
                sex = ?, age = ?, contact = ?, email = ?, current_address = ?, perm_address = ?, 
                ffname = ?, flname = ?, fmi = ?, contact_f = ?, mlname = ?, 
                mfname = ?, mmi = ?, contact_m = ?, lglc = ?, lsa = ?, 
                lysc = ?, school_id = ? 
                WHERE id_nine = ?");
                
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
                $current_address, $perm_address, $ffname, $flname, $fmi, 
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
                $lsa, $lysc, $school_id, 
                $id_nine // Corrected: Used $id_nine instead of $id_eight
            ]);
            
            $this->notif('Grade 9 Data Updated', 'success', 'grade9.php');
            exit();
        }
    }

   public function create_ten() {
    if(isset($_POST['create_ten'])) {
        $sy = $_POST['sy'] ?? '';
        $lrn = $_POST['lrn'] ?? '';
        $course = $_POST['course'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mi = $_POST['mi'] ?? '';
        $bdate = $_POST['bdate'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $age = $_POST['age'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_address = $_POST['current_address'] ?? '';
        $perm_address = $_POST['perm_address'] ?? '';
        $ffname = $_POST['ffname'] ?? '';
        $flname = $_POST['flname'] ?? '';
        $fmi = $_POST['fmi'] ?? '';
        $contact_f = $_POST['contact_f'] ?? '';
        $mlname = $_POST['mlname'] ?? '';
        $mfname = $_POST['mfname'] ?? '';
        $mmi = $_POST['mmi'] ?? '';
        $contact_m = $_POST['contact_m'] ?? '';
        $lglc = $_POST['lglc'] ?? '';
        $lsa = $_POST['lsa'] ?? '';
        $lysc = $_POST['lysc'] ?? '';
        $school_id = $_POST['school_id'] ?? '';
        $id_student = $_POST['id_student'] ?? '';
        $prev_grade_table = trim($_POST['prev_grade_table'] ?? '');
        $prev_grade_id    = (int)($_POST['prev_grade_id']    ?? 0);
        $is_ip    = $_POST['is_ip']    ?? 'No';
        $ip_group = ($is_ip === 'Yes') ? ($_POST['ip_group'] ?? '') : '';
        $is_4ps   = $_POST['is_4ps']   ?? 'No';
        $fourps_id = ($is_4ps === 'Yes') ? ($_POST['fourps_id'] ?? '') : '';

        // Handle multiple document/picture uploads
        $uploadedPaths = [];
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = ROOT_PATH . '/uploads/documents/ten/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $allowedTypes = [
                'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $maxSize = 5 * 1024 * 1024; // 5MB
            foreach ($_FILES['documents']['tmp_name'] as $idx => $tmpName) {
                if ($_FILES['documents']['error'][$idx] !== UPLOAD_ERR_OK) continue;
                if ($_FILES['documents']['size'][$idx] > $maxSize) continue;
                $ftype = mime_content_type($tmpName);
                if (!in_array($ftype, $allowedTypes)) continue;
                $origName = basename($_FILES['documents']['name'][$idx]);
                $safeName = time() . '_' . $idx . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $dest)) {
                    $uploadedPaths[] = 'uploads/documents/ten/' . $safeName;
                }
            }
        }
        $documents_json = !empty($uploadedPaths) ? json_encode($uploadedPaths) : null;

        $connection = $this->openConn();

        $edit_id = (int)($_POST['edit_id'] ?? 0);
        $editing_row = null;
        if ($edit_id > 0) {
            $editing_row = $this->get_editable_submission('tbl_ten', 'id_ten', $edit_id, $id_student);
            if (!$editing_row) {
                echo "<script>alert('This submission can no longer be edited.'); window.location.href='my_submissions.php';</script>";
                exit();
            }
        }

        // Enrollment period gate — only new submissions are blocked; a student
        // mid-resubmission of a rejected application can still finish that.
        if (!$editing_row && !$this->is_enrollment_open()) {
            $_SESSION['swal'] = [
                'icon'  => 'info',
                'title' => 'Enrollment Closed',
                'text'  => 'Enrollment is currently closed. Please check back once the school reopens enrollment.'
            ];
            header('Location: grade10.php');
            exit();
        }

        // One enrollment per account — only new submissions are checked;
        // resubmitting a rejected enrollment (editing_row set) is exempt.
        if (!$editing_row && $this->has_active_enrollment($id_student)) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Already Enrolled',
                'text'  => 'This account already has a pending enrollment. Please wait for it to be approved or rejected before submitting another.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Grade lock — this account already has a Pending/Approved Grade 10
        // record. Once approved, Grade 10 is locked; the student proceeds to
        // Grade 11 instead of re-enrolling in the same grade.
        if (!$editing_row && $this->has_grade_level_record($id_student, 'tbl_ten', 'id_ten')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 10 Already on Record',
                'text'  => 'This account already has a Grade 10 enrollment. If it was approved, please proceed to Grade 11 instead.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Forward lock — this account has already advanced to a later grade
        // level. Grade 10 is permanently locked for it, edit/resubmit included.
        if ($this->has_advanced_beyond($id_student, 'tbl_ten')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 10 Locked',
                'text'  => 'This account has already advanced beyond Grade 10. This grade level is locked.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // LRN duplicate check — only for new students (old/transferee re-use their existing LRN)
        $student_type = trim($_POST['student_type'] ?? 'new');
        if ($student_type === 'new') {
            $lrn_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
            $lrn_taken = false;
            foreach ($lrn_tables as $_lrn_tbl) {
                $sql = "SELECT COUNT(*) FROM `{$_lrn_tbl}` WHERE `lrn` = ? AND (is_archived = 0 OR is_archived IS NULL)";
                $params = [trim($lrn)];
                if ($editing_row && $_lrn_tbl === 'tbl_ten') { $sql .= " AND id_ten != ?"; $params[] = $edit_id; }
                $lrn_stmt = $connection->prepare($sql);
                $lrn_stmt->execute($params);
                if ($lrn_stmt->fetchColumn() > 0) { $lrn_taken = true; break; }
            }
            if ($lrn_taken) {
                $safe_lrn = urlencode(trim($lrn));
                $ref = $_SERVER['HTTP_REFERER'] ?? 'javascript:history.back()';
                $sep = (strpos($ref, '?') !== false) ? '&' : '?';
                header('Location: ' . $ref . $sep . 'lrn_error=' . $safe_lrn);
                exit();
            }
        }

        if (empty($uploadedPaths) && $editing_row) {
            $documents_json = $editing_row['documents'] ?? null;
        }

        if ($editing_row) {
            $query = "UPDATE tbl_ten SET
                `sy` = ?, `lrn` = ?, `course` = ?, `lname` = ?, `fname` = ?, `mi` = ?, `bdate` = ?, `sex` = ?, `age` = ?, `contact` = ?, `email` = ?,
                `current_address` = ?, `perm_address` = ?, `ffname` = ?, `flname` = ?, `fmi` = ?,
                `contact_f` = ?, `mlname` = ?, `mfname` = ?, `mmi` = ?, `contact_m` = ?, `lglc` = ?,
                `lsa` = ?, `lysc` = ?, `school_id` = ?, `documents` = ?, `is_ip` = ?, `ip_group` = ?, `is_4ps` = ?, `fourps_id` = ?,
                `prev_grade_table` = ?, `prev_grade_id` = ?,
                `enrollment_status` = 'Pending', `reject_reason` = NULL
                WHERE id_ten = ? AND id_student = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id,
                $prev_grade_table, $prev_grade_id,
                $edit_id, $id_student
            ]);
            $record_id = $edit_id;
        } else {
            $query = "INSERT INTO tbl_ten (
                `sy`, `lrn`, `course`, `lname`, `fname`, `mi`, `bdate`, `sex`, `age`, `contact`, `email`,
                `current_address`, `perm_address`, `ffname`, `flname`, `fmi`,
                `contact_f`, `mlname`, `mfname`, `mmi`, `contact_m`, `lglc`,
                `lsa`, `lysc`, `school_id`, `id_student`, `documents`, `is_ip`, `ip_group`, `is_4ps`, `fourps_id`, `prev_grade_table`, `prev_grade_id`
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $id_student, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id, $prev_grade_table, $prev_grade_id
            ]);
            $record_id = $connection->lastInsertId();
        }

        if (!empty($uploadedPaths)) {
            $this->run_ai_document_review('tbl_ten', 'id_ten', $record_id, $uploadedPaths, [
                'Full Name'                => trim("$lname, $fname $mi"),
                'Birthdate'                => $bdate,
                'LRN'                      => $lrn,
                'Course/Strand'            => $course,
                'Last School Attended'     => $lsa,
                'Last Grade Level Completed' => $lglc,
                'Is 4Ps Beneficiary'       => $is_4ps,
                '4Ps Household ID'         => $fourps_id,
                'Is IP Member'             => $is_ip,
                'IP Group'                 => $ip_group,
            ]);
        }

        $successText = $editing_row ? 'Grade 10 Enrollment Resubmitted Successfully' : 'Grade 10 Enrollment Submitted Successfully';
        $redirectTo  = $editing_row ? 'my_submissions.php' : 'grade10.php';

        $_SESSION['swal'] = [
            'icon'  => 'success',
            'title' => 'Submitted!',
            'text'  => $successText
        ];
        header('Location: ' . $redirectTo);
        exit();
    }
}

    public function get_single_ten($id_student){
        // Removed the $_GET overwrite so it uses the passed ID correctly
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_ten WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $student = $stmt->fetch();

        return $student ?: false;
    }

    public function view_ten(){ 
        $connection = $this->openConn();
        try { $connection->exec("ALTER TABLE tbl_ten ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
        $stmt = $connection->prepare("SELECT * FROM tbl_ten WHERE is_archived = 0 OR is_archived IS NULL ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function delete_ten(){
        if(isset($_POST['delete_ten'])) {
            $id_ten = $_POST['id_ten']; 
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_ten SET is_archived = 1, archived_at = NOW() WHERE id_ten = ?");
            $stmt->execute([$id_ten]); 
            header("Refresh:0");
            exit();
        }
    }
public function approve_ten() {
    if (!isset($_POST['approve_ten'])) return;
    $id_ten = $_POST['id_ten'] ?? null;
    if (!$id_ten) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_ten ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_ten ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname FROM tbl_ten WHERE id_ten = ?");
    $fetch->execute([$id_ten]);
    $student = $fetch->fetch();
    $update = $connection->prepare("UPDATE tbl_ten SET enrollment_status = 'Approved', reject_reason = NULL WHERE id_ten = ?");
    $update->execute([$id_ten]);

    // Auto-archive the previous grade record when this enrollment is approved
    $prev_tbl = null;
    $prev_pk  = 0;
    $prev_stmt = $connection->prepare("SELECT prev_grade_table, prev_grade_id FROM `tbl_ten` WHERE `id_ten` = ?");
    $prev_stmt->execute([$id_ten]);
    $prev_row = $prev_stmt->fetch(PDO::FETCH_ASSOC);
    if ($prev_row) {
        $prev_tbl = $prev_row['prev_grade_table'];
        $prev_pk  = (int)$prev_row['prev_grade_id'];
    }
    $allowed_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
    if ($prev_tbl && $prev_pk > 0 && in_array($prev_tbl, $allowed_tables)) {
        $pk_map = [
            'tbl_seven'  => 'id_seven',
            'tbl_eight'  => 'id_eight',
            'tbl_nine'   => 'id_nine',
            'tbl_ten'    => 'id_ten',
            'tbl_eleven' => 'id_eleven',
            'tbl_twelve' => 'id_twelve',
        ];
        $prev_pk_col = $pk_map[$prev_tbl];
        $archive_stmt = $connection->prepare(
            "UPDATE `{$prev_tbl}` SET is_archived = 1, archived_at = NOW() WHERE `{$prev_pk_col}` = ?"
        );
        $archive_stmt->execute([$prev_pk]);
    }

    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 10 Enrollment Approved', 'Your Grade 10 enrollment has been approved. Please visit the school to complete your enrollment requirements.', 'approved');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#0b2b5c;'>&#127881; Enrollment Approved!</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We are pleased to inform you that your <strong>Grade 10 enrollment</strong> has been
                   <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                <p>Please visit the school to complete your enrollment requirements and for further instructions.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nYour Grade 10 enrollment has been APPROVED.\nPlease visit the school to complete your enrollment requirements.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 10 Enrollment Approved  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Approved (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}
 
public function reject_ten() {
    if (!isset($_POST['reject_ten'])) return;
    $id_ten        = $_POST['id_ten'] ?? null;
    $reject_reason = trim($_POST['reject_reason'] ?? '');
    if (!$id_ten) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_ten ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_ten ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname, documents FROM tbl_ten WHERE id_ten = ?");
    $fetch->execute([$id_ten]);
    $student = $fetch->fetch();
    
    // Delete the student's uploaded documents from disk since the enrollment is being rejected.
    $this->delete_uploaded_documents($student['documents'] ?? null);

    $update = $connection->prepare("UPDATE tbl_ten SET enrollment_status = 'Rejected', reject_reason = ?, documents = NULL WHERE id_ten = ?");
    $update->execute([$reject_reason, $id_ten]);
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 10 Enrollment Rejected', 'Your Grade 10 enrollment was not approved.' . (!empty($reject_reason) ? ' Reason: ' . $reject_reason : ''), 'rejected');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $reasonHtml = !empty($reject_reason) ? "<p><strong>Reason:</strong> ".htmlspecialchars($reject_reason)."</p>" : "";
        $reasonAlt  = !empty($reject_reason) ? "\nReason: $reject_reason\n" : "";
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#c0392b;'>Enrollment Not Approved</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We regret to inform you that your <strong>Grade 10 enrollment</strong> has been
                   <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                {$reasonHtml}
                <p>If you have questions or would like to appeal, please visit the school during office hours.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nWe regret to inform you that your Grade 10 enrollment has been REJECTED.{$reasonAlt}\nPlease visit the school if you have questions.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 10 Enrollment Update  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Rejected (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}

public function bulk_approve_ten() {
    if (!isset($_POST['bulk_approve_ten'])) return;
    $count = $this->bulk_update_status('tbl_ten', 'id_ten', 'Grade 10', $_POST['bulk_ids'] ?? [], 'Approved');
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Approve Complete', 'text' => $count . ' enrollment(s) approved.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_reject_ten() {
    if (!isset($_POST['bulk_reject_ten'])) return;
    $reason = trim($_POST['bulk_reject_reason'] ?? '');
    $count = $this->bulk_update_status('tbl_ten', 'id_ten', 'Grade 10', $_POST['bulk_ids'] ?? [], 'Rejected', $reason);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Reject Complete', 'text' => $count . ' enrollment(s) rejected.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_archive_ten() {
    if (!isset($_POST['bulk_archive_ten'])) return;
    $count = $this->bulk_archive_records('tbl_ten', 'id_ten', $_POST['bulk_ids'] ?? []);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Archive Complete', 'text' => $count . ' enrollment(s) archived.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

    public function view_archived_ten(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT *, 'Grade 10' AS grade_label, id_ten AS record_id, 'ten' AS grade_table FROM tbl_ten WHERE is_archived = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function restore_ten(){
        if(isset($_POST['restore_ten'])) {
            $id_ten = $_POST['id_ten'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_ten SET is_archived = 0, archived_at = NULL WHERE id_ten = ?");
            $stmt->execute([$id_ten]);
            header("Location: admn_archive.php");
            exit();
        }
    }

    public function update_ten() {
        if (isset($_POST['update_ten'])) {
            // Get ID from the URL or hidden field
            $id_ten = $_GET['id_ten'] ?? $_POST['id_ten']; 
            
            $sy = $_POST['sy'];
            $lrn = $_POST['lrn'];
            $course = $_POST['course'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bdate = $_POST['bdate'];
            $sex = $_POST['sex'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $current_address = $_POST['current_address'];
            $perm_address = $_POST['perm_address'];
            $ffname = $_POST['ffname'];
            $flname = $_POST['flname'];
            $fmi = $_POST['fmi'];
            $contact_f = $_POST['contact_f']; 
            $mlname = $_POST['mlname'];
            $mfname = $_POST['mfname'];
            $mmi = $_POST['mmi'];
            $contact_m = $_POST['contact_m'];
            $lglc = $_POST['lglc'];
            $lsa = $_POST['lsa'];
            $lysc = $_POST['lysc'];
            $school_id = $_POST['school_id'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_ten SET 
                sy = ?, lrn = ?, course = ?, lname = ?, fname = ?, mi = ?, bdate = ?, 
                sex = ?, age = ?, contact = ?, email = ?, current_address = ?, perm_address = ?, 
                ffname = ?, flname = ?, fmi = ?, contact_f = ?, mlname = ?, 
                mfname = ?, mmi = ?, contact_m = ?, lglc = ?, lsa = ?, 
                lysc = ?, school_id = ? 
                WHERE id_ten = ?");
                
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
                $current_address, $perm_address, $ffname, $flname, $fmi, 
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
                $lsa, $lysc, $school_id, 
                $id_ten // Corrected: Used $id_nine instead of $id_eight
            ]);
            
            $this->notif('Grade 10 Data Updated', 'success', 'grade10.php');
            exit();
        }
    } 

   public function create_eleven() {
    if(isset($_POST['create_eleven'])) {
        $sy = $_POST['sy'] ?? '';
        $lrn = $_POST['lrn'] ?? '';
        $course = $_POST['course'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mi = $_POST['mi'] ?? '';
        $bdate = $_POST['bdate'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $age = $_POST['age'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_address = $_POST['current_address'] ?? '';
        $perm_address = $_POST['perm_address'] ?? '';
        $ffname = $_POST['ffname'] ?? '';
        $flname = $_POST['flname'] ?? '';
        $fmi = $_POST['fmi'] ?? '';
        $contact_f = $_POST['contact_f'] ?? '';
        $mlname = $_POST['mlname'] ?? '';
        $mfname = $_POST['mfname'] ?? '';
        $mmi = $_POST['mmi'] ?? '';
        $contact_m = $_POST['contact_m'] ?? '';
        $lglc = $_POST['lglc'] ?? '';
        $lsa = $_POST['lsa'] ?? '';
        $lysc = $_POST['lysc'] ?? '';
        $school_id = $_POST['school_id'] ?? '';
        $id_student = $_POST['id_student'] ?? '';
        $prev_grade_table = trim($_POST['prev_grade_table'] ?? '');
        $prev_grade_id    = (int)($_POST['prev_grade_id']    ?? 0);
        $is_ip    = $_POST['is_ip']    ?? 'No';
        $ip_group = ($is_ip === 'Yes') ? ($_POST['ip_group'] ?? '') : '';
        $is_4ps   = $_POST['is_4ps']   ?? 'No';
        $fourps_id = ($is_4ps === 'Yes') ? ($_POST['fourps_id'] ?? '') : '';

        // Handle multiple document/picture uploads
        $uploadedPaths = [];
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = ROOT_PATH . '/uploads/documents/eleven/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $allowedTypes = [
                'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $maxSize = 5 * 1024 * 1024; // 5MB
            foreach ($_FILES['documents']['tmp_name'] as $idx => $tmpName) {
                if ($_FILES['documents']['error'][$idx] !== UPLOAD_ERR_OK) continue;
                if ($_FILES['documents']['size'][$idx] > $maxSize) continue;
                $ftype = mime_content_type($tmpName);
                if (!in_array($ftype, $allowedTypes)) continue;
                $origName = basename($_FILES['documents']['name'][$idx]);
                $safeName = time() . '_' . $idx . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $dest)) {
                    $uploadedPaths[] = 'uploads/documents/eleven/' . $safeName;
                }
            }
        }
        $documents_json = !empty($uploadedPaths) ? json_encode($uploadedPaths) : null;

        $connection = $this->openConn();

        $edit_id = (int)($_POST['edit_id'] ?? 0);
        $editing_row = null;
        if ($edit_id > 0) {
            $editing_row = $this->get_editable_submission('tbl_eleven', 'id_eleven', $edit_id, $id_student);
            if (!$editing_row) {
                echo "<script>alert('This submission can no longer be edited.'); window.location.href='my_submissions.php';</script>";
                exit();
            }
        }

        // Enrollment period gate — only new submissions are blocked; a student
        // mid-resubmission of a rejected application can still finish that.
        if (!$editing_row && !$this->is_enrollment_open()) {
            $_SESSION['swal'] = [
                'icon'  => 'info',
                'title' => 'Enrollment Closed',
                'text'  => 'Enrollment is currently closed. Please check back once the school reopens enrollment.'
            ];
            header('Location: grade11.php');
            exit();
        }

        // One enrollment per account — only new submissions are checked;
        // resubmitting a rejected enrollment (editing_row set) is exempt.
        if (!$editing_row && $this->has_active_enrollment($id_student)) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Already Enrolled',
                'text'  => 'This account already has a pending enrollment. Please wait for it to be approved or rejected before submitting another.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Grade lock — this account already has a Pending/Approved Grade 11
        // record. Once approved, Grade 11 is locked; the student proceeds to
        // Grade 12 instead of re-enrolling in the same grade.
        if (!$editing_row && $this->has_grade_level_record($id_student, 'tbl_eleven', 'id_eleven')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 11 Already on Record',
                'text'  => 'This account already has a Grade 11 enrollment. If it was approved, please proceed to Grade 12 instead.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Forward lock — this account has already advanced to a later grade
        // level. Grade 11 is permanently locked for it, edit/resubmit included.
        if ($this->has_advanced_beyond($id_student, 'tbl_eleven')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 11 Locked',
                'text'  => 'This account has already advanced beyond Grade 11. This grade level is locked.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // LRN duplicate check — only for new students (old/transferee re-use their existing LRN)
        $student_type = trim($_POST['student_type'] ?? 'new');
        if ($student_type === 'new') {
            $lrn_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
            $lrn_taken = false;
            foreach ($lrn_tables as $_lrn_tbl) {
                $sql = "SELECT COUNT(*) FROM `{$_lrn_tbl}` WHERE `lrn` = ? AND (is_archived = 0 OR is_archived IS NULL)";
                $params = [trim($lrn)];
                if ($editing_row && $_lrn_tbl === 'tbl_eleven') { $sql .= " AND id_eleven != ?"; $params[] = $edit_id; }
                $lrn_stmt = $connection->prepare($sql);
                $lrn_stmt->execute($params);
                if ($lrn_stmt->fetchColumn() > 0) { $lrn_taken = true; break; }
            }
            if ($lrn_taken) {
                $safe_lrn = urlencode(trim($lrn));
                $ref = $_SERVER['HTTP_REFERER'] ?? 'javascript:history.back()';
                $sep = (strpos($ref, '?') !== false) ? '&' : '?';
                header('Location: ' . $ref . $sep . 'lrn_error=' . $safe_lrn);
                exit();
            }
        }

        if (empty($uploadedPaths) && $editing_row) {
            $documents_json = $editing_row['documents'] ?? null;
        }

        if ($editing_row) {
            $query = "UPDATE tbl_eleven SET
                `sy` = ?, `lrn` = ?, `course` = ?, `lname` = ?, `fname` = ?, `mi` = ?, `bdate` = ?, `sex` = ?, `age` = ?, `contact` = ?, `email` = ?,
                `current_address` = ?, `perm_address` = ?, `ffname` = ?, `flname` = ?, `fmi` = ?,
                `contact_f` = ?, `mlname` = ?, `mfname` = ?, `mmi` = ?, `contact_m` = ?, `lglc` = ?,
                `lsa` = ?, `lysc` = ?, `school_id` = ?, `documents` = ?, `is_ip` = ?, `ip_group` = ?, `is_4ps` = ?, `fourps_id` = ?,
                `prev_grade_table` = ?, `prev_grade_id` = ?,
                `enrollment_status` = 'Pending', `reject_reason` = NULL
                WHERE id_eleven = ? AND id_student = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id,
                $prev_grade_table, $prev_grade_id,
                $edit_id, $id_student
            ]);
            $record_id = $edit_id;
        } else {
            $query = "INSERT INTO tbl_eleven (
                `sy`, `lrn`, `course`, `lname`, `fname`, `mi`, `bdate`, `sex`, `age`, `contact`, `email`,
                `current_address`, `perm_address`, `ffname`, `flname`, `fmi`,
                `contact_f`, `mlname`, `mfname`, `mmi`, `contact_m`, `lglc`,
                `lsa`, `lysc`, `school_id`, `id_student`, `documents`, `is_ip`, `ip_group`, `is_4ps`, `fourps_id`, `prev_grade_table`, `prev_grade_id`
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $id_student, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id, $prev_grade_table, $prev_grade_id
            ]);
            $record_id = $connection->lastInsertId();
        }

        if (!empty($uploadedPaths)) {
            $this->run_ai_document_review('tbl_eleven', 'id_eleven', $record_id, $uploadedPaths, [
                'Full Name'                => trim("$lname, $fname $mi"),
                'Birthdate'                => $bdate,
                'LRN'                      => $lrn,
                'Course/Strand'            => $course,
                'Last School Attended'     => $lsa,
                'Last Grade Level Completed' => $lglc,
                'Is 4Ps Beneficiary'       => $is_4ps,
                '4Ps Household ID'         => $fourps_id,
                'Is IP Member'             => $is_ip,
                'IP Group'                 => $ip_group,
            ]);
        }

        $successText = $editing_row ? 'Grade 11 Enrollment Resubmitted Successfully' : 'Grade 11 Enrollment Submitted Successfully';
        $redirectTo  = $editing_row ? 'my_submissions.php' : 'grade11.php';

        $_SESSION['swal'] = [
            'icon'  => 'success',
            'title' => 'Submitted!',
            'text'  => $successText
        ];
        header('Location: ' . $redirectTo);
        exit();
    }
}

    public function get_single_eleven($id_student){
        // Removed the $_GET overwrite so it uses the passed ID correctly
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_eleven WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $student = $stmt->fetch();

        return $student ?: false;
    }
    public function view_eleven(){ 
        $connection = $this->openConn();
        try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
        $stmt = $connection->prepare("SELECT * FROM tbl_eleven WHERE is_archived = 0 OR is_archived IS NULL ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function delete_eleven(){
        if(isset($_POST['delete_eleven'])) {
            $id_eleven = $_POST['id_eleven']; 
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_eleven SET is_archived = 1, archived_at = NOW() WHERE id_eleven = ?");
            $stmt->execute([$id_eleven]); 
            header("Refresh:0");
            exit();
        }
    }
public function approve_eleven() {
    if (!isset($_POST['approve_eleven'])) return;
    $id_eleven = $_POST['id_eleven'] ?? null;
    if (!$id_eleven) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname FROM tbl_eleven WHERE id_eleven = ?");
    $fetch->execute([$id_eleven]);
    $student = $fetch->fetch();
    $update = $connection->prepare("UPDATE tbl_eleven SET enrollment_status = 'Approved', reject_reason = NULL WHERE id_eleven = ?");
    $update->execute([$id_eleven]);

    // Auto-archive the previous grade record when this enrollment is approved
    $prev_tbl = null;
    $prev_pk  = 0;
    $prev_stmt = $connection->prepare("SELECT prev_grade_table, prev_grade_id FROM `tbl_eleven` WHERE `id_eleven` = ?");
    $prev_stmt->execute([$id_eleven]);
    $prev_row = $prev_stmt->fetch(PDO::FETCH_ASSOC);
    if ($prev_row) {
        $prev_tbl = $prev_row['prev_grade_table'];
        $prev_pk  = (int)$prev_row['prev_grade_id'];
    }
    $allowed_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
    if ($prev_tbl && $prev_pk > 0 && in_array($prev_tbl, $allowed_tables)) {
        $pk_map = [
            'tbl_seven'  => 'id_seven',
            'tbl_eight'  => 'id_eight',
            'tbl_nine'   => 'id_nine',
            'tbl_ten'    => 'id_ten',
            'tbl_eleven' => 'id_eleven',
            'tbl_twelve' => 'id_twelve',
        ];
        $prev_pk_col = $pk_map[$prev_tbl];
        $archive_stmt = $connection->prepare(
            "UPDATE `{$prev_tbl}` SET is_archived = 1, archived_at = NOW() WHERE `{$prev_pk_col}` = ?"
        );
        $archive_stmt->execute([$prev_pk]);
    }

    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 11 Enrollment Approved', 'Your Grade 11 enrollment has been approved. Please visit the school to complete your enrollment requirements.', 'approved');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#0b2b5c;'>&#127881; Enrollment Approved!</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We are pleased to inform you that your <strong>Grade 11 enrollment</strong> has been
                   <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                <p>Please visit the school to complete your enrollment requirements and for further instructions.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nYour Grade 11 enrollment has been APPROVED.\nPlease visit the school to complete your enrollment requirements.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 11 Enrollment Approved  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Approved (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}
 
public function reject_eleven() {
    if (!isset($_POST['reject_eleven'])) return;
    $id_eleven     = $_POST['id_eleven'] ?? null;
    $reject_reason = trim($_POST['reject_reason'] ?? '');
    if (!$id_eleven) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname, documents FROM tbl_eleven WHERE id_eleven = ?");
    $fetch->execute([$id_eleven]);
    $student = $fetch->fetch();
    
    // Delete the student's uploaded documents from disk since the enrollment is being rejected.
    $this->delete_uploaded_documents($student['documents'] ?? null);

    $update = $connection->prepare("UPDATE tbl_eleven SET enrollment_status = 'Rejected', reject_reason = ?, documents = NULL WHERE id_eleven = ?");
    $update->execute([$reject_reason, $id_eleven]);
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 11 Enrollment Rejected', 'Your Grade 11 enrollment was not approved.' . (!empty($reject_reason) ? ' Reason: ' . $reject_reason : ''), 'rejected');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $reasonHtml = !empty($reject_reason) ? "<p><strong>Reason:</strong> ".htmlspecialchars($reject_reason)."</p>" : "";
        $reasonAlt  = !empty($reject_reason) ? "\nReason: $reject_reason\n" : "";
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#c0392b;'>Enrollment Not Approved</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We regret to inform you that your <strong>Grade 11 enrollment</strong> has been
                   <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                {$reasonHtml}
                <p>If you have questions or would like to appeal, please visit the school during office hours.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nWe regret to inform you that your Grade 11 enrollment has been REJECTED.{$reasonAlt}\nPlease visit the school if you have questions.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 11 Enrollment Update  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Rejected (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}

public function bulk_approve_eleven() {
    if (!isset($_POST['bulk_approve_eleven'])) return;
    $count = $this->bulk_update_status('tbl_eleven', 'id_eleven', 'Grade 11', $_POST['bulk_ids'] ?? [], 'Approved');
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Approve Complete', 'text' => $count . ' enrollment(s) approved.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_reject_eleven() {
    if (!isset($_POST['bulk_reject_eleven'])) return;
    $reason = trim($_POST['bulk_reject_reason'] ?? '');
    $count = $this->bulk_update_status('tbl_eleven', 'id_eleven', 'Grade 11', $_POST['bulk_ids'] ?? [], 'Rejected', $reason);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Reject Complete', 'text' => $count . ' enrollment(s) rejected.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_archive_eleven() {
    if (!isset($_POST['bulk_archive_eleven'])) return;
    $count = $this->bulk_archive_records('tbl_eleven', 'id_eleven', $_POST['bulk_ids'] ?? []);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Archive Complete', 'text' => $count . ' enrollment(s) archived.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

    public function view_archived_eleven(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT *, 'Grade 11' AS grade_label, id_eleven AS record_id, 'eleven' AS grade_table FROM tbl_eleven WHERE is_archived = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function restore_eleven(){
        if(isset($_POST['restore_eleven'])) {
            $id_eleven = $_POST['id_eleven'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_eleven SET is_archived = 0, archived_at = NULL WHERE id_eleven = ?");
            $stmt->execute([$id_eleven]);
            header("Location: admn_archive.php");
            exit();
        }
    }

    public function update_eleven() {
        if (isset($_POST['update_eleven'])) {
            // Get ID from the URL or hidden field
            $id_eleven = $_GET['id_eleven'] ?? $_POST['id_eleven']; 
            
            $sy = $_POST['sy'];
            $lrn = $_POST['lrn'];
            $course = $_POST['course'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bdate = $_POST['bdate'];
            $sex = $_POST['sex'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $current_address = $_POST['current_address'];
            $perm_address = $_POST['perm_address'];
            $ffname = $_POST['ffname'];
            $flname = $_POST['flname'];
            $fmi = $_POST['fmi'];
            $contact_f = $_POST['contact_f']; 
            $mlname = $_POST['mlname'];
            $mfname = $_POST['mfname'];
            $mmi = $_POST['mmi'];
            $contact_m = $_POST['contact_m'];
            $lglc = $_POST['lglc'];
            $lsa = $_POST['lsa'];
            $lysc = $_POST['lysc'];
            $school_id = $_POST['school_id'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_eleven SET 
                sy = ?, lrn = ?, course = ?, lname = ?, fname = ?, mi = ?, bdate = ?, 
                sex = ?, age = ?, contact = ?, email = ?, current_address = ?, perm_address = ?, 
                ffname = ?, flname = ?, fmi = ?, contact_f = ?, mlname = ?, 
                mfname = ?, mmi = ?, contact_m = ?, lglc = ?, lsa = ?, 
                lysc = ?, school_id = ? 
                WHERE id_eleven = ?");
                
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
                $current_address, $perm_address, $ffname, $flname, $fmi, 
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
                $lsa, $lysc, $school_id, 
                $id_eleven // Corrected: Used $id_nine instead of $id_eight
            ]);
            
            $this->notif('Grade 11 Data Updated', 'success', 'grade11.php');
            exit();
        }
    }

     public function create_twelve() {
    if(isset($_POST['create_twelve'])) {
        $sy = $_POST['sy'] ?? '';
        $lrn = $_POST['lrn'] ?? '';
        $course = $_POST['course'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mi = $_POST['mi'] ?? '';
        $bdate = $_POST['bdate'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $age = $_POST['age'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_address = $_POST['current_address'] ?? '';
        $perm_address = $_POST['perm_address'] ?? '';
        $ffname = $_POST['ffname'] ?? '';
        $flname = $_POST['flname'] ?? '';
        $fmi = $_POST['fmi'] ?? '';
        $contact_f = $_POST['contact_f'] ?? '';
        $mlname = $_POST['mlname'] ?? '';
        $mfname = $_POST['mfname'] ?? '';
        $mmi = $_POST['mmi'] ?? '';
        $contact_m = $_POST['contact_m'] ?? '';
        $lglc = $_POST['lglc'] ?? '';
        $lsa = $_POST['lsa'] ?? '';
        $lysc = $_POST['lysc'] ?? '';
        $school_id = $_POST['school_id'] ?? '';
        $id_student = $_POST['id_student'] ?? '';
        $prev_grade_table = trim($_POST['prev_grade_table'] ?? '');
        $prev_grade_id    = (int)($_POST['prev_grade_id']    ?? 0);
        $is_ip    = $_POST['is_ip']    ?? 'No';
        $ip_group = ($is_ip === 'Yes') ? ($_POST['ip_group'] ?? '') : '';
        $is_4ps   = $_POST['is_4ps']   ?? 'No';
        $fourps_id = ($is_4ps === 'Yes') ? ($_POST['fourps_id'] ?? '') : '';

        // Handle multiple document/picture uploads
        $uploadedPaths = [];
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = ROOT_PATH . '/uploads/documents/twelve/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $allowedTypes = [
                'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $maxSize = 5 * 1024 * 1024; // 5MB
            foreach ($_FILES['documents']['tmp_name'] as $idx => $tmpName) {
                if ($_FILES['documents']['error'][$idx] !== UPLOAD_ERR_OK) continue;
                if ($_FILES['documents']['size'][$idx] > $maxSize) continue;
                $ftype = mime_content_type($tmpName);
                if (!in_array($ftype, $allowedTypes)) continue;
                $origName = basename($_FILES['documents']['name'][$idx]);
                $safeName = time() . '_' . $idx . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $dest)) {
                    $uploadedPaths[] = 'uploads/documents/twelve/' . $safeName;
                }
            }
        }
        $documents_json = !empty($uploadedPaths) ? json_encode($uploadedPaths) : null;

        $connection = $this->openConn();

        $edit_id = (int)($_POST['edit_id'] ?? 0);
        $editing_row = null;
        if ($edit_id > 0) {
            $editing_row = $this->get_editable_submission('tbl_twelve', 'id_twelve', $edit_id, $id_student);
            if (!$editing_row) {
                echo "<script>alert('This submission can no longer be edited.'); window.location.href='my_submissions.php';</script>";
                exit();
            }
        }

        // Enrollment period gate — only new submissions are blocked; a student
        // mid-resubmission of a rejected application can still finish that.
        if (!$editing_row && !$this->is_enrollment_open()) {
            $_SESSION['swal'] = [
                'icon'  => 'info',
                'title' => 'Enrollment Closed',
                'text'  => 'Enrollment is currently closed. Please check back once the school reopens enrollment.'
            ];
            header('Location: grade12.php');
            exit();
        }

        // One enrollment per account — only new submissions are checked;
        // resubmitting a rejected enrollment (editing_row set) is exempt.
        if (!$editing_row && $this->has_active_enrollment($id_student)) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Already Enrolled',
                'text'  => 'This account already has a pending enrollment. Please wait for it to be approved or rejected before submitting another.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // Grade lock — this account already has a Pending/Approved Grade 12
        // record. Grade 12 is the last grade level, so once approved this
        // account's enrollment history is complete.
        if (!$editing_row && $this->has_grade_level_record($id_student, 'tbl_twelve', 'id_twelve')) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Grade 12 Already on Record',
                'text'  => 'This account already has a Grade 12 enrollment on file.'
            ];
            header('Location: my_submissions.php');
            exit();
        }

        // LRN duplicate check — only for new students (old/transferee re-use their existing LRN)
        $student_type = trim($_POST['student_type'] ?? 'new');
        if ($student_type === 'new') {
            $lrn_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
            $lrn_taken = false;
            foreach ($lrn_tables as $_lrn_tbl) {
                $sql = "SELECT COUNT(*) FROM `{$_lrn_tbl}` WHERE `lrn` = ? AND (is_archived = 0 OR is_archived IS NULL)";
                $params = [trim($lrn)];
                if ($editing_row && $_lrn_tbl === 'tbl_twelve') { $sql .= " AND id_twelve != ?"; $params[] = $edit_id; }
                $lrn_stmt = $connection->prepare($sql);
                $lrn_stmt->execute($params);
                if ($lrn_stmt->fetchColumn() > 0) { $lrn_taken = true; break; }
            }
            if ($lrn_taken) {
                $safe_lrn = urlencode(trim($lrn));
                $ref = $_SERVER['HTTP_REFERER'] ?? 'javascript:history.back()';
                $sep = (strpos($ref, '?') !== false) ? '&' : '?';
                header('Location: ' . $ref . $sep . 'lrn_error=' . $safe_lrn);
                exit();
            }
        }

        if (empty($uploadedPaths) && $editing_row) {
            $documents_json = $editing_row['documents'] ?? null;
        }

        if ($editing_row) {
            $query = "UPDATE tbl_twelve SET
                `sy` = ?, `lrn` = ?, `course` = ?, `lname` = ?, `fname` = ?, `mi` = ?, `bdate` = ?, `sex` = ?, `age` = ?, `contact` = ?, `email` = ?,
                `current_address` = ?, `perm_address` = ?, `ffname` = ?, `flname` = ?, `fmi` = ?,
                `contact_f` = ?, `mlname` = ?, `mfname` = ?, `mmi` = ?, `contact_m` = ?, `lglc` = ?,
                `lsa` = ?, `lysc` = ?, `school_id` = ?, `documents` = ?, `is_ip` = ?, `ip_group` = ?, `is_4ps` = ?, `fourps_id` = ?,
                `prev_grade_table` = ?, `prev_grade_id` = ?,
                `enrollment_status` = 'Pending', `reject_reason` = NULL
                WHERE id_twelve = ? AND id_student = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id,
                $prev_grade_table, $prev_grade_id,
                $edit_id, $id_student
            ]);
            $record_id = $edit_id;
        } else {
            $query = "INSERT INTO tbl_twelve (
                `sy`, `lrn`, `course`, `lname`, `fname`, `mi`, `bdate`, `sex`, `age`, `contact`, `email`,
                `current_address`, `perm_address`, `ffname`, `flname`, `fmi`,
                `contact_f`, `mlname`, `mfname`, `mmi`, `contact_m`, `lglc`,
                `lsa`, `lysc`, `school_id`, `id_student`, `documents`, `is_ip`, `ip_group`, `is_4ps`, `fourps_id`, `prev_grade_table`, `prev_grade_id`
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $connection->prepare($query);
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email,
                $current_address, $perm_address, $ffname, $flname, $fmi,
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc,
                $lsa, $lysc, $school_id, $id_student, $documents_json, $is_ip, $ip_group, $is_4ps, $fourps_id, $prev_grade_table, $prev_grade_id
            ]);
            $record_id = $connection->lastInsertId();
        }

        if (!empty($uploadedPaths)) {
            $this->run_ai_document_review('tbl_twelve', 'id_twelve', $record_id, $uploadedPaths, [
                'Full Name'                => trim("$lname, $fname $mi"),
                'Birthdate'                => $bdate,
                'LRN'                      => $lrn,
                'Course/Strand'            => $course,
                'Last School Attended'     => $lsa,
                'Last Grade Level Completed' => $lglc,
                'Is 4Ps Beneficiary'       => $is_4ps,
                '4Ps Household ID'         => $fourps_id,
                'Is IP Member'             => $is_ip,
                'IP Group'                 => $ip_group,
            ]);
        }

        $successText = $editing_row ? 'Grade 12 Enrollment Resubmitted Successfully' : 'Grade 12 Enrollment Submitted Successfully';
        $redirectTo  = $editing_row ? 'my_submissions.php' : 'grade12.php';

        $_SESSION['swal'] = [
            'icon'  => 'success',
            'title' => 'Submitted!',
            'text'  => $successText
        ];
        header('Location: ' . $redirectTo);
        exit();
    }
}
    public function get_single_twelve($id_student){
        // Removed the $_GET overwrite so it uses the passed ID correctly
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_twelve WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $student = $stmt->fetch();

        return $student ?: false;
    }

    public function view_twelve(){ 
        $connection = $this->openConn();
        try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
        $stmt = $connection->prepare("SELECT * FROM tbl_twelve WHERE is_archived = 0 OR is_archived IS NULL ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function delete_twelve(){
        if(isset($_POST['delete_twelve'])) {
            $id_twelve = $_POST['id_twelve']; 
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_twelve SET is_archived = 1, archived_at = NOW() WHERE id_twelve = ?");
            $stmt->execute([$id_twelve]); 
            header("Refresh:0");
            exit();
        }
    }
public function approve_twelve() {
    if (!isset($_POST['approve_twelve'])) return;
    $id_twelve = $_POST['id_twelve'] ?? null;
    if (!$id_twelve) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname FROM tbl_twelve WHERE id_twelve = ?");
    $fetch->execute([$id_twelve]);
    $student = $fetch->fetch();
    $update = $connection->prepare("UPDATE tbl_twelve SET enrollment_status = 'Approved', reject_reason = NULL WHERE id_twelve = ?");
    $update->execute([$id_twelve]);

    // Auto-archive the previous grade record when this enrollment is approved
    $prev_tbl = null;
    $prev_pk  = 0;
    $prev_stmt = $connection->prepare("SELECT prev_grade_table, prev_grade_id FROM `tbl_twelve` WHERE `id_twelve` = ?");
    $prev_stmt->execute([$id_twelve]);
    $prev_row = $prev_stmt->fetch(PDO::FETCH_ASSOC);
    if ($prev_row) {
        $prev_tbl = $prev_row['prev_grade_table'];
        $prev_pk  = (int)$prev_row['prev_grade_id'];
    }
    $allowed_tables = ['tbl_seven','tbl_eight','tbl_nine','tbl_ten','tbl_eleven','tbl_twelve'];
    if ($prev_tbl && $prev_pk > 0 && in_array($prev_tbl, $allowed_tables)) {
        $pk_map = [
            'tbl_seven'  => 'id_seven',
            'tbl_eight'  => 'id_eight',
            'tbl_nine'   => 'id_nine',
            'tbl_ten'    => 'id_ten',
            'tbl_eleven' => 'id_eleven',
            'tbl_twelve' => 'id_twelve',
        ];
        $prev_pk_col = $pk_map[$prev_tbl];
        $archive_stmt = $connection->prepare(
            "UPDATE `{$prev_tbl}` SET is_archived = 1, archived_at = NOW() WHERE `{$prev_pk_col}` = ?"
        );
        $archive_stmt->execute([$prev_pk]);
    }

    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 12 Enrollment Approved', 'Your Grade 12 enrollment has been approved. Please visit the school to complete your enrollment requirements.', 'approved');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#0b2b5c;'>&#127881; Enrollment Approved!</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We are pleased to inform you that your <strong>Grade 12 enrollment</strong> has been
                   <span style='color:#28a745;font-weight:bold;'>APPROVED</span>.</p>
                <p>Please visit the school to complete your enrollment requirements and for further instructions.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nYour Grade 12 enrollment has been APPROVED.\nPlease visit the school to complete your enrollment requirements.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 12 Enrollment Approved  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Approved (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved!','text'=>'Enrollment approved. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}
 
public function reject_twelve() {
    if (!isset($_POST['reject_twelve'])) return;
    $id_twelve     = $_POST['id_twelve'] ?? null;
    $reject_reason = trim($_POST['reject_reason'] ?? '');
    if (!$id_twelve) {
        $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid record.'];
        header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN reject_reason TEXT NULL DEFAULT NULL"); } catch (PDOException $e) {}
    $fetch = $connection->prepare("SELECT id_student, email, fname, lname, documents FROM tbl_twelve WHERE id_twelve = ?");
    $fetch->execute([$id_twelve]);
    $student = $fetch->fetch();
    
    // Delete the student's uploaded documents from disk since the enrollment is being rejected.
    $this->delete_uploaded_documents($student['documents'] ?? null);

    $update = $connection->prepare("UPDATE tbl_twelve SET enrollment_status = 'Rejected', reject_reason = ?, documents = NULL WHERE id_twelve = ?");
    $update->execute([$reject_reason, $id_twelve]);
    $this->closeConn();
    $this->add_notification($student['id_student'] ?? null, 'Grade 12 Enrollment Rejected', 'Your Grade 12 enrollment was not approved.' . (!empty($reject_reason) ? ' Reason: ' . $reject_reason : ''), 'rejected');
    $email = $student['email'] ?? '';
    $name  = trim(($student['fname'] ?? '').' '.($student['lname'] ?? ''));
    if (!empty($email)) {
        $reasonHtml = !empty($reject_reason) ? "<p><strong>Reason:</strong> ".htmlspecialchars($reject_reason)."</p>" : "";
        $reasonAlt  = !empty($reject_reason) ? "\nReason: $reject_reason\n" : "";
        $html = "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Enrollment Notification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                <h3 style='color:#c0392b;'>Enrollment Not Approved</h3>
                <p>Dear <strong>".htmlspecialchars($name)."</strong>,</p>
                <p>We regret to inform you that your <strong>Grade 12 enrollment</strong> has been
                   <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                {$reasonHtml}
                <p>If you have questions or would like to appeal, please visit the school during office hours.</p>
                <br><p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
            </div></div>";
        $alt = "Dear $name,\n\nWe regret to inform you that your Grade 12 enrollment has been REJECTED.{$reasonAlt}\nPlease visit the school if you have questions.\n\n– Eusebia High School";
        $result = $this->sendMail($email, $name, 'Grade 12 Enrollment Update  Eusebia High School', $html, $alt);
        if ($result['success']) {
            $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected and email sent to '.$email];
        } else {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Rejected (Email Failed)','text'=>'Status updated but email could not be sent. '.($result['error'] ?? '')];
        }
    } else {
        $_SESSION['swal'] = ['icon'=>'info','title'=>'Rejected','text'=>'Enrollment rejected. No email address on record.'];
    }
    header('Location: '.$_SERVER['PHP_SELF']); exit;
}

public function bulk_approve_twelve() {
    if (!isset($_POST['bulk_approve_twelve'])) return;
    $count = $this->bulk_update_status('tbl_twelve', 'id_twelve', 'Grade 12', $_POST['bulk_ids'] ?? [], 'Approved');
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Approve Complete', 'text' => $count . ' enrollment(s) approved.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_reject_twelve() {
    if (!isset($_POST['bulk_reject_twelve'])) return;
    $reason = trim($_POST['bulk_reject_reason'] ?? '');
    $count = $this->bulk_update_status('tbl_twelve', 'id_twelve', 'Grade 12', $_POST['bulk_ids'] ?? [], 'Rejected', $reason);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Reject Complete', 'text' => $count . ' enrollment(s) rejected.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

public function bulk_archive_twelve() {
    if (!isset($_POST['bulk_archive_twelve'])) return;
    $count = $this->bulk_archive_records('tbl_twelve', 'id_twelve', $_POST['bulk_ids'] ?? []);
    $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Bulk Archive Complete', 'text' => $count . ' enrollment(s) archived.'];
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

    public function view_archived_twelve(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT *, 'Grade 12' AS grade_label, id_twelve AS record_id, 'twelve' AS grade_table FROM tbl_twelve WHERE is_archived = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function restore_twelve(){
        if(isset($_POST['restore_twelve'])) {
            $id_twelve = $_POST['id_twelve'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_twelve SET is_archived = 0, archived_at = NULL WHERE id_twelve = ?");
            $stmt->execute([$id_twelve]);
            header("Location: admn_archive.php");
            exit();
        }
    }

    public function update_twelve() {
        if (isset($_POST['update_twelve'])) {
            // Get ID from the URL or hidden field
            $id_twelve = $_GET['id_twelve'] ?? $_POST['id_twelve']; 
            
            $sy = $_POST['sy'];
            $lrn = $_POST['lrn'];
            $course = $_POST['course'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bdate = $_POST['bdate'];
            $sex = $_POST['sex'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $current_address = $_POST['current_address'];
            $perm_address = $_POST['perm_address'];
            $ffname = $_POST['ffname'];
            $flname = $_POST['flname'];
            $fmi = $_POST['fmi'];
            $contact_f = $_POST['contact_f']; 
            $mlname = $_POST['mlname'];
            $mfname = $_POST['mfname'];
            $mmi = $_POST['mmi'];
            $contact_m = $_POST['contact_m'];
            $lglc = $_POST['lglc'];
            $lsa = $_POST['lsa'];
            $lysc = $_POST['lysc'];
            $school_id = $_POST['school_id'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_twelve SET 
                sy = ?, lrn = ?, course = ?, lname = ?, fname = ?, mi = ?, bdate = ?, 
                sex = ?, age = ?, contact = ?, email = ?, current_address = ?, perm_address = ?, 
                ffname = ?, flname = ?, fmi = ?, contact_f = ?, mlname = ?, 
                mfname = ?, mmi = ?, contact_m = ?, lglc = ?, lsa = ?, 
                lysc = ?, school_id = ? 
                WHERE id_twelve = ?");
                
            $stmt->execute([
                $sy, $lrn, $course, $lname, $fname, $mi, $bdate, $sex, $age, $contact, $email, 
                $current_address, $perm_address, $ffname, $flname, $fmi, 
                $contact_f, $mlname, $mfname, $mmi, $contact_m, $lglc, 
                $lsa, $lysc, $school_id, 
                $id_twelve // Corrected: Used $id_nine instead of $id_eight
            ]);
            
            $this->notif('Grade 12 Data Updated', 'success', 'grade12.php');
            exit();
        }
    }
    
    // ─────────────────────────────────────────────────────────────────
    //  GRADE PROMOTION FEATURE
    //  Tables: tbl_seven(7) → tbl_eight(8) → tbl_nine(9) → tbl_ten(10)
    //          → tbl_eleven(11) → tbl_twelve(12)
    //  Grade 7 & 8 have NO 'course' column.
    //  Grades 9-12 HAVE a 'course' column.
    // ─────────────────────────────────────────────────────────────────

    private $grade_table_map = [
        '7'  => ['table' => 'tbl_seven',  'pk' => 'id_seven',  'has_course' => false],
        '8'  => ['table' => 'tbl_eight',  'pk' => 'id_eight',  'has_course' => false],
        '9'  => ['table' => 'tbl_nine',   'pk' => 'id_nine',   'has_course' => true],
        '10' => ['table' => 'tbl_ten',    'pk' => 'id_ten',    'has_course' => true],
        '11' => ['table' => 'tbl_eleven', 'pk' => 'id_eleven', 'has_course' => true],
        '12' => ['table' => 'tbl_twelve', 'pk' => 'id_twelve', 'has_course' => true],
    ];

    /**
     * Returns all active (non-archived) students in a given grade table.
     * Adds a 'record_id' alias so the view can reference the PK generically.
     */
    public function get_students_for_promotion($from_grade) {
        if (!isset($this->grade_table_map[$from_grade])) return [];

        $cfg   = $this->grade_table_map[$from_grade];
        $table = $cfg['table'];
        $pk    = $cfg['pk'];

        $conn  = $this->openConn();
        $sql   = "SELECT *, {$pk} AS record_id FROM {$table}
                  WHERE is_archived = 0 OR is_archived IS NULL
                  ORDER BY lname, fname";
        $stmt  = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Promotes selected students from one grade table to the next.
     *
     * @param  string $from_grade    Source grade number string ('7'–'11')
     * @param  string $to_grade      Target grade number string ('8'–'12')
     * @param  string $new_sy        New school year, e.g. '2026-2027'
     * @param  array  $selected_ids  Array of source PKs to promote
     * @return array  ['success' => bool, 'message' => string]
     */
    public function promote_students($from_grade, $to_grade, $new_sy, $selected_ids) {
        // Validate parameters
        if (!isset($this->grade_table_map[$from_grade]) ||
            !isset($this->grade_table_map[$to_grade])) {
            return ['success' => false, 'message' => 'Invalid grade selection.'];
        }

        $expected_next = (string)((int)$from_grade + 1);
        if ($to_grade !== $expected_next) {
            return ['success' => false, 'message' => 'You can only promote to the immediately next grade.'];
        }

        if (empty($selected_ids)) {
            return ['success' => false, 'message' => 'No students were selected for promotion.'];
        }

        // Sanitise school year format  YYYY-YYYY
        if (!preg_match('/^\d{4}-\d{4}$/', $new_sy)) {
            return ['success' => false, 'message' => 'Invalid school year format. Use YYYY-YYYY (e.g. 2026-2027).'];
        }

        $src_cfg   = $this->grade_table_map[$from_grade];
        $dst_cfg   = $this->grade_table_map[$to_grade];
        $src_table = $src_cfg['table'];
        $src_pk    = $src_cfg['pk'];
        $dst_table = $dst_cfg['table'];
        $dst_has_course = $dst_cfg['has_course'];

        // Course overrides submitted from the form (keyed by source PK)
        $course_overrides = $_POST['course_override'] ?? [];
        $default_course   = trim($_POST['default_course'] ?? '');

        $conn = $this->openConn();
        $promoted = 0;
        $skipped  = 0;
        $errors   = [];

        $conn->beginTransaction();
        try {
            foreach ($selected_ids as $src_id) {
                $src_id = (int)$src_id;

                // Fetch source row
                $fetch = $conn->prepare("SELECT * FROM {$src_table} WHERE {$src_pk} = ?");
                $fetch->execute([$src_id]);
                $row = $fetch->fetch(PDO::FETCH_ASSOC);

                if (!$row) {
                    $skipped++;
                    continue;
                }

                // Check if already promoted (same student in destination)
                $dup_check = $conn->prepare(
                    "SELECT COUNT(*) FROM {$dst_table}
                     WHERE id_student = ? AND (is_archived = 0 OR is_archived IS NULL)"
                );
                $dup_check->execute([$row['id_student']]);
                if ($dup_check->fetchColumn() > 0) {
                    $skipped++;
                    $errors[] = "Student {$row['lname']}, {$row['fname']} already exists in the destination grade (skipped).";
                    continue;
                }

                // Resolve course value for destination
                $course_val = '';
                if ($dst_has_course) {
                    if (isset($course_overrides[$src_id]) && trim($course_overrides[$src_id]) !== '') {
                        $course_val = trim($course_overrides[$src_id]);
                    } elseif ($default_course !== '') {
                        $course_val = $default_course;
                    } elseif (isset($row['course'])) {
                        $course_val = $row['course'];
                    }
                    if ($course_val === '') $course_val = 'N/A';
                }

                // Build INSERT
                $common_fields = [
                    'id_student', 'lrn', 'lname', 'fname', 'mi',
                    'bdate', 'sex', 'age', 'contact', 'email',
                    'current_address', 'perm_address',
                    'ffname', 'flname', 'fmi', 'contact_f',
                    'mlname', 'mfname', 'mmi', 'contact_m',
                    'lglc', 'lsa', 'lysc', 'school_id'
                ];

                if ($dst_has_course) {
                    $insert_cols = array_merge(['sy', 'lrn', 'course'], array_diff($common_fields, ['lrn']));
                    // build ordered value list
                    $vals = [
                        $new_sy,
                        $row['lrn'],
                        $course_val,
                        $row['id_student'],
                        // remaining common fields minus id_student and lrn
                    ];
                    // Easier: build col=>val map
                    $col_val = ['sy' => $new_sy, 'course' => $course_val];
                    foreach ($common_fields as $f) {
                        $col_val[$f] = $row[$f] ?? '';
                    }
                    // Promoted students are pre-approved — no second approval needed
                    $col_val['enrollment_status'] = 'Approved';
                } else {
                    $col_val = ['sy' => $new_sy];
                    foreach ($common_fields as $f) {
                        $col_val[$f] = $row[$f] ?? '';
                    }
                    // Promoted students are pre-approved — no second approval needed
                    $col_val['enrollment_status'] = 'Approved';
                }

                $cols        = implode(', ', array_keys($col_val));
                $placeholders = implode(', ', array_fill(0, count($col_val), '?'));
                $insert = $conn->prepare(
                    "INSERT INTO {$dst_table} ({$cols}) VALUES ({$placeholders})"
                );
                $insert->execute(array_values($col_val));

                // Archive the source record
                $archive = $conn->prepare(
                    "UPDATE {$src_table} SET is_archived = 1, archived_at = NOW() WHERE {$src_pk} = ?"
                );
                $archive->execute([$src_id]);

                $promoted++;
            }

            $conn->commit();

            $msg = "{$promoted} student(s) promoted from Grade {$from_grade} to Grade {$to_grade} for school year {$new_sy}.";
            if ($skipped > 0) {
                $msg .= " {$skipped} skipped (duplicate or not found).";
            }
            if (!empty($errors)) {
                $msg .= ' Notes: ' . implode(' | ', $errors);
            }
            return ['success' => true, 'message' => $msg];

        } catch (Exception $e) {
            $conn->rollBack();
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
    public function submit_promotion_request() {
        if (!isset($_POST['submit_promotion_request'])) return;
 
        $conn = $this->openConn();
 
        // Ensure table exists
        $conn->exec("CREATE TABLE IF NOT EXISTS tbl_promotion_requests (
            id           INT AUTO_INCREMENT PRIMARY KEY,
            id_student  INT NOT NULL,
            from_grade   VARCHAR(5) NOT NULL,
            to_grade     VARCHAR(5) NOT NULL,
            record_id    INT NOT NULL,
            documents    TEXT,
            notes        TEXT,
            status       VARCHAR(20) NOT NULL DEFAULT 'Pending',
            reject_reason TEXT,
            submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            reviewed_at  DATETIME,
            reviewed_by  INT
        )");
 
        $user = $this->get_userdata();
        if (empty($user)) { return; }
 
        $id_student = (int)($user['id_student'] ?? 0);
        $from_grade  = trim($_POST['from_grade'] ?? '');
        $record_id   = (int)($_POST['record_id'] ?? 0);
        $notes       = trim($_POST['notes'] ?? '');
 
        $grade_map = [
            '7' => '8', '8' => '9', '9' => '10',
            '10' => '11', '11' => '12'
        ];
        if (!isset($grade_map[$from_grade]) || $id_student === 0 || $record_id === 0) {
            $_SESSION['swal'] = ['icon'=>'error','title'=>'Error','text'=>'Invalid promotion request.'];
            header('Location: promotion_request.php'); exit;
        }
        $to_grade = $grade_map[$from_grade];

        // Bug Fix 2: Verify the student's enrollment in the source grade is actually Approved
        $src_table_map = [
            '7'  => ['table' => 'tbl_seven',  'pk' => 'id_seven'],
            '8'  => ['table' => 'tbl_eight',  'pk' => 'id_eight'],
            '9'  => ['table' => 'tbl_nine',   'pk' => 'id_nine'],
            '10' => ['table' => 'tbl_ten',    'pk' => 'id_ten'],
            '11' => ['table' => 'tbl_eleven', 'pk' => 'id_eleven'],
        ];
        $src = $src_table_map[$from_grade];
        $enr_check = $conn->prepare(
            "SELECT enrollment_status FROM {$src['table']}
             WHERE {$src['pk']} = ? AND id_student = ? AND (is_archived = 0 OR is_archived IS NULL)
             LIMIT 1"
        );
        $enr_check->execute([$record_id, $id_student]);
        $enr_row = $enr_check->fetch(PDO::FETCH_ASSOC);
        if (!$enr_row || strtolower($enr_row['enrollment_status'] ?? '') !== 'approved') {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Not Yet Approved',
                'text'=>'Your enrollment for this grade must be approved before you can request a promotion.'];
            header('Location: promotion_request.php'); exit;
        }

        // Bug Fix 3: Block if a Pending OR Approved promotion request already exists for this grade
        $dup = $conn->prepare(
            "SELECT id FROM tbl_promotion_requests
             WHERE id_student = ? AND from_grade = ? AND status IN ('Pending', 'Approved')"
        );
        $dup->execute([$id_student, $from_grade]);
        $dup_row = $dup->fetch();
        if ($dup_row) {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'Already Processed',
                'text'=>'You already have a pending or approved promotion request for this grade.'];
            header('Location: promotion_request.php'); exit;
        }
 
        // Handle file uploads
        $uploadedPaths = [];
        if (!empty($_FILES['documents']['name'][0])) {
            $uploadDir = ROOT_PATH . '/uploads/promotion_docs/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $allowedTypes = [
                'image/jpeg','image/png','image/gif','image/webp',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $maxSize = 5 * 1024 * 1024; // 5 MB
            foreach ($_FILES['documents']['tmp_name'] as $idx => $tmpName) {
                if ($_FILES['documents']['error'][$idx] !== UPLOAD_ERR_OK) continue;
                if ($_FILES['documents']['size'][$idx] > $maxSize) continue;
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime  = $finfo->file($tmpName);
                if (!in_array($mime, $allowedTypes)) continue;
                $origName  = basename($_FILES['documents']['name'][$idx]);
                $safeName  = time() . '_' . $id_student . '_' . $idx . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $origName);
                $dest      = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $dest)) {
                    $uploadedPaths[] = 'uploads/promotion_docs/' . $safeName;
                }
            }
        }
 
        $docs_json = !empty($uploadedPaths) ? json_encode($uploadedPaths) : null;
 
        $ins = $conn->prepare(
            "INSERT INTO tbl_promotion_requests
             (id_student, from_grade, to_grade, record_id, documents, notes, status, submitted_at)
             VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())"
        );
        $ins->execute([$id_student, $from_grade, $to_grade, $record_id, $docs_json, $notes]);
 
        $_SESSION['swal'] = ['icon'=>'success','title'=>'Request Submitted!',
            'text'=>'Your promotion request has been submitted. Please wait for admin approval.'];
        header('Location: my_submissions.php'); exit;
    }
 
    /**
     * Returns all promotion requests for the current student.
     */
    public function get_my_promotion_requests() {
        $conn = $this->openConn();
        try {
            $conn->exec("CREATE TABLE IF NOT EXISTS tbl_promotion_requests (
                id INT AUTO_INCREMENT PRIMARY KEY,
                id_student INT NOT NULL,
                from_grade VARCHAR(5) NOT NULL,
                to_grade VARCHAR(5) NOT NULL,
                record_id INT NOT NULL,
                documents TEXT,
                notes TEXT,
                status VARCHAR(20) NOT NULL DEFAULT 'Pending',
                reject_reason TEXT,
                submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                reviewed_at DATETIME,
                reviewed_by INT
            )");
            $user = $this->get_userdata();
            if (empty($user)) return [];
            $id_student = (int)($user['id_student'] ?? 0);
            $stmt = $conn->prepare(
                "SELECT * FROM tbl_promotion_requests WHERE id_student = ? ORDER BY submitted_at DESC"
            );
            $stmt->execute([$id_student]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { return []; }
    }
 
    /**
     * Admin: returns all promotion requests with student name info.
     */
    public function admin_get_promotion_requests($status_filter = '') {
        $conn = $this->openConn();
        try {
            $conn->exec("CREATE TABLE IF NOT EXISTS tbl_promotion_requests (
                id INT AUTO_INCREMENT PRIMARY KEY,
                id_student INT NOT NULL,
                from_grade VARCHAR(5) NOT NULL,
                to_grade VARCHAR(5) NOT NULL,
                record_id INT NOT NULL,
                documents TEXT,
                notes TEXT,
                status VARCHAR(20) NOT NULL DEFAULT 'Pending',
                reject_reason TEXT,
                submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                reviewed_at DATETIME,
                reviewed_by INT
            )");
            $where = $status_filter ? "WHERE pr.status = ?" : "";
            $sql = "SELECT pr.*, r.fname, r.lname, r.mi
                    FROM tbl_promotion_requests pr
                    LEFT JOIN tbl_student r ON r.id_student = pr.id_student
                    {$where}
                    ORDER BY pr.submitted_at DESC";
            $stmt = $conn->prepare($sql);
            $status_filter ? $stmt->execute([$status_filter]) : $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { return []; }
    }
 
    /**
     * Admin: approve a promotion request and actually promote the student.
     */
    public function admin_approve_promotion_request() {
        if (!isset($_POST['approve_promotion_request'])) return;
        $this->validate_admin();
 
        $id     = (int)($_POST['request_id'] ?? 0);
        $new_sy = trim($_POST['new_sy'] ?? '');
        $conn   = $this->openConn();
 
        // Fetch the promotion request
        $stmt = $conn->prepare("SELECT * FROM tbl_promotion_requests WHERE id = ?");
        $stmt->execute([$id]);
        $req = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$req || $req['status'] !== 'Pending') {
            $_SESSION['swal'] = ['icon'=>'error','title'=>'Error','text'=>'Request not found or already processed.'];
            header('Location: admn_promotion_requests.php'); exit;
        }
 
        if (!preg_match('/^\d{4}-\d{4}$/', $new_sy)) {
            $_SESSION['swal'] = ['icon'=>'error','title'=>'Invalid SY','text'=>'School year must be in YYYY-YYYY format.'];
            header('Location: admn_promotion_requests.php'); exit;
        }
 
        // Fetch the student's email and name from tbl_student
        $res = $conn->prepare("SELECT fname, lname, email FROM tbl_student WHERE id_student = ?");
        $res->execute([$req['id_student']]);
        $student = $res->fetch(PDO::FETCH_ASSOC);
        $email = $student['email'] ?? '';
        $name  = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
        $from_label = 'Grade ' . $req['from_grade'];
        $to_label   = 'Grade ' . $req['to_grade'];
 
        // Perform the actual promotion
        $result = $this->promote_students(
            $req['from_grade'],
            $req['to_grade'],
            $new_sy,
            [$req['record_id']]
        );
 
        if ($result['success']) {
            $conn->prepare(
                "UPDATE tbl_promotion_requests SET status='Approved', reviewed_at=NOW() WHERE id=?"
            )->execute([$id]);

            $this->add_notification(
                $req['id_student'] ?? null,
                'Promotion Request Approved',
                "Your grade promotion request from {$from_label} to {$to_label} has been approved for School Year {$new_sy}.",
                'approved'
            );
 
            // Send approval email
            if (!empty($email)) {
                $html = "
                <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                    <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                        <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                        <p style='color:#a8c4e0;margin:4px 0 0;'>Grade Promotion Notification</p>
                    </div>
                    <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                        <h3 style='color:#0b2b5c;'>&#127881; Promotion Approved!</h3>
                        <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                        <p>We are pleased to inform you that your grade promotion request from
                           <strong>{$from_label}</strong> to <strong>{$to_label}</strong> has been
                           <span style='color:#28a745;font-weight:bold;'>APPROVED</span>
                           for School Year <strong>{$new_sy}</strong>.</p>
                        <p>Please visit the school to complete your enrollment requirements for {$to_label} and for further instructions.</p>
                        <br>
                        <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
                    </div>
                </div>";
 
                $alt = "Dear {$name},\n\nYour promotion request from {$from_label} to {$to_label} has been APPROVED for School Year {$new_sy}.\nPlease visit the school to complete your requirements.\n\nEusebia Paz Arroyo Memorial National High School";
 
                $mailResult = $this->sendMail($email, $name, "{$to_label} Promotion Approved — Eusebia High School", $html, $alt);
 
                if ($mailResult['success']) {
                    $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved & Promoted!',
                        'text' => $result['message'] . ' Email notification sent to ' . $email . '.'];
                } else {
                    $_SESSION['swal'] = ['icon'=>'warning','title'=>'Approved (Email Failed)',
                        'text' => $result['message'] . ' However, the email could not be sent. ' . ($mailResult['error'] ?? '')];
                }
            } else {
                $_SESSION['swal'] = ['icon'=>'success','title'=>'Approved & Promoted!',
                    'text' => $result['message'] . ' No email address on record.'];
            }
        } else {
            $_SESSION['swal'] = ['icon'=>'error','title'=>'Promotion Failed','text'=>$result['message']];
        }
        header('Location: admn_promotion_requests.php'); exit;
    }
 
    /**
     * Admin: reject a promotion request and email the student.
     */
    public function admin_reject_promotion_request() {
        if (!isset($_POST['reject_promotion_request'])) return;
        $this->validate_admin();
 
        $id     = (int)($_POST['request_id'] ?? 0);
        $reason = trim($_POST['reject_reason'] ?? '');
        $conn   = $this->openConn();
 
        // Fetch the promotion request
        $stmt = $conn->prepare("SELECT * FROM tbl_promotion_requests WHERE id = ?");
        $stmt->execute([$id]);
        $req = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // Fetch the student's email and name
        $email = '';
        $name  = '';
        $from_label = 'Grade ' . ($req['from_grade'] ?? '');
        $to_label   = 'Grade ' . ($req['to_grade'] ?? '');
        if ($req) {
            $res = $conn->prepare("SELECT fname, lname, email FROM tbl_student WHERE id_student = ?");
            $res->execute([$req['id_student']]);
            $student = $res->fetch(PDO::FETCH_ASSOC);
            $email = $student['email'] ?? '';
            $name  = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
        }
 
        $conn->prepare(
            "UPDATE tbl_promotion_requests SET status='Rejected', reject_reason=?, reviewed_at=NOW() WHERE id=?"
        )->execute([$reason, $id]);

        if ($req) {
            $this->add_notification(
                $req['id_student'] ?? null,
                'Promotion Request Rejected',
                "Your grade promotion request from {$from_label} to {$to_label} was not approved." . (!empty($reason) ? " Reason: {$reason}" : ''),
                'rejected'
            );
        }
 
        // Send rejection email
        if (!empty($email)) {
            $reasonHtml = !empty($reason)
                ? "<p><strong>Reason:</strong> " . htmlspecialchars($reason) . "</p>"
                : "";
            $reasonAlt = !empty($reason) ? "\nReason: {$reason}\n" : "";
 
            $html = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                    <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                    <p style='color:#a8c4e0;margin:4px 0 0;'>Grade Promotion Notification</p>
                </div>
                <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                    <h3 style='color:#c0392b;'>Promotion Request Not Approved</h3>
                    <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                    <p>We regret to inform you that your grade promotion request from
                       <strong>{$from_label}</strong> to <strong>{$to_label}</strong> has been
                       <span style='color:#c0392b;font-weight:bold;'>REJECTED</span>.</p>
                    {$reasonHtml}
                    <p>If you have questions or would like to appeal, please visit the school during office hours and bring the necessary documents.</p>
                    <br>
                    <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
                </div>
            </div>";
 
            $alt = "Dear {$name},\n\nYour promotion request from {$from_label} to {$to_label} has been REJECTED.{$reasonAlt}\nPlease visit the school if you have questions.\n\nEusebia Paz Arroyo Memorial National High School";
 
            $mailResult = $this->sendMail($email, $name, "{$to_label} Promotion Request Rejected — Eusebia High School", $html, $alt);
 
            if ($mailResult['success']) {
                $_SESSION['swal'] = ['icon'=>'info','title'=>'Request Rejected',
                    'text' => 'The promotion request has been rejected and a notification email was sent to ' . $email . '.'];
            } else {
                $_SESSION['swal'] = ['icon'=>'warning','title'=>'Rejected (Email Failed)',
                    'text' => 'Request rejected but email could not be sent. ' . ($mailResult['error'] ?? '')];
            }
        } else {
            $_SESSION['swal'] = ['icon'=>'info','title'=>'Request Rejected',
                'text' => 'The promotion request has been rejected. No email address on record.'];
        }
        header('Location: admn_promotion_requests.php'); exit;
    }

    public function admin_bulk_delete_promotion_requests() {
        if (!isset($_POST['bulk_delete_promotion'])) return;
        $this->validate_admin();

        $ids = $_POST['selected_ids'] ?? [];
        if (empty($ids)) {
            $_SESSION['swal'] = ['icon'=>'warning','title'=>'No Selection','text'=>'Please select at least one request to delete.'];
            header('Location: admn_promotion_requests.php'); exit;
        }

        $conn = $this->openConn();
        $ids  = array_map('intval', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $conn->prepare("DELETE FROM tbl_promotion_requests WHERE id IN ({$placeholders})")->execute($ids);

        $count = count($ids);
        $_SESSION['swal'] = ['icon'=>'success','title'=>'Deleted','text'=>"{$count} promotion request(s) deleted."];
        header('Location: admn_promotion_requests.php'); exit;
    }

    // ============================================================
    // GOOGLE SIGN-UP VERIFICATION (email code + admin approval)
    // ============================================================

    // Lazily adds the verification/approval columns to tbl_student.
    // Existing accounts default to email_verified=1 / approval_status='approved'
    // so nothing changes for students who already had access.
    protected function ensure_student_verification_columns($connection) {
        $cols = [
            "email_verified TINYINT(1) NOT NULL DEFAULT 1",
            "verification_code VARCHAR(10) DEFAULT NULL",
            "verification_expires DATETIME DEFAULT NULL",
            "approval_status VARCHAR(20) NOT NULL DEFAULT 'approved'",
            "approved_by INT DEFAULT NULL",
            "approved_at DATETIME DEFAULT NULL",
            "reject_reason TEXT DEFAULT NULL",
        ];
        foreach ($cols as $def) {
            try {
                $connection->exec("ALTER TABLE tbl_student ADD COLUMN {$def}");
            } catch (PDOException $e) {
                // Column already exists — ignore.
            }
        }
    }

    // Generates a fresh 6-digit code, stores it, and emails it to the student.
    // Used for brand-new Google sign-ups and for resending a code.
    public function generate_and_send_verification_code($id_student) {
        $connection = $this->openConn();
        $this->ensure_student_verification_columns($connection);

        $stmt = $connection->prepare("SELECT fname, lname, email FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$student || empty($student['email'])) {
            return ['success' => false, 'error' => 'Student record or email not found.'];
        }

        $code    = (string) random_int(100000, 999999);
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $connection->prepare(
            "UPDATE tbl_student SET verification_code = ?, verification_expires = ?, email_verified = 0 WHERE id_student = ?"
        )->execute([$code, $expires, $id_student]);

        $name = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
        $html = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                <p style='color:#a8c4e0;margin:4px 0 0;'>Email Verification</p>
            </div>
            <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;text-align:center;'>
                <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                <p>Use the code below to verify your email and continue setting up your EPAMHS Portal account.</p>
                <p style='font-size:32px;font-weight:bold;letter-spacing:8px;color:#0b2b5c;margin:24px 0;'>{$code}</p>
                <p style='color:#666;'>This code expires in 15 minutes.</p>
                <p style='color:#888;font-size:12px;margin-top:24px;'>If you did not attempt to sign up, you can ignore this email.</p>
            </div>
        </div>";
        $alt = "Dear {$name},\n\nYour EPAMNHS Portal verification code is: {$code}\nThis code expires in 15 minutes.\n\nIf you did not attempt to sign up, ignore this email.";

        return $this->sendMail($student['email'], $name, 'Verify Your Email EPAMHS Portal', $html, $alt);
    }

    // Checks a submitted code against what's on file for the student.
    // On success, marks the email verified and puts the account into the
    // admin approval queue.
    public function verify_student_email_code($id_student, $code_input) {
        $connection = $this->openConn();
        $this->ensure_student_verification_columns($connection);

        $stmt = $connection->prepare("SELECT verification_code, verification_expires FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || empty($row['verification_code'])) {
            return ['success' => false, 'error' => 'No verification code on file. Please request a new one.'];
        }
        if (strtotime($row['verification_expires']) < time()) {
            return ['success' => false, 'error' => 'This code has expired. Please request a new one.'];
        }
        if (!hash_equals($row['verification_code'], trim((string) $code_input))) {
            return ['success' => false, 'error' => 'Incorrect code. Please try again.'];
        }

        $connection->prepare(
            "UPDATE tbl_student SET email_verified = 1, verification_code = NULL, verification_expires = NULL, approval_status = 'pending' WHERE id_student = ?"
        )->execute([$id_student]);

        return ['success' => true];
    }

    // Status lookup used by google_callback.php to route an existing Google student.
    public function get_student_verification_status($id_student) {
        $connection = $this->openConn();
        $this->ensure_student_verification_columns($connection);
        $stmt = $connection->prepare("SELECT email_verified, approval_status, reject_reason FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id_student]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Admin: list of Google sign-ups that verified their email and are awaiting approval.
    public function admin_get_pending_student_verifications() {
        $connection = $this->openConn();
        $this->ensure_student_verification_columns($connection);
        $stmt = $connection->prepare(
            "SELECT * FROM tbl_student
             WHERE email_verified = 1 AND approval_status = 'pending'
             AND (is_archived = 0 OR is_archived IS NULL)
             ORDER BY id_student DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Small badge count for the sidebar.
    public function count_pending_student_verifications() {
        $connection = $this->openConn();
        $this->ensure_student_verification_columns($connection);
        $stmt = $connection->prepare(
            "SELECT COUNT(*) FROM tbl_student WHERE email_verified = 1 AND approval_status = 'pending' AND (is_archived = 0 OR is_archived IS NULL)"
        );
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    // Admin: approve a verified Google sign-up.
    public function admin_approve_student_account() {
        if (!isset($_POST['approve_student_account'])) return;
        $this->validate_admin();

        $id    = (int) ($_POST['id_student'] ?? 0);
        $admin = $this->get_userdata();
        $connection = $this->openConn();
        $this->ensure_student_verification_columns($connection);

        $stmt = $connection->prepare("SELECT fname, lname, email FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Not Found', 'text' => 'Student account not found.'];
            header('Location: admn_student_verification.php'); exit;
        }

        $connection->prepare(
            "UPDATE tbl_student SET approval_status = 'approved', approved_by = ?, approved_at = NOW() WHERE id_student = ?"
        )->execute([$admin['id_admin'] ?? null, $id]);

        $this->add_notification($id, 'Account Approved', 'Your account has been approved. You can now log in and access the portal.', 'approved');

        $name = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
        if (!empty($student['email'])) {
            $html = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                    <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                    <p style='color:#a8c4e0;margin:4px 0 0;'>Account Approved</p>
                </div>
                <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                    <h3 style='color:#0b2b5c;'>Your Account Has Been Approved!</h3>
                    <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                    <p>Your EPAMHS Portal account has been reviewed and approved. You can now log in using \"Continue with Google\" and access the portal.</p>
                    <br>
                    <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
                </div>
            </div>";
            $alt = "Dear {$name},\n\nYour EPAMHS Portal account has been approved. You can now log in with Continue with Google.\n\nEusebia Paz Arroyo Memorial National High School";
            $this->sendMail($student['email'], $name, 'Account Approved EPAMHS Portal', $html, $alt);
        }

        $_SESSION['swal'] = ['icon' => 'success', 'title' => 'Approved', 'text' => "{$name}'s account has been approved."];
        header('Location: admn_student_verification.php'); exit;
    }

    // Admin: reject a verified Google sign-up.
    public function admin_reject_student_account() {
        if (!isset($_POST['reject_student_account'])) return;
        $this->validate_admin();

        $id     = (int) ($_POST['id_student'] ?? 0);
        $reason = trim($_POST['reject_reason'] ?? '');
        $connection = $this->openConn();
        $this->ensure_student_verification_columns($connection);

        $stmt = $connection->prepare("SELECT fname, lname, email FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            $_SESSION['swal'] = ['icon' => 'error', 'title' => 'Not Found', 'text' => 'Student account not found.'];
            header('Location: admn_student_verification.php'); exit;
        }

        $connection->prepare(
            "UPDATE tbl_student SET approval_status = 'rejected', reject_reason = ? WHERE id_student = ?"
        )->execute([$reason, $id]);

        $name = trim(($student['fname'] ?? '') . ' ' . ($student['lname'] ?? ''));
        if (!empty($student['email'])) {
            $reasonHtml = !empty($reason) ? "<p><strong>Reason:</strong> " . htmlspecialchars($reason) . "</p>" : "";
            $reasonAlt  = !empty($reason) ? "\nReason: {$reason}\n" : "";
            $html = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#0b2b5c;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                    <h2 style='color:#fff;margin:0;'>Eusebia Paz Arroyo Memorial National High School</h2>
                    <p style='color:#a8c4e0;margin:4px 0 0;'>Account Review</p>
                </div>
                <div style='background:#f9f9f9;padding:30px;border:1px solid #ddd;border-radius:0 0 8px 8px;'>
                    <h3 style='color:#c0392b;'>Account Not Approved</h3>
                    <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                    <p>We're sorry, but your EPAMNHS Portal account registration was not approved.</p>
                    {$reasonHtml}
                    <p>If you believe this is a mistake, please visit the school during office hours.</p>
                    <br>
                    <p style='color:#888;font-size:12px;'>This is an automated message. Please do not reply.</p>
                </div>
            </div>";
            $alt = "Dear {$name},\n\nYour EPAMNHS Portal account registration was not approved.{$reasonAlt}\nPlease visit the school if you have questions.\n\nEusebia Paz Arroyo Memorial National High School";
            $this->sendMail($student['email'], $name, 'Account Not Approved EPAMNHS Portal', $html, $alt);
        }

        $_SESSION['swal'] = ['icon' => 'info', 'title' => 'Rejected', 'text' => "{$name}'s account was rejected."];
        header('Location: admn_student_verification.php'); exit;
    }

}
$eusebia = new EUSEBIAClass(); //variable to call outside of its class

?>