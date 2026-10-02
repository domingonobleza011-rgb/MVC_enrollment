<style>
:root {
    --edb-surface:   #ffffff;
    --edb-ink:       #0f172a;
    --edb-muted:     #64748b;
    --edb-border:    #e7ebf2;
    --edb-canvas:    #f5f7fb;
    --edb-success:   #059669;

    /* Plain, neutral chart colors. Charts and the strand list both read these,
       so changing them here re-colors every graph on the page. */
    --edb-shadow:     rgba(0, 0, 0, 0.06);
    --edb-chart-rgb:  55, 65, 81;              /* gray-700 */
    --edb-chart-grid: rgba(0, 0, 0, 0.06);
    --edb-chart-tick: #6b7280;                 /* gray-500 */
}

.edb-numeral { font-variant-numeric: tabular-nums; letter-spacing: -0.01em; }

/* ---------- Hero ---------- */
.dash-hero {
    background: var(--edb-surface);
    border: 1px solid var(--edb-border);
    border-radius: 16px;
    padding: 28px 32px;
    color: var(--edb-ink);
    box-shadow: 0 2px 10px var(--edb-shadow);
    margin-bottom: 24px;
}
.hero-label { font-size: .72rem; letter-spacing: .08em; text-transform: uppercase; color: var(--edb-muted); font-weight: 700; }
.hero-total { font-size: 2.6rem; font-weight: 800; line-height: 1; }
.hero-sub { font-size: .86rem; color: var(--edb-muted); margin-top: 2px; }

.hero-pulse {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(var(--edb-chart-rgb), 0.06);
    border: 1px solid var(--edb-border);
    border-radius: 20px;
    padding: 6px 14px 6px 10px;
    font-size: .78rem;
    font-weight: 600;
    margin-top: 14px;
}
.hero-pulse .pulse-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgb(var(--edb-chart-rgb));
    box-shadow: 0 0 0 0 rgba(var(--edb-chart-rgb), 0.5);
    animation: pulse-ring 2.2s ease-out infinite;
}
@keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(var(--edb-chart-rgb), 0.45); }
    70%  { box-shadow: 0 0 0 8px rgba(var(--edb-chart-rgb), 0); }
    100% { box-shadow: 0 0 0 0 rgba(var(--edb-chart-rgb), 0); }
}
@media (prefers-reduced-motion: reduce) {
    .hero-pulse .pulse-dot { animation: none; }
}

.hero-split { margin-top: 22px; }
.hero-split-track {
    display: flex; width: 100%; height: 7px; border-radius: 8px;
    overflow: hidden; background: rgba(var(--edb-chart-rgb), 0.12);
}
.hero-split-track span:first-child { background: rgb(var(--edb-chart-rgb)); }
.hero-split-track span:last-child { background: rgba(var(--edb-chart-rgb), 0.4); }
.hero-split-legend {
    display: flex; justify-content: space-between; margin-top: 8px;
    font-size: .76rem; color: var(--edb-muted);
}
.hero-split-legend .legend-dot {
    width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 6px;
}
.hero-split-legend .legend-dot.jhs { background: rgb(var(--edb-chart-rgb)); }
.hero-split-legend .legend-dot.shs { background: rgba(var(--edb-chart-rgb), 0.4); }

/* ---------- KPI cards ---------- */
.kpi-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 2px 10px var(--edb-shadow);
    transition: transform .18s ease, box-shadow .18s ease;
    overflow: hidden;
    position: relative;
}
.kpi-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px var(--edb-shadow); cursor: default; }
.kpi-card .kpi-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
    background: rgba(var(--edb-chart-rgb), 0.10); color: rgb(var(--edb-chart-rgb));
}
.kpi-card .kpi-value { font-size: 1.55rem; font-weight: 800; color: var(--edb-ink); }
.kpi-card .kpi-label { font-size: .72rem; letter-spacing: .05em; text-transform: uppercase; color: var(--edb-muted); font-weight: 700; }
.kpi-card .kpi-share { font-size: .72rem; color: var(--edb-muted); font-weight: 700; margin-top: 1px; }

