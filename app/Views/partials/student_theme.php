<?php /* Student portal theme (Default / Light / Dark). Include once inside <head>, after the page's own styles. */ ?>

<script>
/* Student portal theme: Default (navy + gold) / Light / Dark.
   Runs in <head> so the right theme is set before first paint. */
(function () {
    var KEY = 'eusebia_student_theme';
    var VALID = ['default', 'light', 'dark'];
    function read() {
        var v = null;
        try { v = localStorage.getItem(KEY); } catch (e) {}
        return VALID.indexOf(v) === -1 ? 'default' : v;
    }
    function apply(pref) {
        var root = document.documentElement;
        root.setAttribute('data-theme', pref);
        root.setAttribute('data-theme-pref', pref);
        var icon = pref === 'light' ? 'fa-sun' : (pref === 'dark' ? 'fa-moon' : 'fa-palette');
        document.querySelectorAll('[data-theme-icon]').forEach(function (el) {
            el.className = 'fas ' + icon;
            el.setAttribute('data-theme-icon', '');
        });
        document.querySelectorAll('[data-theme-choice]').forEach(function (el) {
            el.classList.toggle('active-theme', el.getAttribute('data-theme-choice') === pref);
        });
    }
    apply(read());
    document.addEventListener('DOMContentLoaded', function () {
        apply(read());
        document.querySelectorAll('[data-theme-choice]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                var pref = el.getAttribute('data-theme-choice');
                try { localStorage.setItem(KEY, pref); } catch (err) {}
                apply(pref);
            });
        });
    });
})();
</script>

