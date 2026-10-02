
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
.table tbody tr.row-selected { background-color: rgba(var(--edb-chart-rgb), 0.12) !important; }
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
#btnDeleteSelected {
    display: none;
    background: #c0392b;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}
#btnDeleteSelected:hover { background: #a93226; }
#selectedCount {
    font-size: 13px;
    font-weight: 600;
    color: #c0392b;
    margin-right: 8px;
    display: none;
}
.cb-row { cursor: pointer; width: 18px; height: 18px; accent-color: rgb(var(--edb-chart-rgb)); }
/* SweetAlert confirm button: neutral instead of the default blue/violet */
body .swal2-styled.swal2-confirm { background-color: rgb(var(--edb-chart-rgb)); color: var(--edb-on-chart); }
body .swal2-styled.swal2-confirm:focus { box-shadow: 0 0 0 3px rgba(var(--edb-chart-rgb), 0.3); }
.th-check { width: 42px; text-align: center; }

/* ===== Pagination (15 per page) ===== */
.student-pagination { display:flex; align-items:center; gap:4px; flex-wrap:wrap; }
.student-pagination .page-btn {
    min-width:30px; height:30px; padding:0 8px;
    border:1px solid var(--edb-input-border); background:transparent; color:var(--edb-ink);
    border-radius:6px; font-size:12.5px; cursor:pointer;
}
.student-pagination .page-btn:hover:not(:disabled):not(.active) { background:rgba(var(--edb-chart-rgb), .08); }
.student-pagination .page-btn.active { background:rgb(var(--edb-chart-rgb)); color:var(--edb-on-chart); border-color:transparent; font-weight:700; }
.student-pagination .page-btn:disabled { opacity:.4; cursor:not-allowed; }
.student-pagination .page-ellipsis { padding:0 4px; color:var(--edb-ink); opacity:.5; font-size:12.5px; }

