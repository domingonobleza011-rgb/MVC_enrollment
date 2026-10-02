
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
    <title>EUSEBIA PAZ ARROYO MNHS | Student Portal</title>

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS Library for scroll animations (optional) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- SweetAlert2 (flash messages + LRN-duplicate notice after enrollment submit) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
    font-family: 'Inter', sans-serif;
    /* Updated background for better performance and fixed position */
    background: linear-gradient(145deg, #f8faff 0%, #f0f4fe 100%);
    background-attachment: fixed; /* Keeps the gradient from stretching if the page is long */

    color: #1a2c3e;
    scroll-behavior: smooth;

    /* Text rendering improvements */
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizeLegibility;

    /* Prevents horizontal scroll on small screens */
    overflow-x: hidden;
    margin: 0;
}
/* Bold headings with tight letter-spacing */
h1, h2, h3, .fw-bold {
    font-weight: 700;
    letter-spacing: -0.022em;
}

/* Medium weight for navigation/sub-labels */
.nav-link, .label-medium {
    font-weight: 500;
    letter-spacing: -0.011em;
}

/* Slightly more line-height for body text to improve readability */
p, .card-text {
    line-height: 1.6;
    font-weight: 400;
}

        /* Custom Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, #0b2b5c 0%, #0f3b7a 100%);
            backdrop-filter: blur(8px);
            padding: 0.9rem 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.3px;
            color: white !important;
            transition: transform 0.2s;
        }
        .navbar-brand:hover {
            transform: scale(1.02);
        }
        .dropdown-toggle-custom {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(4px);
            border-radius: 40px;
            padding: 8px 20px;
            border: 1px solid rgba(255,255,255,0.25);
            color: white !important;
            font-weight: 500;
            transition: all 0.2s;
        }
        .dropdown-toggle-custom:hover {
            background: rgba(255,255,255,0.25);
            border-color: rgba(255,255,255,0.5);
        }
        .dropdown-menu-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            padding: 12px 6px;
            min-width: 210px;
            background: #ffffffdd;
            backdrop-filter: blur(12px);
        }
        .dropdown-item-custom {
            border-radius: 16px;
            padding: 10px 18px;
            font-weight: 500;
            transition: all 0.2s;
            color: #0b2b5c;
        }
        .dropdown-item-custom i {
            width: 28px;
            margin-right: 6px;
        }
        .dropdown-item-custom:hover {
            background: #eef2ff;
            transform: translateX(5px);
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 3rem 1rem 2rem;
    background: linear-gradient(145deg, #f8faff 0%, #f0f4fe 100%);
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 2.8rem;
            background: linear-gradient(135deg, #0b2b5c, #2a6f9c);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.75rem;
        }
        .welcome-badge {
            background: #ffffffcc;
            backdrop-filter: blur(4px);
            border-radius: 80px;
            display: inline-block;
            padding: 0.3rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            color: #0b2b5c;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .current-date {
            font-size: 0.9rem;
            color: #4a627a;
            margin-top: 0.75rem;
        }

        /* Grade / Enroll Section */
        .grade-section {
            padding: 2rem 1rem 4rem;

        }
        .selector-card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(2px);
            border-radius: 36px;
            border: none;
            box-shadow: 0 18px 35px -12px rgba(0,0,0,0.12);
            max-width: 560px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .selector-label {
            display: block;
            font-weight: 600;
            color: #0b2b5c;
            margin-bottom: 0.75rem;
            font-size: 1.05rem;
        }
        .selector-sub {
            font-size: 0.9rem;
            color: #5e7e9e;
            margin-top: 0.75rem;
        }

        /* ENROLL BUTTON */
        .btn-enroll {
            background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
            border: none;
            border-radius: 50px;
            padding: 1rem 2.2rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: white;
            transition: 0.25s;
            box-shadow: 0 10px 20px -8px rgba(11,43,92,0.4);
        }
        .btn-enroll:hover { transform: scale(1.02); background: linear-gradient(135deg, #1f3a6b, #2a6f9c); color: white; }
        .btn-enroll:disabled { opacity: .55; cursor: not-allowed; transform: none; }

        /* MODAL SUBMIT BUTTON REMODEL (Prevents clipping on small screens) */
        .btn-modal-submit {
            background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
            border: none;
            color: white;
            font-weight: 600;
            transition: 0.25s;
            box-shadow: 0 4px 10px rgba(11,43,92,0.2);
        }
        .btn-modal-submit:hover { background: linear-gradient(135deg, #1f3a6b, #2a6f9c); color: white; }
        .btn-modal-submit:disabled { opacity: 0.85; cursor: not-allowed; }
        .enroll-spinner {
            display: none;
            width: 1rem;
            height: 1rem;
            margin-right: 8px;
            border: 2px solid rgba(255,255,255,0.5);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: enroll-spin 0.7s linear infinite;
            vertical-align: -2px;
        }
        .btn-modal-submit.is-loading .enroll-spinner { display: inline-block; }
        .btn-modal-submit.is-loading .enroll-submit-icon { display: none; }
        @keyframes enroll-spin { to { transform: rotate(360deg); } }

        /* MODAL */
        .modern-modal .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            box-shadow: 0 30px 40px rgba(0,0,0,0.2);
        }
        .modal-header {
            background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
            color: white;
            border-bottom: none;
            padding: 1.2rem 1.8rem;
        }
        .modal-header .btn-close { filter: brightness(0) invert(1); }
        .modal-body { padding: 1.5rem; background: #fefefe; }
        .modal-footer { background: #f8fafd; border-top: 1px solid #e9ecef; padding: 1rem 1.5rem; }

        .form-section {
            background: #f8fafd;
            padding: 1rem;
            border-radius: 20px;
            margin-bottom: 1.2rem;
        }
        .form-section h6 {
            font-weight: 700;
            color: #0b2b5c;
            border-left: 4px solid #2a6f9c;
            padding-left: 12px;
            margin-bottom: 1rem;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #dee2e6;
            padding: 0.6rem 1rem;
            font-size: 16px; /* prevents iOS zoom */
        }
        .form-control:focus, .form-select:focus {
            border-color: #2a6f9c;
            box-shadow: 0 0 0 0.2rem rgba(42,111,156,0.25);
        }
        .form-control, .form-select { border-color: #dee2e6 !important; }
        .was-validated .form-control:invalid,
        .was-validated .form-select:invalid { border-color: #dc3545 !important; box-shadow: none !important; }
        .was-validated .form-control:valid,
        .was-validated .form-select:valid { border-color: #28a745 !important; box-shadow: none !important; }

        /* GRADE LEVEL OPTION HINT */
        .grade-option-hint {
            font-size: 0.82rem;
            margin-top: 6px;
        }

        /* UPLOAD */
        .upload-area {
            border: 2px dashed #2a6f9c;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            background: #f0f6fb;
            cursor: pointer;
            transition: background 0.2s;
        }
        .upload-area:hover, .upload-area.dragover { background: #dceef9; }
        .doc-slot .upload-area { padding: 0.9rem; cursor: pointer; }
        .doc-slot .upload-area i { font-size: 1.3rem; }
        .file-preview-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 8px 14px;
            margin-bottom: 6px;
            font-size: 0.88rem;
        }
        .file-preview-item .file-icon { font-size: 1.2rem; color: #2a6f9c; }
        .file-preview-item .preview-file { margin-left: auto; cursor: pointer; color: #2a6f9c; }
        .file-preview-item .remove-file { cursor: pointer; color: #dc3545; }
        .file-preview-item .file-icon,
        .file-preview-item .preview-file,
        .file-preview-item .remove-file { flex-shrink: 0; }
        .file-preview-item .doc-slot-filename {
            flex: 1 1 auto;
            min-width: 0;
            margin-left: 2px;
        }
        .doc-preview-media { max-width: 100%; max-height: 70vh; border-radius: 8px; }
        .doc-preview-frame { width: 100%; height: 70vh; border: 0; }
        #docPreviewModalLabel { min-width: 0; }

        .card-link {
            text-decoration: none;
        }

        @media (max-width: 575.98px) {
            .doc-slot .upload-area { padding: 0.75rem; }
            .doc-slot .upload-area i { font-size: 1.1rem; }
            .doc-slot .upload-area p { font-size: 0.8rem; }
            .file-preview-item { padding: 7px 10px; gap: 8px; font-size: 0.82rem; }
            .doc-preview-media { max-height: 82vh; }
            .doc-preview-frame { height: 82vh; }
        }

        @media (max-width: 991.98px) {
            .navbar-custom {
                padding: 0.75rem 1rem;
            }
            .hero-section {
                padding: 2.5rem 1rem 1.5rem;
            }
            .selector-card {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            body {
                background-attachment: scroll;
            }
            .navbar-brand {
                font-size: clamp(0.85rem, 4vw, 1rem);
                white-space: normal;
                line-height: 1.25;
            }
            .hero-section {
                padding: 2rem 0.75rem 1.25rem;
            }
            .hero-title {
                font-size: clamp(1.75rem, 8vw, 2.2rem);
                line-height: 1.2;
                overflow-wrap: anywhere;
            }
            .welcome-badge {
                max-width: 100%;
                padding: 0.35rem 1rem;
                font-size: 0.9rem;
            }
            .current-date {
                font-size: 0.82rem;
            }
            .grade-section {
                padding: 1rem 0.75rem 2.5rem;
            }
            .selector-card {
                border-radius: 24px;
                padding: 1.5rem 1rem;
            }
            .top-link {
                width: 44px;
                height: 44px;
                right: 1rem;
                bottom: 1rem;
            }
            .footer-custom {
                border-top-left-radius: 24px;
                border-top-right-radius: 24px;
                padding: 1.5rem 1rem;
            }
            .modern-modal .modal-dialog {
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
                height: 100% !important;
                max-height: 100% !important;
            }
            .modern-modal .modal-content {
                border-radius: 0 !important;
                height: 100vh;
            }
            .modal-body { padding: 1rem !important; }
            .form-section { padding: 0.85rem !important; border-radius: 14px !important; }
            .modal-footer {
                padding: 0.75rem 1rem !important;
                display: flex;
                justify-content: space-between;
            }
            .modal-footer .btn {
                padding: 0.5rem 1rem !important;
                font-size: 0.9rem !important;
                flex: 1;
                margin: 0 4px;
                text-align: center;
            }
        }

        @media (max-width: 420px) {
            .navbar-custom {
                padding: 0.65rem 0.75rem;
            }
            .hero-title {
                font-size: 1.6rem;
            }
            .welcome-badge {
                font-size: 0.8rem;
            }
            .selector-card {
                padding: 1.25rem 0.8rem;
                border-radius: 20px;
            }
        }

        /* Back to top button */
        .top-link {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #0b2b5c;
            width: 50px;
            height: 50px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s;
            z-index: 99;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            transition: 0.2s ease;
        }
        .top-link.show {
            opacity: 1;
            visibility: visible;
        }
        .top-link:hover {
            background: #1f5a9e;
            transform: translateY(-5px);
        }

        /* Footer */
        .footer-custom {
            background: #0b1f33;
            color: #cddcec;
            padding: 2rem 1rem;
            text-align: center;
            font-size: 0.9rem;
            border-top-left-radius: 32px;
            border-top-right-radius: 32px;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<!-- Modern Navbar -->
<?php $active_page = 'dashboard'; include(VIEWS_PATH . '/partials/student_navbar.php'); ?>

<!-- Hero / Welcome Section -->
<div class="hero-section">
    <div class="container">
       
        <h1 class="hero-title"><br> <span style="background: linear-gradient(135deg,#1e5a88,#0f3b7a); -webkit-background-clip:text; background-clip:text; color:transparent;"><?= htmlspecialchars($userdetails['surname'] . ', ' . $userdetails['firstname']); ?></span></h1>
        <div class="current-date">
            <i class="far fa-calendar-alt me-1"></i> <?= $current_date ?>
        </div>
    </div>
</div>

<!-- Unified Enrollment Entry Point -->
<div class="grade-section">
    <div class="container">
        <div class="selector-card" data-aos="fade-up">
            <label class="selector-label">
                Ready to Enroll?
            </label>
            <?php if (empty($enrollment_open)): ?>
            <button type="button" class="btn btn-enroll" disabled>
                <i class="fas fa-lock me-2"></i> Enrollment Closed
            </button>
            <p class="text-muted small mt-2 mb-0">
                <i class="fas fa-info-circle me-1"></i>
                Enrollment is currently closed. Please check back once the school reopens enrollment.
            </p>
            <?php else: ?>
            <a href="student_enrollment.php" class="btn btn-enroll"
               onclick="showAdminLoading('Loading enrollment form...', 'pen-alt'); window.location.href='student_enrollment.php'; return false;">
                 Enroll Now
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Unified Enrollment Modal (Grades 7-12) -->
<div class="modal fade modern-modal" id="enrollmentModal" tabindex="-1" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="enrollForm" method="post" action="enroll_submit.php" enctype="multipart/form-data" class="was-validated">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="enrollmentModalLabel">
                        <i class="fas fa-edit me-2"></i><span id="enrollmentModalTitleText">Enrollment Form</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">

                    <div class="form-section" id="gradeLevelSection">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold"><i class="fas fa-layer-group me-1"></i> Grade Level:</label>
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
                                <label class="form-label fw-semibold"><i class="fas fa-user-tag me-1"></i> Student Type:</label>
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

                    <div id="mainFormFields" style="display:none;">

                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">School Year:</label>
                                    <select name="sy" class="form-select" required>
                                        <option value="2026-2027">2026-2027</option>
                                        <option value="2027-2028">2027-2028</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">LRN:</label>
                                    <input name="lrn" type="text" class="form-control" placeholder="Learner Reference No." required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">School ID:</label>
                                    <input id="school_id_top" type="text" class="form-control" placeholder="School ID" required>
                                </div>
                            </div>
                            <div class="row g-3 mt-2" id="courseSection" style="display:none;">
                                <div class="col-12">
                                    <label class="form-label fw-semibold" id="courseLabel">Course:</label>
                                    <select name="course" id="courseSelect" class="form-select border-primary">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h6><i class="fas fa-user-graduate me-2"></i>Learner Information</h6>
                            <div class="row g-3">
                                <div class="col-md-4"><label>Last Name</label><input name="lname" type="text" class="form-control" placeholder="Last Name" required></div>
                                <div class="col-md-4"><label>First Name</label><input name="fname" type="text" class="form-control" placeholder="First Name" required></div>
                                <div class="col-md-4"><label>Middle Name</label><input name="mi" type="text" class="form-control" placeholder="Middle Name" required></div>
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small mb-1">
                                        <i class="fas fa-calendar-alt me-1"></i>Date of Birth
                                    </label>
                                    <input name="bdate" type="date" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Sex</label>
                                    <select name="sex" class="form-select" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4"><label>Age</label><input name="age" type="number" class="form-control" placeholder="Age" required></div>
                                <div class="col-md-4"><label>Contact Number</label><input name="contact" type="number" class="form-control" placeholder="Contact No." required></div>
                                <div class="col-md-8"><label>Email Address</label><input name="email" type="email" class="form-control" placeholder="Email Address" required></div>
                                <div class="col-md-6"><label>Current Address</label><textarea name="current_address" class="form-control" rows="2" placeholder="Current Address" required></textarea></div>
                                <div class="col-md-6"><label>Permanent Address</label><textarea name="perm_address" class="form-control" rows="2" placeholder="Permanent Address" required></textarea></div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h6><i class="fas fa-users me-2"></i>Parent / Guardian</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="fw-semibold">Father's Name</label>
                                    <input name="ffname" class="form-control mb-2" placeholder="First Name" required>
                                    <input name="flname" class="form-control mb-2" placeholder="Last Name" required>
                                    <input name="fmi" class="form-control mb-2" placeholder="Middle Initial" required>
                                    <input name="contact_f" class="form-control" placeholder="Contact No." required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold">Mother's Maiden Name</label>
                                    <input name="mfname" class="form-control mb-2" placeholder="First Name" required>
                                    <input name="mlname" class="form-control mb-2" placeholder="Last Name" required>
                                    <input name="mmi" class="form-control mb-2" placeholder="Middle Initial" required>
                                    <input name="contact_m" class="form-control" placeholder="Contact No." required>
                                </div>
                            </div>
                        </div>

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

                        <div class="form-section">
                            <h6><i class="fas fa-file-upload me-2"></i>Upload Supporting Documents</h6>
                            <p class="text-muted small mb-3">Upload one file at a time for each document below. Accepted: PDF, JPG, PNG, DOC, DOCX &mdash; Max 5MB per file.</p>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold small">PSA Birth Certificate</label>
                                    <div class="doc-slot">
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
                                    <div class="doc-slot">
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
                                    <div class="doc-slot">
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
                                    <div class="doc-slot">
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

                        <input type="hidden" name="student_type" id="studentTypeHidden" value="new">
                        <input type="hidden" name="id_student" value="<?= $userdetails['id_student'] ?? ''; ?>">
                        <input type="hidden" name="grade_level" id="gradeLevelHidden" value="">
                        <input type="hidden" name="prev_grade_table" id="prevGradeTable" value="">
                        <input type="hidden" name="prev_grade_id" id="prevGradeId" value="">

                    </div></div><div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="enrollSubmitBtn" class="btn btn-modal-submit rounded-pill px-4" disabled>
                        <span class="enroll-spinner"></span><i class="fas fa-paper-plane me-2 enroll-submit-icon"></i><span id="enrollSubmitBtnText">Submit</span>
                    </button>
                </div>

            </form>
        </div>
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
            confirmButtonColor: '#3085d6',
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
<?php endif; ?>

<!-- Back to Top Button -->
<a href="#" class="top-link" id="backToTopBtn" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</a>

<!-- Footer -->
<?php include(VIEWS_PATH . '/partials/student_footer.php'); ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS scroll animations
    AOS.init({
        duration: 800,
        once: true,
        offset: 20,
    });

    // Back to top button visibility + smooth scroll
    const backBtn = document.getElementById('backToTopBtn');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            backBtn.classList.add('show');
        } else {
            backBtn.classList.remove('show');
        }
    });
    backBtn.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Tooltip initialization (if any)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<!-- ===== UNIFIED ENROLLMENT MODAL LOGIC (Grades 7-12) ===== -->
<script>
// Server-computed per-grade availability + auto-fill data. Grade 7 has no
// "previous grade" (it's the school's entry level), so prevDataByGrade[7]
// is always null.
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

// Keep the top "School ID" field and the "School ID (Previous)" field
// in sync — they represent the same value, but only the bottom one
// (name="school_id") is actually submitted/saved.
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
    var fields   = document.getElementById('mainFormFields');
    var lrnField = document.querySelector('input[name="lrn"]');
    if (val === '') {
        lookup.style.display = 'none';
        fields.style.display = 'none';
        document.getElementById('enrollSubmitBtn').disabled = true;
    } else if (val === 'new') {
        lookup.style.display = 'none';
        fields.style.display = 'block';
        clearForm();
        if (lrnField) { lrnField.readOnly = false; lrnField.value = ''; }
        document.getElementById('studentTypeHidden').value = 'new';
        document.getElementById('enrollSubmitBtn').disabled = false;
    } else {
        lookup.style.display = 'block';
        fields.style.display = 'block';
        if (lrnField) lrnField.readOnly = true;
        document.getElementById('studentTypeHidden').value = val;
        document.getElementById('enrollSubmitBtn').disabled = false;
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
    document.getElementById('mainFormFields').style.display = 'block';
    document.getElementById('enrollSubmitBtn').disabled = false;
}

document.getElementById('gradeLevelSelect').addEventListener('change', function() {
    var grade = this.value;
    var status = gradeStatus[grade];
    var hint = document.getElementById('gradeLevelHint');
    document.getElementById('gradeLevelHidden').value = grade;
    document.getElementById('enrollmentModalTitleText').textContent = status.label + ' Enrollment Form';
    hint.textContent = '';

    clearForm();
    setCourseSection(status.tier);

    document.getElementById('studentTypeSection').style.display = 'none';
    document.getElementById('lrnLookupSection').style.display = 'none';
    document.getElementById('mainFormFields').style.display = 'none';
    document.getElementById('enrollSubmitBtn').disabled = true;

    if (grade === '7') {
        // Grade 7 is the school's entry grade — always a fresh, new-student form.
        var typeSelect = document.getElementById('studentTypeSelect');
        if (typeSelect) typeSelect.value = 'new';
        document.getElementById('studentTypeHidden').value = 'new';
        document.getElementById('mainFormFields').style.display = 'block';
        document.getElementById('enrollSubmitBtn').disabled = false;
        return;
    }

    var prevData = prevDataByGrade[grade];
    if (prevData) {
        useContinuingStudent(grade, prevData);
    } else {
        // No approved previous-grade record found (e.g. a transferee) —
        // same as Grade 7: skip the Student Type question and go straight
        // to a fresh, fillable form.
        var typeSelect = document.getElementById('studentTypeSelect');
        if (typeSelect) typeSelect.value = 'new';
        document.getElementById('studentTypeHidden').value = 'new';
        document.getElementById('lrnLookupSection').style.display = 'none';
        var lrnField = document.querySelector('input[name="lrn"]');
        if (lrnField) lrnField.readOnly = false;
        document.getElementById('mainFormFields').style.display = 'block';
        document.getElementById('enrollSubmitBtn').disabled = false;
    }
});

// Reset everything when the modal closes
document.getElementById('enrollmentModal').addEventListener('hidden.bs.modal', function() {
    var form = document.getElementById('enrollForm');
    form.reset();
    document.getElementById('gradeLevelSelect').value = '';
    document.getElementById('gradeLevelHidden').value = '';
    document.getElementById('studentTypeSection').style.display = 'none';
    document.getElementById('lrnLookupSection').style.display = 'none';
    document.getElementById('mainFormFields').style.display = 'none';
    document.getElementById('courseSection').style.display = 'none';
    document.getElementById('enrollSubmitBtn').disabled = true;
    document.getElementById('enrollmentModalTitleText').textContent = 'Enrollment Form';
    resetDocSlots();
});

// Sync student type to hidden input
document.getElementById('studentTypeSelect').addEventListener('change', function() {
    document.getElementById('studentTypeHidden').value = this.value || 'new';
});

// Show/hide IP group and 4Ps ID fields conditionally
document.querySelector('[name="is_ip"]').addEventListener('change', function() {
    document.getElementById('ip_group_div').style.display = this.value === 'Yes' ? '' : 'none';
});
document.querySelector('[name="is_4ps"]').addEventListener('change', function() {
    document.getElementById('fourps_id_div').style.display = this.value === 'Yes' ? '' : 'none';
});

// Real-time LRN availability check, scoped to whichever grade is selected right now
(function() {
    var lrnInput = document.querySelector('input[name="lrn"]');
    if (!lrnInput) return;
    var feedback = document.createElement('div');
    feedback.style.cssText = 'font-size:.85rem;margin-top:4px;';
    lrnInput.parentNode.insertBefore(feedback, lrnInput.nextSibling);
    var timer = null;
    lrnInput.addEventListener('input', function() {
        clearTimeout(timer);
        var val = this.value.trim();
        feedback.innerHTML = '';
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
                        feedback.innerHTML = '<i class="fas fa-times-circle" style="color:#dc3545;"></i> <span style="color:#dc3545;">' + msg + '</span>';
                        lrnInput.style.borderColor = '#dc3545';
                        lrnInput.setCustomValidity(msg);
                    } else {
                        feedback.innerHTML = '<i class="fas fa-check-circle" style="color:#28a745;"></i> <span style="color:#28a745;">LRN is available.</span>';
                        lrnInput.style.borderColor = '#28a745';
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

// Validate only on submit
document.getElementById('enrollForm').addEventListener('submit', function(e) {
    this.classList.add('was-validated');
    if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        var firstInvalid = this.querySelector(':invalid');
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalid.focus();
            var lbl = firstInvalid.closest('.col-md-4, .col-md-6, .col-md-8, .col-12, div')?.querySelector('label');
            var fieldName = lbl ? lbl.textContent.trim() : (firstInvalid.placeholder || firstInvalid.name);
            alert('Please check this field before submitting: ' + fieldName);
        }
        return;
    }
    var submitBtn = document.getElementById('enrollSubmitBtn');
    var submitBtnText = document.getElementById('enrollSubmitBtnText');
    submitBtn.classList.add('is-loading');
    submitBtn.disabled = true;
    if (submitBtnText) submitBtnText.textContent = 'Submitting...';
    if (typeof showAdminLoading === 'function') showAdminLoading('Submitting your enrollment...', 'paper-plane');
});

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

function resetDocSlots() {
    document.querySelectorAll('.doc-slot').forEach(function(slot) {
        const input  = slot.querySelector('.doc-slot-input');
        const empty  = slot.querySelector('.doc-slot-empty');
        const filled = slot.querySelector('.doc-slot-filled');
        input.value = '';
        filled.classList.add('d-none');
        empty.classList.remove('d-none');
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

    previewBtn.addEventListener('click', function() {
        previewDocFile(input.files[0]);
    });

    removeBtn.addEventListener('click', function() {
        input.value = '';
        filled.classList.add('d-none');
        empty.classList.remove('d-none');
    });
});
</script>

<script src="js/pwa.js"></script>
</body>
</html>
