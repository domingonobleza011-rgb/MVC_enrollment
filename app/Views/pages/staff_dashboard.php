
<?php include(VIEWS_PATH . '/partials/staff_sidebar_start.php'); ?>

<div class="container-fluid">

    <!-- Welcome Banner -->
    <div class="card mb-4 border-0 shadow-sm" style="background:linear-gradient(135deg,#155724,#1e7e34);border-radius:16px;">
        <div class="card-body py-4 px-4 text-white">
            <div class="d-flex align-items-center">
                <div class="mr-4">
                    <div style="width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                </div>
                <div>
                    <h4 class="mb-0 font-weight-bold">
                        Welcome, <?= htmlspecialchars(($userdetails['lname'] ?? '') . ', ' . ($userdetails['fname'] ?? '')) ?>!
                    </h4>
                    <p class="mb-1 mt-1" style="opacity:.85;">
                        <i class="fas fa-id-badge mr-1"></i><?= htmlspecialchars($userdetails['position'] ?? 'Teacher') ?>
                        &nbsp;|&nbsp;
                        <i class="fas fa-book mr-1"></i>
                        <?= $subject_handled ? htmlspecialchars($subject_handled) : '<em>No subjects assigned</em>' ?>
                    </p>
                    <?php if ($adviser_grade): ?>
                    <span class="badge" style="background:#ffd700;color:#0b2b5c;font-size:.85rem;padding:5px 12px;">
                        <i class="fas fa-star mr-1"></i>Adviser: <?= htmlspecialchars($adviser_grade) ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (!$adviser_grade): ?>
    <!-- No assignment notice -->
    <div class="alert alert-warning shadow-sm" style="border-radius:12px;">
        <h5 class="mb-1"><i class="fas fa-exclamation-triangle mr-2"></i>No Class Assigned Yet</h5>
        <p class="mb-0">You have not been assigned an advisory class or subjects yet. Please contact your administrator.</p>
    </div>

    <?php else: ?>
    <!-- Stat Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">My Advisory Class</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $adviser_count ?> students</div>
                            <small class="text-muted"><?= htmlspecialchars($adviser_grade) ?></small>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Subjects Handled</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= count($subjects) ?: '—' ?></div>
                            <small class="text-muted"><?= $subject_handled ? htmlspecialchars($subject_handled) : 'None assigned' ?></small>
                        </div>
                        <div class="col-auto"><i class="fas fa-book-open fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">School Year</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= date('Y') . '-' . (date('Y')+1) ?></div>
                            <small class="text-muted">Current SY</small>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advisory Class Card -->
    <?php if ($adviser_grade && isset($grade_url_map[$adviser_grade])): ?>
    <div class="card shadow-sm mb-3">
        <div class="card-header font-weight-bold text-white py-2" style="background:linear-gradient(135deg,#0b2b5c,#0f3b7a);">
            <i class="fas fa-star mr-1" style="color:#ffd700;"></i> Advisory Class
        </div>
        <div class="card-body text-center py-3">
            <h5 class="font-weight-bold mb-2"><?= htmlspecialchars($adviser_grade) ?></h5>
            <a href="<?= htmlspecialchars($grade_url_map[$adviser_grade]['url']) ?>" class="btn btn-warning shadow-sm" style="border-radius:40px;padding:.6rem 2rem;">
                <i class="fas fa-star mr-2"></i> View Advisory Students
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Subject Grade Cards -->
    <?php if (!empty($subject_list)): ?>
    <div class="card shadow-sm mb-3">
        <div class="card-header font-weight-bold text-white py-2" style="background:linear-gradient(135deg,#0b2b5c,#0f3b7a);">
            <i class="fas fa-book mr-1"></i> My Subject Classes
        </div>
        <div class="card-body">
            <div class="row">
            <?php foreach ($subject_list as $sg):
                if (!isset($grade_url_map[$sg])) continue;
                $is_adv = ($sg === $adviser_grade);
            ?>
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="<?= htmlspecialchars($grade_url_map[$sg]['url']) ?>"
                   class="btn btn-block shadow-sm <?= $is_adv ? 'btn-warning' : 'btn-primary' ?>"
                   style="border-radius:10px;font-size:.85rem;padding:.6rem;">
                    <i class="fas fa-users mr-1"></i> <?= htmlspecialchars($sg) ?>
                    <?php if ($is_adv): ?>
                    <br><small style="color:#0b2b5c;"><i class="fas fa-star"></i> Advisory</small>
                    <?php endif; ?>
                </a>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php endif; ?>

</div>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>