<div class="row">
    <div class="col-12">
        <!-- Main Traffic Card -->
        <div class="card shadow-sm border-0 rounded-xl overflow-hidden bg-white dark:bg-slate-800">
            <div class="card-header bg-transparent border-bottom border-gray-100 dark:border-slate-700 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1 font-weight-bold text-dark dark:text-white">
                            <i class="fas fa-network-wired mr-2 text-primary"></i>ISP FIBERNET
                        </h4>
                        <p class="text-muted small mb-0">Interfacefibernet</p>
                    </div>
                    <div class="text-right">
                        <div class="badge badge-soft-success p-2 px-3 rounded-pill">
                            <span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span>
                            LIVE MONITORING
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Chart Container -->
                <div id="zabbix-traffic-chart" style="width: 100%; height: 450px;"></div>
                
                <!-- Stats Overlay/Legend Table -->
                <div class="p-4 bg-light dark:bg-slate-900/50 border-top border-gray-100 dark:border-slate-700">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0 text-center">
                            <thead class="text-muted small uppercase tracking-wider">
                                <tr>
                                    <th class="text-left">Interface / Metric</th>
                                    <th>Last</th>
                                    <th>Min</th>
                                    <th>Avg</th>
                                    <th>Max</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-bold">
                                <tr>
                                    <td class="text-left d-flex align-items-center">
                                        <span class="d-inline-block w-3 h-3 rounded mr-2" style="background: #2d8e2d;"></span>
                                        <span class="dark:text-slate-300">Incoming traffic (RX)</span>
                                    </td>
                                    <td id="rx-last" class="text-success">-</td>
                                    <td id="rx-min">-</td>
                                    <td id="rx-avg">-</td>
                                    <td id="rx-max">-</td>
                                </tr>
                                <tr>
                                    <td class="text-left d-flex align-items-center">
                                        <span class="d-inline-block w-3 h-3 rounded mr-2" style="background: #e64a19;"></span>
                                        <span class="dark:text-slate-300">Outgoing traffic (TX)</span>
                                    </td>
                                    <td id="tx-last" class="text-orange">-</td>
                                    <td id="tx-min">-</td>
                                    <td id="tx-avg">-</td>
                                    <td id="tx-max">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent p-3 text-center border-top border-gray-100 dark:border-slate-700">
                <small class="text-muted">
                    Auto-refreshes every 60 seconds. Last updated: <span id="last-update">Never</span>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

<style>
    .dark .card { background: #1e293b; color: #f8fafc; }
    .dark .text-muted { color: #94a3b8 !important; }
    .text-orange { color: #e64a19; }
    .badge-soft-success {
        background-color: rgba(45, 142, 45, 0.1);
        color: #2d8e2d;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .spinner-grow-sm { width: 0.7rem; height: 0.7rem; }
    .w-3 { width: 0.75rem; }
    .h-3 { height: 0.75rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartDom = document.getElementById('zabbix-traffic-chart');
    const myChart = echarts.init(chartDom);
    
    // Konfigurasi Chart Gaya MRTG Premium
    const option = {
        grid: {
            top: '10%',
            left: '3%',
            right: '4%',
            bottom: '5%',
            containLabel: true
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: { type: 'cross', label: { backgroundColor: '#6a7985' } },
            formatter: function(params) {
                let res = `<div style="font-weight:bold;margin-bottom:5px;">${params[0].axisValueLabel}</div>`;
                params.forEach(item => {
                    res += `<div style="display:flex;justify-content:space-between;gap:20px;">
                                <span>${item.marker} ${item.seriesName}:</span>
                                <span style="font-weight:bold;">${formatBytes(item.value)}</span>
                            </div>`;
                });
                return res;
            }
        },
        legend: { show: false },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [],
            axisLine: { lineStyle: { color: '#ddd' } },
            axisLabel: { color: '#999', fontSize: 10 }
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: function(value) { return formatBytes(value, 0); },
                color: '#999',
                fontSize: 10
            },
            splitLine: { lineStyle: { type: 'dashed', color: '#eee' } }
        },
        series: [
            {
                name: 'Received (RX)',
                type: 'line',
                data: [],
                smooth: true,
                symbol: 'none',
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: 'rgba(45, 142, 45, 0.8)' },
                        { offset: 1, color: 'rgba(45, 142, 45, 0.1)' }
                    ])
                },
                lineStyle: { color: '#2d8e2d', width: 2 },
                itemStyle: { color: '#2d8e2d' }
            },
            {
                name: 'Sent (TX)',
                type: 'line',
                data: [],
                smooth: true,
                symbol: 'none',
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: 'rgba(230, 74, 25, 0.8)' },
                        { offset: 1, color: 'rgba(230, 74, 25, 0.1)' }
                    ])
                },
                lineStyle: { color: '#e64a19', width: 2 },
                itemStyle: { color: '#e64a19' }
            }
        ]
    };

    myChart.setOption(option);

    // Function untuk format bytes ke Mbps/Gbps
    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 bps';
        const k = 1000;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    // Function Fetch Data
    async function fetchData() {
        try {
            // Dynamic base path calculation for local/production consistency
            const basePath = window.location.pathname.split('/admin/')[0];
            const fetchUrl = basePath + '/admin/traffic/get/10710/sfp-sfpplus1-fibernet';
            
            const response = await fetch(fetchUrl);
            const data = await response.json();
            console.log('Zabbix API Response:', data);
            
            if (data.success) {
                const rx = data.rx || [];
                const tx = data.tx || [];
                
                // Urutkan berdasarkan clock (takut nyampur)
                rx.sort((a, b) => a.clock - b.clock);
                tx.sort((a, b) => a.clock - b.clock);

                const timestamps = rx.map(d => {
                    const date = new Date(d.clock * 1000);
                    return date.getHours().toString().padStart(2, '0') + ':' + 
                           date.getMinutes().toString().padStart(2, '0');
                });

                const rxValues = rx.map(d => d.value);
                const txValues = tx.map(d => d.value);

                myChart.setOption({
                    xAxis: { data: timestamps },
                    series: [
                        { data: rxValues },
                        { data: txValues }
                    ]
                });

                // Update Stats Table
                updateStats('rx', rxValues);
                updateStats('tx', txValues);
                
                document.getElementById('last-update').innerText = new Date().toLocaleTimeString();
            }
        } catch (error) {
            console.error('Error fetching Zabbix data:', error);
        }
    }

    function updateStats(prefix, values) {
        if (!values.length) return;
        const last = values[values.length - 1];
        const min = Math.min(...values);
        const max = Math.max(...values);
        const avg = values.reduce((a, b) => a + b, 0) / values.length;

        document.getElementById(`${prefix}-last`).innerText = formatBytes(last);
        document.getElementById(`${prefix}-min`).innerText = formatBytes(min);
        document.getElementById(`${prefix}-avg`).innerText = formatBytes(avg);
        document.getElementById(`${prefix}-max`).innerText = formatBytes(max);
    }

    fetchData();
    setInterval(fetchData, 60000); // 1 Menit Auto Refresh

    window.addEventListener('resize', () => myChart.resize());
});
</script>
