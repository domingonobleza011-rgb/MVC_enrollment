
<?php include(VIEWS_PATH . '/partials/staff_sidebar_start.php'); ?>

<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-key mr-2 text-success"></i>Change Password
            </h4>
            <small class="text-muted">Update the password for your teacher account.</small>
        </div>
        <a href="staff_dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header py-2" style="background:linear-gradient(135deg,#155724,#1e7e34);">
                    <span class="text-white font-weight-bold"><i class="fas fa-lock mr-1"></i> Update Password</span>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($userdetails['id_user']) ?>">

                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Old Password</label>
                            <input type="password" name="oldpassword" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">New Password</label>
                            <input type="password" name="newpassword" class="form-control" minlength="6" required>
                            <small class="text-muted">At least 6 characters.</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Verify New Password</label>
                            <input type="password" name="checkpassword" class="form-control" minlength="6" required>
                        </div>

                        <button type="submit" name="staff_changepass" class="btn btn-success px-4" style="border-radius:30px;">
                            <i class="fas fa-check-circle mr-1"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
