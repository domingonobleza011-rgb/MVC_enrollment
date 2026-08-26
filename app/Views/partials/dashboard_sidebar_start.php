<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- PWA -->
    <link rel="manifest" href="manifest.php">
    <meta name="theme-color" content="#0b2b5c">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="EPAMNHS">
    <link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">

    <title>EUSEBIA PAZ ARROYO NATIONAL HIGH SCHOOL</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>

    <style>
        /* ================================================
                   IMPROVED SIDEBAR - SAME POSITION
                   ================================================ */

#accordionSidebar {
    background: linear-gradient(180deg, #0a1e3d 0%, #0b2b5c 40%, #0f3b7a 100%) !important;
    box-shadow: 4px 0 30px rgba(0, 0, 0, 0.3) !important;
    border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
    transition: all 0.3s ease;
}

        /* ----- Sidebar Brand ----- */
        #accordionSidebar .sidebar-brand {
            padding: 20px 15px !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            position: relative !important;
        }

        #accordionSidebar .sidebar-brand::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20%;
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.4), transparent);
        }

        #accordionSidebar .sidebar-brand .sidebar-brand-text {
            font-size: 16px !important;
            font-weight: 800 !important;
            letter-spacing: 0.5px !important;
            text-transform: uppercase !important;
            color: #ffffff !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
        }

        #accordionSidebar .sidebar-brand .sidebar-brand-text small {
            display: block !important;
            font-size: 10px !important;
            font-weight: 400 !important;
            letter-spacing: 1.5px !important;
            color: rgba(255, 255, 255, 0.5) !important;
            text-transform: uppercase !important;
            margin-top: 2px !important;
        }

        /* ----- Sidebar Headings ----- */
        #accordionSidebar .sidebar-heading {
            padding: 12px 20px 8px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            color: rgba(255, 255, 255, 0.35) !important;
            position: relative !important;
        }

        #accordionSidebar .sidebar-heading::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            width: 30px;
            height: 2px;
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.5), transparent);
        }

        /* ----- Sidebar Divider ----- */
        #accordionSidebar hr.sidebar-divider {
            border-color: rgba(255, 255, 255, 0.06) !important;
            margin: 8px 20px !important;
        }

        /* ----- Nav Items ----- */
        #accordionSidebar .nav-item .nav-link {
            padding: 11px 20px !important;
            margin: 2px 10px !important;
            border-radius: 12px !important;
            color: rgba(255, 255, 255, 0.65) !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            transition: all 0.25s ease !important;
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        #accordionSidebar .nav-item .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.08) !important;
            transform: translateX(4px) !important;
        }

