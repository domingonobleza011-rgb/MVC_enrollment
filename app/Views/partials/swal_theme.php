<?php
/**
 * Shared SweetAlert2 theme for the admin / staff portals.
 * Adapts to light and dark mode via html[data-theme="dark"] (set by the theme switcher).
 * Included once from dashboard_sidebar_start.php and staff_sidebar_start.php.
 */
?>
<style id="swal-theme">
    /* ---------- Light (default) ---------- */
    .swal2-container { --sw-bg:#ffffff; --sw-title:#0b2b5c; --sw-text:#4b5563; --sw-border:#e6eaf2;
        --sw-confirm-from:#0b2b5c; --sw-confirm-to:#0f3b7a; --sw-cancel-bg:#eef1f6; --sw-cancel-text:#344054;
        --sw-input-bg:#ffffff; --sw-input-border:#cfd6e4; --sw-input-text:#1a2c3e; }
    html[data-theme="dark"] .swal2-container { --sw-bg:#1a1f2b; --sw-title:#eef0f4; --sw-text:#aab2c0; --sw-border:rgba(255,255,255,.10);
        --sw-confirm-from:#2563eb; --sw-confirm-to:#3b82f6; --sw-cancel-bg:#232a38; --sw-cancel-text:#d7dbe2;
        --sw-input-bg:#232a38; --sw-input-border:rgba(255,255,255,.18); --sw-input-text:#eef0f4; }

    .swal2-container.swal2-backdrop-show, .swal2-container.swal2-noanimation { background: rgba(10,16,30,.55) !important; backdrop-filter: blur(2px); }

    .swal2-popup {
        background: var(--sw-bg) !important;
        color: var(--sw-text) !important;
        border: 1px solid var(--sw-border) !important;
        border-radius: 20px !important;
        padding: 1.6rem 1.4rem 1.4rem !important;
        box-shadow: 0 24px 60px rgba(0,0,0,.28) !important;
        font-family: 'Nunito', 'Inter', sans-serif !important;
    }
    .swal2-title { color: var(--sw-title) !important; font-weight: 800 !important; font-size: 1.55rem !important; }
    .swal2-html-container, .swal2-content { color: var(--sw-text) !important; font-size: .98rem !important; line-height: 1.55 !important; }
    .swal2-html-container strong, .swal2-html-container b { color: var(--sw-title) !important; }

    /* Buttons */
    .swal2-actions { gap: .6rem; margin-top: 1.3rem !important; }
    .swal2-styled { border-radius: 12px !important; font-weight: 700 !important; padding: .6rem 1.5rem !important; box-shadow: none !important; transition: transform .12s, filter .12s !important; }
    .swal2-styled:hover { transform: translateY(-1px); filter: brightness(1.06); }
    .swal2-styled:focus { box-shadow: 0 0 0 3px rgba(59,130,246,.35) !important; }
    .swal2-styled.swal2-confirm { background: linear-gradient(135deg, var(--sw-confirm-from), var(--sw-confirm-to)) !important; color: #fff !important; border: 0 !important; }
    .swal2-styled.swal2-deny    { background: linear-gradient(135deg, #dc2626, #ef4444) !important; color: #fff !important; border: 0 !important; }
    .swal2-styled.swal2-cancel  { background: var(--sw-cancel-bg) !important; color: var(--sw-cancel-text) !important; border: 1px solid var(--sw-border) !important; }

    /* Inputs (e.g. rejection reason) */
    .swal2-input, .swal2-textarea, .swal2-select {
        background: var(--sw-input-bg) !important; color: var(--sw-input-text) !important;
        border: 1.5px solid var(--sw-input-border) !important; border-radius: 12px !important; box-shadow: none !important;
    }
    .swal2-input:focus, .swal2-textarea:focus, .swal2-select:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 3px rgba(59,130,246,.25) !important; }
    .swal2-input::placeholder, .swal2-textarea::placeholder { color: var(--sw-text) !important; opacity: .65; }
    .swal2-validation-message { background: transparent !important; color: #ef4444 !important; }
    .swal2-footer { border-top: 1px solid var(--sw-border) !important; color: var(--sw-text) !important; }
    .swal2-timer-progress-bar { background: linear-gradient(90deg, var(--sw-confirm-from), var(--sw-confirm-to)) !important; }
    .swal2-close { color: var(--sw-text) !important; }

    /* Icons: keep the colours, remove the white patches the success icon paints over the popup background */
    .swal2-icon.swal2-success { border-color: rgba(34,197,94,.35) !important; }
    .swal2-icon.swal2-success [class^=swal2-success-line] { background-color: #22c55e !important; }
    .swal2-icon.swal2-success .swal2-success-ring { border-color: rgba(34,197,94,.30) !important; }
    .swal2-icon.swal2-success [class^=swal2-success-circular-line],
    .swal2-icon.swal2-success .swal2-success-fix { background: var(--sw-bg) !important; }
    .swal2-icon.swal2-error { border-color: rgba(239,68,68,.45) !important; color: #ef4444 !important; }
    .swal2-icon.swal2-error [class^=swal2-x-mark-line] { background-color: #ef4444 !important; }
    .swal2-icon.swal2-warning { border-color: rgba(245,158,11,.55) !important; color: #f59e0b !important; }
    .swal2-icon.swal2-info { border-color: rgba(59,130,246,.55) !important; color: #3b82f6 !important; }
    .swal2-icon.swal2-question { border-color: rgba(99,102,241,.55) !important; color: #6366f1 !important; }
</style>
