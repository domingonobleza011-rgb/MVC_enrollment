<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
    .msg-shell {
        display: flex;
        height: calc(100vh - 230px);
        min-height: 480px;
        background: var(--edb-surface);
        border: 1px solid var(--edb-border);
        border-radius: 14px;
        box-shadow: 0 2px 10px var(--edb-shadow);
        overflow: hidden;
        color: var(--edb-ink);
    }

    /* ---------- Left: conversation list ---------- */
    .msg-list-pane {
        width: 340px;
        flex: 0 0 340px;
        border-right: 1px solid var(--edb-border);
        display: flex;
        flex-direction: column;
        min-width: 0;
    }
    .msg-list-head { padding: 16px 16px 10px; }
    .msg-list-head h5 { margin: 0 0 10px; font-weight: 700; }
    .msg-search {
        width: 100%;
        border: 1px solid var(--edb-input-border);
        background: transparent;
        color: var(--edb-ink);
        border-radius: 999px;
        padding: 8px 14px;
        font-size: .875rem;
        outline: none;
    }
    .msg-search:focus { border-color: rgba(var(--edb-chart-rgb), .6); }
    .msg-list { flex: 1; overflow-y: auto; }
    .msg-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 16px; cursor: pointer;
        border-left: 3px solid transparent;
    }
    .msg-item:hover { background: rgba(var(--edb-chart-rgb), .06); }
    .msg-item.active { background: rgba(var(--edb-chart-rgb), .10); border-left-color: rgb(var(--edb-chart-rgb)); }
    .msg-avatar {
        flex: 0 0 44px; width: 44px; height: 44px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 700; font-size: 1rem;
    }
    .msg-item-body { flex: 1; min-width: 0; }
    .msg-item-top { display: flex; justify-content: space-between; gap: 8px; }
    .msg-item-name { font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .msg-item-ago { font-size: .72rem; color: var(--edb-muted); flex: 0 0 auto; }
    .msg-item-preview {
        font-size: .82rem; color: var(--edb-muted);
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .msg-item.unread .msg-item-name,
    .msg-item.unread .msg-item-preview { color: var(--edb-ink); font-weight: 700; }
    .msg-unread-dot {
        flex: 0 0 auto; min-width: 20px; height: 20px; padding: 0 6px;
        border-radius: 10px; background: #dc2626; color: #fff;
        font-size: .7rem; font-weight: 700; line-height: 20px; text-align: center;
    }
    .msg-empty { padding: 36px 20px; text-align: center; color: var(--edb-muted); font-size: .9rem; }

    /* ---------- Right: thread ---------- */
    .msg-thread-pane { flex: 1; display: flex; flex-direction: column; min-width: 0; }
    .msg-thread-head {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 18px; border-bottom: 1px solid var(--edb-border);
    }
    .msg-back { display: none; background: none; border: 0; color: var(--edb-ink); font-size: 1.1rem; padding: 4px 8px 4px 0; }
    .msg-thread-name { font-weight: 700; line-height: 1.2; }
    .msg-thread-contact { font-size: .78rem; color: var(--edb-muted); }
    .msg-thread-head .msg-del {
        margin-left: auto; background: none; border: 0; color: var(--edb-muted);
        padding: 6px 10px; border-radius: 8px;
    }
    .msg-thread-head .msg-del:hover { color: #dc2626; background: rgba(220,38,38,.08); }

    .msg-body { flex: 1; overflow-y: auto; padding: 18px; display: flex; flex-direction: column; gap: 3px; }
    .msg-day { align-self: center; font-size: .72rem; color: var(--edb-muted); margin: 12px 0 6px; }
    .msg-row { display: flex; flex-direction: column; max-width: 70%; }
    .msg-row.in  { align-self: flex-start; align-items: flex-start; }
    .msg-row.out { align-self: flex-end;   align-items: flex-end; }
    .msg-bubble {
        padding: 8px 14px; border-radius: 18px; line-height: 1.4;
        white-space: pre-wrap; word-break: break-word; font-size: .92rem;
    }
    .msg-row.in  .msg-bubble { background: rgba(var(--edb-chart-rgb), .12); color: var(--edb-ink); border-bottom-left-radius: 6px; }
    .msg-row.out .msg-bubble { background: rgb(var(--edb-chart-rgb)); color: var(--edb-on-chart); border-bottom-right-radius: 6px; }
    .msg-time { font-size: .68rem; color: var(--edb-muted); margin: 2px 6px 6px; }

    .msg-composer {
        display: flex; align-items: flex-end; gap: 10px;
        padding: 12px 16px; border-top: 1px solid var(--edb-border);
    }
    .msg-input {
        flex: 1; resize: none; max-height: 120px;
        border: 1px solid var(--edb-input-border); background: transparent; color: var(--edb-ink);
        border-radius: 20px; padding: 9px 16px; outline: none; font-size: .92rem; line-height: 1.4;
    }
    .msg-input:focus { border-color: rgba(var(--edb-chart-rgb), .6); }
    .msg-send {
        flex: 0 0 auto; width: 42px; height: 42px; border: 0; border-radius: 50%;
        background: rgb(var(--edb-chart-rgb)); color: var(--edb-on-chart);
        display: flex; align-items: center; justify-content: center;
    }
    .msg-send:disabled { opacity: .45; cursor: default; }

    .msg-placeholder {
        flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
        color: var(--edb-muted); text-align: center; padding: 20px;
    }
    .msg-placeholder i { font-size: 3rem; margin-bottom: 14px; opacity: .5; }

    /* ---------- Mobile: one pane at a time ---------- */
    @media (max-width: 767.98px) {
        .msg-shell { height: calc(100vh - 190px); }
        .msg-list-pane { width: 100%; flex: 1 1 100%; border-right: 0; }
        .msg-thread-pane { display: none; width: 100%; }
        .msg-shell.show-thread .msg-list-pane { display: none; }
        .msg-shell.show-thread .msg-thread-pane { display: flex; }
        .msg-back { display: block; }
        .msg-row { max-width: 85%; }
    }

    /* ===== Delete confirmation modal (same design as admn_archive) ===== */
.delete-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10, 20, 40, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.delete-modal-overlay.show {
    display: flex;
}
.delete-modal {
    background: #fff;
    border-radius: 20px;
    padding: 2rem;
    max-width: 380px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: popIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-align: center;
}
@keyframes popIn {
    from { transform: scale(0.8); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}
.delete-modal-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #fff0f0, #ffe0e0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.2rem;
    border: 3px solid #f5c6c6;
}
.delete-modal-icon i {
    font-size: 1.8rem;
    color: #e74c3c;
}
.delete-modal h5 {
    font-family: 'Segoe UI', sans-serif;
    font-weight: 800;
    font-size: 1.15rem;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}
.delete-modal p {
    font-size: 0.85rem;
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}
.delete-modal-warning {
    background: #fff8e1;
    border: 1px solid #ffe082;
    border-radius: 10px;
    padding: 0.6rem 1rem;
    font-size: 0.78rem;
    color: #f39c12;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.delete-modal-actions {
    display: flex;
    gap: 10px;
}
.btn-cancel-modal {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: 1.5px solid #e0e0e0;
    background: #f8f9fa;
    color: #555;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel-modal:hover {
    background: #e9ecef;
    border-color: #ccc;
}
.btn-confirm-delete {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #c0392b, #e74c3c);
    color: white;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(231,76,60,0.4);
    transition: all 0.2s;
}
.btn-confirm-delete:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(231,76,60,0.5);
}

html[data-theme="dark"] .delete-modal { background: #1a1f2b !important; }
html[data-theme="dark"] .delete-modal h5 { color: #eef0f4 !important; }
html[data-theme="dark"] .delete-modal p { color: #9aa2b1 !important; }
html[data-theme="dark"] .delete-modal p strong { color: #eef0f4 !important; }
html[data-theme="dark"] .delete-modal-warning {
    background: rgba(243,156,18,0.12) !important;
    border-color: rgba(243,156,18,0.35) !important;
    color: #f5b041 !important;
}
html[data-theme="dark"] .delete-modal-icon {
    background: linear-gradient(135deg, rgba(231,76,60,0.18), rgba(231,76,60,0.28)) !important;
    border-color: rgba(231,76,60,0.45) !important;
}
html[data-theme="dark"] .btn-cancel-modal {
    background: #232a38 !important;
    border-color: rgba(255,255,255,0.15) !important;
    color: #d7dbe2 !important;
}
html[data-theme="dark"] .btn-cancel-modal:hover {
    background: #2a3242 !important;
    border-color: rgba(255,255,255,0.28) !important;
}
</style>

<div class="container-fluid plain-page">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" style="color:var(--edb-ink);font-weight:700;">
            <i class="fas fa-comments mr-2"></i>Messages
        </h1>
    </div>

    <div class="msg-shell" id="msgShell">
        <!-- Conversation list -->
        <div class="msg-list-pane">
            <div class="msg-list-head">
                <h5>Chats</h5>
                <input type="text" id="msgSearch" class="msg-search" placeholder="Search name or contact" autocomplete="off">
            </div>
            <div class="msg-list" id="msgList"></div>
        </div>

        <!-- Thread -->
        <div class="msg-thread-pane">
            <div class="msg-placeholder" id="msgPlaceholder">
                <i class="far fa-comment-dots"></i>
                <div class="font-weight-bold">Select a conversation</div>
                <div class="small">Messages sent from the enrollment-closed notice appear here.</div>
            </div>

            <div id="msgThreadWrap" style="display:none; flex:1; flex-direction:column; min-height:0;">
                <div class="msg-thread-head">
                    <button class="msg-back" id="msgBack" title="Back"><i class="fas fa-arrow-left"></i></button>
                    <div style="min-width:0;">
                        <div class="msg-thread-name" id="msgHeadName"></div>
                        <div class="msg-thread-contact" id="msgHeadContact"></div>
                    </div>
                    <button class="msg-del" id="msgDelete" title="Delete conversation"><i class="fas fa-trash-alt"></i></button>
                </div>
                <div class="msg-body" id="msgBody"></div>
                <div class="msg-composer">
                    <textarea id="msgInput" class="msg-input" rows="1" placeholder="Write a reply…" maxlength="2000"></textarea>
                    <button class="msg-send" id="msgSend" title="Send"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="delete-modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h5>Delete Conversation?</h5>
        <p>You are about to permanently delete this whole conversation and all of its messages. This action is irreversible.</p>
        <div class="delete-modal-warning">
            <i class="fas fa-exclamation-triangle"></i>
            This cannot be undone!
        </div>
        <div class="delete-modal-actions">
            <button type="button" class="btn-cancel-modal" id="cancelDeleteBtn">
                Cancel
            </button>
            <button type="button" class="btn-confirm-delete" id="confirmDeleteBtn">
                <i class="fas fa-trash-alt"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    var API  = 'admn_messages_api.php';
    var CSRF = <?= json_encode($csrf_value) ?>;
    var activeId = <?= (int)$initial_conv ?: 'null' ?>;
    var lastMsgId = 0, lastDay = '', busy = false;

    var $ = function (id) { return document.getElementById(id); };
    var shell = $('msgShell'), listEl = $('msgList'), bodyEl = $('msgBody'), inputEl = $('msgInput'), sendBtn = $('msgSend');

    var COLORS = ['#2563eb', '#7c3aed', '#db2777', '#ea580c', '#059669', '#0891b2', '#4f46e5', '#b45309'];
    function colorFor(name) { var h = 0; for (var i = 0; i < name.length; i++) h = (h * 31 + name.charCodeAt(i)) >>> 0; return COLORS[h % COLORS.length]; }
    function initials(name) {
        var p = name.trim().split(/\s+/);
        return ((p[0] || '?')[0] + (p.length > 1 ? p[p.length - 1][0] : '')).toUpperCase();
    }
    function setAvatar(el, name) { el.textContent = initials(name); el.style.background = colorFor(name); }

    function getJSON(url) { return fetch(url, { credentials: 'same-origin' }).then(function (r) { return r.json(); }); }
    function post(data) {
        var fd = new FormData();
        Object.keys(data).forEach(function (k) { fd.append(k, data[k]); });
        fd.append('csrf_token', CSRF);
        return fetch(API, { method: 'POST', body: fd, credentials: 'same-origin' }).then(function (r) { return r.json(); });
    }

    /* ---------- conversation list ---------- */
    function loadList() {
        var q = $('msgSearch').value.trim();
        return getJSON(API + '?action=list&q=' + encodeURIComponent(q)).then(function (res) {
            if (!res.ok) return;
            listEl.innerHTML = '';
            if (!res.conversations.length) {
                var e = document.createElement('div');
                e.className = 'msg-empty';
                e.textContent = q ? 'No chats match your search.' : 'No messages yet.';
                listEl.appendChild(e);
                return;
            }
            res.conversations.forEach(function (c) {
                var item = document.createElement('div');
                item.className = 'msg-item' + (c.id === activeId ? ' active' : '') + (c.unread > 0 ? ' unread' : '');
                item.dataset.id = c.id;

                var body = document.createElement('div'); body.className = 'msg-item-body';
                var top = document.createElement('div'); top.className = 'msg-item-top';
                var nm = document.createElement('div'); nm.className = 'msg-item-name'; nm.textContent = c.name;
                var ago = document.createElement('div'); ago.className = 'msg-item-ago'; ago.textContent = c.ago;
                top.appendChild(nm); top.appendChild(ago);
                var pv = document.createElement('div'); pv.className = 'msg-item-preview'; pv.textContent = c.preview;
                body.appendChild(top); body.appendChild(pv);

                item.appendChild(body);
                if (c.unread > 0) {
                    var b = document.createElement('div'); b.className = 'msg-unread-dot'; b.textContent = c.unread > 99 ? '99+' : c.unread;
                    item.appendChild(b);
                }
                item.addEventListener('click', function () { openConv(c.id); });
                listEl.appendChild(item);
            });
        });
    }

    /* ---------- thread ---------- */
    function nearBottom() { return bodyEl.scrollHeight - bodyEl.scrollTop - bodyEl.clientHeight < 80; }

    function appendMessages(msgs) {
        msgs.forEach(function (m) {
            if (m.day_key !== lastDay) {
                var d = document.createElement('div'); d.className = 'msg-day'; d.textContent = m.date;
                bodyEl.appendChild(d); lastDay = m.day_key;
            }
            var row = document.createElement('div'); row.className = 'msg-row ' + (m.sender === 'admin' ? 'out' : 'in');
            var bub = document.createElement('div'); bub.className = 'msg-bubble'; bub.textContent = m.body;
            var tm = document.createElement('div'); tm.className = 'msg-time'; tm.textContent = m.time;
            row.appendChild(bub); row.appendChild(tm);
            bodyEl.appendChild(row);
            lastMsgId = Math.max(lastMsgId, m.id);
        });
    }

    function openConv(id) {
        activeId = id; lastMsgId = 0; lastDay = '';
        bodyEl.innerHTML = '';
        $('msgPlaceholder').style.display = 'none';
        $('msgThreadWrap').style.display = 'flex';
        shell.classList.add('show-thread');
        if (history.replaceState) history.replaceState(null, '', 'admn_messages.php?c=' + id);

        getJSON(API + '?action=thread&id=' + id + '&after=0').then(function (res) {
            if (!res.ok) { closeThread(); return; }
            $('msgHeadName').textContent = res.name;
            $('msgHeadContact').textContent = res.contact || 'No contact provided';
            appendMessages(res.messages);
            bodyEl.scrollTop = bodyEl.scrollHeight;
            inputEl.focus();
            loadList(); refreshBell();
        });
    }

    function closeThread() {
        activeId = null;
        $('msgThreadWrap').style.display = 'none';
        $('msgPlaceholder').style.display = 'flex';
        shell.classList.remove('show-thread');
        if (history.replaceState) history.replaceState(null, '', 'admn_messages.php');
        loadList();
    }

    function pollThread() {
        if (!activeId || busy) return;
        var id = activeId;
        getJSON(API + '?action=thread&id=' + id + '&after=' + lastMsgId).then(function (res) {
            if (!res.ok || id !== activeId || !res.messages.length) return;
            var stick = nearBottom();
            appendMessages(res.messages);
            if (stick) bodyEl.scrollTop = bodyEl.scrollHeight;
            loadList(); refreshBell();
        }).catch(function () {});
    }

    function refreshBell() { if (typeof window.refreshMsgNotif === 'function') window.refreshMsgNotif(); }

    /* ---------- send ---------- */
    function send() {
        var text = inputEl.value.trim();
        if (!text || !activeId || busy) return;
        busy = true; sendBtn.disabled = true;
        post({ action: 'reply', id: activeId, message: text }).then(function (res) {
            if (res.ok) {
                inputEl.value = ''; inputEl.style.height = 'auto';
                busy = false;
                getJSON(API + '?action=thread&id=' + activeId + '&after=' + lastMsgId).then(function (r) {
                    if (r.ok) { appendMessages(r.messages); bodyEl.scrollTop = bodyEl.scrollHeight; }
                    loadList();
                });
            } else {
                busy = false;
                alert(res.error || 'Could not send the message.');
            }
        }).catch(function () { busy = false; alert('Network error. Please try again.'); })
          .then(function () { busy = false; sendBtn.disabled = false; inputEl.focus(); });
    }

    sendBtn.addEventListener('click', send);
    inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
    });
    inputEl.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    $('msgBack').addEventListener('click', closeThread);
    $('msgDelete').addEventListener('click', function () {
        if (!activeId) return;
        $('deleteModalOverlay').classList.add('show');
    });
    function closeDeleteModal() { $('deleteModalOverlay').classList.remove('show'); }
    $('cancelDeleteBtn').addEventListener('click', closeDeleteModal);
    $('deleteModalOverlay').addEventListener('click', function (e) { if (e.target === this) closeDeleteModal(); });
    $('confirmDeleteBtn').addEventListener('click', function () {
        var id = activeId;
        closeDeleteModal();
        if (!id) return;
        post({ action: 'delete', id: id }).then(function (res) { if (res.ok) closeThread(); refreshBell(); });
    });

    var searchTimer = null;
    $('msgSearch').addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(loadList, 300);
    });

    /* ---------- boot + live updates ---------- */
    loadList().then(function () { if (activeId) openConv(activeId); });
    setInterval(pollThread, 4000);
    setInterval(function () { if (!$('msgSearch').value.trim()) loadList(); }, 10000);
})();
</script>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