/* ---------- Section headers ---------- */
.section-title {
    font-weight: 800;
    color: var(--edb-ink);
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin: 4px 0 18px;
    font-size: 1.02rem;
}
.section-title .eyebrow {
    font-size: .68rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--edb-muted);
    font-weight: 800;
    border-left: 3px solid rgb(var(--edb-chart-rgb));
    padding-left: 8px;
}

/* ---------- Panels ---------- */
.panel-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 10px var(--edb-shadow);
}
.panel-card .card-header {
    background: #fff;
    border-bottom: 1px solid var(--edb-border);
    border-radius: 16px 16px 0 0 !important;
    font-weight: 700;
    color: var(--edb-ink);
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .92rem;
}
.panel-card .card-header .card-header-hint {
    font-size: .72rem; font-weight: 600; color: var(--edb-muted);
}
.panel-card .card-body { padding: 22px; }

.trend-empty {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    height: 280px; text-align: center; color: var(--edb-muted); gap: 8px;
}
.trend-empty i { font-size: 1.6rem; color: var(--edb-border); }
.trend-empty code {
    background: var(--edb-canvas); padding: 1px 6px; border-radius: 5px; color: var(--edb-ink);
}

/* ---------- Strand list ---------- */
.strand-row {
    border-radius: 12px;
    border: 1px solid var(--edb-border);
    background: #fff;
    padding: 14px 16px;
    transition: transform .15s ease, box-shadow .15s ease;
}
.strand-row:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.08); }
.strand-row .strand-top {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;
}
.strand-row .strand-name {
    font-size: .78rem; font-weight: 800; letter-spacing: .03em; text-transform: uppercase;
    color: var(--edb-ink);
}
.strand-row .strand-value { font-size: 1.15rem; font-weight: 800; color: var(--edb-ink); }
.strand-row .strand-bar-track {
    height: 6px; border-radius: 6px; background: rgba(var(--edb-chart-rgb), 0.12); overflow: hidden;
}
.strand-row .strand-bar-fill { height: 100%; border-radius: 6px; background: rgb(var(--edb-chart-rgb)); }

@media (max-width: 575.98px) {
    .dash-hero { padding: 22px 20px; }
    .hero-total { font-size: 2.1rem; }
    .dash-hero .d-flex[style*="gap:40px"] { gap: 24px !important; margin-top: 16px; }
}

/* ===== Dark mode ===== */
/* All KPI/panel/strand rules above read color from these custom properties,
   so redefining them here is enough to re-theme the whole page — no need
   to duplicate every selector. */
