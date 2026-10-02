<!-- ======================================================================
     MOBILE RESPONSIVE TYPOGRAPHY — Dashboard + Grade Level pages
     This partial is included at the bottom of every admin/staff page, so
     these rules load after each page's own <style> block and win the
     cascade on same-specificity selectors without needing !important
     everywhere. Scales the Dashboard's hero/KPI/panel text and every
     Grade 7–12 (and strand) student-list table down as the viewport
     narrows, since almost all of that typography is set in rem and
     therefore follows the root font-size.
     ====================================================================== -->
<style>
/* Step the root size down so rem-based headings, KPI numbers, table text,
   and Bootstrap spacing utilities all shrink together. */
@media (max-width: 991.98px) {
    html { font-size: 15px; }
}
@media (max-width: 767.98px) {
    html { font-size: 14px; }
    .container-fluid { padding-left: 14px; padding-right: 14px; }
}
@media (max-width: 575.98px) {
    html { font-size: 13px; }
    .container-fluid { padding-left: 12px; padding-right: 12px; }
}
@media (max-width: 400px) {
    html { font-size: 12px; }
}

/* ---------- Dashboard hero ---------- */
@media (max-width: 767.98px) {
    .dash-hero { padding: 24px 22px; }
    .hero-total { font-size: 2.3rem; }
}
@media (max-width: 575.98px) {
    .dash-hero { padding: 20px 18px; border-radius: 14px; }
    .hero-total { font-size: 1.85rem; }
    .hero-label { font-size: .68rem; }
    .hero-sub { font-size: .8rem; }
    .hero-pulse { font-size: .72rem; padding: 5px 12px 5px 9px; }
    .hero-split-legend { font-size: .7rem; flex-direction: column; gap: 4px; }
    /* the Junior/Senior High counters carry an inline font-size, so an
       inline-style override needs !important to win over that */
    .dash-hero [style*="font-size:1.6rem"] { font-size: 1.25rem !important; }
}

/* ---------- KPI cards / section headers / panels ---------- */
@media (max-width: 575.98px) {
    .kpi-card .kpi-icon { width: 38px; height: 38px; font-size: .95rem; }
    .kpi-card .kpi-value { font-size: 1.25rem; }
    .kpi-card .kpi-label { font-size: .64rem; }
    .kpi-card .kpi-share { font-size: .64rem; }
    .section-title { font-size: .9rem; }
    .panel-card .card-header { padding: 12px 16px; font-size: .84rem; }
    .panel-card .card-body { padding: 16px; }
    .strand-row .strand-name { font-size: .7rem; }
    .strand-row .strand-value { font-size: 1rem; }
}

/* ---------- Grade Level / student list page headers ---------- */
@media (max-width: 575.98px) {
    .container-fluid > .d-flex.align-items-center.justify-content-between.mb-3 {
        flex-wrap: wrap;
        gap: 10px;
    }
    .container-fluid > .d-flex.align-items-center.justify-content-between.mb-3 h4 {
        font-size: 1.05rem;
    }
    .container-fluid > .d-flex.align-items-center.justify-content-between.mb-3 small {
        font-size: .78rem;
    }
}

/* ---------- Search / filter bar ----------
   Every Grade Level page centers its search box with a fixed width:30%
   plus margin-left:34%, which leaves almost no usable input on a phone
   screen — let it go full width below tablet size instead. */
@media (max-width: 767.98px) {
    .input-icons {
        width: 100% !important;
        margin-left: 0 !important;
    }
}

/* ---------- Student tables (Grade 7–12 + strand lists) ---------- */
@media (max-width: 767.98px) {
    #studentsTable { font-size: .78rem; }
    #studentsTable thead th { font-size: .64rem; padding: 10px 8px; }
    #studentsTable tbody td { padding: 8px; }
}
@media (max-width: 575.98px) {
    #studentsTable { font-size: .72rem; }
    #studentsTable thead th { font-size: .7rem; padding: .4rem 1.25rem .4rem .5rem; }
    #studentsTable tbody td { padding: 6px; }
    .student-avatar { width: 26px; height: 26px; min-width: 26px; font-size: .62rem; }
    .status-badge { font-size: 10px; padding: 3px 8px; }
    .doc-preview-btn { max-width: 90px; }
}

/* ---------- Dashboard charts (Enrollment by Grade Level / Over Time) ----------
   These two canvases previously had no fixed-height wrapper and no
   maintainAspectRatio:false, so Chart.js sized them purely from
   width ÷ aspectRatio — on a full-width mobile column that collapsed
   them down to a squashed ~160px strip. They're now wrapped in
   .chart-area-md (paired with maintainAspectRatio:false in the chart
   config) so the height below is what actually renders, at any width. */
.chart-area-md { height: 300px; }
@media (max-width: 767.98px) {
    .chart-area-md { height: 270px; }
}
@media (max-width: 575.98px) {
    .chart-area-md { height: 250px; }
}

