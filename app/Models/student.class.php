<?php 

    require_once('main.class.php');
    

    class StudentClass extends EUSEBIAClass {
        //------------------------------------ STUDENT CRUD FUNCTIONS ----------------------------------------

public function create_student() {
    if(isset($_POST['add_student'])) {
        // Use ?? '' to prevent "Undefined array key" errors
        $login_identity = $_POST['login_identity'] ?? ''; 
        $plain_password = $_POST['password'] ?? '';
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

        $lname = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['lname'] ?? '')));
        $fname = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['fname'] ?? '')));
        $mi = preg_replace('/[^A-Z ]/', '', strtoupper(trim($_POST['mi'] ?? '')));
        $sex = $_POST['sex'] ?? '';

        // PSGC-format address (Region → Province → City/Municipality → Barangay)
        $region = $_POST['region'] ?? '';
        $province = $_POST['province'] ?? '';
        $municipal = $_POST['municipal'] ?? '';
        $brgy = $_POST['brgy'] ?? '';
        $psgc_code = $_POST['psgc_code'] ?? '';

        $contact = $_POST['contact'] ?? ''; 
        $bdate = $_POST['bdate'] ?? '';

        $addedby = $_POST['addedby'] ?? 'Student';

        $security_question = trim($_POST['security_question'] ?? '');
        $security_answer   = trim($_POST['security_answer'] ?? '');
        $hashed_answer      = $security_answer !== '' ? password_hash(strtolower($security_answer), PASSWORD_DEFAULT) : null;

        // Age, civil status, birth place, house no./street, and nationality were
        // removed from the registration form. Age is still derived from the
        // birth date (the `age` column remains NOT NULL); the underage check
        // that used to gate registration on it has been removed.
        $age = 0;
        if ($bdate) {
            try {
                $birth = new DateTime($bdate);
                $today = new DateTime('today');
                $age = $today->diff($birth)->y;
            } catch (Exception $e) {
                $age = 0;
            }
        }
        $status = '';
        $houseno = '';
        $street = '';
        $bplace = '';
        $nationality = '';

        // Logic for Email vs Phone
        $email_to_save = NULL;
        $phone_to_save = NULL;

        if (filter_var($login_identity, FILTER_VALIDATE_EMAIL)) {
            $email_to_save = $login_identity;
        } else {
            $phone_to_save = $login_identity;
        }

        // Check if Identity exists
        if ($this->check_student($login_identity) == 0) {
            try {
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_student (
                    `email`, `phone_number`, `password`, `lname`, `fname`, `mi`, `age`, `sex`, 
                    `status`, `houseno`, `street`, `brgy`, `municipal`, `region`, `province`, 
                    `psgc_code`, `contact`, `bdate`, `bplace`, `nationality`, `addedby`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute([ 
                    $email_to_save, $phone_to_save, $hashed_password, 
                    $lname, $fname, $mi, $age, $sex, $status, 
                    $houseno, $street, $brgy, $municipal, $region, $province,
                    $psgc_code, $contact, $bdate, $bplace, $nationality, $addedby
                ]);

                $new_id_student = $connection->lastInsertId();

                // New self-registered accounts still need an admin's approval
                // before they can log in — same approval queue Google sign-ups use.
                $this->ensure_student_verification_columns($connection);
                $connection->prepare(
                    "UPDATE tbl_student SET email_verified = 1, approval_status = 'pending' WHERE id_student = ?"
                )->execute([$new_id_student]);

                // Save the account-recovery security question/answer (answer is
                // hashed, never stored in plain text). Columns are added lazily
                // so this works even on databases that predate this feature.
                $this->ensure_security_question_columns($connection);
                $connection->prepare(
                    "UPDATE tbl_student SET security_question = ?, security_answer = ? WHERE id_student = ?"
                )->execute([$security_question ?: null, $hashed_answer, $new_id_student]);

                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['pending_approval_name'] = trim($fname . ' ' . $lname);
                // Tell the pending-approval page which identity the student
                // actually registered with, so it doesn't always say "email".
                $_SESSION['pending_approval_contact_type'] = $email_to_save ? 'email' : 'phone';

                echo "<script>window.location.href='pending_approval.php';</script>";
            } catch (PDOException $e) {
                // This will catch the "Column not found" error and tell you exactly what's wrong
                echo "Database Error: " . $e->getMessage();
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    var dupModalEl = document.getElementById('duplicateAccountModal');
                    if (dupModalEl && window.bootstrap) {
                        new bootstrap.Modal(dupModalEl).show();
                    } else {
                        alert('This account is already registered.');
                    }
                });
            </script>";
        }
    }
}
        public function view_student(){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * from tbl_student");
            $stmt->execute();
            $view = $stmt->fetchAll();
            return $view;
        }

        public function update_student() {
            if (isset($_POST['update_student'])) {
                $id_student = $_GET['id_student'];
                $email = $_POST['email'];
                $password = ($_POST['password']);
                $lname = $_POST['lname'];
                $fname = $_POST['fname'];
                $mi = $_POST['mi'];
                $age = $_POST['age'];
                $sex = $_POST['sex'];
                $status = $_POST['status'];
                $houseno = $_POST['houseno'];
                $street = $_POST['street'];
                $brgy = $_POST['brgy'];
                $municipal = $_POST['municipal'];
                $contact = $_POST['contact'];
                $bdate = $_POST['bdate'];
                $bplace = $_POST['bplace'];
                $nationality = $_POST['nationality'];
                $voter = $_POST['voter'];
                $familyrole = $_POST['family_role'];
                $role = $_POST['role'];
                $addedby = $_POST['addedby'];

                $connection = $this->openConn();

// 1. Check if the password is being changed
if (!empty($password)) {
    // If password is NOT empty, update EVERYTHING including the new password
    $stmt = $connection->prepare("UPDATE tbl_student SET `password` =?, `lname` =?, 
        `fname` = ?, `mi` =?, `age` =?, `sex` =?, `status` =?, `email` =?, `houseno` =?, `street` =?,
        `brgy` =?, `municipal` =?, `contact` =?,
        `bdate` =?, `bplace` =?, `nationality` =?, `voter` =?, `family_role` =?, `role` =?, `addedby` =? WHERE `id_student` = ?");
    
    $stmt->execute([$password, $lname, $fname, $mi, $age, $sex, $status, $email, $houseno, 
        $street, $brgy, $municipal, $contact, $bdate, $bplace, $nationality, $voter, $family_role, $role, $addedby, $id_student]);

} else {
    // 2. If password is empty, update everything EXCEPT the password column
    $stmt = $connection->prepare("UPDATE tbl_student SET `lname` =?, 
        `fname` = ?, `mi` =?, `age` =?, `sex` =?, `status` =?, `email` =?, `houseno` =?, `street` =?,
        `brgy` =?, `municipal` =?, `contact` =?,
        `bdate` =?, `bplace` =?, `nationality` =?, `voter` =?, `family_role` =?, `role` =?, `addedby` =? WHERE `id_student` = ?");
    
    // Note: $password is removed from the array below
    $stmt->execute([$lname, $fname, $mi, $age, $sex, $status, $email, $houseno, 
        $street, $brgy, $municipal, $contact, $bdate, $bplace, $nationality, $voter, $familyrole, $role, $addedby, $id_student]);
}

$this->notif('Student Data Updated', 'success', 'reload');
            }
        }


        public function delete_student(){
            $id_student = $_POST['id_student'];

            if(isset($_POST['delete_student'])) {
                $connection = $this->openConn();
                $stmt = $connection->prepare("DELETE FROM tbl_student where id_student = ?");
                $stmt->execute([$id_student]);

                $this->notif('Student Data Deleted', 'success', 'reload');
            }
        }

    //-------------------------------- EXTRA FUNCTIONS FOR STUDENT CLASS ---------------------------------

    


    public function get_single_student($id_student){

        $id_student = $_GET['id_student'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_student where id_student = ?");
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
   
    public function check_student($login_identity) {

        $connection = $this->openConn();
        // Check both email and phone_number columns so duplicates are caught
        // regardless of whether the user registered with an email or phone number.
        // Also check tbl_admin and tbl_user (staff/teacher accounts) so an
        // identity already in use by an admin or staff account is rejected too,
        // not just ones already used by another student.
        $stmt = $connection->prepare(
            "SELECT
                (SELECT COUNT(*) FROM tbl_student WHERE email = ? OR phone_number = ?) +
                (SELECT COUNT(*) FROM tbl_admin   WHERE email = ? OR phone_number = ?) +
                (SELECT COUNT(*) FROM tbl_user    WHERE email = ? OR phone_number = ?)
             AS total"
        );
        $stmt->execute([
            $login_identity, $login_identity,
            $login_identity, $login_identity,
            $login_identity, $login_identity,
        ]);
        $total = (int) $stmt->fetchColumn();

        return $total;
    }

    public function count_student() {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_student");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();
        return $rescount;
    }

    public function check_household($lname, $mi) {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_student WHERE lname = ? AND mi = ?");
        $stmt->Execute([$lname, $mi]);
        $total = $stmt->rowCount(); 
        return $total;
    }

    public function view_household_list() {
        $lname = $_POST['lname'];
        $mi = $_POST['mi'];

        if(isset($_POST['search_household'])) {
            $connection = $this->openConn();
            $stmt1 = $connection->prepare("SELECT * FROM `tbl_student` WHERE `lname` LIKE '%$lname%' and  `mi` LIKE '%$mi%'");
            $stmt1->execute();
        }
    }

    public function count_eleven_stem() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_eleven where course = 'STEM' ");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    public function count_eleven_abm() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_student where sex = 'female'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

  

    public function count_member_student() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_student where family_role = 'Family Member'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    public function profile_update() {
        $id_student = $_GET['id_student'];
        $age = $_POST['age'];
        $status = $_POST['status'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        if (isset($_POST['profile_update'])) {
           
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_student SET  `age` = ?,  `status` = ?, 
            `address` = ?, `contact` = ? WHERE id_student = ?");
            $stmt->execute([ $age, $status, $address,
            $contact, $id_student]);
               
            $this->notif('Student Profile Updated', 'success', 'reload');

        }

    }
    

    //------------------------------------- STUDENT FILTERING QUERIES --------------------------------------

    public function view_student_minor(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_student WHERE `age` <= 17");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_student_adult(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_student WHERE `age` >= 18 AND `age` <= 59");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_student_senior(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_student WHERE `age` >= 60");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function count_student_senior() {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_student WHERE `age` >= 60");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }





    // Returns the student's currently saved security question (or null),
    // for prefilling the "update your security question" form.
    public function get_current_security_question($id_student) {
        $connection = $this->openConn();
        $this->ensure_security_question_columns($connection);
        $stmt = $connection->prepare("SELECT security_question FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['security_question'] ?? null;
    }

    //-------------------------------------- EXTRA FUNCTIONS ------------------------------------------------

    public function student_changepass() {
    // 1. Only run logic if the form was actually submitted
    if(isset($_POST['student_changepass'])) {
        
        // Use ?? to prevent "Undefined index" notices
        // It's safer to get the ID from a session or a POST field rather than GET for a sensitive action
        $id_student = $_POST['id_student'] ?? $_GET['id_student'] ?? null;
        $oldpassword_input = $_POST['oldpassword'] ?? '';
        $newpassword = $_POST['newpassword'] ?? '';
        $checkpassword = $_POST['checkpassword'] ?? '';

        if (!$id_student) {
            $_SESSION['swal'] = [
                'icon'  => 'error',
                'title' => 'Missing Student ID',
                'text'  => 'We could not identify your account. Please log in again.'
            ];
            header('Location: student_changepass.php');
            exit();
        }

        $connection = $this->openConn();
        
        // 2. Fetch the hashed password from the database
        $stmt = $connection->prepare("SELECT `password` FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. Validation Logic
        if(!$result) {
            $_SESSION['swal'] = [
                'icon'  => 'error',
                'title' => 'Student Not Found',
                'text'  => 'We could not find your student record.'
            ];
        } 
        // Use password_verify to check against the hashed DB password
        elseif (!password_verify($oldpassword_input, $result['password'])) {
            $_SESSION['swal'] = [
                'icon'  => 'error',
                'title' => 'Incorrect Password',
                'text'  => 'Your current password is incorrect.'
            ];
        } 
        elseif (empty($newpassword)) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Password Required',
                'text'  => 'New password cannot be empty.'
            ];
        }
        elseif ($newpassword !== $checkpassword) {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Passwords Do Not Match',
                'text'  => 'New password and confirmation password do not match.'
            ];
        } 
        else {
            // 4. Update the password using a NEW hash
            $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
            
            $stmt = $connection->prepare("UPDATE tbl_student SET password = ? WHERE id_student = ?");
            $success = $stmt->execute([$hashed_password, $id_student]);
            
            if ($success) {
                $_SESSION['swal'] = [
                    'icon'  => 'success',
                    'title' => 'Password Updated',
                    'text'  => 'Your password has been updated successfully.'
                ];
            } else {
                $_SESSION['swal'] = [
                    'icon'  => 'error',
                    'title' => 'Update Failed',
                    'text'  => 'Database error: could not update password.'
                ];
            }
        }

        // Redirect so a page refresh never resubmits the form (PRG pattern),
        // same flash-then-redirect flow used after enrollment submission.
        header('Location: student_changepass.php');
        exit();
    }
}

    // Lazily adds the account-recovery security question columns to
    // tbl_student. Same pattern as ensure_student_verification_columns() —
    // safe to call repeatedly, works on databases that predate this feature.
    protected function ensure_security_question_columns($connection) {
        $cols = [
            "security_question VARCHAR(255) DEFAULT NULL",
            "security_answer VARCHAR(255) DEFAULT NULL",
        ];
        foreach ($cols as $def) {
            try {
                $connection->exec("ALTER TABLE tbl_student ADD COLUMN {$def}");
            } catch (PDOException $e) {
                // Column already exists — ignore.
            }
        }
    }

    // Lets an already-logged-in student set or update their security
    // question from its own standalone page. Posted as `set_security_question`.
    public function student_set_security_question() {
        if (!isset($_POST['set_security_question'])) return;

        $id_student = $_POST['id_student'] ?? null;
        $question   = trim($_POST['security_question'] ?? '');
        $answer     = trim($_POST['security_answer'] ?? '');

        if (!$id_student || $question === '' || $answer === '') {
            $_SESSION['swal'] = [
                'icon'  => 'warning',
                'title' => 'Missing Information',
                'text'  => 'Please choose a question and provide an answer.'
            ];
            header('Location: student_security_question.php');
            exit();
        }

        $connection = $this->openConn();
        $this->ensure_security_question_columns($connection);

        $hashed_answer = password_hash(strtolower($answer), PASSWORD_DEFAULT);
        $connection->prepare(
            "UPDATE tbl_student SET security_question = ?, security_answer = ? WHERE id_student = ?"
        )->execute([$question, $hashed_answer, $id_student]);

        $_SESSION['swal'] = [
            'icon'  => 'success',
            'title' => 'Security Question Saved',
            'text'  => 'You can now use this to recover your account with your phone number.'
        ];
        header('Location: student_security_question.php');
        exit();
    }

    // ---- Forgot-password-by-email recovery (security question) -----------
    // Same idea as forgot_password_lookup_phone() above, but keyed on email
    // instead of phone number — lets a student reset instantly via their
    // security question instead of waiting on the emailed reset link.
    public function forgot_password_lookup_email($email) {
        $connection = $this->openConn();
        $this->ensure_security_question_columns($connection);

        $stmt = $connection->prepare(
            "SELECT id_student, security_question FROM tbl_student WHERE email = ? LIMIT 1"
        );
        $stmt->execute([$email]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student || empty($student['security_question'])) {
            return ['found' => false];
        }

        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['pwd_recovery_student_id'] = $student['id_student'];

        return ['found' => true, 'question' => $student['security_question']];
    }

    // Step 2 for the email path is identical to the phone path — both only
    // depend on $_SESSION['pwd_recovery_student_id'] set by whichever lookup
    // ran above — so this just reuses that logic under a matching name.
    public function forgot_password_reset_via_email($answer, $newpassword, $checkpassword) {
        return $this->forgot_password_reset_via_phone($answer, $newpassword, $checkpassword);
    }

    // ---- Forgot-password-by-phone-number recovery -------------------------
    // Step 1: look up the student's security question by phone number.
    // Returns the question on success so the view can render step 2, without
    // ever exposing whether the phone number matched an email- vs phone-
    // registered account. Stores the matched id_student in session so step 2
    // can't be tricked into resetting a different account via a tampered
    // hidden field.
    public function forgot_password_lookup_phone($phone) {
        $connection = $this->openConn();
        $this->ensure_security_question_columns($connection);

        $stmt = $connection->prepare(
            "SELECT id_student, security_question FROM tbl_student WHERE phone_number = ? LIMIT 1"
        );
        $stmt->execute([$phone]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student || empty($student['security_question'])) {
            return ['found' => false];
        }

        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['pwd_recovery_student_id'] = $student['id_student'];

        return ['found' => true, 'question' => $student['security_question']];
    }

    // Step 2: verify the answer to the stored question and, if correct,
    // set the new password immediately (no email link needed).
    public function forgot_password_reset_via_phone($answer, $newpassword, $checkpassword) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $id_student = $_SESSION['pwd_recovery_student_id'] ?? null;

        if (!$id_student) {
            return ['success' => false, 'message' => 'Your session expired. Please start over.'];
        }
        if ($newpassword === '' || $newpassword !== $checkpassword) {
            return ['success' => false, 'message' => 'New password and confirmation do not match.'];
        }

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT security_answer FROM tbl_student WHERE id_student = ?");
        $stmt->execute([$id_student]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student || !$student['security_answer'] ||
            !password_verify(strtolower(trim($answer)), $student['security_answer'])) {
            return ['success' => false, 'message' => 'That answer is incorrect.'];
        }

        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
        $connection->prepare("UPDATE tbl_student SET password = ? WHERE id_student = ?")
                   ->execute([$hashed_password, $id_student]);

        unset($_SESSION['pwd_recovery_student_id']);
        return ['success' => true, 'message' => 'Your password has been reset. You can now log in.'];
    }



    //========================================== SCOPE CHANGED FUNCTIONS ===========================================

    public function view_student_household(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_student WHERE `family_role` = 'Yes'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_student_voters(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_student WHERE `voter` = 'Yes'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }
 public function view_eleven_stem(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_eleven 
         WHERE course = 'STEM' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_eleven_abm(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_eleven 
         WHERE course = 'ABM' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

    public function view_eleven_gas(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_eleven 
         WHERE course = 'GAS' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_eleven_ict(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_eleven 
         WHERE course = 'TVL-ICT' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_eleven_he(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_eleven ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_eleven 
         WHERE course = 'TVL-HE' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}
    public function view_twelve_abm(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_twelve 
         WHERE course = 'ABM' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_twelve_stem(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_twelve 
         WHERE course = 'STEM' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_twelve_gas(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_twelve 
         WHERE course = 'GAS' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_twelve_ict(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_twelve 
         WHERE course = 'TVL-ICT' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_twelve_he(){
    $connection = $this->openConn();
    try { $connection->exec("ALTER TABLE tbl_twelve ADD COLUMN enrollment_status VARCHAR(20) NOT NULL DEFAULT 'Pending'"); } catch (PDOException $e) {}
    $stmt = $connection->prepare(
        "SELECT * FROM tbl_twelve 
         WHERE course = 'TVL-HE' 
         AND (is_archived = 0 OR is_archived IS NULL)
         ORDER BY CASE WHEN LOWER(enrollment_status) = 'pending' THEN 0 ELSE 1 END, lname ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function view_eleven($sort = 'lname', $order = 'ASC') {
    // 1. Whitelist (Security check)
    $allowed = ['lname', 'age', 'email', 'course', 'lrn'];
    if (!in_array($sort, $allowed)) { $sort = 'lname'; }
    
    // 2. Validate Order
    $order = ($order === 'DESC') ? 'DESC' : 'ASC';

    $connection = $this->openConn();
    // 3. Inject variables into the SQL
    $stmt = $connection->prepare("SELECT * FROM tbl_eleven ORDER BY $sort $order");
    $stmt->execute();
    return $stmt->fetchAll();
}
    
    

    public function search_admn_voter() {
        
        $search = $_GET['search'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_student WHERE `fname` = '$search'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;

            


            
        
        

    }
    public function count_all_courses($table_name) {
    $connection = $this->openConn();
    $stmt = $connection->prepare(
        "SELECT course, COUNT(*) as total 
         FROM $table_name 
         WHERE (is_archived = 0 OR is_archived IS NULL)
         GROUP BY course
         ORDER BY course"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // returns ['CourseName' => count, ...]
}
public function count_by_grade($table_name, $column = null, $value = null) {
    $connection = $this->openConn();

    if ($column === null) {
        // Grade 7–10 (no strand)
        $stmt = $connection->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE is_archived = 0 OR is_archived IS NULL"
        );
        $stmt->execute();
    } else {
        // Grade 11–12 strands (STEM, ABM, GAS, TVL-ICT, TVL-HE)
        $stmt = $connection->prepare(
            "SELECT COUNT(*) FROM $table_name 
             WHERE $column = ? AND (is_archived = 0 OR is_archived IS NULL)"
        );
        $stmt->execute([$value]);
    }

    return $stmt->fetchColumn();
}





    public function get_enrollment_trend($days = 30) {
        $connection = $this->openConn();
        $tables = ['tbl_seven', 'tbl_eight', 'tbl_nine', 'tbl_ten', 'tbl_eleven', 'tbl_twelve'];

        // Self-heal: make sure every grade table has a date_enrolled column,
        // same pattern used elsewhere in this class (e.g. view_eleven_stem()).
        foreach ($tables as $t) {
            try {
                $connection->exec(
                    "ALTER TABLE $t ADD COLUMN date_enrolled TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP"
                );
            } catch (PDOException $e) {
                // Column already exists — ignore
            }
        }

        // Zero-fill every day in the window first, so the chart shows a
        // continuous line even on days with no enrollments.
        $trend = [];
        $today = new DateTime('today');
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = (clone $today)->modify("-$i days")->format('Y-m-d');
            $trend[$day] = 0;
        }

        $unionParts = array_map(function ($t) {
            return "SELECT DATE(date_enrolled) as d FROM $t WHERE date_enrolled >= DATE_SUB(CURDATE(), INTERVAL ? DAY)";
        }, $tables);
        $sql = "SELECT d, COUNT(*) as c FROM (" . implode(" UNION ALL ", $unionParts) . ") as combined GROUP BY d ORDER BY d ASC";

        $stmt = $connection->prepare($sql);
        $stmt->execute(array_fill(0, count($tables), $days));

        foreach ($stmt->fetchAll(PDO::FETCH_KEY_PAIR) as $day => $count) {
            $trend[$day] = (int) $count;
        }

        return $trend;
    }

    }

    $studenteusebia = new StudentClass();
?>