html[data-theme="dark"] {
    --edb-ink:     #e6e9f0;
    --edb-muted:   #9aa3b5;
    --edb-border:  rgba(255,255,255,0.08);
    --edb-canvas:  #1e2432;

    --edb-surface:    #1a1f2b;
    --edb-shadow:     rgba(0, 0, 0, 0.35);
    --edb-chart-rgb:  209, 213, 219;           /* gray-300 */
    --edb-chart-grid: rgba(255, 255, 255, 0.08);
    --edb-chart-tick: #9ca3af;                 /* gray-400 */
}
html[data-theme="dark"] .strand-row {
    background: #1a1f2b;
}
</style>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<div class="container-fluid">

    <!-- HERO -->
    <div class="dash-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-start">
            <div>
                <div class="hero-label">Enrollment Overview</div>
                <div class="hero-total edb-numeral"><?= number_format($grand_total) ?> Enrollees</div>
                <div class="hero-sub">Across Grade 7 to Grade 12</div>
                <div class="hero-pulse">
                    <span class="pulse-dot"></span>
                    Last new enrollee: <?= htmlspecialchars($last_active_label) ?>
                </div>
            </div>
            <div class="d-flex" style="gap:40px;">
                <div>
                    <div class="hero-label">Junior High</div>
                    <div class="edb-numeral" style="font-size:1.6rem;font-weight:700;"><?= number_format($total_jhs) ?></div>
                </div>
                <div>
                    <div class="hero-label">Senior High</div>
                    <div class="edb-numeral" style="font-size:1.6rem;font-weight:700;"><?= number_format($total_shs) ?></div>
                </div>
            </div>
        </div>

        <div class="hero-split">
            <div class="hero-split-track">
                <span style="width:<?= $jhs_pct ?>%;"></span>
                <span style="width:<?= $shs_pct ?>%;"></span>
            </div>
            <div class="hero-split-legend">
                <span><span class="legend-dot jhs"></span>Junior High — <?= $jhs_pct ?>%</span>
                <span><span class="legend-dot shs"></span>Senior High — <?= $shs_pct ?>%</span>
            </div>
        </div>
    </div>

   

    <!-- ENROLLMENT BY GRADE + TREND -->
    <div class="section-title"><span class="eyebrow">Monitoring</span>Enrollment</div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card panel-card mb-4">
                <div class="card-header">
                    Enrollment by Grade Level
                    <span class="card-header-hint">Grade 7–12</span>
                </div>
                <div class="card-body">
                    <div class="chart-area chart-area-md"><canvas id="gradeChart"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card panel-card mb-4">
                <div class="card-header">
                    Enrollment Over Time
                    <span class="card-header-hint">Last 30 days</span>
                </div>
                <div class="card-body">
                    <?php if ($trend_available): ?>
                        <div class="chart-area chart-area-md"><canvas id="trendChart"></canvas></div>
                    <?php else: ?>
                        <div class="trend-empty">
                            <i class="fas fa-chart-line"></i>
                            <div>
                                This chart needs a <code>date_enrolled</code> column on the grade tables.<br>
                                Run <code>migration_add_date_enrolled.sql</code>, then reload this page.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- SHS STRANDS -->
    <div class="section-title"><span class="eyebrow">Course Monitoring</span>Senior High Strands</div>
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card panel-card mb-4">
                <div class="card-header">Enrollment Distribution by Strand</div>
                <div class="card-body">
                    <div class="chart-area" style="height: 380px;">
                        <canvas id="strandChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card panel-card mb-4 h-100">
                <div class="card-header">Strand Breakdown</div>
                <div class="card-body" style="padding-top:16px;">
                    <?php
                    $shs_strand_total = max($stem_count + $abm_count + $gas_count + $ict_count + $he_count, 1);
                    $course_cards = [
                        ['label' => 'STEM',    'count' => $stem_count],
                        ['label' => 'ABM',     'count' => $abm_count],
                        ['label' => 'GAS',     'count' => $gas_count],
                        ['label' => 'TVL-ICT', 'count' => $ict_count],
                        ['label' => 'TVL-HE',  'count' => $he_count],
                    ];
                    foreach ($course_cards as $i => $card):
                        $pct = round(($card['count'] / $shs_strand_total) * 100);
                    ?>
                    <div class="strand-row <?= $i < count($course_cards) - 1 ? 'mb-2' : '' ?>">
                        <div class="strand-top">
                            <span class="strand-name"><?= $card['label'] ?></span>
                            <span class="strand-value edb-numeral"><?= number_format($card['count']) ?></span>
                        </div>
                        <div class="strand-bar-track">
                            <div class="strand-bar-fill" style="width:<?= $pct ?>%;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
Chart.defaults.font.family = "'Nunito', -apple-system, sans-serif";

// --- Theme-aware chart colors. Canvases are drawn by JS so they can't use CSS
// directly; read the same --edb-chart-* custom properties the stylesheet uses.
// Those flip under html[data-theme="dark"], so charts and CSS always agree. ---
function cssVar(name) {
    return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
}
function chartColor(alpha) {
    var rgb = cssVar('--edb-chart-rgb');
    return alpha == null ? 'rgb(' + rgb + ')' : 'rgba(' + rgb + ',' + alpha + ')';
}
function chartGridColor() { return cssVar('--edb-chart-grid'); }
function chartTickColor() { return cssVar('--edb-chart-tick'); }
Chart.defaults.color = chartTickColor();

const dashboardCharts = [];