<style id="student-theme">
html[data-theme="default"] {
    color-scheme: light;
    --st-bg: linear-gradient(145deg,#f8faff 0%,#f0f4fe 100%); --st-surface: #ffffff; --st-surface-2: #f8fafd;
    --st-ink: #1a2c3e; --st-heading: #0b2b5c; --st-muted: #5e7e9e;
    --st-line: #dbe4f3; --st-input-bg: #ffffff; --st-input-line: #c5d2e6;
    --st-accent: #0f3b7a; --st-accent-soft: #eef3fc; --st-connector: #c5d2e6;
    --st-grad: linear-gradient(135deg,#0b2b5c,#1f5a9e); --st-title-grad: linear-gradient(135deg,#0b2b5c,#2a6f9c); --st-bubble-in: #e6e9f0;
    --st-sm-body: #f4f6fa; --st-footer-bg: #0b1f33; --st-footer-ink: #cddcec;
    --st-shadow: rgba(11,43,92,.10);
}

html[data-theme="light"] {
    color-scheme: light;
    --st-bg: #f4f5f7; --st-surface: #ffffff; --st-surface-2: #f9fafb;
    --st-ink: #000000; --st-heading: #000000; --st-muted: #000000;
    --st-line: #000000; --st-input-bg: #ffffff; --st-input-line: #000000;
    --st-accent: #000000; --st-accent-soft: #f3f4f6; --st-connector: #000000;
    --st-grad: #374151; --st-title-grad: linear-gradient(135deg,#000000,#000000); --st-bubble-in: #e5e7eb;
    --st-sm-body: #f3f4f6; --st-footer-bg: #e5e7eb; --st-footer-ink: #000000;
    --st-shadow: rgba(0,0,0,.07);
}

html[data-theme="dark"] {
    color-scheme: dark;
    --st-bg: #12161f; --st-surface: #1a1f2b; --st-surface-2: #1e2432;
    --st-ink: #ffffff; --st-heading: #ffffff; --st-muted: #ffffff;
    --st-line: #ffffff; --st-input-bg: #232a38; --st-input-line: #ffffff;
    --st-accent: #ffffff; --st-accent-soft: rgba(255,255,255,.14); --st-connector: #ffffff;
    --st-grad: linear-gradient(135deg,#27346b,#3a4fa8); --st-title-grad: linear-gradient(135deg,#ffffff,#ffffff); --st-bubble-in: #2a3142;
    --st-sm-body: #141923; --st-footer-bg: #0b0e14; --st-footer-ink: #ffffff;
    --st-shadow: rgba(0,0,0,.45);
}


/* ---- theme switcher (navbar) ---- */
.fb-theme-menu { width: 190px; border: 1px solid var(--st-line, #e5e7eb); border-radius: 12px; box-shadow: 0 12px 28px rgba(0,0,0,.18); padding: 8px; margin-top: 10px; }
.fb-theme-menu .fb-theme-title { font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--st-muted, #7a8a99); padding: 4px 10px 6px; }
.fb-theme-menu .dropdown-item, .fb-mobile-menu-panel .dropdown-item[data-theme-choice] { display: flex; align-items: center; gap: 10px; border-radius: 8px; padding: 8px 10px; font-size: .9rem; }
.fb-theme-menu .dropdown-item i.fa-check, .fb-mobile-menu-panel .dropdown-item[data-theme-choice] i.fa-check { display: none; margin-left: auto; font-size: .8rem; }
.fb-theme-menu .dropdown-item.active-theme, .fb-mobile-menu-panel .dropdown-item[data-theme-choice].active-theme { font-weight: 700; }
.fb-theme-menu .dropdown-item.active-theme i.fa-check, .fb-mobile-menu-panel .dropdown-item[data-theme-choice].active-theme i.fa-check { display: inline-block; }
.fb-mobile-menu-panel .fb-theme-title { font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 8px 10px 4px; color: var(--st-muted, #7a8a99); }


html[data-theme="default"] body { background: var(--st-bg) !important; color: var(--st-ink) !important; }
html[data-theme="default"] h1,
html[data-theme="default"] h2,
html[data-theme="default"] h3,
html[data-theme="default"] h4,
html[data-theme="default"] h5,
html[data-theme="default"] h6,
html[data-theme="default"] .form-label,
html[data-theme="default"] .step-panel h5,
html[data-theme="default"] .wizard-topbar .wt-title,
html[data-theme="default"] .selector-label,
html[data-theme="default"] .welcome-badge,
html[data-theme="default"] .empty-state h4,
html[data-theme="default"] .info-section h6,
html[data-theme="default"] .form-section h6,
html[data-theme="default"] .review-group h6,
html[data-theme="default"] .card-title,
html[data-theme="default"] .modal-title { color: var(--st-heading); }
html[data-theme="default"] .modal-header[class] .modal-title { color: inherit; }
html[data-theme="default"] :is(.page-header,.card-header-custom,.profile-header,.sm-head) :is(h1,h2,h3,h4,h5,h6) { color: #ffffff; }
html[data-theme="default"] .hero-section { background: transparent; }
html[data-theme="default"] .table { --bs-table-color: var(--st-ink); --bs-table-bg: transparent; --bs-table-border-color: var(--st-line); --bs-table-striped-bg: var(--st-surface-2); --bs-table-hover-bg: var(--st-accent-soft); color: var(--st-ink); border-color: var(--st-line); }
html[data-theme="default"] .bg-light,
html[data-theme="default"] .bg-white { background-color: var(--st-surface-2) !important; color: var(--st-ink); }
html[data-theme="default"] .text-muted,
html[data-theme="default"] .current-date,
html[data-theme="default"] .selector-sub,
html[data-theme="default"] .wizard-topbar .wt-sub,
html[data-theme="default"] .step-panel .step-desc,
html[data-theme="default"] .info-item label,
html[data-theme="default"] .empty-state p,
html[data-theme="default"] .sm-day,
html[data-theme="default"] .sm-time,
html[data-theme="default"] .sm-empty,
html[data-theme="default"] .review-row .rr-label,
html[data-theme="default"] .current-question-note,
html[data-theme="default"] .toggle-password { color: var(--st-muted) !important; }
html[data-theme="default"] .info-item span,
html[data-theme="default"] .review-row .rr-value,
html[data-theme="default"] .fb-account-header-name,
html[data-theme="default"] .fb-notif-title { color: var(--st-ink); }
html[data-theme="default"] .review-row .rr-value.empty { color: var(--st-muted); }

/* surfaces */
html[data-theme="default"] .selector-card,
html[data-theme="default"] .submission-card,
html[data-theme="default"] .empty-state,
html[data-theme="default"] .sm-card,
html[data-theme="default"] .sm-composer,
html[data-theme="default"] .password-card,
html[data-theme="default"] .profile-card,
html[data-theme="default"] .wizard-topbar,
html[data-theme="default"] .form-section,
html[data-theme="default"] .review-group,
html[data-theme="default"] .file-preview-item,
html[data-theme="default"] .welcome-badge,
html[data-theme="default"] .dropdown-menu-custom,
html[data-theme="default"] .modal-content,
html[data-theme="default"] .modal-body,
html[data-theme="default"] .card {
    background-color: var(--st-surface); color: var(--st-ink); border-color: var(--st-line);
}
html[data-theme="default"] .selector-card,
html[data-theme="default"] .submission-card,
html[data-theme="default"] .empty-state,
html[data-theme="default"] .sm-card,
html[data-theme="default"] .password-card,
html[data-theme="default"] .profile-card,
html[data-theme="default"] .wizard-topbar,
html[data-theme="default"] .form-section,
html[data-theme="default"] .review-group { box-shadow: 0 2px 14px var(--st-shadow); }
html[data-theme="default"] .modal-footer,
html[data-theme="default"] .info-section,
html[data-theme="default"] .upload-area,
html[data-theme="default"] .review-row:nth-child(even) { background-color: var(--st-surface-2); border-color: var(--st-line); }
html[data-theme="default"] .sm-body { background: var(--st-sm-body); }
html[data-theme="default"] .sm-row.in .sm-bubble { background: var(--st-bubble-in); color: var(--st-ink); }
html[data-theme="default"] .modal-header { border-bottom-color: var(--st-line); }
html[data-theme="default"] .review-row { border-bottom-color: var(--st-line); }
html[data-theme="default"] .review-row .rr-label { border-right-color: var(--st-line); }
html[data-theme="default"] .review-divider { border-top-color: var(--st-line); }
html[data-theme="default"] .sm-composer { border-top-color: var(--st-line); }
html[data-theme="default"] .dropdown-divider { border-top-color: var(--st-line); }

/* inputs */
html[data-theme="default"] .form-control,
html[data-theme="default"] .form-select,
html[data-theme="default"] .input-group-custom,
html[data-theme="default"] .sm-composer textarea,
html[data-theme="default"] .input-group-text {
    background-color: var(--st-input-bg); border-color: var(--st-input-line); color: var(--st-ink);
}
html[data-theme="default"] .input-group-custom .form-control,
html[data-theme="default"] .input-group-custom input { background: transparent; border-color: transparent; color: var(--st-ink); }
html[data-theme="default"] .form-control:focus,
html[data-theme="default"] .form-select:focus,
html[data-theme="default"] .sm-composer textarea:focus,
html[data-theme="default"] .input-group-custom:focus-within {
    background-color: var(--st-input-bg); border-color: var(--st-accent); color: var(--st-ink);
    box-shadow: 0 0 0 .2rem var(--st-accent-soft);
}
html[data-theme="default"] .form-control::placeholder,
html[data-theme="default"] .sm-composer textarea::placeholder { color: var(--st-muted); opacity: .75; }
html[data-theme="default"] .form-control:disabled,
html[data-theme="default"] .form-control[readonly],
html[data-theme="default"] .form-select:disabled { background-color: var(--st-surface-2); color: var(--st-ink); }
html[data-theme="default"] .input-icon,
html[data-theme="default"] .toggle-password:hover { color: var(--st-accent) !important; }

/* enrollment wizard: the purple accent follows the active theme */
html[data-theme="default"] .wizard-topbar { border-top-color: var(--st-accent); }
html[data-theme="default"] .wizard-topbar i,
html[data-theme="default"] .file-preview-item .file-icon,
html[data-theme="default"] .file-preview-item .preview-file,
html[data-theme="default"] .review-group .rg-edit,
html[data-theme="default"] .btn-wizard-back { color: var(--st-accent); }
html[data-theme="default"] .btn-wizard-back:hover { background: var(--st-accent-soft); }
html[data-theme="default"] .stepper .step-connector { background: var(--st-connector); }
html[data-theme="default"] .stepper .step-connector.done,
html[data-theme="default"] .stepper .step-connector.active { background: var(--st-accent); }
html[data-theme="default"] .form-section h6,
html[data-theme="default"] .review-group h6,
html[data-theme="default"] .info-section h6 { border-left-color: var(--st-accent); }
html[data-theme="default"] .upload-area { border-color: var(--st-accent); }
html[data-theme="default"] .upload-area:hover,
html[data-theme="default"] .upload-area.dragover { background-color: var(--st-accent-soft); }

/* secondary pill buttons on the password / profile pages */
html[data-theme="default"] .btn-security-link,
html[data-theme="default"] .btn-back-link,
html[data-theme="default"] .btn-household { background: var(--st-accent-soft); border-color: var(--st-line); color: var(--st-heading); }

/* footer */
html[data-theme="default"] .footer-custom { background: var(--st-footer-bg); color: var(--st-footer-ink); }


/* dropdown panels */
html[data-theme="default"] .fb-account-menu, html[data-theme="default"] .fb-notif-panel, html[data-theme="default"] .fb-mobile-menu-panel, html[data-theme="default"] .fb-theme-menu { background: var(--st-surface); border: 1px solid var(--st-line); color: var(--st-ink); }
html[data-theme="default"] .fb-account-menu .dropdown-item, html[data-theme="default"] .fb-mobile-menu-panel .dropdown-item, html[data-theme="default"] .fb-theme-menu .dropdown-item { color: var(--st-ink); }
html[data-theme="default"] .fb-account-menu .dropdown-item .icon-wrap, html[data-theme="default"] .fb-mobile-menu-panel .dropdown-item .icon-wrap { color: var(--st-muted); }
html[data-theme="default"] .fb-account-menu .dropdown-item:hover, html[data-theme="default"] .fb-mobile-menu-panel .dropdown-item:hover, html[data-theme="default"] .fb-theme-menu .dropdown-item:hover,
html[data-theme="default"] .fb-account-menu .dropdown-item:focus, html[data-theme="default"] .fb-mobile-menu-panel .dropdown-item:focus, html[data-theme="default"] .fb-theme-menu .dropdown-item:focus { background: var(--st-accent-soft); color: var(--st-heading); }
html[data-theme="default"] .fb-mobile-menu-panel .dropdown-item.active { background: var(--st-accent-soft); color: var(--st-heading); }
html[data-theme="default"] .fb-account-header { border-bottom-color: var(--st-line); }
html[data-theme="default"] .fb-account-header-role, html[data-theme="default"] .fb-notif-empty, html[data-theme="default"] .fb-notif-time { color: var(--st-muted); }
html[data-theme="default"] .fb-notif-header { color: var(--st-heading); border-bottom-color: var(--st-line); }
html[data-theme="default"] .fb-notif-msg { color: var(--st-muted); }
html[data-theme="default"] .fb-notif-item { border-bottom-color: var(--st-line); }
html[data-theme="default"] .fb-notif-item.unread { background: var(--st-accent-soft); }
html[data-theme="default"] .fb-notif-delete-btn:hover { background: rgba(239,68,68,.15); color: #ef4444; }


html[data-theme="light"] body { background: var(--st-bg) !important; color: var(--st-ink) !important; }
html[data-theme="light"] h1,
html[data-theme="light"] h2,
html[data-theme="light"] h3,
html[data-theme="light"] h4,
html[data-theme="light"] h5,
html[data-theme="light"] h6,
html[data-theme="light"] .form-label,
html[data-theme="light"] .step-panel h5,
html[data-theme="light"] .wizard-topbar .wt-title,
html[data-theme="light"] .selector-label,
html[data-theme="light"] .welcome-badge,
html[data-theme="light"] .empty-state h4,
html[data-theme="light"] .info-section h6,
html[data-theme="light"] .form-section h6,
html[data-theme="light"] .review-group h6,
html[data-theme="light"] .card-title,
html[data-theme="light"] .modal-title { color: var(--st-heading); }
html[data-theme="light"] .modal-header[class] .modal-title { color: inherit; }
html[data-theme="light"] :is(.page-header,.card-header-custom,.profile-header,.sm-head) :is(h1,h2,h3,h4,h5,h6) { color: #ffffff; }
html[data-theme="light"] .hero-section { background: transparent; }
html[data-theme="light"] .table { --bs-table-color: var(--st-ink); --bs-table-bg: transparent; --bs-table-border-color: var(--st-line); --bs-table-striped-bg: var(--st-surface-2); --bs-table-hover-bg: var(--st-accent-soft); color: var(--st-ink); border-color: var(--st-line); }
html[data-theme="light"] .bg-light,
html[data-theme="light"] .bg-white { background-color: var(--st-surface-2) !important; color: var(--st-ink); }
html[data-theme="light"] .text-muted,
html[data-theme="light"] .current-date,
html[data-theme="light"] .selector-sub,
html[data-theme="light"] .wizard-topbar .wt-sub,
html[data-theme="light"] .step-panel .step-desc,
html[data-theme="light"] .info-item label,
html[data-theme="light"] .empty-state p,
html[data-theme="light"] .sm-day,
html[data-theme="light"] .sm-time,
html[data-theme="light"] .sm-empty,
html[data-theme="light"] .review-row .rr-label,
html[data-theme="light"] .current-question-note,
html[data-theme="light"] .toggle-password { color: var(--st-muted) !important; }
html[data-theme="light"] .info-item span,
html[data-theme="light"] .review-row .rr-value,
html[data-theme="light"] .fb-account-header-name,
html[data-theme="light"] .fb-notif-title { color: var(--st-ink); }
html[data-theme="light"] .review-row .rr-value.empty { color: var(--st-muted); }

/* surfaces */
html[data-theme="light"] .selector-card,
html[data-theme="light"] .submission-card,
html[data-theme="light"] .empty-state,
html[data-theme="light"] .sm-card,
html[data-theme="light"] .sm-composer,
html[data-theme="light"] .password-card,
html[data-theme="light"] .profile-card,
html[data-theme="light"] .wizard-topbar,
html[data-theme="light"] .form-section,
html[data-theme="light"] .review-group,
html[data-theme="light"] .file-preview-item,
html[data-theme="light"] .welcome-badge,
html[data-theme="light"] .dropdown-menu-custom,
html[data-theme="light"] .modal-content,
html[data-theme="light"] .modal-body,
html[data-theme="light"] .card {
    background-color: var(--st-surface); color: var(--st-ink); border-color: var(--st-line);
}
html[data-theme="light"] .selector-card,
html[data-theme="light"] .submission-card,
html[data-theme="light"] .empty-state,
html[data-theme="light"] .sm-card,
html[data-theme="light"] .password-card,
html[data-theme="light"] .profile-card,
html[data-theme="light"] .wizard-topbar,
html[data-theme="light"] .form-section,
html[data-theme="light"] .review-group { box-shadow: 0 2px 14px var(--st-shadow); }
html[data-theme="light"] .modal-footer,
html[data-theme="light"] .info-section,
html[data-theme="light"] .upload-area,
html[data-theme="light"] .review-row:nth-child(even) { background-color: var(--st-surface-2); border-color: var(--st-line); }
html[data-theme="light"] .sm-body { background: var(--st-sm-body); }
html[data-theme="light"] .sm-row.in .sm-bubble { background: var(--st-bubble-in); color: var(--st-ink); }
html[data-theme="light"] .modal-header { border-bottom-color: var(--st-line); }
html[data-theme="light"] .review-row { border-bottom-color: var(--st-line); }
html[data-theme="light"] .review-row .rr-label { border-right-color: var(--st-line); }
html[data-theme="light"] .review-divider { border-top-color: var(--st-line); }
html[data-theme="light"] .sm-composer { border-top-color: var(--st-line); }
html[data-theme="light"] .dropdown-divider { border-top-color: var(--st-line); }

/* inputs */
html[data-theme="light"] .form-control,
html[data-theme="light"] .form-select,
html[data-theme="light"] .input-group-custom,
html[data-theme="light"] .sm-composer textarea,
html[data-theme="light"] .input-group-text {
    background-color: var(--st-input-bg); border-color: var(--st-input-line); color: var(--st-ink);
}
html[data-theme="light"] .input-group-custom .form-control,
html[data-theme="light"] .input-group-custom input { background: transparent; border-color: transparent; color: var(--st-ink); }
html[data-theme="light"] .form-control:focus,
html[data-theme="light"] .form-select:focus,
html[data-theme="light"] .sm-composer textarea:focus,
html[data-theme="light"] .input-group-custom:focus-within {
    background-color: var(--st-input-bg); border-color: var(--st-accent); color: var(--st-ink);
    box-shadow: 0 0 0 .2rem var(--st-accent-soft);
}
html[data-theme="light"] .form-control::placeholder,
html[data-theme="light"] .sm-composer textarea::placeholder { color: var(--st-muted); opacity: .75; }
html[data-theme="light"] .form-control:disabled,
html[data-theme="light"] .form-control[readonly],
html[data-theme="light"] .form-select:disabled { background-color: var(--st-surface-2); color: var(--st-ink); }
html[data-theme="light"] .input-icon,
html[data-theme="light"] .toggle-password:hover { color: var(--st-accent) !important; }

/* enrollment wizard: the purple accent follows the active theme */
html[data-theme="light"] .wizard-topbar { border-top-color: var(--st-accent); }
html[data-theme="light"] .wizard-topbar i,
html[data-theme="light"] .file-preview-item .file-icon,
html[data-theme="light"] .file-preview-item .preview-file,
html[data-theme="light"] .review-group .rg-edit,
html[data-theme="light"] .btn-wizard-back { color: var(--st-accent); }
html[data-theme="light"] .btn-wizard-back:hover { background: var(--st-accent-soft); }
html[data-theme="light"] .stepper .step-connector { background: var(--st-connector); }
html[data-theme="light"] .stepper .step-connector.done,
html[data-theme="light"] .stepper .step-connector.active { background: var(--st-accent); }
html[data-theme="light"] .form-section h6,
html[data-theme="light"] .review-group h6,
html[data-theme="light"] .info-section h6 { border-left-color: var(--st-accent); }
html[data-theme="light"] .upload-area { border-color: var(--st-accent); }
html[data-theme="light"] .upload-area:hover,
html[data-theme="light"] .upload-area.dragover { background-color: var(--st-accent-soft); }

/* secondary pill buttons on the password / profile pages */
html[data-theme="light"] .btn-security-link,
html[data-theme="light"] .btn-back-link,
html[data-theme="light"] .btn-household { background: var(--st-accent-soft); border-color: var(--st-line); color: var(--st-heading); }

/* footer */
html[data-theme="light"] .footer-custom { background: var(--st-footer-bg); color: var(--st-footer-ink); }


/* dropdown panels */
html[data-theme="light"] .fb-account-menu, html[data-theme="light"] .fb-notif-panel, html[data-theme="light"] .fb-mobile-menu-panel, html[data-theme="light"] .fb-theme-menu { background: var(--st-surface); border: 1px solid var(--st-line); color: var(--st-ink); }
html[data-theme="light"] .fb-account-menu .dropdown-item, html[data-theme="light"] .fb-mobile-menu-panel .dropdown-item, html[data-theme="light"] .fb-theme-menu .dropdown-item { color: var(--st-ink); }
html[data-theme="light"] .fb-account-menu .dropdown-item .icon-wrap, html[data-theme="light"] .fb-mobile-menu-panel .dropdown-item .icon-wrap { color: var(--st-muted); }
html[data-theme="light"] .fb-account-menu .dropdown-item:hover, html[data-theme="light"] .fb-mobile-menu-panel .dropdown-item:hover, html[data-theme="light"] .fb-theme-menu .dropdown-item:hover,
html[data-theme="light"] .fb-account-menu .dropdown-item:focus, html[data-theme="light"] .fb-mobile-menu-panel .dropdown-item:focus, html[data-theme="light"] .fb-theme-menu .dropdown-item:focus { background: var(--st-accent-soft); color: var(--st-heading); }
html[data-theme="light"] .fb-mobile-menu-panel .dropdown-item.active { background: var(--st-accent-soft); color: var(--st-heading); }
html[data-theme="light"] .fb-account-header { border-bottom-color: var(--st-line); }
html[data-theme="light"] .fb-account-header-role, html[data-theme="light"] .fb-notif-empty, html[data-theme="light"] .fb-notif-time { color: var(--st-muted); }
html[data-theme="light"] .fb-notif-header { color: var(--st-heading); border-bottom-color: var(--st-line); }
html[data-theme="light"] .fb-notif-msg { color: var(--st-muted); }
html[data-theme="light"] .fb-notif-item { border-bottom-color: var(--st-line); }
html[data-theme="light"] .fb-notif-item.unread { background: var(--st-accent-soft); }
html[data-theme="light"] .fb-notif-delete-btn:hover { background: rgba(239,68,68,.15); color: #ef4444; }


html[data-theme="dark"] body { background: var(--st-bg) !important; color: var(--st-ink) !important; }
html[data-theme="dark"] h1,
html[data-theme="dark"] h2,
html[data-theme="dark"] h3,
html[data-theme="dark"] h4,
html[data-theme="dark"] h5,
html[data-theme="dark"] h6,
html[data-theme="dark"] .form-label,
html[data-theme="dark"] .step-panel h5,
html[data-theme="dark"] .wizard-topbar .wt-title,
html[data-theme="dark"] .selector-label,
html[data-theme="dark"] .welcome-badge,
html[data-theme="dark"] .empty-state h4,
html[data-theme="dark"] .info-section h6,
html[data-theme="dark"] .form-section h6,
html[data-theme="dark"] .review-group h6,
html[data-theme="dark"] .card-title,
html[data-theme="dark"] .modal-title { color: var(--st-heading); }
html[data-theme="dark"] .modal-header[class] .modal-title { color: inherit; }
html[data-theme="dark"] :is(.page-header,.card-header-custom,.profile-header,.sm-head) :is(h1,h2,h3,h4,h5,h6) { color: #ffffff; }
html[data-theme="dark"] .hero-section { background: transparent; }
html[data-theme="dark"] .table { --bs-table-color: var(--st-ink); --bs-table-bg: transparent; --bs-table-border-color: var(--st-line); --bs-table-striped-bg: var(--st-surface-2); --bs-table-hover-bg: var(--st-accent-soft); color: var(--st-ink); border-color: var(--st-line); }
html[data-theme="dark"] .bg-light,
html[data-theme="dark"] .bg-white { background-color: var(--st-surface-2) !important; color: var(--st-ink); }
html[data-theme="dark"] .text-muted,
html[data-theme="dark"] .current-date,
html[data-theme="dark"] .selector-sub,
html[data-theme="dark"] .wizard-topbar .wt-sub,
html[data-theme="dark"] .step-panel .step-desc,
html[data-theme="dark"] .info-item label,
html[data-theme="dark"] .empty-state p,
html[data-theme="dark"] .sm-day,
html[data-theme="dark"] .sm-time,
html[data-theme="dark"] .sm-empty,
html[data-theme="dark"] .review-row .rr-label,
html[data-theme="dark"] .current-question-note,
html[data-theme="dark"] .toggle-password { color: var(--st-muted) !important; }
html[data-theme="dark"] .info-item span,
html[data-theme="dark"] .review-row .rr-value,
html[data-theme="dark"] .fb-account-header-name,
html[data-theme="dark"] .fb-notif-title { color: var(--st-ink); }
html[data-theme="dark"] .review-row .rr-value.empty { color: var(--st-muted); }

/* surfaces */
html[data-theme="dark"] .selector-card,
html[data-theme="dark"] .submission-card,
html[data-theme="dark"] .empty-state,
html[data-theme="dark"] .sm-card,
html[data-theme="dark"] .sm-composer,
html[data-theme="dark"] .password-card,
html[data-theme="dark"] .profile-card,
html[data-theme="dark"] .wizard-topbar,
html[data-theme="dark"] .form-section,
html[data-theme="dark"] .review-group,
html[data-theme="dark"] .file-preview-item,
html[data-theme="dark"] .welcome-badge,
html[data-theme="dark"] .dropdown-menu-custom,
html[data-theme="dark"] .modal-content,
html[data-theme="dark"] .modal-body,
html[data-theme="dark"] .card {
    background-color: var(--st-surface); color: var(--st-ink); border-color: var(--st-line);
}
html[data-theme="dark"] .selector-card,
html[data-theme="dark"] .submission-card,
html[data-theme="dark"] .empty-state,
html[data-theme="dark"] .sm-card,
html[data-theme="dark"] .password-card,
html[data-theme="dark"] .profile-card,
html[data-theme="dark"] .wizard-topbar,
html[data-theme="dark"] .form-section,
html[data-theme="dark"] .review-group { box-shadow: 0 2px 14px var(--st-shadow); }
html[data-theme="dark"] .modal-footer,
html[data-theme="dark"] .info-section,
html[data-theme="dark"] .upload-area,
html[data-theme="dark"] .review-row:nth-child(even) { background-color: var(--st-surface-2); border-color: var(--st-line); }
html[data-theme="dark"] .sm-body { background: var(--st-sm-body); }
html[data-theme="dark"] .sm-row.in .sm-bubble { background: var(--st-bubble-in); color: var(--st-ink); }
html[data-theme="dark"] .modal-header { border-bottom-color: var(--st-line); }
html[data-theme="dark"] .review-row { border-bottom-color: var(--st-line); }
html[data-theme="dark"] .review-row .rr-label { border-right-color: var(--st-line); }
html[data-theme="dark"] .review-divider { border-top-color: var(--st-line); }
html[data-theme="dark"] .sm-composer { border-top-color: var(--st-line); }
html[data-theme="dark"] .dropdown-divider { border-top-color: var(--st-line); }

/* inputs */
html[data-theme="dark"] .form-control,
html[data-theme="dark"] .form-select,
html[data-theme="dark"] .input-group-custom,
html[data-theme="dark"] .sm-composer textarea,
html[data-theme="dark"] .input-group-text {
    background-color: var(--st-input-bg); border-color: var(--st-input-line); color: var(--st-ink);
}
html[data-theme="dark"] .input-group-custom .form-control,
html[data-theme="dark"] .input-group-custom input { background: transparent; border-color: transparent; color: var(--st-ink); }
html[data-theme="dark"] .form-control:focus,
html[data-theme="dark"] .form-select:focus,
html[data-theme="dark"] .sm-composer textarea:focus,
html[data-theme="dark"] .input-group-custom:focus-within {
    background-color: var(--st-input-bg); border-color: var(--st-accent); color: var(--st-ink);
    box-shadow: 0 0 0 .2rem var(--st-accent-soft);
}
html[data-theme="dark"] .form-control::placeholder,
html[data-theme="dark"] .sm-composer textarea::placeholder { color: var(--st-muted); opacity: .75; }
html[data-theme="dark"] .form-control:disabled,
html[data-theme="dark"] .form-control[readonly],
html[data-theme="dark"] .form-select:disabled { background-color: var(--st-surface-2); color: var(--st-ink); }
html[data-theme="dark"] .input-icon,
html[data-theme="dark"] .toggle-password:hover { color: var(--st-accent) !important; }

/* enrollment wizard: the purple accent follows the active theme */
html[data-theme="dark"] .wizard-topbar { border-top-color: var(--st-accent); }
html[data-theme="dark"] .wizard-topbar i,
html[data-theme="dark"] .file-preview-item .file-icon,
html[data-theme="dark"] .file-preview-item .preview-file,
html[data-theme="dark"] .review-group .rg-edit,
html[data-theme="dark"] .btn-wizard-back { color: var(--st-accent); }
html[data-theme="dark"] .btn-wizard-back:hover { background: var(--st-accent-soft); }
html[data-theme="dark"] .stepper .step-connector { background: var(--st-connector); }
html[data-theme="dark"] .stepper .step-connector.done,
html[data-theme="dark"] .stepper .step-connector.active { background: var(--st-accent); }
html[data-theme="dark"] .form-section h6,
html[data-theme="dark"] .review-group h6,
html[data-theme="dark"] .info-section h6 { border-left-color: var(--st-accent); }
html[data-theme="dark"] .upload-area { border-color: var(--st-accent); }
html[data-theme="dark"] .upload-area:hover,
html[data-theme="dark"] .upload-area.dragover { background-color: var(--st-accent-soft); }

/* secondary pill buttons on the password / profile pages */
html[data-theme="dark"] .btn-security-link,
html[data-theme="dark"] .btn-back-link,
html[data-theme="dark"] .btn-household { background: var(--st-accent-soft); border-color: var(--st-line); color: var(--st-heading); }

/* footer */
html[data-theme="dark"] .footer-custom { background: var(--st-footer-bg); color: var(--st-footer-ink); }


/* dropdown panels */
html[data-theme="dark"] .fb-account-menu, html[data-theme="dark"] .fb-notif-panel, html[data-theme="dark"] .fb-mobile-menu-panel, html[data-theme="dark"] .fb-theme-menu { background: var(--st-surface); border: 1px solid var(--st-line); color: var(--st-ink); }
html[data-theme="dark"] .fb-account-menu .dropdown-item, html[data-theme="dark"] .fb-mobile-menu-panel .dropdown-item, html[data-theme="dark"] .fb-theme-menu .dropdown-item { color: var(--st-ink); }
html[data-theme="dark"] .fb-account-menu .dropdown-item .icon-wrap, html[data-theme="dark"] .fb-mobile-menu-panel .dropdown-item .icon-wrap { color: var(--st-muted); }
html[data-theme="dark"] .fb-account-menu .dropdown-item:hover, html[data-theme="dark"] .fb-mobile-menu-panel .dropdown-item:hover, html[data-theme="dark"] .fb-theme-menu .dropdown-item:hover,
html[data-theme="dark"] .fb-account-menu .dropdown-item:focus, html[data-theme="dark"] .fb-mobile-menu-panel .dropdown-item:focus, html[data-theme="dark"] .fb-theme-menu .dropdown-item:focus { background: var(--st-accent-soft); color: var(--st-heading); }
html[data-theme="dark"] .fb-mobile-menu-panel .dropdown-item.active { background: var(--st-accent-soft); color: var(--st-heading); }
html[data-theme="dark"] .fb-account-header { border-bottom-color: var(--st-line); }
html[data-theme="dark"] .fb-account-header-role, html[data-theme="dark"] .fb-notif-empty, html[data-theme="dark"] .fb-notif-time { color: var(--st-muted); }
html[data-theme="dark"] .fb-notif-header { color: var(--st-heading); border-bottom-color: var(--st-line); }
html[data-theme="dark"] .fb-notif-msg { color: var(--st-muted); }
html[data-theme="dark"] .fb-notif-item { border-bottom-color: var(--st-line); }
html[data-theme="dark"] .fb-notif-item.unread { background: var(--st-accent-soft); }
html[data-theme="dark"] .fb-notif-delete-btn:hover { background: rgba(239,68,68,.15); color: #ef4444; }


/* brand headers / primary buttons */
html[data-theme="light"] .page-header,
html[data-theme="light"] .card-header-custom,
html[data-theme="light"] .profile-header,
html[data-theme="light"] .sm-head,
html[data-theme="light"] .btn-enroll,
html[data-theme="light"] .btn-modal-submit,
html[data-theme="light"] .btn-change,
html[data-theme="light"] .btn-update,
html[data-theme="light"] .btn-go-enroll,
html[data-theme="light"] .btn-wizard-next,
html[data-theme="light"] .btn-wizard-submit,
html[data-theme="light"] .top-link,
html[data-theme="light"] .grade-badge-card,
html[data-theme="light"] .sm-send,
html[data-theme="light"] .sm-row.out .sm-bubble { background: var(--st-grad); color: #ffffff; }
html[data-theme="light"] .btn-enroll:hover, html[data-theme="light"] .btn-modal-submit:hover, html[data-theme="light"] .btn-change:hover, html[data-theme="light"] .btn-update:hover, html[data-theme="light"] .btn-go-enroll:hover,
html[data-theme="light"] .btn-wizard-next:hover, html[data-theme="light"] .btn-wizard-submit:hover, html[data-theme="light"] .top-link:hover, html[data-theme="light"] .sm-send:hover { filter: brightness(1.12); color: #ffffff; }
html[data-theme="light"] .hero-title { background-image: var(--st-title-grad); }


html[data-theme="light"] .fb-navbar { background: #ffffff; box-shadow: 0 1px 0 #000000, 0 4px 14px rgba(0,0,0,.05); }
html[data-theme="light"] .fb-navbar-brand { color: #000000; }
html[data-theme="light"] .fb-navbar-brand:hover { color: #000000; }
html[data-theme="light"] .fb-nav-link { color: #000000; }
html[data-theme="light"] .fb-nav-link:hover { color: #000000; background: #f3f4f6; }
html[data-theme="light"] .fb-nav-link.active { color: #000000; }
html[data-theme="light"] .fb-nav-link.active::after { background: #000000; }
html[data-theme="light"] .fb-icon-btn, html[data-theme="light"] .fb-account-btn, html[data-theme="light"] .fb-menu-toggle { background: #f3f4f6; color: #000000; }
html[data-theme="light"] .fb-icon-btn:hover, html[data-theme="light"] .fb-account-btn:hover, html[data-theme="light"] .fb-menu-toggle:hover { background: #e5e7eb; color: #000000; }
html[data-theme="light"] .fb-icon-btn[aria-expanded="true"], html[data-theme="light"] .fb-account-btn[aria-expanded="true"], html[data-theme="light"] .fb-menu-toggle[aria-expanded="true"] { background: #e5e7eb; }
html[data-theme="light"] .fb-navbar .fb-avatar { background: #374151; border-color: #374151; color: #ffffff; }
html[data-theme="light"] .fb-theme-menu .dropdown-item.active-theme, html[data-theme="light"] .fb-mobile-menu-panel .dropdown-item[data-theme-choice].active-theme { background: #f3f4f6; color: #000000; }


/* brand headers / primary buttons */
html[data-theme="dark"] .page-header,
html[data-theme="dark"] .card-header-custom,
html[data-theme="dark"] .profile-header,
html[data-theme="dark"] .sm-head,
html[data-theme="dark"] .btn-enroll,
html[data-theme="dark"] .btn-modal-submit,
html[data-theme="dark"] .btn-change,
html[data-theme="dark"] .btn-update,
html[data-theme="dark"] .btn-go-enroll,
html[data-theme="dark"] .btn-wizard-next,
html[data-theme="dark"] .btn-wizard-submit,
html[data-theme="dark"] .top-link,
html[data-theme="dark"] .grade-badge-card,
html[data-theme="dark"] .sm-send,
html[data-theme="dark"] .sm-row.out .sm-bubble { background: var(--st-grad); color: #ffffff; }
html[data-theme="dark"] .btn-enroll:hover, html[data-theme="dark"] .btn-modal-submit:hover, html[data-theme="dark"] .btn-change:hover, html[data-theme="dark"] .btn-update:hover, html[data-theme="dark"] .btn-go-enroll:hover,
html[data-theme="dark"] .btn-wizard-next:hover, html[data-theme="dark"] .btn-wizard-submit:hover, html[data-theme="dark"] .top-link:hover, html[data-theme="dark"] .sm-send:hover { filter: brightness(1.12); color: #ffffff; }
html[data-theme="dark"] .hero-title { background-image: var(--st-title-grad); }


html[data-theme="dark"] .fb-navbar { background: #1a1f2b; box-shadow: 0 1px 0 #ffffff, 0 4px 14px rgba(0,0,0,.4); }
html[data-theme="dark"] .fb-nav-link { color: #ffffff; }
html[data-theme="dark"] .fb-nav-link.active::after { background: #ffffff; }
html[data-theme="dark"] .fb-navbar .fb-avatar { background: #3a4fa8; border-color: #3a4fa8; }
html[data-theme="dark"] .fb-theme-menu .dropdown-item.active-theme, html[data-theme="dark"] .fb-mobile-menu-panel .dropdown-item[data-theme-choice].active-theme { background: rgba(255,255,255,.18); color: #ffffff; }


/* ---- Default: navy + gold, same palette as the landing page ---- */
html[data-theme="default"] .fb-navbar { border-bottom: 2px solid rgba(255,215,0,.55); }
html[data-theme="default"] .fb-nav-link.active::after { background: #ffd700; }
html[data-theme="default"] .page-header { border-bottom: 3px solid #ffd700; }
html[data-theme="default"] .fb-notif-header { color: var(--st-heading); }
html[data-theme="default"] .fb-theme-menu .dropdown-item.active-theme { background: #fff7cc; color: #0b2b5c; }


html[data-theme="light"] .btn[style*="background:#0b2b5c"], html[data-theme="light"] .card-header[style*="background:#0b2b5c"] { background: #374151 !important; }
html[data-theme="light"] thead[style*="background:#f8f9fc"] { background: #f3f4f6 !important; }
html[data-theme="light"] .btn-security-link:hover, html[data-theme="light"] .btn-back-link:hover, html[data-theme="light"] .btn-household:hover { background: #e5e7eb; color: #000000; }
html[data-theme="light"] .welcome-badge { border: 1px solid var(--st-line); }


html[data-theme="dark"] [style*="background:#f0fdf4"] { background: rgba(16,185,129,.12) !important; border-color: rgba(16,185,129,.35) !important; }
html[data-theme="dark"] [style*="color:#065f46"] { color: #6ee7b7 !important; }
html[data-theme="dark"] [style*="background:#fffbeb"] { background: rgba(245,158,11,.12) !important; border-color: rgba(245,158,11,.35) !important; }
html[data-theme="dark"] [style*="color:#92400e"], html[data-theme="dark"] [style*="color:#b45309"] { color: #fcd34d !important; }
html[data-theme="dark"] thead[style*="background:#f8f9fc"] { background: #1e2432 !important; }
html[data-theme="dark"] .btn-light { background: #2a3142; border-color: #2a3142; color: #d7dbe2; }
/* ---- Dark: remaining pieces that hard-code light colors ---- */
html[data-theme="dark"] .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
html[data-theme="dark"] .modal-header .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
html[data-theme="dark"] .btn-secondary { background: #2a3142; border-color: #2a3142; color: #d7dbe2; }
html[data-theme="dark"] .form-select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239aa3b5' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"); }
html[data-theme="dark"] select option { background: #1a1f2b; color: #d7dbe2; }
html[data-theme="dark"] .status-badge.pending  { background: rgba(245,158,11,.18); color: #fcd34d; }
html[data-theme="dark"] .status-badge.approved { background: rgba(16,185,129,.18); color: #6ee7b7; }
html[data-theme="dark"] .status-badge.rejected { background: rgba(239,68,68,.18);  color: #fca5a5; }
html[data-theme="dark"] .reject-reason-box { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.35); color: #fca5a5; }
html[data-theme="dark"] .timeline-step::after { background: rgba(255,255,255,.14); }
html[data-theme="dark"] .step-dot { background: #2a3142; border-color: #2a3142; color: #9aa3b5; }
html[data-theme="dark"] .step-dot.done { background: #10b981; border-color: #10b981; color: #fff; }
html[data-theme="dark"] .step-dot.active { background: #f59e0b; border-color: #f59e0b; color: #fff; }
html[data-theme="dark"] .step-dot.failed { background: #ef4444; border-color: #ef4444; color: #fff; }
html[data-theme="dark"] .step-label.done { color: #6ee7b7 !important; }
html[data-theme="dark"] .step-label.active { color: #fcd34d !important; }
html[data-theme="dark"] .step-label.failed { color: #fca5a5 !important; }
html[data-theme="dark"] .empty-icon { color: #3a4256; }
html[data-theme="dark"] .upload-area i { color: #a5b4fc; }
html[data-theme="dark"] .alert { background-color: var(--st-surface-2); border-color: var(--st-line); color: var(--st-ink); }
/* SweetAlert popups */
html[data-theme="dark"] .swal2-popup { background: #1a1f2b; color: #d7dbe2; }
html[data-theme="dark"] .swal2-title, html[data-theme="dark"] .swal2-html-container { color: #eef0f4; }
html[data-theme="dark"] .swal2-input, html[data-theme="dark"] .swal2-textarea, html[data-theme="dark"] .swal2-select { background: #232a38; color: #d7dbe2; border-color: rgba(255,255,255,.16); }
html[data-theme="dark"] ::-webkit-scrollbar-track { background: #12161f; }
html[data-theme="dark"] ::-webkit-scrollbar-thumb { background: #3a4256; }

/* =====================================================================
   LIGHT: every text and line is black.
   (Default theme is not touched by anything below.)
   ===================================================================== */
html[data-theme="light"] body,
html[data-theme="light"] .form-check-label,
html[data-theme="light"] .form-text,
html[data-theme="light"] .text-secondary,
html[data-theme="light"] .text-body-secondary,
html[data-theme="light"] .alert,
html[data-theme="light"] .input-field,
html[data-theme="light"] .step-label,
html[data-theme="light"] .step-label.done,
html[data-theme="light"] .step-label.active,
html[data-theme="light"] .step-label.failed,
html[data-theme="light"] .status-badge,
html[data-theme="light"] .status-badge.pending,
html[data-theme="light"] .status-badge.approved,
html[data-theme="light"] .status-badge.rejected,
html[data-theme="light"] .reject-reason-box,
html[data-theme="light"] .empty-icon,
html[data-theme="light"] .fb-account-header-role,
html[data-theme="light"] [style*="color:#94a3b8"],
html[data-theme="light"] [style*="color:#065f46"],
html[data-theme="light"] [style*="color:#92400e"],
html[data-theme="light"] [style*="color:#b45309"] { color: #000000 !important; }
html[data-theme="light"] .hero-title span { background: none !important; color: #000000 !important; -webkit-text-fill-color: #000000 !important; }

/* light: icons */
html[data-theme="light"] .empty-icon i,
html[data-theme="light"] .sm-empty i,
html[data-theme="light"] .upload-area i,
html[data-theme="light"] .file-preview-item .file-icon,
html[data-theme="light"] .file-preview-item .preview-file,
html[data-theme="light"] .fb-account-menu .dropdown-item .icon-wrap i,
html[data-theme="light"] .fb-mobile-menu-panel .dropdown-item .icon-wrap i,
html[data-theme="light"] .fb-notif-delete-btn,
html[data-theme="light"] .fb-notif-delete-btn i,
html[data-theme="light"] .current-date i,
html[data-theme="light"] .input-icon,
html[data-theme="light"] .toggle-password,
html[data-theme="light"] i[style*="color:#2a6f9c"],
html[data-theme="light"] i[style*="color:#b6c1cd"],
html[data-theme="light"] .form-label i,
html[data-theme="light"] .form-section h6 i,
html[data-theme="light"] .info-section h6 i,
html[data-theme="light"] .review-group h6 i { color: #000000 !important; }
html[data-theme="light"] .fb-notif-delete-btn:hover,
html[data-theme="light"] .fb-notif-delete-btn:hover i { color: #ef4444 !important; }
html[data-theme="light"] .form-select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23000000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"); }

/* light: lines */
html[data-theme="light"] .form-control,
html[data-theme="light"] .form-select,
html[data-theme="light"] .input-group-custom,
html[data-theme="light"] .input-group-text,
html[data-theme="light"] .sm-composer textarea { border-color: #000000 !important; }
html[data-theme="light"] .input-group-custom .form-control,
html[data-theme="light"] .input-group-custom input { border-color: transparent !important; }
html[data-theme="light"] hr,
html[data-theme="light"] .dropdown-divider { border-color: #000000; opacity: 1; }
html[data-theme="light"] .reject-reason-box { border-color: #000000; }
html[data-theme="light"] [style*="border:1px solid #bbf7d0"],
html[data-theme="light"] [style*="border:1px solid #fde68a"] { border-color: #000000 !important; }
html[data-theme="light"] .timeline-step::after { background: #000000; }
html[data-theme="light"] .step-dot { color: #000000; border-color: #000000; }
html[data-theme="light"] .step-dot.done,
html[data-theme="light"] .step-dot.active,
html[data-theme="light"] .step-dot.failed { color: #ffffff; }
html[data-theme="light"] .footer-custom { border-top: 1px solid #000000; }
html[data-theme="light"] .fb-notif-panel,
html[data-theme="light"] .fb-account-menu,
html[data-theme="light"] .fb-mobile-menu-panel,
html[data-theme="light"] .fb-theme-menu { border-color: #000000; }

/* =====================================================================
   DARK: every text and line is white, every icon is visible.
   ===================================================================== */
html[data-theme="dark"] body,
html[data-theme="dark"] .form-check-label,
html[data-theme="dark"] .form-text,
html[data-theme="dark"] .text-secondary,
html[data-theme="dark"] .text-body-secondary,
html[data-theme="dark"] .alert,
html[data-theme="dark"] .input-field,
html[data-theme="dark"] .step-label,
html[data-theme="dark"] .step-label.done,
html[data-theme="dark"] .step-label.active,
html[data-theme="dark"] .step-label.failed,
html[data-theme="dark"] .status-badge,
html[data-theme="dark"] .status-badge.pending,
html[data-theme="dark"] .status-badge.approved,
html[data-theme="dark"] .status-badge.rejected,
html[data-theme="dark"] .reject-reason-box,
html[data-theme="dark"] .empty-icon,
html[data-theme="dark"] .sm-empty,
html[data-theme="dark"] .fb-account-header-role,
html[data-theme="dark"] .footer-custom,
html[data-theme="dark"] [style*="color:#94a3b8"],
html[data-theme="dark"] [style*="color:#065f46"],
html[data-theme="dark"] [style*="color:#92400e"],
html[data-theme="dark"] [style*="color:#b45309"],
html[data-theme="dark"] .swal2-title,
html[data-theme="dark"] .swal2-html-container,
html[data-theme="dark"] .swal2-popup { color: #ffffff !important; }
html[data-theme="dark"] .hero-title span { background: none !important; color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; }

/* dark: icons (Font Awesome + Bootstrap Icons) */
html[data-theme="dark"] .fas, html[data-theme="dark"] .far, html[data-theme="dark"] .fab,
html[data-theme="dark"] .fa, html[data-theme="dark"] .fa-solid, html[data-theme="dark"] .fa-regular,
html[data-theme="dark"] .fa-brands, html[data-theme="dark"] .bi,
html[data-theme="dark"] .empty-icon i, html[data-theme="dark"] .sm-empty i,
html[data-theme="dark"] .upload-area i, html[data-theme="dark"] .input-icon,
html[data-theme="dark"] .toggle-password, html[data-theme="dark"] .fb-notif-delete-btn,
html[data-theme="dark"] .fb-account-menu .dropdown-item .icon-wrap,
html[data-theme="dark"] .fb-mobile-menu-panel .dropdown-item .icon-wrap { color: #ffffff !important; }
/* keep the meaningful red / green / orange icons recognisable */
html[data-theme="dark"] .remove-file,
html[data-theme="dark"] i[style*="color:#dc3545"], html[data-theme="dark"] [style*="color:#dc3545"] > i,
html[data-theme="dark"] i[style*="color:#ef4444"] { color: #ff6b7a !important; }
html[data-theme="dark"] i[style*="color:#28a745"], html[data-theme="dark"] [style*="color:#28a745"] > i { color: #4ade80 !important; }
html[data-theme="dark"] i[style*="color:#f0ad4e"] { color: #fbbf24 !important; }
html[data-theme="dark"] .fb-notif-delete-btn:hover,
html[data-theme="dark"] .fb-notif-delete-btn:hover i { color: #ef4444 !important; }
html[data-theme="dark"] .form-select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"); }

/* dark: lines */
html[data-theme="dark"] .form-control,
html[data-theme="dark"] .form-select,
html[data-theme="dark"] .input-group-custom,
html[data-theme="dark"] .input-group-text,
html[data-theme="dark"] .sm-composer textarea,
html[data-theme="dark"] .swal2-input,
html[data-theme="dark"] .swal2-textarea,
html[data-theme="dark"] .swal2-select { border-color: #ffffff !important; }
html[data-theme="dark"] .input-group-custom .form-control,
html[data-theme="dark"] .input-group-custom input { border-color: transparent !important; }
html[data-theme="dark"] hr,
html[data-theme="dark"] .dropdown-divider { border-color: #ffffff; opacity: 1; }
html[data-theme="dark"] .reject-reason-box { border-color: #ffffff; }
html[data-theme="dark"] .timeline-step::after { background: #ffffff; }
html[data-theme="dark"] .step-dot { color: #ffffff; border-color: #ffffff; }
html[data-theme="dark"] .footer-custom { border-top: 1px solid #ffffff; }
html[data-theme="dark"] .fb-notif-panel,
html[data-theme="dark"] .fb-account-menu,
html[data-theme="dark"] .fb-mobile-menu-panel,
html[data-theme="dark"] .fb-theme-menu { border-color: #ffffff; }
html[data-theme="dark"] .table > :not(caption) > * > * { border-bottom-color: #ffffff; }


/* light: submission card header (My Submissions).
   Text is forced black in light mode, so the header must be light, not dark,
   or "Senior High - 12th" and the other header text disappear. */
html[data-theme="light"] .submission-card .card-header-custom { background: #f3f4f6; color: #000000; border-bottom: 1px solid #000000; }
html[data-theme="light"] .submission-card .grade-badge-card { background: #111827; color: #ffffff; }
html[data-theme="light"] .submission-card .card-header-custom [style*="color:#94a3b8"] { color: #000000 !important; }
</style>
