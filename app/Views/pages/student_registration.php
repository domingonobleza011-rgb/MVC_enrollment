

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <!-- PWA -->
  <link rel="manifest" href="manifest.php">
  <meta name="theme-color" content="#0b2b5c">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="EPAMNHS">
        <link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">
    <title>Registration Form – EPAMNHS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>

    <style>
        /* ── TOKENS ── */
        :root {
            --navy-dark:    #0a2e5c;
            --navy-mid:     #103f80;
            --navy-light:   #1a5ca8;
            --gold:         #ffd700;
            --gold-soft:    rgba(255,215,0,.75);
            --white:        #ffffff;
            --bg:           #f0f4fb;
            --card-bg:      #ffffff;
            --border:       rgba(10,46,92,.1);
            --text-primary: #1a1e2e;
            --text-muted:   #5a6478;
            --label:        #2d3a52;
            --input-bg:     #f7f9fd;
            --input-focus:  #e8eff9;
            --radius:       10px;
            --shadow:       0 4px 24px rgba(10,46,92,.08);
        }

        /* ── BASE ── */
        *, *::before, *::after { box-sizing: border-box; }

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
            flex-shrink: 1;
            min-width: 0;
        }

        .navbar-brand span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .navbar-logo { width: 38px; height: 38px; object-fit: contain; flex-shrink: 0; }
        @media (max-width: 480px) { .navbar-logo { width: 32px; height: 32px; } }
                .btn-portal {
            border-radius: 40px;
            padding: 7px 18px;
            font-weight: 500;
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
            font-weight: 600;
            flex-shrink: 0;
        }

        .btn-portal:hover {
            background: #ffd700;
            transform: translateY(-2px);
            color: #0b2b5c;
        }

        @media (max-width: 400px) {
            .btn-portal .btn-label { display: none; }
            .btn-portal { padding: 8px 11px; border-radius: 50%; }
            .navbar-inner { padding: .7rem 1rem; }
        }

        /* ── PAGE WRAPPER ── */
        main {
            flex: 1;
            padding: 2.5rem 1rem 3rem;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(22px, 5vw, 32px);
            color: var(--navy-dark);
            margin-bottom: .35rem;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 300;
        }

        .divider {
            width: 48px;
            height: 3px;
            background: var(--gold);
            border-radius: 2px;
            margin: .6rem auto 0;
        }

        /* ── CARD ── */
        .form-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        }

        .form-card-header {
            background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-mid) 100%);
            padding: 1.1rem 1.6rem;
            display: flex;
            align-items: center;
            gap: .7rem;
        }

        .form-card-header i { color: var(--gold); font-size: 18px; }

        .form-card-header h2 {
            color: var(--white);
            font-size: 15px;
            font-weight: 500;
            margin: 0;
            letter-spacing: .02em;
        }

        .form-card-body { padding: 1.8rem 1.6rem; }

        /* ── SECTION LABELS ── */
        .section-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--navy-light);
            padding-left: .55rem;
            margin: 1.6rem 0 1rem;
        }

        .section-label:first-child { margin-top: 0; }

        /* ── FORM FIELDS ── */
        .form-group { margin-bottom: .9rem; }

        label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--label);
            margin-bottom: .35rem;
        }

        label .req { color: #c0392b; margin-left: 2px; }

        .form-control, .form-select {
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-size: 14px;
            color: var(--text-primary);
            padding: .58rem .85rem;
            transition: border-color .2s, background .2s, box-shadow .2s;
            width: 100%;
        }

        .form-control::placeholder { color: #aab2c4; }

        .form-control:focus, .form-select:focus {
            background: var(--input-focus);
            border-color: var(--navy-light);
            box-shadow: 0 0 0 3px rgba(26,92,168,.12);
            outline: none;
        }

        /* Bootstrap validation overrides */
        .was-validated .form-control:valid,
        .was-validated .form-select:valid {
            border-color: #3b6d11;
            background-image: none;
        }

        .was-validated .form-control:invalid,
        .was-validated .form-select:invalid {
            border-color: #c0392b;
            background-image: none;
        }

        .valid-feedback   { font-size: 11.5px; color: #3b6d11; }
        .invalid-feedback { font-size: 11.5px; color: #c0392b; }

        /* ── PASSWORD TOGGLE ── */
        .password-wrap {
            position: relative;
        }

        .password-wrap .form-control {
            padding-right: 2.8rem;
        }

        .toggle-password {
            position: absolute;
            right: .85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 15px;
            z-index: 2;
            line-height: 1;
        }

        .toggle-password:hover { color: var(--navy-light); }

        /* ── TERMS ── */
        .terms-row {
            background: #f0f4fb;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: .85rem 1rem;
            margin-top: 1.4rem;
        }

        .form-check-input:checked {
            background-color: var(--navy-mid);
            border-color: var(--navy-mid);
        }

        .terms-link {
            color: var(--navy-light);
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px dashed var(--navy-light);
        }

        .terms-link:hover { color: var(--navy-dark); }

        /* ── ACTIONS ── */
        .form-actions {
            display: flex;
            gap: .75rem;
            justify-content: flex-end;
            margin-top: 1.6rem;
            flex-wrap: wrap;
        }

        .btn-back {
            background: transparent;
            border: 1.5px solid #c0392b;
            color: #c0392b;
            border-radius: var(--radius);
            padding: .58rem 1.4rem;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            transition: background .2s, color .2s;
        }

        .btn-back:hover {
            background: #c0392b;
            color: #fff;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
            border: none;
            color: var(--white);
            border-radius: var(--radius);
            padding: .58rem 1.8rem;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            box-shadow: 0 3px 12px rgba(16,63,128,.25);
        }

        .btn-submit:hover { opacity: .9; transform: translateY(-1px); }

        .btn-submit:disabled {
            opacity: .5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .btn-submit:disabled:hover { opacity: .5; transform: none; }

        /* ── MODAL ── */
        .modal-header.navy {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-mid));
        }

        .modal-header.navy .modal-title { color: var(--white); }

        .modal-header.navy .btn-close {
            filter: invert(1);
        }

        .modal-body h6 {
            color: var(--navy-dark);
            font-weight: 600;
            margin-top: 1rem;
        }

        .modal-body p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
        }

footer {
            background: #0b1f33;
            color: #cddcec;
            padding: 1rem;
            text-align: center;
            font-size: .78rem;
        }

        @media (max-width: 500px) {
            .login-card .card-body { padding: 1.5rem 1.3rem; }
        }
        /* ── RESPONSIVE ── */
        @media (max-width: 576px) {
            .form-card-body { padding: 1.3rem 1rem; }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn-back,
            .btn-submit {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
<?php include(VIEWS_PATH . '/partials/admin_loading_overlay.php'); ?>

<!-- NAVBAR -->
<nav class="navbar-custom">
    <div class="navbar-inner">
        <a class="navbar-brand" href="index.php">
            <img src="icons/Documents/eusebia.png" alt="EPAMNHS logo" class="navbar-logo">
            <span>EPAMNHS</span>
        </a>
        <a href="index.php" class="btn-portal" onclick="showAdminLoading('Returning to login portal...', 'arrow-left'); window.location.href='login.php'; return false;">
            <i class="fas fa-arrow-left"></i>
            <span class="btn-label">Back to Login</span>
        </a>
    </div>
</nav>

<!-- MAIN -->
<main>
    <!-- Card -->
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-user-plus"></i>
            <h2>Account Registration</h2>
        </div>

        <div class="form-card-body">
            <?php if (!empty($google_pending)): ?>
            <div class="alert alert-info d-flex align-items-center gap-2 mb-4" style="border-radius:10px;">
                <i class="fab fa-google"></i>
                <div>
                    Signed in as <strong><?= htmlspecialchars($google_pending['email']) ?></strong> with Google.
                    Please finish this registration form to create your account — Google sign-in only verifies
                    your email, it doesn't create the account by itself.
                </div>
            </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" class="was-validated" novalidate>

                <!-- ── Personal Information ── -->
                <div class="section-label">Personal Information</div>

                <div class="row g-3">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Last Name <span class="req">*</span></label>
                            <input type="text" class="form-control text-uppercase-field" name="lname" value="<?= htmlspecialchars(strtoupper($google_pending['lname'] ?? '')) ?>" placeholder="e.g. Dela Cruz" pattern="[A-Za-z ]+" title="Letters and spaces only" required>
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>First Name <span class="req">*</span></label>
                            <input type="text" class="form-control text-uppercase-field" name="fname" value="<?= htmlspecialchars(strtoupper($google_pending['fname'] ?? '')) ?>" placeholder="e.g. Juan" pattern="[A-Za-z ]+" title="Letters and spaces only" required>
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Middle Name <span class="req">*</span></label>
                            <input type="text" class="form-control text-uppercase-field" name="mi" placeholder="e.g. Santos" pattern="[A-Za-z ]+" title="Letters and spaces only" required>
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">Middle name is required.</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Birth Date <span class="req">*</span></label>
                            <input type="date" class="form-control" name="bdate" required>
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">Birth date is required.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Sex <span class="req">*</span></label>
                            <select class="form-select" name="sex" required>
                                <option value="">Choose…</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">Please select your sex.</div>
                        </div>
                    </div>
                </div>

                <!-- ── Address (PSGC Format) ── -->
                <div class="section-label">Address (PSGC Format)</div>

                <div class="row g-3">
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label>Region <span class="req">*</span></label>
                            <select class="form-select" id="psgc_region" required>
                                <option value="">Loading regions…</option>
                            </select>
                            <input type="hidden" name="region" id="region_name">
                            <div class="invalid-feedback">Please select a region.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label>Province <span class="req">*</span></label>
                            <select class="form-select" id="psgc_province" required disabled>
                                <option value="">Select a region first</option>
                            </select>
                            <input type="hidden" name="province" id="province_name">
                            <div class="invalid-feedback">Please select a province.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label>City / Municipality <span class="req">*</span></label>
                            <select class="form-select" id="psgc_citymun" required disabled>
                                <option value="">Select a province first</option>
                            </select>
                            <input type="hidden" name="municipal" id="citymun_name">
                            <div class="invalid-feedback">Please select a city or municipality.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label>Barangay <span class="req">*</span></label>
                            <select class="form-select" id="psgc_brgy" required disabled>
                                <option value="">Select a city/municipality first</option>
                            </select>
                            <input type="hidden" name="brgy" id="brgy_name">
                            <input type="hidden" name="psgc_code" id="psgc_code">
                            <div class="invalid-feedback">Please select a barangay.</div>
                        </div>
                    </div>
                </div>

                <!-- ── Account Details ── -->
                <div class="section-label">Account Details</div>

                <div class="row g-3">
<div class="col-12 col-sm-4">
    <div class="form-group">
        <label>Contact Number <span class="req">*</span></label>

        <div class="input-group">
            <span class="input-group-text">+63</span>

            <input type="tel"
                   class="form-control"
                   id="contact"
                   name="contact"
                   maxlength="10"
                   pattern="9[0-9]{9}"
                   placeholder="9XXXXXXXXX"
                   required>
        </div>

        <div class="valid-feedback">Looks good.</div>
        <div class="invalid-feedback">
            Enter a valid Philippine mobile number.
        </div>
    </div>
</div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Email / Phone <span class="req">*</span></label>
                            <input type="text"
       class="form-control"
       id="login_identity"
       name="login_identity"
       value="<?= htmlspecialchars($google_pending['email'] ?? '') ?>"
       <?= !empty($google_pending) ? 'readonly' : '' ?>
       placeholder="email or phone number"
       required>
<div class="valid-feedback">Looks good.</div>
<div class="invalid-feedback" id="loginIdentityFeedback">
    Enter a valid email address or phone number.
</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Password <span class="req">*</span></label>
                            <div class="password-wrap">
                                <input type="password" class="form-control" id="password-field"
                                       name="password" placeholder="Create a password" required>
                                
                            </div>
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">Password is required.</div>
                        </div>
                    </div>
                </div>

                <!-- ── Account Recovery ── -->
                <div class="section-label">Account Recovery</div>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Security Question <span class="req">*</span></label>
                            <select class="form-select" id="security_question" name="security_question" required>
                                <option value="">-- Select a question --</option>
                                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                                <option value="What is your favorite teacher's name?">What is your favorite teacher's name?</option>
                                <option value="What city were you born in?">What city were you born in?</option>
                                <option value="What is your best friend's name?">What is your best friend's name?</option>
                            </select>
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">Please choose a security question.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Answer <span class="req">*</span></label>
                            <input type="text" class="form-control" id="security_answer" name="security_answer"
                                   placeholder="Your answer" required autocomplete="off">
                            <div class="valid-feedback">Looks good.</div>
                            <div class="invalid-feedback">Please provide an answer.</div>
                        </div>
                    </div>
                </div>

                <!-- ── Terms ── -->
                <div class="terms-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck" style="font-size:13.5px;">
                            I have read and agree to the
                            <a href="#" class="terms-link" data-bs-toggle="modal" data-bs-target="#termsModal">
                                Terms and Conditions
                            </a>
                        </label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                </div>

                <!-- ── Actions ── -->
                <input type="hidden" name="role" value="student">
                <?php if (!empty($google_pending)): ?>
                <input type="hidden" name="addedby" value="Google">
                <?php endif; ?>

                <div class="form-actions">
                    <button class="btn-submit" type="submit" name="add_student" id="submitRegistrationBtn" disabled>
                        <i class="fas fa-paper-plane"></i> Submit Registration
                    </button>
 
                </div>

            </form>
        </div>
    </div>
</main>

<!-- ── TERMS MODAL ── -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header navy">
                <h5 class="modal-title" id="termsModalLabel">
                    <i class="fas fa-file-contract me-2" style="color:var(--gold);"></i>
                    Terms and Conditions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size:14px; line-height:1.75;">
                <h6>1. Data Privacy Act of 2012</h6>
                <p>By registering, you allow EUSEBIA PAZ ARROYO NATIONAL HIGH SCHOOL to collect and process your personal information in accordance with the Data Privacy Act. Your data will be used solely for enrollment and emergency services.</p>

                <h6>2. Accuracy of Information</h6>
                <p>You certify that all information provided is true and correct. Providing false information may lead to the cancellation of your registration or legal action.</p>

                <h6>3. Usage Policy</h6>
                <p>This account is for the exclusive use of the registered student. Any unauthorized use of this system may result in suspension of access.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        onclick="document.getElementById('termsCheck').checked = true;">
                    I Understand &amp; Agree
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ── DUPLICATE ACCOUNT MODAL ── -->
<div class="modal fade" id="duplicateAccountModal" tabindex="-1" aria-labelledby="duplicateAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header navy">
                <h5 class="modal-title" id="duplicateAccountModalLabel">
                    <i class="fas fa-triangle-exclamation me-2" style="color:var(--gold);"></i>
                    Account Already Registered
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size:14px; line-height:1.75;">
                <p class="mb-0">The email or phone number you entered is already registered to an existing account. Please use a different email or phone number, or log in instead if this account belongs to you.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer-custom">
  <div class="container">
    <i class="fas fa-school me-2"></i> Eusebia Paz Arroyo Memorial National High School
    <br><small><?= date('Y') ?> EPAMNHS. </small>
  </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const loginIdentity = document.getElementById("login_identity");
    const form = loginIdentity.closest("form");

    // Phone number: numbers only, 11 digits
    const phonePattern = /^[0-9]{11}$/;

    // Email: must contain @ and a valid domain
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function validateLoginIdentity() {
        const value = loginIdentity.value.trim();

        // Empty field
        if (value === "") {
            loginIdentity.setCustomValidity("This field is required.");
            return false;
        }

        // If it contains only numbers, treat it as a phone number
        if (/^[0-9]+$/.test(value)) {
            if (phonePattern.test(value)) {
                loginIdentity.setCustomValidity("");
                return true;
            } else {
                loginIdentity.setCustomValidity(
                    "Phone number must contain exactly 11 digits."
                );
                return false;
            }
        }

        // Otherwise, treat it as an email
        if (!value.includes("@")) {
            loginIdentity.setCustomValidity(
                "Email address must contain the @ symbol."
            );
            return false;
        }

        if (!emailPattern.test(value)) {
            loginIdentity.setCustomValidity(
                "Please enter a valid email address."
            );
            return false;
        }

        loginIdentity.setCustomValidity("");
        return true;
    }

    // Validate while the user types
    loginIdentity.addEventListener("input", validateLoginIdentity);

    // Validate when leaving the field
    loginIdentity.addEventListener("blur", validateLoginIdentity);

    // Validate before submitting
    form.addEventListener("submit", function (event) {
        if (!validateLoginIdentity()) {
            event.preventDefault();
            event.stopPropagation();
            loginIdentity.reportValidity();
        }
    });
});
</script>
<script>
    // Password toggle
    $(".toggle-password").on("click", function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        input.attr("type", input.attr("type") === "password" ? "text" : "password");
    });

    // Auto-uppercase name fields (Last Name, First Name, Middle Name) as the
    // applicant types them, and strip out anything that isn't a letter or
    // space (no numbers, no symbols). Also runs once on page load so any
    // server-prefilled value (e.g. the name Google handed back) is
    // normalized immediately instead of only after the next keystroke.
    function cleanUppercaseField(el) {
        var pos = el.selectionStart;
        var before = el.value;
        var cleaned = before.toUpperCase().replace(/[^A-Z ]/g, '');
        if (cleaned !== before) {
            pos -= (before.length - cleaned.length);
        }
        el.value = cleaned;
        if (pos !== null && typeof el.setSelectionRange === 'function' && document.activeElement === el) {
            if (pos < 0) pos = 0;
            el.setSelectionRange(pos, pos);
        }
    }

    document.addEventListener('input', function (e) {
        if (e.target && e.target.classList && e.target.classList.contains('text-uppercase-field')) {
            cleanUppercaseField(e.target);
        }
    });

    document.querySelectorAll('.text-uppercase-field').forEach(cleanUppercaseField);
</script>

<script>
   
    (function () {
        var PSGC_BASE = 'https://psgc.cloud/api/v2';

        var $region  = document.getElementById('psgc_region');
        var $province = document.getElementById('psgc_province');
        var $citymun = document.getElementById('psgc_citymun');
        var $brgy    = document.getElementById('psgc_brgy');

        var $regionName  = document.getElementById('region_name');
        var $provinceName = document.getElementById('province_name');
        var $citymunName = document.getElementById('citymun_name');
        var $brgyName    = document.getElementById('brgy_name');
        var $psgcCode    = document.getElementById('psgc_code');

        function resetSelect($el, placeholder) {
            $el.innerHTML = '<option value="">' + placeholder + '</option>';
            $el.disabled = true;
        }

        function fillSelect($el, items, placeholder) {
            $el.innerHTML = '<option value="">' + placeholder + '</option>';
            items.forEach(function (item) {
                var opt = document.createElement('option');
                opt.value = item.code;
                opt.textContent = item.name;
                $el.appendChild(opt);
            });
            $el.disabled = false;
        }

        function fetchJSON(url) {
            return fetch(url).then(function (res) {
                if (!res.ok) throw new Error('PSGC request failed: ' + url);
                return res.json();
            }).then(function (json) {
                
                return (json && Array.isArray(json.data)) ? json.data : json;
            });
        }

        // 1. Load regions on page load
        fetchJSON(PSGC_BASE + '/regions')
            .then(function (regions) {
                fillSelect($region, regions, 'Choose a region…');
            })
            .catch(function () {
                $region.innerHTML = '<option value="">Could not load regions — refresh to retry</option>';
            });

        // 2. Region → Provinces (falls back to Cities/Municipalities directly for NCR,
        //    which has no provinces in the PSGC hierarchy)
        $region.addEventListener('change', function () {
            var code = $region.value;
            var name = $region.options[$region.selectedIndex].text;
            $regionName.value = code ? name : '';

            resetSelect($province, 'Loading provinces…');
            resetSelect($citymun, 'Select a province first');
            resetSelect($brgy, 'Select a city/municipality first');
            $provinceName.value = '';
            $citymunName.value = '';
            $brgyName.value = '';
            $psgcCode.value = '';

            if (!code) {
                resetSelect($province, 'Select a region first');
                return;
            }

            fetchJSON(PSGC_BASE + '/regions/' + code + '/provinces')
                .then(function (provinces) {
                    if (provinces.length) {
                        fillSelect($province, provinces, 'Choose a province…');
                    } else {
                        // No provinces under this region (e.g. NCR) — load
                        // cities/municipalities directly instead.
                        $province.innerHTML = '<option value="">Not applicable for this region</option>';
                        $province.disabled = true;
                        $provinceName.value = 'N/A';
                        return fetchJSON(PSGC_BASE + '/regions/' + code + '/cities-municipalities')
                            .then(function (cities) {
                                fillSelect($citymun, cities, 'Choose a city/municipality…');
                            });
                    }
                })
                .catch(function () {
                    $province.innerHTML = '<option value="">Could not load provinces — refresh to retry</option>';
                });
        });

        // 3. Province → Cities/Municipalities
        $province.addEventListener('change', function () {
            var code = $province.value;
            var name = $province.options[$province.selectedIndex].text;
            $provinceName.value = code ? name : '';

            resetSelect($citymun, 'Loading cities/municipalities…');
            resetSelect($brgy, 'Select a city/municipality first');
            $citymunName.value = '';
            $brgyName.value = '';
            $psgcCode.value = '';

            if (!code) {
                resetSelect($citymun, 'Select a province first');
                return;
            }

            fetchJSON(PSGC_BASE + '/provinces/' + code + '/cities-municipalities')
                .then(function (cities) {
                    fillSelect($citymun, cities, 'Choose a city/municipality…');
                })
                .catch(function () {
                    $citymun.innerHTML = '<option value="">Could not load cities/municipalities — refresh to retry</option>';
                });
        });

        // 4. City/Municipality → Barangays
        $citymun.addEventListener('change', function () {
            var code = $citymun.value;
            var name = $citymun.options[$citymun.selectedIndex].text;
            $citymunName.value = code ? name : '';

            resetSelect($brgy, 'Loading barangays…');
            $brgyName.value = '';
            $psgcCode.value = '';

            if (!code) {
                resetSelect($brgy, 'Select a city/municipality first');
                return;
            }

            fetchJSON(PSGC_BASE + '/cities-municipalities/' + code + '/barangays')
                .then(function (barangays) {
                    fillSelect($brgy, barangays, 'Choose a barangay…');
                })
                .catch(function () {
                    $brgy.innerHTML = '<option value="">Could not load barangays — refresh to retry</option>';
                });
        });


        $brgy.addEventListener('change', function () {
            var code = $brgy.value;
            var name = $brgy.options[$brgy.selectedIndex].text;
            $brgyName.value = code ? name : '';
            $psgcCode.value = code || '';
        });
    })();


    (function () {
        var DRAFT_KEY = 'epamnhs_student_registration_draft';
        var DRAFT_MAX_AGE_MS = 24 * 60 * 60 * 1000; // drop drafts older than a day

        var $form = document.querySelector('form[enctype="multipart/form-data"]');
        if (!$form) return;

        var plainFields = ['lname', 'fname', 'mi', 'bdate', 'sex', 'contact', 'login_identity'];

        var $region  = document.getElementById('psgc_region');
        var $province = document.getElementById('psgc_province');
        var $citymun = document.getElementById('psgc_citymun');
        var $brgy    = document.getElementById('psgc_brgy');
        var $terms   = document.getElementById('termsCheck');

        function readDraft() {
            try {
                var raw = localStorage.getItem(DRAFT_KEY);
                if (!raw) return null;
                var draft = JSON.parse(raw);
                if (!draft || (Date.now() - (draft.savedAt || 0)) > DRAFT_MAX_AGE_MS) {
                    localStorage.removeItem(DRAFT_KEY);
                    return null;
                }
                return draft;
            } catch (e) {
                return null;
            }
        }

        function saveDraft() {
            var draft = { savedAt: Date.now(), fields: {}, terms: $terms ? $terms.checked : false };
            plainFields.forEach(function (name) {
                var el = $form.elements[name];
                if (el) draft.fields[name] = el.value;
            });
            draft.region = $region.value;
            draft.province = $province.value;
            draft.citymun = $citymun.value;
            draft.brgy = $brgy.value;
            try {
                localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
            } catch (e) {
                
            }
        }

        function clearDraft() {
            try { localStorage.removeItem(DRAFT_KEY); } catch (e) {}
        }

        function onceOptionsChange($el, cb, timeoutMs) {
            var done = false;
            var obs = new MutationObserver(function () {
                if (done) return;
                done = true;
                obs.disconnect();
                cb();
            });
            obs.observe($el, { childList: true });
            setTimeout(function () {
                if (done) return;
                done = true;
                obs.disconnect();
                cb();
            }, timeoutMs || 8000);
        }

        function hasOption($el, value) {
            for (var i = 0; i < $el.options.length; i++) {
                if ($el.options[i].value === value) return true;
            }
            return false;
        }

        function fireChange($el) {
            $el.dispatchEvent(new Event('change'));
        }

        function restoreAddress(draft) {
            if (!draft.region) return;

            onceOptionsChange($region, function () {
                if (!hasOption($region, draft.region)) return;
                $region.value = draft.region;
                fireChange($region);

                onceOptionsChange($province, function () {
                    if (!$province.disabled && draft.province && hasOption($province, draft.province)) {
                        $province.value = draft.province;
                        fireChange($province);
                        onceOptionsChange($citymun, function () { restoreCitymunAndBrgy(draft); });
                    } else {
                       
                        onceOptionsChange($citymun, function () { restoreCitymunAndBrgy(draft); });
                    }
                });
            });
        }

        function restoreCitymunAndBrgy(draft) {
            if (!draft.citymun || !hasOption($citymun, draft.citymun)) return;
            $citymun.value = draft.citymun;
            fireChange($citymun);

            onceOptionsChange($brgy, function () {
                if (draft.brgy && hasOption($brgy, draft.brgy)) {
                    $brgy.value = draft.brgy;
                    fireChange($brgy);
                }
            });
        }

        // ── Restore on load ──
        var draft = readDraft();
        if (draft) {
            plainFields.forEach(function (name) {
                var el = $form.elements[name];
                if (el && !el.readOnly && draft.fields && draft.fields[name]) el.value = draft.fields[name];
            });
            if ($terms) $terms.checked = !!draft.terms;
            restoreAddress(draft);
        }

        // ── Save as the person fills things in ──
        plainFields.forEach(function (name) {
            var el = $form.elements[name];
            if (el) el.addEventListener('input', saveDraft);
        });
        [$region, $province, $citymun, $brgy].forEach(function (el) {
            el.addEventListener('change', saveDraft);
        });
        if ($terms) $terms.addEventListener('change', saveDraft);

        // ── Clear once the form is actually submitted ──
        $form.addEventListener('submit', clearDraft);
    })();

    (function () {
        var $form = document.querySelector('form[enctype="multipart/form-data"]');
        var $submitBtn = document.getElementById('submitRegistrationBtn');
        var $hint = document.getElementById('submitHint');
        if (!$form || !$submitBtn) return;

        function refresh() {
            var valid = $form.checkValidity();
            $submitBtn.disabled = !valid;
            if ($hint) $hint.style.display = valid ? 'none' : '';
        }


        $form.addEventListener('input', refresh);
        $form.addEventListener('change', refresh);

        ['psgc_region', 'psgc_province', 'psgc_citymun', 'psgc_brgy'].forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            new MutationObserver(refresh).observe(el, { childList: true, attributes: true, attributeFilter: ['disabled'] });
        });

  
        $form.addEventListener('submit', function (e) {
            if (!$form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                $form.reportValidity();
                refresh();
                return;
            }
            showAdminLoading('Submitting your registration...', 'paper-plane');
        });

        refresh();
    })();
</script>
<script src="js/pwa.js"></script>
</body>
</html>