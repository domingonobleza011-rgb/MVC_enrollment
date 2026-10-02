
<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
    .archive-badge {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 20px;
    }
    .table th { font-size: 13px; }
    .table td { font-size: 13px; vertical-align: middle; }
    .grade-filter-btn {
        border-radius: 20px;
        margin: 0 3px 6px 0;
        font-size: 13px;
    }
    .archive-header {
        padding: 18px 24px;
    }
    .archive-header .badge {
        background: rgba(var(--edb-chart-rgb), 0.08);
        color: var(--edb-ink) !important;
        border: 1px solid var(--edb-border);
    }
    .empty-archive {
        text-align: center;
        padding: 60px 20px;
        color: #aaa;
    }
    .empty-archive i { font-size: 60px; margin-bottom: 16px; color: #ccc; }
    /* Bulk action toolbar */
    .bulk-toolbar {
        display: none;
        align-items: center;
        gap: 10px;
        background: rgba(var(--edb-chart-rgb), 0.06);
        border: 1.5px solid rgba(var(--edb-chart-rgb), 0.25);
        border-radius: 10px;
        padding: 10px 16px;
        margin-bottom: 12px;
        font-size: 13px;
        font-weight: 600;
        color: var(--edb-ink);
        flex-wrap: wrap;
    }
    .bulk-toolbar.show { display: flex; }
    .bulk-toolbar .selected-count { margin-right: auto; }
    .btn-bulk-restore {
        padding: 7px 16px;
        border-radius: 10px;
        border: 1.5px solid #27ae60;
        background: rgba(39,174,96,0.1);
        color: #27ae60;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-bulk-restore:hover { background: #27ae60; color: white; }
    .btn-bulk-delete {
        padding: 7px 16px;
        border-radius: 10px;
        border: 1.5px solid #e74c3c;
        background: rgba(231,76,60,0.08);
        color: #e74c3c;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-bulk-delete:hover { background: #e74c3c; color: white; }
    .row-checkbox { cursor: pointer; width: 16px; height: 16px; accent-color: rgb(var(--edb-chart-rgb)); }
    #selectAllChk { cursor: pointer; width: 16px; height: 16px; accent-color: rgb(var(--edb-chart-rgb)); }
    .delete-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10, 20, 40, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.delete-modal-overlay.show {
    display: flex;
}
.delete-modal {
    background: #fff;
    border-radius: 20px;
    padding: 2rem;
    max-width: 380px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: popIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-align: center;
}
@keyframes popIn {
    from { transform: scale(0.8); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}
.delete-modal-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #fff0f0, #ffe0e0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.2rem;
    border: 3px solid #f5c6c6;
}
.delete-modal-icon i {
    font-size: 1.8rem;
    color: #e74c3c;
}
.delete-modal h5 {
    font-family: 'Segoe UI', sans-serif;
    font-weight: 800;
    font-size: 1.15rem;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}
.delete-modal p {
    font-size: 0.85rem;
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}
.delete-modal-warning {
    background: #fff8e1;
    border: 1px solid #ffe082;
    border-radius: 10px;
    padding: 0.6rem 1rem;
    font-size: 0.78rem;
    color: #f39c12;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.delete-modal-actions {
    display: flex;
    gap: 10px;
}
.btn-cancel-modal {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: 1.5px solid #e0e0e0;
    background: #f8f9fa;
    color: #555;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel-modal:hover {
    background: #e9ecef;
    border-color: #ccc;
}
.btn-confirm-delete {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #c0392b, #e74c3c);
    color: white;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(231,76,60,0.4);
    transition: all 0.2s;
}
.btn-confirm-delete:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(231,76,60,0.5);
}
.restore-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10, 20, 40, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.restore-modal-overlay.show {
    display: flex;
}
.restore-modal {
    background: #fff;
    border-radius: 20px;
    padding: 2rem;
    max-width: 380px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: popIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-align: center;
}
.restore-modal-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #eafaf1, #d5f5e3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.2rem;
    border: 3px solid #a9dfbf;
}
.restore-modal-icon i {
    font-size: 1.8rem;
    color: #27ae60;
}
.restore-modal h5 {
    font-family: 'Segoe UI', sans-serif;
    font-weight: 800;
    font-size: 1.15rem;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}
.restore-modal p {
    font-size: 0.85rem;
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}
.restore-modal-info {
    background: #eafaf1;
    border: 1px solid #a9dfbf;
    border-radius: 10px;
    padding: 0.6rem 1rem;
    font-size: 0.78rem;
    color: #27ae60;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.restore-modal-actions {
    display: flex;
    gap: 10px;
}
.btn-cancel-restore {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: 1.5px solid #e0e0e0;
    background: #f8f9fa;
    color: #555;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel-restore:hover {
    background: #e9ecef;
    border-color: #ccc;
}
.btn-confirm-restore {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #1e8449, #27ae60);
    color: white;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(39,174,96,0.4);
    transition: all 0.2s;
}
.btn-confirm-restore:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(39,174,96,0.5);
}

