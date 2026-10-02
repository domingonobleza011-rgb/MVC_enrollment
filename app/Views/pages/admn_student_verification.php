

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
    .page-header { padding:26px 30px; }
    .page-header h1 { font-size:1.6rem; font-weight:700; margin:0; }
    .tbl-card { border:none; border-radius:14px; box-shadow:0 2px 10px var(--edb-shadow); }
    .tbl-card .card-header { background:var(--edb-surface); color:var(--edb-ink); border-bottom:1px solid var(--edb-border); border-radius:14px 14px 0 0; font-weight:600; }
    /* SweetAlert confirm button: neutral instead of the default blue/violet */
    body .swal2-styled.swal2-confirm { background-color: rgb(var(--edb-chart-rgb)); color: var(--edb-on-chart); }
    body .swal2-styled.swal2-confirm:focus { box-shadow: 0 0 0 3px rgba(var(--edb-chart-rgb), 0.3); }

/* ===== Approve / Reject modals (match Archive's restore/delete modal style) ===== */
.approve-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(10, 20, 40, 0.6); backdrop-filter: blur(4px);
    z-index: 9999; align-items: center; justify-content: center;
}
.approve-modal-overlay.show { display: flex; }
.approve-modal {
    background: #fff; border-radius: 20px; padding: 2rem;
    max-width: 400px; width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: gtPopIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-align: center;
}
@keyframes gtPopIn {
    from { transform: scale(0.8); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}
.approve-modal-icon {
    width: 70px; height: 70px;
    background: linear-gradient(135deg, #eafaf1, #d5f5e3);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.2rem; border: 3px solid #a9dfbf;
}
.approve-modal-icon i { font-size: 1.8rem; color: #27ae60; }
.approve-modal h5 { font-family: 'Segoe UI', sans-serif; font-weight: 800; font-size: 1.15rem; color: #1a1a2e; margin-bottom: 0.5rem; }
.approve-modal p { font-size: 0.85rem; color: #7f8c8d; margin-bottom: 1.2rem; line-height: 1.6; }
.approve-modal-info {
    background: #eafaf1; border: 1px solid #a9dfbf; border-radius: 10px;
    padding: 0.6rem 1rem; font-size: 0.78rem; color: #27ae60; font-weight: 600;
    margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; text-align: left;
}
.approve-modal-actions { display: flex; gap: 10px; }
.btn-cancel-approve {
    flex: 1; padding: 10px; border-radius: 12px; border: 1.5px solid #e0e0e0;
    background: #f8f9fa; color: #555; font-weight: 700; font-size: 0.85rem;
    cursor: pointer; transition: all 0.2s;
}
.btn-cancel-approve:hover { background: #e9ecef; border-color: #ccc; }
.btn-confirm-approve {
    flex: 1; padding: 10px; border-radius: 12px; border: none;
    background: linear-gradient(135deg, #1e8449, #27ae60); color: white;
    font-weight: 700; font-size: 0.85rem; cursor: pointer;
    box-shadow: 0 4px 14px rgba(39,174,96,0.4); transition: all 0.2s;
}
.btn-confirm-approve:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(39,174,96,0.5); }

.reject-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(10, 20, 40, 0.6); backdrop-filter: blur(4px);
    z-index: 9999; align-items: center; justify-content: center;
}
.reject-modal-overlay.show { display: flex; }
.reject-modal {
    background: #fff; border-radius: 20px; padding: 2rem;
    max-width: 420px; width: 92%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: gtPopIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-align: center;
}
.reject-modal-icon {
    width: 70px; height: 70px;
    background: linear-gradient(135deg, #fff0f0, #ffe0e0);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.2rem; border: 3px solid #f5c6c6;
}
.reject-modal-icon i { font-size: 1.8rem; color: #e74c3c; }
.reject-modal h5 { font-family: 'Segoe UI', sans-serif; font-weight: 800; font-size: 1.15rem; color: #1a1a2e; margin-bottom: 0.5rem; }
.reject-modal p { font-size: 0.85rem; color: #7f8c8d; margin-bottom: 1rem; line-height: 1.6; }
.reject-modal .form-group { text-align: left; margin-bottom: 1.5rem; }
.reject-modal .form-group label { font-size: 0.82rem; font-weight: 700; color: #1a1a2e; }
.reject-modal textarea.form-control { border-radius: 10px; border: 1.5px solid #e0e0e0; font-size: 0.85rem; resize: vertical; }
.reject-modal textarea.form-control:focus { border-color: #e74c3c; box-shadow: 0 0 0 3px rgba(231,76,60,0.12); outline: none; }
.reject-modal-actions { display: flex; gap: 10px; }
.btn-cancel-reject-modal {
    flex: 1; padding: 10px; border-radius: 12px; border: 1.5px solid #e0e0e0;
    background: #f8f9fa; color: #555; font-weight: 700; font-size: 0.85rem;
    cursor: pointer; transition: all 0.2s;
}
.btn-cancel-reject-modal:hover { background: #e9ecef; border-color: #ccc; }
.btn-confirm-reject-modal {
    flex: 1; padding: 10px; border-radius: 12px; border: none;
    background: linear-gradient(135deg, #c0392b, #e74c3c); color: white;
    font-weight: 700; font-size: 0.85rem; cursor: pointer;
    box-shadow: 0 4px 14px rgba(231,76,60,0.4); transition: all 0.2s;
}
.btn-confirm-reject-modal:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(231,76,60,0.5); }

/* ===== Dark mode support ===== */
html[data-theme="dark"] .approve-modal,
html[data-theme="dark"] .reject-modal {
    background: #1a1f2b !important;
}
html[data-theme="dark"] .approve-modal h5,
html[data-theme="dark"] .reject-modal h5 {
    color: #eef0f4 !important;
}
html[data-theme="dark"] .approve-modal p,
html[data-theme="dark"] .reject-modal p {
    color: #9aa2b1 !important;
}
html[data-theme="dark"] .approve-modal p strong,
html[data-theme="dark"] .reject-modal p strong {
    color: #eef0f4 !important;
}
html[data-theme="dark"] .reject-modal .form-group label {
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .reject-modal textarea.form-control {
    background-color: #232a38 !important;
    border-color: rgba(255,255,255,0.15) !important;
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .reject-modal textarea.form-control::placeholder {
    color: rgba(215,219,226,0.4) !important;
}
html[data-theme="dark"] .approve-modal-info {
    background: rgba(39,174,96,0.12) !important;
    border-color: rgba(39,174,96,0.35) !important;
    color: #6fcf97 !important;
}
html[data-theme="dark"] .approve-modal-icon {
    background: linear-gradient(135deg, rgba(39,174,96,0.18), rgba(39,174,96,0.28)) !important;
    border-color: rgba(39,174,96,0.45) !important;
}
html[data-theme="dark"] .reject-modal-icon {
    background: linear-gradient(135deg, rgba(231,76,60,0.18), rgba(231,76,60,0.28)) !important;
    border-color: rgba(231,76,60,0.45) !important;
}
html[data-theme="dark"] .btn-cancel-approve,
html[data-theme="dark"] .btn-cancel-reject-modal {
    background: #232a38 !important;
    border-color: rgba(255,255,255,0.15) !important;
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .btn-cancel-approve:hover,
html[data-theme="dark"] .btn-cancel-reject-modal:hover {
    background: #2a3242 !important;
    border-color: rgba(255,255,255,0.28) !important;
}
</style>

<div class="container-fluid py-4 plain-page">

    <?php if ($swal): ?>
    <script>
    window.addEventListener('load', function() {
        Swal.fire({
            icon: '<?= $swal['icon'] ?>',
            title: '<?= addslashes($swal['title']) ?>',
            text: '<?= addslashes($swal['text']) ?>'
        });
    });
    </script>
    <?php endif; ?>

    <div class="page-header plain-banner">
        <h1><i class="fas fa-user-check me-2"></i> Student Account Verification</h1>
    </div>

    <div class="tbl-card card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span>
                <i class="fas fa-list me-2"></i> Awaiting Approval
                <span class="badge bg-warning text-dark ms-2"><?= count($pending) ?> Pending</span>
            </span>
        </div>
        <div class="card-body p-0">
            <?php if (empty($pending)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3" style="color:#cbd5e1;"></i>
                    <p>No accounts are currently waiting for approval.</p>
                </div>
            <?php else: ?>
            <div class="enr-scroll">
                <table class="table table-hover mb-0 simple-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                           
                            <th>Signed Up Via</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pending as $i => $s): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><strong><?= htmlspecialchars(trim(($s['lname'] ?? '') . ', ' . ($s['fname'] ?? ''))) ?></strong></td>
                            
                            <td><span class="badge bg-light text-dark border"><i class="fab fa-google me-1"></i><?= htmlspecialchars($s['addedby'] ?? 'Google') ?></span></td>
                            <td>
                                <div class="dropdown row-actions">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        id="verDd<?= $s['id_student'] ?>" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right row-actions-menu" aria-labelledby="verDd<?= $s['id_student'] ?>">
                                        <a class="dropdown-item item-view" href="#" data-toggle="modal" data-target="#viewStudentModal<?= $s['id_student'] ?>">
                                            <i class="fa fa-eye"></i>View
                                        </a>
                                        <button type="button" class="dropdown-item item-approve"
                                                onclick="approveAccount(<?= $s['id_student'] ?>, '<?= htmlspecialchars(trim(($s['lname']??'').', '.($s['fname']??'')), ENT_QUOTES) ?>')">
                                            <i class="fas fa-check"></i>Approve
                                        </button>
                                        <button type="button" class="dropdown-item item-reject"
                                                onclick="rejectAccount(<?= $s['id_student'] ?>)">
                                            <i class="fas fa-times"></i>Reject
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- View Modal: everything the student submitted on student_registration.php -->
                        <div class="modal fade plain-modal" id="viewStudentModal<?= $s['id_student'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header py-2">
                                        <h5 class="modal-title">Student Registration Details</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body text-left view-student-body">
                                        <div class="view-grid">
                                            <div class="view-item span-2"><span class="view-label">Full Name</span><div class="view-val"><?= htmlspecialchars(trim(($s['lname'] ?? '') . ', ' . ($s['fname'] ?? '') . ' ' . ($s['mi'] ?? ''))) ?></div></div>
                                            <div class="view-item"><span class="view-label">Birthdate</span><div class="view-val"><?= htmlspecialchars($s['bdate'] ?? '') ?></div></div>
                                            <div class="view-item"><span class="view-label">Age</span><div class="view-val"><?= htmlspecialchars($s['age'] ?? '') ?></div></div>
                                            <div class="view-item"><span class="view-label">Sex</span><div class="view-val"><?= htmlspecialchars($s['sex'] ?? '') ?></div></div>
                                            <div class="view-item"><span class="view-label">Signed Up Via</span><div class="view-val"><?= htmlspecialchars($s['addedby'] ?? '') ?><?= !empty($s['social_provider']) ? ' — ' . htmlspecialchars($s['social_provider']) : '' ?></div></div>
                                        </div>

                                        <h6 class="edit-section-title">Contact Information</h6>
                                        <div class="view-grid">
                                            <div class="view-item span-2"><span class="view-label">Email</span><div class="view-val"><?= htmlspecialchars($s['email'] ?? '') ?></div></div>
                                            <div class="view-item span-2"><span class="view-label">Phone Number</span><div class="view-val"><?= htmlspecialchars($s['phone_number'] ?? '') ?></div></div>
                                            <div class="view-item span-4"><span class="view-label">Contact Number</span><div class="view-val"><?= htmlspecialchars($s['contact'] ?? '') ?></div></div>
                                        </div>

                                        <h6 class="edit-section-title">Address</h6>
                                        <div class="view-grid">
                                            <div class="view-item"><span class="view-label">Region</span><div class="view-val"><?= htmlspecialchars($s['region'] ?? '') ?></div></div>
                                            <div class="view-item"><span class="view-label">Province</span><div class="view-val"><?= htmlspecialchars($s['province'] ?? '') ?></div></div>
                                            <div class="view-item"><span class="view-label">City / Municipality</span><div class="view-val"><?= htmlspecialchars($s['municipal'] ?? '') ?></div></div>
                                            <div class="view-item"><span class="view-label">Barangay</span><div class="view-val"><?= htmlspecialchars($s['brgy'] ?? '') ?></div></div>
                                        </div>

                                        <h6 class="edit-section-title">Account Recovery</h6>
                                        <div class="view-grid">
                                            <div class="view-item span-4"><span class="view-label">Security Question</span><div class="view-val"><?= htmlspecialchars($s['security_question'] ?? '') ?></div></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Approve Form -->
<form method="POST" action="admn_student_verification.php" id="approveForm">
    <input type="hidden" name="approve_student_account" value="1">
    <input type="hidden" name="id_student" id="approve_id" value="">
</form>

<!-- Reject Form -->
<form method="POST" action="admn_student_verification.php" id="rejectForm">
    <input type="hidden" name="reject_student_account" value="1">
    <input type="hidden" name="id_student" id="reject_id" value="">
    <input type="hidden" name="reject_reason" id="reject_reason_hidden" value="">
</form>

<!-- ===== APPROVE CONFIRM MODAL ===== -->
<div class="approve-modal-overlay" id="approveModalOverlay">
    <div class="approve-modal">
        <div class="approve-modal-icon">
            <i class="fas fa-check"></i>
        </div>
        <h5>Approve this Account?</h5>
        <p><strong id="approveAccountName"></strong> will be able to log in and access the portal.</p>
        <div class="approve-modal-actions">
            <button type="button" class="btn-cancel-approve" onclick="closeApproveAccountModal()">Cancel</button>
            <button type="button" class="btn-confirm-approve" id="confirmApproveAccountBtn">
                <i class="fas fa-check"></i> Yes, Approve
            </button>
        </div>
    </div>
</div>

<!-- ===== REJECT CONFIRM MODAL ===== -->
<div class="reject-modal-overlay" id="rejectModalOverlay">
    <div class="reject-modal">
        <div class="reject-modal-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <h5>Reject this Account?</h5>
        <div class="form-group">
            <label for="reject_reason_input">Reason <span class="text-muted" style="font-weight:400;">(optional)</span></label>
            <textarea class="form-control" id="reject_reason_input" rows="3"
                placeholder="e.g. Could not verify identity as a student..."></textarea>
        </div>
        <div class="reject-modal-actions">
            <button type="button" class="btn-cancel-reject-modal" onclick="closeRejectAccountModal()">Cancel</button>
            <button type="button" class="btn-confirm-reject-modal" id="confirmRejectAccountBtn">
                <i class="fas fa-times-circle"></i> Confirm Reject
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let approveAccountId = null;
function approveAccount(id, name) {
    approveAccountId = id;
    document.getElementById('approveAccountName').textContent = name;
    document.getElementById('approveModalOverlay').classList.add('show');
}
function closeApproveAccountModal() {
    document.getElementById('approveModalOverlay').classList.remove('show');
    approveAccountId = null;
}
document.getElementById('confirmApproveAccountBtn').addEventListener('click', function () {
    if (approveAccountId) {
        document.getElementById('approve_id').value = approveAccountId;
        showAdminLoading('Approving account...', 'check');
        document.getElementById('approveForm').submit();
    }
    closeApproveAccountModal();
});
document.getElementById('approveModalOverlay').addEventListener('click', function(e){ if (e.target === this) closeApproveAccountModal(); });

let rejectAccountId = null;
function rejectAccount(id) {
    rejectAccountId = id;
    document.getElementById('reject_reason_input').value = '';
    document.getElementById('rejectModalOverlay').classList.add('show');
}
function closeRejectAccountModal() {
    document.getElementById('rejectModalOverlay').classList.remove('show');
    rejectAccountId = null;
}
document.getElementById('confirmRejectAccountBtn').addEventListener('click', function () {
    if (rejectAccountId) {
        document.getElementById('reject_id').value = rejectAccountId;
        document.getElementById('reject_reason_hidden').value = document.getElementById('reject_reason_input').value.trim();
        showAdminLoading('Rejecting account...', 'times');
        document.getElementById('rejectForm').submit();
    }
    closeRejectAccountModal();
});
document.getElementById('rejectModalOverlay').addEventListener('click', function(e){ if (e.target === this) closeRejectAccountModal(); });
</script>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
