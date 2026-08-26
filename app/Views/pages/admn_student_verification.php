

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
    .page-header { background:linear-gradient(135deg,#0b2b5c,#1565c0); color:#fff; border-radius:14px; padding:26px 30px; margin-bottom:24px; }
    .page-header h1 { font-size:1.6rem; font-weight:700; margin:0; }
    .tbl-card { border:none; border-radius:14px; box-shadow:0 2px 14px rgba(11,43,92,.10); }
    .tbl-card .card-header { background:#0b2b5c; color:#fff; border-radius:14px 14px 0 0; font-weight:600; }
</style>

<div class="container-fluid py-4">

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

    <div class="page-header">
        <h1><i class="fas fa-user-check me-2"></i> Student Account Verification</h1>
        <p class="mb-0 mt-1" style="opacity:.85;font-size:.95rem;">Accounts created with "Continue with Google" that have verified their email and are waiting for approval before they can access the portal.</p>
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead style="background:#f8f9fc;">
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
                                <button class="btn btn-sm btn-success mb-1"
                                        onclick="approveAccount(<?= $s['id_student'] ?>, '<?= htmlspecialchars(trim(($s['lname']??'').', '.($s['fname']??'')), ENT_QUOTES) ?>')">
                                    <i class="fas fa-check me-1"></i> Approve
                                </button>
                                <button class="btn btn-sm btn-danger"
                                        onclick="rejectAccount(<?= $s['id_student'] ?>)">
                                    <i class="fas fa-times me-1"></i> Reject
                                </button>
                            </td>
                        </tr>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function approveAccount(id, name) {
    Swal.fire({
        title: 'Approve this account?',
        html: `<p><strong>${name}</strong> will be able to log in and access the portal.</p>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Approve',
        confirmButtonColor: '#16a34a'
    }).then(res => {
        if (res.isConfirmed) {
            document.getElementById('approve_id').value = id;
            document.getElementById('approveForm').submit();
        }
    });
}

function rejectAccount(id) {
    Swal.fire({
        title: 'Reject this account?',
        html: `<label class="form-label fw-semibold">Reason (optional)</label>
               <textarea id="reason_input" class="swal2-textarea" placeholder="e.g. Could not verify identity as a student…"></textarea>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-times"></i> Reject',
        confirmButtonColor: '#dc2626',
        preConfirm: () => document.getElementById('reason_input').value.trim()
    }).then(res => {
        if (res.isConfirmed) {
            document.getElementById('reject_id').value = id;
            document.getElementById('reject_reason_hidden').value = res.value;
            document.getElementById('rejectForm').submit();
        }
    });
}
</script>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
