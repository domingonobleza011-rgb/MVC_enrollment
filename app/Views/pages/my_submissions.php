
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.php">
    <meta name="theme-color" content="#0b2b5c">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="EPAMNHS">
    <link rel="apple-touch-icon" href="icons/pwa/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="192x192" href="icons/pwa/icon-192x192.png">
    <title>My Submissions | EPAMHS Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #f8faff 0%, #f0f4fe 100%);
            background-attachment: fixed;
            color: #1a2c3e;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #0b2b5c 0%, #0f3b7a 100%);
            padding: 0.9rem 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 1.5rem; color: white !important;
        }
        .dropdown-toggle-custom {
            background: rgba(255,255,255,0.12);
            border-radius: 40px; padding: 8px 20px;
            border: 1px solid rgba(255,255,255,0.25);
            color: white !important; font-weight: 500; transition: all 0.2s;
        }
        .dropdown-toggle-custom:hover { background: rgba(255,255,255,0.25); }
        .dropdown-menu-custom {
            border: none; border-radius: 20px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            padding: 12px 6px; min-width: 210px;
            background: #ffffffdd; backdrop-filter: blur(12px);
        }
        .dropdown-item-custom {
            border-radius: 16px; padding: 10px 18px;
            font-weight: 500; transition: all 0.2s; color: #0b2b5c;
        }
        .dropdown-item-custom i { width: 28px; margin-right: 6px; }
        .dropdown-item-custom:hover { background: #eef2ff; transform: translateX(5px); }
        .dropdown-item-custom.active-page { background: #e8eeff; color: #0b2b5c; font-weight: 600; }

        .page-header {
            background: linear-gradient(135deg, #0b2b5c 0%, #1e5a88 100%);
            padding: 2.5rem 1rem 3rem; color: white; text-align: center; position: relative; overflow: hidden;
        }
        .page-header::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.06), transparent 60%);
        }
        .page-header h1 { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; position: relative; }
        .page-header p { opacity: 0.8; position: relative; }
        .header-badge {
            background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);
            border-radius: 80px; display: inline-block; padding: 0.3rem 1.2rem;
            font-size: 0.85rem; font-weight: 500; margin-bottom: 1rem;
        }

        .submissions-section { padding: 1rem 1rem 4rem; }
        .submission-card {
            background: white; border-radius: 24px;
            box-shadow: 0 8px 30px -10px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05); overflow: hidden; transition: all 0.3s;
        }
        .submission-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px -12px rgba(0,0,0,0.18); }
        .card-header-custom {
            padding: 1.2rem 1.5rem; display: flex; align-items: center;
            justify-content: space-between; border-bottom: 1px solid #f1f5f9;
        }
        .grade-badge-card {
            background: #0b2b5c;
            color: white; border-radius: 12px; padding: 0.4rem 1rem;
            font-weight: 700; font-size: 0.9rem;
        }
        .status-badge {
            border-radius: 80px; padding: 0.35rem 1rem; font-weight: 600;
            font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;
        }
        .status-badge.pending  { background: #fef3c7; color: #92400e; }
        .status-badge.approved { background: #d1fae5; color: #065f46; }
        .status-badge.rejected { background: #fee2e2; color: #991b1b; }
        .card-body-custom { padding: 1.5rem; }
        .info-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem;
        }
        .info-item label {
            display: block; font-size: 0.72rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; margin-bottom: 3px;
        }
        .info-item span { font-weight: 600; color: #1e293b; font-size: 0.9rem; }
        .reject-reason-box {
            background: #fff5f5; border: 1px solid #fecaca; border-radius: 12px;
            padding: 0.9rem 1.2rem; margin-top: 1rem; font-size: 0.875rem; color: #7f1d1d;
        }

        .status-timeline {
            display: flex; align-items: center; margin-top: 1rem; padding: 0.75rem 0;
        }
        .timeline-step { flex: 1; text-align: center; position: relative; }
        .timeline-step::after {
            content: ''; position: absolute; top: 14px; left: 50%;
            width: 100%; height: 2px; background: #e2e8f0; z-index: 0;
        }
        .timeline-step:last-child::after { display: none; }
        .step-dot {
            width: 28px; height: 28px; border-radius: 50%; background: #e2e8f0;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700; position: relative; z-index: 1;
            color: #94a3b8; border: 2px solid #e2e8f0;
        }
        .step-dot.done   { background: #10b981; border-color: #10b981; color: white; }
        .step-dot.active { background: #f59e0b; border-color: #f59e0b; color: white; }
        .step-dot.failed { background: #ef4444; border-color: #ef4444; color: white; }
        .step-label { font-size: 0.68rem; font-weight: 600; color: #94a3b8; margin-top: 4px; }
        .step-label.done   { color: #059669; }
        .step-label.active { color: #d97706; }
        .step-label.failed { color: #dc2626; }

        .empty-state {
            text-align: center; padding: 4rem 1rem; background: white;
            border-radius: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .empty-icon { font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem; }
        .empty-state h4 { font-weight: 700; color: #334155; }
        .empty-state p  { color: #64748b; }
        .btn-go-enroll {
            background: linear-gradient(135deg, #0b2b5c, #1e5a88); color: white;
            border: none; border-radius: 80px; padding: 0.65rem 2rem; font-weight: 600;
            text-decoration: none; display: inline-block; transition: all 0.2s; margin-top: 1rem;
        }
        .btn-go-enroll:hover { transform: translateY(-2px); color: white; opacity: 0.9; }

        .footer-custom {
            background: #0b1f33; color: #cddcec; padding: 2rem 1rem;
            text-align: center; font-size: 0.9rem;
            border-top-left-radius: 32px; border-top-right-radius: 32px;
        }
    </style>
</head>
<body>

<?php $active_page = 'submissions'; include(VIEWS_PATH . '/partials/student_navbar.php'); ?>



<!-- Submissions -->
<div class="submissions-section">
    <div class="container">

        <?php if (empty($all_submissions)): ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
            <h4>No Submissions Yet</h4>
            <p class="mt-2">You haven't submitted any enrollment forms yet.<br>Head back to the dashboard to choose your grade level and apply.</p>
            <a href="student_homepage.php" class="btn-go-enroll">
                <i class="fas fa-arrow-right me-2"></i> Go to Dashboard
            </a>
        </div>

        <?php else: ?>

        <div class="row g-4" id="submissionsGrid">
            <?php foreach ($all_submissions as $sub):
                $status      = strtolower($sub['enrollment_status'] ?? 'pending');
                $statusLabel = ucfirst($status);
                $statusIcon  = $status === 'approved' ? 'fa-check-circle' : ($status === 'rejected' ? 'fa-times-circle' : 'fa-hourglass-half');
                $sy          = htmlspecialchars($sub['sy'] ?? 'N/A');
                $lrn         = htmlspecialchars($sub['lrn'] ?? 'N/A');
                $name        = htmlspecialchars(($sub['lname'] ?? '') . ', ' . ($sub['fname'] ?? '') . ' ' . ($sub['mi'] ?? ''));
                $course      = htmlspecialchars($sub['course'] ?? '');
                $rejectReason = htmlspecialchars($sub['reject_reason'] ?? '');
            ?>
            <div class="col-12 col-md-6 submission-item" data-status="<?= $status ?>">
                <div class="submission-card">
                    <div class="card-header-custom">
                        <div>
                            <div class="grade-badge-card"><?= htmlspecialchars($sub['grade_label']) ?></div>
                            <div class="mt-1" style="font-size:0.78rem; color:#94a3b8;">
                                <?= htmlspecialchars($sub['grade_level']) ?>
                            </div>
                        </div>
                        <div class="status-badge <?= $status ?>">
                            <i class="fas <?= $statusIcon ?>"></i> <?= $statusLabel ?>
                        </div>
                    </div>

                    <div class="card-body-custom">
                        <!-- Timeline -->
                        <div class="status-timeline">
                            <div class="timeline-step">
                                <div class="step-dot done"><i class="fas fa-paper-plane" style="font-size:0.6rem"></i></div>
                                <div class="step-label done">Submitted</div>
                            </div>
                            <div class="timeline-step">
                                <div class="step-dot <?= $status !== 'pending' ? 'done' : 'active' ?>">
                                    <i class="fas fa-search" style="font-size:0.6rem"></i>
                                </div>
                                <div class="step-label <?= $status !== 'pending' ? 'done' : 'active' ?>">Under Review</div>
                            </div>
                            <div class="timeline-step">
                                <div class="step-dot <?= $status === 'approved' ? 'done' : ($status === 'rejected' ? 'failed' : '') ?>">
                                    <i class="fas <?= $status === 'rejected' ? 'fa-times' : 'fa-check' ?>" style="font-size:0.6rem"></i>
                                </div>
                                <div class="step-label <?= $status === 'approved' ? 'done' : ($status === 'rejected' ? 'failed' : '') ?>">
                                    <?= $status === 'rejected' ? 'Rejected' : 'Approved' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="info-grid mt-3">
                            <div class="info-item">
                                <label><i class="fas fa-user me-1"></i> Full Name</label>
                                <span><?= $name ?></span>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-id-badge me-1"></i> LRN</label>
                                <span><?= $lrn ?></span>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-calendar me-1"></i> School Year</label>
                                <span><?= $sy ?></span>
                            </div>
                            <?php if ($course): ?>
                            <div class="info-item">
                                <label><i class="fas fa-book me-1"></i> Strand / Course</label>
                                <span><?= $course ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($status === 'rejected'): ?>
                        <?php if ($rejectReason): ?>
                        <div class="reject-reason-box mt-3">
                            <strong><i class="fas fa-exclamation-circle me-1" style="color:#ef4444"></i> Reason for Rejection:</strong><br>
                            <?= $rejectReason ?>
                        </div>
                        <?php endif; ?>
                        <div class="mt-3 text-end">
                            <a href="<?= htmlspecialchars($sub['edit_page']) ?>?edit=<?= (int)$sub['edit_pk'] ?>&grade=<?= (int)$sub['edit_grade'] ?>" class="btn btn-sm rounded-pill px-3" style="background:#0b2b5c; color:#fff;">
                                <i class="fas fa-edit me-1"></i> Edit &amp; Resubmit
                            </a>
                        </div>
                        <?php elseif ($status === 'approved'): ?>
                        <div class="mt-3 p-3 rounded-3" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                            <i class="fas fa-info-circle text-success me-1"></i>
                            <span style="color:#065f46; font-size:0.85rem; font-weight:500;">
                                Your enrollment is <strong>approved</strong>. Please visit the school to complete your requirements.
                            </span>
                        </div>
                        <?php elseif ($status === 'pending'): ?>
                        <div class="mt-3 p-3 rounded-3" style="background:#fffbeb; border:1px solid #fde68a;">
                            <i class="fas fa-info-circle" style="color:#b45309;"></i>
                            <span style="color:#92400e; font-size:0.85rem; font-weight:500;">
                                Your application is <strong>under review</strong>. You will be notified via email once a decision is made.
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>
    </div>
</div>

<!-- ============================================================
     PROMOTION REQUESTS SECTION
     ============================================================ -->
<?php if (!empty($my_promotion_requests)): ?>
<div class="container-fluid px-4 pb-4">
    <div class="card" style="border:none; border-radius:14px; box-shadow:0 2px 14px rgba(11,43,92,.10);">
        <div class="card-header" style="background:#0b2b5c; color:#fff; border-radius:14px 14px 0 0; font-weight:600;">
            <i class="fas fa-level-up-alt me-2"></i> My Promotion Requests
            <a href="promotion_request.php" class="btn btn-sm btn-light float-end" style="font-size:.82rem;">
                <i class="fas fa-plus me-1"></i> New Request
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr>
                            <th>#</th>
                            <th>From Grade</th>
                            <th>To Grade</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($my_promotion_requests as $i => $pr): ?>
                        <?php $st = strtolower($pr['status']); ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>Grade <?= htmlspecialchars($pr['from_grade']) ?></td>
                            <td>Grade <?= htmlspecialchars($pr['to_grade']) ?></td>
                            <td style="font-size:.85rem;"><?= htmlspecialchars($pr['submitted_at']) ?></td>
                            <td>
                                <span style="border-radius:20px; padding:3px 13px; font-size:.82rem; font-weight:600;
                                    <?= $st==='pending'  ? 'background:#fef3c7;color:#92400e;' :
                                       ($st==='approved' ? 'background:#d1fae5;color:#065f46;' :
                                                           'background:#fee2e2;color:#991b1b;') ?>">
                                    <?= htmlspecialchars($pr['status']) ?>
                                </span>
                            </td>
                            <td style="font-size:.85rem;">
                                <?php if ($st === 'approved'): ?>
                                    <i class="fas fa-check-circle text-success"></i> Promoted to Grade <?= htmlspecialchars($pr['to_grade']) ?>
                                <?php elseif ($st === 'rejected' && $pr['reject_reason']): ?>
                                    <i class="fas fa-times-circle text-danger"></i> <?= htmlspecialchars($pr['reject_reason']) ?>
                                <?php else: ?>
                                    <span class="text-muted">Waiting for admin review…</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php else: ?>

<?php endif; ?>
<!-- ============================================================ -->

<?php if (!empty($_SESSION['swal'])):
    $swal = $_SESSION['swal'];
    unset($_SESSION['swal']);
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon:  '<?= $swal['icon'] ?>',
            title: '<?= addslashes($swal['title']) ?>',
            text:  '<?= addslashes($swal['text'] ?? '') ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6',
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
<?php endif; ?>

<?php include(VIEWS_PATH . '/partials/student_footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/pwa.js"></script>
</body>
</html>