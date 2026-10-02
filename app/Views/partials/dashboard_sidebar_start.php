<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Theme init: runs before CSS/paint so there's no flash of the wrong theme.
         Stored value is 'light', 'dark', or 'default' (follow system preference). -->
    <script>
        (function () {
            var stored = localStorage.getItem('eusebia_admin_theme') || 'default';
            var effective = stored;
            if (stored === 'default') {
                effective = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', effective);
            document.documentElement.setAttribute('data-theme-pref', stored);
        })();
    </script>
    <!-- Font size init: runs before CSS/paint so there's no flash of the wrong size.
         Stored value is 'small', 'medium', or 'large'. -->
    <script>
        (function () {
            var stored = localStorage.getItem('eusebia_admin_fontsize') || 'medium';
            document.documentElement.setAttribute('data-fontsize', stored);
        })();
    </script>
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

    <!-- jQuery must load before any page content that uses it (e.g. the
         DataTables setup + filter-bar scripts inside admn_*_search.php
         partials, which render before dashboard_sidebar_end.php's own
         jQuery <script> tag further down the page). Loading it here in
         <head> guarantees $ is defined before those scripts run. -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

/* Hard stop for any page-level horizontal scrollbar. The fixed sidebar's
   box-shadow, the Bootstrap modal's scrollbar-compensation padding on
   <body>, and sub-pixel rounding from the zoom-based font-size selector
   below can each nudge the document a fraction of a pixel wider than the
   viewport. None of that should ever be user-visible as a stray
   horizontal scrollbar, so it's clamped at the source. */
html, body {
    overflow-x: hidden;
    max-width: 100%;
}

/* ----- Modal backdrop: cover the *real* viewport, not a zoomed one -----
   Bootstrap sizes .modal-backdrop with width:100vw/height:100vh. Those
   values get rendered through the same `zoom` scaling the font-size
   selector below applies to the whole page, so at "Small" (zoom:0.875)
   the backdrop is painted about 12% smaller than the actual screen —
   leaving a sliver of the real page uncovered and un-dimmed at the
   bottom/right edge. Since the sidebar sits there, its bright blue shows
   through at full saturation instead of being dimmed like the rest of
   the page behind the modal — that's the "dark navy patch" behind View /
   Edit / Add Student. Anchoring with inset instead of vw/vh sidesteps the
   zoom scaling entirely, so the dimmed overlay always reaches every edge. */
.modal-backdrop {
    width: auto;
    height: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

#accordionSidebar {
    background: #ffffff !important;
    box-shadow: 0 0 24px rgba(11, 43, 92, 0.07) !important;
    border-right: 1px solid #e3e6ec !important;
    transition: all 0.3s ease;
}

/* ----- Desktop: pin the sidebar to the viewport instead of the page -----
   Below md, #accordionSidebar is already `position:fixed` (see the mobile
   drawer rules further down this file). At md and up it was still a normal
   flex item sized off `min-height:100vh`, which is a *layout viewport*
   unit — it doesn't track the `zoom` used by the font-size selector below,
   so picking "Small" (zoom:0.875) leaves the real viewport taller than the
   zoomed 100vh, and the sidebar's blue background runs out before the
   bottom of the screen. Pinning it to the viewport with top/bottom
   (instead of a height) sidesteps that entirely. #content-wrapper gets a
   matching left margin so it isn't overlapped, kept in sync with the
   collapsed "icon rail" width when the sidebar is toggled. */
@media (min-width: 768px) {
    #accordionSidebar.sidebar {
        position: fixed !important;
        top: 0;
        left: 0;
        bottom: 0;
        height: auto;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1020;
    }
    #content-wrapper {
        margin-left: 14rem;
        width: calc(100% - 14rem);
        transition: margin-left 0.3s ease, width 0.3s ease;
    }
    body.sidebar-toggled #content-wrapper {
        margin-left: 6.5rem;
        width: calc(100% - 6.5rem);
    }
}

        /* ----- Sidebar Brand ----- */
        #accordionSidebar .sidebar-brand {
            padding: 20px 15px !important;
            background: transparent !important;
            border-bottom: 1px solid #eef0f4 !important;
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
            color: #0b2b5c !important;
            text-shadow: none !important;
        }

        #accordionSidebar .sidebar-brand .sidebar-brand-text small {
            display: block !important;
            font-size: 10px !important;
            font-weight: 400 !important;
            letter-spacing: 1.5px !important;
            color: #374151 !important;
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
            color: #374151 !important;
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
            border-color: #eef0f4 !important;
            margin: 8px 20px !important;
        }

        /* ----- Nav Items ----- */
        #accordionSidebar .nav-item .nav-link {
            padding: 11px 20px !important;
            margin: 2px 10px !important;
            border-radius: 12px !important;
            color: #1a1f2b !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            transition: all 0.25s ease !important;
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        #accordionSidebar .nav-item .nav-link:hover {
            color: #0b2b5c !important;
            background: #f1f4f9 !important;
            transform: translateX(4px) !important;
        }

