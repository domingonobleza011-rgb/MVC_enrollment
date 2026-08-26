
<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
    .settings-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(11,43,92,0.08);
    }
    .settings-card .card-header {
        background: linear-gradient(135deg,#0b2b5c,#1f5a9e);
        color: #fff;
        border-radius: 14px 14px 0 0;
        padding: 18px 24px;
    }
    .toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 4px;
        border-bottom: 1px solid #eef1f6;
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

    .capacity-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 4px;
        border-bottom: 1px solid #f2f4f8;
    }
    .capacity-row:last-child { border-bottom: none; }
    .capacity-row label {
        margin: 0;
        font-weight: 600;
        color: #1a1e2e;
        width: 110px;
        flex-shrink: 0;
    }
    .capacity-row input[type="number"] {
        max-width: 160px;
        border-radius: 8px;
    }
    .capacity-row .unlimited-hint {
        color: #8a93a6;
        font-size: .8rem;
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" style="color:#0b2b5c;font-weight:700;">
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
                                <div class="font-weight-bold" style="color:#1a1e2e;">Accept New Enrollments</div>
                                <div class="text-muted small" style="max-width:340px;">
                                    When turned off, the public enrollment forms (Grade 7–12) will stop
                                    accepting <strong>new</strong> submissions. Students already mid-appeal
                                    on a rejected application can still resubmit.
                                </div>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="enrollment_open" <?= $enrollment_open ? 'checked' : '' ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="mt-3">
                            <span class="badge <?= $enrollment_open ? 'badge-success' : 'badge-danger' ?> px-3 py-2">
                                <i class="fas <?= $enrollment_open ? 'fa-check-circle' : 'fa-times-circle' ?> mr-1"></i>
                                Currently <?= $enrollment_open ? 'OPEN' : 'CLOSED' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card settings-card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-users mr-2"></i>Grade Level Capacity</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">
                            Leave a field blank for <strong>unlimited</strong> capacity. Once a grade level
                            reaches its capacity for the current school year, new applications are automatically
                            marked <span class="badge badge-pill" style="background:#e2e3ff;color:#3730a3;">Waitlisted</span>
                            instead of Pending.
                        </p>
                        <?php foreach ($grades as $key => $label): ?>
                        <div class="capacity-row">
                            <label for="cap_<?= $key ?>"><?= htmlspecialchars($label) ?></label>
                            <input type="number" min="0" step="1" class="form-control form-control-sm"
                                   id="cap_<?= $key ?>" name="capacity[<?= $key ?>]"
                                   value="<?= $capacities[$key] !== null ? (int)$capacities[$key] : '' ?>"
                                   placeholder="Unlimited">
                            <span class="unlimited-hint"><?= $capacities[$key] === null ? 'No limit set' : 'seats' ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" name="save_enrollment_settings" class="btn btn-lg" style="background:#0b2b5c;color:#fff;border-radius:10px;padding:10px 32px;">
            <i class="fas fa-save mr-2"></i> Save Settings
        </button>
    </form>
</div>

<?php if (!empty($_SESSION['swal'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['swal']['icon'] ?>',
        title: '<?= addslashes($_SESSION['swal']['title']) ?>',
        text: '<?= addslashes($_SESSION['swal']['text'] ?? '') ?>',
        confirmButtonColor: '#0b2b5c'
    });
</script>
<?php unset($_SESSION['swal']); endif; ?>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
