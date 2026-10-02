<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">
    <title>EPAMNHS | Login</title>
<link rel="manifest" href="manifest.php">
<meta name="theme-color" content="#0b2b5c">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 (same success/error dialog used across the portal) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        /* ── NAVBAR ── */
        .navbar-custom {
            background: linear-gradient(135deg, #0b2b5c 0%, #0f3b7a 100%);
            padding: 0;
            box-shadow: 0 4px 20px rgba(0,0,0,.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .55rem 1rem;
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
            flex-shrink: 1;
            min-width: 0;
        }

        .navbar-brand span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-portal {
            border-radius: 40px;
            padding: 6px 14px;
            font-weight: 600;
            font-size: .82rem;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
            background: rgba(255,215,0,.8);
            border: 1px solid #ffd700;
            color: #0b2b5c;
            flex-shrink: 0;
        }

        .btn-portal:hover {
            background: #ffd700;
            transform: translateY(-2px);
            color: #0b2b5c;
        }

        @media (max-width: 400px) {
            .btn-portal .btn-label { display: none; }
            .btn-portal { padding: 9px 11px; margin: -2px 0; border-radius: 50%; }
        }

        /* ── PAGE BODY ──
           The whole page is sized to fit one screen (min-height = viewport, and
           dvh so mobile browser bars are accounted for). Everything below is
           compact by default and only gets roomier when the screen has space. */
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

        .page-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: .75rem;
        }

        /* ── LOGIN CONTAINER ── */
        .login-container {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
        }

        .header-content {
            text-align: center;
            margin-bottom: .7rem;
        }

        .login-logo {
            width: 56px;
            height: 56px;
            background: white;
            border-radius: 50%;
            padding: 7px;
            box-shadow: 0 6px 16px rgba(0,0,0,.15);
            margin-bottom: .45rem;
            transition: transform .2s;
        }

        .login-logo:hover { transform: scale(1.03); }

        .system-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: clamp(1rem, 4.2vw, 1.25rem);
            line-height: 1.2;
            color: #ffffff;
            margin-bottom: .15rem;
        }

        .sub-title {
            color: rgba(255,215,0,.85);
            font-size: .78rem;
            letter-spacing: .4px;
        }

        /* ── CARD ── */
        .login-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,.3);
            overflow: hidden;
        }

        .login-card .card-body { padding: 1.1rem 1.15rem; }

        /* ── FORM ── */
        .form-label {
            font-weight: 600;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #1f3a5f;
            margin-bottom: .25rem;
            display: block;
        }

        .input-group-custom {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            transition: all .2s;
            margin-bottom: .7rem;
        }

        .input-group-custom:focus-within {
            border-color: #2a6f9c;
            box-shadow: 0 0 0 3px rgba(42,111,156,.14);
            background: white;
        }

        .input-icon {
            padding: .5rem 0 .5rem .9rem;
            color: #2a6f9c;
            font-size: .9rem;
        }

        .input-field {
            width: 100%;
            padding: .55rem .85rem .55rem .5rem;
            border: none;
            background: transparent;
            outline: none;
            font-size: 1rem;              /* 16px: stops iOS from zooming in on focus */
            font-weight: 500;
            color: #1a2c3e;
        }

        .input-field::placeholder { color: #a0afc0; font-weight: 400; }

        .input-field.is-invalid { color: #dc3545; }
        .input-group-custom:has(.input-field.is-invalid) {
            border-color: #dc3545;
            background: #fff5f5;
        }

        /* "Show password" (left) + "Forgot password?" (right) share one row */
        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            margin: 0 0 .8rem;
        }

        .form-switch-custom {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-switch-custom .form-check-input {
            width: 2rem;
            cursor: pointer;
            background-color: #cbd5e1;
            border-color: #94a3b8;
        }

        .form-switch-custom .form-check-input:checked {
            background-color: #2a6f9c;
            border-color: #2a6f9c;
        }

        .form-switch-custom label {
            font-size: .82rem;
            color: #334155;
            cursor: pointer;
            padding: .6rem 0;               /* bigger tap area ... */
            margin: -.6rem 0;               /* ... without taking any extra height */
        }

        .forgot-link {
            font-size: .82rem;
            font-weight: 500;
            color: #2a6f9c;
            text-decoration: none;
            white-space: nowrap;
            padding: .6rem .25rem;          /* bigger tap area ... */
            margin: -.6rem -.25rem;         /* ... without taking any extra height */
        }

        .forgot-link:hover { color: #1f5a9e; text-decoration: underline; }

        /* ── SOCIAL BUTTONS ── */
        .social-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: .8rem 0;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .social-divider span {
            font-size: .76rem;
            color: #94a3b8;
            font-weight: 500;
            white-space: nowrap;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .65rem;
            width: 100%;
            padding: .6rem 1rem;
            border-radius: 40px;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            border: 1.5px solid;
        }

        .btn-google {
            background: #ffffff;
            border-color: #dadce0;
            color: #3c4043;
        }

        .btn-google:hover {
            background: #f8f9fa;
            box-shadow: 0 2px 10px rgba(0,0,0,.12);
            transform: translateY(-1px);
            color: #3c4043;
        }

        .btn-facebook {
            background: #1877f2;
            border-color: #1877f2;
            color: #ffffff;
        }

        .btn-facebook:hover {
            background: #0c63d4;
            border-color: #0c63d4;
            box-shadow: 0 2px 10px rgba(24,119,242,.35);
            transform: translateY(-1px);
            color: #ffffff;
        }

        .btn-social .social-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* ── BUTTONS ── */
        .btn-login-submit {
            background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
            border: none;
            border-radius: 40px;
            padding: .65rem;
            font-weight: 600;
            font-size: .98rem;
            width: 100%;
            color: white;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-login-submit:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #1f3a6b, #2a6f9c);
            box-shadow: 0 8px 18px rgba(11,43,92,.25);
        }

        .btn-login-submit:disabled {
            opacity: .8;
            cursor: not-allowed;
            transform: none;
        }

        .login-spinner {
            display: none;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255,255,255,.45);
            border-top-color: #fff;
            border-radius: 50%;
            animation: loginSpin .7s linear infinite;
            vertical-align: -2px;
            margin-right: .55rem;
        }

        .btn-login-submit.is-loading .login-spinner {
            display: inline-block;
        }

        @keyframes loginSpin {
            to { transform: rotate(360deg); }
        }

        /* "Don't have an account yet? Create Account" on one line */
        .register-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: .1rem .4rem;
            margin-top: .6rem;
            font-size: .85rem;
            color: #334155;
        }

        .btn-register-link {
            background: none;
            border: none;
            padding: .7rem .4rem;           /* comfortable tap target ... */
            margin: -.3rem 0;               /* ... without taking any extra height */
            font-weight: 600;
            font-size: .85rem;
            color: #1f5a9e;
            cursor: pointer;
        }

        .btn-register-link:hover { color: #0b2b5c; text-decoration: underline; }

        /* ── FOOTER ── */
        footer {
            background: #0b1f33;
            color: #cddcec;
            padding: .55rem 1rem;
            text-align: center;
            font-size: .78rem;
        }

        /* ── ROOMIER SIZING, only when the screen actually has the space ──
           (tall phones, tablets, laptops and desktops)                         */
        @media (min-height: 760px), (min-width: 576px) and (min-height: 560px) {
            .page-body { padding: 1.25rem 1rem; }
            .header-content { margin-bottom: 1rem; }
            .login-logo { width: 72px; height: 72px; padding: 9px; margin-bottom: .6rem; }
            .system-title { font-size: clamp(1.15rem, 3vw, 1.5rem); }
            .sub-title { font-size: .85rem; }
            .login-card { border-radius: 28px; }
            .login-card .card-body { padding: 1.5rem 1.6rem; }
            .input-group-custom { border-radius: 18px; margin-bottom: .9rem; }
            .input-icon { padding: .65rem 0 .65rem 1.05rem; }
            .input-field { padding: .65rem 1rem .65rem .5rem; }
            .login-options { margin-bottom: 1rem; }
            .btn-login-submit { padding: .75rem; }
            .social-divider { margin: 1rem 0; }
            .btn-social { padding: .7rem 1rem; }
            .register-row { margin-top: .8rem; }
            footer { padding: .8rem 1rem; }
        }

        /* ── SMALL PHONES (short screens): drop the least important bits so the
              form still fits without scrolling ── */
        @media (max-width: 575.98px) and (max-height: 640px) {
            .sub-title { display: none; }
            .login-logo { width: 44px; height: 44px; padding: 5px; margin-bottom: .3rem; }
            .header-content { margin-bottom: .5rem; }
        }
        /* very small phones (e.g. 320x568): tighten further */
        @media (max-width: 575.98px) and (max-height: 600px) {
            .login-logo { display: none; }
            .login-card .card-body { padding: .9rem 1rem; }
            .input-icon { padding-top: .5rem; padding-bottom: .5rem; }
            .input-field { padding-top: .5rem; padding-bottom: .5rem; }
            .social-divider { margin: .6rem 0; }
            .register-row { margin-top: .4rem; font-size: .8rem; }
            .btn-register-link { font-size: .8rem; }
            footer { padding: .4rem 1rem; }
        }

        /* ── SHORT + WIDE (landscape phones, small laptops): branding on the left,
              form on the right, so nothing has to scroll ── */
        @media (min-width: 700px) and (max-height: 760px) {
            .login-container {
                max-width: 880px;
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(0, 420px);
                gap: 2.5rem;
                align-items: center;
            }
            .header-content { margin-bottom: 0; }
            .system-title { font-size: clamp(1.2rem, 2.6vw, 1.6rem); }
        }
    </style>
</head>
<body>
<?php include(VIEWS_PATH . '/partials/admin_loading_overlay.php'); ?>
<?php if (($_GET['msg'] ?? '') === 'enrollment_closed') include(VIEWS_PATH . '/partials/enrollment_closed_modal.php'); ?>
<?php if (($_GET['msg'] ?? '') === 'auth'): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'info',
        title: 'Login Required',
        text: 'Please log in to access that page.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#0b2b5c'
    });
});
</script>
<?php endif; ?>

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
        confirmButtonColor: '#0b2b5c'
    });
});
</script>
<?php endif; ?>