/* ===== Delete modal (match Archive's delete modal style) ===== */
.delete-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(10, 20, 40, 0.6); backdrop-filter: blur(4px);
    z-index: 9999; align-items: center; justify-content: center;
}
.delete-modal-overlay.show { display: flex; }
.delete-modal {
    background: #fff; border-radius: 20px; padding: 2rem;
    max-width: 380px; width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: gtPopIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-align: center;
}
@keyframes gtPopIn {
    from { transform: scale(0.8); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}
.delete-modal-icon {
    width: 70px; height: 70px;
    background: linear-gradient(135deg, #fff0f0, #ffe0e0);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.2rem; border: 3px solid #f5c6c6;
}
.delete-modal-icon i { font-size: 1.8rem; color: #e74c3c; }
.delete-modal h5 { font-family: 'Segoe UI', sans-serif; font-weight: 800; font-size: 1.15rem; color: #1a1a2e; margin-bottom: 0.5rem; }
.delete-modal p { font-size: 0.85rem; color: #7f8c8d; margin-bottom: 1.5rem; line-height: 1.6; }
.delete-modal-warning {
    background: #fff8e1; border: 1px solid #ffe082; border-radius: 10px;
    padding: 0.6rem 1rem; font-size: 0.78rem; color: #f39c12; font-weight: 600;
    margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;
}
.delete-modal-actions { display: flex; gap: 10px; }
.btn-cancel-modal {
    flex: 1; padding: 10px; border-radius: 12px; border: 1.5px solid #e0e0e0;
    background: #f8f9fa; color: #555; font-weight: 700; font-size: 0.85rem;
    cursor: pointer; transition: all 0.2s;
}
.btn-cancel-modal:hover { background: #e9ecef; border-color: #ccc; }
.btn-confirm-delete {
    flex: 1; padding: 10px; border-radius: 12px; border: none;
    background: linear-gradient(135deg, #c0392b, #e74c3c); color: white;
    font-weight: 700; font-size: 0.85rem; cursor: pointer;
    box-shadow: 0 4px 14px rgba(231,76,60,0.4); transition: all 0.2s;
}
.btn-confirm-delete:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(231,76,60,0.5); }

/* ===== Dark mode support ===== */
html[data-theme="dark"] .delete-modal { background: #1a1f2b !important; }
html[data-theme="dark"] .delete-modal h5 { color: #eef0f4 !important; }
html[data-theme="dark"] .delete-modal p { color: #9aa2b1 !important; }
html[data-theme="dark"] .delete-modal p strong { color: #eef0f4 !important; }
html[data-theme="dark"] .delete-modal-warning {
    background: rgba(243,156,18,0.12) !important;
    border-color: rgba(243,156,18,0.35) !important;
    color: #f5b041 !important;
}
html[data-theme="dark"] .delete-modal-icon {
    background: linear-gradient(135deg, rgba(231,76,60,0.18), rgba(231,76,60,0.28)) !important;
    border-color: rgba(231,76,60,0.45) !important;
}
html[data-theme="dark"] .btn-cancel-modal {
    background: #232a38 !important;
    border-color: rgba(255,255,255,0.15) !important;
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .btn-cancel-modal:hover {
    background: #2a3242 !important;
    border-color: rgba(255,255,255,0.28) !important;
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
</style>

<div class="delete-modal-overlay" id="bulkDeleteModalOverlay">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h5>Delete Selected Accounts?</h5>
        <p>You are about to permanently delete <strong id="bulkDeleteAccountCount">0</strong> account(s). This action cannot be undone.</p>
        <div class="delete-modal-warning">
            <i class="fas fa-exclamation-triangle"></i>
            This cannot be undone!
        </div>
        <div class="delete-modal-actions">
            <button class="btn-cancel-modal" onclick="closeBulkDeleteAccountsModal()">Cancel</button>
            <button class="btn-confirm-delete" id="confirmBulkDeleteAccountsBtn">
                <i class="fas fa-trash-alt"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid plain-page">

    <!-- Header -->
    <div class="res-header plain-banner d-flex align-items-center justify-content-between flex-wrap">
        <div>
            <h4 class="mb-1"><i class="fas fa-users mr-2"></i>Registered Accounts</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap mt-2 mt-md-0" style="gap:10px;">
            <a href="admn_manage_admins.php" class="btn btn-add-admin">
                <i class="fas fa-user-shield mr-1"></i> Manage Admins
            </a>
            <span class="total-badge">
                <i class="fas fa-user-check mr-1"></i>
                Total: <?= number_format(count($students)) ?>
            </span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="m-0 font-weight-bold" style="color:var(--edb-ink);">
                <i class="fas fa-table mr-1"></i> Student List
            </h6>
            <div class="d-flex align-items-center flex-wrap mt-2 mt-md-0" style="gap:10px;">
                <span id="selectedCount">0 selected</span>
                <button id="btnDeleteSelected" onclick="confirmBulkDelete()">
                    <i class="fas fa-trash-alt mr-1"></i> Delete Selected
                </button>
                <div class="search-wrap">
                    <input type="text" id="studentSearch" placeholder="&#128269; Search name, email...">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="enr-scroll">
                <table class="table table-hover mb-0 simple-table" id="studentTable">
                    <thead>
                        <tr>
                            <th class="th-check">
                                <input type="checkbox" id="selectAll" class="cb-row" title="Select All">
                            </th>
                            <th style="width:45px;">#</th>
                            <th>Full Name</th>
                            <th>Birthdate</th>
                            <th>Email / Phone</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody id="studentTbody">
                        <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No registered students found.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($students as $i => $r):
                            $mi       = !empty($r['mi']) ? ' ' . strtoupper($r['mi']) : '';
                            $fullname = strtoupper($r['lname']) . ', ' . ucwords(strtolower($r['fname'])) . $mi;
                            $contact  = !empty($r['email']) ? $r['email'] : ($r['phone_number'] ?? '—');
                            $bdate    = !empty($r['bdate']) ? date('M d, Y', strtotime($r['bdate'])) : '—';
                        ?>
                        <tr class="data-row">
                            <td class="text-center">
                                <input type="checkbox" class="cb-row cb-student" value="<?= $r['id_student'] ?>">
                            </td>
                            <td class="text-center text-muted"><?= $i + 1 ?></td>
                            <td class="font-weight-bold"><?= htmlspecialchars($fullname) ?></td>
                            <td><?= $bdate ?></td>
                            <td><?= htmlspecialchars($contact) ?></td>
                           
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted d-flex justify-content-between align-items-center py-2 flex-wrap" style="gap:10px;">
            <small id="entriesCount">Showing <strong id="visibleCount"><?= count($students) ?></strong> of <strong><?= count($students) ?></strong> entries</small>
            <div id="studentPagination" class="student-pagination"></div>
        </div>
    </div>

</div><!-- /.container-fluid -->

<!-- ======== PROMOTE MODAL ======== -->
<div class="modal fade" id="promoteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#155724,#1e7e34);">
                <h5 class="modal-title"><i class="fas fa-chalkboard-teacher mr-2"></i>Promote to Teacher / Staff</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="alert alert-success py-2 mb-3">
                        <i class="fas fa-user mr-1"></i>
                        Promoting: <strong id="promote_name_display"></strong>
                    </div>
                    <input type="hidden" name="id_student" id="promote_id_student">

                    <div class="form-group">
                        <label class="font-weight-bold small">Position <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm" name="position" required>
                            <option value="">— Select Position —</option>
                            <option value="Teacher I">Teacher I</option>
                            <option value="Teacher II">Teacher II</option>
                            <option value="Teacher III">Teacher III</option>
                            <option value="Master Teacher I">Master Teacher I</option>
                            <option value="Master Teacher II">Master Teacher II</option>
                            <option value="Head Teacher">Head Teacher</option>
                            <option value="Registrar">Registrar</option>
                            <option value="Guidance Counselor">Guidance Counselor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold small">Subject(s) Handled</label>
                        <input type="text" class="form-control form-control-sm" name="subject_handled" placeholder="e.g. Math, Science, English">
                        <small class="text-muted">Separate multiple subjects with commas</small>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold small">Assign as Adviser of Grade/Section</label>
                        <select class="form-control form-control-sm" name="adviser_grade">
                            <option value="">— Not an Adviser —</option>
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                            <option value="Grade 11 - STEM">Grade 11 - STEM</option>
                            <option value="Grade 11 - ABM">Grade 11 - ABM</option>
                            <option value="Grade 11 - GAS">Grade 11 - GAS</option>
                            <option value="Grade 11 - TVL-ICT">Grade 11 - TVL-ICT</option>
                            <option value="Grade 11 - TVL-HE">Grade 11 - TVL-HE</option>
                            <option value="Grade 12 - STEM">Grade 12 - STEM</option>
                            <option value="Grade 12 - ABM">Grade 12 - ABM</option>
                            <option value="Grade 12 - GAS">Grade 12 - GAS</option>
                            <option value="Grade 12 - TVL-ICT">Grade 12 - TVL-ICT</option>
                            <option value="Grade 12 - TVL-HE">Grade 12 - TVL-HE</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="promote_student" class="btn btn-success btn-sm">
                        <i class="fas fa-user-check mr-1"></i> Confirm Promotion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Populate promote modal
$(document).on('click', '.promote-btn', function() {
    const b = $(this);
    $('#promote_id_student').val(b.data('id'));
    $('#promote_name_display').text(b.data('name'));
});
</script>

<script>
// ── Select All ──────────────────────────────────────────────────────────────
document.getElementById('selectAll').addEventListener('change', function () {
    const visibleCheckboxes = [...document.querySelectorAll('#studentTbody tr')]
        .filter(r => r.style.display !== 'none')
        .map(r => r.querySelector('.cb-student'))
        .filter(Boolean);

    visibleCheckboxes.forEach(cb => {
        cb.checked = this.checked;
        cb.closest('tr').classList.toggle('row-selected', this.checked);
    });
    updateDeleteBar();
});

// ── Per-row checkbox ─────────────────────────────────────────────────────────
document.getElementById('studentTbody').addEventListener('change', function (e) {
    if (e.target.classList.contains('cb-student')) {
        e.target.closest('tr').classList.toggle('row-selected', e.target.checked);
        syncSelectAll();
        updateDeleteBar();
    }
});

function syncSelectAll() {
    const all     = [...document.querySelectorAll('.cb-student')].filter(cb => cb.closest('tr').style.display !== 'none');
    const checked = all.filter(cb => cb.checked);
    const sa      = document.getElementById('selectAll');
    sa.checked       = all.length > 0 && checked.length === all.length;
    sa.indeterminate = checked.length > 0 && checked.length < all.length;
}

function updateDeleteBar() {
    const count = document.querySelectorAll('.cb-student:checked').length;
    const btn   = document.getElementById('btnDeleteSelected');
    const lbl   = document.getElementById('selectedCount');
    if (count > 0) {
        btn.style.display = 'inline-block';
        lbl.style.display = 'inline';
        lbl.textContent   = count + ' selected';
    } else {
        btn.style.display = 'none';
        lbl.style.display = 'none';
    }
}

// ── Bulk delete ──────────────────────────────────────────────────────────────
let pendingDeleteIds = [];
function confirmBulkDelete() {
    const ids = [...document.querySelectorAll('.cb-student:checked')].map(cb => cb.value);
    if (ids.length === 0) return;
    pendingDeleteIds = ids;
    document.getElementById('bulkDeleteAccountCount').textContent = ids.length;
    document.getElementById('bulkDeleteModalOverlay').classList.add('show');
}
function closeBulkDeleteAccountsModal() {
    document.getElementById('bulkDeleteModalOverlay').classList.remove('show');
}
document.getElementById('bulkDeleteModalOverlay').addEventListener('click', function(e){ if (e.target === this) closeBulkDeleteAccountsModal(); });

document.getElementById('confirmBulkDeleteAccountsBtn').addEventListener('click', function () {
    const ids = pendingDeleteIds;
    closeBulkDeleteAccountsModal();
    if (!ids.length) return;

    showAdminLoading('Deleting ' + ids.length + ' account' + (ids.length > 1 ? 's' : '') + '...', 'trash');

    fetch('delete_bulk_students.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids: ids })
    })
    .then(r => r.json())
    .then(data => {
        hideAdminLoading();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: data.deleted + ' account(s) removed.',
                timer: 1800,
                showConfirmButton: false
            }).then(() => location.reload());
        } else {
            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
        }
    })
    .catch(() => {
        hideAdminLoading();
        Swal.fire('Error', 'Request failed. Please try again.', 'error');
    });
});

// ── Search + Pagination (15 per page) ──────────────────────────────────────
const ROWS_PER_PAGE = 15;
let currentPage = 1;

function getDataRows() {
    return Array.from(document.querySelectorAll('#studentTbody tr.data-row'));
}

function pageButtons(current, total) {
    const pages = [];
    const delta = 1;
    for (let i = 1; i <= total; i++) {
        if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) {
            pages.push(i);
        } else if (pages[pages.length - 1] !== '...') {
            pages.push('...');
        }
    }
    return pages;
}

function renderPagination(totalMatches, totalPages) {
    const el = document.getElementById('studentPagination');
    if (!el) return;
    if (totalPages <= 1) { el.innerHTML = ''; return; }

    let html = '<button type="button" class="page-btn" ' + (currentPage === 1 ? 'disabled' : '') +
        ' onclick="goToPage(' + (currentPage - 1) + ')" aria-label="Previous page">&laquo;</button>';

    pageButtons(currentPage, totalPages).forEach(p => {
        if (p === '...') {
            html += '<span class="page-ellipsis">&hellip;</span>';
        } else {
            html += '<button type="button" class="page-btn' + (p === currentPage ? ' active' : '') +
                '" onclick="goToPage(' + p + ')">' + p + '</button>';
        }
    });

    html += '<button type="button" class="page-btn" ' + (currentPage === totalPages ? 'disabled' : '') +
        ' onclick="goToPage(' + (currentPage + 1) + ')" aria-label="Next page">&raquo;</button>';

    el.innerHTML = html;
}

function applyFilterAndPaginate() {
    const query = document.getElementById('studentSearch').value.toLowerCase().trim();
    const allRows = getDataRows();
    const matched = allRows.filter(row => row.innerText.toLowerCase().includes(query));

    const totalPages = Math.max(1, Math.ceil(matched.length / ROWS_PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * ROWS_PER_PAGE;
    const end = start + ROWS_PER_PAGE;

    allRows.forEach(row => { row.style.display = 'none'; });
    matched.slice(start, end).forEach(row => { row.style.display = ''; });

    const entriesEl = document.getElementById('entriesCount');
    if (matched.length === 0) {
        entriesEl.innerHTML = 'No matching entries';
    } else {
        entriesEl.innerHTML = 'Showing <strong>' + (start + 1) + '&ndash;' + Math.min(end, matched.length) +
            '</strong> of <strong>' + matched.length + '</strong> entries';
    }

    renderPagination(matched.length, totalPages);
    syncSelectAll();
}

function goToPage(p) {
    currentPage = p;
    applyFilterAndPaginate();
}

document.getElementById('studentSearch').addEventListener('keyup', function () {
    currentPage = 1;
    applyFilterAndPaginate();
});

applyFilterAndPaginate();
</script>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>