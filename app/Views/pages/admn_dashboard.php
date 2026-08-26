

<style>
:root {
    --edb-navy:      #0b2b5c;
    --edb-navy-2:    #0f3b7a;
    --edb-navy-3:    #1e5a88;
    --edb-navy-4:    #2a6f9c;
    --edb-accent:    #6366f1;
    --edb-accent-2:  #818cf8;
    --edb-ink:       #0f172a;
    --edb-muted:     #64748b;
    --edb-border:    #e7ebf2;
    --edb-canvas:    #f5f7fb;
    --edb-success:   #059669;
}

.edb-numeral { font-variant-numeric: tabular-nums; letter-spacing: -0.01em; }

/* ---------- Hero ---------- */
.dash-hero {
    background: linear-gradient(135deg, var(--edb-navy) 0%, var(--edb-navy-3) 60%, var(--edb-navy-4) 100%);
    border-radius: 18px;
    padding: 30px 34px;
    color: #fff;
    box-shadow: 0 12px 30px rgba(11,43,92,0.22);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.dash-hero::before {
    content: '';
    position: absolute;
    top: -60%; right: -8%;
    width: 320px; height: 320px;
    background: radial-gradient(circle, rgba(129,140,248,0.25) 0%, rgba(129,140,248,0) 70%);
    pointer-events: none;
}
.hero-label { font-size: .72rem; letter-spacing: .08em; text-transform: uppercase; opacity: .72; font-weight: 700; }
.hero-total { font-size: 2.6rem; font-weight: 800; line-height: 1; }
.hero-sub { font-size: .86rem; opacity: .78; margin-top: 2px; }

.hero-pulse {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 20px;
    padding: 6px 14px 6px 10px;
    font-size: .78rem;
    font-weight: 600;
    margin-top: 14px;
}
.hero-pulse .pulse-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--edb-accent-2);
    box-shadow: 0 0 0 0 rgba(129,140,248,0.6);
    animation: pulse-ring 2.2s ease-out infinite;
}
@keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(129,140,248,0.55); }
    70%  { box-shadow: 0 0 0 8px rgba(129,140,248,0); }
    100% { box-shadow: 0 0 0 0 rgba(129,140,248,0); }
}
@media (prefers-reduced-motion: reduce) {
    .hero-pulse .pulse-dot { animation: none; }
}

.hero-split { margin-top: 22px; }
.hero-split-track {
    display: flex; width: 100%; height: 7px; border-radius: 8px;
    overflow: hidden; background: rgba(255,255,255,0.14);
}
.hero-split-track span:first-child { background: #fff; }
.hero-split-track span:last-child { background: var(--edb-accent-2); }
.hero-split-legend {
    display: flex; justify-content: space-between; margin-top: 8px;
    font-size: .76rem; opacity: .85;
}
.hero-split-legend .legend-dot {
    width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 6px;
}

/* ---------- KPI cards ---------- */
.kpi-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(11,43,92,0.08);
    transition: transform .18s ease, box-shadow .18s ease;
    overflow: hidden;
    position: relative;
}
.kpi-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(11,43,92,0.16); cursor: default; }
.kpi-card .kpi-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #fff; flex-shrink: 0;
}
.kpi-card .kpi-value { font-size: 1.55rem; font-weight: 800; color: var(--edb-ink); }
.kpi-card .kpi-label { font-size: .72rem; letter-spacing: .05em; text-transform: uppercase; color: var(--edb-muted); font-weight: 700; }
.kpi-card .kpi-share { font-size: .72rem; color: var(--edb-accent); font-weight: 700; margin-top: 1px; }

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
    color: var(--edb-accent);
    font-weight: 800;
    border-left: 3px solid var(--edb-accent);
    padding-left: 8px;
}

/* ---------- Panels ---------- */
.panel-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(11,43,92,0.07);
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
    background: var(--edb-canvas); padding: 1px 6px; border-radius: 5px; color: var(--edb-navy-3);
}

/* ---------- Strand list ---------- */
.strand-row {
    border-radius: 12px;
    border: 1px solid var(--edb-border);
    background: #fff;
    padding: 14px 16px;
    transition: transform .15s ease, box-shadow .15s ease;
}
.strand-row:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(11,43,92,0.08); }
.strand-row .strand-top {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;
}
.strand-row .strand-name {
    font-size: .78rem; font-weight: 800; letter-spacing: .03em; text-transform: uppercase;
}
.strand-row .strand-value { font-size: 1.15rem; font-weight: 800; color: var(--edb-ink); }
.strand-row .strand-bar-track {
    height: 6px; border-radius: 6px; background: var(--edb-canvas); overflow: hidden;
}
.strand-row .strand-bar-fill { height: 100%; border-radius: 6px; }