/* ---------- Hamburger sidebar drawer (phones/tablets) ----------
   The vendor theme's default mobile behavior was an always-visible
   icon-only rail (6.5rem) that only ever collapsed to width:0 — never a
   proper slide-out drawer. Below we take .sidebar out of the flex layout
   and turn it into a fixed overlay panel that's closed (width 0) by
   default and opens to ~78% of the screen (capped at 300px) when the
   hamburger button adds the "toggled" class, with a dimmed backdrop
   behind it. Full icon+label rows are restored while it's open, instead
   of the desktop "toggled = icon rail" look. */
@media (max-width: 767.98px) {
    #accordionSidebar.sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1049;
        width: 0 !important;
        min-width: 0;
        overflow: hidden;
        transition: width 0.28s ease;
    }
    #accordionSidebar.sidebar.toggled {
        width: 78% !important;
        max-width: 300px;
        overflow-y: auto;
        box-shadow: 6px 0 34px rgba(0,0,0,0.35);
    }
    #accordionSidebar.sidebar.toggled .sidebar-brand-text {
        display: inline !important;
    }
    #accordionSidebar.sidebar.toggled .nav-item .nav-link {
        text-align: left !important;
        width: auto !important;
        padding: .8rem 1.25rem !important;
    }
    #accordionSidebar.sidebar.toggled .nav-item .nav-link span:first-child {
        display: inline-flex !important;
        align-items: center;
        gap: .65rem;
        font-size: .88rem !important;
    }

    /* dim + block-scroll the page behind the open drawer; tapping the dim
       area closes it (see the click handler added below) */
    body.sidebar-toggled {
        overflow: hidden;
    }
    body.sidebar-toggled #content-wrapper::before {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(8, 16, 32, .45);
        z-index: 1040;
    }
}
</style>

