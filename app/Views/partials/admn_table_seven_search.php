<?php require MODELS_PATH . '/conn.php'; require_once MODELS_PATH . '/ai_review_ui.php'; ?>

<!-- ===== DOCUMENT VIEWER MODAL (Facebook-story style) ===== -->
<div class="modal fade" id="docViewerModal" tabindex="-1" role="dialog" aria-labelledby="docViewerTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(135deg,#0b2b5c,#1f5a9e);color:white;">
                <h5 class="modal-title" id="docViewerTitle">
                    <i class="fas fa-file"></i>&nbsp;<span id="docViewerTitleText">Document Preview</span>
                    <span id="docViewerCounter" class="ml-2 small font-weight-normal" style="opacity:.8;"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;opacity:1;">
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

<!-- ===== REJECT REASON MODAL ===== -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;">
            <div class="modal-header" style="background:#c0392b;color:white;">
                <h5 class="modal-title"><i class="fas fa-times-circle mr-2"></i>Reject Enrollment</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:1;"><span>&times;</span></button>
            </div>
            <form id="rejectForm" action="" method="POST">
                <input type="hidden" name="id_seven" id="rejectIdSeven" value="">
                <div class="modal-body">
                    <p class="mb-1">Student: <strong id="rejectStudentName"></strong></p>
                    <p class="text-muted small mb-3">An email notification will be sent to the student.</p>
                    <div class="form-group">
                        <label for="reject_reason"><strong>Reason for Rejection</strong> <span class="text-muted">(optional)</span></label>
                        <textarea class="form-control" id="reject_reason" name="reject_reason" rows="3"
                            placeholder="e.g. Incomplete documents, does not meet age requirement..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="reject_seven" class="btn btn-danger">
                        <i class="fas fa-times-circle mr-1"></i> Confirm Reject
                    </button>
                </div>
            </form>
        </div>
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
#docViewerSegments .doc-segment { flex:1; height:3px; border-radius:2px; background:#dfe3ea; overflow:hidden; }
#docViewerSegments .doc-segment.active { background:#0b2b5c; }
#docViewerBody iframe { width:100%;height:68vh;border:none;border-radius:8px; }
.doc-preview-btn { display:inline-block;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;vertical-align:middle;cursor:pointer;transition:transform .15s,box-shadow .15s; }
.doc-preview-btn:hover { transform:scale(1.04);box-shadow:0 3px 10px rgba(42,111,156,.3); }
.doc-unsupported { padding:50px 20px;color:#6c757d; }
.doc-unsupported .big-icon { font-size:3rem;display:block;margin-bottom:12px;color:#adb5bd; }
.status-badge { font-size:12px;padding:4px 10px;border-radius:20px;font-weight:600;display:inline-block; }
.status-pending  { background:#fff3cd;color:#856404;border:1px solid #ffc107; }
.status-approved { background:#d4edda;color:#155724;border:1px solid #28a745; }
.status-rejected { background:#f8d7da;color:#721c24;border:1px solid #dc3545; }
.status-waitlisted { background:#e2e3ff;color:#3730a3;border:1px solid #6366f1; }

/* ===== MODERN TABLE (Grade 7) ===== */
.modern-card { border:none; border-radius:14px; overflow:hidden; }
.modern-card .card-header { border:none; padding:14px 20px; }
#studentsTable { font-size:.84rem; }
#studentsTable thead th {
    background:#f8f9fc; color:#5a6169; border:none;
    text-transform:uppercase; letter-spacing:.04em; font-size:.7rem;
    font-weight:700; padding:12px 10px; vertical-align:middle;
}
#studentsTable tbody td { padding:10px; vertical-align:middle; border-top:1px solid #f0f2f6; }
#studentsTable tbody tr { transition:background .12s ease; }
#studentsTable tbody tr:hover { background:#f8faff; }
.student-avatar {
    width:32px; height:32px; min-width:32px; border-radius:50%;
    background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff;
    display:inline-flex; align-items:center; justify-content:center;
    font-weight:700; font-size:.72rem; margin-right:8px;
}
.student-name-cell { display:flex; align-items:center; }
.student-name-text { font-weight:600; color:#1a202c; }
.actions-dropdown-toggle {
    border-radius:20px !important; border:1px solid #e2e8f0 !important;
    background:#fff !important; color:#4a5568 !important;
    box-shadow:none !important;
}
.actions-dropdown-toggle:hover { background:#f8faff !important; border-color:#6366f1 !important; color:#6366f1 !important; }
</style>

<?php

/* ---- helper: guesses a human document type (PSA, Form 137, etc.) ---- */
function resolveDocLabel($fileName, $aiDocsByFile, $index) {
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

/* ---- helper: renders the Documents cell ---- */
function renderDocs($docsJson, $groupKey, $aiAnalysisJson = null) {
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
        $isImg = in_array($ext, ['jpg','jpeg','png']);
        $isPdf = $ext === 'pdf';
        $items[] = [
            'path' => $docPath,
            'name' => resolveDocLabel($fileName, $aiDocsByFile, $i),
            'type' => $isImg ? 'image' : ($isPdf ? 'pdf' : 'doc'),
        ];
    }

    echo '<script>(window.__docGroups=window.__docGroups||{})[' . json_encode($groupKey) . ']=' . json_encode($items) . ';</script>';

    echo '<button type="button" class="btn btn-outline-primary btn-sm doc-view-btn"
            onclick="openDocViewer(\'' . addslashes($groupKey) . '\', 0)">
            <i class="fas fa-folder-open mr-1"></i> View (' . count($items) . ')
          </button>';
}

/* ---- helper: renders the Status badge ---- */
function renderStatus($status) {
    $status = $status ?: 'Pending';
    $cls = ['Approved' => 'status-approved', 'Rejected' => 'status-rejected', 'Pending' => 'status-pending', 'Waitlisted' => 'status-waitlisted'];
    $ico = ['Approved' => 'fa-check-circle', 'Rejected' => 'fa-times-circle', 'Pending' => 'fa-clock', 'Waitlisted' => 'fa-hourglass-half'];
    $c   = $cls[$status] ?? 'status-pending';
    $i   = $ico[$status] ?? 'fa-clock';
    echo '<span class="status-badge ' . $c . '"><i class="fas ' . $i . ' mr-1"></i>' . htmlspecialchars($status) . '</span>';
}

/* ---- helper: renders the Requirements badge ---- */
function renderRequirements($reqStatus) {
    $reqStatus = $reqStatus ?: 'Complete';
    $cls = $reqStatus === 'Incomplete' ? 'status-pending' : 'status-approved';
    $ico = $reqStatus === 'Incomplete' ? 'fa-exclamation-circle' : 'fa-check-circle';
    echo '<span class="status-badge ' . $cls . '"><i class="fas ' . $ico . ' mr-1"></i>' . htmlspecialchars($reqStatus) . '</span>';
}

/* ---- helper: renders the Action buttons ---- */
function renderActions($id_seven, $id_student, $status, $fname, $lname, $mi, $prefix = '', $reqStatus = 'Complete') {
    $fullName = htmlspecialchars($lname.', '.$fname.' '.$mi);
    $modalId  = 'viewModal'.$prefix.$id_student;
    $ddId     = 'actionsDd'.$prefix.$id_seven;
    ?>
    <div class="dropdown">
        <button class="btn btn-outline-primary btn-sm dropdown-toggle actions-dropdown-toggle" type="button"
            id="<?= $ddId ?>" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i> Actions
        </button>
        <div class="dropdown-menu dropdown-menu-right actions-dropdown-menu" aria-labelledby="<?= $ddId ?>" data-boundary="window">
            <div class="actions-dropdown-header">Actions</div>
            <div class="actions-dropdown-body">

            <a class="dropdown-item item-view" href="#" data-toggle="modal" data-target="#<?= $modalId ?>">
                <span class="action-icon-badge"><i class="fa fa-eye"></i></span>View
            </a>

            <form action="" method="post">
                <input type="hidden" name="id_seven" value="<?= $id_seven ?>">
                <button class="dropdown-item item-archive" type="submit" name="delete_seven">
                    <span class="action-icon-badge"><i class="fas fa-archive"></i></span>Archive
                </button>
            </form>

            <?php if ($reqStatus === 'Incomplete'): ?>
                <div class="dropdown-divider"></div>
                <form action="" method="post" onsubmit="return confirm('Mark requirements complete and auto-approve this enrollment?');">
                    <input type="hidden" name="id_seven" value="<?= $id_seven ?>">
                    <input type="hidden" name="grade_table" value="seven">
                    <input type="hidden" name="mark_requirements_complete" value="1">
                    <button class="dropdown-item item-approve" type="submit">
                        <span class="action-icon-badge"><i class="fas fa-clipboard-check"></i></span>Mark Complete &amp; Approve
                    </button>
                </form>
            <?php endif; ?>

            <?php if ($status !== 'Approved' && $status !== 'Rejected'): ?>
                <div class="dropdown-divider"></div>
                <form action="" method="post" onsubmit="return confirmApprove(this);">
                    <input type="hidden" name="id_seven" value="<?= $id_seven ?>">
                    <input type="hidden" name="approve_seven" value="1">
                    <button class="dropdown-item item-approve" type="submit">
                        <span class="action-icon-badge"><i class="fas fa-check"></i></span>Approve
                    </button>
                </form>
                <button class="dropdown-item item-reject" type="button"
                    onclick="openRejectModal(<?= $id_seven ?>, '<?= addslashes($fullName) ?>')">
                    <span class="action-icon-badge"><i class="fas fa-times"></i></span>Reject
                </button>

            <?php elseif ($status === 'Rejected'): ?>
                <div class="dropdown-divider"></div>
                <form action="" method="post" onsubmit="return confirmApprove(this);">
                    <input type="hidden" name="id_seven" value="<?= $id_seven ?>">
                    <input type="hidden" name="approve_seven" value="1">
                    <button class="dropdown-item item-approve" type="submit">
                        <span class="action-icon-badge"><i class="fas fa-check"></i></span>Approve
                    </button>
                </form>
            <?php endif; ?>

            </div>
        </div>
    </div>
<?php
}
?>

<!-- ===== BULK REJECT REASON MODAL ===== -->
<div class="modal fade" id="bulkRejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;">
            <div class="modal-header" style="background:#c0392b;color:white;">
                <h5 class="modal-title"><i class="fas fa-times-circle mr-2"></i>Bulk Reject Enrollments</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:1;"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="mb-1"><strong id="bulkRejectCount"></strong> enrollment(s) selected.</p>
                <p class="text-muted small mb-3">Email notifications will be sent to all selected students.</p>
                <div class="form-group">
                    <label for="bulk_reject_reason_seven"><strong>Reason for Rejection</strong> <span class="text-muted">(optional, applies to all selected)</span></label>
                    <textarea class="form-control" id="bulk_reject_reason_seven" rows="3"
                        placeholder="e.g. Incomplete documents, does not meet age requirement..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmBulkReject('seven')">
                    <i class="fas fa-times-circle mr-1"></i> Confirm Bulk Reject
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== BULK ACTION FORM ===== -->
<form id="bulkFormSeven" method="POST" action="" style="display:none;"></form>

<!-- ===== FILTER BAR ===== -->
<div class="card modern-card shadow-sm mb-3">
    <div class="card-body py-2">
        <div class="form-group mb-0">
            <label for="filterSearchSeven" class="small font-weight-bold text-muted mb-1">Search by Name or Email</label>
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="filterSearchSeven" placeholder="Type a name or email...">
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" id="filterSearchBtnSeven">
                        <i class="fas fa-search mr-1"></i>Search
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="filterClearBtnSeven">
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
            <i class="fas fa-table mr-1"></i> Grade 7 Enrollees
        </span>
        <div id="bulkActionBarSeven" style="display:none;">
            <span id="bulkSelectedCountSeven" class="text-white-50 small mr-2">0 selected</span>
            <button type="button" class="btn btn-sm btn-success" onclick="submitBulkAction('seven','approve')">
                <i class="fas fa-check mr-1"></i>Bulk Approve
            </button>
            <button type="button" class="btn btn-sm btn-danger" onclick="openBulkRejectModal('seven')">
                <i class="fas fa-times mr-1"></i>Bulk Reject
            </button>
            <button type="button" class="btn btn-sm btn-light" onclick="submitBulkAction('seven','archive')">
                <i class="fas fa-archive mr-1"></i>Bulk Archive
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="studentsTable">
                <thead class="text-center">
                    <tr>
                        <th style="width:34px;"><input type="checkbox" id="selectAllSeven" onclick="toggleSelectAll('seven', this)"></th>
                        <th>LRN</th><th class="text-left" data-col="name">Full Name</th><th data-col="bdate">Birthday</th><th>Age</th>
                        <th>Contact</th><th data-col="email">Email</th><th>Documents</th><th><img src="https://cdn.simpleicons.org/mistralai" width="24" height="24" alt="Mistral AI"></th><th>Requirements</th><th data-col="status">Status</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
            <?php if (is_array($view)): foreach ($view as $row):
                $rStatus   = $row['enrollment_status']   ?? 'Pending';
                $reqStatus = $row['requirements_status']  ?? 'Complete';
                $initials  = strtoupper(substr($row['fname'] ?? '', 0, 1) . substr($row['lname'] ?? '', 0, 1));
            ?>
                <tr>
                    <td><input type="checkbox" class="bulk-checkbox-seven" value="<?= $row['id_seven'] ?>" onclick="updateBulkCount('seven')"></td>
                    <td><?= htmlspecialchars($row['lrn']) ?></td>
                    <td class="text-left">
                        <div class="student-name-cell">
                            <span class="student-name-text"><?= htmlspecialchars($row['lname']) ?>, <?= htmlspecialchars($row['fname']) ?> <?= htmlspecialchars($row['mi']) ?></span>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($row['bdate']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= htmlspecialchars($row['contact']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td style="min-width:145px;"><?php renderDocs($row['documents'] ?? '', 'seven_' . $row['id_seven'], $row['ai_analysis'] ?? null); ?></td>
                    <td style="min-width:150px;"><?php render_ai_review_cell($row['ai_analysis'] ?? null, 'seven', $row['id_seven']);?></td>
                    <td><?php renderRequirements($reqStatus); ?></td>
                    <td><?php renderStatus($rStatus); ?></td>
                    <td style="min-width:220px;">
                        <?php renderActions($row['id_seven'], $row['id_student'], $rStatus,
                            $row['fname'], $row['lname'], $row['mi'], '', $reqStatus); ?>
                    </td>
                </tr>

                <!-- View Modal -->
                <div class="modal fade" id="viewModal<?= $row['id_student'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-white" style="background:linear-gradient(135deg,#0b2b5c,#1f5a9e);">
                                <h5 class="modal-title">Student Information</h5>
                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body text-left">
                                <p><strong>School Year:</strong> <?= htmlspecialchars($row['sy']) ?></p>
                                <p><strong>LRN:</strong> <?= htmlspecialchars($row['lrn']) ?></p>
                                <hr style="border:2px solid black;opacity:1;">
                                <h5><strong>Personal Information</strong></h5>
                                <p><strong>Full Name:</strong> <?= htmlspecialchars($row['lname']) ?>, <?= htmlspecialchars($row['fname']) ?> <?= htmlspecialchars($row['mi']) ?></p>
                                <p><strong>Birthday:</strong> <?= htmlspecialchars($row['bdate']) ?></p>
                                <p><strong>Age:</strong> <?= htmlspecialchars($row['age']) ?></p>
                                <p><strong>Contact Number:</strong> <?= htmlspecialchars($row['contact']) ?></p>
                                <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                                <p><strong>Current Address:</strong> <?= htmlspecialchars($row['current_address']) ?></p>
                                <p><strong>Permanent Address:</strong> <?= htmlspecialchars($row['perm_address']) ?></p>
                                <hr style="border:2px solid black;opacity:1;">
                                <h5><strong>Father's Information</strong></h5>
                                <p><strong>Name:</strong> <?= htmlspecialchars($row['flname']) ?>, <?= htmlspecialchars($row['ffname']) ?> <?= htmlspecialchars($row['fmi']) ?></p>
                                <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact_f']) ?></p>
                                <hr style="border:2px solid black;opacity:1;">
                                <h5><strong>Mother's Information</strong></h5>
                                <p><strong>Name:</strong> <?= htmlspecialchars($row['mlname']) ?>, <?= htmlspecialchars($row['mfname']) ?> <?= htmlspecialchars($row['mmi']) ?></p>
                                <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact_m']) ?></p>
                                <hr style="border:2px solid black;opacity:1;">
                                <h5><strong>For Returning Learner</strong></h5>
                                <p><strong>Last Grade Level Completed:</strong> <?= htmlspecialchars($row['lglc']) ?></p>
                                <p><strong>Last School Attended:</strong> <?= htmlspecialchars($row['lsa']) ?></p>
                                <p><strong>Last School Year Completed:</strong> <?= htmlspecialchars($row['lysc']) ?></p>
                                <p><strong>School ID:</strong> <?= htmlspecialchars($row['school_id']) ?></p>
                                <hr style="border:2px solid black;opacity:1;">
                                <h5><strong>Socioeconomic Information</strong></h5>
                                <p><strong>IP Member:</strong> <?= htmlspecialchars($row['is_ip'] ?? 'No') ?><?= (!empty($row['ip_group'])) ? ' — ' . htmlspecialchars($row['ip_group']) : '' ?></p>
                                <p><strong>4Ps Beneficiary:</strong> <?= htmlspecialchars($row['is_4ps'] ?? 'No') ?><?= (!empty($row['fourps_id'])) ? ' — ID: ' . htmlspecialchars($row['fourps_id']) : '' ?></p>
                                <hr style="border:2px solid black;opacity:1;">
                                <p><strong>Status:</strong> <?php renderStatus($rStatus); ?></p>
                                <?php if ($rStatus === 'Rejected' && !empty($row['reject_reason'])): ?>
                                <p><strong>Rejection Reason:</strong> <?= htmlspecialchars($row['reject_reason']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <tr><td colspan="11" class="text-center text-muted py-4">No students found.</td></tr>
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
    var studentsTable_seven = $('#studentsTable').DataTable({ dom: 'rt', paging: false, order: [[2,'asc']], columnDefs: [{ orderable: false, targets: [0, 11] }] });

    // ===== Filter bar wiring: combined Name/Email search =====
    (function() {
        var table = studentsTable_seven;
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

        function runSearchSeven() {
            activeTerm = $('#filterSearchSeven').val().trim().toLowerCase();
            table.draw();
        }

        $('#filterSearchBtnSeven').on('click', runSearchSeven);

        $('#filterSearchSeven').on('keypress', function(e) {
            if (e.which === 13) { e.preventDefault(); runSearchSeven(); }
        });

        $('#filterClearBtnSeven').on('click', function() {
            $('#filterSearchSeven').val('');
            activeTerm = '';
            table.draw();
        });
    })();
});
</script>

<script>
/* ---- Document Viewer ---- */
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

/* ---- Approve confirm ---- */
function confirmApprove(form) {
    var row  = form.closest('tr');
    var name = row ? row.cells[1].innerText.trim() : 'this student';
    Swal.fire({
        title: 'Approve Enrollment?',
        html: 'Are you sure you want to approve <strong>' + name + "</strong>'s enrollment?<br><br>An email notification will be sent to the student.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0b2b5c',
        cancelButtonColor:  '#d33',
        confirmButtonText:  'Yes, Approve!',
        cancelButtonText:   'Cancel'
    }).then(function(result) {
        if (result.isConfirmed) { form.submit(); }
    });
    return false;
}

/* ---- Reject modal ---- */
function openRejectModal(id_seven, studentName) {
    document.getElementById('rejectIdSeven').value    = id_seven;
    document.getElementById('rejectStudentName').textContent = studentName;
    document.getElementById('reject_reason').value   = '';
    $('#rejectModal').modal('show');
}

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

function submitBulkAction(grade, action) {
    var checked = getBulkCheckboxes(grade);
    if (checked.length === 0) {
        Swal.fire('No selection', 'Please select at least one enrollment first.', 'warning');
        return;
    }
    var verb  = action === 'approve' ? 'approve' : 'archive';
    var color = action === 'approve' ? '#0b2b5c' : '#6c757d';
    Swal.fire({
        title: (action === 'approve' ? 'Bulk Approve' : 'Bulk Archive') + '?',
        html: 'This will ' + verb + ' <strong>' + checked.length + '</strong> selected enrollment(s).' +
              (action === 'approve' ? '<br><br>Email notifications will be sent to all selected students.' : ''),
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + (action === 'approve' ? 'Approve' : 'Archive') + '!',
        cancelButtonText: 'Cancel'
    }).then(function(result) {
        if (result.isConfirmed) {
            buildAndSubmitBulkForm(grade, action, checked, '');
        }
    });
}

function openBulkRejectModal(grade) {
    var checked = getBulkCheckboxes(grade);
    if (checked.length === 0) {
        Swal.fire('No selection', 'Please select at least one enrollment first.', 'warning');
        return;
    }
    document.getElementById('bulkRejectCount').textContent = checked.length;
    var reasonBox = document.getElementById('bulk_reject_reason_' + grade);
    if (reasonBox) reasonBox.value = '';
    $('#bulkRejectModal').modal('show');
}

function confirmBulkReject(grade) {
    var checked = getBulkCheckboxes(grade);
    var reason  = (document.getElementById('bulk_reject_reason_' + grade) || {}).value || '';
    $('#bulkRejectModal').modal('hide');
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

    form.submit();
}
</script>