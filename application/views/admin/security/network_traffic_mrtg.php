<!-- Network Traffic MRTG - Zabbix Style Dashboard -->
<style>
    /* ===== ZABBIX-STYLE MRTG DASHBOARD ===== */
    .mrtg-wrapper {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #333;
        background: #f5f5f5;
        padding: 0;
    }

    /* Header bar */
    .mrtg-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        border: 1px solid #d0d0d0;
        border-radius: 3px;
        padding: 8px 14px;
        margin-bottom: 12px;
    }
    .mrtg-topbar-title {
        font-size: 14px;
        font-weight: bold;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .mrtg-topbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 11px;
        color: #666;
    }
    .mrtg-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 11px;
        font-weight: bold;
        padding: 3px 10px;
        border-radius: 12px;
        border: 1px solid #a5d6a7;
    }
    .mrtg-live-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #2e7d32;
        animation: blink-dot 1.4s infinite;
    }
    @keyframes blink-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.2; }
    }

    /* Grid */
    .mrtg-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    @media (max-width: 900px) {
        .mrtg-grid { grid-template-columns: 1fr; }
    }

    /* Card */
    .mrtg-card {
        background: #fff;
        border: 1px solid #c8c8c8;
        border-radius: 2px;
        overflow: hidden;
    }
    .mrtg-card-header {
        background: #f0f0f0;
        border-bottom: 1px solid #d0d0d0;
        padding: 5px 10px;
    }
    .mrtg-card-title {
        font-size: 13px;
        font-weight: bold;
        color: #1a1a1a;
        margin: 0 0 1px 0;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .mrtg-card-port {
        font-size: 10.5px;
        color: #555;
        margin: 0;
    }

    /* Chart */
    .mrtg-chart-wrap {
        position: relative;
        width: 100%;
        height: 180px;
        background: #fff;
    }
    .mrtg-chart-wrap canvas {
        display: block;
    }

    /* Legend / Stats */
    .mrtg-legend {
        padding: 5px 10px 7px 10px;
        border-top: 1px solid #e8e8e8;
        background: #fafafa;
    }
    .mrtg-legend-row {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 2px;
        font-size: 11px;
        line-height: 1.4;
    }
    .mrtg-legend-swatch {
        width: 16px;
        height: 3px;
        flex-shrink: 0;
        margin-right: 5px;
        border-radius: 1px;
    }
    .mrtg-legend-name {
        flex: 1;
        color: #444;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        min-width: 0;
        font-size: 10.5px;
    }
    .mrtg-legend-stats {
        display: flex;
        gap: 0;
        flex-shrink: 0;
        font-size: 10.5px;
        color: #333;
    }
    .mrtg-stat-item {
        display: flex;
        align-items: center;
        gap: 2px;
        margin-left: 8px;
        white-space: nowrap;
    }
    .mrtg-stat-label {
        color: #888;
        font-size: 10px;
    }
    .mrtg-stat-val {
        font-weight: bold;
        color: #222;
    }

    /* Loading overlay */
    .mrtg-loading {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.85);
        font-size: 11px;
        color: #888;
        z-index: 10;
    }
    .mrtg-loading.hidden { display: none; }

    /* Footer */
    .mrtg-footer {
        text-align: center;
        padding: 8px;
        font-size: 10.5px;
        color: #999;
        margin-top: 8px;
    }
</style>