#accordionSidebar .nav-item.active .nav-link {
    color: #0b2b5c !important;
    background: #ffffff !important;
    box-shadow: none !important;
    border: none !important;
}

        #accordionSidebar .nav-item.active,
        #accordionSidebar .nav-item.active .nav-link {
            box-shadow: none !important;
        }

        #accordionSidebar .nav-item.active .nav-link::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: linear-gradient(180deg, #818cf8, #6366f1);
            border-radius: 0 4px 4px 0;
        }

        #accordionSidebar .nav-item .nav-link span:first-child {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #accordionSidebar .nav-item .nav-link span:first-child i {
            width: 20px;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.4);
            transition: color 0.25s ease;
        }

        #accordionSidebar .nav-item .nav-link:hover span:first-child i,
        #accordionSidebar .nav-item.active .nav-link span:first-child i {
            color: #818cf8;
        }

        /* ----- Grade Pending Badge ----- */
        .grade-pending-badge {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 22px !important;
            height: 22px !important;
            padding: 0 7px !important;
            border-radius: 20px !important;
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: #fff !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            line-height: 1 !important;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.35) !important;
            animation: pulse-badge 2s ease-in-out infinite !important;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ----- Sidebar Toggle Button ----- */
        #sidebarToggle {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            transition: all 0.3s ease !important;
            width: 36px !important;
            height: 36px !important;
            margin-top: 12px !important;
        }

        #sidebarToggle:hover {
            background: rgba(255, 255, 255, 0.18) !important;
            transform: rotate(90deg) !important;
        }

        #sidebarToggle::before {
            content: '\f053';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 14px;
        }

        /* ================================================
                   ENHANCED NOTIFICATION - SAME POSITION
                   ================================================ */

        .topbar .nav-link.dropdown-toggle {
            position: relative !important;
            padding: 8px 12px !important;
            border-radius: 12px !important;
            transition: all 0.25s ease !important;
            color: #4a5568 !important;
        }

        .topbar .nav-link.dropdown-toggle:hover {
            background: rgba(99, 102, 241, 0.08) !important;
            color: #6366f1 !important;
        }

        .topbar .nav-link.dropdown-toggle .fa-bell {
            font-size: 20px !important;
        }

        /* Notification Badge Counter - TOP-RIGHT (standard) */
        .badge-counter {
            position: absolute !important;
            top: 4px !important;
            right: -4px !important;
            transform: none !important;
            min-width: 20px !important;
            height: 20px !important;
            padding: 0 6px !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            line-height: 20px !important;
            border-radius: 20px !important;
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4) !important;
            border: 2px solid #fff !important;
        }

        .topbar .nav-item.dropdown {
            overflow: visible !important;
        }

        /* Dropdown Container */
        .dropdown-list {
            border: none !important;
            border-radius: 16px !important;
            padding: 0 !important;
            background: #ffffff !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 4px 20px rgba(0, 0, 0, 0.05) !important;
            min-width: 380px !important;
            max-width: 420px !important;
            overflow: hidden !important;
        }

        /* Dropdown Header */
        .dropdown-list .dropdown-header {
            padding: 18px 22px !important;
            background: linear-gradient(135deg, #f8faff, #f0f4ff) !important;
            border-bottom: 1px solid #edf2f7 !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            color: #1a202c !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .dropdown-list .dropdown-header .header-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 2px 12px;
            border-radius: 20px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
        }

        /* Dropdown Items */
        .dropdown-list .dropdown-item {
            padding: 14px 20px !important;
            border-bottom: 1px solid #f7fafc !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: flex-start !important;
            gap: 14px !important;
        }

        .dropdown-list .dropdown-item:last-child {
            border-bottom: none !important;
        }

        .dropdown-list .dropdown-item:hover {
            background: #f8faff !important;
            transform: translateX(2px) !important;
        }

        /* Icon Circle */
        .dropdown-list .dropdown-item .icon-circle {
            width: 44px !important;
            height: 44px !important;
            min-width: 44px !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: linear-gradient(135deg, #fef3c7, #fde68a) !important;
            color: #d97706 !important;
            font-size: 18px !important;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15) !important;
        }

        .dropdown-list .dropdown-item .icon-circle.text-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
            color: #059669 !important;
        }

        .dropdown-list .dropdown-item .icon-circle.text-danger {
            background: linear-gradient(135deg, #fee2e2, #fca5a5) !important;
            color: #dc2626 !important;
        }

        .dropdown-list .dropdown-item .icon-circle.text-primary {
            background: linear-gradient(135deg, #dbeafe, #93c5fd) !important;
            color: #2563eb !important;
        }

        /* Item Content */
        .dropdown-list .dropdown-item .item-content {
            flex: 1;
            min-width: 0;
        }

        .dropdown-list .dropdown-item .item-content .item-title {
            font-weight: 600 !important;
            color: #1a202c !important;
            font-size: 14px !important;
            margin-bottom: 2px !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .dropdown-list .dropdown-item .item-content .item-subtitle {
            font-size: 12px !important;
            color: #718096 !important;
            margin-bottom: 2px !important;
        }

        .dropdown-list .dropdown-item .item-content .item-meta {
            font-size: 11px !important;
            color: #a0aec0 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .dropdown-list .dropdown-item .item-content .item-meta .status-badge {
            padding: 1px 10px !important;
            border-radius: 12px !important;
            font-size: 10px !important;
            font-weight: 600 !important;
        }

        .status-badge.warning {
            background: #fef3c7 !important;
            color: #d97706 !important;
        }

        .status-badge.success {
            background: #d1fae5 !important;
            color: #059669 !important;
        }

        .status-badge.danger {
            background: #fee2e2 !important;
            color: #dc2626 !important;
        }

        /* Empty State */
        .dropdown-list .dropdown-item.text-center {
            padding: 30px 20px !important;
            color: #a0aec0 !important;
        }

        .dropdown-list .dropdown-item.text-center i {
            font-size: 32px !important;
            margin-bottom: 10px !important;
            color: #cbd5e0 !important;
        }

        /* Footer Link */
        .dropdown-list .dropdown-footer {
            padding: 12px 22px !important;
            background: #f7fafc !important;
            border-top: 1px solid #edf2f7 !important;
            text-align: center !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            color: #6366f1 !important;
            display: block !important;
            transition: all 0.2s ease !important;
        }

        .dropdown-list .dropdown-footer:hover {
            background: #edf2f7 !important;
            color: #4f46e5 !important;
            text-decoration: none !important;
        }

        /* ================================================
                   TOPBAR IMPROVEMENTS - SAME POSITION
                   ================================================ */

        .topbar {
            background: #ffffff !important;
            border-bottom: 1px solid #edf2f7 !important;
            padding: 12px 24px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04) !important;
        }

        .topbar-divider {
            border-color: #edf2f7 !important;
            height: 30px !important;
            margin: 0 8px !important;
        }

        /* User Info */
        .topbar .nav-link .text-gray-800 {
            color: #1a202c !important;
            font-weight: 600 !important;
            font-size: 14px !important;
        }

        .topbar .nav-link .fa-sign-out-alt {
            color: #a0aec0 !important;
            transition: color 0.25s ease !important;
        }

        .topbar .nav-link:hover .fa-sign-out-alt {
            color: #ef4444 !important;
        }

        /* ================================================
                   RESPONSIVE - SAME BEHAVIOR
                   ================================================ */

        @media (max-width: 768px) {
            .dropdown-list {
                min-width: 320px !important;
                max-width: 90vw !important;
                right: -10px !important;
            }

            .topbar .nav-link .text-gray-800 {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .dropdown-list {
                min-width: 290px !important;
            }
        }

        /* ================================================
                   ACTIONS DROPDOWN - UNCHANGED
                   ================================================ */

        .actions-dropdown-toggle {
            border-radius: 8px !important;
            font-weight: 600;
            padding: .4rem .9rem !important;
        }

        .actions-dropdown-menu {
            min-width: 240px;
            padding: .5rem;
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 12px 32px rgba(11, 43, 92, 0.18), 0 2px 10px rgba(0,0,0,0.10);
        }

        .actions-dropdown-menu .actions-dropdown-header {
            font-weight: 700;
            font-size: .72rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #90959c;
            padding: .4rem .6rem .35rem;
        }

        .actions-dropdown-menu .actions-dropdown-body {
            padding: 0;
        }

        .actions-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .5rem .55rem;
            border-radius: 10px;
            font-size: .95rem;
            font-weight: 600;
            color: #050505;
            transition: background .12s ease;
        }

        .actions-dropdown-menu .dropdown-item .action-icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 50%;
            background: #f0f2f5;
            color: #444950;
            font-size: 1rem;
        }

        .actions-dropdown-menu .dropdown-item.item-view .action-icon-badge   { background: #e7f3ff; color: #1877f2; }
        .actions-dropdown-menu .dropdown-item.item-archive .action-icon-badge { background: #f0f2f5; color: #65676b; }
        .actions-dropdown-menu .dropdown-item.item-approve .action-icon-badge { background: #e3f6e8; color: #1a9c4b; }
        .actions-dropdown-menu .dropdown-item.item-reject .action-icon-badge  { background: #fde8e8; color: #e0245e; }
        .actions-dropdown-menu .dropdown-item:hover,
        .actions-dropdown-menu .dropdown-item:focus {
            background: #f2f2f2;
            color: #050505;
            text-decoration: none;
        }
        .actions-dropdown-menu .dropdown-item.text-danger:hover { background: #fdecec; }
        .actions-dropdown-menu form { margin: 0; }
        .actions-dropdown-menu .dropdown-divider {
            margin: .35rem .5rem;
            border-color: #edf0f5;
        }
        .actions-dropdown-menu.dropdown-menu-floating {
            position: fixed !important;
            margin: 0 !important;
            transform: none !important;
            z-index: 3050 !important;
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admn_dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text">
                    Administrator Dashboard
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $current_page === 'admn_dashboard.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_dashboard.php">
                    <span><i class="fas fa-th-large"></i> Dashboard</span>
                </a>
            </li>
            <li class="nav-item <?= $current_page === 'admn_students.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_students.php">
                    <span><i class="fas fa-users"></i> Accounts</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Grade Level Enrollment
            </div>

            <?php
                $pending_by_grade = (isset($eusebia) && method_exists($eusebia, 'count_pending_by_grade'))
                    ? $eusebia->count_pending_by_grade()
                    : [];
            ?>

            <li class="nav-item <?= $current_page === 'admn_seven.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_seven.php">
                    <span><i class="fas fa-user-graduate"></i> GRADE-7</span>
                    <?php if (!empty($pending_by_grade['tbl_seven'])): ?>
                        <span class="grade-pending-badge"><?= $pending_by_grade['tbl_seven'] ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <li class="nav-item <?= $current_page === 'admn_eight.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_eight.php">
                    <span><i class="fas fa-user-graduate"></i> GRADE-8</span>
                    <?php if (!empty($pending_by_grade['tbl_eight'])): ?>
                        <span class="grade-pending-badge"><?= $pending_by_grade['tbl_eight'] ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <li class="nav-item <?= $current_page === 'admn_nine.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_nine.php">
                    <span><i class="fas fa-user-graduate"></i> GRADE-9</span>
                    <?php if (!empty($pending_by_grade['tbl_nine'])): ?>
                        <span class="grade-pending-badge"><?= $pending_by_grade['tbl_nine'] ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <li class="nav-item <?= $current_page === 'admn_ten.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_ten.php">
                    <span><i class="fas fa-user-graduate"></i> GRADE-10</span>
                    <?php if (!empty($pending_by_grade['tbl_ten'])): ?>
                        <span class="grade-pending-badge"><?= $pending_by_grade['tbl_ten'] ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <li class="nav-item <?= $current_page === 'admn_eleven.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_eleven.php">
                    <span><i class="fas fa-user-graduate"></i> GRADE-11</span>
                    <?php if (!empty($pending_by_grade['tbl_eleven'])): ?>
                        <span class="grade-pending-badge"><?= $pending_by_grade['tbl_eleven'] ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <li class="nav-item <?= $current_page === 'admn_twelve.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_twelve.php">
                    <span><i class="fas fa-user-graduate"></i> GRADE-12</span>
                    <?php if (!empty($pending_by_grade['tbl_twelve'])): ?>
                        <span class="grade-pending-badge"><?= $pending_by_grade['tbl_twelve'] ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item <?= $current_page === 'admn_classlist.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_classlist.php">
                    <span><i class="fas fa-list-ul"></i> Class List</span>
                </a>
            </li>
            <li class="nav-item <?= $current_page === 'admn_archive.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_archive.php">
                    <span><i class="fas fa-archive"></i> Archive</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Administration
            </div>

            <li class="nav-item <?= $current_page === 'admn_staff_crud.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_staff_crud.php">
                    <span><i class="fas fa-chalkboard-teacher"></i> Teachers &amp; Advisers</span>
                </a>
            </li>
            <li class="nav-item <?= $current_page === 'admn_student_verification.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_student_verification.php">
                    <span><i class="fas fa-shield-alt"></i> Account Verification</span>
                    <?php
                        $pending_verif_count = (isset($eusebia) && method_exists($eusebia, 'count_pending_student_verifications'))
                            ? $eusebia->count_pending_student_verifications()
                            : 0;
                    ?>
                    <?php if ($pending_verif_count > 0): ?>
                        <span class="grade-pending-badge" style="background: linear-gradient(135deg, #f59e0b, #d97706);"><?= $pending_verif_count ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item <?= $current_page === 'admn_settings.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_settings.php">
                    <span><i class="fas fa-sliders-h"></i> System Settings</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <?php
                            $pendingData = (isset($eusebia) && method_exists($eusebia, 'get_pending_enrollees'))
                                ? $eusebia->get_pending_enrollees()
                                : ['total' => 0, 'items' => []];
                        ?>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - Pending Enrollment Notification -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="pendingApprovalsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <?php if (!empty($pendingData['total'])): ?>
                                <span class="badge badge-danger badge-counter"><?= $pendingData['total'] > 99 ? '99+' : (int) $pendingData['total'] ?></span>
                                <?php endif; ?>
                            </a>
                            <!-- Dropdown - Pending Enrollment -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="pendingApprovalsDropdown" style="max-height:26rem; overflow-y:auto;">
                                <h6 class="dropdown-header">
                                    <span>🔔 Notifications</span>
                                    <span class="header-badge"><?= (int) $pendingData['total'] ?> Pending</span>
                                </h6>
                                <?php if (empty($pendingData['items'])): ?>
                                <div class="dropdown-item text-center">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <div style="font-weight: 500; color: #4a5568;">All caught up!</div>
                                    <div style="font-size: 12px; color: #a0aec0;">No pending enrollees</div>
                                </div>
                                <?php else: ?>
                                    <?php foreach ($pendingData['items'] as $item): ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= htmlspecialchars($item['link']) ?>">
                                        <div class="icon-circle">
                                            <i class="fas fa-user-clock"></i>
                                        </div>
                                        <div class="item-content">
                                            <div class="item-title"><?= htmlspecialchars($item['name']) ?></div>
                                            <div class="item-subtitle">
                                                <?= htmlspecialchars($item['grade']) ?>
                                                <?= $item['sy'] ? ' · S.Y. ' . htmlspecialchars($item['sy']) : '' ?>
                                            </div>
                                            <div class="item-meta">
                                                <span class="status-badge warning">⏳ Pending</span>
                                                <span>• <?= date('M d, h:i A') ?></span>
                                            </div>
                                        </div>
                                    </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if (!empty($pendingData['total'])): ?>
                                <a class="dropdown-footer" href="admn_dashboard.php">View All Notifications <i class="fas fa-arrow-right ml-1"></i></a>
                                <?php endif; ?>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- User Name -->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);">
                                <span class="mr-2 d-none d-lg-inline text-gray-800 small">
                                    <?= htmlspecialchars($userdetails['surname'] ?? '') ?>,
                                    <?= htmlspecialchars($userdetails['firstname'] ?? '') ?>
                                    <?= htmlspecialchars($userdetails['mname'] ?? '') ?>
                                </span>
                            </a>
                        </li>

                        <!-- Logout Icon Only -->
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutConfirmModal" title="Log out">
                                <i class="fas fa-sign-out-alt fa-fw"></i>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- End of Topbar -->
