<?php require MODELS_PATH . '/conn.php'; require_once MODELS_PATH . '/ai_review_ui.php'; ?>

<!-- ===== DOCUMENT VIEWER MODAL (Facebook-story style) ===== -->
<div class="modal fade plain-modal" id="docViewerModal" tabindex="-1" role="dialog" aria-labelledby="docViewerTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header">
                <h5 class="modal-title" id="docViewerTitle">
                    <i class="fas fa-file"></i>&nbsp;<span id="docViewerTitleText">Document Preview</span>
                    <span id="docViewerCounter" class="ml-2 small font-weight-normal" style="opacity:.8;"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="docViewerSegments" class="d-flex" style="gap:4px;padding:8px 12px 0;background:#f8f9fa;"></div>
            <div class="modal-body text-center p-3 position-relative" id="docViewerBody" style="min-height:300px;background:#f8f9fa;">
                <button type="button" id="docViewerPrev" class="doc-nav-btn doc-nav-prev" onclick="prevDocViewer()" aria-label="Previous document">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div id="docViewerContent"><p class="text-muted pt-5">Loading...</p></div>
                <button type="button" id="docViewerNext" class="doc-nav-btn doc-nav-next" onclick="nextDocViewer()" aria-label="Next document">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius:20px;">Close</button>
            </div>
        </div>
    </div>
</div>
<button id="docViewerRelay" data-toggle="modal" data-target="#docViewerModal" style="display:none;"></button>

<!-- ===== APPROVE CONFIRM MODAL ===== -->
<div class="approve-modal-overlay" id="approveModalOverlay_eleven">
    <div class="approve-modal">
        <div class="approve-modal-icon">
            <i class="fas fa-check"></i>
        </div>
        <h5>Approve Enrollment?</h5>
        <p>You are about to approve <strong id="approveStudentName_eleven"></strong>'s enrollment.</p>
        <div class="approve-modal-info">
            <i class="fas fa-envelope"></i>
            An email notification will be sent to the student.
        </div>
        <div class="approve-modal-actions">
            <button type="button" class="btn-cancel-approve" onclick="closeApproveModal_eleven()">Cancel</button>
            <button type="button" class="btn-confirm-approve" id="confirmApproveBtn_eleven">
                <i class="fas fa-check"></i> Yes, Approve
            </button>
        </div>
    </div>
</div>

<!-- ===== REJECT REASON MODAL ===== -->
<div class="reject-modal-overlay" id="rejectModalOverlay_eleven">
    <div class="reject-modal">
        <div class="reject-modal-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <h5>Reject Enrollment?</h5>
        <p>Student: <strong id="rejectStudentName"></strong></p>
        <div class="reject-modal-warning">
            <i class="fas fa-envelope"></i>
            An email notification will be sent to the student.
        </div>
        <form id="rejectForm" action="" method="POST">
            <input type="hidden" name="id_eleven" id="rejectIdEleven" value="">
            <div class="form-group">
                <label for="reject_reason">Reason for Rejection <span class="text-muted" style="font-weight:400;">(optional)</span></label>
                <textarea class="form-control" id="reject_reason" name="reject_reason" rows="3"
                    placeholder="e.g. Incomplete documents, does not meet age requirement..."></textarea>
            </div>
            <div class="reject-modal-actions">
                <button type="button" class="btn-cancel-reject-modal" onclick="closeRejectModal_eleven()">Cancel</button>
                <button type="submit" name="reject_eleven" class="btn-confirm-reject-modal">
                    <i class="fas fa-times-circle"></i> Confirm Reject
                </button>
            </div>
        </form>
    </div>
</div>