#accordionSidebar .nav-item.active .nav-link {
    color: #0b2b5c !important;
    background: #e8effa !important;
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
            color: #374151;
            transition: color 0.25s ease;
        }

        #accordionSidebar .nav-item .nav-link:hover span:first-child i,
        #accordionSidebar .nav-item.active .nav-link span:first-child i {
            color: #1f5a9e;
        }

                   .gs-wrap { position: relative; flex: 0 1 440px; min-width: 0; margin-right: 12px; }
        .gs-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; pointer-events: none; }
        .gs-input {
            width: 100%; height: 40px; padding: 0 14px 0 38px;
            border: 1px solid var(--edb-input-border, #d1d5db); border-radius: 10px;
            background: #f8fafc; color: #0f172a; font-size: 14px; outline: none;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }
        .gs-input::placeholder { color: #64748b; }
        .gs-input:focus { background: #ffffff; border-color: rgba(var(--edb-chart-rgb, 55,65,81), .6); box-shadow: 0 0 0 3px rgba(var(--edb-chart-rgb, 55,65,81), .14); }
        .gs-panel {
            position: absolute; top: calc(100% + 8px); left: 0; z-index: 1040;
            width: min(560px, calc(100vw - 24px)); max-height: min(70vh, 520px); overflow-y: auto;
            background: #ffffff; border: 1px solid #e3e6ec; border-radius: 12px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, .16); padding: 6px 0; text-align: left;
        }
        .gs-panel[hidden] { display: none; }
        .gs-status-line { padding: 14px 16px; font-size: 13px; color: #64748b; }
        .gs-group { display: flex; align-items: center; gap: 8px; padding: 10px 16px 4px; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #475569; }
        .gs-count { font-weight: 600; letter-spacing: 0; text-transform: none; color: #64748b; }
        .gs-item { display: flex; align-items: center; gap: 10px; padding: 8px 16px; color: #0f172a !important; text-decoration: none !important; cursor: pointer; }
        .gs-item:hover, .gs-item.gs-active { background: #f1f5f9; }
        .gs-item-static { cursor: default; }
        .gs-item-static:hover { background: transparent; }
        .gs-badge { flex: 0 0 auto; min-width: 64px; text-align: center; padding: 2px 8px; border-radius: 999px; background: #eef2f7; color: #0f172a; font-size: 11px; font-weight: 700; }
        .gs-main { flex: 1 1 auto; min-width: 0; }
        .gs-name { font-size: 14px; font-weight: 600; line-height: 1.25; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .gs-sub { font-size: 12px; color: #64748b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .gs-state { flex: 0 0 auto; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px; background: #eef2f7; color: #334155; }
        .gs-state.st-pending { background: #fff3cd; color: #856404; }
        .gs-state.st-approved { background: #d4edda; color: #155724; }
        .gs-state.st-rejected { background: #f8d7da; color: #721c24; }
        .gs-more { padding: 2px 16px 8px 90px; font-size: 12px; color: #64748b; }
        .gs-panel mark { background: #fde68a; color: inherit; padding: 0 1px; border-radius: 3px; }
        html[data-theme="dark"] .gs-icon { color: rgba(255,255,255,.55); }
        html[data-theme="dark"] .gs-wrap .gs-input { background: rgba(255,255,255,.06) !important; border-color: rgba(255,255,255,.18) !important; color: #ffffff !important; }
        html[data-theme="dark"] .gs-input::placeholder { color: rgba(255,255,255,.55); }
        html[data-theme="dark"] .gs-wrap .gs-input:focus { background: rgba(255,255,255,.1) !important; }
        html[data-theme="dark"] .gs-panel { background: #1a1f2b; border-color: rgba(255,255,255,.1); box-shadow: 0 12px 32px rgba(0,0,0,.5); }
        html[data-theme="dark"] .gs-group, html[data-theme="dark"] .gs-count,
        html[data-theme="dark"] .gs-status-line, html[data-theme="dark"] .gs-more { color: rgba(255,255,255,.7); }
        html[data-theme="dark"] .gs-item { color: #ffffff !important; }
        html[data-theme="dark"] .gs-item:hover, html[data-theme="dark"] .gs-item.gs-active { background: rgba(255,255,255,.08); }
        html[data-theme="dark"] .gs-item-static:hover { background: transparent; }
        html[data-theme="dark"] .gs-sub { color: rgba(255,255,255,.65); }
        html[data-theme="dark"] .gs-badge { background: rgba(255,255,255,.14); color: #ffffff; }
        html[data-theme="dark"] .gs-state { background: rgba(255,255,255,.14); color: #ffffff; }
        html[data-theme="dark"] .gs-panel mark { background: rgba(255,215,0,.35); color: #ffffff; }
        @media (max-width: 768px) {
            .gs-wrap { flex: 1 1 auto; margin-right: 8px; }
            .gs-panel { position: fixed; top: 4.6rem; left: 8px; right: 8px; width: auto; }
            .gs-more { padding-left: 16px; }
        }

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

        /* .grade-pending-badge forces display with !important, so inline display:none never hid it */
        .grade-pending-badge[hidden] { display: none !important; }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ----- Sidebar Toggle Button ----- */
        #sidebarToggle {
            background: #f1f4f9 !important;
            border: 1px solid #e3e6ec !important;
            color: #0b2b5c !important;
            transition: all 0.3s ease !important;
            width: 36px !important;
            height: 36px !important;
            margin-top: 12px !important;
        }

        #sidebarToggle:hover {
            background: #e2e8f2 !important;
            transform: rotate(90deg) !important;
        }

        #sidebarToggle::before {
            content: '\f053';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 14px;
        }

        /* ================================================
           NOTIFICATION - simple, flat design
           One set of rules for light + dark: colors come from the
           --nt-* variables below (dark values are set further down).
           ================================================ */

        .topbar .nav-item.dropdown {
            overflow: visible !important;
        }

        .topbar .nav-link.dropdown-toggle {
            position: relative !important;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            color: #4a5568 !important;
            transition: background-color 0.15s ease !important;
        }

        .topbar .nav-link.dropdown-toggle:hover {
            background: rgba(0, 0, 0, 0.05) !important;
        }

        html[data-theme="dark"] .topbar .nav-link.dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.08) !important;
        }

        .topbar .nav-link.dropdown-toggle .fa-bell {
            font-size: 18px !important;
        }

        /* Bell + count sit side by side; the count is vertically centred next to the bell */
        #pendingApprovalsDropdown {
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
        }

        .badge-counter {
            position: absolute !important;
            /* The bell is vertically centred in the tall topbar link; anchor the badge to the
               bell's top-right corner (not to the top of the bar) so it sits right beside it. */
            top: 50% !important;
            margin-top: -17px !important;
            right: 4px !important;
            transform: none !important;
            min-width: 16px !important;
            height: 16px !important;
            padding: 0 4px !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            line-height: 16px !important;
            border: 0 !important;
            border-radius: 8px !important;
            background: #dc2626 !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        /* Dropdown container */
        .dropdown-list {
            --nt-bg: #ffffff;
            --nt-line: #eceef1;
            --nt-hover: #f6f7f9;
            --nt-text: #1f2937;
            --nt-muted: #6b7280;

            min-width: 320px !important;
            max-width: 360px !important;
            max-height: 26rem !important;
            padding: 0 !important;
            background: var(--nt-bg) !important;
            border: 1px solid var(--nt-line) !important;
            border-radius: 10px !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10) !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }

        html[data-theme="dark"] .dropdown-list {
            --nt-bg: #1a1f2b;
            --nt-line: rgba(255, 255, 255, 0.08);
            --nt-hover: rgba(255, 255, 255, 0.05);
            --nt-text: #e6e9f0;
            --nt-muted: #9aa3b5;

            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.40) !important;
        }

        /* Header: title + plain count */
        .topbar .dropdown-list .dropdown-header {
            position: sticky !important;
            top: 0 !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 14px 16px !important;
            background: var(--nt-bg) !important;
            border: 0 !important;
            border-bottom: 1px solid var(--nt-line) !important;
            color: var(--nt-text) !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            letter-spacing: normal !important;
            text-transform: none !important;
        }

        .dropdown-list .dropdown-header .header-count {
            font-size: 12px;
            font-weight: 500;
            color: var(--nt-muted);
        }

        /* Rows */
        .dropdown-list .dropdown-item {
            display: flex !important;
            align-items: flex-start !important;
            gap: 12px !important;
            padding: 12px 16px !important;
            background: transparent !important;
            border: 0 !important;
            border-bottom: 1px solid var(--nt-line) !important;
            color: var(--nt-text) !important;
            white-space: normal !important;
        }

        .dropdown-list .dropdown-item:last-child {
            border-bottom: 0 !important;
        }

        .dropdown-list a.dropdown-item:hover,
        .dropdown-list a.dropdown-item:focus,
        .dropdown-list a.dropdown-item:active {
            background: var(--nt-hover) !important;
            color: var(--nt-text) !important;
        }

        /* Small amber dot marks a pending enrollee */
        .dropdown-list .notif-dot {
            flex: 0 0 8px;
            width: 8px;
            height: 8px;
            margin-top: 6px;
            border-radius: 50%;
            background: #f59e0b;
        }

        .dropdown-list .item-content {
            flex: 1;
            min-width: 0;
        }

        .dropdown-list .item-title {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.3;
            color: var(--nt-text);
        }

        .dropdown-list .item-subtitle {
            margin-top: 2px;
            font-size: 12px;
            color: var(--nt-muted);
        }

        /* Empty state: one quiet line */
        .topbar .dropdown-list .notif-empty[hidden],
        .topbar .dropdown-list #msgNotifSection[hidden] { display: none !important; }
        .topbar .dropdown-list .notif-empty {
            justify-content: center !important;
            padding: 28px 16px !important;
            font-size: 13px !important;
            color: var(--nt-muted) !important;
        }

        .dropdown-list .notif-section-title {
            padding: 8px 16px 4px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--nt-muted);
        }

        /* Footer link */
        .dropdown-list .dropdown-footer {
            display: block !important;
            padding: 12px 16px !important;
            background: transparent !important;
            border-top: 0 !important;
            text-align: center !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: var(--nt-text) !important;
        }

        .dropdown-list .dropdown-footer:hover {
            background: var(--nt-hover) !important;
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
                   SIMPLE TABLES + ROW "ACTIONS" DROPDOWN
                   Shared by the grade lists, Archive, Students and
                   Account Verification.
                   ================================================ */
        
        /* Scroll box: scrolls sideways and down; the header row stays pinned. */
        .enr-scroll { overflow:auto; max-height:70vh; -webkit-overflow-scrolling:touch; }
        
        .simple-table { width:100%; margin:0 !important; font-size:.82rem; white-space:nowrap; }
        .simple-table thead th {
            position:sticky; top:0; z-index:2;
            padding:.5rem .75rem; vertical-align:middle;
            background:#f8f9fc; color:#5a5c69;
            font-size:.78rem; font-weight:700; text-transform:none; letter-spacing:normal;
            border:0; border-bottom:1px solid #e3e6ec;
        }
        .simple-table tbody td { padding:.4rem .75rem; vertical-align:middle; border:0; border-bottom:1px solid #eef0f4; }
        html:not([data-theme="dark"]) .simple-table tbody td { color:#2d3142; }
        .simple-table td > .btn-sm,
        .simple-table .row-actions > .btn-sm { padding:.15rem .5rem; font-size:.75rem; }
        
        /* Row "Actions": a plain Bootstrap dropdown. The script in dashboard_sidebar_end.php
           floats the open menu (position:fixed) so the scroll box can't clip it, and adds
           .is-dropup when it has to open upward. */
        .row-actions { display:inline-block; }
        .row-actions-menu { min-width:10rem; padding:.25rem 0; font-size:.82rem; text-align:left; }
        .row-actions-menu form { margin:0; }
        .row-actions-menu .dropdown-item { padding:.35rem .9rem; }
        .row-actions-menu .dropdown-item i { width:1.25em; margin-right:.4rem; text-align:center; }
        .row-actions-menu .dropdown-divider { margin:.25rem 0; }
        .row-actions-menu .dropdown-item.item-reject { color:#dc3545; }
        html[data-theme="dark"] .row-actions-menu .dropdown-item.item-reject { color:#f28b82 !important; }
        .row-actions-menu.is-floating { position:fixed; margin:0; transform:none; z-index:1030; overflow-y:auto; }
        .row-actions.is-dropup > .dropdown-toggle::after { border-top:0; border-bottom:.3em solid; }

        /* Text that used to be blue in the grade-level lists (Documents "View", AI "View details",
           page titles, strand labels, sort dropdowns): dark in light mode, white in dark mode. */
        .text-ink { color:#1a1f2b !important; }
        #studentsTable td > .doc-view-btn,
        #studentsTable td > .btn-link { color:#1a1f2b; }
        #studentsTable td > .doc-view-btn { border-color:#6b7280; background:transparent; }
        #studentsTable td > .doc-view-btn:hover { color:#1a1f2b; background:#eef1f6; border-color:#1a1f2b; }
        #studentsTable td > .btn-link:hover { color:#000000; }
        html[data-theme="dark"] .text-ink,
        html[data-theme="dark"] select.text-ink { color:#ffffff !important; }
        html[data-theme="dark"] #studentsTable td > .doc-view-btn,
        html[data-theme="dark"] #studentsTable td > .btn-link { color:#ffffff; }
        html[data-theme="dark"] #studentsTable td > .doc-view-btn { border-color:rgba(255,255,255,0.6); }
        html[data-theme="dark"] #studentsTable td > .doc-view-btn:hover { color:#ffffff; background:rgba(255,255,255,0.1); border-color:#ffffff; }
        html[data-theme="dark"] #studentsTable td > .btn-link:hover { color:#ffffff; }
        
        /* ================================================
                   THEME SWITCHER (topbar dropdown)
                   ================================================ */
        .theme-switch-menu { min-width: 180px; }
        .theme-switch-menu .dropdown-item.active-theme {
            font-weight: 700;
            color: #0b2b5c;
        }
        .theme-switch-menu .dropdown-item.active-theme i.fa-check { display: inline-block !important; }
        .theme-switch-menu .dropdown-item i.fa-check { display: none; margin-left: auto; }
        .theme-switch-menu .dropdown-item { display: flex; align-items: center; gap: 10px; }

        /* ================================================
                   FONT SIZE (applied via admn_settings.php)
                   ================================================ */
        /* Scales the whole admin portal's text (and, as a side effect, spacing/icons
           along with it — the codebase mixes px and rem font-sizes throughout, so a
           uniform zoom is the only way to size *every* label consistently). */
        /* Font size selector: the sidebar uses min-height:100vh, but `vh` units
           don't scale with `zoom` the way rem/px do — so shrinking everything
           via "Small" leaves a gap below shorter pages. Forcing the content
           column to also fill the viewport keeps that gap the correct
           background color instead of stark white. */
        #content-wrapper { min-height: 100vh; }

        html[data-fontsize="small"]  { zoom: 0.875; }
        html[data-fontsize="medium"] { zoom: 1; }
        html[data-fontsize="large"]  { zoom: 1.15; }

        /* ================================================
                   DARK MODE
                   ================================================ */
        html[data-theme="dark"] body {
            background-color: #12161f !important;
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] #content-wrapper {
            background-color: #12161f !important;
        }
        html[data-theme="dark"] .topbar.navbar-light,
        html[data-theme="dark"] nav.navbar.bg-white {
            background-color: #1a1f2b !important;
            border-color: rgba(255,255,255,0.06) !important;
        }
        html[data-theme="dark"] .topbar .nav-link,
        html[data-theme="dark"] .topbar .nav-link i {
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] .topbar .nav-link .text-gray-800 {
            color: #eef0f4 !important;
        }
        html[data-theme="dark"] .topbar-divider {
            border-color: rgba(255,255,255,0.1) !important;
        }
        html[data-theme="dark"] .card {
            background-color: #1a1f2b !important;
            border-color: rgba(255,255,255,0.08) !important;
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] .card-header {
            background-color: #1e2432 !important;
            border-color: rgba(255,255,255,0.08) !important;
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] .table {
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] .table thead th {
            background-color: #1e2432 !important;
            color: #d7dbe2 !important;
            border-color: rgba(255,255,255,0.08) !important;
        }
        html[data-theme="dark"] .table td,
        html[data-theme="dark"] .table th {
            border-color: rgba(255,255,255,0.08) !important;
        }
        html[data-theme="dark"] .table-hover tbody tr:hover {
            background-color: rgba(255,255,255,0.04) !important;
            color: #ffffff !important;
        }
        html[data-theme="dark"] .table-bordered,
        html[data-theme="dark"] .table-bordered td,
        html[data-theme="dark"] .table-bordered th {
            border-color: rgba(255,255,255,0.08) !important;
        }
        html[data-theme="dark"] .form-control,
        html[data-theme="dark"] .custom-select,
        html[data-theme="dark"] select,
        html[data-theme="dark"] textarea,
        html[data-theme="dark"] input {
            background-color: #232a38 !important;
            border-color: rgba(255,255,255,0.12) !important;
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] .form-control::placeholder {
            color: rgba(215,219,226,0.4) !important;
        }
        html[data-theme="dark"] .form-control:focus {
            background-color: #232a38 !important;
            color: #ffffff !important;
        }
        html[data-theme="dark"] .modal-content {
            background-color: #1a1f2b !important;
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] .modal-header,
        html[data-theme="dark"] .modal-footer {
            border-color: rgba(255,255,255,0.08) !important;
        }
        html[data-theme="dark"] .dropdown-menu {
            background-color: #1a1f2b !important;
            border-color: rgba(255,255,255,0.08) !important;
        }
        html[data-theme="dark"] .dropdown-item {
            color: #d7dbe2 !important;
        }
        html[data-theme="dark"] .dropdown-item:hover,
        html[data-theme="dark"] .dropdown-item:focus {
            background-color: rgba(255,255,255,0.06) !important;
            color: #ffffff !important;
        }
        html[data-theme="dark"] .dropdown-header {
            color: rgba(215,219,226,0.6) !important;
        }
        html[data-theme="dark"] .dropdown-divider {
            border-color: rgba(255,255,255,0.08) !important;
        }
        /* Sidebar is white in the light theme; keep a dark surface when the dark theme is on. */
        html[data-theme="dark"] #accordionSidebar {
            background: #1a1f2b !important;
            box-shadow: none !important;
            border-right-color: rgba(255,255,255,0.08) !important;
        }
        html[data-theme="dark"] #accordionSidebar .sidebar-brand { border-bottom-color: rgba(255,255,255,0.08) !important; }
        html[data-theme="dark"] #accordionSidebar .sidebar-brand .sidebar-brand-text { color: #ffffff !important; }
        html[data-theme="dark"] #accordionSidebar .sidebar-brand .sidebar-brand-text small { color: #ffffff !important; }
        html[data-theme="dark"] #accordionSidebar .sidebar-heading { color: #ffffff !important; }
        html[data-theme="dark"] #accordionSidebar hr.sidebar-divider { border-color: rgba(255,255,255,0.08) !important; }
        html[data-theme="dark"] #accordionSidebar .nav-item .nav-link { color: #ffffff !important; }
        html[data-theme="dark"] #accordionSidebar .nav-item .nav-link:hover { color: #ffffff !important; background: rgba(255,255,255,0.06) !important; }
        html[data-theme="dark"] #accordionSidebar .nav-item.active .nav-link { color: #ffffff !important; background: rgba(255,255,255,0.1) !important; }
        html[data-theme="dark"] #accordionSidebar .nav-item .nav-link span:first-child i { color: #ffffff; }
        html[data-theme="dark"] #accordionSidebar .nav-item .nav-link:hover span:first-child i,
        html[data-theme="dark"] #accordionSidebar .nav-item.active .nav-link span:first-child i { color: #818cf8; }
        html[data-theme="dark"] #sidebarToggle { background: rgba(255,255,255,0.08) !important; border-color: rgba(255,255,255,0.1) !important; color: #ffffff !important; }
        html[data-theme="dark"] #sidebarToggle:hover { background: rgba(255,255,255,0.18) !important; }
        html[data-theme="dark"] .theme-switch-menu .dropdown-item.active-theme {
            color: #a5b4fc;
        }
        html[data-theme="dark"] h1, html[data-theme="dark"] h2, html[data-theme="dark"] h3,
        html[data-theme="dark"] h4, html[data-theme="dark"] h5, html[data-theme="dark"] h6,
        html[data-theme="dark"] .text-gray-800, html[data-theme="dark"] .text-gray-900 {
            color: #eef0f4 !important;
        }
        html[data-theme="dark"] .text-gray-600, html[data-theme="dark"] .text-gray-500 {
            color: #9aa2b1 !important;
        }
        html[data-theme="dark"] a:not(.btn):not(.nav-link):not(.dropdown-item) {
            color: #818cf8;
        }
        html[data-theme="dark"] .btn-outline-secondary,
        html[data-theme="dark"] .btn-secondary {
            color: #d7dbe2 !important;
            border-color: rgba(255,255,255,0.2) !important;
        }
        html[data-theme="dark"] hr {
            border-color: rgba(255,255,255,0.08) !important;
        }
        html[data-theme="dark"] ::-webkit-scrollbar-track {
            background: #12161f;
        }
        html[data-theme="dark"] ::-webkit-scrollbar-thumb {
            background: #3a4256;
        }

        /* ================================================
           PLAIN PAGE THEME
           Shared by Student List, Archive, Registered Accounts and
           Account Verification. Same neutral tokens as the dashboard:
           charcoal in light mode, light gray in dark mode.
           Pages opt in by adding class="plain-page" to their container,
           so nothing else in the admin area changes.
           ================================================ */
        :root {
            --edb-surface:      #ffffff;
            --edb-ink:          #0f172a;
            --edb-muted:        #64748b;
            --edb-border:       #e7ebf2;
            --edb-input-border: #d1d5db;
            --edb-shadow:       rgba(0, 0, 0, 0.06);
            --edb-chart-rgb:    55, 65, 81;
            --edb-on-chart:     #ffffff;
        }
        html[data-theme="dark"] {
            --edb-surface:      #1a1f2b;
            --edb-ink:          #e6e9f0;
            --edb-muted:        #9aa3b5;
            --edb-border:       rgba(255, 255, 255, 0.08);
            --edb-input-border: rgba(255, 255, 255, 0.18);
            --edb-shadow:       rgba(0, 0, 0, 0.35);
            --edb-chart-rgb:    209, 213, 219;
            --edb-on-chart:     #111827;
        }

        /* Bootstrap "primary" (SB Admin blue) -> neutral.
           Applies inside .plain-page (whole pages) and .plain-modal (the
           View / Edit / Add / Document-viewer modals on the grade tables). */
        .plain-page .btn-primary,
        .plain-page .btn-primary:focus,
        .plain-page .btn-primary:hover,
        .plain-page .btn-primary:active,
        .plain-page .btn-primary:not(:disabled):not(.disabled):active,
        .plain-modal .btn-primary,
        .plain-modal .btn-primary:focus,
        .plain-modal .btn-primary:hover,
        .plain-modal .btn-primary:active,
        .plain-modal .btn-primary:not(:disabled):not(.disabled):active {
            background-color: rgb(var(--edb-chart-rgb)) !important;
            border-color: rgb(var(--edb-chart-rgb)) !important;
            color: var(--edb-on-chart) !important;
        }
        .plain-page .btn-primary:hover,
        .plain-modal .btn-primary:hover { opacity: 0.88; }
        .plain-page .btn-primary:focus,
        .plain-page .btn-outline-primary:focus,
        .plain-modal .btn-primary:focus,
        .plain-modal .btn-outline-primary:focus {
            box-shadow: 0 0 0 0.15rem rgba(var(--edb-chart-rgb), 0.3) !important;
        }
        .plain-page .btn-outline-primary,
        .plain-modal .btn-outline-primary {
            background-color: transparent !important;
            border-color: rgba(var(--edb-chart-rgb), 0.45) !important;
            color: rgb(var(--edb-chart-rgb)) !important;
        }
        .plain-page .btn-outline-primary:hover,
        .plain-page .btn-outline-primary:active,
        .plain-page .btn-outline-primary:not(:disabled):not(.disabled):active,
        .plain-modal .btn-outline-primary:hover,
        .plain-modal .btn-outline-primary:active,
        .plain-modal .btn-outline-primary:not(:disabled):not(.disabled):active {
            background-color: rgba(var(--edb-chart-rgb), 0.10) !important;
            border-color: rgb(var(--edb-chart-rgb)) !important;
            color: rgb(var(--edb-chart-rgb)) !important;
        }
        .plain-page .text-primary,
        .plain-modal .text-primary { color: var(--edb-ink) !important; }
        .plain-page .badge-primary {
            background-color: rgba(var(--edb-chart-rgb), 0.12) !important;
            color: rgb(var(--edb-chart-rgb)) !important;
        }

        /* Inputs: neutral focus ring instead of the blue one */
        .plain-page .form-control:focus,
        .plain-page .custom-select:focus,
        .plain-modal .form-control:focus,
        .plain-modal .custom-select:focus {
            border-color: rgba(var(--edb-chart-rgb), 0.55) !important;
            box-shadow: 0 0 0 0.15rem rgba(var(--edb-chart-rgb), 0.15) !important;
        }

        /* Page banner (replaces the navy gradient headers) */
        .plain-page .plain-banner {
            background: var(--edb-surface);
            color: var(--edb-ink);
            border: 1px solid var(--edb-border);
            border-radius: 12px;
            box-shadow: 0 2px 10px var(--edb-shadow);
            margin-bottom: 24px;
        }
        .plain-page .plain-banner small { color: var(--edb-muted); opacity: 1; }

        /* ---- Modals: View / Edit / Add / Document viewer (grade tables) ----
           Opt in with class="plain-modal" on the .modal element. */
        .plain-modal .modal-header {
            background: var(--edb-surface);
            color: var(--edb-ink);
            border-bottom: 1px solid var(--edb-border);
        }
        .plain-modal .modal-header .modal-title { color: var(--edb-ink); }
        .plain-modal .modal-header .close {
            color: var(--edb-ink);
            opacity: 0.6;
            text-shadow: none;
        }
        .plain-modal .modal-header .close:hover { opacity: 1; }

        /* Radios / checkboxes: neutral instead of Bootstrap blue */
        .plain-modal input[type="checkbox"],
        .plain-modal input[type="radio"] { accent-color: rgb(var(--edb-chart-rgb)); }
        .plain-modal .custom-control-input:checked ~ .custom-control-label::before {
            background-color: rgb(var(--edb-chart-rgb));
            border-color: rgb(var(--edb-chart-rgb));
        }
        .plain-modal .custom-control-input:focus ~ .custom-control-label::before {
            box-shadow: 0 0 0 0.15rem rgba(var(--edb-chart-rgb), 0.25);
        }
        .plain-modal .custom-control-input:focus:not(:checked) ~ .custom-control-label::before {
            border-color: rgba(var(--edb-chart-rgb), 0.55);
        }
        /* light-gray fill in dark mode needs a dark dot / tick to stay visible */
        html[data-theme="dark"] .plain-modal .custom-radio .custom-control-input:checked ~ .custom-control-label::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23111827'/%3e%3c/svg%3e");
        }
        html[data-theme="dark"] .plain-modal .custom-checkbox .custom-control-input:checked ~ .custom-control-label::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%23111827' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z'/%3e%3c/svg%3e");
        }

        /* ---- View modal: compact grid (label over value) ---- */
        .plain-modal .view-student-body { padding: 0.8rem 1.1rem; max-height: 72vh; overflow-y: auto; }
        .plain-modal .view-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px 18px;
        }
        .plain-modal .view-item { min-width: 0; }
        .plain-modal .view-item.span-2 { grid-column: span 2; }
        .plain-modal .view-item.span-4 { grid-column: 1 / -1; }
        .plain-modal .view-label {
            display: block;
            margin-bottom: 1px;
            font-size: 0.74rem;
            font-weight: 500;
            line-height: 1.2;
            color: var(--edb-muted);
        }
        .plain-modal .view-val {
            font-size: 0.86rem;
            font-weight: 500;
            line-height: 1.3;
            color: var(--edb-ink);
            overflow-wrap: anywhere;
        }
        .plain-modal .view-val:empty::before { content: "\2014"; font-weight: 400; color: var(--edb-muted); }
        /* Values stand out more than the muted labels: near-black in light mode, near-white in dark mode */
        .plain-modal .view-val { color: #0a0e14; }
        html[data-theme="dark"] .plain-modal .view-val { color: #ffffff; }
        .plain-modal .edit-student-body .form-control { color: #0a0e14 !important; }
        html[data-theme="dark"] .plain-modal .edit-student-body .form-control { color: #ffffff !important; }
        .plain-modal .view-student-body .edit-section-title { margin: 14px 0 8px; }
        .plain-modal .view-student-body .edit-section-title:first-child { margin-top: 0; }
        @media (max-width: 767.98px) {
            .plain-modal .view-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .plain-modal .view-item.span-2 { grid-column: 1 / -1; }
        }
        @media (max-width: 479.98px) {
            .plain-modal .view-grid { grid-template-columns: minmax(0, 1fr); }
        }

        /* ================================================================
           GRADE-LEVEL TABLES (Grade 7-12): responsive + compact
           The enrollee table picks one of three layouts by measuring the
           room it actually has (see the script below), so it also adapts
           when the sidebar is collapsed:
             (none)       full table
             .is-compact  table without the Email column
             .is-stacked  one card per student (phones / small tablets)
           Selectors start with .modern-card so they outrank the partials'
           own #studentsTable rules.
           ================================================================ */

        /* -- page header: wraps instead of squeezing on small screens -- */
        .grade-page-head { gap: .5rem 1rem; }
        .grade-page-actions { display: flex; flex-wrap: wrap; align-items: center; gap: .4rem; }
        @media (max-width: 767.98px) {
            /* Grades 11-12: drop the <br> spacers and let the sort control sit on its own line */
            .grade-page-head ~ br { display: none; }
            .grade-page-head ~ form.d-inline { display: flex !important; align-items: center; margin: 0 0 .75rem !important; }
        }
        @media (max-width: 575.98px) {
            .grade-page-head h4 { font-size: 1.15rem; }
            .grade-page-actions { width: 100%; }
        }

        /* -- table, all layouts: tighter cells; long values are truncated (full text in the tooltip) -- */
        .modern-card #studentsTable tbody td { padding: .35rem .5rem; }
        .modern-card #studentsTable thead th { padding: .45rem 1.25rem .45rem .5rem; }
        .modern-card #studentsTable td[data-label="Full Name"] { max-width: 15rem; overflow: hidden; text-overflow: ellipsis; }
        .modern-card #studentsTable td[data-label="Email"]     { max-width: 12rem; overflow: hidden; text-overflow: ellipsis; }
        .modern-card #studentsTable td[data-label="AI Review"] { white-space: normal; min-width: 7rem; max-width: 9rem; }

        /* -- layout 2: no Email column -- */
        .modern-card.is-compact #studentsTable th[data-col="email"],
        .modern-card.is-compact #studentsTable td[data-label="Email"] { display: none; }

        /* -- layout 3: cards -- */
        .modern-card.is-stacked .enr-scroll { max-height: none; overflow: visible; }
        .modern-card.is-stacked #studentsTable { display: block; width: 100%; white-space: normal; font-size: .85rem; }

        /* header row: only "Select all" survives (bulk actions still work) */
        .modern-card.is-stacked #studentsTable thead { display: block; background: rgba(var(--edb-chart-rgb), 0.06); border-bottom: 1px solid var(--edb-border); }
        .modern-card.is-stacked #studentsTable thead tr { display: flex; }
        .modern-card.is-stacked #studentsTable thead th { display: none; }
        .modern-card.is-stacked #studentsTable thead th:first-child {
            display: flex; align-items: center; gap: .6rem;
            width: auto !important; padding: .55rem .85rem;
            position: static; background: transparent; border: 0;
        }
        .modern-card.is-stacked #studentsTable thead th:first-child::after {
            content: "Select all"; font-size: .78rem; font-weight: 700; color: var(--edb-muted);
        }
        .modern-card.is-stacked #studentsTable input[type="checkbox"] { width: 18px; height: 18px; }

        /* one card per student; cards flow into columns when there is room */
        .modern-card.is-stacked #studentsTable tbody {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(300px, 100%), 1fr));
            gap: 10px;
            padding: 10px;
        }
        .modern-card.is-stacked #studentsTable tbody tr {
            display: flex; flex-wrap: wrap; align-items: center; gap: 6px 10px;
            padding: 10px 12px;
            background: var(--edb-surface);
            border: 1px solid var(--edb-border);
            border-radius: 10px;
        }
        .modern-card.is-stacked #studentsTable tbody td {
            display: block; padding: 0; border: 0; text-align: left;
            white-space: normal; max-width: none; min-width: 0; overflow: visible;
        }
        /* line 1: [checkbox] name ............ [Actions] */
        .modern-card.is-stacked #studentsTable td:first-child { order: 1; flex: 0 0 auto; }
        .modern-card.is-stacked #studentsTable td[data-label="Full Name"] {
            order: 2; flex: 1 1 0; font-size: .92rem; font-weight: 700; color: var(--edb-ink); overflow-wrap: anywhere;
        }
        .modern-card.is-stacked #studentsTable td:last-child { order: 3; flex: 0 0 auto; }
        .modern-card.is-stacked #studentsTable tbody tr::before { content: ""; order: 4; flex: 0 0 100%; height: 0; }
        /* line 2: LRN . course . email */
        .modern-card.is-stacked #studentsTable td[data-label="LRN"]    { order: 5; }
        .modern-card.is-stacked #studentsTable td[data-label="Course"] { order: 6; }
        .modern-card.is-stacked #studentsTable td[data-label="Email"] {
            order: 7; flex: 1 1 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--edb-muted);
        }
        .modern-card.is-stacked #studentsTable tbody tr::after { content: ""; order: 8; flex: 0 0 100%; height: 0; }
        /* line 3: chips */
        .modern-card.is-stacked #studentsTable td[data-label="Documents"]    { order: 9; }
        .modern-card.is-stacked #studentsTable td[data-label="AI Review"]    { order: 10; }
        .modern-card.is-stacked #studentsTable td[data-label="Requirements"] { order: 11; }
        .modern-card.is-stacked #studentsTable td[data-label="Status"]       { order: 12; }
        .modern-card.is-stacked #studentsTable td[data-label="LRN"]::before,
        .modern-card.is-stacked #studentsTable td[data-label="Requirements"]::before,
        .modern-card.is-stacked #studentsTable td[data-label="Status"]::before {
            font-size: .7rem; font-weight: 700; color: var(--edb-muted); margin-right: .3rem;
        }
        .modern-card.is-stacked #studentsTable td[data-label="LRN"]::before          { content: "LRN"; }
        .modern-card.is-stacked #studentsTable td[data-label="Requirements"]::before { content: "Req."; }
        .modern-card.is-stacked #studentsTable td[data-label="Status"]::before       { content: "Status"; }
        .modern-card.is-stacked #studentsTable td.dataTables_empty { order: 1; flex: 1 1 100%; text-align: center; padding: 1rem 0; }
    </style>
    <script>
    /* Grade-level enrollee table: choose full / no-Email / card layout from the room the table really has.
       Nothing here changes the data or DataTables (sorting, search, bulk select all keep working). */
    (function () {
        var LABELS = { 'Mistral AI': 'AI Review' };
        function ready(fn) {
            if (document.readyState !== 'loading') fn();
            else document.addEventListener('DOMContentLoaded', fn);
        }
        ready(function () {
            var t = document.getElementById('studentsTable');
            if (!t) return;
            var box = t.closest('.enr-scroll'), card = t.closest('.modern-card');
            if (!box || !card || !t.tBodies[0]) return;

            /* Tag every cell with its column name (read from the header, so it works for every grade),
               and put the full text of truncated cells in a tooltip. */
            var heads = [].map.call(t.querySelectorAll('thead th'), function (th) {
                var txt = (th.textContent || '').trim(), img = th.querySelector('img');
                if (!txt && img) txt = img.getAttribute('alt') || '';
                return LABELS[txt] || txt;
            });
            [].forEach.call(t.tBodies[0].rows, function (tr) {
                [].forEach.call(tr.cells, function (td, i) {
                    if (!heads[i]) return;
                    td.setAttribute('data-label', heads[i]);
                    if (heads[i] === 'Email' || heads[i] === 'Full Name') td.title = td.textContent.trim();
                });
            });

            /* natural (no-wrap) width of the table in each layout, measured once with every row present,
               so filtering rows later can't flip the layout back and forth */
            var nat = { full: 0, compact: 0 };
            function natural(cls) {
                card.classList.remove('is-compact', 'is-stacked');
                if (cls) card.classList.add(cls);
                var prev = t.style.width;
                t.style.width = 'auto';
                var w = t.offsetWidth;
                t.style.width = prev;
                return w;
            }
            function measure() { nat.full = natural(''); nat.compact = natural('is-compact'); }

            function layout() {
                card.classList.remove('is-compact', 'is-stacked');
                var avail = box.clientWidth;
                if (!avail) return;                       /* hidden: leave the default layout */
                if (nat.full && avail >= nat.full) return;
                if (nat.compact && avail >= nat.compact) { card.classList.add('is-compact'); return; }
                card.classList.add('is-stacked');
            }

            var raf = 0;
            function schedule() { cancelAnimationFrame(raf); raf = requestAnimationFrame(layout); }

            measure(); layout();
            window.addEventListener('load', function () { measure(); layout(); });
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { measure(); layout(); });
            window.addEventListener('resize', schedule);
            if (window.ResizeObserver) new ResizeObserver(schedule).observe(box.parentNode);   /* sidebar collapse etc. */
        });
    })();
    </script>
</head>

<body id="page-top">

    <?php include(VIEWS_PATH . '/partials/admin_loading_overlay.php'); ?>
    <?php include(VIEWS_PATH . '/partials/swal_theme.php'); ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

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


            <?php
                if (!isset($msgData)) {
                    $msgData = (isset($eusebia) && method_exists($eusebia, 'chat_unread_summary'))
                        ? $eusebia->chat_unread_summary(5)
                        : ['total' => 0, 'items' => []];
                }
            ?>
            <li class="nav-item <?= $current_page === 'admn_messages.php' ? 'active' : '' ?>">
                <a class="nav-link" href="admn_messages.php">
                    <span><i class="fas fa-comments"></i> Messages</span>
                    <span class="grade-pending-badge" id="navMsgBadge" style="background: linear-gradient(135deg, #3b82f6, #2563eb);"<?= empty($msgData['total']) ? ' hidden' : '' ?>><?= (int) ($msgData['total'] ?? 0) ?></span>
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

                   <div class="gs-wrap" id="gsWrap">
                        <i class="fas fa-search gs-icon" aria-hidden="true"></i>
                        <input type="search" id="gsInput" class="gs-input" placeholder="Search name, LRN or email…  ( / )"
                               autocomplete="off" spellcheck="false" role="combobox" aria-label="Search students, accounts and archive"
                               aria-controls="gsPanel" aria-expanded="false" aria-autocomplete="list">
                        <div class="gs-panel" id="gsPanel" role="listbox" hidden></div>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <?php
                            $pendingData = (isset($eusebia) && method_exists($eusebia, 'get_pending_enrollees'))
                                ? $eusebia->get_pending_enrollees()
                                : ['total' => 0, 'items' => []];
                            $bellTotal = (int) $pendingData['total'] + (int) $msgData['total'];
                        ?>

                        <!-- Nav Item - Theme Switcher -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="themeSwitchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Theme">
                                <i class="fas fa-circle-half-stroke fa-fw" id="themeSwitchIcon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in theme-switch-menu"
                                aria-labelledby="themeSwitchDropdown">
                                <h6 class="dropdown-header">Theme</h6>
                                <a class="dropdown-item" href="#" data-theme-choice="light">
                                    <i class="fas fa-sun"></i> Light
                                    <i class="fas fa-check ml-auto"></i>
                                </a>
                                <a class="dropdown-item" href="#" data-theme-choice="dark">
                                    <i class="fas fa-moon"></i> Dark
                                    <i class="fas fa-check ml-auto"></i>
                                </a>
                                <a class="dropdown-item" href="#" data-theme-choice="default">
                                    <i class="fas fa-desktop"></i> Default (System)
                                    <i class="fas fa-check ml-auto"></i>
                                </a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - Pending Enrollment Notification -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="pendingApprovalsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter" id="bellBadge" <?= $bellTotal > 0 ? '' : 'style="display:none;"' ?>><?= $bellTotal > 99 ? '99+' : $bellTotal ?></span>
                            </a>
                            <!-- Dropdown - Pending Enrollment -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right animated--grow-in"
                                aria-labelledby="pendingApprovalsDropdown">
                                <h6 class="dropdown-header">
                                    <span>Notifications</span>
                                    <span class="header-count" id="bellHeaderCount"><?= $bellTotal ?> new</span>
                                </h6>
                                <div class="dropdown-item notif-empty" id="bellEmpty"<?= (empty($pendingData['items']) && empty($msgData['items'])) ? '' : ' hidden' ?>>No new notifications</div>
                                <?php if (!empty($pendingData['items'])): ?>
                                    <div class="notif-section-title">Pending Enrollment</div>
                                    <?php foreach ($pendingData['items'] as $item): ?>
                                    <a class="dropdown-item" href="<?= htmlspecialchars($item['link']) ?>">
                                        <span class="notif-dot"></span>
                                        <div class="item-content">
                                            <div class="item-title"><?= htmlspecialchars($item['name']) ?></div>
                                            <div class="item-subtitle">
                                                <?= htmlspecialchars($item['grade']) ?><?= $item['sy'] ? ' · S.Y. ' . htmlspecialchars($item['sy']) : '' ?>
                                            </div>
                                        </div>
                                    </a>
                                    <?php endforeach; ?>
                                    <a class="dropdown-footer" href="admn_dashboard.php">View all</a>
                                <?php endif; ?>

                                <!-- Messages (visitor chats from the enrollment-closed notice) -->
                                <div id="msgNotifSection" style="<?= empty($msgData['items']) ? 'display:none;' : '' ?>">
                                    <div class="notif-section-title">Messages</div>
                                    <div id="msgNotifItems">
                                    <?php foreach ($msgData['items'] as $m): ?>
                                    <a class="dropdown-item" href="<?= htmlspecialchars($m['link']) ?>">
                                        <span class="notif-dot" style="background:#2563eb;"></span>
                                        <div class="item-content">
                                            <div class="item-title"><?= htmlspecialchars($m['name']) ?><?= $m['unread'] > 1 ? ' (' . (int) $m['unread'] . ')' : '' ?></div>
                                            <div class="item-subtitle"><?= htmlspecialchars($m['preview']) ?> · <?= htmlspecialchars($m['ago']) ?></div>
                                        </div>
                                    </a>
                                    <?php endforeach; ?>
                                    </div>
                                    <a class="dropdown-footer" href="admn_messages.php">Open Messages</a>
                                </div>
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

<script>
/* Live message notifications: refreshes the bell badge, the "Messages" block inside the bell
   dropdown and the sidebar "Messages" badge. admn_messages.php also calls this after reading a thread. */
(function () {
    var PENDING_TOTAL = <?= (int) $pendingData['total'] ?>;
    var PENDING_SHOWN = <?= count($pendingData['items']) ?>;

    window.refreshMsgNotif = function () {
        fetch('admn_messages_api.php?action=summary', { credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res || !res.ok) return;
                var total = PENDING_TOTAL + res.total;

                var badge = document.getElementById('bellBadge');
                if (badge) { badge.textContent = total > 99 ? '99+' : total; badge.style.display = total > 0 ? '' : 'none'; }
                var hc = document.getElementById('bellHeaderCount');
                if (hc) hc.textContent = total + ' new';
                var nav = document.getElementById('navMsgBadge');
                if (nav) { nav.textContent = res.total; nav.hidden = !(res.total > 0); }

                var section = document.getElementById('msgNotifSection');
                var box = document.getElementById('msgNotifItems');
                if (section && box) {
                    box.innerHTML = '';
                    res.items.forEach(function (m) {
                        var a = document.createElement('a'); a.className = 'dropdown-item'; a.href = m.link;
                        var dot = document.createElement('span'); dot.className = 'notif-dot'; dot.style.background = '#2563eb';
                        var c = document.createElement('div'); c.className = 'item-content';
                        var t = document.createElement('div'); t.className = 'item-title';
                        t.textContent = m.name + (m.unread > 1 ? ' (' + m.unread + ')' : '');
                        var st = document.createElement('div'); st.className = 'item-subtitle';
                        st.textContent = m.preview + ' \u00b7 ' + m.ago;
                        c.appendChild(t); c.appendChild(st); a.appendChild(dot); a.appendChild(c); box.appendChild(a);
                    });
                    section.style.display = res.items.length ? '' : 'none';
                }
                var empty = document.getElementById('bellEmpty');
                if (empty) empty.hidden = !(PENDING_SHOWN === 0 && res.items.length === 0);
            })
            .catch(function () {});
    };
    setInterval(window.refreshMsgNotif, 15000);
})();
</script>

<script>
/* Global search. GET global_search.php?q=... (admin-only JSON). Results are built with textContent,
   never innerHTML, so names/emails from the database can't inject markup. */
(function () {
    var wrap = document.getElementById('gsWrap');
    if (!wrap) return;
    var input = document.getElementById('gsInput'), panel = document.getElementById('gsPanel');
    var timer = null, ctrl = null, active = -1, lastQ = '';

    function el(tag, cls, text) { var e = document.createElement(tag); if (cls) e.className = cls; if (text != null) e.textContent = text; return e; }
    function escRe(s) { return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }
    function highlight(text, tokens, into) {
        if (!tokens.length) { into.textContent = text; return into; }
        var re = new RegExp('(' + tokens.map(escRe).join('|') + ')', 'ig');
        text.split(re).forEach(function (part, i) {
            if (i % 2 === 1) { var m = document.createElement('mark'); m.textContent = part; into.appendChild(m); }
            else if (part) into.appendChild(document.createTextNode(part));
        });
        return into;
    }
    function items() { return panel.querySelectorAll('.gs-item:not(.gs-item-static)'); }
    function openPanel() { panel.hidden = false; input.setAttribute('aria-expanded', 'true'); }
    function closePanel() { panel.hidden = true; active = -1; input.setAttribute('aria-expanded', 'false'); }
    function say(msg) { panel.textContent = ''; panel.appendChild(el('div', 'gs-status-line', msg)); openPanel(); }
    function setActive(i) {
        var list = items(); if (!list.length) return;
        active = (i + list.length) % list.length;
        list.forEach(function (a, n) { a.classList.toggle('gs-active', n === active); });
        list[active].scrollIntoView({ block: 'nearest' });
    }

    function render(data, q) {
        var tokens = q.split(/[\s,]+/).filter(Boolean);
        panel.textContent = ''; active = -1;
        if (!data.groups || !data.groups.length) { say('No results for \u201c' + q + '\u201d'); return; }
        data.groups.forEach(function (g) {
            var h = el('div', 'gs-group', g.label); h.appendChild(el('span', 'gs-count', '(' + g.total + ')')); panel.appendChild(h);
            g.items.forEach(function (it) {
                var row = el(it.url ? 'a' : 'div', 'gs-item' + (it.url ? '' : ' gs-item-static'));
                if (it.url) { row.href = it.url; row.setAttribute('role', 'option'); }
                row.appendChild(el('span', 'gs-badge', it.badge));
                var main = el('div', 'gs-main');
                main.appendChild(highlight(it.name, tokens, el('div', 'gs-name')));
                if (it.sub) main.appendChild(highlight(it.sub, tokens, el('div', 'gs-sub')));
                row.appendChild(main);
                if (it.status) row.appendChild(el('span', 'gs-state st-' + it.status.toLowerCase(), it.status));
                panel.appendChild(row);
            });
            if (g.total > g.items.length) panel.appendChild(el('div', 'gs-more', '+' + (g.total - g.items.length) + ' more \u2014 type more of the name to narrow it down'));
        });
        openPanel();
    }

    function run(q) {
        if (ctrl) ctrl.abort();
        ctrl = new AbortController(); lastQ = q;
        say('Searching\u2026');
        fetch('global_search.php?q=' + encodeURIComponent(q), { credentials: 'same-origin', signal: ctrl.signal, headers: { 'Accept': 'application/json' } })
            .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
            .then(function (d) { if (d && d.success && q === lastQ) render(d, q); else if (!d || !d.success) throw new Error('bad'); })
            .catch(function (e) { if (e && e.name === 'AbortError') return; say('Search is unavailable right now. Please try again.'); });
    }

    input.addEventListener('input', function () {
        clearTimeout(timer);
        var q = input.value.trim();
        if (q.length < 2) { if (ctrl) ctrl.abort(); q.length ? say('Type at least 2 characters') : closePanel(); return; }
        timer = setTimeout(function () { run(q); }, 250);
    });
    function reopen() { if (panel.hidden && panel.childNodes.length && input.value.trim().length >= 2) openPanel(); }
    input.addEventListener('focus', reopen);
    input.addEventListener('click', reopen);
    if (window.matchMedia && window.matchMedia('(max-width: 768px)').matches) input.placeholder = 'Search\u2026';
    input.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowDown') { e.preventDefault(); if (panel.hidden) { if (panel.childNodes.length) openPanel(); } else setActive(active + 1); }
        else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(active - 1); }
        else if (e.key === 'Enter') { var list = items(); var target = list[active] || list[0]; if (target) { e.preventDefault(); window.location.href = target.href; } }
        else if (e.key === 'Escape') { if (!panel.hidden) { e.preventDefault(); closePanel(); } }   // 1st Esc closes the list and keeps the text; 2nd Esc clears it (native)
    });
    document.addEventListener('mousedown', function (e) { if (!wrap.contains(e.target)) closePanel(); });
    document.addEventListener('keydown', function (e) {           // "/" jumps to the search box
        if (e.key !== '/' || e.ctrlKey || e.metaKey || e.altKey) return;
        var t = e.target, tag = (t.tagName || '').toLowerCase();
        if (tag === 'input' || tag === 'textarea' || tag === 'select' || t.isContentEditable) return;
        e.preventDefault(); input.focus(); input.select();
    });

    /* Arriving from a search result: pre-fill the destination page's own search box
       (grade lists use DataTables filters, Registered Accounts filters its rows). */
    function applyDeepLink() {
        var term = new URLSearchParams(window.location.search).get('search');
        if (!term) return;
        var box = document.querySelector('input[id^="filterSearch"]');
        if (box) {
            box.value = term;
            var btn = document.querySelector('[id^="filterSearchBtn"]'); if (btn) btn.click();
            return;
        }
        var accounts = document.getElementById('studentSearch');
        if (accounts) { accounts.value = term; accounts.dispatchEvent(new Event('keyup')); }
    }
    // jQuery queues its ready-callbacks: asking for one now puts ours after the page's own setup.
    window.addEventListener('load', function () { if (window.jQuery) window.jQuery(applyDeepLink); else applyDeepLink(); });
})();
</script>