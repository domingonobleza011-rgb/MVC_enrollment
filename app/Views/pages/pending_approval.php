
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>EPAMHS | Awaiting Approval</title>
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
    .navbar-inner { display: flex; align-items: center; padding: .8rem 1.5rem; }
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
    .page-body {
        flex: 1 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1rem;
    }
    .login-container { max-width: 460px; width: 100%; margin: auto; }
    .login-card {
        background: white;
        border: none;
        border-radius: 32px;
        box-shadow: 0 25px 45px -12px rgba(0,0,0,.4);
        overflow: hidden;
        text-align: center;
    }
    .login-card .card-body { padding: 3rem 2rem; }
    .icon-wrap {
        width: 84px;
        height: 84px;
        background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.2rem;
    }
    .icon-wrap i { color: #ffd700; font-size: 2.1rem; }
    h5 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #0b2b5c;
        font-size: 1.4rem;
        margin-bottom: .7rem;
    }
    p { color: #64748b; font-size: .95rem; line-height: 1.7; margin-bottom: .6rem; }
    .btn-back {
        background: linear-gradient(135deg, #0b2b5c, #1f5a9e);
        border: none;
        border-radius: 40px;
        padding: .8rem 2rem;
        font-weight: 600;
        font-size: .95rem;
        color: white;
        transition: all .2s;
        text-decoration: none;
        display: inline-block;
        margin-top: 1.2rem;
    }
    .btn-back:hover { transform: translateY(-2px); color: white; }
    footer {
        background: #0b1f33;
        color: #cddcec;
        padding: 1.25rem 1rem;
        text-align: center;
        font-size: .78rem;
        flex-shrink: 0;
        border-top: 1px solid rgba(255,255,255,0.05);
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
        <div class="login-card">
            <div class="card-body">
                <div class="icon-wrap"><i class="fas fa-hourglass-half"></i></div>
                <h5>Awaiting Admin Approval</h5>
                <?php if ($name): ?>
                    <p>Thanks, <strong><?= htmlspecialchars($name) ?></strong> — your email is verified.</p>
                <?php endif; ?>
                <p>Your account is now waiting for a school administrator to review and approve it.</p>
                <p>You'll receive an email once your account has been approved and you can log in.</p>
                <a href="login.php" class="btn-back"><i class="fas fa-arrow-left me-2"></i> Back to Login</a>
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
