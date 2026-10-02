<?php

if (!isset($current_user_id)) {
    $current_user_id = $userdetails['id_student'] ?? '';
}
if (!isset($active_page)) {
    $active_page = '';
}

// Who is logged in (shown in the account menu). Falls back gracefully if a page
// doesn't provide the name fields.
if (!function_exists('fb_first_char')) {
    function fb_first_char($str) {
        $str = trim((string)$str);
        if ($str === '') return '';
        $c = function_exists('mb_substr') ? mb_substr($str, 0, 1) : substr($str, 0, 1);
        return function_exists('mb_strtoupper') ? mb_strtoupper($c) : strtoupper($c);
    }
}
$nav_first_name = trim((string)($userdetails['firstname'] ?? ''));
$nav_surname    = trim((string)($userdetails['surname'] ?? ''));
$nav_full_name  = trim($nav_first_name . ' ' . $nav_surname);
$nav_initials   = fb_first_char($nav_first_name) . fb_first_char($nav_surname);
if ($nav_full_name === '') $nav_full_name = 'Student';
if ($nav_initials === '')  $nav_initials = 'S';
$nav_short_name = $nav_first_name !== '' ? $nav_first_name : 'Account';

$notif_unread_count = $eusebia->get_unread_notification_count($current_user_id);
$msg_unread_count   = method_exists($eusebia, 'chat_student_unread') ? $eusebia->chat_student_unread($current_user_id) : 0;
$notif_list = $eusebia->get_notifications($current_user_id, 8);

if (!function_exists('fb_notif_time_ago')) {
    function fb_notif_time_ago($datetime) {
        if (empty($datetime)) return '';
        $diff = time() - strtotime($datetime);
        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return floor($diff / 60) . 'm ago';
        if ($diff < 86400) return floor($diff / 3600) . 'h ago';
        if ($diff < 604800) return floor($diff / 86400) . 'd ago';
        return date('M j, Y', strtotime($datetime));
    }
}

/**
 * Renders the notification bell + dropdown panel.
 * Called twice (desktop inline row, mobile top bar) with a unique $idSuffix
 * so both copies can exist in the DOM without id collisions.
 */
