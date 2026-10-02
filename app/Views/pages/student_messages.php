<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.php">
    <meta name="theme-color" content="#0b2b5c">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="EPAMNHS">
    <link rel="apple-touch-icon" href="icons/pwa/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="192x192" href="icons/pwa/icon-192x192.png">
    <title>Messages | EPAMNHS Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
        .sm-wrap { max-width: 760px; width: 100%; margin: 1.5rem auto; padding: 0 1rem; }
        .sm-card {
            background: #fff; border-radius: 20px; overflow: hidden;
            box-shadow: 0 10px 30px rgba(11,43,92,.10);
            display: flex; flex-direction: column;
            height: calc(100vh - 56px - 48px); min-height: 440px;
        }
        .sm-head {
            background: linear-gradient(135deg, #0b2b5c 0%, #0f3b7a 100%);
            color: #fff; display: flex; align-items: center; gap: 12px; padding: 14px 18px;
        }
        .sm-avatar {
            width: 42px; height: 42px; border-radius: 50%; background: #fff; flex: 0 0 42px;
            overflow: hidden; display: flex; align-items: center; justify-content: center;
        }
        .sm-avatar img { width: 100%; height: 100%; object-fit: contain; display: block; }
        .sm-title { font-weight: 700; line-height: 1.2; }
        .sm-sub   { font-size: .78rem; opacity: .85; }

        .sm-body {
            flex: 1; overflow-y: auto; padding: 16px; background: #f4f6fa;
            display: flex; flex-direction: column; gap: 4px;
        }
        .sm-day { align-self: center; font-size: .72rem; color: #8a94a6; margin: 10px 0 6px; }
        .sm-row { display: flex; flex-direction: column; max-width: 80%; }
        .sm-row.out { align-self: flex-end; align-items: flex-end; }
        .sm-row.in  { align-self: flex-start; align-items: flex-start; }
        .sm-bubble {
            padding: 9px 14px; border-radius: 18px; font-size: .92rem; line-height: 1.4;
            white-space: pre-wrap; word-break: break-word;
        }
        .sm-row.out .sm-bubble { background: #0f3b7a; color: #fff; border-bottom-right-radius: 5px; }
        .sm-row.in  .sm-bubble { background: #e6e9f0; color: #1a2c3e; border-bottom-left-radius: 5px; }
        .sm-time { font-size: .68rem; color: #8a94a6; margin: 2px 6px 6px; }
        .sm-empty { margin: auto; text-align: center; color: #8a94a6; font-size: .9rem; padding: 0 20px; }
        .sm-empty i { font-size: 2rem; display: block; margin-bottom: 8px; color: #b5bfd3; }

        .sm-error { color: #dc3545; font-size: .8rem; padding: 0 16px; min-height: 0; }
        .sm-composer {
            display: flex; align-items: flex-end; gap: 10px; padding: 12px 14px;
            border-top: 1px solid #e8ebf2; background: #fff;
        }
        .sm-composer textarea {
            flex: 1; resize: none; border: 1.5px solid #d5dbe7; border-radius: 22px;
            padding: 9px 16px; font-family: inherit; font-size: .92rem; max-height: 120px; outline: none;
        }
        .sm-composer textarea:focus { border-color: #0f3b7a; }
        .sm-send {
            width: 42px; height: 42px; border-radius: 50%; border: 0; flex: 0 0 42px;
            background: #0f3b7a; color: #fff; cursor: pointer; transition: transform .15s, background .15s;
        }
        .sm-send:hover { background: #0b2b5c; transform: scale(1.05); }
        .sm-send:disabled { opacity: .55; cursor: default; transform: none; }

        @media (max-width: 575px) {
            .sm-wrap { margin: 0; padding: 0; }
            .sm-card { border-radius: 0; height: calc(100vh - 56px); }
        }
    </style>
</head>
<body>

<?php $active_page = 'messages'; include(VIEWS_PATH . '/partials/student_navbar.php'); ?>

<div class="sm-wrap">
    <div class="sm-card">
        <div class="sm-head">
            <div class="sm-avatar"><img src="icons/pwa/icon-192x192.png" alt="EPAMNHS"></div>
            <div>
                <div class="sm-title">EPAMNHS</div>
                <div class="sm-sub">Send us your concern, we'll reply here</div>
            </div>
        </div>

        <div class="sm-body" id="smBody"></div>
        <div class="sm-error" id="smError"></div>

        <div class="sm-composer">
            <textarea id="smInput" rows="1" maxlength="1000" placeholder="Type your message…"></textarea>
            <button type="button" class="sm-send" id="smSend" aria-label="Send"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<script>
(function () {
    var API  = 'student_messages_api.php';
    var CSRF = <?= json_encode($csrf_value) ?>;
    var $ = function (id) { return document.getElementById(id); };
    var bodyEl = $('smBody'), inputEl = $('smInput'), sendBtn = $('smSend'), errEl = $('smError');
    var lastId = 0, lastDay = '', sending = false, timer = null;

    function parse(r) {
        return r.text().then(function (t) {
            try { return JSON.parse(t); }
            catch (e) { return { ok: false, error: 'Session expired or server problem (HTTP ' + r.status + '). Please refresh the page.' }; }
        });
    }
    function showError(m) { errEl.textContent = m || ''; errEl.style.padding = m ? '4px 16px 6px' : '0 16px'; }
    function atBottom() { return bodyEl.scrollHeight - bodyEl.scrollTop - bodyEl.clientHeight < 80; }
    function toBottom() { bodyEl.scrollTop = bodyEl.scrollHeight; }

    function showEmpty() {
        if ($('smEmpty')) return;
        var d = document.createElement('div'); d.id = 'smEmpty'; d.className = 'sm-empty';
        d.innerHTML = '<i class="far fa-comments"></i>No messages yet. Type your concern below and the school admin will reply here.';
        bodyEl.appendChild(d);
    }
    function render(msgs) {
        var e = $('smEmpty'); if (e && msgs.length) e.remove();
        msgs.forEach(function (m) {
            if (m.day_key !== lastDay) {
                var d = document.createElement('div'); d.className = 'sm-day'; d.textContent = m.date;
                bodyEl.appendChild(d); lastDay = m.day_key;
            }
            var row = document.createElement('div'); row.className = 'sm-row ' + (m.sender === 'visitor' ? 'out' : 'in');
            var b = document.createElement('div'); b.className = 'sm-bubble'; b.textContent = m.body;
            var t = document.createElement('div'); t.className = 'sm-time'; t.textContent = m.time;
            row.appendChild(b); row.appendChild(t); bodyEl.appendChild(row);
            lastId = Math.max(lastId, m.id);
        });
    }

    function load(initial) {
        fetch(API + '?action=fetch&after=' + lastId, { cache: 'no-store', credentials: 'same-origin' })
            .then(parse).then(function (res) {
                if (!res.ok) { if (initial) showError(res.error || ''); return; }
                if (initial && !res.messages.length) { showEmpty(); return; }
                if (!res.messages.length) return;
                var stick = initial || atBottom();
                render(res.messages);
                if (stick) toBottom();
            }).catch(function () { if (initial) showError('Could not reach the server.'); });
    }

    function send() {
        if (sending) return;
        var text = inputEl.value.trim();
        if (!text) return;
        sending = true; sendBtn.disabled = true; showError('');
        var fd = new URLSearchParams();
        fd.append('action', 'send'); fd.append('message', text); fd.append('csrf_token', CSRF);
        fetch(API, {
            method: 'POST', credentials: 'same-origin', body: fd.toString(),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' }
        }).then(parse).then(function (res) {
            if (!res.ok) { showError(res.error || 'Could not send your message.'); return; }
            inputEl.value = ''; inputEl.style.height = 'auto';
            load(false); setTimeout(toBottom, 250);
        }).catch(function () { showError('Could not reach the server. Check your connection and try again.'); })
          .then(function () { sending = false; sendBtn.disabled = false; inputEl.focus(); });
    }

    sendBtn.addEventListener('click', send);
    inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
    });
    inputEl.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    load(true);
    setTimeout(toBottom, 400);
    timer = setInterval(function () { load(false); }, 4000);
})();
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/pwa.js"></script>
</body>
</html>
