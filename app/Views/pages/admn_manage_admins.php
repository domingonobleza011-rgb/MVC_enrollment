
<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
.res-header {
    padding: 18px 24px;
}
.res-header h4 { margin-bottom: 2px; }
.total-badge {
    background: rgba(var(--edb-chart-rgb), 0.08);
    border: 1px solid var(--edb-border);
    color: var(--edb-ink);
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 20px;
    font-size: 14px;
}
.table tbody tr:hover { background-color: rgba(var(--edb-chart-rgb), 0.06); }
.search-wrap input {
    border: 1px solid var(--edb-input-border);
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 14px;
    width: 260px;
}
.search-wrap input:focus {
    outline: none;
    border-color: rgba(var(--edb-chart-rgb), 0.55);
    box-shadow: 0 0 0 2px rgba(var(--edb-chart-rgb), 0.15);
}
#entriesCount { font-size: 13px; color: #6c757d; }
.role-badge {
    display: inline-block;
    padding: 3px 12px;
    border-radius: 14px;
    font-size: 12px;
    font-weight: 700;
    text-transform: capitalize;
    background: rgba(var(--edb-chart-rgb), 0.1);
    color: rgb(var(--edb-chart-rgb));
}

/* ===== Add Admin (button + modal) ===== */
.btn-add-admin {
    background: rgb(var(--edb-chart-rgb));
    color: var(--edb-on-chart);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    padding: 7px 16px;
}
.btn-add-admin:hover, .btn-add-admin:focus { color: var(--edb-on-chart); filter: brightness(1.12); }
.btn-back-students {
    background: transparent;
    color: var(--edb-ink);
    border: 1px solid var(--edb-input-border);
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    padding: 7px 16px;
}
.btn-back-students:hover { background: rgba(var(--edb-chart-rgb), 0.08); color: var(--edb-ink); }
.admin-form-body { padding: .9rem 1.1rem; }
.admin-form-body .form-group { margin-bottom: .6rem; }
.admin-form-body label { font-size: .78rem; font-weight: 600; margin-bottom: .15rem; color: #0f172a; }
.admin-form-body .form-control { text-align: left; color: #0f172a; }
.admin-form-body .form-control::placeholder { color: #6b7280; }
.plain-modal .modal-footer .btn-outline-secondary { color: #0f172a; border-color: #6b7280; }
html[data-theme="dark"] .admin-form-body label,
html[data-theme="dark"] .admin-form-body .form-control { color: #ffffff !important; }
html[data-theme="dark"] .admin-form-body .form-control::placeholder { color: rgba(255,255,255,0.55) !important; }
html[data-theme="dark"] .plain-modal .modal-footer .btn-outline-secondary { color: #ffffff !important; border-color: rgba(255,255,255,0.5) !important; }
</style>

<?php $aa = fn($k) => htmlspecialchars($_POST[$k] ?? '', ENT_QUOTES, 'UTF-8'); ?>
<!-- Add Admin modal (posts to this page; handled by AdmnManageAdminsController -> create_admin()) -->
<div class="modal fade plain-modal" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" autocomplete="off">
                <input type="hidden" name="return_to" value="admn_manage_admins.php">
                <!-- Role is always Admin here -->
                <input type="hidden" name="role" value="administrator">
                <div class="modal-header py-2">
                    <h5 class="modal-title font-weight-bold text-ink" id="addAdminTitle">Add Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body text-left admin-form-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control form-control-sm name-only" placeholder="First Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" maxlength="50" value="<?= $aa('fname') ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Middle Name</label>
                            <input type="text" name="mi" class="form-control form-control-sm name-only" placeholder="Middle Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" maxlength="50" value="<?= $aa('mi') ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control form-control-sm name-only" placeholder="Last Name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Letters only (no numbers or symbols)" maxlength="50" value="<?= $aa('lname') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email or Phone Number</label>
                        <input type="text" name="login_identity" class="form-control form-control-sm" placeholder="name@example.com or 09XXXXXXXXX" value="<?= $aa('login_identity') ?>" required>
                    </div>
                    <div class="form-group mb-0">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control form-control-sm" autocomplete="new-password" required>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_admin" class="btn btn-add-admin btn-sm">Create Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid plain-page">

    <!-- Header -->
    <div class="res-header plain-banner d-flex align-items-center justify-content-between flex-wrap">
        <div>
            <h4 class="mb-1"><i class="fas fa-user-shield mr-2"></i>Manage Admins</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap mt-2 mt-md-0" style="gap:10px;">
            <a href="admn_students.php" class="btn btn-back-students">
                <i class="fas fa-arrow-left mr-1"></i> Back to Registered Accounts
            </a>
            <button type="button" class="btn btn-add-admin" data-toggle="modal" data-target="#addAdminModal">
                <i class="fas fa-user-plus mr-1"></i> Add Admin
            </button>
            <span class="total-badge">
                <i class="fas fa-users mr-1"></i>
                Total: <?= number_format(count($admins)) ?>
            </span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="m-0 font-weight-bold" style="color:var(--edb-ink);">
                <i class="fas fa-table mr-1"></i> Admin Accounts
            </h6>
            <div class="d-flex align-items-center flex-wrap mt-2 mt-md-0" style="gap:10px;">
                <div class="search-wrap">
                    <input type="text" id="adminSearch" placeholder="&#128269; Search name, email...">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="enr-scroll">
                <table class="table table-hover mb-0 simple-table" id="adminTable">
                    <thead>
                        <tr>
                            <th style="width:45px;">#</th>
                            <th>Full Name</th>
                            <th>Email / Phone</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody id="adminTbody">
                        <?php if (empty($admins)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No admin accounts found.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($admins as $i => $r):
                            $mi       = !empty($r['mi']) ? ' ' . strtoupper($r['mi']) : '';
                            $fullname = strtoupper($r['lname']) . ', ' . ucwords(strtolower($r['fname'])) . $mi;
                            $contact  = !empty($r['email']) ? $r['email'] : ($r['phone_number'] ?? '—');
                        ?>
                        <tr class="data-row">
                            <td class="text-center text-muted"><?= $i + 1 ?></td>
                            <td class="font-weight-bold"><?= htmlspecialchars($fullname) ?></td>
                            <td><?= htmlspecialchars($contact) ?></td>
                            <td><span class="role-badge"><?= htmlspecialchars($r['role']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted py-2">
            <small id="entriesCount">Showing <strong><?= count($admins) ?></strong> of <strong><?= count($admins) ?></strong> entries</small>
        </div>
    </div>

</div><!-- /.container-fluid -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('adminSearch').addEventListener('keyup', function () {
    const query = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#adminTbody tr.data-row');
    let visible = 0;
    rows.forEach(row => {
        const match = row.innerText.toLowerCase().includes(query);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('entriesCount').innerHTML =
        visible === 0 ? 'No matching entries' :
        'Showing <strong>' + visible + '</strong> of <strong><?= count($admins) ?></strong> entries';
});

<?php if (isset($_POST['add_admin'])): ?>
$(function () { $('#addAdminModal').modal('show'); });
<?php endif; ?>
</script>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