// --- COMBINED GRADE 7-12 CHART (replaces the separate JHS/SHS charts) ---
const ctxGrade = document.getElementById('gradeChart').getContext('2d');
const gradeChart = new Chart(ctxGrade, {
    type: 'bar',
    data: {
        labels: ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
        datasets: [{
            label: 'Students',
            data: [<?= $g7 ?>, <?= $g8 ?>, <?= $g9 ?>, <?= $g10 ?>, <?= $g11 ?>, <?= $g12 ?>],
            backgroundColor: chartColor(),
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0, color: chartTickColor() }, grid: { color: chartGridColor() } },
            x: { ticks: { color: chartTickColor() }, grid: { display: false } }
        }
    }
});
dashboardCharts.push(gradeChart);

<?php if ($trend_available): ?>
// --- ENROLLMENT OVER TIME ---
const trendLabels = <?= json_encode(array_map(fn($d) => date('M j', strtotime($d)), array_keys($trend))) ?>;
const trendData   = <?= json_encode(array_values($trend)) ?>;

const ctxTrend = document.getElementById('trendChart').getContext('2d');

function trendFillGradient() {
    var g = ctxTrend.createLinearGradient(0, 0, 0, 300);
    g.addColorStop(0, chartColor(0.25));
    g.addColorStop(1, chartColor(0.02));
    return g;
}

const trendChart = new Chart(ctxTrend, {
    type: 'line',
    data: {
        labels: trendLabels,
        datasets: [{
            label: 'New Enrollees',
            data: trendData,
            borderColor: chartColor(),
            backgroundColor: trendFillGradient(),
            fill: true,
            tension: 0.35,
            pointRadius: 0,
            pointHoverRadius: 5,
            borderWidth: 2.5,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0, color: chartTickColor() }, grid: { color: chartGridColor() } },
            x: { ticks: { maxTicksLimit: 8, color: chartTickColor() }, grid: { display: false } }
        }
    }
});
dashboardCharts.push(trendChart);
<?php endif; ?>

// --- STRAND DISTRIBUTION ---
const ctxStrand = document.getElementById('strandChart').getContext('2d');
const strandChart = new Chart(ctxStrand, {
    type: 'bar',
    data: {
        labels: ['STEM', 'ABM', 'GAS', 'TVL-ICT', 'TVL-HE'],
        datasets: [{
            label: 'Total Students',
            data: [<?= (int)$stem_count ?>, <?= (int)$abm_count ?>, <?= (int)$gas_count ?>, <?= (int)$ict_count ?>, <?= (int)$he_count ?>],
            backgroundColor: chartColor(),
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, ticks: { stepSize: 1, precision: 0, color: chartTickColor() }, grid: { color: chartGridColor() } },
            y: { ticks: { color: chartTickColor() }, grid: { display: false } }
        },
        responsive: true,
        maintainAspectRatio: false
    }
});
dashboardCharts.push(strandChart);

// --- Keep charts in sync with live theme switches (no page reload happens
// when the user picks Light/Dark from the notification-bell area's theme
// menu, so re-color the canvases whenever data-theme actually changes). ---
new MutationObserver(function (mutations) {
    var changed = mutations.some(function (m) { return m.attributeName === 'data-theme'; });
    if (!changed) return;

    Chart.defaults.color = chartTickColor();

    dashboardCharts.forEach(function (chart) {
        var scales = chart.options.scales || {};
        if (scales.x) {
            if (scales.x.ticks) scales.x.ticks.color = chartTickColor();
            if (scales.x.grid && scales.x.grid.display !== false) scales.x.grid.color = chartGridColor();
        }
        if (scales.y) {
            if (scales.y.ticks) scales.y.ticks.color = chartTickColor();
            if (scales.y.grid && scales.y.grid.display !== false) scales.y.grid.color = chartGridColor();
        }
    });

    gradeChart.data.datasets[0].backgroundColor  = chartColor();
    strandChart.data.datasets[0].backgroundColor = chartColor();

    if (typeof trendChart !== 'undefined') {
        trendChart.data.datasets[0].borderColor = chartColor();
        trendChart.data.datasets[0].backgroundColor = trendFillGradient();
    }

    dashboardCharts.forEach(function (chart) { chart.update(); });
}).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
</script>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>