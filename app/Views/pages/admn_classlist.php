<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>
<style>
.cl-header { padding:18px 24px; }
.filter-card { border-radius:10px; }
.preview-badge { font-size:12px; padding:4px 12px; border-radius:20px; }
.print-btn { background:linear-gradient(135deg,#1d6f42,#22884f); border:none; color:#fff; font-weight:700; font-size:14px; padding:10px 28px; border-radius:10px; transition:opacity .2s; }
.print-btn:hover { opacity:.85; color:#fff; }
.count-pill { background:rgba(var(--edb-chart-rgb),.08); color:var(--edb-ink); font-weight:700; font-size:13px; padding:5px 16px; border-radius:20px; border:1px solid rgba(var(--edb-chart-rgb),.25); }
.strand-section { margin-bottom: 10px; }

/* ===== PLAIN TABLE (Grade 7 style) — Excel-style grid ===== */
.cl-preview-card { border:1px solid #000 !important; border-radius:0 !important; }
.cl-preview-card .card-header { border:none; border-bottom:1px solid #000; }
#classlistTable { font-size:.84rem; border-collapse:collapse; width:100%; }
#classlistTable thead th {
    background:#f0f0f0; color:#000; border:1px solid #000;
    text-transform:none; letter-spacing:normal; font-size:.8rem;
    font-weight:700; padding:8px 10px; vertical-align:middle;
}
#classlistTable tbody td { padding:8px 10px; vertical-align:middle; border:1px solid #000; }
#classlistTable tbody tr { background:#fff; }
#classlistTable tbody tr:hover { background:#f5f5f5; }

html[data-theme="light"] #classlistTable,
html[data-theme="light"] #classlistTable thead th,
html[data-theme="light"] #classlistTable tbody td {
    color:#000 !important;
}
html[data-theme="dark"] #classlistTable,
html[data-theme="dark"] #classlistTable thead th,
html[data-theme="dark"] #classlistTable tbody td {
    color:#fff !important;
}
html[data-theme="dark"] .cl-preview-card,
html[data-theme="dark"] .cl-preview-card .card-header,
html[data-theme="dark"] #classlistTable thead th,
html[data-theme="dark"] #classlistTable tbody td {
    border-color:#fff !important;
}
html[data-theme="dark"] .cl-preview-card .card-header,
html[data-theme="dark"] #classlistTable thead th {
    background:#1e2432 !important;
}
html[data-theme="dark"] #classlistTable tbody tr { background:#12161f !important; }
html[data-theme="dark"] #classlistTable tbody tr:hover { background:#1a1f2b !important; }

.cl-preview-card .card-footer { background:#f8f9fc; color:#333; border-top:1px solid #000; }
html[data-theme="light"] .cl-preview-card .card-footer { background:#f8f9fc !important; color:#333 !important; }
html[data-theme="dark"] .cl-preview-card .card-footer { background:#1e2432 !important; color:#fff !important; border-top-color:#fff !important; }
</style>
<div class="container-fluid plain-page">
    <div class="cl-header plain-banner d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-1"><i class="fas fa-print mr-2"></i>Student List</h4>
            <small class="opacity-75">Generate a print-ready enrollment list per grade level.</small>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="admn_classlist.php" class="form-inline flex-wrap" style="gap:12px;">
                <div class="form-group mr-3 mb-2">
                    <label class="font-weight-bold mr-2">Grade Level</label>
                    <select name="grade" class="form-control" required>
                        <option value="">-- Select --</option>
                        <?php foreach ($grade_map as $val => $info): ?>
                            <option value="<?= $val ?>" <?= $grade === $val ? 'selected' : '' ?>><?= $info['label'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mr-3 mb-2">
                    <label class="font-weight-bold mr-2">School Year</label>
                    <select name="sy" class="form-control" required>
                        <?php foreach ($all_sy as $sy): ?>
                            <option value="<?= htmlspecialchars($sy) ?>" <?= $school_year === $sy ? 'selected' : '' ?>><?= htmlspecialchars($sy) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-filter mr-1"></i> Generate
                    </button>
                    <?php if ($grade && !empty($students)): ?>
                        <a href="admn_classlist.php?grade=<?= $grade ?>&sy=<?= urlencode($school_year) ?>&export=excel"
                           class="print-btn btn">
                            <i class="fas fa-file-excel mr-1"></i> Download Excel
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <?php if ($grade && $grade_info): ?>
    <!-- Preview -->
    <div class="card shadow mb-4 cl-preview-card">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list mr-1"></i>
                <?= $grade_info['label'] ?> — <?= $school_year ?: 'All School Years' ?>
            </h6>
            <span class="count-pill"><?= count($students) ?> student<?= count($students) != 1 ? 's' : '' ?></span>
        </div>
        <div class="card-body p-0">
            <?php if (empty($students)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 d-block" style="color:#ddd;"></i>
                    <p>No students found for this selection.</p>
                </div>
            <?php else: ?>
                <?php foreach ($grouped as $course => $rows): ?>
                    <?php if ($grade_info['shs']): ?>
                        <div class="strand-section">
                        <div class="px-3 pt-3">
                            <span class="badge badge-primary px-3 py-2" style="font-size:13px;"><?= htmlspecialchars($course) ?> — <?= count($rows) ?> student<?= count($rows)!=1?'s':'' ?></span>
                        </div>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="classlistTable" class="table table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th>LRN</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>M.I.</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                    <th>Birthday</th>
                                    <th>Contact</th>
                                    <?php if ($grade_info['shs']): ?><th>Strand</th><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $n=1; foreach ($rows as $s): ?>
                                <tr>
                                    <td><?= $n++ ?></td>
                                    <td><?= htmlspecialchars($s['lrn']??'') ?></td>
                                    <td><?= htmlspecialchars($s['lname']??'') ?></td>
                                    <td><?= htmlspecialchars($s['fname']??'') ?></td>
                                    <td><?= htmlspecialchars($s['mi']??'') ?></td>
                                    <td><?= htmlspecialchars($s['sex']??'') ?></td>
                                    <td><?= htmlspecialchars($s['age']??'') ?></td>
                                    <td><?= htmlspecialchars($s['bdate']??'') ?></td>
                                    <td><?= htmlspecialchars($s['contact']??'') ?></td>
                                    <?php if ($grade_info['shs']): ?><td><?= htmlspecialchars($s['course']??'') ?></td><?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if (!empty($students)): ?>
        <div class="card-footer text-muted small">
            <?= count($students) ?> student<?= count($students)!=1?'s':'' ?> · <?= $grade_info['label'] ?> · <?= $school_year ?: 'All Years' ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>