/* ===== Dark mode support for restore/delete modals ===== */
html[data-theme="dark"] .restore-modal,
html[data-theme="dark"] .delete-modal {
    background: #1a1f2b !important;
}
html[data-theme="dark"] .restore-modal h5,
html[data-theme="dark"] .delete-modal h5 {
    color: #eef0f4 !important;
}
html[data-theme="dark"] .restore-modal p,
html[data-theme="dark"] .delete-modal p {
    color: #9aa2b1 !important;
}
html[data-theme="dark"] .restore-modal p strong,
html[data-theme="dark"] .delete-modal p strong {
    color: #eef0f4 !important;
}
html[data-theme="dark"] .delete-modal .form-group label {
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .delete-modal textarea.form-control {
    background-color: #232a38 !important;
    border-color: rgba(255,255,255,0.15) !important;
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .delete-modal textarea.form-control::placeholder {
    color: rgba(215,219,226,0.4) !important;
}
html[data-theme="dark"] .restore-modal-info {
    background: rgba(39,174,96,0.12) !important;
    border-color: rgba(39,174,96,0.35) !important;
    color: #6fcf97 !important;
}
html[data-theme="dark"] .delete-modal-warning {
    background: rgba(243,156,18,0.12) !important;
    border-color: rgba(243,156,18,0.35) !important;
    color: #f5b041 !important;
}
html[data-theme="dark"] .restore-modal-icon {
    background: linear-gradient(135deg, rgba(39,174,96,0.18), rgba(39,174,96,0.28)) !important;
    border-color: rgba(39,174,96,0.45) !important;
}
html[data-theme="dark"] .delete-modal-icon {
    background: linear-gradient(135deg, rgba(231,76,60,0.18), rgba(231,76,60,0.28)) !important;
    border-color: rgba(231,76,60,0.45) !important;
}
html[data-theme="dark"] .btn-cancel-restore,
html[data-theme="dark"] .btn-cancel-modal {
    background: #232a38 !important;
    border-color: rgba(255,255,255,0.15) !important;
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .btn-cancel-restore:hover,
html[data-theme="dark"] .btn-cancel-modal:hover {
    background: #2a3242 !important;
    border-color: rgba(255,255,255,0.28) !important;
}
</style>

<!-- Begin Page Content -->
<div class="container-fluid plain-page">

    <!-- Page Heading -->
    <div class="archive-header plain-banner d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-1"><i class="fas fa-archive mr-2"></i>Archive</h4>
            <small class="opacity-75">Recently archived enrollment records. Restore or permanently delete them.</small>
        </div>
        <span class="badge badge-light text-dark px-3 py-2" style="font-size:14px;">
            <?= count($all_archived) ?> Record<?= count($all_archived) != 1 ? 's' : '' ?>
        </span>
    </div>

    <!-- Filters Row -->
    <div class="card shadow mb-4">
        <div class="card-body pb-2">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2">
                    <strong class="mr-2">Filter by Grade:</strong>
                    <?php
                    $grades = ['all' => 'All Grades', 'seven' => 'Grade 7', 'eight' => 'Grade 8',
                               'nine' => 'Grade 9', 'ten' => 'Grade 10', 'eleven' => 'Grade 11', 'twelve' => 'Grade 12'];
                    foreach ($grades as $val => $label):
                        $active = ($filter_grade === $val) ? 'btn-primary' : 'btn-outline-primary';
                    ?>
                        <a href="admn_archive.php?grade=<?= $val ?>&keyword=<?= urlencode($keyword) ?>"
                           class="btn btn-sm <?= $active ?> grade-filter-btn"><?= $label ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-6 mb-2">
                    <form method="GET" action="admn_archive.php" class="d-flex">
                        <input type="hidden" name="grade" value="<?= htmlspecialchars($filter_grade) ?>">
                        <input type="search" name="keyword" class="form-control form-control-sm mr-2"
                               placeholder="Search by name or LRN..." value="<?= htmlspecialchars($keyword) ?>">
                        <button class="btn btn-sm btn-success" type="submit">Search</button>
                        <?php if ($keyword): ?>
                            <a href="admn_archive.php?grade=<?= $filter_grade ?>" class="btn btn-sm btn-secondary ml-1">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Archive Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list mr-1"></i> Archived Records
            </h6>
        </div>
        <div class="card-body p-0">
            <?php
            // Apply filters
            $display_records = array_filter($all_archived, function($row) use ($filter_grade, $keyword) {
                $grade_match = ($filter_grade === 'all') || ($row['grade_table'] === $filter_grade);
                if (!$grade_match) return false;
                if ($keyword) {
                    $searchable = strtolower(
                        ($row['lname'] ?? '') . ' ' . ($row['fname'] ?? '') . ' ' .
                        ($row['mi'] ?? '') . ' ' . ($row['lrn'] ?? '')
                    );
                    return strpos($searchable, $keyword) !== false;
                }
                return true;
            });
            ?>

            <?php if (empty($display_records)): ?>
                <div class="empty-archive">
                    <i class="fas fa-inbox d-block"></i>
                    <h5>No archived records found</h5>
                    <p>Records you archive from the grade enrollment pages will appear here.</p>
                </div>
            <?php else: ?>
                <!-- Bulk Action Form wraps the whole table -->
                <form method="POST" id="bulkForm">
                    <!-- Bulk Toolbar -->
                    <div class="bulk-toolbar px-3 pt-3" id="bulkToolbar">
                        <span class="selected-count"><i class="fas fa-check-square mr-1"></i><span id="selectedCount">0</span> record(s) selected</span>
                        <button type="button" class="btn-bulk-restore" onclick="openBulkRestoreModal()">
                            <i class="fas fa-undo mr-1"></i> Restore Selected
                        </button>
                        <button type="button" class="btn-bulk-delete" onclick="openBulkDeleteModal()">
                            <i class="fas fa-trash-alt mr-1"></i> Delete Selected
                        </button>
                    </div>

                    <div class="enr-scroll">
                        <table class="table table-hover mb-0 simple-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllChk" title="Select All"></th>
                                    <th>#</th>
                                    <th>Grade</th>
                                    <th>LRN</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>M.I.</th>
                                    <th>School Year</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                    <th>Archived At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $ctr = 1; foreach ($display_records as $row): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-checkbox"
                                               name="selected_records[]"
                                               value="<?= $row['grade_table'] . ':' . $row['record_id'] ?>">
                                    </td>
                                    <td><?= $ctr++ ?></td>
                                    <td>
                                        <span class="badge badge-primary archive-badge">
                                            <?= htmlspecialchars($row['grade_label']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($row['lrn'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['lname'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['fname'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['mi'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['sy'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['sex'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['age'] ?? '') ?></td>
                                    <td>
                                        <?php if (!empty($row['archived_at'])): ?>
                                            <small class="text-muted">
                                                <?= date('M d, Y g:i A', strtotime($row['archived_at'])) ?>
                                            </small>
                                        <?php else: ?>
                                            <small class="text-muted">—</small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php $gt = $row['grade_table']; $rid = $row['record_id']; ?>
                                        <div class="dropdown row-actions">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                                id="archDd<?= $gt . $rid ?>" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right row-actions-menu" aria-labelledby="archDd<?= $gt . $rid ?>">
                                                <!-- Single Restore -->
                                                <form method="POST">
                                                    <input type="hidden" name="id_<?= $gt ?>" value="<?= $rid ?>">
                                                    <button type="button" class="dropdown-item item-restore"
                                                        onclick="openRestoreModal(this, '<?= strtoupper(substr($gt,0,1)).substr($gt,1) ?>')">
                                                        <i class="fas fa-undo"></i>Restore
                                                    </button>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                <!-- Single Permanent Delete -->
                                                <form method="POST">
                                                    <input type="hidden" name="grade_table" value="<?= $gt ?>">
                                                    <input type="hidden" name="record_id" value="<?= $rid ?>">
                                                    <button type="button" class="dropdown-item item-reject"
                                                        onclick="openDeleteModal(this)">
                                                        <i class="fas fa-trash-alt"></i>Delete permanently
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form><!-- end bulkForm -->
            <?php endif; ?>
        </div>
        <?php if (!empty($display_records)): ?>
        <div class="card-footer text-muted small">
            Showing <?= count($display_records) ?> archived record<?= count($display_records) != 1 ? 's' : '' ?>.
            Restoring a record moves it back to its original grade enrollment list.
        </div>
        <?php endif; ?>
    </div>

</div>
<div class="delete-modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h5>Delete Permanently?</h5>
        <p>You are about to permanently remove this record from the system. This action is irreversible.</p>
        <div class="delete-modal-warning">
            <i class="fas fa-exclamation-triangle"></i>
            This cannot be undone!
        </div>
        <div class="delete-modal-actions">
            <button class="btn-cancel-modal" onclick="closeDeleteModal()">
                Cancel
            </button>
            <button class="btn-confirm-delete" id="confirmDeleteBtn">
                <i class="fas fa-trash-alt"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- BULK Delete Modal -->
<div class="delete-modal-overlay" id="bulkDeleteModalOverlay">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h5>Delete Selected Records?</h5>
        <p>You are about to permanently delete <strong id="bulkDeleteCount">0</strong> selected record(s). This action is irreversible.</p>
        <div class="delete-modal-warning">
            <i class="fas fa-exclamation-triangle"></i>
            This cannot be undone!
        </div>
        <div class="delete-modal-actions">
            <button class="btn-cancel-modal" onclick="closeBulkDeleteModal()">Cancel</button>
            <button class="btn-confirm-delete" id="confirmBulkDeleteBtn">
                <i class="fas fa-trash-alt"></i> Yes, Delete All
            </button>
        </div>
    </div>
</div>

<div class="restore-modal-overlay" id="restoreModalOverlay">
    <div class="restore-modal">
        <div class="restore-modal-icon">
            <i class="fas fa-undo"></i>
        </div>
        <h5>Restore Record?</h5>
        <p>You are about to restore this record back to <strong id="restoreGradeLabel"></strong>. The record will be active again.</p>
        <div class="restore-modal-info">
            <i class="fas fa-check-circle"></i>
            This record will be fully recovered!
        </div>
        <div class="restore-modal-actions">
            <button class="btn-cancel-restore" onclick="closeRestoreModal()">
                Cancel
            </button>
            <button class="btn-confirm-restore" id="confirmRestoreBtn">
                <i class="fas fa-undo"></i> Yes, Restore
            </button>
        </div>
    </div>
</div>

<!-- BULK Restore Modal -->
<div class="restore-modal-overlay" id="bulkRestoreModalOverlay">
    <div class="restore-modal">
        <div class="restore-modal-icon">
            <i class="fas fa-undo"></i>
        </div>
        <h5>Restore Selected Records?</h5>
        <p>You are about to restore <strong id="bulkRestoreCount">0</strong> selected record(s) back to their original grade enrollment lists.</p>
        <div class="restore-modal-info">
            <i class="fas fa-check-circle"></i>
            All selected records will be fully recovered!
        </div>
        <div class="restore-modal-actions">
            <button class="btn-cancel-restore" onclick="closeBulkRestoreModal()">Cancel</button>
            <button class="btn-confirm-restore" id="confirmBulkRestoreBtn">
                <i class="fas fa-undo"></i> Yes, Restore All
            </button>
        </div>
    </div>
</div>

<script>
// ── Single restore ──────────────────────────────────────────
let restoreTargetForm = null;
function openRestoreModal(btn, gradeLabel) {
    restoreTargetForm = btn.closest('form');
    document.getElementById('restoreGradeLabel').textContent = 'Grade ' + gradeLabel;
    document.getElementById('restoreModalOverlay').classList.add('show');
}
function closeRestoreModal() {
    document.getElementById('restoreModalOverlay').classList.remove('show');
    restoreTargetForm = null;
}
document.getElementById('confirmRestoreBtn').addEventListener('click', function () {
    if (restoreTargetForm) {
        const gt = restoreTargetForm.querySelector('input[type=hidden]').name.replace('id_','');
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'restore_' + gt; inp.value = '1';
        restoreTargetForm.appendChild(inp);
        restoreTargetForm.submit();
    }
    closeRestoreModal();
});
document.getElementById('restoreModalOverlay').addEventListener('click', function(e){ if(e.target===this) closeRestoreModal(); });

// ── Single delete ───────────────────────────────────────────
let targetForm = null;
function openDeleteModal(btn) {
    targetForm = btn.closest('form');
    document.getElementById('deleteModalOverlay').classList.add('show');
}
function closeDeleteModal() {
    document.getElementById('deleteModalOverlay').classList.remove('show');
    targetForm = null;
}
document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (targetForm) {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'permanent_delete'; inp.value = '1';
        targetForm.appendChild(inp);
        targetForm.submit();
    }
    closeDeleteModal();
});
document.getElementById('deleteModalOverlay').addEventListener('click', function(e){ if(e.target===this) closeDeleteModal(); });

// ── Select All / checkbox logic ─────────────────────────────
const selectAllChk = document.getElementById('selectAllChk');
const bulkToolbar  = document.getElementById('bulkToolbar');
const countSpan    = document.getElementById('selectedCount');

function getChecked() {
    return document.querySelectorAll('.row-checkbox:checked');
}
function updateToolbar() {
    const n = getChecked().length;
    countSpan.textContent = n;
    if (n > 0) bulkToolbar.classList.add('show');
    else        bulkToolbar.classList.remove('show');
    // sync select-all indeterminate state
    const all = document.querySelectorAll('.row-checkbox');
    selectAllChk.checked       = n === all.length;
    selectAllChk.indeterminate = n > 0 && n < all.length;
}

if (selectAllChk) {
    selectAllChk.addEventListener('change', function () {
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
        updateToolbar();
    });
}
document.querySelectorAll('.row-checkbox').forEach(cb => {
    cb.addEventListener('change', updateToolbar);
});

// ── Bulk Restore ────────────────────────────────────────────
function openBulkRestoreModal() {
    document.getElementById('bulkRestoreCount').textContent = getChecked().length;
    document.getElementById('bulkRestoreModalOverlay').classList.add('show');
}
function closeBulkRestoreModal() {
    document.getElementById('bulkRestoreModalOverlay').classList.remove('show');
}
document.getElementById('confirmBulkRestoreBtn').addEventListener('click', function () {
    const inp = document.createElement('input');
    inp.type = 'hidden'; inp.name = 'bulk_restore'; inp.value = '1';
    document.getElementById('bulkForm').appendChild(inp);
    document.getElementById('bulkForm').submit();
    closeBulkRestoreModal();
});
document.getElementById('bulkRestoreModalOverlay').addEventListener('click', function(e){ if(e.target===this) closeBulkRestoreModal(); });

// ── Bulk Delete ─────────────────────────────────────────────
function openBulkDeleteModal() {
    document.getElementById('bulkDeleteCount').textContent = getChecked().length;
    document.getElementById('bulkDeleteModalOverlay').classList.add('show');
}
function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModalOverlay').classList.remove('show');
}
document.getElementById('confirmBulkDeleteBtn').addEventListener('click', function () {
    const inp = document.createElement('input');
    inp.type = 'hidden'; inp.name = 'bulk_delete'; inp.value = '1';
    document.getElementById('bulkForm').appendChild(inp);
    document.getElementById('bulkForm').submit();
    closeBulkDeleteModal();
});
document.getElementById('bulkDeleteModalOverlay').addEventListener('click', function(e){ if(e.target===this) closeBulkDeleteModal(); });

// ── Escape key closes any open modal ───────────────────────
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRestoreModal(); closeDeleteModal();
        closeBulkRestoreModal(); closeBulkDeleteModal();
    }
});
</script>
<!-- /.container-fluid -->

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>