<style>
#docViewerBody img { max-width:100%;max-height:68vh;border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,.15);object-fit:contain; }
.doc-nav-btn {
    position:absolute; top:50%; transform:translateY(-50%);
    width:40px; height:40px; border-radius:50%; border:none;
    background:rgba(0,0,0,.35); color:#fff; font-size:16px;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:background .15s; z-index:5;
}
.doc-nav-btn:hover { background:rgba(0,0,0,.6); }
.doc-nav-prev { left:10px; }
.doc-nav-next { right:10px; }
#docViewerSegments .doc-segment { flex:1; height:3px; border-radius:2px; background:#e5e7eb; overflow:hidden; }
#docViewerSegments .doc-segment.active { background:#374151; }
#docViewerBody iframe { width:100%;height:68vh;border:none;border-radius:8px; }
.doc-preview-btn { display:inline-block;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;vertical-align:middle;cursor:pointer;transition:transform .15s,box-shadow .15s; }
.doc-preview-btn:hover { transform:scale(1.04);box-shadow:0 3px 10px rgba(42,111,156,.3); }
.doc-unsupported { padding:50px 20px;color:#6c757d; }
.doc-unsupported .big-icon { font-size:3rem;display:block;margin-bottom:12px;color:#adb5bd; }
.status-badge { font-size:.72rem;padding:.15rem .55rem;border-radius:10px;font-weight:600;display:inline-block;white-space:nowrap; }
.status-pending  { background:#fff3cd;color:#856404; }
.status-approved { background:#d4edda;color:#155724; }
.status-rejected { background:#f8d7da;color:#721c24; }
.status-waitlisted { background:#e2e3ff;color:#3730a3; }

/* ===== Enrollees table: simple, compact, scrollable ===== */
.modern-card { border:1px solid #e3e6ec; border-radius:8px; overflow:hidden; }
.modern-card .card-header { border:0; padding:.5rem .85rem; }

/* Scroll box: scrolls sideways and down; the header row stays pinned while scrolling. */
.enr-scroll { overflow:auto; max-height:70vh; -webkit-overflow-scrolling:touch; }

#studentsTable { width:100%; margin:0 !important; font-size:.82rem; white-space:nowrap; }
#studentsTable thead th {
    position:sticky; top:0; z-index:2;
    padding:.5rem 1.5rem .5rem .75rem; vertical-align:middle;
    background:#f8f9fc; color:#5a5c69;
    font-size:.78rem; font-weight:700;
    border:0; border-bottom:1px solid #e3e6ec;
}
#studentsTable tbody td { padding:.4rem .75rem; vertical-align:middle; border:0; border-bottom:1px solid #eef0f4; }
html:not([data-theme="dark"]) #studentsTable tbody td { color:#2d3142; }

/* One line per row: no stacked badge + link inside a cell. */
#studentsTable tbody > tr > td > br { display:none; }
#studentsTable td > .btn-sm,
#studentsTable .row-actions > .btn-sm { padding:.15rem .5rem; font-size:.75rem; }
#studentsTable td > .btn.mt-1 { margin-top:0 !important; margin-left:.35rem; }
#studentsTable td > .ai-badge { font-size:.72rem; padding:.15rem .55rem; border-radius:10px; border:0; white-space:nowrap; }
/* Modals are rendered inside cells; they must wrap text normally. */
#studentsTable .modal { white-space:normal; }

/* ===== DataTables pagination (bottom of #studentsTable), theme-aware ===== */
.dataTables_wrapper .dataTables_paginate { padding-top:.6rem; text-align:right; }
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding:.25rem .65rem; margin-left:3px; border-radius:6px; border:1px solid #e3e6ec;
    background:#fff; color:#2d3142 !important; font-size:.78rem; cursor:pointer;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
    background:#f0f2f7; border-color:#d7dbe2; color:#2d3142 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background:#0b2b5c; border-color:#0b2b5c; color:#fff !important; font-weight:700;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
    opacity:.4; cursor:not-allowed;
}
html[data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button {
    background:#1e2432; border-color:#2c3446; color:#fff !important;
}
html[data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
    background:#262e3f; border-color:#3a4459; color:#fff !important;
}
html[data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background:#3b6fd6; border-color:#3b6fd6; color:#fff !important;
}

/* ===== Row "Actions" dropdown: a plain Bootstrap dropdown =====
   The script further down floats the open menu (position:fixed) so the scroll
   box can't clip it, and adds .is-dropup when it has to open upward. */
.row-actions { display:inline-block; }
.row-actions-menu { min-width:10rem; padding:.25rem 0; font-size:.82rem; text-align:left; }
.row-actions-menu form { margin:0; }
.row-actions-menu .dropdown-item { padding:.35rem .9rem; }
.row-actions-menu .dropdown-item i { width:1.25em; margin-right:.4rem; text-align:center; }
.row-actions-menu .dropdown-divider { margin:.25rem 0; }
.row-actions-menu .dropdown-item.item-reject { color:#dc3545; }
html[data-theme="dark"] .row-actions-menu .dropdown-item.item-reject { color:#f28b82 !important; }
.row-actions-menu.is-floating { position:fixed; margin:0; transform:none; z-index:1030; overflow-y:auto; }
.row-actions.is-dropup > .dropdown-toggle::after { border-top:0; border-bottom:.3em solid; }

/* ===== Edit modal: plain, compact ===== */
.edit-student-body { max-height:70vh; overflow-y:auto; padding:.9rem 1.1rem; }
.edit-student-body .form-group { margin-bottom:.6rem; }
.edit-student-body .form-control { text-align:left; }
.edit-student-body label { font-size:.78rem; font-weight:600; margin-bottom:.15rem; }
.edit-section-title {
    font-size:.75rem; text-transform:uppercase; letter-spacing:.04em;
    color:var(--edb-ink); font-weight:700; margin:16px 0 8px;
    padding-bottom:4px; border-bottom:1px solid var(--edb-border);
}
.edit-section-title:first-child { margin-top:0; }
html[data-theme="dark"] .modal-header .close { color:#ffffff; text-shadow:none; opacity:.85; }


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
.reject-modal-warning {
    background: #fff8e1; border: 1px solid #ffe082; border-radius: 10px;
    padding: 0.6rem 1rem; font-size: 0.78rem; color: #f39c12; font-weight: 600;
    margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px; text-align: left;
}
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

/* ===== Dark mode support for approve/reject modals ===== */
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
html[data-theme="dark"] .reject-modal-warning {
    background: rgba(243,156,18,0.12) !important;
    border-color: rgba(243,156,18,0.35) !important;
    color: #f5b041 !important;
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

<?php

function resolveDocLabel_eleven($fileName, $aiDocsByFile, $index) {
    if (isset($aiDocsByFile[$fileName])) {
        $type = $aiDocsByFile[$fileName]['detected_type'] ?? '';
        if ($type !== '' && $type !== 'Other / Unclear' && $type !== 'Unreadable') {
            return $type;
        }
    }
    $base = strtolower($fileName);
    if (strpos($base, 'psa') !== false || strpos($base, 'birth') !== false) return 'PSA Birth Certificate';
    if (strpos($base, 'brigada') !== false) return 'Brigada Eskwela Commitment Slip';
    if (strpos($base, '137') !== false || strpos($base, 'reportcard') !== false || strpos($base, 'report_card') !== false) return 'Form 137 / Report Card';
    if (strpos($base, 'goodmoral') !== false || strpos($base, 'good_moral') !== false || strpos($base, 'moral') !== false) return 'Good Moral Certificate';
    if (strpos($base, 'completion') !== false) return 'Certificate of Completion';
    if (strpos($base, '4ps') !== false || strpos($base, 'pantawid') !== false) return '4Ps / Pantawid Pamilya Certificate';
    if (strpos($base, 'indigenous') !== false || strpos($base, '_ip_') !== false) return 'Indigenous People (IP) Certificate';
    return 'Document ' . ($index + 1);
}

function renderDocs_eleven($docsJson, $groupKey, $aiAnalysisJson = null) {
    $docs = json_decode($docsJson ?? '[]', true);
    if (is_array($docs) && array_key_exists('admin_marked', $docs)) {
        if ($docs['admin_marked'] === 'Incomplete') {
            echo '<span class="badge badge-warning" title="' . htmlspecialchars($docs['note'] ?? '') . '"><i class="fas fa-exclamation-triangle mr-1"></i>Incomplete</span>';
            if (!empty($docs['note'])) echo '<br><span class="text-muted small">' . htmlspecialchars($docs['note']) . '</span>';
        } else {
            echo '<span class="badge badge-success"><i class="fas fa-check mr-1"></i>Complete (added by admin)</span>';
        }
        return;
    }
    if (empty($docs)) { echo '<span class="text-muted small">No documents</span>'; return; }

    $ai = $aiAnalysisJson ? json_decode($aiAnalysisJson, true) : null;
    $aiDocsByFile = [];
    if (!empty($ai['documents']) && is_array($ai['documents'])) {
        foreach ($ai['documents'] as $d) {
            if (!empty($d['file'])) $aiDocsByFile[basename($d['file'])] = $d;
        }
    }

    $items = [];
    foreach ($docs as $i => $docPath) {
        $fileName = basename($docPath);
        $ext   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $isImg = in_array($ext, ['jpg','jpeg','png','gif','webp']);
        $isPdf = $ext === 'pdf';
        $items[] = [
            'path' => $docPath,
            'name' => resolveDocLabel_eleven($fileName, $aiDocsByFile, $i),
            'type' => $isImg ? 'image' : ($isPdf ? 'pdf' : 'doc'),
        ];
    }

    echo '<script>(window.__docGroups=window.__docGroups||{})[' . json_encode($groupKey) . ']=' . json_encode($items) . ';</script>';

    echo '<button type="button" class="btn btn-outline-primary btn-sm doc-view-btn"
            onclick="openDocViewer(\''.addslashes($groupKey).'\', 0)">
            <i class="fas fa-folder-open mr-1"></i> View (' . count($items) . ')
          </button>';
}

function renderStatus_eleven($status) {
    $status = $status ?: 'Pending';
    $cls = ['Approved'=>'status-approved','Rejected'=>'status-rejected','Pending'=>'status-pending','Waitlisted'=>'status-waitlisted'];
    $ico = ['Approved'=>'fa-check-circle','Rejected'=>'fa-times-circle','Pending'=>'fa-clock','Waitlisted'=>'fa-hourglass-half'];
    $c   = $cls[$status] ?? 'status-pending';
    $i   = $ico[$status] ?? 'fa-clock';
    echo '<span class="status-badge '.$c.'"><i class="fas '.$i.' mr-1"></i>'.htmlspecialchars($status).'</span>';
}

function renderRequirements_eleven($reqStatus) {
    $reqStatus = $reqStatus ?: 'Complete';
    $cls = $reqStatus === 'Incomplete' ? 'status-pending' : 'status-approved';
    $ico = $reqStatus === 'Incomplete' ? 'fa-exclamation-circle' : 'fa-check-circle';
    echo '<span class="status-badge ' . $cls . '"><i class="fas ' . $ico . ' mr-1"></i>' . htmlspecialchars($reqStatus) . '</span>';
}

function renderActions_eleven($id_col_val, $id_student, $status, $fname, $lname, $mi, $prefix = '', $reqStatus = 'Complete') {
    $fullName = htmlspecialchars($lname.', '.$fname.' '.$mi);
    $modalId  = 'viewModal'.$prefix.$id_student;
    $ddId     = 'actionsDd'.$prefix.$id_col_val;
    ?>
    <div class="dropdown row-actions">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
            id="<?= $ddId ?>" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
            Actions
        </button>
        <div class="dropdown-menu dropdown-menu-right row-actions-menu" aria-labelledby="<?= $ddId ?>">
            <a class="dropdown-item item-view" href="#" data-toggle="modal" data-target="#<?= $modalId ?>">
                <i class="fa fa-eye"></i>View
            </a>

            <a class="dropdown-item item-edit" href="#" data-toggle="modal" data-target="#editModal<?= $id_student ?>">
                <i class="fa fa-pen"></i>Edit
            </a>

            <form action="" method="post">
                <input type="hidden" name="id_eleven" value="<?= $id_col_val ?>">
                <button class="dropdown-item item-archive" type="submit" name="delete_eleven">
                    <i class="fas fa-archive"></i>Archive
                </button>
            </form>

            <?php if ($reqStatus === 'Incomplete'): ?>
                <div class="dropdown-divider"></div>
                <form action="" method="post" onsubmit="return confirm('Mark requirements complete and auto-approve this enrollment?');">
                    <input type="hidden" name="id_eleven" value="<?= $id_col_val ?>">
                    <input type="hidden" name="grade_table" value="eleven">
                    <input type="hidden" name="mark_requirements_complete" value="1">
                    <button class="dropdown-item item-approve" type="submit">
                        <i class="fas fa-clipboard-check"></i>Mark Complete &amp; Approve
                    </button>
                </form>
            <?php endif; ?>

            <?php if ($status !== 'Approved' && $status !== 'Rejected'): ?>
                <div class="dropdown-divider"></div>
                <form action="" method="post" onsubmit="return confirmApprove_eleven(this);">
                    <input type="hidden" name="id_eleven" value="<?= $id_col_val ?>">
                    <input type="hidden" name="approve_eleven" value="1">
                    <button class="dropdown-item item-approve" type="submit">
                        <i class="fas fa-check"></i>Approve
                    </button>
                </form>
                <button class="dropdown-item item-reject" type="button"
                    onclick="openRejectModal_eleven(<?= $id_col_val ?>, '<?= addslashes($fullName) ?>')">
                    <i class="fas fa-times"></i>Reject
                </button>
            <?php elseif ($status === 'Rejected'): ?>
                <div class="dropdown-divider"></div>
                <form action="" method="post" onsubmit="return confirmApprove_eleven(this);">
                    <input type="hidden" name="id_eleven" value="<?= $id_col_val ?>">
                    <input type="hidden" name="approve_eleven" value="1">
                    <button class="dropdown-item item-approve" type="submit">
                        <i class="fas fa-check"></i>Approve
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php
}

?>


<!-- ===== BULK APPROVE CONFIRM MODAL ===== -->
<div class="approve-modal-overlay" id="bulkApproveModalOverlay">
    <div class="approve-modal">
        <div class="approve-modal-icon">
            <i class="fas fa-check"></i>
        </div>
        <h5>Bulk Approve Enrollments?</h5>
        <p>This will approve <strong id="bulkApproveCount">0</strong> selected enrollment(s).</p>
        <div class="approve-modal-info">
            <i class="fas fa-envelope"></i>
            Email notifications will be sent to all selected students.
        </div>
        <div class="approve-modal-actions">
            <button type="button" class="btn-cancel-approve" onclick="closeBulkApproveModal()">Cancel</button>
            <button type="button" class="btn-confirm-approve" id="confirmBulkApproveBtn">
                <i class="fas fa-check"></i> Yes, Approve All
            </button>
        </div>
    </div>
</div>

<!-- ===== BULK REJECT REASON MODAL ===== -->
<div class="reject-modal-overlay" id="bulkRejectModalOverlay">
    <div class="reject-modal">
        <div class="reject-modal-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <h5>Bulk Reject Enrollments?</h5>
        <p><strong id="bulkRejectCount">0</strong> enrollment(s) selected.</p>
        <div class="reject-modal-warning">
            <i class="fas fa-envelope"></i>
            Email notifications will be sent to all selected students.
        </div>
        <div class="form-group">
            <label for="bulk_reject_reason_eleven">Reason for Rejection <span class="text-muted" style="font-weight:400;">(optional, applies to all selected)</span></label>
            <textarea class="form-control" id="bulk_reject_reason_eleven" rows="3"
                placeholder="e.g. Incomplete documents, does not meet age requirement..."></textarea>
        </div>
        <div class="reject-modal-actions">
            <button type="button" class="btn-cancel-reject-modal" onclick="closeBulkRejectModal()">Cancel</button>
            <button type="button" class="btn-confirm-reject-modal" onclick="confirmBulkReject('eleven')">
                <i class="fas fa-times-circle"></i> Confirm Bulk Reject
            </button>
        </div>
    </div>
</div>

<!-- ===== BULK ACTION FORM ===== -->
<form id="bulkFormEleven" method="POST" action="" style="display:none;"></form>

<!-- ===== FILTER BAR ===== -->
<div class="card modern-card shadow-sm mb-3">
    <div class="card-body py-2">
        <div class="form-group mb-0">
            <label for="filterSearchEleven" class="small font-weight-bold text-muted mb-1">Search by Name or Email</label>
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="filterSearchEleven" placeholder="Type a name or email...">
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" id="filterSearchBtnEleven">
                        <i class="fas fa-search mr-1"></i>Search
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="filterClearBtnEleven">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ENROLLEES TABLE (card, matches staff view style) ===== -->
<div class="card modern-card shadow-sm">
    <div class="card-header py-2 d-flex align-items-center justify-content-between flex-wrap"
         style="background:linear-gradient(135deg,#0b2b5c,#1f5a9e);gap:8px;">
        <span class="text-white font-weight-bold">
            <i class="fas fa-table mr-1"></i> Grade 11 Enrollees
        </span>
        <div id="bulkActionBarEleven" style="display:none;">
            <span id="bulkSelectedCountEleven" class="text-white-50 small mr-2">0 selected</span>
            <button type="button" class="btn btn-sm btn-success" onclick="submitBulkAction('eleven','approve')">
                <i class="fas fa-check mr-1"></i>Bulk Approve
            </button>
            <button type="button" class="btn btn-sm btn-danger" onclick="openBulkRejectModal('eleven')">
                <i class="fas fa-times mr-1"></i>Bulk Reject
            </button>
            <button type="button" class="btn btn-sm btn-light" onclick="submitBulkAction('eleven','archive')">
                <i class="fas fa-archive mr-1"></i>Bulk Archive
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="enr-scroll">
            <table class="table table-hover mb-0" id="studentsTable">
                <thead class="text-center">
                    <tr>
                        <th style="width:34px;"><input type="checkbox" id="selectAllEleven" onclick="toggleSelectAll('eleven', this)"></th>
                        <th>LRN</th><th>Course</th><th class="text-left" data-col="name">Full Name</th><th data-col="email">Email</th><th>Documents</th><th><img src="https://cdn.simpleicons.org/googlegemini" width="24" height="24" alt="Gemini AI"></th><th>Requirements</th><th data-col="status">Status</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">


    <?php if (is_array($view)): foreach ($view as $row):
        $rStatus   = $row['enrollment_status']  ?? 'Pending';
        $reqStatus = $row['requirements_status'] ?? 'Complete';
        $initials  = strtoupper(substr($row['fname'] ?? '', 0, 1) . substr($row['lname'] ?? '', 0, 1));
    ?>
        <tr>
            <td><input type="checkbox" class="bulk-checkbox-eleven" value="<?= $row['id_eleven'] ?>" onclick="updateBulkCount('eleven')"></td>
            <td><?= htmlspecialchars($row['lrn']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td class="text-left">
                <div class="student-name-cell">
                    <span><?= htmlspecialchars($row['lname']) ?>, <?= htmlspecialchars($row['fname']) ?> <?= htmlspecialchars($row['mi']) ?></span>
                </div>
            </td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?php renderDocs_eleven($row['documents'] ?? '', 'eleven_' . $row['id_eleven'], $row['ai_analysis'] ?? null); ?></td>
            <td><?php render_ai_review_cell($row['ai_analysis'] ?? null, 'eleven', $row['id_eleven']); ?></td>
            <td><?php renderRequirements_eleven($reqStatus); ?></td>
            <td><?php renderStatus_eleven($rStatus); ?></td>
            <td>
                <?php renderActions_eleven($row['id_eleven'], $row['id_student'], $rStatus,
                    $row['fname'], $row['lname'], $row['mi'], '', $reqStatus); ?>
            </td>
        </tr>

        <!-- View Modal (default) -->
        <div class="modal fade plain-modal" id="viewModal<?= $row['id_student'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title">Student Information</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body text-left view-student-body">
                        <div class="view-grid">
                            <div class="view-item"><span class="view-label">School Year</span><div class="view-val"><?= htmlspecialchars($row['sy']) ?></div></div>
                            <div class="view-item"><span class="view-label">Course</span><div class="view-val"><?= htmlspecialchars($row['course']) ?></div></div>
                            <div class="view-item"><span class="view-label">LRN</span><div class="view-val"><?= htmlspecialchars($row['lrn']) ?></div></div>
                            <div class="view-item"><span class="view-label">Status</span><div class="view-val"><?php renderStatus_eleven($rStatus); ?></div></div>
                            <?php if ($rStatus === 'Rejected' && !empty($row['reject_reason'])): ?>
                            <div class="view-item span-4"><span class="view-label">Rejection Reason</span><div class="view-val"><?= htmlspecialchars($row['reject_reason']) ?></div></div>
                            <?php endif; ?>
                        </div>

                        <h6 class="edit-section-title">Personal Information</h6>
                        <div class="view-grid">
                            <div class="view-item span-2"><span class="view-label">Full Name</span><div class="view-val"><?= htmlspecialchars($row['lname']) ?>, <?= htmlspecialchars($row['fname']) ?> <?= htmlspecialchars($row['mi']) ?></div></div>
                            <div class="view-item"><span class="view-label">Birthday</span><div class="view-val"><?= htmlspecialchars($row['bdate']) ?></div></div>
                            <div class="view-item"><span class="view-label">Age</span><div class="view-val"><?= htmlspecialchars($row['age']) ?></div></div>
                            <div class="view-item"><span class="view-label">Contact Number</span><div class="view-val"><?= htmlspecialchars($row['contact']) ?></div></div>
                            <div class="view-item span-2"><span class="view-label">Email</span><div class="view-val"><?= htmlspecialchars($row['email']) ?></div></div>
                            <div class="view-item span-2"><span class="view-label">Current Address</span><div class="view-val"><?= htmlspecialchars($row['current_address']) ?></div></div>
                            <div class="view-item span-2"><span class="view-label">Permanent Address</span><div class="view-val"><?= htmlspecialchars($row['perm_address']) ?></div></div>
                        </div>

                        <h6 class="edit-section-title">Parents' Information</h6>
                        <div class="view-grid">
                            <div class="view-item"><span class="view-label">Father's Name</span><div class="view-val"><?= htmlspecialchars($row['flname']) ?>, <?= htmlspecialchars($row['ffname']) ?> <?= htmlspecialchars($row['fmi']) ?></div></div>
                            <div class="view-item"><span class="view-label">Father's Contact</span><div class="view-val"><?= htmlspecialchars($row['contact_f']) ?></div></div>
                            <div class="view-item"><span class="view-label">Mother's Name</span><div class="view-val"><?= htmlspecialchars($row['mlname']) ?>, <?= htmlspecialchars($row['mfname']) ?> <?= htmlspecialchars($row['mmi']) ?></div></div>
                            <div class="view-item"><span class="view-label">Mother's Contact</span><div class="view-val"><?= htmlspecialchars($row['contact_m']) ?></div></div>
                        </div>

                        <h6 class="edit-section-title">For Returning Learner</h6>
                        <div class="view-grid">
                            <div class="view-item"><span class="view-label">Last Grade Level Completed</span><div class="view-val"><?= htmlspecialchars($row['lglc']) ?></div></div>
                            <div class="view-item"><span class="view-label">Last School Attended</span><div class="view-val"><?= htmlspecialchars($row['lsa']) ?></div></div>
                            <div class="view-item"><span class="view-label">Last School Year Completed</span><div class="view-val"><?= htmlspecialchars($row['lysc']) ?></div></div>
                            <div class="view-item"><span class="view-label">School ID</span><div class="view-val"><?= htmlspecialchars($row['school_id']) ?></div></div>
                        </div>

                        <h6 class="edit-section-title">Socioeconomic Information</h6>
                        <div class="view-grid">
                            <div class="view-item span-2"><span class="view-label">IP Member</span><div class="view-val"><?= htmlspecialchars($row['is_ip'] ?? 'No') ?><?= (!empty($row['ip_group'])) ? ' — ' . htmlspecialchars($row['ip_group']) : '' ?></div></div>
                            <div class="view-item span-2"><span class="view-label">4Ps Beneficiary</span><div class="view-val"><?= htmlspecialchars($row['is_4ps'] ?? 'No') ?><?= (!empty($row['fourps_id'])) ? ' — ID: ' . htmlspecialchars($row['fourps_id']) : '' ?></div></div>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" data-toggle="modal" data-target="#editModal<?= $row['id_student'] ?>">
                            <i class="fas fa-pen mr-1"></i> Edit Information
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade plain-modal" id="editModal<?= $row['id_student'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header py-2">
                            <h6 class="modal-title font-weight-bold text-ink">Edit Student Information</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                        </div>
                        <div class="modal-body text-left edit-student-body">
                            <input type="hidden" name="edit_enrollee" value="1">
                            <input type="hidden" name="grade_table" value="eleven">
                            <input type="hidden" name="id_eleven" value="<?= $row['id_eleven'] ?>">

                            <h6 class="edit-section-title">Personal Information</h6>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>LRN</label>
                                    <input type="text" class="form-control form-control-sm" name="lrn" value="<?= htmlspecialchars($row['lrn']) ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Birthday</label>
                                    <input type="date" class="form-control form-control-sm" name="bdate" value="<?= htmlspecialchars($row['bdate']) ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Age</label>
                                    <input type="number" min="0" class="form-control form-control-sm" name="age" value="<?= htmlspecialchars($row['age']) ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control form-control-sm" name="lname" value="<?= htmlspecialchars($row['lname']) ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>First Name</label>
                                    <input type="text" class="form-control form-control-sm" name="fname" value="<?= htmlspecialchars($row['fname']) ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control form-control-sm" name="mi" maxlength="50" value="<?= htmlspecialchars($row['mi']) ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control form-control-sm" name="contact" value="<?= htmlspecialchars($row['contact']) ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control form-control-sm" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Current Address</label>
                                <input type="text" class="form-control form-control-sm" name="current_address" value="<?= htmlspecialchars($row['current_address']) ?>">
                            </div>
                            <div class="form-group">
                                <label>Permanent Address</label>
                                <input type="text" class="form-control form-control-sm" name="perm_address" value="<?= htmlspecialchars($row['perm_address']) ?>">
                            </div>

                            <h6 class="edit-section-title">Parent / Guardian Information</h6>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">Father's Name</label>
                                    <input type="text" class="form-control form-control-sm mb-2 text-uppercase-field" name="ffname" placeholder="First Name" pattern="[A-Za-z ]+" title="Letters and spaces only" value="<?= htmlspecialchars($row['ffname']) ?>">
                                    <input type="text" class="form-control form-control-sm mb-2 text-uppercase-field" name="flname" placeholder="Last Name" pattern="[A-Za-z ]+" title="Letters and spaces only" value="<?= htmlspecialchars($row['flname']) ?>">
                                    <input type="text" class="form-control form-control-sm mb-2 text-uppercase-field" name="fmi" placeholder="Middle Name" maxlength="50" pattern="[A-Za-z ]+" title="Letters and spaces only" value="<?= htmlspecialchars($row['fmi']) ?>">
                                    <input type="text" class="form-control form-control-sm" name="contact_f" placeholder="Contact No." value="<?= htmlspecialchars($row['contact_f']) ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">Mother's Maiden Name</label>
                                    <input type="text" class="form-control form-control-sm mb-2 text-uppercase-field" name="mfname" placeholder="First Name" pattern="[A-Za-z ]+" title="Letters and spaces only" value="<?= htmlspecialchars($row['mfname']) ?>">
                                    <input type="text" class="form-control form-control-sm mb-2 text-uppercase-field" name="mlname" placeholder="Last Name" pattern="[A-Za-z ]+" title="Letters and spaces only" value="<?= htmlspecialchars($row['mlname']) ?>">
                                    <input type="text" class="form-control form-control-sm mb-2 text-uppercase-field" name="mmi" placeholder="Middle Name" maxlength="50" pattern="[A-Za-z ]+" title="Letters and spaces only" value="<?= htmlspecialchars($row['mmi']) ?>">
                                    <input type="text" class="form-control form-control-sm" name="contact_m" placeholder="Contact No." value="<?= htmlspecialchars($row['contact_m']) ?>">
                                </div>
                            </div>

                            <h6 class="edit-section-title">Previous Education</h6>
                            <div class="form-row">
                                <div class="form-group col-md-6"><label>Last Grade Level Completed</label><input type="text" class="form-control form-control-sm" name="lglc" value="<?= htmlspecialchars($row['lglc'] ?? '') ?>"></div>
                                <div class="form-group col-md-6"><label>Last School Attended</label><input type="text" class="form-control form-control-sm" name="lsa" value="<?= htmlspecialchars($row['lsa'] ?? '') ?>"></div>
                                <div class="form-group col-md-6"><label>Last School Year Completed</label><input type="text" class="form-control form-control-sm" name="lysc" value="<?= htmlspecialchars($row['lysc'] ?? '') ?>"></div>
                                <div class="form-group col-md-6"><label>School ID</label><input type="text" class="form-control form-control-sm" name="school_id" value="<?= htmlspecialchars($row['school_id'] ?? '') ?>"></div>
                            </div>

                            <h6 class="edit-section-title">Socioeconomic Information</h6>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Indigenous People (IP) Member</label>
                                    <select name="is_ip" class="form-control form-control-sm" onchange="document.getElementById('editIpGroupDiv_<?= $row['id_student'] ?>').style.display = this.value === 'Yes' ? '' : 'none';">
                                        <option value="No" <?= ((($row['is_ip'] ?? 'No')) === 'Yes') ? '' : 'selected' ?>>No</option>
                                        <option value="Yes" <?= ((($row['is_ip'] ?? '')) === 'Yes') ? 'selected' : '' ?>>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" id="editIpGroupDiv_<?= $row['id_student'] ?>" style="<?= ((($row['is_ip'] ?? '')) === 'Yes') ? '' : 'display:none;' ?>">
                                    <label>IP Group / Tribe</label>
                                    <input type="text" class="form-control form-control-sm" name="ip_group" placeholder="e.g. Agta, Dumagat, Igorot" value="<?= htmlspecialchars($row['ip_group'] ?? '') ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>4Ps Beneficiary</label>
                                    <select name="is_4ps" class="form-control form-control-sm" onchange="document.getElementById('editFourpsDiv_<?= $row['id_student'] ?>').style.display = this.value === 'Yes' ? '' : 'none';">
                                        <option value="No" <?= ((($row['is_4ps'] ?? 'No')) === 'Yes') ? '' : 'selected' ?>>No</option>
                                        <option value="Yes" <?= ((($row['is_4ps'] ?? '')) === 'Yes') ? 'selected' : '' ?>>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mb-0" id="editFourpsDiv_<?= $row['id_student'] ?>" style="<?= ((($row['is_4ps'] ?? '')) === 'Yes') ? '' : 'display:none;' ?>">
                                    <label>4Ps Household ID</label>
                                    <input type="text" class="form-control form-control-sm" name="fourps_id" placeholder="4Ps Household ID" value="<?= htmlspecialchars($row['fourps_id'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; else: ?>
                <tr><td colspan="10" class="text-center text-muted py-4">No students found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function(){
    var studentsTable_eleven = $('#studentsTable').DataTable({ dom: 'rtp', autoWidth: false, paging: true, pageLength: 15, pagingType: 'simple_numbers', order: [[3,'asc']], columnDefs: [{ orderable: false, targets: [0, 9] }] });

    // ===== Filter bar wiring: combined Name/Email search =====
    (function() {
        var table = studentsTable_eleven;
        var nameCol  = $('#studentsTable thead th[data-col="name"]').index();
        var emailCol = $('#studentsTable thead th[data-col="email"]').index();
        var activeTerm = '';

        $.fn.dataTable.ext.search.push(function(settings, data) {
            if (settings.nTable.id !== 'studentsTable') return true;
            if (!activeTerm) return true;

            var name  = String(data[nameCol]  || '').toLowerCase();
            var email = String(data[emailCol] || '').toLowerCase();
            return name.indexOf(activeTerm) !== -1 || email.indexOf(activeTerm) !== -1;
        });

        function runSearchEleven() {
            activeTerm = $('#filterSearchEleven').val().trim().toLowerCase();
            table.draw();
        }

        $('#filterSearchBtnEleven').on('click', runSearchEleven);

        $('#filterSearchEleven').on('keypress', function(e) {
            if (e.which === 13) { e.preventDefault(); runSearchEleven(); }
        });

        $('#filterClearBtnEleven').on('click', function() {
            $('#filterSearchEleven').val('');
            activeTerm = '';
            table.draw();
        });
    })();
});
</script>

<script>
/* Row "Actions" dropdown: a plain Bootstrap dropdown (data-display="static" keeps Popper out of it).
   The table sits in a scroll box, which clips a normal absolutely-positioned menu, so while a menu is
   open it becomes position:fixed and is placed against its toggle: below by default, above (drop-up)
   when there isn't enough room underneath. */
(function () {
    if (window.__rowActionsReady) return;
    window.__rowActionsReady = true;

    var GAP = 2, EDGE = 8, openDd = null;

    /* The portal scales pages with CSS zoom (Settings > font size), so getBoundingClientRect() values and
       position:fixed offsets can be in different units. Measure the viewport and a 100px box the same way
       the menu is laid out, and convert with that ratio. */
    function measure() {
        var vp = document.createElement('div'), box = document.createElement('div');
        vp.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;visibility:hidden;pointer-events:none;';
        box.style.cssText = 'width:100px;height:1px;';
        vp.appendChild(box);
        document.body.appendChild(vp);
        var v = vp.getBoundingClientRect(), b = box.getBoundingClientRect();
        document.body.removeChild(vp);
        return { w: v.width, h: v.height, k: (b.width / 100) || 1 };
    }

    function place(dd) {
        var toggle = dd.querySelector('[data-toggle="dropdown"]');
        var menu   = dd.querySelector('.dropdown-menu');
        if (!toggle || !menu) return;

        // Toggle scrolled out of its scroll box: nothing left to attach the menu to.
        var t = toggle.getBoundingClientRect(), scroller = toggle.closest('.enr-scroll');
        if (scroller) {
            var s = scroller.getBoundingClientRect();
            if (t.bottom < s.top || t.top > s.bottom || t.right < s.left || t.left > s.right) {
                $(toggle).dropdown('hide');
                return;
            }
        }

        var m = measure();
        menu.classList.add('is-floating');
        menu.style.maxHeight = '';
        menu.style.left = '0px'; menu.style.top = '0px'; menu.style.right = 'auto'; menu.style.bottom = 'auto';

        var mr = menu.getBoundingClientRect(), mw = mr.width, mh = mr.height;
        var below = m.h - t.bottom - GAP - EDGE, above = t.top - GAP - EDGE;
        var up    = mh > below && above > below;        // drop-up only when it doesn't fit below and there is more room above
        var room  = Math.max(80, up ? above : below);
        if (mh > room) {                                // taller than either side: scroll inside the menu
            menu.style.maxHeight = (room / m.k) + 'px';
            mh = menu.getBoundingClientRect().height;
        }

        var left = Math.max(EDGE, Math.min(t.right - mw, m.w - mw - EDGE));   // right edges line up
        var top  = up ? t.top - GAP - mh : t.bottom + GAP;
        menu.style.left = (left / m.k) + 'px';
        menu.style.top  = (top / m.k) + 'px';
        dd.classList.toggle('is-dropup', up);
    }

    $(document).on('shown.bs.dropdown', '.row-actions', function () { openDd = this; place(this); });
    $(document).on('hidden.bs.dropdown', '.row-actions', function () {
        var menu = this.querySelector('.dropdown-menu');
        menu.classList.remove('is-floating');
        ['top', 'left', 'right', 'bottom', 'maxHeight'].forEach(function (p) { menu.style[p] = ''; });
        this.classList.remove('is-dropup');
        if (openDd === this) openDd = null;
    });
    window.addEventListener('resize', function () { if (openDd) place(openDd); });
    window.addEventListener('scroll', function (e) {     // capture: also fires for the table's own scroll box
        if (openDd && !openDd.contains(e.target)) place(openDd);
    }, true);
})();
</script>


<script>
/* ---- Document Viewer (Facebook-story style, with Prev/Next) ---- */
var __docViewerState = { group: null, index: 0 };

function openDocViewer(group, index) {
    __docViewerState.group = group;
    __docViewerState.index = index;
    renderDocViewer();
    document.getElementById('docViewerRelay').click();
}

function renderDocViewer() {
    var group = __docViewerState.group;
    var items = (window.__docGroups && window.__docGroups[group]) || [];
    var total = items.length;
    if (!total) return;

    var index = __docViewerState.index;
    if (index < 0) index = 0;
    if (index > total - 1) index = total - 1;
    __docViewerState.index = index;

    var item = items[index];
    document.getElementById('docViewerTitleText').textContent = item.name;
    document.getElementById('docViewerCounter').textContent = total > 1 ? '(' + (index + 1) + ' / ' + total + ')' : '';

    var content = document.getElementById('docViewerContent');
    if (item.type === 'image') {
        content.innerHTML = '<img src="' + item.path + '" alt="' + item.name + '">';
    } else if (item.type === 'pdf') {
        content.innerHTML = '<iframe src="' + item.path + '" title="' + item.name + '"></iframe>';
    } else {
        content.innerHTML = '<div class="doc-unsupported"><i class="fas fa-file-word big-icon"></i><strong>' + item.name + '</strong><p class="mt-2 text-muted">This file type cannot be previewed here.</p></div>';
    }

    var segWrap = document.getElementById('docViewerSegments');
    segWrap.innerHTML = '';
    if (total > 1) {
        for (var i = 0; i < total; i++) {
            var seg = document.createElement('div');
            seg.className = 'doc-segment' + (i === index ? ' active' : '');
            segWrap.appendChild(seg);
        }
    }

    var show = total > 1;
    document.getElementById('docViewerPrev').style.display = show ? 'flex' : 'none';
    document.getElementById('docViewerNext').style.display = show ? 'flex' : 'none';
}

function prevDocViewer() {
    var items = (window.__docGroups && window.__docGroups[__docViewerState.group]) || [];
    if (!items.length) return;
    __docViewerState.index = (__docViewerState.index - 1 + items.length) % items.length;
    renderDocViewer();
}

function nextDocViewer() {
    var items = (window.__docGroups && window.__docGroups[__docViewerState.group]) || [];
    if (!items.length) return;
    __docViewerState.index = (__docViewerState.index + 1) % items.length;
    renderDocViewer();
}

document.getElementById('docViewerModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('docViewerContent').innerHTML = '<p class="text-muted pt-5">Loading...</p>';
    document.getElementById('docViewerTitleText').textContent = 'Document Preview';
    document.getElementById('docViewerCounter').textContent = '';
    document.getElementById('docViewerSegments').innerHTML = '';
});

let approveTargetForm_eleven = null;
function confirmApprove_eleven(form) {
    var row  = form.closest('tr');
    var name = row ? row.cells[1].innerText.trim() : 'this student';
    approveTargetForm_eleven = form;
    document.getElementById('approveStudentName_eleven').textContent = name;
    document.getElementById('approveModalOverlay_eleven').classList.add('show');
    return false;
}
function closeApproveModal_eleven() {
    document.getElementById('approveModalOverlay_eleven').classList.remove('show');
    approveTargetForm_eleven = null;
}
document.getElementById('confirmApproveBtn_eleven').addEventListener('click', function () {
    if (approveTargetForm_eleven) {
        showAdminLoading('Approving enrollment...', 'check');
        approveTargetForm_eleven.submit();
    }
    closeApproveModal_eleven();
});
document.getElementById('approveModalOverlay_eleven').addEventListener('click', function(e){ if(e.target===this) closeApproveModal_eleven(); });

document.getElementById('rejectForm').addEventListener('submit', function () {
    showAdminLoading('Rejecting enrollment...', 'times');
});

function openRejectModal_eleven(id_col_val, studentName) {
    document.getElementById('rejectIdEleven').value = id_col_val;
    document.getElementById('rejectStudentName').textContent = studentName;
    document.getElementById('reject_reason').value = '';
    document.getElementById('rejectModalOverlay_eleven').classList.add('show');
}
function closeRejectModal_eleven() {
    document.getElementById('rejectModalOverlay_eleven').classList.remove('show');
}
document.getElementById('rejectModalOverlay_eleven').addEventListener('click', function(e){ if(e.target===this) closeRejectModal_eleven(); });

/* ================= BULK ACTIONS ================= */
function getBulkCheckboxes(grade) {
    return document.querySelectorAll('.bulk-checkbox-' + grade + ':checked');
}

function toggleSelectAll(grade, headerCheckbox) {
    document.querySelectorAll('.bulk-checkbox-' + grade).forEach(function(cb) {
        cb.checked = headerCheckbox.checked;
    });
    updateBulkCount(grade);
}

function updateBulkCount(grade) {
    var count = getBulkCheckboxes(grade).length;
    var gradeCap = grade.charAt(0).toUpperCase() + grade.slice(1);
    var el = document.getElementById('bulkSelectedCount' + gradeCap);
    if (el) el.textContent = count + ' selected';
    var bar = document.getElementById('bulkActionBar' + gradeCap);
    if (bar) bar.style.display = count > 0 ? 'flex' : 'none';
}

let pendingBulkApprove = null;
function submitBulkAction(grade, action) {
    var checked = getBulkCheckboxes(grade);
    if (checked.length === 0) {
        Swal.fire('No selection', 'Please select at least one enrollment first.', 'warning');
        return;
    }
    if (action === 'approve') {
        pendingBulkApprove = { grade: grade, checked: checked };
        document.getElementById('bulkApproveCount').textContent = checked.length;
        document.getElementById('bulkApproveModalOverlay').classList.add('show');
        return;
    }
    Swal.fire({
        title: 'Bulk Archive?',
        html: 'This will archive <strong>' + checked.length + '</strong> selected enrollment(s).',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6c757d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Archive!',
        cancelButtonText: 'Cancel'
    }).then(function(result) {
        if (result.isConfirmed) {
            buildAndSubmitBulkForm(grade, action, checked, '');
        }
    });
}
function closeBulkApproveModal() {
    document.getElementById('bulkApproveModalOverlay').classList.remove('show');
    pendingBulkApprove = null;
}
document.getElementById('confirmBulkApproveBtn').addEventListener('click', function () {
    if (pendingBulkApprove) {
        buildAndSubmitBulkForm(pendingBulkApprove.grade, 'approve', pendingBulkApprove.checked, '');
    }
    closeBulkApproveModal();
});
document.getElementById('bulkApproveModalOverlay').addEventListener('click', function(e){ if(e.target===this) closeBulkApproveModal(); });

function openBulkRejectModal(grade) {
    var checked = getBulkCheckboxes(grade);
    if (checked.length === 0) {
        Swal.fire('No selection', 'Please select at least one enrollment first.', 'warning');
        return;
    }
    document.getElementById('bulkRejectCount').textContent = checked.length;
    var reasonBox = document.getElementById('bulk_reject_reason_' + grade);
    if (reasonBox) reasonBox.value = '';
    document.getElementById('bulkRejectModalOverlay').classList.add('show');
}
function closeBulkRejectModal() {
    document.getElementById('bulkRejectModalOverlay').classList.remove('show');
}
document.getElementById('bulkRejectModalOverlay').addEventListener('click', function(e){ if(e.target===this) closeBulkRejectModal(); });

function confirmBulkReject(grade) {
    var checked = getBulkCheckboxes(grade);
    var reason  = (document.getElementById('bulk_reject_reason_' + grade) || {}).value || '';
    closeBulkRejectModal();
    buildAndSubmitBulkForm(grade, 'reject', checked, reason);
}

function buildAndSubmitBulkForm(grade, action, checkedNodeList, reason) {
    var formIdMap = { seven: 'bulkFormSeven', eight: 'bulkFormEight', nine: 'bulkFormNine',
                       ten: 'bulkFormTen', eleven: 'bulkFormEleven', twelve: 'bulkFormTwelve' };
    var form = document.getElementById(formIdMap[grade]);
    if (!form) return;
    form.innerHTML = '';

    checkedNodeList.forEach(function(cb) {
        var inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'bulk_ids[]'; inp.value = cb.value;
        form.appendChild(inp);
    });

    var actionField = document.createElement('input');
    actionField.type = 'hidden';
    actionField.name = 'bulk_' + action + '_' + grade;
    actionField.value = '1';
    form.appendChild(actionField);

    if (action === 'reject') {
        var reasonField = document.createElement('input');
        reasonField.type = 'hidden';
        reasonField.name = 'bulk_reject_reason';
        reasonField.value = reason;
        form.appendChild(reasonField);
    }

    var __label = action === 'approve' ? 'Approving selected enrollments...' : (action === 'reject' ? 'Rejecting selected enrollments...' : 'Archiving selected enrollments...');
    showAdminLoading(__label, action === 'approve' ? 'check' : (action === 'reject' ? 'times' : 'archive'));
    form.submit();
}
</script>