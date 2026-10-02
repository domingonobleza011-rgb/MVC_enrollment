
<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
    .settings-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 10px var(--edb-shadow);
    }
    .settings-card .card-header {
        background: var(--edb-surface);
        color: var(--edb-ink);
        border-bottom: 1px solid var(--edb-border);
        border-radius: 14px 14px 0 0;
        padding: 18px 24px;
    }
    .toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 4px;
        border-bottom: 1px solid var(--edb-border);
    }
    /* Simple styled checkbox-as-switch, no extra JS library needed */
    .switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
        flex-shrink: 0;
    }
    .switch input { opacity: 0; width: 0; height: 0; }
    .switch .slider {
        position: absolute; cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #dc3545;
        transition: .2s;
        border-radius: 28px;
    }
    .switch .slider:before {
        position: absolute;
        content: "";
        height: 22px; width: 22px;
        left: 3px; bottom: 3px;
        background-color: white;
        transition: .2s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,.3);
    }
    .switch input:checked + .slider { background-color: #28a745; }
    .switch input:checked + .slider:before { transform: translateX(24px); }

    /* Font size selector */
    .fontsize-option-group {
        display: flex;
        gap: 10px;
        margin-top: 12px;
    }
    .fontsize-option {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 14px 8px;
        border: 2px solid var(--edb-border);
        border-radius: 12px;
        color: var(--edb-muted);
        font-weight: 600;
        font-size: .82rem;
        text-decoration: none;
        transition: all .15s;
        cursor: pointer;
    }
    .fontsize-option:hover { border-color: rgba(var(--edb-chart-rgb), 0.4); color: var(--edb-ink); text-decoration: none; }
    /* Labels get their color directly (not inherited from the <a>) so the
       shared dark-mode link color can't tint them. */
    .fontsize-option > span:not(.fontsize-option-preview) { color: var(--edb-muted); }
    .fontsize-option:hover > span:not(.fontsize-option-preview),
    .fontsize-option.active-fontsize > span:not(.fontsize-option-preview) { color: var(--edb-ink); }
    .fontsize-option .fontsize-option-preview { font-weight: 800; color: var(--edb-ink); line-height: 1; }
    .fontsize-option.active-fontsize { border-color: rgb(var(--edb-chart-rgb)); background: rgba(var(--edb-chart-rgb), 0.08); color: var(--edb-ink); }

    /* Primary labels on this page ("Accept New Enrollments", "Automatic
       Schedule", "Font Size"): a theme-aware class rather than an inline
       color, so they stay readable in both light and dark mode. */
    .settings-label { color: var(--edb-ink); }

    /* SweetAlert confirm button: neutral instead of navy/blue */
    body .swal2-styled.swal2-confirm { background-color: rgb(var(--edb-chart-rgb)); color: var(--edb-on-chart); }
    body .swal2-styled.swal2-confirm:focus { box-shadow: 0 0 0 3px rgba(var(--edb-chart-rgb), 0.3); }
</style>

<div class="container-fluid plain-page">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" style="color:var(--edb-ink);font-weight:700;">
            <i class="fas fa-sliders-h mr-2"></i>System Settings
        </h1>
    </div>

    <form method="post">
        <div class="row">
            <div class="col-lg-6">
                <div class="card settings-card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-door-open mr-2"></i>Enrollment Period</h6>
                    </div>
                    <div class="card-body">
                        <div class="toggle-row">
                            <div>
                                <div class="font-weight-bold settings-label">Accept New Enrollments</div>
                                <div class="text-muted small" style="max-width:340px;">
                                    <span class="badge <?= $enrollment_open ? 'badge-success' : 'badge-danger' ?> px-3 py-2">
                                <i class="fas <?= $enrollment_open ? 'fa-check-circle' : 'fa-times-circle' ?> mr-1"></i>
                                Currently <?= $enrollment_open ? 'OPEN' : 'CLOSED' ?>
                            </span>
                                </div>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="enrollment_open" <?= $manual_enrollment_open ? 'checked' : '' ?>>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <?php if ($manual_enrollment_open && !$enrollment_open): ?>
                            <div class="small mt-2 mb-0" style="max-width:420px;color:#b45309;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:8px 12px;">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                This switch is ON, but the scheduled opening date/time below
                                hasn't arrived yet, so enrollment is still <strong>closed</strong>
                                for now. It will switch to OPEN automatically once that time is
                                reached — no need to touch this switch.
                            </div>
                        <?php endif; ?>

                        <div class="pt-3">
                            <div class="font-weight-bold settings-label">
                                <i class="fas fa-clock mr-1"></i> Automatic Schedule <span class="text-muted font-weight-normal">(optional)</span>
                            </div>
                         
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small font-weight-bold text-muted mb-1">Opens on</label>
                                    <input type="datetime-local" name="schedule_open_at" class="form-control"
                                        value="<?= !empty($enrollment_schedule['open_at']) ? date('Y-m-d\TH:i', strtotime($enrollment_schedule['open_at'])) : '' ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small font-weight-bold text-muted mb-1">Closes on</label>
                                    <input type="datetime-local" name="schedule_close_at" class="form-control"
                                        value="<?= !empty($enrollment_schedule['close_at']) ? date('Y-m-d\TH:i', strtotime($enrollment_schedule['close_at'])) : '' ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card settings-card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-text-height mr-2"></i>Display Preferences</h6>
                    </div>
                    <div class="card-body">
                        <div class="font-weight-bold settings-label">Font Size</div>
                        
                        <div class="fontsize-option-group">
                            <a href="#" class="fontsize-option" data-fontsize-choice="small">
                                <span class="fontsize-option-preview" style="font-size:.85rem;">A</span>
                                <span>Small</span>
                            </a>
                            <a href="#" class="fontsize-option" data-fontsize-choice="medium">
                                <span class="fontsize-option-preview" style="font-size:1.1rem;">A</span>
                                <span>Medium</span>
                            </a>
                            <a href="#" class="fontsize-option" data-fontsize-choice="large">
                                <span class="fontsize-option-preview" style="font-size:1.4rem;">A</span>
                                <span>Large</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" name="save_enrollment_settings" class="btn btn-primary btn-lg" style="border-radius:10px;padding:10px 32px;">
            <i class="fas fa-save mr-2"></i> Save Settings
        </button>
    </form>

    <div class="row">
        <div class="col-lg-6">
            <form method="post" enctype="multipart/form-data">
                <div class="card settings-card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-stamp mr-2"></i>Approval Certificate — Registrar Details</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small" style="max-width:480px;">
                            This name and signature are printed on the "Certificate of Enrollment Approval" PDF
                            that gets attached to a student's approval email.
                        </p>
                        <div class="form-group">
                            <label class="small font-weight-bold text-muted mb-1">Registrar Name</label>
                            <input type="text" name="registrar_name" class="form-control" placeholder="e.g. Juan D. Dela Cruz"
                                value="<?= htmlspecialchars($registrar_name ?? '') ?>">
                        </div>
                        <div class="form-group mb-0">
                            <label class="small font-weight-bold text-muted mb-1">Signature Image <span class="font-weight-normal">(PNG with transparent background works best)</span></label>
                            <input type="file" name="registrar_signature" class="form-control-file" accept=".png,.jpg,.jpeg">
                            <?php if (!empty($registrar_signature_url)): ?>
                                <div class="mt-2 p-2" style="background:#fff;border:1px solid var(--edb-border);border-radius:8px;display:inline-block;">
                                    <img src="<?= htmlspecialchars($registrar_signature_url) ?>" alt="Current signature" style="max-height:60px;display:block;">
                                </div>
                                <div class="text-muted small mt-1">Current signature on file. Uploading a new file will replace it.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <button type="submit" name="save_registrar_settings" class="btn btn-primary" style="border-radius:10px;padding:8px 24px;">
                            <i class="fas fa-save mr-2"></i> Save Registrar Details
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['swal'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['swal']['icon'] ?>',
        title: '<?= addslashes($_SESSION['swal']['title']) ?>',
        text: '<?= addslashes($_SESSION['swal']['text'] ?? '') ?>'
    });
</script>
<?php unset($_SESSION['swal']); endif; ?>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
