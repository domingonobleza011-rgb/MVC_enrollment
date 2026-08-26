<?php http_response_code(500); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>500 - Something Went Wrong | EPAMNHS</title>
    <link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; min-height: 100vh; }
        body {
            background: linear-gradient(145deg, #f8faff 0%, #f0f4fe 100%);
            font-family: 'Inter', -apple-system, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1a2c3e;
        }
        .error-container { width: 100%; max-width: 640px; margin: 0 auto; text-align: center; }
        .brand-row { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 2rem; }
        .brand-row img { width: 38px; height: 38px; border-radius: 50%; }
        .brand-row span {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.05rem;
            color: #0b2b5c;
            letter-spacing: .2px;
        }
        .error-number {
            font-size: 8rem;
            font-weight: 900;
            color: #4a5a6b;
            line-height: 1;
            letter-spacing: -8px;
            margin-bottom: 0.25rem;
            position: relative;
            display: inline-block;
        }
        .error-number::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4a5a6b, #6c7a89, #4a5a6b);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
            border-radius: 4px;
        }
        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .error-illustration { margin: 0 auto 1.5rem; max-width: 220px; width: 100%; }
        .error-illustration svg { width: 100%; height: auto; }
        .error-illustration .cog { transform-origin: center; animation: spin 6s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .error-title { font-size: 1.6rem; font-weight: 700; color: #1c1e21; margin-bottom: 0.75rem; }
        .error-message {
            font-size: 1rem;
            color: #65676b;
            line-height: 1.8;
            max-width: 460px;
            margin: 0 auto 2rem;
        }
        .action-buttons { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-primary-custom {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 0.7rem 2rem; background: #0b2b5c; color: #fff;
            border-radius: 12px; text-decoration: none; font-weight: 600;
            font-size: 0.9rem; transition: all 0.2s ease; border: none;
            box-shadow: 0 2px 8px rgba(11, 43, 92, 0.25);
        }
        .btn-primary-custom:hover {
            background: #0f3b7a; transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(11, 43, 92, 0.35); color: #fff;
        }
        .btn-secondary-custom {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 0.7rem 2rem; background: #fff; color: #1c1e21;
            border: 1.5px solid #dee2e6; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .btn-secondary-custom:hover {
            background: #f0f2f5; border-color: #bcc0c4; transform: translateY(-2px);
        }
        @media (max-width: 576px) {
            .error-number { font-size: 4.5rem; letter-spacing: -4px; }
            .error-title { font-size: 1.2rem; }
            .error-message { font-size: 0.88rem; padding: 0; }
            .error-illustration { max-width: 150px; }
            .action-buttons { flex-direction: column; }
            .action-buttons .btn-primary-custom, .action-buttons .btn-secondary-custom {
                width: 100%; justify-content: center;
            }
        }
    </style>
</head>
<body>
<div class="error-container">
    <div class="brand-row">
        <img src="icons/pwa/icon-96x96.png" alt="EPAMNHS">
        <span>Eusebia Paz Arroyo MNHS</span>
    </div>

    <div class="error-number">500</div>

    <div class="error-illustration">
        <svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g class="cog">
                <circle cx="100" cy="65" r="20" stroke="#4a5a6b" stroke-width="3" fill="none" opacity="0.55"/>
                <circle cx="100" cy="65" r="7" fill="#4a5a6b" opacity="0.55"/>
                <g stroke="#4a5a6b" stroke-width="3" opacity="0.55" stroke-linecap="round">
                    <path d="M100 39 V45"/>
                    <path d="M100 85 V91"/>
                    <path d="M74 65 H80"/>
                    <path d="M120 65 H126"/>
                    <path d="M82 47 L86 51"/>
                    <path d="M114 79 L118 83"/>
                    <path d="M118 47 L114 51"/>
                    <path d="M86 79 L82 83"/>
                </g>
            </g>
            <path d="M60 110 L140 110" stroke="#4a5a6b" stroke-width="2" stroke-dasharray="4 4" opacity="0.3"/>
            <circle cx="35" cy="30" r="3" fill="#4a5a6b" opacity="0.08"/>
            <circle cx="165" cy="25" r="4" fill="#6c7a89" opacity="0.06"/>
            <circle cx="30" cy="110" r="2.5" fill="#4a5a6b" opacity="0.07"/>
        </svg>
    </div>

    <h1 class="error-title">Something went wrong</h1>
    <p class="error-message">
        Our server ran into an unexpected problem. It's not you, it's us —<br>
        please try again in a moment.
    </p>

    <div class="action-buttons">
        <a href="/" class="btn-primary-custom">
            <i class="bi bi-house-door-fill"></i> Back to Home
        </a>
        <a href="javascript:history.back()" class="btn-secondary-custom">
            <i class="bi bi-arrow-left"></i> Go Back
        </a>
    </div>
</div>
</body>
</html>