<!-- ── NAVBAR ── -->
<nav class="navbar-custom">
    <div class="navbar-inner">
        <a class="navbar-brand" href="index.php">
            <span>EPAMNHS Portal</span>
        </a>
        <a href="index.php" class="btn-portal" onclick="showAdminLoading('Returning to main portal...', 'arrow-left'); window.location.href='index.php'; return false;">
            <i class="fas fa-arrow-left"></i>
            <span class="btn-label">Back to Main Portal</span>
        </a>
    </div>
</nav>

<!-- ── PAGE ── -->
<div class="page-body">
    <div class="login-container">

        <div class="header-content">
            <img src="icons/Documents/eusebia.png" class="login-logo" alt="School Seal">
            <h2 class="system-title">Eusebia Paz Arroyo Memorial National High School</h2>
            <p class="sub-title">Buluang, Baao, Camarines Sur</p>
        </div>

        <div class="card login-card">
            <div class="card-body">
                <?php if (!empty($_SESSION['google_error'])): ?>
                    <div class="alert alert-danger" style="border-radius:14px; font-size:.85rem; padding:.5rem .75rem; margin-bottom:.75rem;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $_SESSION['google_error']; unset($_SESSION['google_error']); ?>
                    </div>
                <?php endif; ?>
                <form method="post" id="loginForm">

                    <label class="form-label" for="loginIdentityField">Email or Phone</label>
                    <div class="input-group-custom">
                        <div class="input-icon"><i class="fas fa-envelope"></i></div>
                        <input class="input-field" type="text" placeholder="your.email@example.com" name="login_identity" id="loginIdentityField" required>
                    </div>
                    <div id="loginIdentityError" class="text-danger small mt-1" style="display:none;"></div>

                    <label class="form-label" for="myInput">Password</label>
                    <div class="input-group-custom">
                        <div class="input-icon"><i class="fas fa-key"></i></div>
                        <input class="input-field" type="password" placeholder="••••••••" id="myInput" name="password" required>
                    </div>

                    <div class="login-options">
                        <div class="form-switch-custom">
                            <input class="form-check-input" type="checkbox" onclick="myFunction()" id="showPasswordSwitch">
                            <label for="showPasswordSwitch">Show password</label>
                        </div>
                        <a href="forgot_password.php" class="forgot-link" onclick="showAdminLoading('Loading...', 'key'); window.location.href='forgot_password.php'; return false;">Forgot password?</a>
                    </div>

                    <button class="btn-login-submit" type="submit" name="login" id="loginSubmitButton">
                        <span class="login-spinner"></span>
                        <i class="fas fa-sign-in-alt me-2 login-button-icon"></i>
                        <span class="login-button-text">Log in</span>
                    </button>
                    <input type="hidden" name="login" value="1">
                </form>

                <div class="social-divider"><span>or continue with</span></div>

                <a href="#" class="btn-social btn-google" onclick="handleGoogleLogin(event)">
                    <svg class="social-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </a>


                <div class="register-row">
                    <span>Don't have an account yet?</span>
                    <button type="button" class="btn-register-link" onclick="showAdminLoading('Loading registration form...', 'user-plus'); window.location.href='student_registration.php';">Create Account</button>
                </div>
            </div>
        </div>

    </div>
