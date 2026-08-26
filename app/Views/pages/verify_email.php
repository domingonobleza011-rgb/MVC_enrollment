
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>EPAMHS | Verify Your Email</title>
    <link rel="manifest" href="manifest.php">
    <meta name="theme-color" content="#0b2b5c">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; }
    body {
        font-family: 'Inter', sans-serif;
        background-image: linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url('icons/eusebia.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
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
        flex-shrink: 0;
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
    }
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
    .code-input {
        width: 100%;
        text-align: center;
        font-size: 1.9rem;
        font-weight: 700;
        letter-spacing: 10px;
        padding: .9rem .5rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        background: #f8fafc;
        color: #0b2b5c;
        outline: none;
        margin-bottom: 1.2rem;
    }
    .code-input:focus { border-color: #2a6f9c; box-shadow: 0 0 0 3px rgba(42,111,156,.14); background: white; }
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
    .btn-resend {
        background: none;
        border: none;
        color: #1f5a9e;
        font-weight: 600;
        font-size: .9rem;
        width: 100%;
        cursor: pointer;
        text-decoration: underline;
        padding: .5rem;
    }
    .alert { border-radius: 16px; font-size: .88rem; padding: 1rem; }
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
        .code-input { font-size: 1.5rem; letter-spacing: 6px; }
    }
</style>
</head>
<body>
<nav class="navbar-custom">
    <div class="navbar-inner">
        <a class="navbar-brand" href="index.php"><i class="bi bi-mortarboard-fill"></i><span>EPAMNHS Portal</span></a>
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
                    <div class="icon-wrap"><i class="fas fa-envelope-open-text"></i></div>
                    <h5>Verify Your Email</h5>
                    <p>We sent a 6-digit code to <strong><?= htmlspecialchars($email_display) ?></strong></p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $message_type ?> mb-3">
                        <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <input type="text" class="code-input" name="code" maxlength="6" inputmode="numeric"
                           pattern="[0-9]{6}" placeholder="------" required autofocus>
                    <button class="btn-submit" type="submit" name="verify_code">
                        <i class="fas fa-check me-2"></i> Verify Code
                    </button>
                </form>

                <form method="post">
                    <button class="btn-resend" type="submit" name="resend_code">
                        Didn't get a code? Resend
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer>
    <i class="fas fa-school me-2"></i> Eusebia Paz Arroyo Memorial National High School
    <br><small><?= date('Y') ?> EPAMNHS. All rights reserved.</small>
</footer>
<script src="js/pwa.js"></script>
</body>
</html>
