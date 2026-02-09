<!-- =====================================================
     WAF Attack Activity Page - Security Section
     ===================================================== -->

<!-- Page Header -->
<div class="mb-8 p-6 rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 text-white relative overflow-hidden" data-aos="fade-up">
    <div class="absolute inset-0 opacity-20">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="waf-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#waf-grid)"/>
        </svg>
    </div>
    <div class="relative z-10">
        <h1 class="text-2xl font-bold mb-2">Aktivitas Serangan WAF</h1>
        <p class="text-slate-300">Monitoring serangan dan ancaman keamanan dari Safeline WAF secara real-time.</p>
    </div>
    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-red-500/10 rounded-full blur-2xl"></div>
    <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-orange-500/10 rounded-full blur-xl"></div>
</div>

<!-- Main Content -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700" data-aos="fade-up">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Log Serangan</h2>
        
        <div class="flex items-center bg-gray-100 dark:bg-slate-700 p-1 rounded-lg">
            <button onclick="switchTab('logs')" id="tab-logs-btn" class="px-4 py-1.5 text-xs font-medium rounded-md transition-all bg-white dark:bg-slate-600 text-blue-600 dark:text-blue-400 shadow-sm">
                Log Serangan
            </button>
            <button onclick="switchTab('events')" id="tab-events-btn" class="px-4 py-1.5 text-xs font-medium rounded-md transition-all text-gray-500 dark:text-gray-400">
                Kejadian (Events)
            </button>
        </div>

        <button class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium flex items-center gap-2" id="live-view-btn">
            Live View <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span></span>
        </button>
    </div>
    
    <!-- Logs Table -->
    <div id="table-logs-container" class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 dark:bg-slate-700/50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Action</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">URL</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Attack Type</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">IP Addr</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase text-right">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700" id="logs-table-body">
                <?php if (empty($recent_logs)): ?>
                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Menunggu data...</td></tr>
                <?php else: ?>
                    <?php foreach ($recent_logs as $log): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <?php if ($log['action'] == 1 || $log['action'] == 'block'): ?>
                                <span class="px-2 py-0.5 bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400 rounded-full text-[10px] uppercase font-bold">Blocked</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 dark:bg-slate-600 dark:text-gray-400 rounded-full text-[10px] uppercase font-bold">Log</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white truncate max-w-[350px]" title="<?= htmlspecialchars($log['host'] . $log['url_path']) ?>">
                                <span class="font-medium"><?= htmlspecialchars($log['host']) ?></span><?= htmlspecialchars($log['url_path']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300"><?= htmlspecialchars($log['module']) ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-mono text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($log['src_ip']) ?></div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="text-xs text-gray-900 dark:text-white"><?= date('H:i:s', $log['timestamp']) ?></div>
                            <div class="text-[10px] text-gray-500"><?= date('Y-m-d', $log['timestamp']) ?></div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Events Table (Hidden by default) -->
    <div id="table-events-container" class="overflow-x-auto hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 dark:bg-slate-700/50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">IP Addr</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Applications</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase text-center">Attack Count</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase text-center">Duration</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase text-right">Start At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700" id="events-table-body">
                <?php if (empty($recent_events)): ?>
                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada kejadian penting hari ini.</td></tr>
                <?php else: ?>
                    <?php foreach ($recent_events as $event): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-mono text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($event['src_ip'] ?? '-') ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($event['host'] ?? '-') ?></div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded text-xs"><?= $event['count'] ?? '1' ?></span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs text-gray-600 dark:text-gray-400"><?= $event['duration'] ?? '1m' ?></span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="text-xs text-gray-900 dark:text-white"><?= date('H:i:s', $event['timestamp'] ?? time()) ?></div>
                            <div class="text-[10px] text-gray-500"><?= date('Y-m-d', $event['timestamp'] ?? time()) ?></div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- WAF Live Update Script -->
<script>
let currentTab = 'logs';

function switchTab(tab) {
    currentTab = tab;
    
    const logsBtn = document.getElementById('tab-logs-btn');
    const eventsBtn = document.getElementById('tab-events-btn');
    const logsContainer = document.getElementById('table-logs-container');
    const eventsContainer = document.getElementById('table-events-container');

    if (tab === 'logs') {
        logsBtn.classList.add('bg-white', 'dark:bg-slate-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
        logsBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
        eventsBtn.classList.remove('bg-white', 'dark:bg-slate-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
        eventsBtn.classList.add('text-gray-500', 'dark:text-gray-400');
        
        logsContainer.classList.remove('hidden');
        eventsContainer.classList.add('hidden');
    } else {
        eventsBtn.classList.add('bg-white', 'dark:bg-slate-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
        eventsBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
        logsBtn.classList.remove('bg-white', 'dark:bg-slate-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
        logsBtn.classList.add('text-gray-500', 'dark:text-gray-400');
        
        eventsContainer.classList.remove('hidden');
        logsContainer.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const liveViewBtn = document.getElementById('live-view-btn');
    const logsTableBody = document.getElementById('logs-table-body');
    const eventsTableBody = document.getElementById('events-table-body');
    let liveInterval = null;
    let isLive = false;

    function formatTime(timestamp) {
        if (!timestamp) return '-';
        const date = new Date(timestamp * 1000);
        return date.getHours().toString().padStart(2, '0') + ':' + 
               date.getMinutes().toString().padStart(2, '0') + ':' + 
               date.getSeconds().toString().padStart(2, '0');
    }

    function formatDate(timestamp) {
        if (!timestamp) return '-';
        const date = new Date(timestamp * 1000);
        return date.getFullYear() + '-' + 
               (date.getMonth() + 1).toString().padStart(2, '0') + '-' + 
               date.getDate().toString().padStart(2, '0');
    }

    function updateLogsTable(records) {
        if (!records || records.length === 0) return;
        let html = '';
        records.forEach(log => {
            const actionBadge = (log.action == 1 || log.action == 'block') 
                ? `<span class="px-2 py-0.5 bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400 rounded-full text-[10px] uppercase font-bold">Blocked</span>`
                : `<span class="px-2 py-0.5 bg-gray-100 text-gray-600 dark:bg-slate-600 dark:text-gray-400 rounded-full text-[10px] uppercase font-bold">Log</span>`;
            
            html += `
            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                <td class="px-6 py-4">${actionBadge}</td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 dark:text-white truncate max-w-[350px]" title="${(log.host || '') + (log.url_path || '')}">
                        <span class="font-medium">${log.host || ''}</span>${log.url_path || ''}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300">${log.module || ''}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-mono text-sm text-gray-900 dark:text-white">${log.src_ip || ''}</div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="text-xs text-gray-900 dark:text-white">${formatTime(log.timestamp)}</div>
                    <div class="text-[10px] text-gray-500">${formatDate(log.timestamp)}</div>
                </td>
            </tr>`;
        });
        logsTableBody.innerHTML = html;
    }

    function updateEventsTable(events) {
        if (!events || events.length === 0) return;
        let html = '';
        events.forEach(event => {
            html += `
            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-mono text-sm text-gray-900 dark:text-white">${event.src_ip || '-'}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 dark:text-white">${event.host || '-'}</div>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded text-xs">${event.count || '1'}</span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="text-xs text-gray-600 dark:text-gray-400">${event.duration || '1m'}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="text-xs text-gray-900 dark:text-white">${formatTime(event.timestamp)}</div>
                    <div class="text-[10px] text-gray-500">${formatDate(event.timestamp)}</div>
                </td>
            </tr>`;
        });
        eventsTableBody.innerHTML = html;
    }

    async function fetchLiveData() {
        try {
            const response = await fetch('<?= base_url("waf/dashboard_live") ?>');
            if (!response.ok) return;
            const result = await response.json();
            if (result.success && result.data) {
                updateLogsTable(result.data.records);
                updateEventsTable(result.data.events);
            }
        } catch (error) {
            console.error('Failed to fetch WAF live data:', error);
        }
    }

    if (liveViewBtn) {
        liveViewBtn.addEventListener('click', function() {
            isLive = !isLive;
            if (isLive) {
                liveViewBtn.classList.add('bg-blue-50', 'dark:bg-blue-500/10', 'px-3', 'py-1', 'rounded-lg');
                fetchLiveData();
                liveInterval = setInterval(fetchLiveData, 30000);
            } else {
                liveViewBtn.classList.remove('bg-blue-50', 'dark:bg-blue-500/10', 'px-3', 'py-1', 'rounded-lg');
                clearInterval(liveInterval);
            }
        });
    }
});
</script>