<div class="mrtg-wrapper">

    <!-- Top bar -->
    <div class="mrtg-topbar">
        <div class="mrtg-topbar-title">
            <i class="fas fa-chart-area" style="color:#1565c0;"></i>
            Network Traffic Monitoring — MRTG
        </div>
        <div class="mrtg-topbar-right">
            <span class="mrtg-live-badge"><span class="mrtg-live-dot"></span> LIVE</span>
            <span>Updated: <strong id="mrtg-last-update">—</strong></span>
            <span style="color:#aaa;">Auto-refresh 5 min</span>
        </div>
    </div>

    <!-- 2-column grid -->
    <div class="mrtg-grid" id="mrtg-grid">
        <!-- Cards injected by JS -->
    </div>

    <div class="mrtg-footer">
        Data source: Zabbix API &nbsp;|&nbsp; Trend data today (00:00 – now) &nbsp;|&nbsp; 1 point = 1-hour average
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
(function() {

    // =====================================================
    // HOST CONFIG — matches Zabbix_model.php $hosts array
    // =====================================================
    const HOSTS = [
        { label: 'ASTINET',                      port: 'ether1-Astinet-Telkom-200Mbps (PORT 1)',  inId: '66918',  outId: '66942'  },
        { label: 'ASTINET TUNNEL',               port: 'ether2 (LINK 2)',                          inId: '374437', outId: '374458' },
        { label: 'FIBERNET GEDUNG MBC PUSBANGKOM', port: 'ether3-SumberTricom (PORT 3)',           inId: '373160', outId: '373193' },
        { label: 'FIBERNET PUSBANGKOM',          port: 'ether2-Data-Internet (PORT 2)',            inId: '406908', outId: '406956' },
        { label: 'FIBERNET',                     port: 'sfp-sfpplus1-fibernet (fibernet)',         inId: '423546', outId: '423603' },
        { label: 'FIBERNET BINA PROFESI',        port: 'ether2-Kepsta-Pro3 (PORT 2)',              inId: '374148', outId: '374166' },
        { label: 'FIBERNET DC DPOK',             port: 'ether6-DC-Depok (PORT 6)',                 inId: '423534', outId: '423591' },
        { label: 'FIBERNET SPI',                 port: 'ether1-Sumber-Fibernet (PORT 1)',          inId: '413801', outId: '413819' },
        { label: 'INTERNET DC JKT',              port: 'ether1-MK-Core-Operasional (PORT 1)',      inId: '41470',  outId: '41536'  },
        { label: 'FIBERNET PEMANCAR KEBAYORAN',  port: 'ether1 (LINK 1)',                          inId: '374436', outId: '374457' },
        { label: 'INTERNET RRI KANTOR PUSAT',    port: 'sfp-sfpplus2-Fortigate-KTRPusat',         inId: '423545', outId: '423602' },
        { label: 'FIBERNET DC PDN',              port: 'ether2-DC-PDN-Serpong',                    inId: '423530', outId: '423587' }
    ];

    const COLOR_OUT = '#cc3300';   // Red — Bits sent (OUT)
    const COLOR_IN  = '#2d8e2d';   // Green — Bits received (IN)

    const charts = [];
    const grid   = document.getElementById('mrtg-grid');

    // =====================================================
    // Build DOM cards
    // =====================================================
    HOSTS.forEach(function(host, idx) {
        const card = document.createElement('div');
        card.className = 'mrtg-card';
        card.id = 'mrtg-card-' + idx;
        card.innerHTML = `
            <div class="mrtg-card-header">
                <div class="mrtg-card-title">${host.label}</div>
                <div class="mrtg-card-port" id="port-${idx}">${host.port}</div>
            </div>
            <div class="mrtg-chart-wrap">
                <div class="mrtg-loading" id="loading-${idx}">Loading…</div>
                <canvas id="chart-${idx}" height="180"></canvas>
            </div>
            <div class="mrtg-legend">
                <!-- OUT row (red) -->
                <div class="mrtg-legend-row">
                    <div class="mrtg-legend-swatch" style="background:${COLOR_OUT};"></div>
                    <span class="mrtg-legend-name" id="out-name-${idx}">Bits sent</span>
                    <div class="mrtg-legend-stats">
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">[avg]</span>&nbsp;<span class="mrtg-stat-val" id="out-last-${idx}">—</span></span>
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">min</span>&nbsp;<span class="mrtg-stat-val" id="out-min-${idx}">—</span></span>
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">avg</span>&nbsp;<span class="mrtg-stat-val" id="out-avg-${idx}">—</span></span>
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">max</span>&nbsp;<span class="mrtg-stat-val" id="out-max-${idx}">—</span></span>
                    </div>
                </div>
                <!-- IN row (green) -->
                <div class="mrtg-legend-row">
                    <div class="mrtg-legend-swatch" style="background:${COLOR_IN};"></div>
                    <span class="mrtg-legend-name" id="in-name-${idx}">Bits received</span>
                    <div class="mrtg-legend-stats">
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">[avg]</span>&nbsp;<span class="mrtg-stat-val" id="in-last-${idx}">—</span></span>
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">min</span>&nbsp;<span class="mrtg-stat-val" id="in-min-${idx}">—</span></span>
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">avg</span>&nbsp;<span class="mrtg-stat-val" id="in-avg-${idx}">—</span></span>
                        <span class="mrtg-stat-item"><span class="mrtg-stat-label">max</span>&nbsp;<span class="mrtg-stat-val" id="in-max-${idx}">—</span></span>
                    </div>
                </div>
            </div>
        `;
        grid.appendChild(card);

        // Init Chart.js
        const ctx = document.getElementById('chart-' + idx).getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Bits sent (OUT)',
                        data: [],
                        borderColor: COLOR_OUT,
                        backgroundColor: hexToRgba(COLOR_OUT, 0.55),
                        borderWidth: 1,
                        pointRadius: 0,
                        fill: true,
                        tension: 0,
                        order: 1
                    },
                    {
                        label: 'Bits received (IN)',
                        data: [],
                        borderColor: COLOR_IN,
                        backgroundColor: hexToRgba(COLOR_IN, 0.55),
                        borderWidth: 1,
                        pointRadius: 0,
                        fill: true,
                        tension: 0,
                        order: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(255,255,255,0.95)',
                        titleColor: '#333',
                        bodyColor: '#333',
                        borderColor: '#ccc',
                        borderWidth: 1,
                        titleFont: { size: 11 },
                        bodyFont: { size: 11 },
                        callbacks: {
                            label: function(ctx) {
                                return ' ' + ctx.dataset.label + ': ' + fmtBps(ctx.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: '#e8e8e8',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#cc0000',
                            font: { size: 9 },
                            maxRotation: 45,
                            minRotation: 45,
                            autoSkip: true,
                            maxTicksLimit: 14
                        },
                        border: { color: '#ccc' }
                    },
                    y: {
                        min: 0,
                        grid: {
                            color: '#e8e8e8',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#555',
                            font: { size: 9 },
                            callback: function(v) { return fmtBps(v, 0); },
                            maxTicksLimit: 6
                        },
                        border: { color: '#ccc' }
                    }
                }
            }
        });
        charts.push(chart);
    });

    // =====================================================
    // Utility: format bps → Kbps / Mbps / Gbps
    // =====================================================
    function fmtBps(value, decimals) {
        if (decimals === undefined) decimals = 2;
        if (!value || value === 0) return '0 bps';
        const abs = Math.abs(value);
        if (abs >= 1e9)  return (value / 1e9).toFixed(decimals)  + ' Gbps';
        if (abs >= 1e6)  return (value / 1e6).toFixed(decimals)  + ' Mbps';
        if (abs >= 1e3)  return (value / 1e3).toFixed(decimals)  + ' Kbps';
        return value.toFixed(decimals) + ' bps';
    }

    function hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1,3), 16);
        const g = parseInt(hex.slice(3,5), 16);
        const b = parseInt(hex.slice(5,7), 16);
        return `rgba(${r},${g},${b},${alpha})`;
    }

    // =====================================================
    // Clock → HH:MM label (local time)
    // =====================================================
    function clockToLabel(clock) {
        const d = new Date(clock * 1000);
        const h = d.getHours().toString().padStart(2, '0');
        const m = d.getMinutes().toString().padStart(2, '0');
        return h + ':' + m;
    }

    // =====================================================
    // Fetch data from backend JSON endpoint
    // =====================================================
    async function fetchData() {
        try {
            // Build base URL: strip everything from /admin/ onwards
            // e.g. http://localhost/RRI-LOCAL/admin/network-traffic-mrtg → http://localhost/RRI-LOCAL
            const pathParts = window.location.pathname.split('/');
            const adminIdx  = pathParts.indexOf('admin');
            const basePath  = adminIdx > 0 ? pathParts.slice(0, adminIdx).join('/') : '';
            const url       = basePath + '/admin/traffic/mrtg';

            const resp = await fetch(url, { cache: 'no-store' });
            if (!resp.ok) throw new Error('HTTP ' + resp.status + ' at ' + url);
            const data = await resp.json();

            if (!data.success || !data.hosts) {
                console.warn('MRTG: unexpected response', data);
                return;
            }

            data.hosts.forEach(function(host, idx) {
                if (idx >= HOSTS.length) return;

                // Hide loading
                const loadEl = document.getElementById('loading-' + idx);
                if (loadEl) loadEl.classList.add('hidden');

                // Build time labels from IN data (or OUT if IN empty)
                const inData  = host.in_data  || [];
                const outData = host.out_data || [];
                const src     = inData.length >= outData.length ? inData : outData;
                const labels  = src.map(function(d) { return clockToLabel(d.clock); });

                // Value arrays (raw bps)
                const inVals  = inData.map(function(d)  { return d.value_avg; });
                const outVals = outData.map(function(d) { return d.value_avg; });

                // Update chart
                charts[idx].data.labels           = labels;
                charts[idx].data.datasets[0].data = outVals;  // red = OUT
                charts[idx].data.datasets[1].data = inVals;   // green = IN
                charts[idx].update('none');

                // Update interface names
                setText('out-name-' + idx, host.out_name || 'Bits sent');
                setText('in-name-'  + idx, host.in_name  || 'Bits received');

                // Update stats
                const os = host.out_stats || {};
                const is = host.in_stats  || {};

                // [avg] column = lastvalue from item.get (realtime)
                setText('out-last-' + idx, fmtBps(host.out_last || os.last || 0));
                setText('in-last-'  + idx, fmtBps(host.in_last  || is.last || 0));

                setText('out-min-' + idx, fmtBps(os.min || 0));
                setText('out-avg-' + idx, fmtBps(os.avg || 0));
                setText('out-max-' + idx, fmtBps(os.max || 0));

                setText('in-min-' + idx, fmtBps(is.min || 0));
                setText('in-avg-' + idx, fmtBps(is.avg || 0));
                setText('in-max-' + idx, fmtBps(is.max || 0));
            });

            // Update timestamp
            const now = new Date();
            const ts  = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            setText('mrtg-last-update', ts);

        } catch (err) {
            console.error('MRTG fetch error:', err);
        }
    }

    function setText(id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val;
    }

    // =====================================================
    // Init + auto-refresh every 5 minutes
    // =====================================================
    document.addEventListener('DOMContentLoaded', function() {
        fetchData();
        setInterval(fetchData, 5 * 60 * 1000);
    });

    // Resize charts on window resize
    window.addEventListener('resize', function() {
        charts.forEach(function(c) { c.resize(); });
    });

})();
</script>