@media (max-width: 575.98px) {
    .dash-hero { padding: 22px 20px; }
    .hero-total { font-size: 2.1rem; }
    .dash-hero .d-flex[style*="gap:40px"] { gap: 24px !important; margin-top: 16px; }
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
                <span><span class="legend-dot" style="background:#fff;"></span>Junior High — <?= $jhs_pct ?>%</span>
                <span><span class="legend-dot" style="background:var(--edb-accent-2);"></span>Senior High — <?= $shs_pct ?>%</span>
            </div>
        </div>
    </div>

    <!-- KPI CARDS -->
    <div class="row mb-4">
        <?php
        $kpis = [
            ['label' => 'Grade 7-10',  'value' => $total_jhs, 'icon' => 'fa-users',         'grad' => 'linear-gradient(135deg,#0b2b5c,#1e5a88)'],
            ['label' => 'Grade 11-12', 'value' => $total_shs, 'icon' => 'fa-user-graduate', 'grad' => 'linear-gradient(135deg,#1e5a88,#2a6f9c)'],
            ['label' => 'STEM + ABM',  'value' => $stem_count + $abm_count, 'icon' => 'fa-flask',   'grad' => 'linear-gradient(135deg,#2a6f9c,#4a8db5)'],
            ['label' => 'GAS + TVL',   'value' => $gas_count + $ict_count + $he_count, 'icon' => 'fa-layer-group', 'grad' => 'linear-gradient(135deg,#4a8db5,#7fb0d0)'],
        ];
        foreach ($kpis as $k):
            $share = $grand_total > 0 ? round(($k['value'] / $grand_total) * 100) : 0;
        ?>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card kpi-card h-100">
                <div class="card-body d-flex align-items-center" style="gap:14px;">
                    <div class="kpi-icon" style="background:<?= $k['grad'] ?>;"><i class="fas <?= $k['icon'] ?>"></i></div>
                    <div>
                        <div class="kpi-value edb-numeral"><?= number_format($k['value']) ?></div>
                        <div class="kpi-label"><?= $k['label'] ?></div>
                        <div class="kpi-share"><?= $share ?>% of total</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
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
                <div class="card-body"><canvas id="gradeChart" style="height:280px;"></canvas></div>
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
                        <canvas id="trendChart" style="height:280px;"></canvas>
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
                        ['label' => 'STEM',    'count' => $stem_count, 'hex' => '#0b2b5c'],
                        ['label' => 'ABM',     'count' => $abm_count,  'hex' => '#0f3b7a'],
                        ['label' => 'GAS',     'count' => $gas_count,  'hex' => '#1e5a88'],
                        ['label' => 'TVL-ICT', 'count' => $ict_count,  'hex' => '#2a6f9c'],
                        ['label' => 'TVL-HE',  'count' => $he_count,   'hex' => '#4a8db5'],
                    ];
                    foreach ($course_cards as $i => $card):
                        $pct = round(($card['count'] / $shs_strand_total) * 100);
                    ?>
                    <div class="strand-row <?= $i < count($course_cards) - 1 ? 'mb-2' : '' ?>">
                        <div class="strand-top">
                            <span class="strand-name" style="color:<?= $card['hex'] ?>;"><?= $card['label'] ?></span>
                            <span class="strand-value edb-numeral"><?= number_format($card['count']) ?></span>
                        </div>
                        <div class="strand-bar-track">
                            <div class="strand-bar-fill" style="width:<?= $pct ?>%; background:<?= $card['hex'] ?>;"></div>
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

// --- COMBINED GRADE 7-12 CHART (replaces the separate JHS/SHS charts) ---
const ctxGrade = document.getElementById('gradeChart').getContext('2d');
new Chart(ctxGrade, {
    type: 'bar',
    data: {
        labels: ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
        datasets: [{
            label: 'Students',
            data: [<?= $g7 ?>, <?= $g8 ?>, <?= $g9 ?>, <?= $g10 ?>, <?= $g11 ?>, <?= $g12 ?>],
            backgroundColor: ['#0b2b5c', '#0f3b7a', '#1e5a88', '#2a6f9c', '#4a8db5', '#7fb0d0'],
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(11,43,92,0.06)' } },
            x: { grid: { display: false } }
        }
    }
});

<?php if ($trend_available): ?>
// --- ENROLLMENT OVER TIME ---
const trendLabels = <?= json_encode(array_map(fn($d) => date('M j', strtotime($d)), array_keys($trend))) ?>;
const trendData   = <?= json_encode(array_values($trend)) ?>;

const ctxTrend = document.getElementById('trendChart').getContext('2d');
const trendGradient = ctxTrend.createLinearGradient(0, 0, 0, 280);
trendGradient.addColorStop(0, 'rgba(11,43,92,0.28)');
trendGradient.addColorStop(1, 'rgba(11,43,92,0.02)');

new Chart(ctxTrend, {
    type: 'line',
    data: {
        labels: trendLabels,
        datasets: [{
            label: 'New Enrollees',
            data: trendData,
            borderColor: '#0b2b5c',
            backgroundColor: trendGradient,
            fill: true,
            tension: 0.35,
            pointRadius: 0,
            pointHoverRadius: 5,
            borderWidth: 2.5,
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(11,43,92,0.06)' } },
            x: { grid: { display: false }, ticks: { maxTicksLimit: 8 } }
        }
    }
});
<?php endif; ?>

// --- STRAND DISTRIBUTION ---
const ctxStrand = document.getElementById('strandChart').getContext('2d');
new Chart(ctxStrand, {
    type: 'bar',
    data: {
        labels: ['STEM', 'ABM', 'GAS', 'TVL-ICT', 'TVL-HE'],
        datasets: [{
            label: 'Total Students',
            data: [<?= (int)$stem_count ?>, <?= (int)$abm_count ?>, <?= (int)$gas_count ?>, <?= (int)$ict_count ?>, <?= (int)$he_count ?>],
            backgroundColor: ['#0b2b5c', '#0f3b7a', '#1e5a88', '#2a6f9c', '#4a8db5'],
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: 'rgba(11,43,92,0.06)' } },
            y: { grid: { display: false } }
        },
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>