function render_notif_bell($idSuffix, $notif_unread_count, $notif_list) {
    ob_start();
    ?>
    <div class="dropdown">
        <button class="fb-icon-btn js-notif-bell" id="notifBell<?= $idSuffix ?>" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications" title="Notifications">
            <i class="fas fa-bell"></i>
            <?php if ($notif_unread_count > 0): ?>
                <span class="fb-notif-badge"><?= $notif_unread_count > 9 ? '9+' : $notif_unread_count ?></span>
            <?php endif; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end fb-notif-panel js-notif-list" aria-labelledby="notifBell<?= $idSuffix ?>">
            <li class="fb-notif-header">Notifications</li>
            <?php if (empty($notif_list)): ?>
                <li class="fb-notif-empty">No notifications yet.</li>
            <?php else: foreach ($notif_list as $n):
                $type = $n['type'] ?? 'info';
                $iconClass = $type === 'approved' ? 'fa-check' : ($type === 'rejected' ? 'fa-xmark' : 'fa-circle-info');
                $bubbleClass = $type === 'approved' ? 'ok' : ($type === 'rejected' ? 'bad' : '');
            ?>
                <li class="fb-notif-item<?= empty($n['is_read']) ? ' unread' : '' ?>" data-notif-id="<?= (int)$n['id_notification'] ?>">
                    <div class="fb-notif-icon <?= $bubbleClass ?>"><i class="fas <?= $iconClass ?>"></i></div>
                    <div class="fb-notif-body">
                        <div class="fb-notif-title"><?= htmlspecialchars($n['title']) ?></div>
                        <div class="fb-notif-msg"><?= htmlspecialchars($n['message']) ?></div>
                        <div class="fb-notif-time"><?= fb_notif_time_ago($n['created_at']) ?></div>
                    </div>
                    <button type="button" class="fb-notif-delete-btn js-notif-delete" data-id="<?= (int)$n['id_notification'] ?>" title="Delete notification">
                        <i class="fas fa-times"></i>
                    </button>
                </li>
            <?php endforeach; endif; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
?>
<?php include(VIEWS_PATH . '/partials/admin_loading_overlay.php'); ?>
<style>
    :root {
        --navbar-height: 56px;
        --sidebar-width: 260px;
        --bg-card: #ffffff;
        --brand-color: #0f3b7a;
    }
<?php if (empty($navbar_skip_body_layout)): ?>
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
<?php endif; ?>

    .fb-navbar {
        position: sticky;
        top: 0;
        z-index: 1030;
        background: linear-gradient(135deg, #0b2b5c 0%, #0f3b7a 100%);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        height: var(--navbar-height);
        padding: 0 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: auto;
    }

    /* LEFT: logo + school name (always links home) */
    .fb-navbar-brand {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: #ffffff;
        text-decoration: none;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .fb-navbar-brand:hover { color: #ffffff; }
    .fb-brand-logo {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffffff;
        object-fit: contain;
        padding: 2px;
        flex-shrink: 0;
    }

    /* Main links sit right after the logo, left-aligned */
    .fb-nav-links {
        display: flex;
        align-items: stretch;
        height: 100%;
        gap: 0.25rem;
        margin-left: 1.25rem;
    }
    .fb-nav-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0 0.95rem;
        font-size: 0.92rem;
        font-weight: 500;
        color: rgba(255,255,255,0.72);
        text-decoration: none;
        transition: color 0.15s ease, background-color 0.15s ease;
    }
    .fb-nav-link i { font-size: 1rem; }
    .fb-nav-badge {
        background: #dc3545; color: #fff; font-size: .68rem; font-weight: 700;
        min-width: 18px; height: 18px; padding: 0 5px; border-radius: 9px;
        display: inline-flex; align-items: center; justify-content: center; line-height: 1;
    }
    .fb-nav-link:hover {
        color: #ffffff;
        background: rgba(255,255,255,0.08);
    }
    .fb-nav-link.active {
        color: #ffffff;
        font-weight: 600;
    }
    /* visible "you are here" underline */
    .fb-nav-link.active::after {
        content: '';
        position: absolute;
        left: 0.6rem;
        right: 0.6rem;
        bottom: 0;
        height: 3px;
        border-radius: 3px 3px 0 0;
        background: #ffffff;
    }

    /* RIGHT: notifications + account */
    .fb-nav-right {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-left: auto;
    }
    .fb-icon-btn {
        position: relative;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
        color: #ffffff;
        font-size: 1.05rem;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .fb-icon-btn:hover,
    .fb-icon-btn[aria-expanded="true"] { background: rgba(255,255,255,0.22); }

    .fb-account-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        height: 40px;
        padding: 0 0.7rem 0 0.35rem;
        border: none;
        border-radius: 999px;
        background: rgba(255,255,255,0.10);
        color: #ffffff;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .fb-account-btn:hover,
    .fb-account-btn[aria-expanded="true"] { background: rgba(255,255,255,0.22); }
    .fb-account-name {
        max-width: 110px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .fb-account-caret { font-size: 0.65rem; opacity: 0.8; }

    .fb-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.4);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .fb-nav-link:focus-visible,
    .fb-icon-btn:focus-visible,
    .fb-account-btn:focus-visible,
    .fb-menu-toggle:focus-visible {
        outline: 2px solid #ffffff;
        outline-offset: -2px;
    }

    /* Account dropdown (same look as the notification panel) */
    .fb-account-menu {
        width: 260px;
        border: none;
        border-radius: 12px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        padding: 8px;
        margin-top: 10px;
    }
    .fb-account-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 10px 12px;
        margin-bottom: 4px;
        border-bottom: 1px solid #eef1f6;
    }
    .fb-account-header .fb-avatar {
        width: 40px;
        height: 40px;
        font-size: 0.95rem;
        background: #0f3b7a;
        border-color: #0f3b7a;
    }
    .fb-account-header-name {
        font-weight: 600;
        font-size: 0.92rem;
        color: #1a2c3e;
        line-height: 1.25;
        word-break: break-word;
    }
    .fb-account-header-role {
        font-size: 0.78rem;
        color: #7a8a99;
    }
    .fb-account-menu .dropdown-item,
    .fb-mobile-menu-panel .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        color: #1a2c3e;
        font-weight: 500;
        font-size: 0.92rem;
    }
    .fb-account-menu .dropdown-item:hover,
    .fb-account-menu .dropdown-item.active,
    .fb-mobile-menu-panel .dropdown-item:hover { background: #eef1f6; color: #1a2c3e; }
    .fb-account-menu .dropdown-item .icon-wrap,
    .fb-mobile-menu-panel .dropdown-item .icon-wrap {
        width: 20px;
        color: #4a5a6a;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Mobile: bell + hamburger on the right (hidden on desktop) */
    .fb-mobile-actions {
        display: none;
        align-items: center;
        gap: 0.4rem;
        margin-left: auto;
    }
    .fb-menu-toggle {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
        color: #ffffff;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .fb-menu-toggle:hover,
    .fb-menu-toggle[aria-expanded="true"] { background: rgba(255,255,255,0.22); }

    /* Notification bell */
    .fb-notif-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        min-width: 17px;
        height: 17px;
        padding: 0 4px;
        border-radius: 999px;
        background: #e41e3f;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        line-height: 17px;
        text-align: center;
        border: 2px solid #0b2b5c;
    }
    .fb-notif-panel {
        width: 340px;
        max-width: 90vw;
        max-height: 420px;
        overflow-y: auto;
        border: none;
        border-radius: 16px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        padding: 0;
        margin-top: 10px;
    }
    .fb-notif-header {
        padding: 14px 18px;
        font-weight: 700;
        font-size: 1.05rem;
        color: #0b2b5c;
        border-bottom: 1px solid #eef1f6;
    }
    .fb-notif-empty {
        padding: 28px 18px;
        text-align: center;
        color: #8a96a3;
        font-size: 0.9rem;
    }
    .fb-notif-item {
        display: flex;
        gap: 12px;
        padding: 12px 18px;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f3f5f9;
        position: relative;
    }
    .fb-notif-item.unread {
        background: #eef4ff;
    }
    .fb-notif-delete-btn {
        flex-shrink: 0;
        align-self: flex-start;
        width: 24px;
        height: 24px;
        border: none;
        background: none;
        color: #b7c0ca;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .fb-notif-delete-btn:hover {
        background: #fde8e8;
        color: #c0392b;
    }
    .fb-notif-icon {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        color: #fff;
        background: #6c7a89;
    }
    .fb-notif-icon.ok { background: #28a745; }
    .fb-notif-icon.bad { background: #c0392b; }
    .fb-notif-body { flex: 1; min-width: 0; }
    .fb-notif-title {
        font-weight: 600;
        font-size: 0.88rem;
        color: #1a2c3e;
        margin-bottom: 2px;
    }
    .fb-notif-msg {
        font-size: 0.82rem;
        color: #5e7e9e;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .fb-notif-time {
        font-size: 0.75rem;
        color: #9aa8b5;
        margin-top: 4px;
    }

    /* ===== MOBILE MENU (hamburger) ===== */
    .fb-mobile-menu-panel {
        width: 250px;
        border: none;
        border-radius: 12px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        padding: 8px;
        margin-top: 10px;
    }
    .fb-mobile-menu-panel .dropdown-item.active { background: #eef1f6; color: #1a2c3e; font-weight: 600; }

    @media (max-width: 992px) {
        .fb-account-name, .fb-account-caret { display: none; }   /* avatar only on tablets */
        .fb-account-btn { padding: 0 0.35rem; }
    }
    @media (max-width: 768px) {
        .fb-nav-links, .fb-nav-right { display: none; }   /* desktop layout hidden */
        .fb-mobile-actions { display: flex; }             /* bell + hamburger shown */
        .fb-navbar { padding: 0 0.85rem; }
    }
</style>

<nav class="fb-navbar" aria-label="Main navigation">
    <!-- LEFT: logo + school name, always links home -->
    <a class="fb-navbar-brand" href="student_homepage.php" title="Eusebia Paz Arroyo Memorial National High School">
        <img class="fb-brand-logo" src="icons/Documents/eusebia.png" alt="">
        <span>EPAMNHS</span>
    </a>

    <!-- Main links, left-aligned next to the logo (desktop) -->
    <div class="fb-nav-links">
        <a class="fb-nav-link<?= $active_page === 'dashboard' ? ' active' : '' ?>" href="student_homepage.php"<?= $active_page === 'dashboard' ? ' aria-current="page"' : '' ?>>
            <i class="fas fa-home"></i><span>Home</span>
        </a>
        <a class="fb-nav-link<?= $active_page === 'submissions' ? ' active' : '' ?>" href="my_submissions.php?id_student=<?= $current_user_id ?>"<?= $active_page === 'submissions' ? ' aria-current="page"' : '' ?>>
            <i class="fas fa-file-alt"></i><span>My Submissions</span>
        </a>
        <a class="fb-nav-link<?= $active_page === 'messages' ? ' active' : '' ?>" href="student_messages.php"<?= $active_page === 'messages' ? ' aria-current="page"' : '' ?>>
            <i class="fas fa-comments"></i><span>Messages</span>
            <?php if ($msg_unread_count > 0): ?><span class="fb-nav-badge"><?= $msg_unread_count > 9 ? '9+' : $msg_unread_count ?></span><?php endif; ?>
        </a>
    </div>

    <!-- RIGHT (desktop): notifications, then the account menu -->
    <div class="fb-nav-right">
        <?= render_notif_bell('Desktop', $notif_unread_count, $notif_list) ?>

        <div class="dropdown">
            <button class="fb-account-btn" id="accountMenuBtn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Account menu">
                <span class="fb-avatar"><?= htmlspecialchars($nav_initials) ?></span>
                <span class="fb-account-name"><?= htmlspecialchars($nav_short_name) ?></span>
                <i class="fas fa-chevron-down fb-account-caret"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end fb-account-menu" aria-labelledby="accountMenuBtn">
                <li class="fb-account-header">
                    <span class="fb-avatar"><?= htmlspecialchars($nav_initials) ?></span>
                    <div>
                        <div class="fb-account-header-name"><?= htmlspecialchars($nav_full_name) ?></div>
                        <div class="fb-account-header-role">Student</div>
                    </div>
                </li>
                <li>
                    <a class="dropdown-item<?= $active_page === 'changepass' ? ' active' : '' ?>" href="student_changepass.php?id_student=<?= $current_user_id ?>">
                        <span class="icon-wrap"><i class="fas fa-key"></i></span> Change Password
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                        <span class="icon-wrap"><i class="fas fa-sign-out-alt"></i></span> Log out
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Mobile-only: bell stays visible, hamburger opens the same menu -->
    <div class="fb-mobile-actions">
        <?= render_notif_bell('Mobile', $notif_unread_count, $notif_list) ?>
        <div class="dropdown">
            <button class="fb-menu-toggle" id="menuToggleBtn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu" title="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end fb-mobile-menu-panel" aria-labelledby="menuToggleBtn">
                <li class="fb-account-header">
                    <span class="fb-avatar"><?= htmlspecialchars($nav_initials) ?></span>
                    <div>
                        <div class="fb-account-header-name"><?= htmlspecialchars($nav_full_name) ?></div>
                        <div class="fb-account-header-role">Student</div>
                    </div>
                </li>
                <li>
                    <a href="student_homepage.php" class="dropdown-item<?= $active_page === 'dashboard' ? ' active' : '' ?>">
                        <span class="icon-wrap"><i class="fas fa-home"></i></span> Home
                    </a>
                </li>
                <li>
                    <a href="my_submissions.php?id_student=<?= $current_user_id ?>" class="dropdown-item<?= $active_page === 'submissions' ? ' active' : '' ?>">
                        <span class="icon-wrap"><i class="fas fa-file-alt"></i></span> My Submissions
                    </a>
                </li>
                <li>
                    <a href="student_messages.php" class="dropdown-item<?= $active_page === 'messages' ? ' active' : '' ?>">
                        <span class="icon-wrap"><i class="fas fa-comments"></i></span> Messages<?php if ($msg_unread_count > 0): ?> <span class="fb-nav-badge"><?= $msg_unread_count > 9 ? '9+' : $msg_unread_count ?></span><?php endif; ?>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a href="student_changepass.php?id_student=<?= $current_user_id ?>" class="dropdown-item<?= $active_page === 'changepass' ? ' active' : '' ?>">
                        <span class="icon-wrap"><i class="fas fa-key"></i></span> Change Password
                    </a>
                </li>
                <li>
                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                        <span class="icon-wrap"><i class="fas fa-sign-out-alt"></i></span> Log out
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Logout confirmation modal (opened from the account menu on desktop, hamburger on mobile) -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmModalLabel">Log out?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="logout.php" class="btn btn-danger" onclick="showAdminLoading('Logging out...', 'sign-out-alt')">Yes, log out</a>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        // Notification bells (desktop + mobile copies) — clear badge and mark read on open
        document.querySelectorAll('.js-notif-bell').forEach(function (bell) {
            bell.addEventListener('shown.bs.dropdown', function () {
                var badge = bell.querySelector('.fb-notif-badge');
                if (badge) badge.remove();
                fetch('notifications_mark_read.php', { method: 'POST' }).catch(function () {});
            });
        });

        // Delete a single notification (delegated — covers both desktop/mobile copies)
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.js-notif-delete');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation(); // don't close the dropdown

            var id = btn.getAttribute('data-id');
            if (!id) return;
            btn.disabled = true;

            var body = new URLSearchParams({ id_notification: id });
            fetch('notification_delete.php', { method: 'POST', body: body })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (!data.success) { btn.disabled = false; return; }
                    // Remove this notification from every copy of the list (desktop + mobile)
                    document.querySelectorAll('.js-notif-list li[data-notif-id="' + id + '"]').forEach(function (li) {
                        var list = li.closest('.js-notif-list');
                        li.remove();
                        if (list && !list.querySelector('li[data-notif-id]')) {
                            list.insertAdjacentHTML('beforeend', '<li class="fb-notif-empty">No notifications yet.</li>');
                        }
                    });
                })
                .catch(function () { btn.disabled = false; });
        });

       
        document.querySelectorAll('.fb-navbar-brand, .fb-nav-link, .fb-account-menu a.dropdown-item, .fb-mobile-menu-panel a.dropdown-item').forEach(function (link) {
            link.addEventListener('click', function (e) {
                if (e.defaultPrevented || e.ctrlKey || e.metaKey || e.shiftKey || e.button === 1) return;

                var href = link.getAttribute('href');
                if (!href || href === '#' || href.indexOf('javascript:') === 0) return;
                if (link.hasAttribute('data-toggle') || link.hasAttribute('data-bs-toggle')) return;
                if (link.target && link.target !== '' && link.target !== '_self') return;

                if (typeof showAdminLoading === 'function') showAdminLoading('Loading...');
            });
        });
    })();
</script>