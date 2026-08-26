<?php

if (!isset($current_user_id)) {
    $current_user_id = $userdetails['id_student'] ?? '';
}
if (!isset($active_page)) {
    $active_page = '';
}

$notif_unread_count = $eusebia->get_unread_notification_count($current_user_id);
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
        <button class="fb-nav-item js-notif-bell" id="notifBell<?= $idSuffix ?>" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
            <i class="fas fa-bell"></i><span class="fb-nav-label">Notifications</span>
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
<style>
    :root {
        --navbar-height: 56px;
        --sidebar-width: 260px;
        --bg-card: #ffffff;
        --brand-color: #0f3b7a;
    }

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
        justify-content: space-between;
    }
    .fb-navbar-brand {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: #ffffff;
        text-decoration: none;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .fb-nav-icons {
        display: flex;
        align-items: center;
        height: 100%;
        gap: 2.5rem;
        margin: 0 auto;
    }
    .fb-nav-item {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 100%;
        padding: 0 0.85rem;
        font-size: 1.4rem;
        color: rgba(255,255,255,0.65);
        text-decoration: none;
        transition: color 0.15s ease;
        border: none;
        background: none;
        cursor: pointer;
    }
    .fb-nav-label {
        font-size: 0.9rem;
        font-weight: 500;
        letter-spacing: -0.011em;
    }
    .fb-nav-item:hover {
        color: #ffffff;
    }
    .fb-nav-item.active {
        color: #ffffff;
    }
    .fb-nav-item.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 65%;
        height: 3px;
        border-radius: 3px 3px 0 0;
    }
    .fb-nav-spacer {
        flex-shrink: 0;
        width: 90px;
    }

    /* Right-hand cluster on mobile: bell stays, hamburger opens the drawer */
    .fb-mobile-actions {
        display: none;
        align-items: center;
        height: 100%;
        gap: 0.25rem;
    }
    .fb-menu-toggle {
        border: none;
        background: none;
        color: #ffffff;
        font-size: 1.3rem;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Notification bell */
    .fb-notif-badge {
        position: absolute;
        top: 6px;
        right: 2px;
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

    /* ===== MOBILE MENU DROPDOWN (Home / Submissions / Change Password / Logout) ===== */
    .fb-mobile-menu-panel {
        width: 230px;
        border: none;
        border-radius: 16px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        padding: 8px;
        margin-top: 10px;
    }
    .fb-mobile-menu-panel .side-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        color: #1a2c3e;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 2px;
    }
    .fb-mobile-menu-panel .side-link:hover,
    .fb-mobile-menu-panel .side-link.active { background: #eef1f6; }
    .fb-mobile-menu-panel .side-link .icon-wrap {
        width: 20px;
        color: #4a5a6a;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .fb-nav-icons { display: none; }       /* inline row hidden on mobile */
        .fb-mobile-actions { display: flex; }  /* bell + hamburger shown instead */
        .fb-nav-spacer { display: none; }
    }
</style>

<nav class="fb-navbar">
    <a class="fb-navbar-brand" href="student_homepage.php">
        <i class="bi bi-mortarboard-fill me-1"></i> EPAMNHS
    </a>

    <!-- Desktop inline nav (hidden on mobile) -->
    <div class="fb-nav-icons">
        <a class="fb-nav-item<?= $active_page === 'dashboard' ? ' active' : '' ?>" href="student_homepage.php" title="Dashboard">
            <i class="fas fa-home"></i><span class="fb-nav-label">Home</span>
        </a>
        <a class="fb-nav-item<?= $active_page === 'submissions' ? ' active' : '' ?>" href="my_submissions.php?id_student=<?= $current_user_id ?>" title="My Submissions">
            <i class="fas fa-file-alt"></i><span class="fb-nav-label">Submissions</span>
        </a>

        <?= render_notif_bell('Desktop', $notif_unread_count, $notif_list) ?>

        <a class="fb-nav-item<?= $active_page === 'changepass' ? ' active' : '' ?>" href="student_changepass.php?id_student=<?= $current_user_id ?>" title="Change Password">
            <i class="fas fa-key"></i><span class="fb-nav-label">Change Password</span>
        </a>
        <a class="fb-nav-item" href="#" title="Logout" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
            <i class="fas fa-sign-out-alt"></i><span class="fb-nav-label">Logout</span>
        </a>
    </div>
    <div class="fb-nav-spacer"></div>

    <!-- Mobile-only: bell stays visible, hamburger opens a compact dropdown -->
    <div class="fb-mobile-actions">
        <?= render_notif_bell('Mobile', $notif_unread_count, $notif_list) ?>
        <div class="dropdown">
            <button class="fb-menu-toggle" id="menuToggleBtn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end fb-mobile-menu-panel" aria-labelledby="menuToggleBtn">
                <li>
                    <a href="student_homepage.php" class="side-link<?= $active_page === 'dashboard' ? ' active' : '' ?>">
                        <span class="icon-wrap"><i class="fas fa-home"></i></span> Home
                    </a>
                </li>
                <li>
                    <a href="my_submissions.php?id_student=<?= $current_user_id ?>" class="side-link<?= $active_page === 'submissions' ? ' active' : '' ?>">
                        <span class="icon-wrap"><i class="fas fa-file-alt"></i></span> My Submissions
                    </a>
                </li>
                <li>
                    <a href="student_changepass.php?id_student=<?= $current_user_id ?>" class="side-link<?= $active_page === 'changepass' ? ' active' : '' ?>">
                        <span class="icon-wrap"><i class="fas fa-key"></i></span> Change Password
                    </a>
                </li>
                <li>
                    <a href="#" class="side-link" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                        <span class="icon-wrap"><i class="fas fa-sign-out-alt"></i></span> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Logout confirmation modal (shared by desktop icon bar + mobile menu) -->
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
                <a href="logout.php" class="btn btn-danger">Yes, log out</a>
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
    })();
</script>