<!--
    Admin action loading overlay.
    Shows a full-screen blocking spinner while approve / reject / edit / delete
    actions are processed (regular POST form reloads, not just AJAX).

    Usage from any admin page script:
        showAdminLoading('Approving account...', 'check');
        showAdminLoading('Deleting record...', 'trash');
        hideAdminLoading(); // only needed for AJAX flows that don't reload the page

    Any <form method="post"> submit (button click OR form.submit() called from
    JS, e.g. after a SweetAlert confirm) is caught automatically and shows a
    generic "Processing..." overlay even if no explicit call was made.
-->
<div id="adminLoadingOverlay" class="admin-loading-overlay" aria-hidden="true">
    <div class="admin-loading-card">
        <div class="admin-loading-spinner">
            <i id="adminLoadingIcon" class="fas fa-sync-alt"></i>
        </div>
        <div id="adminLoadingText" class="admin-loading-text">Processing your request...</div>
    </div>
</div>

<style>
.admin-loading-overlay {
    position: fixed;
    inset: 0;
    z-index: 20000;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(11, 43, 92, 0.55);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
}
.admin-loading-overlay.show {
    display: flex;
}
.admin-loading-card {
    background: #fff;
    border-radius: 16px;
    padding: 34px 42px;
    text-align: center;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
    min-width: 220px;
    animation: adminLoadingPop 0.18s ease-out;
}
@keyframes adminLoadingPop {
    from { transform: scale(0.92); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}
.admin-loading-spinner {
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    border-radius: 50%;
    background: #0b2b5c;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.admin-loading-spinner::before {
    content: '';
    position: absolute;
    inset: -6px;
    border: 3px solid rgba(11, 43, 92, 0.15);
    border-top-color: #0b2b5c;
    border-radius: 50%;
    animation: adminLoadingSpin 0.8s linear infinite;
}
.admin-loading-spinner i {
    color: #fff;
    font-size: 20px;
}
.admin-loading-spinner i.fa-sync-alt {
    animation: adminLoadingSpin 1s linear infinite;
}
@keyframes adminLoadingSpin {
    to { transform: rotate(360deg); }
}
.admin-loading-text {
    font-weight: 600;
    color: #0b2b5c;
    font-size: 14.5px;
}
</style>

<script>
(function () {
    var overlay, iconEl, textEl;

    function els() {
        if (!overlay) {
            overlay = document.getElementById('adminLoadingOverlay');
            iconEl  = document.getElementById('adminLoadingIcon');
            textEl  = document.getElementById('adminLoadingText');
        }
    }

    // icon: 'check' (approve), 'times' (reject), 'pencil' (edit),
    // 'trash' (delete), or omit for a generic spinner
    window.showAdminLoading = function (text, icon) {
        els();
        if (!overlay) return;
        textEl.textContent = text || 'Processing your request...';
        iconEl.className = icon ? ('fas fa-' + icon) : 'fas fa-sync-alt';
        overlay.classList.add('show');
        overlay.setAttribute('aria-hidden', 'false');
    };

    window.hideAdminLoading = function () {
        els();
        if (!overlay) return;
        overlay.classList.remove('show');
        overlay.setAttribute('aria-hidden', 'true');
    };

    // Safety net: catch a form submitting via its own submit button/browser
    // validation. Bubble phase (not capture) + the defaultPrevented check
    // matters: several admin forms use onsubmit="return confirm(...)" or
    // onsubmit="return confirmApprove(this)" (Swal, always returns false
    // and re-submits later via form.submit()). Those synchronously cancel
    // the initial submit event — if we showed the overlay in capture phase
    // we'd flash it under/behind the confirm dialog before the cancel even
    // happens. Listening on bubble and checking defaultPrevented means we
    // only show it once the submission is actually going through; the
    // Swal-then-submit() pattern is instead caught by the monkeypatch below.
    document.addEventListener('submit', function (e) {
        if (e.defaultPrevented) return;
        var form = e.target;
        if (form && form.tagName === 'FORM' && (form.method || 'get').toLowerCase() === 'post') {
            window.showAdminLoading();
        }
    });

    // Catches programmatic form.submit() calls (e.g. after a SweetAlert
    // confirm) — these never fire a native 'submit' event at all.
    var nativeSubmit = HTMLFormElement.prototype.submit;
    HTMLFormElement.prototype.submit = function () {
        if ((this.method || 'get').toLowerCase() === 'post') {
            window.showAdminLoading();
        }
        nativeSubmit.call(this);
    };

    // If the page is restored from bfcache (e.g. user hits Back after an
    // action), make sure a stale overlay never stays stuck on screen.
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) window.hideAdminLoading();
    });
})();
</script>
