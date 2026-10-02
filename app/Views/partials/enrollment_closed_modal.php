<?php
/**
 * enrollment_closed_modal.php
 * ---------------------------------------------------------------------
 * Self-contained modal (no Bootstrap JS needed) shown on the login page
 * when a student tries to open their account while enrollment is closed.
 * Included by login.php when ?msg=enrollment_closed is present.
 *
 * "For concerns, send us a message" switches the modal into a chat view.
 * Visitors have no account, so their conversation is tied to a secret
 * token saved in this browser (localStorage) and talks to chat_api.php.
 * Admin replies show up here live (polled every few seconds).
 */
?>
<style>
    #enrollClosedOverlay {
        position: fixed; inset: 0; z-index: 99999;
        background: rgba(11, 43, 92, .65);
        display: flex; align-items: center; justify-content: center;
        padding: 16px;
    }
    #enrollClosedOverlay .ec-box {
        background: #fff; border-radius: 14px; max-width: 420px; width: 100%;
        text-align: center; overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,.3);
        animation: ecPop .25s ease-out;
    }
    #enrollClosedOverlay .ec-notice { padding: 32px 28px 26px; }
    #enrollClosedOverlay .ec-icon {
        width: 72px; height: 72px; border-radius: 50%;
        background: #fdecea; color: #d9534f;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; margin: 0 auto 16px;
    }
    #enrollClosedOverlay h4 { margin: 0 0 8px; color: #0b2b5c; font-weight: 700; }
    #enrollClosedOverlay .ec-notice p { margin: 0 0 22px; color: #5b6573; font-size: .95rem; line-height: 1.5; }
    #enrollClosedOverlay .ec-btn {
        background: #0b2b5c; color: #fff; border: 0; border-radius: 8px;
        padding: 10px 34px; font-weight: 600; cursor: pointer;
    }
    #enrollClosedOverlay .ec-btn:hover { background: #123d82; }
    #enrollClosedOverlay .ec-btn-outline {
        display: block; width: 100%; margin: 0 0 10px;
        background: #fff; color: #0b2b5c; border: 1.5px solid #0b2b5c; border-radius: 8px;
        padding: 10px 16px; font-weight: 600; cursor: pointer;
    }
    #enrollClosedOverlay .ec-btn-outline:hover { background: #eef3fb; }

    /* ---------- chat view ---------- */
    #enrollClosedOverlay .ec-chat { display: none; flex-direction: column; height: min(560px, 85vh); text-align: left; }
    #enrollClosedOverlay.chat-open .ec-notice { display: none; }
    #enrollClosedOverlay.chat-open .ec-chat { display: flex; }
    .ec-chat-head {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 14px; background: #0b2b5c; color: #fff;
    }
    .ec-chat-head .ec-back { background: none; border: 0; color: #fff; font-size: 1.2rem; cursor: pointer; padding: 2px 6px; }
    .ec-chat-avatar {
        width: 38px; height: 38px; border-radius: 50%; background: #fff; color: #0b2b5c;
        display: flex; align-items: center; justify-content: center; font-weight: 700; flex: 0 0 38px;
        overflow: hidden;
    }
    .ec-chat-avatar img { width: 100%; height: 100%; object-fit: contain; display: block; }
    .ec-chat-title { font-weight: 700; line-height: 1.2; }
    .ec-chat-sub   { font-size: .75rem; opacity: .85; }
    .ec-chat-body {
        flex: 1; overflow-y: auto; padding: 14px; background: #f4f6fa;
        display: flex; flex-direction: column; gap: 3px;
    }
    .ec-row { display: flex; flex-direction: column; max-width: 80%; }
    .ec-row.in  { align-self: flex-start; align-items: flex-start; }
    .ec-row.out { align-self: flex-end;   align-items: flex-end; }
    .ec-bubble {
        padding: 8px 13px; border-radius: 18px; font-size: .9rem; line-height: 1.4;
        white-space: pre-wrap; word-break: break-word;
    }
    .ec-row.in  .ec-bubble { background: #e4e8ef; color: #1c2430; border-bottom-left-radius: 5px; }
    .ec-row.out .ec-bubble { background: #0b2b5c; color: #fff; border-bottom-right-radius: 5px; }
    .ec-time { font-size: .66rem; color: #8a94a3; margin: 2px 6px 6px; }
    .ec-day  { align-self: center; font-size: .7rem; color: #8a94a3; margin: 8px 0 4px; }
    .ec-details { background: #fff; border: 1px solid #dde3ed; border-radius: 12px; padding: 12px; }
    .ec-details label { font-size: .75rem; font-weight: 600; color: #5b6573; display: block; margin-bottom: 3px; }
    .ec-details input {
        width: 100%; border: 1px solid #cfd6e2; border-radius: 8px; padding: 7px 10px;
        font-size: .88rem; margin-bottom: 8px; outline: none; box-sizing: border-box;
    }
    .ec-details input:focus { border-color: #0b2b5c; }
    .ec-error { color: #d9534f; font-size: .78rem; padding: 0 14px; background: #fff; }
    .ec-composer { display: flex; align-items: flex-end; gap: 8px; padding: 10px 12px; background: #fff; border-top: 1px solid #e3e8f0; }
    .ec-composer textarea {
        flex: 1; resize: none; max-height: 96px; border: 1px solid #cfd6e2; border-radius: 20px;
        padding: 8px 14px; font-size: .9rem; line-height: 1.4; outline: none; font-family: inherit;
    }
    .ec-composer textarea:focus { border-color: #0b2b5c; }
    .ec-send {
        flex: 0 0 40px; width: 40px; height: 40px; border: 0; border-radius: 50%;
        background: #0b2b5c; color: #fff; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }
    .ec-send:disabled { opacity: .5; cursor: default; }
    .ec-hp { position: absolute; left: -9999px; width: 1px; height: 1px; opacity: 0; }

    .ec-newdot { background:#dc3545; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:10px; margin-left:6px; }
    @keyframes ecPop { from { transform: scale(.92); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>

<div id="enrollClosedOverlay" role="dialog" aria-modal="true" aria-labelledby="enrollClosedTitle">
    <div class="ec-box">

        <!-- Closed notice -->
        <div class="ec-notice">
            <div class="ec-icon"><i class="bi bi-lock-fill"></i></div>
            <h4 id="enrollClosedTitle">Enrollment is Closed</h4>
            <p>Student accounts can't be opened while enrollment is closed. Please check back once the school reopens enrollment.</p>
            <button type="button" class="ec-btn-outline" id="ecOpenChat">
                <i class="bi bi-chat-dots me-1"></i> For concerns, send us a message
            </button>
            <button type="button" class="ec-btn" id="enrollClosedOk">OK</button>
        </div>

        <!-- Chat -->
        <div class="ec-chat">
            <div class="ec-chat-head">
                <button type="button" class="ec-back" id="ecBack" aria-label="Back"><i class="bi bi-arrow-left"></i></button>
                <div class="ec-chat-avatar"><img src="icons/pwa/icon-192x192.png" alt="EPAMNHS"></div>
                <div>
                    <div class="ec-chat-title">EPAMNHS</div>
                    <div class="ec-chat-sub">Send us your concern, we'll reply here</div>
                </div>
            </div>

            <div class="ec-chat-body" id="ecBody"></div>

            <div class="ec-details" id="ecDetails" style="margin:0 12px 8px;">
                <label for="ecName">Your name</label>
                <input type="text" id="ecName" maxlength="100" placeholder="Full name" autocomplete="name">
                <label for="ecContact">Email or phone (optional)</label>
                <input type="text" id="ecContact" maxlength="150" placeholder="So we can reach you" autocomplete="off" style="margin-bottom:0;">
            </div>

            <div class="ec-error" id="ecError"></div>

            <div class="ec-composer">
                <input type="text" id="ecWebsite" class="ec-hp" tabindex="-1" autocomplete="off" aria-hidden="true">
                <textarea id="ecInput" rows="1" maxlength="1000" placeholder="Type your message…"></textarea>
                <button type="button" class="ec-send" id="ecSend" aria-label="Send"><i class="bi bi-send-fill"></i></button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var overlay = document.getElementById('enrollClosedOverlay');
    var $ = function (id) { return document.getElementById(id); };
    // Set when the popup came from a specific account's login attempt (server-side session).
    var IDENT = <?php echo json_encode(!empty($_SESSION['ec_identity']['key']) ? ['key' => $_SESSION['ec_identity']['key'], 'name' => $_SESSION['ec_identity']['name'] ?? ''] : null); ?>;
    var STORE = 'epamnhs_chat';
    var API = 'login.php?chat=1';

    var state = { token: '', name: '' };
    if (IDENT) {
        state = { token: 'acct', name: IDENT.name };   // server finds the thread by account, not by token
    } else {
        try { var saved = JSON.parse(localStorage.getItem(STORE) || 'null'); if (saved && saved.token) state = saved; } catch (e) {}
    }
    function save() { if (IDENT) return; try { localStorage.setItem(STORE, JSON.stringify(state)); } catch (e) {} }
    var CACHE = 'epamnhs_chat_msgs' + (IDENT ? ':' + IDENT.key : '');
    function loadCache() { try { var c = JSON.parse(localStorage.getItem(CACHE) || '[]'); return Array.isArray(c) ? c : []; } catch (e) { return []; } }
    function saveCache(list) { try { localStorage.setItem(CACHE, JSON.stringify(list.slice(-200))); } catch (e) {} }
    function cacheAdd(msgs) {
        var list = loadCache(), seen = {};
        list.forEach(function (m) { seen[m.id] = 1; });
        msgs.forEach(function (m) { if (!seen[m.id]) list.push(m); });
        list.sort(function (a, b) { return a.id - b.id; });
        saveCache(list);
    }
    function forget() { if (IDENT) return; state = { token: '', name: '' }; try { localStorage.removeItem(STORE); localStorage.removeItem(CACHE); } catch (e) {} }

    var bodyEl = $('ecBody'), inputEl = $('ecInput'), sendBtn = $('ecSend'), errEl = $('ecError');
    var lastId = 0, lastDay = '', timer = null, sending = false;

    /* ---------- OK / open / back ---------- */
    $('enrollClosedOk').addEventListener('click', function () {
        stopPolling();
        overlay.remove();
        // Drop ?msg=enrollment_closed so a refresh doesn't show the modal again.
        if (window.history && history.replaceState) history.replaceState(null, '', 'login.php');
    });
    $('ecOpenChat').addEventListener('click', function () { overlay.classList.add('chat-open'); startChat(); });
    $('ecBack').addEventListener('click', function () { overlay.classList.remove('chat-open'); stopPolling(); });

    /* ---------- rendering ---------- */
    function addGreeting() {
        var row = document.createElement('div'); row.className = 'ec-row in';
        var b = document.createElement('div'); b.className = 'ec-bubble';
        b.textContent = "Hi! Enrollment is closed right now. Tell us your concern and the admin will reply here.";
        row.appendChild(b); bodyEl.appendChild(row);
    }

    function render(msgs) {
        cacheAdd(msgs);
        msgs.forEach(function (m) {
            if (m.day_key !== lastDay) {
                var d = document.createElement('div'); d.className = 'ec-day'; d.textContent = m.date;
                bodyEl.appendChild(d); lastDay = m.day_key;
            }
            var row = document.createElement('div'); row.className = 'ec-row ' + (m.sender === 'visitor' ? 'out' : 'in');
            var b = document.createElement('div'); b.className = 'ec-bubble'; b.textContent = m.body;
            var t = document.createElement('div'); t.className = 'ec-time'; t.textContent = m.time;
            row.appendChild(b); row.appendChild(t); bodyEl.appendChild(row);
            lastId = Math.max(lastId, m.id);
        });
    }
    function atBottom() { return bodyEl.scrollHeight - bodyEl.scrollTop - bodyEl.clientHeight < 80; }
    function toBottom() { bodyEl.scrollTop = bodyEl.scrollHeight; }
    function showError(msg) { errEl.textContent = msg || ''; errEl.style.padding = msg ? '0 14px 6px' : '0 14px'; }

    /* ---------- chat lifecycle ---------- */
    function resetThread() { bodyEl.innerHTML = ''; lastId = 0; lastDay = ''; }

    function startChat() {
        showError('');
        resetThread();
        if (!state.token) {
            $('ecDetails').style.display = '';
            addGreeting();
            return;
        }
        $('ecDetails').style.display = 'none';
        var cached = loadCache();
        if (cached.length) { render(cached); toBottom(); }
        fetchMessages(true);
        startPolling();
        var b = $('ecOpenChat'); if (b) b.classList.remove('has-new');
    }

    function fetchMessages(initial) {
        if (!state.token) return;
        fetch(API + '&action=fetch&token=' + encodeURIComponent(state.token) + '&after=' + lastId, { cache: 'no-store' })
            .then(function (r) { return r.text().then(function (t) { try { return JSON.parse(t); } catch (e) { return { ok: false }; } }); })
            .then(function (res) {
                if (!res.ok) {
                    if (res.error === 'not_found') { forget(); stopPolling(); startChat(); }
                    return;
                }
                if (initial && lastId === 0 && !res.messages.length) addGreeting();
                if (!res.messages.length) return;
                var stick = initial || atBottom();
                render(res.messages);
                if (stick) toBottom();
            })
            .catch(function () {});
    }

    function startPolling() { stopPolling(); timer = setInterval(function () { fetchMessages(false); }, 4000); }
    function stopPolling()  { if (timer) { clearInterval(timer); timer = null; } }

    /* ---------- send ---------- */
    function send() {
        if (sending) return;
        var text = inputEl.value.trim();
        if (!text) return;

        var fd = new URLSearchParams();
        fd.append('action', 'send');
        fd.append('message', text);
        fd.append('hp', $('ecWebsite').value);

        if (state.token) {
            fd.append('token', state.token);
        } else {
            var name = $('ecName').value.trim();
            if (name.length < 2) { showError('Please enter your name first.'); $('ecName').focus(); return; }
            fd.append('name', name);
            fd.append('contact', $('ecContact').value.trim());
        }

        sending = true; sendBtn.disabled = true; showError('');
        fetch(API, {
            method: 'POST',
            body: fd.toString(),
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(function (r) {
                return r.text().then(function (t) {
                    try { return JSON.parse(t); }
                    catch (e) { return { ok: false, error: (r.status === 403 ? 'Message blocked by the server (HTTP 403). Please refresh the page and try again.' : 'Server problem (HTTP ' + r.status + '). The message service may be unavailable right now.') }; }
                });
            })
            .then(function (res) {
                if (!res.ok) { showError(res.error || 'Could not send your message.'); return; }
                inputEl.value = ''; inputEl.style.height = 'auto';
                if (!state.token && res.token) {
                    state = { token: res.token, name: $('ecName').value.trim() };
                    save();
                    $('ecDetails').style.display = 'none';
                    resetThread();           // drop the local greeting; server history takes over
                    startPolling();
                }
                fetchMessages(true);
            })
            .catch(function () { showError('Could not reach the server. Check your internet connection and try again.'); })
            .then(function () { sending = false; sendBtn.disabled = false; inputEl.focus(); });
    }

    // Returning visitor: quietly check for new admin replies and flag the button.
    (function checkNewReplies() {
        if (!state.token) return;
        var cached = loadCache(), maxId = 0;
        cached.forEach(function (m) { maxId = Math.max(maxId, m.id); });
        fetch(API + '&action=fetch&token=' + encodeURIComponent(state.token) + '&after=' + maxId, { cache: 'no-store' })
            .then(function (r) { return r.text().then(function (t) { try { return JSON.parse(t); } catch (e) { return { ok: false }; } }); })
            .then(function (res) {
                if (!res.ok) { if (res.error === 'not_found') forget(); return; }
                if (!res.messages.length) return;
                cacheAdd(res.messages);
                var hasAdmin = res.messages.some(function (m) { return m.sender === 'admin'; });
                var b = $('ecOpenChat');
                if (hasAdmin && b) { b.classList.add('has-new'); b.insertAdjacentHTML('beforeend', ' <span class="ec-newdot">New reply</span>'); }
            }).catch(function () {});
    })();

    sendBtn.addEventListener('click', send);
    inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
    });
    inputEl.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 96) + 'px';
    });
})();
</script>
