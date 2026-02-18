<!-- Network Traffic MRTG - Zabbix Style Dashboard (ApexCharts Dark) -->
<style>
    /* ===== MODERN DARK DASHBOARD ===== */
    :root {
        --bg-body: #0f172a;       /* Slate 900 */
        --bg-card: #1e293b;       /* Slate 800 */
        --text-main: #e2e8f0;     /* Slate 200 */
        --text-muted: #94a3b8;    /* Slate 400 */
        --border-color: #334155;  /* Slate 700 */
        
        --color-in: #00e676;      /* Neon Green/Cyan for IN */
        --color-out: #ff5252;     /* Soft Red/Orange for OUT */
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .mrtg-wrapper {
        padding: 20px;
        max-width: 1600px;
        margin: 0 auto;
    }

    /* Header Bar */
    .mrtg-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
    }
    .mrtg-topbar-title {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .mrtg-topbar-right {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 12px;
        color: var(--text-muted);
    }
    .mrtg-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(34, 197, 94, 0.1); /* Green tint */
        color: #4ade80; /* Green 400 */
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid rgba(74, 222, 128, 0.2);
    }
    .mrtg-live-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #4ade80;
        box-shadow: 0 0 8px #4ade80; /* Glow */
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(74, 222, 128, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
    }

    /* Grid Layout */
    .mrtg-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(600px, 1fr)); /* Responsive */
        gap: 20px;
    }
    @media (max-width: 768px) {
        .mrtg-grid { grid-template-columns: 1fr; }
    }

    /* Card Styling */
    .mrtg-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
    }
    .mrtg-card-header {
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .mrtg-card-info {
        display: flex;
        flex-direction: column;
    }
    .mrtg-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .mrtg-card-port {
        font-size: 11px;
        color: var(--text-muted);
        font-family: Consolas, monospace;
    }

    /* Chart Container */
    .mrtg-chart-wrap {
        position: relative;
        height: 220px; /* Reduced height for stacked compact view */
        padding: 10px 10px 0 0; /* Right padding for axis labels */
        background: var(--bg-card); /* Ensure solid bg for chart */
    }
    
    /* Loading Overlay */
    .mrtg-loading {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(30, 41, 59, 0.8);
        color: var(--text-muted);
        font-size: 12px;
        backdrop-filter: blur(2px);
        z-index: 10;
        transition: opacity 0.3s;
    }
    .mrtg-loading.hidden {
        opacity: 0;
        pointer-events: none;
    }

    /* ApexCharts Customization for Glow */
    .apexcharts-series path {
        transition: filter 0.3s ease;
    }
    /* Series 1: Inbound (Green) */
    .apexcharts-series.apexcharts-series-0 path {
        filter: drop-shadow(0 0 5px rgba(0, 230, 118, 0.6));
    }
    /* Series 2: Outbound (Red) */
    .apexcharts-series.apexcharts-series-1 path {
        filter: drop-shadow(0 0 5px rgba(255, 82, 82, 0.6));
    }
    
    /* Legend / Stats Footer */
    .mrtg-stats-footer {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-top: 1px solid var(--border-color);
        background: rgba(15, 23, 42, 0.3);
    }
    .mrtg-stat-row {
        padding: 8px 12px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .mrtg-stat-row.in { border-right: 1px solid var(--border-color); }
    
    .stat-header {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 2px;
    }
    .stat-dot {
        width: 8px;
        height: 8px;
        border-radius: 2px;
    }
    .stat-title {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
    }
    .stat-values {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: var(--text-muted);
    }
    .stat-val-group {
        display: flex;
        flex-direction: column;
    }
    .stat-val-label { font-size: 9px; opacity: 0.7; }
    .stat-val-num { font-size: 12px; color: #fff; font-weight: 500; font-family: Consolas, monospace; }
    
    /* Footer Global */
    .mrtg-footer-global {
        text-align: center;
        padding: 20px;
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    /* Custom Scrollbar for better dark mode feel */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--bg-body); }
    ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #475569; }

</style>

<div class="mrtg-wrapper">

    <!-- Top Bar -->
    <div class="mrtg-topbar">
        <div class="mrtg-topbar-title">
            <i class="fas fa-network-wired" style="color: #60a5fa;"></i>
            Network Traffic Monitor <span style="font-weight:400; font-size:13px; opacity:0.6; margin-left:5px;">| Real-time Dashboard</span>
        </div>
        <div class="mrtg-topbar-right">
            <span class="mrtg-live-badge"><span class="mrtg-live-dot"></span> LIVE</span>
            <span>Last Update: <strong id="mrtg-last-update" style="color:#fff;">—</strong></span>
            <span>Refresh: 5m</span>
        </div>
    </div>

    <!-- Grid Container -->
    <div class="mrtg-grid" id="mrtg-grid">
        <!-- Cards injected by JS -->
    </div>

    <!-- Global Footer -->
    <div class="mrtg-footer-global">
        Data Source: Zabbix API &nbsp;&bull;&nbsp; 
        Time Range: Today (00:00 – Now) &nbsp;&bull;&nbsp; 
        Resolution: 1 Hour
    </div>

</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
(function() {

    // =====================================================
    // HOST CONFIGURATION
    // =====================================================
    const HOSTS = [
        { label: 'ASTINET',                      port: 'ether1-Astinet-Telkom-200Mbps (PORT 1)',  inId: '66918',  outId: '66942'  },
        { label: 'ASTINET TUNNEL',               port: 'ether4-ASTINET-Utama-50Mbps (PORT 4)',                    inId: '333371', outId: '333722' },
        { label: 'FIBERNET GEDUNG MBC PUSBANGKOM', port: 'ether1-ISP-Fibernet (PORT 1)',             inId: '424087', outId: '424090' },
        { label: 'FIBERNET PUSBANGKOM',          port: 'ether1-Modem-Fibernet (PORT 1 - Sumber Internet 80Mbps)', inId: '373158', outId: '373191' },
        { label: 'FIBERNET',                     port: 'sfp-sfpplus1-fibernet (fibernet)',         inId: '423546', outId: '423603' },
        { label: 'FIBERNET BINA PROFESI',        port: 'ether8-Router-Fibernet (PORT 8 - Sumber Internet Fiber)', inId: '424984', outId: '425005' },
        { label: 'FIBERNET DC DPOK',             port: 'ether6-DC-Depok (PORT 6)',                 inId: '423534', outId: '423591' },
        { label: 'FIBERNET SPI',                 port: 'ether1-Sumber-Fibernet (PORT 1)',          inId: '413801', outId: '413819' },
        { label: 'INTERNET DC JKT',              port: 'ether1-DC-Jakarta (PORT 1)',               inId: '423529', outId: '423586' },
        { label: 'FIBERNET PEMANCAR KEBAYORAN',  port: 'ether1 (LINK 1)',                          inId: '374436', outId: '374457' },
        { label: 'INTERNET RRI KANTOR PUSAT',    port: 'sfp-sfpplus2-Fortigate-KTRPusat',         inId: '423545', outId: '423602' },
        { label: 'FIBERNET DC PDN',              port: 'ether2-DC-PDN-Serpong',                    inId: '423530', outId: '423587' }
    ];

    // Colors
    const COLOR_IN  = '#00e676'; // Neon Green
    const COLOR_OUT = '#ff5252'; // Soft Red

    const charts = []; // Store chart instances
    const grid   = document.getElementById('mrtg-grid');

    // =====================================================
    // BUILD DOM & AUTHENTICATE APEXCHARTS
    // =====================================================
    HOSTS.forEach(function(host, idx) {
        const card = document.createElement('div');
        card.className = 'mrtg-card';
        card.innerHTML = `
            <div class="mrtg-card-header">
                <div class="mrtg-card-info">
                    <div class="mrtg-card-title">${host.label}</div>
                    <div class="mrtg-card-port">${host.port}</div>
                </div>
            </div>
            
            <div class="mrtg-chart-wrap">
                <div class="mrtg-loading" id="loading-${idx}">
                    <i class="fas fa-spinner fa-spin"></i>&nbsp;Loading Data...
                </div>
                <div id="chart-${idx}" style="min-height: 220px;"></div>
            </div>

            <div class="mrtg-stats-footer">
                <!-- IN Stats (Green) -->
                <div class="mrtg-stat-row in">
                    <div class="stat-header">
                        <div class="stat-dot" style="background:${COLOR_IN}; box-shadow: 0 0 5px ${COLOR_IN};"></div>
                        <div class="stat-title">Received (In)</div>
                    </div>
                    <div class="stat-values">
                        <div class="stat-val-group">
                            <span class="stat-val-label">Last</span>
                            <span class="stat-val-num" id="in-last-${idx}">—</span>
                        </div>
                        <div class="stat-val-group">
                            <span class="stat-val-label">Avg</span>
                            <span class="stat-val-num" id="in-avg-${idx}">—</span>
                        </div>
                        <div class="stat-val-group">
                            <span class="stat-val-label">Max</span>
                            <span class="stat-val-num" id="in-max-${idx}">—</span>
                        </div>
                    </div>
                </div>

                <!-- OUT Stats (Red) -->
                <div class="mrtg-stat-row">
                    <div class="stat-header">
                        <div class="stat-dot" style="background:${COLOR_OUT}; box-shadow: 0 0 5px ${COLOR_OUT};"></div>
                        <div class="stat-title">Sent (Out)</div>
                    </div>
                    <div class="stat-values">
                        <div class="stat-val-group">
                            <span class="stat-val-label">Last</span>
                            <span class="stat-val-num" id="out-last-${idx}">—</span>
                        </div>
                        <div class="stat-val-group">
                            <span class="stat-val-label">Avg</span>
                            <span class="stat-val-num" id="out-avg-${idx}">—</span>
                        </div>
                        <div class="stat-val-group">
                            <span class="stat-val-label">Max</span>
                            <span class="stat-val-num" id="out-max-${idx}">—</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        grid.appendChild(card);

        // Init ApexChart
        const options = {
            series: [], // To be filled
            chart: {
                type: 'area',
                height: 220,
                stacked: true,
                background: 'transparent',
                toolbar: { show: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            colors: [COLOR_IN, COLOR_OUT],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'category',
                categories: [],
                labels: {
                    style: { colors: '#64748b', fontSize: '10px', fontFamily: 'Consolas' },
                    rotate: -45,
                    maxHeight: 50
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                tooltip: { enabled: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#64748b', fontSize: '10px', fontFamily: 'Consolas' },
                    formatter: function(val) { return fmtBps(val, 0); }
                },
            },
            grid: {
                borderColor: '#334155',
                strokeDashArray: 3,
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: true } },
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            theme: { mode: 'dark' },
            tooltip: {
                theme: 'dark',
                x: { show: true },
                y: {
                    formatter: function(val) { return fmtBps(val); }
                },
                style: { fontSize: '12px' },
                marker: { show: true },
            },
            legend: { show: false } // Using custom stats footer instead
        };

        const chart = new ApexCharts(document.querySelector("#chart-" + idx), options);
        chart.render();
        charts.push(chart);
    });

    // =====================================================
    // FETCH DATA
    // =====================================================
    async function fetchData() {
        try {
            const pathParts = window.location.pathname.split('/');
            const adminIdx  = pathParts.indexOf('admin');
            const basePath  = adminIdx > 0 ? pathParts.slice(0, adminIdx).join('/') : '';
            const url       = basePath + '/admin/traffic/mrtg';

            const resp = await fetch(url, { cache: 'no-store' });
            if (!resp.ok) throw new Error('HTTP ' + resp.status);
            const data = await resp.json();

            if (!data.success || !data.hosts) return;

            data.hosts.forEach((host, idx) => {
                if (idx >= HOSTS.length) return;

                // Hide loading
                const loadEl = document.getElementById('loading-' + idx);
                if (loadEl) loadEl.classList.add('hidden');

                // Process Data
                const inData  = host.in_data  || [];
                const outData = host.out_data || [];
                
                // Get Categories (Time)
                const src = inData.length >= outData.length ? inData : outData;
                const categories = src.map(d => clockToLabel(d.clock));
                
                // Get Values
                const inVals = inData.map(d => d.value_avg);
                const outVals = outData.map(d => d.value_avg);

                // Add "Now" Point
                const nowLabel = (function() {
                        const d = new Date();
                        return d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
                })();
                categories.push(nowLabel);
                inVals.push(host.in_last || 0);
                outVals.push(host.out_last || 0);

                // Update Chart
                charts[idx].updateOptions({
                    xaxis: { categories: categories }
                });
                
                // Note: Series order [IN, OUT] to match colors [Green, Red]
                charts[idx].updateSeries([
                    { name: 'Received', data: inVals },
                    { name: 'Sent', data: outVals }
                ]);

                // Update Stats Footer
                const is = host.in_stats || {};
                const os = host.out_stats || {};

                setText('in-last-' + idx, fmtBps(host.in_last || 0));
                setText('in-avg-'  + idx, fmtBps(is.avg || 0));
                setText('in-max-'  + idx, fmtBps(is.max || 0));

                setText('out-last-'+ idx, fmtBps(host.out_last || 0));
                setText('out-avg-' + idx, fmtBps(os.avg || 0));
                setText('out-max-' + idx, fmtBps(os.max || 0));
            });

            // Update Time
            const now = new Date();
            setText('mrtg-last-update', now.toLocaleTimeString('id-ID'));

        } catch (err) {
            console.error('Fetch error:', err);
        }
    }

    // =====================================================
    // UTILS
    // =====================================================
    function fmtBps(value, decimals = 2) {
        if (!value || value === 0) return '0 bps';
        const abs = Math.abs(value);
        if (abs >= 1e9) return (value / 1e9).toFixed(decimals) + ' Gbps';
        if (abs >= 1e6) return (value / 1e6).toFixed(decimals) + ' Mbps';
        if (abs >= 1e3) return (value / 1e3).toFixed(decimals) + ' Kbps';
        return value.toFixed(decimals) + ' bps';
    }

    function clockToLabel(clock) {
        const d = new Date(clock * 1000);
        const h = d.getHours().toString().padStart(2, '0');
        const m = d.getMinutes().toString().padStart(2, '0');
        return h + ':' + m;
    }

    function setText(id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val;
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => {
        fetchData();
        setInterval(fetchData, 5 * 60 * 1000); // 5 min refresh
    });

})();
</script>
