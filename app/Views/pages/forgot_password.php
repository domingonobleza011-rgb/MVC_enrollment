
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">
    <title>EPAMHS | Forgot Password</title>
    <link rel="manifest" href="manifest.php">
    <meta name="theme-color" content="#0b2b5c">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    
    /* Force full layout height baseline across documents */
    html, body { height: 100%; }

        body {
            font-family: 'Inter', sans-serif;
            background-image: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)), url('icons/Documents/eusebia.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
        }

    .navbar-custom {
        background: linear-gradient(135deg, #0b2b5c 0%, #0f3b7a 100%);
        padding: 0;
        box-shadow: 0 4px 20px rgba(0,0,0,.2);
        position: sticky;
        top: 0;
        z-index: 1000;
        flex-shrink: 0; /* Prevents navbar compression */
    }
    
    .navbar-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .8rem 1.5rem;
        gap: .75rem;
    }
    
    .navbar-brand {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: clamp(.95rem, 3vw, 1.35rem);
        color: white !important;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .navbar-logo { width: 38px; height: 38px; object-fit: contain; flex-shrink: 0; }
    @media (max-width: 480px) { .navbar-logo { width: 32px; height: 32px; } }
    
    .btn-portal {
        border-radius: 40px;
        padding: 7px 18px;
        font-weight: 600;
        font-size: .875rem;
        transition: all .2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
        background: rgba(255,215,0,.8);
        border: 1px solid #ffd700;
        color: #0b2b5c;
    }
    .btn-portal:hover { background: #ffd700; transform: translateY(-2px); color: #0b2b5c; }

    /* FIXED: Flex constraints configured and padding increased to keep the container tall and centered */
    .page-body {
        flex: 1 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1rem;
    }
    
    .login-container { max-width: 460px; width: 100%; margin: auto; }
    .header-content { text-align: center; margin-bottom: 2rem; }
    
    .login-logo {
        width: 88px;
        height: 88px;
        background: white;
        border-radius: 50%;
        padding: 11px;
        box-shadow: 0 8px 20px rgba(0,0,0,.15);
        margin-bottom: 1rem;
        transition: transform .2s;
    }
    .login-logo:hover { transform: scale(1.03); }
    
    /* Added text dropshadow extensions for legibility on fixed background canvases */
    .system-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: clamp(1.3rem, 4vw, 1.75rem);
        color: #fff;
        margin-bottom: .25rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    
    .sub-title {
        color: rgba(255,215,0,.95);
        font-size: .88rem;
        letter-spacing: .5px;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    
    .login-card {
        background: white;
        border: none;
        border-radius: 32px;
        box-shadow: 0 25px 45px -12px rgba(0,0,0,.4);
        overflow: hidden;
    }
    .login-card .card-body { padding: 2.5rem 2rem; }
    
    .card-heading { text-align: center; margin-bottom: 1.5rem; }
    .card-heading .icon-wrap {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: .75rem;
    }
    .card-heading .icon-wrap i { color: white; font-size: 1.5rem; }
    
    .card-heading h5 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #0b2b5c;
        font-size: 1.4rem;
        margin-bottom: .3rem;
    }
    .card-heading p { color: #64748b; font-size: .88rem; }
    
    .form-label {
        font-weight: 600;
        font-size: .82rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #1f3a5f;
        margin-bottom: .45rem;
        display: block;
    }
    
    .input-group-custom {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        transition: all .2s;
        margin-bottom: 1.2rem;
    }
    .input-group-custom:focus-within {
        border-color: #2a6f9c;
        box-shadow: 0 0 0 3px rgba(42,111,156,.14);
        background: white;
    }
    
    .input-icon { padding: .75rem 0 .75rem 1.15rem; color: #2a6f9c; font-size: .95rem; }
    .input-field {
        width: 100%;
        padding: .75rem 1rem .75rem .5rem;
        border: none;
        background: transparent;
        outline: none;
        font-size: .95rem;
        font-weight: 500;
        color: #1a2c3e;
    }
    .input-field::placeholder { color: #a0afc0; font-weight: 400; }
    
    .btn-submit {
        background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
        border: none;
        border-radius: 40px;
        padding: .8rem;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        color: white;
        transition: all .2s;
        margin-bottom: 1rem;
        cursor: pointer;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #1f3a6b, #2a6f9c);
        box-shadow: 0 8px 18px rgba(11,43,92,.25);
    }
    
    .btn-back {
        background: #eef2ff;
        border: 1.5px solid #cbd5e1;
        border-radius: 40px;
        padding: .8rem;
        font-weight: 600;
        font-size: .9rem;
        width: 100%;
        color: #1f3a5f;
        transition: all .2s;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
    }
    .btn-back:hover { background: #e2e8f0; transform: translateY(-1px); color: #1f3a5f; }
    
    .alert { border-radius: 16px; font-size: .88rem; padding: 1rem; }

    .recovery-tabs {
        display: flex;
        background: #eef2ff;
        border-radius: 40px;
        padding: 4px;
        margin-bottom: 1.4rem;
    }
    .recovery-tab {
        flex: 1;
        border: none;
        background: transparent;
        border-radius: 40px;
        padding: .55rem .5rem;
        font-weight: 600;
        font-size: .85rem;
        color: #5f6368;
        cursor: pointer;
        transition: all .2s;
    }
    .recovery-tab.active {
        background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
        color: #fff;
        box-shadow: 0 4px 10px rgba(11,43,92,.25);
    }
    .security-question-text {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: .75rem 1rem;
        font-size: .92rem;
        font-weight: 600;
        color: #1a2c3e;
        margin-bottom: 1.2rem;
    }
    
    /* FIXED: Pushes elements down cleanly and retains a flat shape without crunching sizes */
    footer {
        background: #0b1f33;
        color: #cddcec;
        padding: 1.25rem 1rem;
        text-align: center;
        font-size: .78rem;
        flex-shrink: 0;
        border-top: 1px solid rgba(255,255,255,0.05);
    }
    
    @media(max-width:500px) {
        .login-card .card-body { padding: 1.8rem 1.3rem; }
        .page-body { padding: 2rem 1rem; }
    }
</style>
</head>
<body>
<?php include(VIEWS_PATH . '/partials/admin_loading_overlay.php'); ?>
<nav class="navbar-custom">
    <div class="navbar-inner">
        <a class="navbar-brand" href="index.php"><img src="icons/Documents/eusebia.png" alt="EPAMNHS logo" class="navbar-logo"><span>EPAMNHS Portal</span></a>
        <a href="login.php" class="btn-portal" onclick="showAdminLoading('Returning to login...', 'arrow-left'); window.location.href='login.php'; return false;"><i class="fas fa-arrow-left"></i> Back to Login</a>
    </div>
</nav>

<div class="page-body">
    <div class="login-container">
        <div class="header-content">
            <img src="icons/Documents/eusebia.png" class="login-logo" alt="School Seal">
            <h2 class="system-title">Eusebia Paz Arroyo Memorial National High School</h2>
            <p class="sub-title">Buluang, Baao, Camarines Sur</p>
        </div>
        <div class="card login-card">
            <div class="card-body">
                <div class="card-heading">
                    <div class="icon-wrap"><i class="fas fa-key"></i></div>
                    <h5>Forgot Password?</h5>
                    <p>Reset it using your email, or your phone number and security question.</p>
                </div>

                <!-- ========== TABS ========== -->
                <div class="recovery-tabs">
                    <button type="button" class="recovery-tab <?= $active_tab === 'email' ? 'active' : '' ?>" data-tab="email">
                        <i class="fas fa-envelope me-1"></i> Email
                    </button>
                    <button type="button" class="recovery-tab <?= $active_tab === 'phone' ? 'active' : '' ?>" data-tab="phone">
                        <i class="fas fa-mobile-screen me-1"></i> Phone Number
                    </button>
                </div>

                <!-- ========== EMAIL TAB ========== -->
                <div class="recovery-panel" id="panel-email" style="<?= $active_tab === 'phone' ? 'display:none;' : '' ?>">
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?= $message_type ?> mb-3">
                            <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($email_message)): ?>
                        <div class="alert alert-<?= $email_message_type ?> mb-3">
                            <i class="fas fa-<?= $email_message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
                            <?= htmlspecialchars($email_message) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($message_type !== 'success' && $email_step === 'email'): ?>
                    <form method="post" onsubmit="showAdminLoading('Checking your email...', 'paper-plane');">
                        <label class="form-label">Registered Email</label>
                        <div class="input-group-custom">
                            <div class="input-icon"><i class="fas fa-envelope"></i></div>
                            <input class="input-field" type="email" name="email"
                                   placeholder="your.email@example.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   required>
                        </div>
                        <button class="btn-submit" type="submit" name="send_reset">
                            <i class="fas fa-paper-plane me-2"></i> Continue
                        </button>
                    </form>

                    <?php elseif ($email_step === 'answer'): ?>
                        <!-- Student account with a security question set - reset instantly instead of waiting on the emailed link -->
                        <form method="post">
                            <label class="form-label">Security Question</label>
                            <p class="security-question-text"><?= htmlspecialchars($email_question) ?></p>

                            <label class="form-label">Your Answer</label>
                            <div class="input-group-custom">
                                <div class="input-icon"><i class="fas fa-circle-question"></i></div>
                                <input class="input-field" type="text" name="security_answer" autocomplete="off" required>
                            </div>

                            <label class="form-label">New Password</label>
                            <div class="input-group-custom">
                                <div class="input-icon"><i class="fas fa-key"></i></div>
                                <input class="input-field" type="password" name="newpassword" required>
                            </div>

                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group-custom">
                                <div class="input-icon"><i class="fas fa-user-lock"></i></div>
                                <input class="input-field" type="password" name="checkpassword" required>
                            </div>

                            <button class="btn-submit" type="submit" name="email_reset">
                                <i class="fas fa-check me-2"></i> Reset Password
                            </button>
                        </form>
                    <?php endif; ?>
                    <!-- 'done' step shows only the success alert above, no form -->
                </div>

                <!-- ========== PHONE NUMBER TAB (students) ========== -->
                <div class="recovery-panel" id="panel-phone" style="<?= $active_tab === 'phone' ? '' : 'display:none;' ?>">
                    <?php if (!empty($phone_message)): ?>
                        <div class="alert alert-<?= $phone_message_type ?> mb-3">
                            <i class="fas fa-<?= $phone_message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
                            <?= htmlspecialchars($phone_message) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($phone_step === 'phone'): ?>
                        <!-- Step 1: enter phone number -->
                        <form method="post">
                            <label class="form-label">Registered Phone Number</label>
                            <div class="input-group-custom">
                                <div class="input-icon"><i class="fas fa-mobile-screen"></i></div>
                                <input class="input-field" type="tel" name="phone"
                                       placeholder="09XXXXXXXXX"
                                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                                       required>
                            </div>
                            <button class="btn-submit" type="submit" name="phone_lookup">
                                <i class="fas fa-arrow-right me-2"></i> Continue
                            </button>
                        </form>

                    <?php elseif ($phone_step === 'answer'): ?>
                        <!-- Step 2: answer the security question and set a new password -->
                        <form method="post">
                            <label class="form-label">Security Question</label>
                            <p class="security-question-text"><?= htmlspecialchars($phone_question) ?></p>

                            <label class="form-label">Your Answer</label>
                            <div class="input-group-custom">
                                <div class="input-icon"><i class="fas fa-circle-question"></i></div>
                                <input class="input-field" type="text" name="security_answer" autocomplete="off" required>
                            </div>

                            <label class="form-label">New Password</label>
                            <div class="input-group-custom">
                                <div class="input-icon"><i class="fas fa-key"></i></div>
                                <input class="input-field" type="password" name="newpassword" required>
                            </div>

                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group-custom">
                                <div class="input-icon"><i class="fas fa-user-lock"></i></div>
                                <input class="input-field" type="password" name="checkpassword" required>
                            </div>

                            <button class="btn-submit" type="submit" name="phone_reset">
                                <i class="fas fa-check me-2"></i> Reset Password
                            </button>
                        </form>
                    <?php endif; ?>
                    <!-- 'done' step shows only the success alert above, no form -->
                </div>

                <a href="login.php" class="btn-back" onclick="showAdminLoading('Returning to login...', 'arrow-left'); window.location.href='login.php'; return false;"><i class="fas fa-arrow-left me-2"></i> Back to Login</a>
            </div>
        </div>
    </div>
</div>

<footer>
    <i class="fas fa-school me-2"></i> Eusebia Paz Arroyo Memorial National High School
    <br><small><?= date('Y') ?> EPAMNHS. All rights reserved.</small>
</footer>
<script>
    document.querySelectorAll('.recovery-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.recovery-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('panel-email').style.display = this.dataset.tab === 'email' ? '' : 'none';
            document.getElementById('panel-phone').style.display = this.dataset.tab === 'phone' ? '' : 'none';
        });
    });
</script>
<script src="js/pwa.js"></script>
</body>
</html>