</div>

<footer class="footer-custom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 d-none d-md-block text-md-start">
                <i class="fas fa-school me-2"></i> Eusebia Paz Arroyo Memorial National High School
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <p class="mb-0"><?= date('Y') ?> EPAMNHS Portal.</p>
            </div>
        </div>
    </div>
</footer>
<script src="js/pwa.js"></script>
<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        x.type = (x.type === "password") ? "text" : "password";
    }



    // Identity field must be either a plausible email (has @ and a domain)
    // or a plausible phone number (digits, optionally with +/-/spaces) —
    // reject anything else (e.g. a typo'd email missing the @) before it
    // ever reaches the server.
    function isValidLoginIdentity(value) {
        var val = (value || '').trim();
        var isPhone = /^[0-9+\-\s()]{7,15}$/.test(val);
        var isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
        return isPhone || isEmail;
    }

    // Show a loading phase after a valid login form is submitted.
    const loginForm = document.getElementById("loginForm");
    const loginSubmitButton = document.getElementById("loginSubmitButton");
    const loginIdentityField = document.getElementById("loginIdentityField");
    const loginIdentityError = document.getElementById("loginIdentityError");

    // Desktop: start with the cursor in the first field. On touch devices this is skipped
    // (it would pop the keyboard up and cover the form the moment the page opens).
    if (loginIdentityField && window.matchMedia && window.matchMedia("(pointer: fine)").matches) {
        loginIdentityField.focus();
    }

    if (loginIdentityField && loginIdentityError) {
        loginIdentityField.addEventListener("input", function () {
            loginIdentityError.style.display = "none";
            loginIdentityField.classList.remove("is-invalid");
        });
    }

    if (loginForm && loginSubmitButton) {
        loginForm.addEventListener("submit", function (e) {
            // The submit event only reaches here after HTML required validation passes.
            if (loginIdentityField && !isValidLoginIdentity(loginIdentityField.value)) {
                e.preventDefault();
                if (loginIdentityError) {
                    loginIdentityError.textContent = "Enter a valid email address (must include @) or a valid phone number.";
                    loginIdentityError.style.display = "block";
                }
                loginIdentityField.classList.add("is-invalid");
                loginIdentityField.focus();
                return;
            }

            loginSubmitButton.disabled = true;
            loginSubmitButton.classList.add("is-loading");

            const icon = loginSubmitButton.querySelector(".login-button-icon");
            const text = loginSubmitButton.querySelector(".login-button-text");

            if (icon) icon.style.display = "none";
            if (text) text.textContent = "Logging in...";

            showAdminLoading('Logging in...', 'sign-in-alt');
        });
    }
    function handleGoogleLogin(e) {
        e.preventDefault();
        showAdminLoading('Connecting to Google...', 'sign-in-alt');
        var params = new URLSearchParams({
            client_id:     '240563055427-f8m83d6t72de5ck1leqrvuduenbghoon.apps.googleusercontent.com',
            redirect_uri:  'https://eusebianationalhighschool.fwh.is/google_callback.php',
            response_type: 'code',
            scope:         'openid email profile',
            prompt:        'select_account'
        });
        window.location.href = 'https://accounts.google.com/o/oauth2/v2/auth?' + params.toString();
    }

    function handleFacebookLogin(e) {
        e.preventDefault();
        showAdminLoading('Connecting to Facebook...', 'sign-in-alt');
        var params = new URLSearchParams({
            client_id:     '1384598473521605',
            redirect_uri:  'https://eusebianationalhighschool.fwh.is/facebook_callback.php',
            response_type: 'code',
            scope:         'email,public_profile',
            auth_type:     'rerequest'
        });
        window.location.href = 'https://www.facebook.com/v18.0/dialog/oauth?' + params.toString();
    }
</script>

</body>
</html>