<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <!-- PWA -->
    <link rel="manifest" href="manifest.php">
    <meta name="theme-color" content="#0b2b5c">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="EPAMNHS">
    <link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">
    <link rel="icon" type="image/png" sizes="192x192" href="icons/pwa/icon-192x192.png">
    <title>EUSEBIA PAZ ARROYO MNHS | Online Enrollment</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { overflow-y: scroll; scrollbar-gutter: stable; }
        body {
            font-family: 'Roboto', 'Inter', sans-serif;
            background: #f0ebf8;
            color: #202124;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        h1, h2, h3, .fw-bold { font-weight: 700; letter-spacing: -0.022em; }

        /* Navbar (reused look) */
        .navbar-custom {
            background: linear-gradient(135deg, #0b2b5c 0%, #0f3b7a 100%);
            padding: 0.9rem 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .wizard-wrap { max-width: 1400px; width: 92%; margin: 2rem auto 4rem; padding: 0 1rem; }

        .wizard-card {
            background: transparent;
            border-radius: 0;
            box-shadow: none;
            overflow: visible;
        }
        .wizard-topbar {
            background: #fff;
            color: #202124;
            padding: 1.5rem 1.75rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            border-top: 10px solid #673ab7;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(60,64,67,0.15), 0 1px 2px rgba(60,64,67,0.1);
            margin-bottom: 1rem;
        }
        .wizard-topbar i { color: #673ab7; opacity: 1; }
        .wizard-topbar .wt-title { font-weight: 700; font-size: 1.3rem; color: #202124; }
        .wizard-topbar .wt-sub { font-size: .85rem; color: #5f6368; opacity: 1; }

        /* Progress bar (Google Forms style) */
        .stepper {
            display: flex; align-items: center; gap: 3px;
            padding: 0; margin-bottom: 1rem; background: transparent;
        }
        .stepper .step { display: none; }
        .stepper .step-connector {
            flex: 1 1 auto; height: 4px; border-radius: 2px;
            background: #d8c9ef; margin: 0;
        }
        .stepper .step-connector.done, .stepper .step-connector.active { background: #673ab7; }

        .wizard-body { padding: 0; }
        .step-panel { display: none; }
        .step-panel.active { display: block; }
        .step-panel h5 { color: #202124; font-weight: 700; margin-bottom: .25rem; }
        .step-panel .step-desc { color: #5f6368; font-size: .88rem; margin-bottom: 1.25rem; }

        .form-section {
            background: #fff;
            padding: 1.5rem 1.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(60,64,67,0.15), 0 1px 2px rgba(60,64,67,0.1);
        }
        .form-section h6 { font-weight: 700; color: #202124; border-left: 4px solid #673ab7; padding-left: 12px; margin-bottom: 1rem; font-size: 1.05rem; }
        .form-control, .form-select { border-radius: 4px; border: 1px solid #dadce0; padding: 0.6rem 1rem; font-size: 16px; }
        .form-control:focus, .form-select:focus { border-color: #673ab7; box-shadow: 0 0 0 0.2rem rgba(103,58,183,0.18); }
        .was-validated .form-control:invalid, .was-validated .form-select:invalid { border-color: #dc3545 !important; box-shadow: none !important; }
        .was-validated .form-control:valid, .was-validated .form-select:valid { border-color: #28a745 !important; box-shadow: none !important; }
        .grade-option-hint { font-size: 0.82rem; margin-top: 6px; }

        /* Upload */
        .upload-area { border: 2px dashed #673ab7; border-radius: 8px; padding: 1.5rem; text-align: center; background: #f6f2fb; cursor: pointer; transition: background 0.2s; }
        .upload-area:hover { background: #ece3f8; }
        .doc-slot .upload-area { padding: 0.9rem; cursor: pointer; }
        .doc-slot .upload-area i { font-size: 1.3rem; }
        .file-preview-item { display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid #dadce0; border-radius: 6px; padding: 8px 14px; margin-bottom: 6px; font-size: 0.88rem; }
        .file-preview-item .file-icon { font-size: 1.2rem; color: #673ab7; flex-shrink: 0; }
        .file-preview-item .preview-file { margin-left: auto; cursor: pointer; color: #673ab7; flex-shrink: 0; }
        .file-preview-item .remove-file { cursor: pointer; color: #dc3545; flex-shrink: 0; }
        .file-preview-item .doc-slot-filename { flex: 1 1 auto; min-width: 0; margin-left: 2px; }
        .doc-preview-media { max-width: 100%; max-height: 70vh; border-radius: 8px; }
        .doc-preview-frame { width: 100%; height: 70vh; border: 0; }

        /* Review step */
        .review-group { background: #fff; border-radius: 8px; padding: 1.5rem 1.75rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(60,64,67,0.15), 0 1px 2px rgba(60,64,67,0.1); }
        .review-group .rg-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: .8rem; }
        .review-group h6 { color: #202124; font-weight: 700; font-size: 1.05rem; border-left: 4px solid #673ab7; padding-left: 12px; margin: 0; }
        .review-group .rg-edit { font-size: .85rem; color: #673ab7; cursor: pointer; font-weight: 600; text-decoration: none; }
        .review-row { display: flex; align-items: baseline; padding: .6rem 4px; border-bottom: 1px dashed #e8eaed; font-size: .95rem; }
        .review-row:nth-child(even) { background: #faf8fd; }
        .review-row:last-child { border-bottom: none; }
        .review-row .rr-label { flex: 0 0 40%; color: #5f6368; font-weight: 600; padding-right: 12px; border-right: 1px solid #e8eaed; }
        .review-row .rr-value { flex: 1 1 auto; color: #202124; word-break: break-word; padding-left: 12px; }
        .review-row .rr-value.empty { color: #9aa0a6; font-style: italic; }
        .review-divider { border: none; border-top: 2px dashed #dadce0; margin: 1.5rem 0 1.75rem; }

        /* Nav buttons */
        .wizard-nav { display: flex; justify-content: space-between; margin-top: 1.5rem; }
        .btn-wizard-back { background: transparent; border: none; color: #673ab7; font-weight: 600; border-radius: 4px; padding: .65rem 1.6rem; }
        .btn-wizard-back:hover { background: #f0ebf8; }
        .btn-wizard-next, .btn-wizard-submit {
            background: #673ab7; border: none; color: #fff;
            font-weight: 600; border-radius: 4px; padding: .65rem 1.8rem; transition: .2s;
        }
        .btn-wizard-next:hover, .btn-wizard-submit:hover { background: #5628a3; color: #fff; }
        .btn-wizard-submit:disabled { opacity: .7; }
        .wiz-spinner { display: none; width: 1rem; height: 1rem; margin-right: 8px; border: 2px solid rgba(255,255,255,0.5); border-top-color: #fff; border-radius: 50%; animation: wiz-spin 0.7s linear infinite; vertical-align: -2px; }
        .btn-wizard-submit.is-loading .wiz-spinner { display: inline-block; }
        .btn-wizard-submit.is-loading .wiz-submit-icon { display: none; }
        @keyframes wiz-spin { to { transform: rotate(360deg); } }

        .top-link { position: fixed; bottom: 2rem; right: 2rem; background: #673ab7; width: 50px; height: 50px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 99; text-decoration: none; opacity: 0; visibility: hidden; transition: 0.2s ease; }
        .top-link.show { opacity: 1; visibility: visible; }

        .footer-custom { background: #0b1f33; color: #cddcec; padding: 2rem 1rem; text-align: center; font-size: 0.9rem; border-top-left-radius: 32px; border-top-right-radius: 32px; margin-top: 2rem; }

        @media (max-width: 768px) {
            .wizard-wrap { margin: 1rem auto 3rem; padding: 0 0.75rem; }
            .wizard-topbar { padding: 1.1rem 1.25rem; }
            .form-section { padding: 1.1rem 1.25rem; border-radius: 8px; }
        }
    </style>
</head>
<body>

<?php
// Shared student navbar. This page manages its own <body> layout (wizard),
// so skip the partial's body-flex rules.
$active_page = 'dashboard';
$navbar_skip_body_layout = true;
include(VIEWS_PATH . '/partials/student_navbar.php');
?>

<div class="wizard-wrap">
    <div class="wizard-card">
        <div class="wizard-topbar">
            <i class="fas fa-user-graduate fa-lg"></i>
            <div>
                <div class="wt-title" id="wizardTopTitle"><?= $editing_record ? 'Resubmit Enrollment' : 'Online School Enrollment' ?></div>
                <div class="wt-sub">Update Process &mdash; <?= htmlspecialchars($userdetails['surname'] . ', ' . $userdetails['firstname']); ?></div>
            </div>
        </div>

        <?php if ($editing_record && !empty($editing_record['reject_reason'])): ?>
        <div class="alert alert-danger d-flex align-items-start gap-2" role="alert" style="border-radius:8px;">
            <i class="fas fa-exclamation-circle mt-1"></i>
            <div>
                <strong>Your previous submission was rejected.</strong><br>
                <span class="small"><?= htmlspecialchars($editing_record['reject_reason']) ?></span>
            </div>
        </div>
        <?php endif; ?>

        <?php if (empty($enrollment_open) && empty($editing_record)): ?>
            <div class="wizard-body text-center py-5">
                <i class="fas fa-lock fa-2x mb-3" style="color:#b6c1cd;"></i>
                <h5>Enrollment is currently closed</h5>
                <p class="text-muted small mb-4">Please check back once the school reopens enrollment.</p>
                <a href="student_homepage.php" class="btn btn-wizard-back">Back to Dashboard</a>
            </div>
        <?php elseif (!empty($pending_block)): ?>
            <div class="wizard-body text-center py-5">
                <i class="fas fa-hourglass-half fa-2x mb-3" style="color:#f0ad4e;"></i>
                <h5>Pending enrollment in <?= htmlspecialchars($pending_label) ?></h5>
                <p class="text-muted small mb-4">Your enrollment is waiting for review. You can enroll again once it has been approved.</p>
                <a href="my_submissions.php" class="btn btn-wizard-back me-2">View My Submissions</a>
                <a href="student_homepage.php" class="btn btn-wizard-back">Back to Dashboard</a>
            </div>
        <?php else: ?>

        <div class="stepper" id="wizardStepper">
            <div class="step active" data-step="1"><div class="step-circle">1</div><div class="step-label">Grade &amp; ID</div></div>
            <div class="step-connector"></div>
            <div class="step" data-step="2"><div class="step-circle">2</div><div class="step-label">Learner Info</div></div>
            <div class="step-connector"></div>
            <div class="step" data-step="3"><div class="step-circle">3</div><div class="step-label">Parent/Guardian</div></div>
            <div class="step-connector"></div>
            <div class="step" data-step="4"><div class="step-circle">4</div><div class="step-label">Education &amp; Socioeconomic</div></div>
            <div class="step-connector"></div>
            <div class="step" data-step="5"><div class="step-circle">5</div><div class="step-label">Documents</div></div>
            <div class="step-connector"></div>
            <div class="step" data-step="6"><div class="step-circle">6</div><div class="step-label">Review &amp; Submit</div></div>
        </div>

        <div class="wizard-body">
            <form id="enrollForm" method="post" action="enroll_submit.php" enctype="multipart/form-data" novalidate>

                <!-- ===================== STEP 1: GRADE LEVEL & IDENTIFICATION ===================== -->
                <div class="step-panel active" data-step="1">
                    <h5><i class="fas fa-layer-group me-2"></i>Step 1: Grade Level &amp; Identification</h5>
                    <p class="step-desc">Choose the grade level you're enrolling into and confirm your identification details.</p>

                    <div class="form-section" id="gradeLevelSection">
                        <div class="row g-3">
                            <?php $fixed_grade = !empty($auto_grade) ? (int)$auto_grade : (!empty($editing_grade) ? (int)$editing_grade : 0); ?>
                            <?php if ($fixed_grade): ?>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Grade Level</label>
                                <div class="form-control bg-light fw-semibold" style="pointer-events:none;">
                                    <i class="fas fa-graduation-cap me-2 text-success"></i><?= htmlspecialchars($grade_status[$fixed_grade]['label']) ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-12" <?= $fixed_grade ? 'style="display:none;"' : '' ?>>
                                <label class="form-label fw-semibold">Grade Level</label>
                                <select id="gradeLevelSelect" class="form-select" required>
                                    <option value="" selected disabled>-- Choose your grade level --</option>
                                    <?php foreach ($grade_status as $g => $st): ?>
                                    <option value="<?= (int)$g ?>" <?= empty($st['available']) ? 'disabled' : '' ?>>
                                        <?= htmlspecialchars($st['label']) ?><?= empty($st['available']) ? ' - ' . htmlspecialchars($st['reason']) : '' ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="gradeLevelHint" class="grade-option-hint text-muted"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section" id="studentTypeSection" style="display:none;">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Student Type</label>
                                <select id="studentTypeSelect" class="form-select" onchange="handleStudentType(this.value)">
                                    <option value="">-- Select Student Type --</option>
                                    <option value="new">New Student</option>
                                    <option value="old">Old Student</option>
                                    <option value="transferee">Transferee</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="lrnLookupSection" style="display:none;" class="form-section">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Enter your LRN to auto-fill your information:</label>
                                <input type="text" id="lrnLookupInput" class="form-control" placeholder="Enter LRN and wait..." maxlength="12">
                            </div>
                            <div class="col-md-4">
                                <div id="lrnLookupStatus" style="font-size:.85rem;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section" id="identFields" style="display:none;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">School Year</label>
                                <select name="sy" class="form-select" required>
                                    <option value="2026-2027">2026-2027</option>
                                    <option value="2027-2028">2027-2028</option>
                                    <option value="2028-2029">2028-2029</option>
                                    <option value="2029-2030">2029-2030</option>
                                    <option value="2030-2031">2030-2031</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">LRN</label>
                                <input name="lrn" type="text" class="form-control" placeholder="Learner Reference No." required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">School ID</label>
                                <input id="school_id_top" type="text" class="form-control" placeholder="School ID" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== STEP 2: PERSONAL & ACADEMIC DETAILS ===================== -->
                <div class="step-panel" data-step="2">
                    <h5><i class="fas fa-id-card me-2"></i>Step 2: Learner Information</h5>
                    <p class="step-desc">Fill in your personal and academic information.</p>

                    <div class="form-section" id="courseSection" style="display:none;">
                        <label class="form-label fw-semibold" id="courseLabel">Course:</label>
                        <select name="course" id="courseSelect" class="form-select border-primary">
                            <option value="">-- Select --</option>
                        </select>
                    </div>

                    <div class="form-section">
                        <h6><i class="fas fa-user-graduate me-2"></i>Learner Information</h6>
                        <div class="row g-3">
                            <div class="col-md-4"><label>Last Name</label><input name="lname" type="text" class="form-control name-only" placeholder="Last Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-4"><label>First Name</label><input name="fname" type="text" class="form-control name-only" placeholder="First Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-4"><label>Middle Name</label><input name="mi" type="text" class="form-control name-only" placeholder="Middle Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-3">
                                <label>Suffix <span class="text-muted small">(optional)</span></label>
                                <select name="ext" class="form-select">
                                    <option value="">None</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small mb-1"><i class="fas fa-calendar-alt me-1"></i>Date of Birth</label>
                                <input name="bdate" type="date" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label>Sex</label>
                                <select name="sex" class="form-select" required>
                                    <option value="">Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label>Age</label><input name="age" type="number" class="form-control" placeholder="Age" required></div>
                            <div class="col-md-4"><label>Contact Number</label><input name="contact" type="number" class="form-control" placeholder="Contact No." required></div>
                            <div class="col-md-8"><label>Email Address</label><input name="email" type="email" class="form-control" placeholder="Email Address" required></div>
                            <div class="col-md-6"><label>Current Address</label><textarea name="current_address" class="form-control" rows="2" placeholder="Current Address" required></textarea></div>
                            <div class="col-md-6"><label>Permanent Address</label><textarea name="perm_address" class="form-control" rows="2" placeholder="Permanent Address" required></textarea></div>
                        </div>
                    </div>
                </div>

                <div class="step-panel" data-step="3">
                    <h5><i class="fas fa-users me-2"></i>Step 3: Parent / Guardian</h5>
                    <p class="step-desc">Tell us about your parent or guardian.</p>

                    <div class="form-section">
                        <h6><i class="fas fa-users me-2"></i>Father's Name</h6>
                        <div class="row g-3">
                            <div class="col-md-3"><label>Last Name</label><input name="flname" type="text" class="form-control name-only" placeholder="Last Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-3"><label>First Name</label><input name="ffname" type="text" class="form-control name-only" placeholder="First Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-3"><label>Middle Name</label><input name="fmi" type="text" class="form-control name-only" placeholder="Middle Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-3"><label>Contact Number</label><input name="contact_f" type="text" class="form-control" placeholder="Contact No." required></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h6><i class="fas fa-users me-2"></i>Mother's Maiden Name</h6>
                        <div class="row g-3">
                            <div class="col-md-3"><label>Last Name</label><input name="mlname" type="text" class="form-control name-only" placeholder="Last Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-3"><label>First Name</label><input name="mfname" type="text" class="form-control name-only" placeholder="First Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-3"><label>Middle Name</label><input name="mmi" type="text" class="form-control name-only" placeholder="Middle Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" required></div>
                            <div class="col-md-3"><label>Contact Number</label><input name="contact_m" type="text" class="form-control" placeholder="Contact No." required></div>
                        </div>
                    </div>
                </div>

                <div class="step-panel" data-step="4">
                    <h5><i class="fas fa-school me-2"></i>Step 4: Previous Education &amp; Socioeconomic Information</h5>
                    <p class="step-desc">Tell us about your previous school and household background.</p>

                    <div class="form-section">
                        <h6><i class="fas fa-school me-2"></i>Previous Education</h6>
                        <div class="row g-3">
                            <div class="col-md-8"><input name="lglc" class="form-control" placeholder="Last Grade Level Completed" required></div>
                            <div class="col-md-4"><input name="lsa" class="form-control" placeholder="Last School Attended" required></div>
                            <div class="col-md-8"><input name="lysc" class="form-control" placeholder="Last School Year Completed" required></div>
                            <div class="col-md-4"><input id="school_id" name="school_id" type="text" class="form-control" placeholder="School ID (Previous)" required></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h6><i class="fas fa-hand-holding-heart me-2"></i>Socioeconomic Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Indigenous People (IP) Member</label>
                                <select name="is_ip" class="form-select">
                                    <option value="No" selected>No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="ip_group_div" style="display:none;">
                                <label class="form-label fw-semibold small">IP Group / Tribe</label>
                                <input name="ip_group" class="form-control" placeholder="e.g. Agta, Dumagat, Igorot">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">4Ps / Pantawid Pamilyang Pilipino Program</label>
                                <select name="is_4ps" class="form-select">
                                    <option value="No" selected>No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="fourps_id_div" style="display:none;">
                                <label class="form-label fw-semibold small">4Ps Household ID Number</label>
                                <input name="fourps_id" class="form-control" placeholder="4Ps Household ID">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== STEP 5: UPLOAD DOCUMENTS ===================== -->
                <div class="step-panel" data-step="5">
                    <h5><i class="fas fa-file-upload me-2"></i>Step 5: Upload Documents</h5>
                    <p class="step-desc">Upload one file at a time for each document below. Accepted: PDF, JPG, PNG, DOC, DOCX &mdash; Max 5MB per file.</p>
                    <?php if ($editing_record): ?>
                    <div class="alert alert-info small" style="border-radius:8px;">
                        <i class="fas fa-info-circle me-1"></i>
                        Your previously uploaded documents are still on file. You only need to upload a file here if you want to replace it.
                    </div>
                    <?php endif; ?>

                    <div class="form-section">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">PSA Birth Certificate</label>
                                <div class="doc-slot" data-doc-label="PSA Birth Certificate">
                                    <div class="upload-area doc-slot-empty" onclick="this.querySelector('.doc-slot-input').click()">
                                        <i class="fas fa-cloud-upload-alt mb-1" style="color:#2a6f9c;"></i>
                                        <p class="mb-0 small fw-semibold">Click to upload</p>
                                        <input type="file" class="d-none doc-slot-input" name="documents[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    </div>
                                    <div class="file-preview-item doc-slot-filled d-none">
                                        <i class="file-icon fas fa-file-alt"></i>
                                        <span class="doc-slot-filename text-truncate"></span>
                                        <i class="preview-file fas fa-eye" title="Preview"></i>
                                        <i class="remove-file fas fa-times-circle" title="Remove"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Form 137 / Report Card</label>
                                <div class="doc-slot" data-doc-label="Form 137 / Report Card">
                                    <div class="upload-area doc-slot-empty" onclick="this.querySelector('.doc-slot-input').click()">
                                        <i class="fas fa-cloud-upload-alt mb-1" style="color:#2a6f9c;"></i>
                                        <p class="mb-0 small fw-semibold">Click to upload</p>
                                        <input type="file" class="d-none doc-slot-input" name="documents[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    </div>
                                    <div class="file-preview-item doc-slot-filled d-none">
                                        <i class="file-icon fas fa-file-alt"></i>
                                        <span class="doc-slot-filename text-truncate"></span>
                                        <i class="preview-file fas fa-eye" title="Preview"></i>
                                        <i class="remove-file fas fa-times-circle" title="Remove"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Good Moral Certificate</label>
                                <div class="doc-slot" data-doc-label="Good Moral Certificate">
                                    <div class="upload-area doc-slot-empty" onclick="this.querySelector('.doc-slot-input').click()">
                                        <i class="fas fa-cloud-upload-alt mb-1" style="color:#2a6f9c;"></i>
                                        <p class="mb-0 small fw-semibold">Click to upload</p>
                                        <input type="file" class="d-none doc-slot-input" name="documents[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    </div>
                                    <div class="file-preview-item doc-slot-filled d-none">
                                        <i class="file-icon fas fa-file-alt"></i>
                                        <span class="doc-slot-filename text-truncate"></span>
                                        <i class="preview-file fas fa-eye" title="Preview"></i>
                                        <i class="remove-file fas fa-times-circle" title="Remove"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small">Brigada Eskwela Commitment Slip</label>
                                <div class="doc-slot" data-doc-label="Brigada Eskwela Commitment Slip">
                                    <div class="upload-area doc-slot-empty" onclick="this.querySelector('.doc-slot-input').click()">
                                        <i class="fas fa-cloud-upload-alt mb-1" style="color:#2a6f9c;"></i>
                                        <p class="mb-0 small fw-semibold">Click to upload</p>
                                        <input type="file" class="d-none doc-slot-input" name="documents[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    </div>
                                    <div class="file-preview-item doc-slot-filled d-none">
                                        <i class="file-icon fas fa-file-alt"></i>
                                        <span class="doc-slot-filename text-truncate"></span>
                                        <i class="preview-file fas fa-eye" title="Preview"></i>
                                        <i class="remove-file fas fa-times-circle" title="Remove"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== STEP 4: REVIEW & SUBMIT ===================== -->
                <div class="step-panel" data-step="6">
                    <h5><i class="fas fa-clipboard-check me-2"></i>Step 6: Review &amp; Submit</h5>
                    <p class="step-desc">Please check everything below carefully before submitting your enrollment.</p>
                    <div id="reviewContainer"></div>
                    <hr class="review-divider">
                </div>

                <input type="hidden" name="student_type" id="studentTypeHidden" value="new">
                <input type="hidden" name="id_student" value="<?= $userdetails['id_student'] ?? ''; ?>">
                <input type="hidden" name="grade_level" id="gradeLevelHidden" value="">
                <input type="hidden" name="prev_grade_table" id="prevGradeTable" value="">
                <input type="hidden" name="prev_grade_id" id="prevGradeId" value="">
                <input type="hidden" name="edit_id" id="editIdHidden" value="<?= $editing_id ?? '' ?>">

                <div class="wizard-nav">
                    <button type="button" class="btn btn-wizard-back" id="wizBackBtn" onclick="prevStep()" style="visibility:hidden;">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </button>
                    <button type="button" class="btn btn-wizard-next" id="wizNextBtn" onclick="nextStep()">
                        Continue <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                    <button type="submit" class="btn btn-wizard-submit d-none" id="enrollSubmitBtn">
                        <span class="wiz-spinner"></span><i class="fas fa-paper-plane me-2 wiz-submit-icon"></i><span id="enrollSubmitBtnText"><?= $editing_record ? 'Resubmit' : 'Submit Enrollment' ?></span>
                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="docPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-truncate" id="docPreviewModalLabel"><i class="fas fa-eye me-2"></i>Document Preview</h6>
                <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center text-center" id="docPreviewModalBody"></div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['swal'])):
    $swal = $_SESSION['swal'];
    unset($_SESSION['swal']);
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon:  '<?= $swal['icon'] ?>',
        title: '<?= addslashes($swal['title']) ?>',
        text:  '<?= addslashes($swal['text'] ?? '') ?>',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    });
});
</script>
<?php endif; ?>

<a href="#" class="top-link" id="backToTopBtn" aria-label="Back to top"><i class="fas fa-arrow-up"></i></a>

<?php include(VIEWS_PATH . '/partials/student_footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
const backBtn = document.getElementById('backToTopBtn');
window.addEventListener('scroll', function() {
    if (window.scrollY > 300) backBtn.classList.add('show'); else backBtn.classList.remove('show');
});
backBtn.addEventListener('click', function(e) { e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' }); });
</script>

<script>
// ===== Restrict name fields to letters only (no numbers or symbols) =====
(function() {
    var nameFieldRegex = /[^A-Za-zÀ-ÿ\s\-']/g; // allow letters, spaces, hyphens, apostrophes
    document.querySelectorAll('.name-only').forEach(function(input) {
        input.addEventListener('input', function() {
            var cleaned = input.value.replace(nameFieldRegex, '');
            if (cleaned !== input.value) input.value = cleaned;
        });
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            var text = (e.clipboardData || window.clipboardData).getData('text');
            var cleaned = text.replace(nameFieldRegex, '');
            var start = input.selectionStart, end = input.selectionEnd;
            input.value = input.value.slice(0, start) + cleaned + input.value.slice(end);
            input.dispatchEvent(new Event('input'));
        });
    });
})();
</script>

<?php if (!empty($enrollment_open) && empty($pending_block)): ?>
<!-- ===== ENROLLMENT WIZARD LOGIC (Grades 7-12) ===== -->
<script>
var gradeStatus     = <?= json_encode($grade_status) ?>;
var prevDataByGrade = <?= json_encode($prev_data_map) ?>;
var TABLE_BY_GRADE = {7:'tbl_seven',8:'tbl_eight',9:'tbl_nine',10:'tbl_ten',11:'tbl_eleven',12:'tbl_twelve'};

var COURSE_OPTIONS = {
    junior_course: {
        label: 'TLE Specialization (Course):',
        options: [
            ['', '-- Select Course --'],
            ['ICT', 'ICT - Computer Programming'],
            ['Animation', 'ICT - Animation'],
            ['Cookery', 'Home Economics - Cookery'],
            ['BAP', 'Home Economics - Bread and Pastry'],
            ['Automotive', 'Industrial Arts - Automotive'],
            ['Welding', 'Industrial Arts - Welding (SMAW)']
        ]
    },
    senior: {
        label: 'SHS Strand (Course):',
        options: [
            ['', '-- Select Strand --'],
            ['STEM', 'STEM (Science, Technology, Engineering, and Mathematics)'],
            ['ABM', 'ABM (Accountancy, Business, and Management)'],
            ['GAS', 'GAS (General Academic Strand)'],
            ['TVL-ICT', 'TVL-ICT (Information and Communication Technology)'],
            ['TVL-HE', 'TVL-HE (Home Economics)']
        ]
    }
};

var FIELD_NAMES = ['lrn','school_id','lname','fname','mi','ext','bdate','sex','age','contact','email',
    'current_address','perm_address','ffname','flname','fmi','contact_f',
    'mlname','mfname','mmi','contact_m','lglc','lsa','lysc','course'];

var REVIEW_SECTIONS = [
    { title: 'Grade Level & Identification', step: 1, fields: [
        ['gradeLevelSelect_text', 'Grade Level'],
        ['studentTypeHidden', 'Student Type'],
        ['sy', 'School Year'],
        ['lrn', 'LRN'],
        ['school_id_top', 'School ID']
    ]},
    { title: 'Learner Information', step: 2, fields: [
        ['lname', 'Last Name'], ['fname', 'First Name'], ['mi', 'Middle Name'], ['ext', 'Suffix'],
        ['course', 'Course / Strand'],
        ['bdate', 'Date of Birth'], ['sex', 'Sex'], ['age', 'Age'],
        ['contact', 'Contact Number'], ['email', 'Email Address'],
        ['current_address', 'Current Address'], ['perm_address', 'Permanent Address']
    ]},
    { title: 'Parent / Guardian', step: 3, fields: [
        ['ffname', "Father's First Name"], ['flname', "Father's Last Name"], ['fmi', "Father's Middle Name"], ['contact_f', "Father's Contact No."],
        ['mfname', "Mother's First Name"], ['mlname', "Mother's Last Name"], ['mmi', "Mother's Middle Name"], ['contact_m', "Mother's Contact No."]
    ]},
    { title: 'Previous Education', step: 4, fields: [
        ['lglc', 'Last Grade Level Completed'], ['lsa', 'Last School Attended'], ['lysc', 'Last School Year Completed']
    ]},
    { title: 'Socioeconomic Information', step: 4, fields: [
        ['is_ip', 'Indigenous People (IP) Member'], ['ip_group', 'IP Group / Tribe'],
        ['is_4ps', '4Ps Member'], ['fourps_id', '4Ps Household ID Number']
    ]}
];

function clearForm() {
    FIELD_NAMES.forEach(function(n) {
        var el = document.querySelector('[name="' + n + '"]');
        if (el) el.value = '';
    });
    var schoolIdTop = document.getElementById('school_id_top');
    if (schoolIdTop) schoolIdTop.value = '';
    document.getElementById('lrnLookupStatus').innerHTML = '';
    var lookupInput = document.getElementById('lrnLookupInput');
    if (lookupInput) lookupInput.value = '';
    document.getElementById('prevGradeTable').value = '';
    document.getElementById('prevGradeId').value = '';
}

(function() {
    var top = document.getElementById('school_id_top');
    var bottom = document.getElementById('school_id');
    if (top && bottom) {
        top.addEventListener('input', function() { bottom.value = top.value; });
        bottom.addEventListener('input', function() { top.value = bottom.value; });
    }
})();

function fillFromRecord(d) {
    var set = function(name, val) {
        var el = document.querySelector('[name="' + name + '"]');
        if (el) el.value = val || '';
    };
    set('lrn', d.lrn); set('school_id', d.school_id);
    var schoolIdTop = document.getElementById('school_id_top');
    if (schoolIdTop) schoolIdTop.value = d.school_id || '';
    set('lname', d.lname); set('fname', d.fname); set('mi', d.mi); set('ext', d.ext);
    set('bdate', d.bdate); set('sex', d.sex); set('age', d.age);
    set('contact', d.contact); set('email', d.email);
    set('current_address', d.current_address); set('perm_address', d.perm_address);
    set('ffname', d.ffname); set('flname', d.flname); set('fmi', d.fmi); set('contact_f', d.contact_f);
    set('mfname', d.mfname); set('mlname', d.mlname); set('mmi', d.mmi); set('contact_m', d.contact_m);
    set('lglc', d.lglc); set('lsa', d.lsa); set('lysc', d.lysc);
    var courseField = document.querySelector('[name="course"]');
    if (courseField && d.course) courseField.value = d.course;

    var isIpField = document.querySelector('[name="is_ip"]');
    if (isIpField) { isIpField.value = d.is_ip || 'No'; isIpField.dispatchEvent(new Event('change')); }
    set('ip_group', d.ip_group);
    var is4psField = document.querySelector('[name="is_4ps"]');
    if (is4psField) { is4psField.value = d.is_4ps || 'No'; is4psField.dispatchEvent(new Event('change')); }
    set('fourps_id', d.fourps_id);
}

function setCourseSection(tier) {
    var section = document.getElementById('courseSection');
    var label   = document.getElementById('courseLabel');
    var select  = document.getElementById('courseSelect');

    if (tier === 'junior_course' || tier === 'senior') {
        var cfg = COURSE_OPTIONS[tier];
        label.textContent = cfg.label;
        select.innerHTML = cfg.options.map(function(o) {
            return '<option value="' + o[0] + '">' + o[1] + '</option>';
        }).join('');
        select.name = 'course';
        select.required = true;
        section.style.display = '';
    } else {
        select.required = false;
        select.value = '';
        section.style.display = 'none';
    }
}

function handleStudentType(val) {
    var lookup   = document.getElementById('lrnLookupSection');
    var fields   = document.getElementById('identFields');
    var lrnField = document.querySelector('input[name="lrn"]');
    if (val === '') {
        lookup.style.display = 'none';
        fields.style.display = 'none';
    } else if (val === 'new') {
        lookup.style.display = 'none';
        fields.style.display = 'block';
        clearForm();
        if (lrnField) { lrnField.readOnly = false; lrnField.value = ''; }
        document.getElementById('studentTypeHidden').value = 'new';
    } else {
        lookup.style.display = 'block';
        fields.style.display = 'block';
        if (lrnField) lrnField.readOnly = true;
        document.getElementById('studentTypeHidden').value = val;
    }
}

function useContinuingStudent(grade, d) {
    document.getElementById('studentTypeSection').style.display = 'none';
    document.getElementById('lrnLookupSection').style.display = 'none';
    var typeSelect = document.getElementById('studentTypeSelect');
    if (typeSelect) typeSelect.value = 'old';
    document.getElementById('studentTypeHidden').value = 'old';
    fillFromRecord(d);
    document.getElementById('prevGradeTable').value = d.source_table || '';
    document.getElementById('prevGradeId').value = d.source_id || '';
    document.getElementById('identFields').style.display = 'block';
}

document.getElementById('gradeLevelSelect').addEventListener('change', function() {
    var grade = this.value;
    var status = gradeStatus[grade];
    var hint = document.getElementById('gradeLevelHint');
    document.getElementById('gradeLevelHidden').value = grade;
    hint.textContent = '';

    clearForm();
    setCourseSection(status.tier);

    document.getElementById('studentTypeSection').style.display = 'none';
    document.getElementById('lrnLookupSection').style.display = 'none';
    document.getElementById('identFields').style.display = 'none';

    if (grade === '7') {
        var typeSelect = document.getElementById('studentTypeSelect');
        if (typeSelect) typeSelect.value = 'new';
        document.getElementById('studentTypeHidden').value = 'new';
        document.getElementById('identFields').style.display = 'block';
        return;
    }

    var prevData = prevDataByGrade[grade];
    if (prevData) {
        useContinuingStudent(grade, prevData);
    } else {
        var typeSelect = document.getElementById('studentTypeSelect');
        if (typeSelect) typeSelect.value = 'new';
        document.getElementById('studentTypeHidden').value = 'new';
        document.getElementById('lrnLookupSection').style.display = 'none';
        var lrnField = document.querySelector('input[name="lrn"]');
        if (lrnField) lrnField.readOnly = false;
        document.getElementById('identFields').style.display = 'block';
    }
});

document.getElementById('studentTypeSelect').addEventListener('change', function() {
    document.getElementById('studentTypeHidden').value = this.value || 'new';
});

document.querySelector('[name="is_ip"]').addEventListener('change', function() {
    document.getElementById('ip_group_div').style.display = this.value === 'Yes' ? '' : 'none';
});
document.querySelector('[name="is_4ps"]').addEventListener('change', function() {
    document.getElementById('fourps_id_div').style.display = this.value === 'Yes' ? '' : 'none';
});

// Real-time LRN availability check (silent — no "available/taken" text shown;
// still blocks step navigation via setCustomValidity if it's a duplicate)
(function() {
    var lrnInput = document.querySelector('input[name="lrn"]');
    if (!lrnInput) return;
    var timer = null;
    lrnInput.addEventListener('input', function() {
        clearTimeout(timer);
        var val = this.value.trim();
        lrnInput.setCustomValidity('');
        if (val.length < 3) return;
        var grade = document.getElementById('gradeLevelSelect').value;
        var targetTable = TABLE_BY_GRADE[grade] || 'tbl_eight';
        var studentType = document.getElementById('studentTypeHidden').value || 'new';
        timer = setTimeout(function() {
            fetch('check_lrn.php?lrn=' + encodeURIComponent(val) + '&student_type=' + encodeURIComponent(studentType) + '&target_table=' + encodeURIComponent(targetTable))
                .then(r => r.json())
                .then(data => {
                    if (data.taken) {
                        var msg = data.status === 'pending'
                            ? 'This LRN already has a pending registration.'
                            : 'This LRN is already registered.';
                        lrnInput.setCustomValidity(msg);
                    } else {
                        lrnInput.setCustomValidity('');
                    }
                })
                .catch(() => {});
        }, 500);
    });
})();

// LRN lookup for Old Student / Transferee auto-fill
(function() {
    var timer = null;
    var input = document.getElementById('lrnLookupInput');
    if (!input) return;
    input.addEventListener('input', function() {
        clearTimeout(timer);
        var val = this.value.trim();
        var status = document.getElementById('lrnLookupStatus');
        status.innerHTML = '';
        if (val.length < 3) return;
        status.innerHTML = '<span style="color:#6c757d;"><i class="fas fa-spinner fa-spin me-1"></i>Searching...</span>';
        timer = setTimeout(function() {
            fetch('lookup_lrn.php?lrn=' + encodeURIComponent(val))
                .then(r => r.json())
                .then(res => {
                    if (res.found) {
                        fillFromRecord(res.data);
                        status.innerHTML = '<span style="color:#28a745;"><i class="fas fa-check-circle me-1"></i>Information loaded!</span>';
                    } else {
                        status.innerHTML = '<span style="color:#dc3545;"><i class="fas fa-times-circle me-1"></i>LRN not found. Fill manually.</span>';
                    }
                })
                .catch(() => { status.innerHTML = '<span style="color:#dc3545;">Lookup failed. Fill manually.</span>'; });
        }, 600);
    });
})();

// ===== DOCUMENT UPLOAD (one file at a time, per document type) =====
function iconForType(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-image';
    if (ext === 'pdf') return 'fas fa-file-pdf';
    if (['doc','docx'].includes(ext)) return 'fas fa-file-word';
    return 'fas fa-file-alt';
}

let docSlotPreviewUrl = null;
const docPreviewModalEl = document.getElementById('docPreviewModal');
const docPreviewModal   = docPreviewModalEl ? new bootstrap.Modal(docPreviewModalEl) : null;
const docPreviewBody    = document.getElementById('docPreviewModalBody');
const docPreviewLabel   = document.getElementById('docPreviewModalLabel');

function previewDocFile(f) {
    if (!f || !docPreviewModal) return;
    if (docSlotPreviewUrl) { URL.revokeObjectURL(docSlotPreviewUrl); docSlotPreviewUrl = null; }
    docSlotPreviewUrl = URL.createObjectURL(f);
    docPreviewLabel.innerHTML = '<i class="fas fa-eye me-2"></i>' + f.name;

    const ext = f.name.split('.').pop().toLowerCase();
    if (['jpg','jpeg','png'].includes(ext)) {
        docPreviewBody.innerHTML = `<img src="${docSlotPreviewUrl}" class="doc-preview-media">`;
    } else if (ext === 'pdf') {
        docPreviewBody.innerHTML = `<iframe src="${docSlotPreviewUrl}" class="doc-preview-frame"></iframe>`;
    } else {
        docPreviewBody.innerHTML = `<p class="text-muted mb-3">Preview isn't available for this file type.</p>
            <a href="${docSlotPreviewUrl}" download="${f.name}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-download me-1"></i> Download to view
            </a>`;
    }
    docPreviewModal.show();
}

if (docPreviewModalEl) {
    docPreviewModalEl.addEventListener('hidden.bs.modal', function() {
        if (docSlotPreviewUrl) { URL.revokeObjectURL(docSlotPreviewUrl); docSlotPreviewUrl = null; }
        docPreviewBody.innerHTML = '';
    });
}

document.querySelectorAll('.doc-slot').forEach(function(slot) {
    const input      = slot.querySelector('.doc-slot-input');
    const empty      = slot.querySelector('.doc-slot-empty');
    const filled     = slot.querySelector('.doc-slot-filled');
    const nameEl     = slot.querySelector('.doc-slot-filename');
    const iconEl     = slot.querySelector('.file-icon');
    const previewBtn = slot.querySelector('.preview-file');
    const removeBtn  = slot.querySelector('.remove-file');
    const MAX        = 5 * 1024 * 1024;

    input.addEventListener('change', function() {
        const f = input.files[0];
        if (!f) return;
        if (f.size > MAX) {
            alert(`"${f.name}" exceeds 5MB limit.`);
            input.value = '';
            return;
        }
        nameEl.textContent = f.name;
        nameEl.title = f.name;
        iconEl.className = 'file-icon ' + iconForType(f.name);
        empty.classList.add('d-none');
        filled.classList.remove('d-none');
    });

    previewBtn.addEventListener('click', function() { previewDocFile(input.files[0]); });

    removeBtn.addEventListener('click', function() {
        input.value = '';
        filled.classList.add('d-none');
        empty.classList.remove('d-none');
    });
});

// ===== WIZARD STEP NAVIGATION =====
var currentStep = 1;
var TOTAL_STEPS = 6;

function updateStepper() {
    document.querySelectorAll('#wizardStepper .step').forEach(function(el) {
        var s = parseInt(el.dataset.step, 10);
        el.classList.remove('active', 'done');
        if (s < currentStep) el.classList.add('done');
        else if (s === currentStep) el.classList.add('active');
    });
    document.querySelectorAll('#wizardStepper .step-connector').forEach(function(el, i) {
        el.classList.toggle('done', (i + 1) < currentStep);
    });
}

function showStep(n) {
    document.querySelectorAll('.step-panel').forEach(function(p) {
        p.classList.toggle('active', parseInt(p.dataset.step, 10) === n);
    });
    document.getElementById('wizBackBtn').style.visibility = n === 1 ? 'hidden' : 'visible';
    document.getElementById('wizNextBtn').classList.toggle('d-none', n === TOTAL_STEPS);
    document.getElementById('enrollSubmitBtn').classList.toggle('d-none', n !== TOTAL_STEPS);
    if (n === TOTAL_STEPS) buildReview();
    currentStep = n;
    updateStepper();
    var scrollTarget = window.innerWidth <= 768 ? 0 : (document.querySelector('.wizard-card').offsetTop - 20);
    window.scrollTo({ top: scrollTarget, behavior: 'smooth' });
}

function validateStep(n) {
    var panel = document.querySelector('.step-panel[data-step="' + n + '"]');
    panel.classList.add('was-validated');
    var fields = Array.prototype.slice.call(panel.querySelectorAll('input, select, textarea'));
    var visibleInvalid = fields.filter(function(el) {
        return el.offsetParent !== null && !el.checkValidity();
    });
    if (visibleInvalid.length) {
        visibleInvalid[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        visibleInvalid[0].focus();
        return false;
    }
    return true;
}

function nextStep() {
    if (!validateStep(currentStep)) return;
    if (currentStep < TOTAL_STEPS) showStep(currentStep + 1);
}

function prevStep() {
    if (currentStep > 1) showStep(currentStep - 1);
}

function fieldDisplayValue(name) {
    if (name === 'gradeLevelSelect_text') {
        var sel = document.getElementById('gradeLevelSelect');
        return sel && sel.selectedIndex >= 0 ? sel.options[sel.selectedIndex].text.split(' - ')[0] : '';
    }
    var el = document.querySelector('[name="' + name + '"]') || document.getElementById(name);
    if (!el) return '';
    if (el.tagName === 'SELECT') return el.selectedIndex >= 0 ? el.options[el.selectedIndex].text : '';
    return el.value;
}

function buildReview() {
    var html = '';
    REVIEW_SECTIONS.forEach(function(section) {
        html += '<div class="review-group"><div class="rg-head"><h6>' + section.title + '</h6>' +
            '<a href="javascript:void(0)" class="rg-edit" onclick="showStep(' + section.step + ')"><i class="fas fa-pen me-1"></i>Edit</a></div>';
        section.fields.forEach(function(f) {
            var val = fieldDisplayValue(f[0]);
            var display = val ? val : '&mdash;';
            var emptyCls = val ? '' : ' empty';
            html += '<div class="review-row"><div class="rr-label">' + f[1] + '</div><div class="rr-value' + emptyCls + '">' + display + '</div></div>';
        });
        html += '</div>';
    });

    html += '<div class="review-group"><div class="rg-head"><h6>Uploaded Documents</h6>' +
        '<a href="javascript:void(0)" class="rg-edit" onclick="showStep(5)"><i class="fas fa-pen me-1"></i>Edit</a></div>';
    document.querySelectorAll('.doc-slot').forEach(function(slot) {
        var label = slot.dataset.docLabel;
        var input = slot.querySelector('.doc-slot-input');
        var f = input.files[0];
        var display = f ? f.name : '&mdash; Not uploaded';
        var emptyCls = f ? '' : ' empty';
        html += '<div class="review-row"><div class="rr-label">' + label + '</div><div class="rr-value' + emptyCls + '">' + display + '</div></div>';
    });
    html += '</div>';

    document.getElementById('reviewContainer').innerHTML = html;
}

document.getElementById('enrollForm').addEventListener('submit', function(e) {
    if (!validateStep(5) || !validateStep(4) || !validateStep(3) || !validateStep(2) || !validateStep(1)) {
        e.preventDefault();
        showStep(1);
        return;
    }
    var submitBtn = document.getElementById('enrollSubmitBtn');
    var submitBtnText = document.getElementById('enrollSubmitBtnText');
    submitBtn.classList.add('is-loading');
    submitBtn.disabled = true;
    if (submitBtnText) submitBtnText.textContent = 'Submitting...';
    if (typeof showAdminLoading === 'function') showAdminLoading('Submitting your enrollment...', 'paper-plane');
});

// ===== EDIT / RESUBMIT MODE =====
var autoGrade = <?= !empty($auto_grade) ? (int)$auto_grade : 'null' ?>;
var editData  = <?= $editing_record ? json_encode($editing_record) : 'null' ?>;
var editGrade = <?= $editing_grade ? (int)$editing_grade : 'null' ?>;

if (!editData && autoGrade) {
    // Student already has a grade on record -> go straight to the next level
    var autoSel = document.getElementById('gradeLevelSelect');
    autoSel.value = String(autoGrade);
    autoSel.dispatchEvent(new Event('change'));
}

if (editData && editGrade) {
    var gradeSel = document.getElementById('gradeLevelSelect');
    gradeSel.value = String(editGrade);
    gradeSel.dispatchEvent(new Event('change')); // runs the normal per-grade setup (course section, etc.)
    gradeSel.disabled = true; // resubmission stays on the same grade it was rejected from

    document.getElementById('studentTypeSection').style.display = 'none';
    document.getElementById('lrnLookupSection').style.display = 'none';
    var studentTypeSelectEl = document.getElementById('studentTypeSelect');
    if (studentTypeSelectEl) studentTypeSelectEl.value = 'old';
    document.getElementById('studentTypeHidden').value = 'old';
    document.getElementById('identFields').style.display = 'block';
    var lrnField = document.querySelector('input[name="lrn"]');
    if (lrnField) lrnField.readOnly = false;

    // Overwrite whatever the grade-change handler auto-filled with the
    // student's actual rejected-submission data.
    fillFromRecord(editData);

    // Preserve this row's own prev_grade_table/prev_grade_id (set on its
    // original submission) rather than whatever useContinuingStudent()
    // may have just written from a *different* previous-grade record.
    document.getElementById('prevGradeTable').value = editData.prev_grade_table || '';
    document.getElementById('prevGradeId').value = editData.prev_grade_id || '';

    if (editData.sy) {
        var syField = document.querySelector('[name="sy"]');
        if (syField) syField.value = editData.sy;
    }

    var submitBtnText = document.getElementById('enrollSubmitBtnText');
    if (submitBtnText) submitBtnText.textContent = 'Resubmit';
}

showStep(1);
</script>

<!-- ===== DRAFT AUTOSAVE (restores typed data after an accidental refresh) ===== -->
<script>
(function() {
    var form = document.getElementById('enrollForm');
    if (!form) return;
    // Skip entirely when resubmitting a rejected enrollment — the form is
    // already pre-filled from that record, and restoring a leftover draft
    // from an earlier, unrelated "new enrollment" attempt would clobber it.
    if (document.getElementById('editIdHidden') && document.getElementById('editIdHidden').value) return;

    var studentIdEl = document.querySelector('[name="id_student"]');
    var DRAFT_KEY = 'eusebia_enroll_draft_' + (studentIdEl && studentIdEl.value ? studentIdEl.value : 'guest');

    // Plain fields identified by their "name" attribute.
    var NAME_FIELDS = ['sy','lrn','lname','fname','mi','ext','bdate','sex','age','contact','email',
        'current_address','perm_address','course','flname','ffname','fmi','contact_f',
        'mlname','mfname','mmi','contact_m','lglc','lsa','lysc','school_id',
        'is_ip','ip_group','is_4ps','fourps_id'];
    // Fields that only have an id (no name attribute).
    var ID_FIELDS = ['gradeLevelSelect','studentTypeSelect','lrnLookupInput','school_id_top'];

    function saveDraft() {
        var data = {};
        NAME_FIELDS.forEach(function(n) {
            var el = form.querySelector('[name="' + n + '"]');
            if (el) data['n_' + n] = el.value;
        });
        ID_FIELDS.forEach(function(id) {
            var el = document.getElementById(id);
            if (el) data['i_' + id] = el.value;
        });
        data._step = currentStep;
        try { localStorage.setItem(DRAFT_KEY, JSON.stringify(data)); } catch (e) {}
    }

    function clearDraft() {
        try { localStorage.removeItem(DRAFT_KEY); } catch (e) {}
    }

    function restoreDraft() {
        var raw;
        try { raw = localStorage.getItem(DRAFT_KEY); } catch (e) { raw = null; }
        if (!raw) return;
        var data;
        try { data = JSON.parse(raw); } catch (e) { return; }

        // 1) Restore grade level first - this replays the site's own cascading logic
        //    (reveals the right sections, auto-fills continuing-student records, etc).
        if (data.i_gradeLevelSelect) {
            var gradeSel = document.getElementById('gradeLevelSelect');
            if (gradeSel && gradeSel.querySelector('option[value="' + data.i_gradeLevelSelect + '"]:not([disabled])')) {
                gradeSel.value = data.i_gradeLevelSelect;
                gradeSel.dispatchEvent(new Event('change'));
            }
        }

        // 2) Re-apply everything the user actually typed on top of that, since the
        //    grade-level change above may have cleared fields or filled in defaults.
        NAME_FIELDS.forEach(function(n) {
            var key = 'n_' + n;
            if (!(key in data)) return;
            var el = form.querySelector('[name="' + n + '"]');
            if (el) el.value = data[key];
        });
        ['studentTypeSelect', 'lrnLookupInput', 'school_id_top'].forEach(function(id) {
            var key = 'i_' + id;
            if (!(key in data)) return;
            var el = document.getElementById(id);
            if (el) el.value = data[key];
        });

        // Keep the two "School ID" fields (top of step 1, bottom of step 4) in sync.
        var schoolIdTop = document.getElementById('school_id_top');
        var schoolIdBottom = form.querySelector('[name="school_id"]');
        if (schoolIdTop && schoolIdBottom && schoolIdTop.value && !schoolIdBottom.value) {
            schoolIdBottom.value = schoolIdTop.value;
        }

        // Re-fire the IP / 4Ps toggles so their extra fields show if "Yes" was saved.
        var isIp = form.querySelector('[name="is_ip"]');
        if (isIp) isIp.dispatchEvent(new Event('change'));
        var is4ps = form.querySelector('[name="is_4ps"]');
        if (is4ps) is4ps.dispatchEvent(new Event('change'));

        // Go back to whichever step the user was on.
        if (data._step && data._step >= 1 && data._step <= TOTAL_STEPS) {
            showStep(data._step);
        }
    }

    // Save on every change - file inputs are skipped because browsers never let JS
    // re-populate a chosen file, so there's nothing worth persisting there anyway.
    form.addEventListener('input', function(e) {
        if (e.target && e.target.type === 'file') return;
        saveDraft();
    });
    form.addEventListener('change', function(e) {
        if (e.target && e.target.type === 'file') return;
        saveDraft();
    });

    // Also snapshot on step navigation so a refresh returns to the same step.
    var nextBtn = document.getElementById('wizNextBtn');
    var backBtn2 = document.getElementById('wizBackBtn');
    if (nextBtn) nextBtn.addEventListener('click', saveDraft);
    if (backBtn2) backBtn2.addEventListener('click', saveDraft);

    // Only clear the draft once the form actually passes validation and submits.
    // (The existing submit handler calls preventDefault() when a step is invalid;
    // e.defaultPrevented lets us tell the two cases apart.)
    form.addEventListener('submit', function(e) {
        if (e.defaultPrevented) return;
        clearDraft();
    });

    restoreDraft();
})();
</script>
<?php endif; ?>

<script src="js/pwa.js"></script>
</body>
</html>