<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout confirmation modal — same modal, same wording as the student
         portal's confirm, but shown via jQuery's Bootstrap 4 modal() call
         (this template is SB Admin 2 / Bootstrap 4 + jQuery, not Bootstrap 5,
         so data-bs-toggle doesn't apply here — jQuery is what's actually
         driving the sidebar/dropdowns already, so it's the reliable option). -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutConfirmModalLabel">Log out?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to log out?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger" onclick="showAdminLoading('Logging out...', 'sign-out-alt')">Yes, log out</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <!-- jQuery now loads early in <head> (dashboard_sidebar_start.php) so it's
         available to the DataTables/filter-bar scripts that run earlier on
         the page — no need to load it again here. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Row "Actions" dropdown (grade lists, Archive, Account Verification): a plain Bootstrap
         dropdown (data-display="static" keeps Popper out of it). The tables sit in a scroll box
         (.enr-scroll), which clips a normal absolutely-positioned menu, so while a menu is open it
         becomes position:fixed and is placed against its toggle: below by default, above (drop-up)
         when there isn't enough room underneath. The grade-list partials carry the same script and
         set the flag below, so it only ever runs once. -->
    <script>
    (function () {
        if (window.__rowActionsReady) return;
        window.__rowActionsReady = true;

        var GAP = 2, EDGE = 8, openDd = null;

        /* The portal scales pages with CSS zoom (Settings > font size), so getBoundingClientRect() values
           and position:fixed offsets can be in different units. Measure the viewport and a 100px box the
           same way the menu is laid out, and convert with that ratio. */
        function measure() {
            var vp = document.createElement('div'), box = document.createElement('div');
            vp.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;visibility:hidden;pointer-events:none;';
            box.style.cssText = 'width:100px;height:1px;';
            vp.appendChild(box);
            document.body.appendChild(vp);
            var v = vp.getBoundingClientRect(), b = box.getBoundingClientRect();
            document.body.removeChild(vp);
            return { w: v.width, h: v.height, k: (b.width / 100) || 1 };
        }

        function place(dd) {
            var toggle = dd.querySelector('[data-toggle="dropdown"]');
            var menu   = dd.querySelector('.dropdown-menu');
            if (!toggle || !menu) return;

            // Toggle scrolled out of its scroll box: nothing left to attach the menu to.
            var t = toggle.getBoundingClientRect(), scroller = toggle.closest('.enr-scroll');
            if (scroller) {
                var s = scroller.getBoundingClientRect();
                if (t.bottom < s.top || t.top > s.bottom || t.right < s.left || t.left > s.right) {
                    $(toggle).dropdown('hide');
                    return;
                }
            }

            var m = measure();
            menu.classList.add('is-floating');
            menu.style.maxHeight = '';
            menu.style.left = '0px'; menu.style.top = '0px'; menu.style.right = 'auto'; menu.style.bottom = 'auto';

            var mr = menu.getBoundingClientRect(), mw = mr.width, mh = mr.height;
            var below = m.h - t.bottom - GAP - EDGE, above = t.top - GAP - EDGE;
            var up    = mh > below && above > below;      // drop-up only when it doesn't fit below and there is more room above
            var room  = Math.max(80, up ? above : below);
            if (mh > room) {                              // taller than either side: scroll inside the menu
                menu.style.maxHeight = (room / m.k) + 'px';
                mh = menu.getBoundingClientRect().height;
            }

            var left = Math.max(EDGE, Math.min(t.right - mw, m.w - mw - EDGE));   // right edges line up
            var top  = up ? t.top - GAP - mh : t.bottom + GAP;
            menu.style.left = (left / m.k) + 'px';
            menu.style.top  = (top / m.k) + 'px';
            dd.classList.toggle('is-dropup', up);
        }

        $(document).on('shown.bs.dropdown', '.row-actions', function () { openDd = this; place(this); });
        $(document).on('hidden.bs.dropdown', '.row-actions', function () {
            var menu = this.querySelector('.dropdown-menu');
            menu.classList.remove('is-floating');
            ['top', 'left', 'right', 'bottom', 'maxHeight'].forEach(function (p) { menu.style[p] = ''; });
            this.classList.remove('is-dropup');
            if (openDd === this) openDd = null;
        });
        window.addEventListener('resize', function () { if (openDd) place(openDd); });
        window.addEventListener('scroll', function (e) {   // capture: also fires for the table's own scroll box
            if (openDd && !openDd.contains(e.target)) place(openDd);
        }, true);
    })();
    </script>

    <script>
        function showLogoutConfirm(e) {
            if (e) e.preventDefault();
            $('#logoutConfirmModal').modal('show');
            return false;
        }

        // Show the same loading overlay used for logout/form actions
        // (admin_loading_overlay.php) when tapping any sidebar link that
        // navigates to another admin page — e.g. Dashboard -> Grade 7.
        // Skip anything that doesn't actually leave the page (the logout
        // link, which just opens the confirm modal and is handled by its
        // own onclick above; dropdown toggles; "#"/javascript: placeholders)
        // and modified/middle clicks that open a new tab.
        document.querySelectorAll('#accordionSidebar .nav-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                if (e.defaultPrevented || e.ctrlKey || e.metaKey || e.shiftKey || e.button === 1) return;

                var href = link.getAttribute('href');
                if (!href || href === '#' || href.indexOf('javascript:') === 0) return;
                if (link.hasAttribute('data-toggle') || link.hasAttribute('data-bs-toggle')) return;
                if (link.target && link.target !== '' && link.target !== '_self') return;

                if (typeof showAdminLoading === 'function') showAdminLoading('Loading...');
            });
        });
    </script>

    <!-- Theme switcher: Light / Dark / Default (system) -->
    <script>
    (function () {
        var STORAGE_KEY = 'eusebia_admin_theme';

        function applyEffectiveTheme(pref) {
            var effective = pref;
            if (pref === 'default') {
                effective = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', effective);
            document.documentElement.setAttribute('data-theme-pref', pref);

            var icon = document.getElementById('themeSwitchIcon');
            if (icon) {
                icon.className = 'fa-fw ' + (
                    pref === 'light' ? 'fas fa-sun' :
                    pref === 'dark'  ? 'fas fa-moon' :
                                       'fas fa-circle-half-stroke'
                );
            }

            document.querySelectorAll('[data-theme-choice]').forEach(function (el) {
                el.classList.toggle('active-theme', el.getAttribute('data-theme-choice') === pref);
            });
        }

        function setTheme(pref) {
            localStorage.setItem(STORAGE_KEY, pref);
            applyEffectiveTheme(pref);
        }

        document.addEventListener('DOMContentLoaded', function () {
            var stored = localStorage.getItem(STORAGE_KEY) || 'default';
            applyEffectiveTheme(stored);

            document.querySelectorAll('[data-theme-choice]').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    setTheme(el.getAttribute('data-theme-choice'));
                });
            });

            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
                    if ((localStorage.getItem(STORAGE_KEY) || 'default') === 'default') {
                        applyEffectiveTheme('default');
                    }
                });
            }
        });
    })();
    </script>

    <!-- Font size switcher: Small / Medium / Large -->
    <script>
    (function () {
        var STORAGE_KEY = 'eusebia_admin_fontsize';

        function applyFontSize(size) {
            document.documentElement.setAttribute('data-fontsize', size);
            document.querySelectorAll('[data-fontsize-choice]').forEach(function (el) {
                el.classList.toggle('active-fontsize', el.getAttribute('data-fontsize-choice') === size);
            });
        }

        function setFontSize(size) {
            localStorage.setItem(STORAGE_KEY, size);
            applyFontSize(size);
        }

        document.addEventListener('DOMContentLoaded', function () {
            var stored = localStorage.getItem(STORAGE_KEY) || 'medium';
            applyFontSize(stored);

            document.querySelectorAll('[data-fontsize-choice]').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    setFontSize(el.getAttribute('data-fontsize-choice'));
                });
            });
        });
    })();
    </script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Mobile drawer: close it by tapping the dimmed backdrop, since the
         vendor script only ever wires up the hamburger button itself. -->
    <script>
    $(document).on('click touchstart', function (e) {
        if ($(window).width() >= 768) return;
        if (!$('body').hasClass('sidebar-toggled')) return;
        var $target = $(e.target);
        if ($target.closest('#accordionSidebar').length) return;
        if ($target.closest('#sidebarToggle, #sidebarToggleTop').length) return;
        $('body').removeClass('sidebar-toggled');
        $('.sidebar').removeClass('toggled');
    });
    </script>

    <!-- PWA -->
    <script src="js/pwa.js"></script>


</body>

</html>