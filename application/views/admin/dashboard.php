<!-- =====================================================
     Dashboard Main View - Attack & Protection Panel
     ===================================================== -->

<!-- Welcome Banner -->
<div class="mb-8 p-6 rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 text-white relative overflow-hidden" data-aos="fade-up">
    <div class="absolute inset-0 opacity-20">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dash-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dash-grid)"/>
        </svg>
    </div>
    <div class="relative z-10 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold mb-2">Security Operations Center</h1>
            <p class="text-slate-300">Monitoring ancaman siber dan status perlindungan sistem secara real-time.</p>
        </div>
        <div class="text-right hidden md:block">
            <div id="live-date" class="text-sm font-bold text-slate-400 mb-1 uppercase tracking-widest"><?= date('Y-m-d') ?></div>
            <div id="live-clock" class="text-4xl font-black text-white tracking-tighter tabular-nums">00:00:00</div>
        </div>
    </div>
    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl"></div>
    <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-purple-500/10 rounded-full blur-xl"></div>
</div>



<!-- Main Content Grid -->
<div class="grid lg:grid-cols-3 gap-6">
    <!-- Security Overview Cards (Main Column) -->
    <div class="lg:col-span-2 space-y-6" data-aos="fade-up">


        <!-- Attack Map Box (Replaces Placeholder) -->
        <div id="map-card" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 relative overflow-hidden transition-all duration-500">
            <div class="flex items-center justify-between mb-4 relative z-10 text-slate-800">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-semibold dark:text-white">Live Attack Map</h3>
                    <div class="flex items-center gap-2 px-2 py-0.5 bg-red-100 dark:bg-red-500/10 rounded text-red-600 dark:text-red-400">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold uppercase tracking-wider">Real-time</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Premium Capsule Theme Switcher -->
                    <div id="map-theme-container" class="relative flex items-center bg-slate-100 dark:bg-slate-900/50 p-1 rounded-full border border-gray-200 dark:border-slate-700/50 shadow-inner w-[90px] h-[34px] cursor-pointer group/theme transition-all overflow-hidden">
                        <!-- Sliding Indicator -->
                        <div id="theme-indicator" class="absolute left-1 w-[40px] h-[26px] bg-white dark:bg-blue-600 rounded-full shadow-md transition-all duration-500 ease-out z-0"></div>
                        
                        <!-- Toggle Buttons Layer -->
                        <div class="relative z-10 flex items-center justify-between w-full px-1.5">
                            <button type="button" onclick="setMapTheme('light')" class="w-9 h-6 flex items-center justify-center transition-colors duration-300 text-blue-600 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z" /></svg>
                            </button>
                            <button type="button" onclick="setMapTheme('dark')" class="w-9 h-6 flex items-center justify-center transition-colors duration-300 text-slate-400 dark:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                            </button>
                        </div>
                    </div>

                    <button id="btn-fullscreen" class="p-2.5 bg-slate-50 dark:bg-slate-700/50 hover:bg-blue-500 hover:text-white rounded-xl transition-all text-slate-400 group shadow-sm" title="Toggle Fullscreen">
                        <svg id="icon-fullscreen" class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Map Container -->
            <div id="attack-map-container" class="w-full h-[400px] relative rounded-lg overflow-hidden border border-slate-100 dark:border-slate-700 bg-[#e0e7ff]/30">
                <div id="attack-map" class="w-full h-full"></div>
                
                <!-- Interaction Overlay (Ctrl + Zoom) -->
                <div id="map-interaction-overlay" class="absolute inset-0 flex items-center justify-center bg-black/50 backdrop-blur-[2px] opacity-0 pointer-events-none transition-opacity duration-300 z-[100]">
                    <div class="bg-slate-900/95 text-white px-6 py-3 rounded-full text-sm font-semibold border border-white/20 shadow-2xl flex items-center gap-3">
                        <div class="flex items-center gap-1.5">
                            <kbd class="px-2 py-1 bg-white/20 rounded border border-white/30 text-[10px] leading-none">Ctrl</kbd>
                            <span class="text-white/40">+</span>
                            <span class="bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded text-[10px] uppercase font-bold tracking-wider">Scroll</span>
                        </div>
                        <div class="w-px h-4 bg-white/10"></div>
                        <span>Use Ctrl + scroll to zoom the map</span>
                    </div>
                </div>
            </div>
            <!-- Fullscreen Only: Right Panel (Live Attacks) -->
            <!-- Fullscreen Only: Right Panel (Live Attacks) -->
            <div id="fs-attack-list" class="hidden absolute top-20 right-6 w-80 bg-slate-900/90 backdrop-blur rounded-xl border border-slate-700/50 z-50 overflow-hidden shadow-2xl transition-all duration-300">
                <button onclick="toggleFsPanel('fs-attack-list-content', this)" class="w-full flex items-center justify-between p-4 bg-slate-800/50 hover:bg-slate-800 transition-colors border-b border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1.5 px-2 py-0.5 bg-red-500/20 rounded text-red-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="text-[10px] font-bold">LIVE</span>
                        </div>
                        <h4 class="text-sm font-bold text-white uppercase tracking-wider">Web Attacks</h4>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="fs-attack-list-content" class="max-h-0 py-0 opacity-0 overflow-hidden overflow-y-auto custom-scrollbar space-y-2 transition-all duration-300 origin-top">
                    <!-- Content injected via JS -->
                    <div class="text-center text-slate-500 text-xs py-4">Waiting for data...</div>
                </div>
            </div>

            <!-- Fullscreen Only: Bottom Left Panel (Leaderboard) -->
            <div id="fs-leaderboard" class="hidden absolute bottom-6 left-6 w-80 bg-slate-900/90 backdrop-blur rounded-xl border border-slate-700/50 z-50 shadow-2xl transition-all duration-300">
                <button onclick="toggleFsPanel('fs-leaderboard-content', this)" class="w-full flex items-center justify-between p-4 bg-slate-800/50 hover:bg-slate-800 transition-colors border-b border-white/5">
                     <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <h4 class="text-sm font-bold text-white uppercase tracking-wider">Top Attackers</h4>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="fs-leaderboard-content" class="max-h-0 py-0 opacity-0 overflow-hidden overflow-y-auto custom-scrollbar space-y-3 transition-all duration-300 origin-bottom">
                    <!-- Content injected via JS -->
                    <div class="text-center text-slate-500 text-xs py-2">Calculating stats...</div>
                </div>
            </div>
        </div>

        <!-- WAF Activity Card with Link -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 rounded-xl shadow-lg p-6 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="waf-pattern" width="30" height="30" patternUnits="userSpaceOnUse">
                            <path d="M 30 0 L 0 0 0 30" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#waf-pattern)"/>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-2">Aktivitas Serangan WAF</h3>
                        <p class="text-blue-100 text-sm mb-4">Lihat log serangan dan kejadian keamanan secara real-time dari Safeline WAF.</p>
                        
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-sm text-blue-100">WAF Active</span>
                            </div>
                            <span class="text-blue-200 text-sm">•</span>
                            <span class="text-sm text-blue-100"><?= count($recent_logs ?? []) ?> log terbaru</span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                
                <a href="<?= base_url('admin/security-waf-activity') ?>" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Detail Serangan
                </a>
            </div>
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
        </div>


    </div>

    <!-- Right Sidebar -->
    <div class="space-y-6">
        <!-- Real-time Web Attack Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden flex flex-col h-[742px]" data-aos="fade-up">
            <div class="p-6 pb-2 border-b border-gray-50 dark:border-slate-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Real-time Web Attack</h3>
            </div>
            
            <div id="web-attack-list" class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-4">
                <!-- Loading State -->
                <div id="sync-indicator" class="flex flex-col items-center justify-center h-full text-slate-400 space-y-2 opacity-50">
                    <svg class="w-8 h-8 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-medium">Syncing events...</span>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- ECharts & Map Scripts -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
/* Fullscreen Styles for the Map Card */
#map-card:-webkit-full-screen {
    width: 100vw !important;
    height: 100vh !important;
    padding: 2rem !important;
    background-color: #f8fafc !important;
    border: none !important;
    border-radius: 0 !important;
}

#map-card:fullscreen {
    width: 100vw !important;
    height: 100vh !important;
    padding: 2rem !important;
    background-color: #f8fafc !important;
    border: none !important;
    border-radius: 0 !important;
}

/* Dark Mode Fullscreen Support */
.dark #map-card:fullscreen,
.dark #map-card:-webkit-full-screen {
    background-color: #0b1426 !important;
}

#map-card.is-fullscreen #attack-map-container {
    height: calc(100vh - 120px) !important;
}

#map-card.is-fullscreen h3 {
    font-size: 1.5rem !important;
    color: #1e293b !important;
}

.dark #map-card.is-fullscreen h3 {
    color: #f8fafc !important;
}

#map-card.map-dark-theme h3 {
    color: white !important;
}

#map-card.map-dark-theme .text-slate-800 {
    color: #f1f5f9 !important;
}

/* Fullscreen Panels Visibility */
#map-card:fullscreen #fs-attack-list, 
#map-card:-webkit-full-screen #fs-attack-list,
#map-card.is-fullscreen #fs-attack-list {
    display: block !important;
}

#map-card:fullscreen #fs-leaderboard,
#map-card:-webkit-full-screen #fs-leaderboard,
#map-card.is-fullscreen #fs-leaderboard {
    display: block !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // -----------------------------------------------------
    // Configuration
    // -----------------------------------------------------
    const JAKARTA_COORDS = [106.8456, -6.2088]; // Target Location (RRI)
    
    // Expanded Country Coordinates to ensure matches
    const COUNTRY_COORDS = {
        // Move ID/Indonesia to Central Indonesia (Kalimantan) so domestic lines to Jakarta are visible
        'Indonesia': [113.9213, -0.7893], 'ID': [113.9213, -0.7893],
        'United States': [-95.7, 37.1], 'US': [-95.7, 37.1], 'USA': [-95.7, 37.1],

        'China': [104.2, 35.9], 'CN': [104.2, 35.9],
        'Russia': [105.3, 61.5], 'RU': [105.3, 61.5],
        'Brazil': [-51.9, -14.2], 'BR': [-51.9, -14.2],
        'India': [78.9, 20.6], 'IN': [78.9, 20.6],
        'Germany': [10.4, 51.2], 'DE': [10.4, 51.2],
        'United Kingdom': [-3.4, 55.4], 'UK': [-3.4, 55.4], 'GB': [-3.4, 55.4],
        'France': [2.2, 46.2], 'FR': [2.2, 46.2],
        'Italy': [12.6, 41.9], 'IT': [12.6, 41.9],
        'Canada': [-106.3, 56.1], 'CA': [-106.3, 56.1],
        'Australia': [133.8, -25.3], 'AU': [133.8, -25.3],
        'Japan': [138.3, 36.2], 'JP': [138.3, 36.2],
        'South Korea': [127.8, 35.9], 'KR': [127.8, 35.9],
        'Netherlands': [5.3, 52.1], 'NL': [5.3, 52.1],
        'Singapore': [103.8, 1.4], 'SG': [103.8, 1.4],
        'Malaysia': [102.0, 4.2], 'MY': [102.0, 4.2],
        'Vietnam': [108.3, 14.1], 'VN': [108.3, 14.1],
        'Thailand': [101.0, 15.9], 'TH': [101.0, 15.9],
        'Taiwan': [121.0, 23.7], 'TW': [121.0, 23.7],
        'Hong Kong': [114.2, 22.3], 'HK': [114.2, 22.3],
        'Ukraine': [31.2, 48.4], 'UA': [31.2, 48.4],
        'Iran': [53.7, 32.4], 'IR': [53.7, 32.4],
        'Turkey': [35.2, 39.0], 'TR': [35.2, 39.0],
        'Israel': [34.9, 31.0], 'IL': [34.9, 31.0],
        'Poland': [19.1, 51.9], 'PL': [19.1, 51.9],
        'Sweden': [18.6, 60.1], 'SE': [18.6, 60.1],
        'Spain': [-3.7, 40.5], 'ES': [-3.7, 40.5],
        'Mexico': [-102.6, 23.6], 'MX': [-102.6, 23.6],
        'Argentina': [-63.6, -38.4], 'AR': [-63.6, -38.4],
        'South Africa': [22.9, -30.6], 'ZA': [22.9, -30.6],
        'Egypt': [30.8, 26.8], 'EG': [30.8, 26.8],
        'Saudi Arabia': [45.1, 23.9], 'SA': [45.1, 23.9],
        'Pakistan': [69.3, 30.4], 'PK': [69.3, 30.4],
        'Bangladesh': [90.4, 23.7], 'BD': [90.4, 23.7],
        'Philippines': [121.8, 12.9], 'PH': [121.8, 12.9],
        'New Zealand': [174.9, -40.9], 'NZ': [174.9, -40.9],
        'Switzerland': [8.2, 46.8], 'CH': [8.2, 46.8],
        'Belgium': [4.5, 50.5], 'BE': [4.5, 50.5],
        'Austria': [14.6, 47.5], 'AT': [14.6, 47.5],
        'Norway': [8.5, 60.5], 'NO': [8.5, 60.5],
        'Denmark': [9.5, 56.3], 'DK': [9.5, 56.3],
        'Finland': [25.7, 61.9], 'FI': [25.7, 61.9],
        'Ireland': [-8.2, 53.4], 'IE': [-8.2, 53.4],
        'Portugal': [-8.2, 39.4], 'PT': [-8.2, 39.4],
        'Greece': [21.8, 39.1], 'GR': [21.8, 39.1],
        'Romania': [25.0, 45.9], 'RO': [25.0, 45.9],
        'Hungary': [19.5, 47.2], 'HU': [19.5, 47.2],
        'Czech Republic': [15.5, 49.8], 'CZ': [15.5, 49.8],
        'Mauritius': [57.5, -20.3], 'MU': [57.5, -20.3],
        'Lebanon': [35.5, 33.9], 'LB': [35.5, 33.9],
    };

    let chartInstance = null;
    let isMapLoaded = false;

    // Theme Configurations
    const MAP_THEMES = {
        light: {
            ocean: '#dee6ed',
            land: '#ffffff',
            border: '#cbd5e1'
        },
        dark: {
            ocean: '#0b1426', // Deep Navy
            land: '#1e3a8a',  // Rich Blue
            border: '#1e40af' 
        }
    };

    let currentTheme = localStorage.getItem('attack-map-theme') || 'light';
    const MAP_THEME = {
        lineStart: '#fb7185', // Pink
        lineEnd: '#8b5cf6',   // Purple
        target: '#22c55e',   // Green
        attacker: '#ef4444'  // Red
    };

    // -----------------------------------------------------
    // Map Initialization
    // -----------------------------------------------------
    function initMap() {
        const dom = document.getElementById('attack-map');
        if (!dom) return;

        chartInstance = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });

        // Load World Map JSON
        $.getJSON('https://fastly.jsdelivr.net/npm/echarts@4.9.0/map/json/world.json', function (data) {
            echarts.registerMap('world', data);
            
            const theme = MAP_THEMES[currentTheme];
            const option = {
                backgroundColor: theme.ocean,
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    borderColor: '#e2e8f0',
                    textStyle: { color: '#1e293b' },
                    padding: 8,
                    borderRadius: 8,
                    extraCssText: 'box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border: 1px solid #e2e8f0;',
                    formatter: function(params) {
                        if (params.seriesType === 'lines') {
                            const d = params.data;
                            return `
                                <div class="text-xs p-1">
                                    <div class="font-bold text-red-600 mb-1 border-b border-red-100 pb-1 uppercase tracking-tight">ATTACK DETECTED</div>
                                    <div class="space-y-1 mt-1">
                                        <div><span class="text-slate-500 font-medium">IP:</span> <span class="font-mono" style="color: #1e293b; font-weight: 700;">${d.ip || 'Hidden'}</span></div>
                                        <div><span class="text-slate-500 font-medium fa-check">From:</span> <span style="color: #334155;">${d.fromName}${d.location ? ' • ' + d.location : ''}</span></div>
                                        <div><span class="text-slate-500 font-medium">Target:</span> <span style="color: #334155;">${d.toName}</span></div>
                                        <div><span class="text-slate-500 font-medium">Module:</span> <span class="text-blue-600 font-semibold">${d.type}</span></div>
                                    </div>
                                </div>
                            `;
                        }
                        return null;
                    }
                },
                geo: {
                    id: 'main-geo',
                    map: 'world',
                    roam: true,
                    scaleLimit: { min: 1, max: 50 }, // Increased for province-level detail
                    center: [106, 15],
                    zoom: 1.5,
                    boundingCoords: [
                        [-180, 85],
                        [180, -60]
                    ],
                    label: { emphasis: { show: false } },
                    itemStyle: {
                        normal: {
                            areaColor: theme.land, 
                            borderColor: theme.border,
                            borderWidth: 0.5
                        },
                        emphasis: {
                            areaColor: currentTheme === 'dark' ? '#1e3a8a' : '#f1f5f9'
                        }
                    }
                },
                series: [
                    {
                        name: 'Attack Lines',
                        type: 'lines',
                        coordinateSystem: 'geo',
                        zlevel: 2,
                        effect: {
                            show: true,
                            period: 3,
                            trailLength: 0.5,
                            color: '#fff',
                            symbolSize: 4,
                            shadowBlur: 20,
                            shadowColor: '#fff'
                        },
                        lineStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0, color: MAP_THEME.lineStart
                                }, {
                                    offset: 1, color: MAP_THEME.lineEnd
                                }]),
                                width: 2,
                                opacity: 0.5,
                                curveness: 0.35 // Membuat lengkungan lebih melengkung seperti di gambar
                            }
                        },
                        data: [] 
                    },
                    {
                        name: 'Attack Points',
                        type: 'effectScatter',
                        coordinateSystem: 'geo',
                        zlevel: 2,
                        symbolSize: 3,
                        itemStyle: {
                            normal: { color: MAP_THEME.attacker }
                        },
                        label: {
                            show: true, // Re-enable labels by default
                            position: 'top',
                            distance: 8, // Closer to the point
                            formatter: function(params) {
                                return `{country|${params.name}} {ip|${params.value[3] || ''}}`;
                            },
                            rich: {
                                country: {
                                    backgroundColor: '#ef4444',
                                    color: '#fff',
                                    padding: [1, 4],
                                    borderRadius: [3, 0, 0, 3],
                                    fontSize: 8,
                                    fontWeight: 'bold'
                                },
                                ip: {
                                    backgroundColor: 'rgba(255,255,255,0.9)',
                                    color: '#1e293b',
                                    padding: [1, 4],
                                    borderRadius: [0, 3, 3, 0],
                                    fontSize: 8,
                                    borderColor: '#e2e8f0',
                                    borderWidth: 1
                                }
                            }
                        },
                        emphasis: {
                            label: {
                                show: true // Show on hover/click
                            }
                        },
                        data: []
                    },
                    {
                        name: 'Target Point',
                        type: 'effectScatter',
                        coordinateSystem: 'geo',
                        zlevel: 2,
                        z: 10,
                        rippleEffect: {
                            brushType: 'stroke',
                            period: 3,
                            scale: 4,
                            number: 3
                        },
                        label: {
                            normal: {
                                show: true,
                                position: 'right',
                                offset: [15, 0],
                                formatter: '{b}',
                                fontSize: 11,
                                fontWeight: '900',
                                color: '#10b981',
                                backgroundColor: currentTheme === 'dark' ? 'rgba(11, 20, 38, 0.9)' : 'rgba(255,255,255,0.95)',
                                padding: [5, 12],
                                borderRadius: 4,
                                borderColor: '#10b981',
                                borderWidth: 1.5,
                                shadowBlur: 15,
                                shadowColor: 'rgba(16, 185, 129, 0.3)'
                            }
                        },
                        symbolSize: 20,
                        symbol: 'diamond',
                        itemStyle: {
                            normal: {
                                color: '#10b981',
                                shadowBlur: 25,
                                shadowColor: 'rgba(16, 185, 129, 0.8)',
                                borderColor: '#fff',
                                borderWidth: 2
                            }
                        },
                        data: [{
                            name: 'RRI DEFENSE HUB',
                            value: [...JAKARTA_COORDS, 100],
                        }]
                    }
                ]
            };

            chartInstance.setOption(option);
            isMapLoaded = true;

            // Track user interaction & Trigger 0.5s Automatic Recall
            let roamTimer = null;
            chartInstance.on('georoam', function (params) {
                window.lastMapInteraction = Date.now();
                
                // Clear existing recall timer
                if (roamTimer) clearTimeout(roamTimer);
                
                // Set recall timer: 0.5s after user stops dragging/zooming
                // This ensures high-res rendering or data alignment happens after movement
                roamTimer = setTimeout(() => {
                    if (window.lastAttacksData) {
                        updateMapData(window.lastAttacksData);
                    }
                }, 500); 
            });
            
            // Resize handler
            window.addEventListener('resize', function() {
                chartInstance.resize();
            });
        });
    }

    // -----------------------------------------------------
    // Extended Country Coordinates (180+ Countries)
    // -----------------------------------------------------
    const EXTENDED_COUNTRY_COORDS = {
        'AF': [67.7, 33.9], 'Afghanistan': [67.7, 33.9],
        'AL': [20.1, 41.1], 'Albania': [20.1, 41.1],
        'DZ': [1.6, 28.0], 'Algeria': [1.6, 28.0],
        'AO': [17.8, -11.2], 'Angola': [17.8, -11.2],
        'AR': [-63.6, -38.4], 'Argentina': [-63.6, -38.4],
        'AM': [45.0, 40.0], 'Armenia': [45.0, 40.0],
        'AU': [133.7, -25.2], 'Australia': [133.7, -25.2],
        'AT': [14.5, 47.5], 'Austria': [14.5, 47.5],
        'AZ': [47.5, 40.1], 'Azerbaijan': [47.5, 40.1],
        'BD': [90.3, 23.6], 'Bangladesh': [90.3, 23.6],
        'BY': [27.9, 53.7], 'Belarus': [27.9, 53.7],
        'BE': [4.4, 50.5], 'Belgium': [4.4, 50.5],
        'BZ': [-88.4, 17.1], 'Belize': [-88.4, 17.1],
        'BJ': [2.3, 9.3], 'Benin': [2.3, 9.3],
        'BT': [90.4, 27.5], 'Bhutan': [90.4, 27.5],
        'BO': [-63.5, -16.2], 'Bolivia': [-63.5, -16.2],
        'BA': [17.6, 43.9], 'Bosnia and Herzegovina': [17.6, 43.9],
        'BW': [24.6, -22.3], 'Botswana': [24.6, -22.3],
        'BR': [-51.9, -14.2], 'Brazil': [-51.9, -14.2],
        'BG': [25.4, 42.7], 'Bulgaria': [25.4, 42.7],
        'BF': [-1.5, 12.2], 'Burkina Faso': [-1.5, 12.2],
        'KH': [104.9, 12.5], 'Cambodia': [104.9, 12.5],
        'CM': [12.3, 7.3], 'Cameroon': [12.3, 7.3],
        'CA': [-106.3, 56.1], 'Canada': [-106.3, 56.1],
        'CF': [20.9, 6.6], 'Central African Republic': [20.9, 6.6],
        'TD': [18.7, 15.4], 'Chad': [18.7, 15.4],
        'CL': [-71.5, -35.6], 'Chile': [-71.5, -35.6],
        'CN': [104.1, 35.8], 'China': [104.1, 35.8],
        'CO': [-74.2, 4.5], 'Colombia': [-74.2, 4.5],
        'CG': [15.8, -0.2], 'Congo': [15.8, -0.2],
        'CR': [-83.7, 9.7], 'Costa Rica': [-83.7, 9.7],
        'HR': [15.2, 45.1], 'Croatia': [15.2, 45.1],
        'CU': [-77.7, 21.5], 'Cuba': [-77.7, 21.5],
        'CY': [33.4, 35.1], 'Cyprus': [33.4, 35.1],
        'CZ': [15.4, 49.8], 'Czech Republic': [15.4, 49.8],
        'DK': [9.5, 56.2], 'Denmark': [9.5, 56.2],
        'DJ': [42.5, 11.8], 'Djibouti': [42.5, 11.8],
        'DO': [-70.1, 18.7], 'Dominican Republic': [-70.1, 18.7],
        'EC': [-78.1, -1.8], 'Ecuador': [-78.1, -1.8],
        'EG': [30.8, 26.8], 'Egypt': [30.8, 26.8],
        'SV': [-88.8, 13.7], 'El Salvador': [-88.8, 13.7],
        'EE': [25.0, 58.5], 'Estonia': [25.0, 58.5],
        'ET': [40.4, 9.1], 'Ethiopia': [40.4, 9.1],
        'FI': [25.7, 61.9], 'Finland': [25.7, 61.9],
        'FR': [2.2, 46.2], 'France': [2.2, 46.2],
        'GA': [11.6, -0.8], 'Gabon': [11.6, -0.8],
        'GM': [-15.3, 13.4], 'Gambia': [-15.3, 13.4],
        'GE': [43.3, 42.3], 'Georgia': [43.3, 42.3],
        'DE': [10.4, 51.1], 'Germany': [10.4, 51.1],
        'GH': [-1.0, 7.9], 'Ghana': [-1.0, 7.9],
        'GR': [21.8, 39.0], 'Greece': [21.8, 39.0],
        'GT': [-90.2, 15.7], 'Guatemala': [-90.2, 15.7],
        'GN': [-9.6, 9.9], 'Guinea': [-9.6, 9.9],
        'GY': [-58.9, 4.8], 'Guyana': [-58.9, 4.8],
        'HT': [-72.2, 18.9], 'Haiti': [-72.2, 18.9],
        'HN': [-86.2, 15.1], 'Honduras': [-86.2, 15.1],
        'HK': [114.1, 22.3], 'Hong Kong': [114.1, 22.3],
        'HU': [19.5, 47.1], 'Hungary': [19.5, 47.1],
        'IS': [-19.0, 64.9], 'Iceland': [-19.0, 64.9],
        'IN': [78.9, 20.5], 'India': [78.9, 20.5],
        'ID': [113.9, -0.7], 'Indonesia': [113.9, -0.7],
        'IR': [53.6, 32.4], 'Iran': [53.6, 32.4],
        'IQ': [43.6, 33.2], 'Iraq': [43.6, 33.2],
        'IE': [-8.2, 53.4], 'Ireland': [-8.2, 53.4],
        'IL': [34.8, 31.0], 'Israel': [34.8, 31.0],
        'IT': [12.5, 41.8], 'Italy': [12.5, 41.8],
        'JM': [-77.2, 18.1], 'Jamaica': [-77.2, 18.1],
        'JP': [138.2, 36.2], 'Japan': [138.2, 36.2],
        'JO': [36.2, 30.5], 'Jordan': [36.2, 30.5],
        'KZ': [66.9, 48.0], 'Kazakhstan': [66.9, 48.0],
        'KE': [37.9, -0.02], 'Kenya': [37.9, -0.02],
        'KP': [127.5, 40.3], 'North Korea': [127.5, 40.3],
        'KR': [127.7, 35.9], 'South Korea': [127.7, 35.9],
        'KW': [47.4, 29.3], 'Kuwait': [47.4, 29.3],
        'KG': [74.7, 41.2], 'Kyrgyzstan': [74.7, 41.2],
        'LA': [102.4, 19.8], 'Laos': [102.4, 19.8],
        'LV': [24.6, 56.8], 'Latvia': [24.6, 56.8],
        'LB': [35.8, 33.8], 'Lebanon': [35.8, 33.8],
        'LS': [28.2, -29.6], 'Lesotho': [28.2, -29.6],
        'LR': [-9.4, 6.4], 'Liberia': [-9.4, 6.4],
        'LY': [17.2, 26.3], 'Libya': [17.2, 26.3],
        'LT': [23.8, 55.1], 'Lithuania': [23.8, 55.1],
        'LU': [6.1, 49.8], 'Luxembourg': [6.1, 49.8],
        'MK': [21.7, 41.6], 'Macedonia': [21.7, 41.6],
        'MG': [46.8, -18.7], 'Madagascar': [46.8, -18.7],
        'MW': [34.3, -13.2], 'Malawi': [34.3, -13.2],
        'MY': [101.9, 4.2], 'Malaysia': [101.9, 4.2],
        'MV': [73.2, 3.2], 'Maldives': [73.2, 3.2],
        'ML': [-3.9, 17.5], 'Mali': [-3.9, 17.5],
        'MT': [14.3, 35.9], 'Malta': [14.3, 35.9],
        'MR': [-10.9, 21.0], 'Mauritania': [-10.9, 21.0],
        'MU': [57.5, -20.3], 'Mauritius': [57.5, -20.3],
        'MX': [-102.5, 23.6], 'Mexico': [-102.5, 23.6],
        'MD': [28.3, 47.4], 'Moldova': [28.3, 47.4],
        'MN': [103.8, 46.8], 'Mongolia': [103.8, 46.8],
        'ME': [19.3, 42.7], 'Montenegro': [19.3, 42.7],
        'MA': [-7.0, 31.7], 'Morocco': [-7.0, 31.7],
        'MZ': [35.5, -18.6], 'Mozambique': [35.5, -18.6],
        'MM': [95.9, 21.9], 'Myanmar': [95.9, 21.9],
        'NA': [18.4, -22.9], 'Namibia': [18.4, -22.9],
        'NP': [84.1, 28.3], 'Nepal': [84.1, 28.3],
        'NL': [5.2, 52.1], 'Netherlands': [5.2, 52.1],
        'NZ': [174.8, -40.9], 'New Zealand': [174.8, -40.9],
        'NI': [-85.2, 12.8], 'Nicaragua': [-85.2, 12.8],
        'NE': [8.0, 17.6], 'Niger': [8.0, 17.6],
        'NG': [8.6, 9.0], 'Nigeria': [8.6, 9.0],
        'NO': [8.4, 60.4], 'Norway': [8.4, 60.4],
        'OM': [55.9, 21.5], 'Oman': [55.9, 21.5],
        'PK': [69.3, 30.3], 'Pakistan': [69.3, 30.3],
        'PA': [-80.7, 8.5], 'Panama': [-80.7, 8.5],
        'PG': [143.9, -6.3], 'Papua New Guinea': [143.9, -6.3],
        'PY': [-58.4, -23.4], 'Paraguay': [-58.4, -23.4],
        'PE': [-75.0, -9.1], 'Peru': [-75.0, -9.1],
        'PH': [121.7, 12.8], 'Philippines': [121.7, 12.8],
        'PL': [19.1, 51.9], 'Poland': [19.1, 51.9],
        'PT': [-8.2, 39.3], 'Portugal': [-8.2, 39.3],
        'QA': [51.1, 25.3], 'Qatar': [51.1, 25.3],
        'RO': [24.9, 45.9], 'Romania': [24.9, 45.9],
        'RU': [105.3, 61.5], 'Russia': [105.3, 61.5],
        'RW': [29.8, -1.9], 'Rwanda': [29.8, -1.9],
        'SA': [45.0, 23.8], 'Saudi Arabia': [45.0, 23.8],
        'SN': [-14.4, 14.4], 'Senegal': [-14.4, 14.4],
        'RS': [21.0, 44.0], 'Serbia': [21.0, 44.0],
        'SG': [103.8, 1.3], 'Singapore': [103.8, 1.3],
        'SK': [19.6, 48.6], 'Slovakia': [19.6, 48.6],
        'SI': [14.9, 46.1], 'Slovenia': [14.9, 46.1],
        'SO': [46.1, 5.1], 'Somalia': [46.1, 5.1],
        'ZA': [22.9, -30.5], 'South Africa': [22.9, -30.5],
        'ES': [-3.7, 40.4], 'Spain': [-3.7, 40.4],
        'LK': [80.7, 7.8], 'Sri Lanka': [80.7, 7.8],
        'SD': [30.2, 12.8], 'Sudan': [30.2, 12.8],
        'SR': [-56.0, 3.9], 'Suriname': [-56.0, 3.9],
        'SE': [18.6, 60.1], 'Sweden': [18.6, 60.1],
        'CH': [8.2, 46.8], 'Switzerland': [8.2, 46.8],
        'SY': [38.9, 34.8], 'Syria': [38.9, 34.8],
        'TW': [120.9, 23.6], 'Taiwan': [120.9, 23.6],
        'TJ': [71.2, 38.8], 'Tajikistan': [71.2, 38.8],
        'TZ': [34.8, -6.3], 'Tanzania': [34.8, -6.3],
        'TH': [100.9, 15.8], 'Thailand': [100.9, 15.8],
        'TL': [125.7, -8.8], 'Timor-Leste': [125.7, -8.8],
        'TG': [0.8, 8.6], 'Togo': [0.8, 8.6],
        'TN': [9.5, 33.8], 'Tunisia': [9.5, 33.8],
        'TR': [35.2, 38.9], 'Turkey': [35.2, 38.9],
        'TM': [59.5, 38.9], 'Turkmenistan': [59.5, 38.9],
        'UG': [32.2, 1.3], 'Uganda': [32.2, 1.3],
        'UA': [31.1, 48.3], 'Ukraine': [31.1, 48.3],
        'AE': [53.8, 23.4], 'United Arab Emirates': [53.8, 23.4],
        'GB': [-3.4, 55.3], 'United Kingdom': [-3.4, 55.3], 'UK': [-3.4, 55.3],
        'US': [-95.7, 37.0], 'United States': [-95.7, 37.0], 'USA': [-95.7, 37.0],
        'UY': [-55.7, -32.5], 'Uruguay': [-55.7, -32.5],
        'UZ': [64.5, 41.3], 'Uzbekistan': [64.5, 41.3],
        'VE': [-66.5, 6.4], 'Venezuela': [-66.5, 6.4],
        'VN': [108.2, 14.0], 'Vietnam': [108.2, 14.0],
        'YE': [48.5, 15.5], 'Yemen': [48.5, 15.5],
        'ZM': [27.8, -13.1], 'Zambia': [27.8, -13.1],
        'ZW': [29.1, -19.0], 'Zimbabwe': [29.1, -19.0]
    };
    
    // Combine standard and extended coords
    Object.assign(COUNTRY_COORDS, EXTENDED_COUNTRY_COORDS);

    // -----------------------------------------------------
    // IP Resolver Cache
    // -----------------------------------------------------
    const IP_CACHE = new Map();
    const RESOLVE_QUEUE = [];
    let isResolving = false;

    // Process IP resolution queue (max 1 request per 1.5s to be polite to free APIs)
    function processResolveQueue() {
        if (RESOLVE_QUEUE.length === 0) {
            isResolving = false;
            return;
        }

        isResolving = true;
        const ip = RESOLVE_QUEUE.shift();
        
        // Skip if already cached
        if (IP_CACHE.has(ip)) {
            processResolveQueue();
            return;
        }

        // Fetch from ip-api.com
        fetch(`http://ip-api.com/json/${ip}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    IP_CACHE.set(ip, {
                        lat: data.lat,
                        lon: data.lon,
                        city: data.city,
                        country: data.country
                    });
                    
                    // Refresh map if we found data
                    if (window.lastAttacksData) {
                        updateMapData(window.lastAttacksData);
                    }
                } else {
                    // Mark as failed to avoid retry loop
                    IP_CACHE.set(ip, { failed: true });
                }
            })
            .catch(err => {
                console.warn('IP Resolve Error:', err);
                IP_CACHE.set(ip, { failed: true });
            })
            .finally(() => {
                setTimeout(processResolveQueue, 1500); // Wait 1.5s before next request
            });
    }

    function queueIpResolution(ip) {
        if (!IP_CACHE.has(ip) && !RESOLVE_QUEUE.includes(ip) && RESOLVE_QUEUE.length < 50) {
            RESOLVE_QUEUE.push(ip);
            if (!isResolving) processResolveQueue();
        }
    }

    // -----------------------------------------------------
    // Data Processing & Updates
    // -----------------------------------------------------
    function updateMapData(records) {
        if (!isMapLoaded || !chartInstance) return;
        
        // Cache data 
        window.lastAttacksData = records;

        // 1. Filter unique entries by IP
        const uniqueEntries = new Map();
        [...records].reverse().forEach(r => {
            const key = r.src_ip || r.ip || 'Unknown';
            if (!uniqueEntries.has(key)) uniqueEntries.set(key, r);
        });

        const lineData = [];
        const scatterData = [];

        /**
         * Deterministic Jitter
         */
        const getDeterministicJitter = (ip, range) => {
            let hash = 0;
            for (let i = 0; i < ip.length; i++) {
                hash = ((hash << 5) - hash) + ip.charCodeAt(i);
                hash |= 0; 
            }
            const angle = (Math.abs(hash) % 360) * (Math.PI / 180);
            const radius = ((Math.abs(hash * 13) % 1000) / 1000) * range;
            return [Math.cos(angle) * radius, Math.sin(angle) * radius];
        };

        const applySmartJitter = (coords, ip, isPrecise) => {
            const distToJakarta = Math.sqrt(Math.pow(coords[0] - JAKARTA_COORDS[0], 2) + Math.pow(coords[1] - JAKARTA_COORDS[1], 2));
            
            if (distToJakarta < 0.5) {
                let hash = 0;
                for (let i = 0; i < ip.length; i++) {
                    hash = ((hash << 5) - hash) + ip.charCodeAt(i);
                    hash |= 0; 
                }
                const angle = (Math.abs(hash) % 360) * (Math.PI / 180);
                const radius = 0.25 + ((Math.abs(hash * 7) % 350) / 1000); 
                return [JAKARTA_COORDS[0] + Math.cos(angle) * radius, JAKARTA_COORDS[1] + Math.sin(angle) * radius];
            }

            let range = isPrecise ? 0.15 : 2.5;
            const jitter = getDeterministicJitter(ip, range);
            return [coords[0] + jitter[0], coords[1] + jitter[1]];
        };

        const entries = Array.from(uniqueEntries.values()).slice(0, 100);

        entries.forEach((record) => {
            const country = record.country || 'ID';
            const src_ip = record.src_ip || record.ip || 'Unknown';
            const module = record.module || 'Web Detection';
            const target_host = record.host || 'RRI SOC';
            
            let isPrecise = false;
            let locationName = '';
            let startCoords = null;

            // Prioritize Real-time Resolved Coords
            const cachedIp = IP_CACHE.get(src_ip);
            if (cachedIp && !cachedIp.failed) {
                startCoords = [cachedIp.lon, cachedIp.lat];
                locationName = cachedIp.city + ', ' + cachedIp.country;
                isPrecise = true;
            } 
            // Fallback to Backend Provided Coords
            else if (record.coords && record.coords.lon && record.coords.lat) {
                startCoords = [record.coords.lon, record.coords.lat];
                locationName = record.coords.city || record.city;
                isPrecise = true;
            } 
            // Fallback to Static Country Coords
            else if (COUNTRY_COORDS[country]) {
                startCoords = [...COUNTRY_COORDS[country]];
                locationName = country;
                isPrecise = false;
            } 
            
            // IP Resolution Queue for Unknowns or Imprecise Locations
            if (!startCoords || (startCoords[0] === 0 && startCoords[1] === 0)) {
                if (src_ip !== 'Unknown') queueIpResolution(src_ip);
                return; // Skip drawing pending IPs to avoid "Point Null Island" (0,0)
            }

            const finalCoords = applySmartJitter(startCoords, src_ip, isPrecise);

            lineData.push({
                fromName: locationName || country,
                toName: target_host,
                coords: [finalCoords, JAKARTA_COORDS],
                type: module,
                ip: src_ip,
                location: locationName || country
            });

            scatterData.push({
                name: locationName || country,
                value: [...finalCoords, 10, src_ip, locationName], 
            });
        });

        // Show labels for only the 10 most recent attacks to maintain readability
        const scatterFinal = scatterData.map((d, i) => {
            return {
                ...d,
                label: { show: i < 10 } 
            };
        });

        // Use name-based merging for stability with zero-delay rendering
        chartInstance.setOption({
            series: [
                { 
                    name: 'Attack Lines', 
                    data: lineData,
                    animation: false 
                }, 
                { 
                    name: 'Attack Points', 
                    data: scatterFinal,
                    animation: false 
                }, 
                { 
                    name: 'Target Point', 
                    data: [{ name: 'RRI DEFENSE HUB', value: [...JAKARTA_COORDS, 100] }],
                    animation: false
                } 
            ]
        }, {
            notMerge: false,
            lazyUpdate: false,
            animation: false,
            animationDurationUpdate: 0
        });
    }

    // -----------------------------------------------------
    // Data Fetching
    // -----------------------------------------------------
    async function refreshDashboardStats() {
        // Show indicator on list if empty, otherwise maybe small indicator elsewhere
        const syncIndicator = document.getElementById('sync-indicator');
        const listContainer = document.getElementById('web-attack-list');
        
        try {
            const response = await fetch('<?= base_url("waf/dashboard_live") ?>?t=' + new Date().getTime());
            if (!response.ok) return;
            const result = await response.json();
            
            if (result.success && result.data) {
                if (result.data.summary) {
                    const totalElem = document.getElementById('stat-total-attacks');
                    const blockedElem = document.getElementById('stat-blocked-attacks');
                    
                    if (totalElem) totalElem.innerText = Number(result.data.summary.total_attacks || 0).toLocaleString();
                    if (blockedElem) blockedElem.innerText = Number(result.data.summary.blocked_attacks || 0).toLocaleString();
                }

                const events = result.data.events || [];
                const records = result.data.records || [];
                const attacks = [...events, ...records]; 
                
                // Immediately process map data regardless of interaction
                updateMapData(attacks);
                updateWebAttackList(events);
                updateLeaderboardStats(attacks);
            }
        } catch (error) {
            console.log('Stats refresh skipped', error);
        }
    }

    // -----------------------------------------------------
    // Web Attack List Rendering
    // -----------------------------------------------------
    function updateWebAttackList(events) {
        const listContainer = document.getElementById('web-attack-list');
        const fsListContainer = document.getElementById('fs-attack-list-content');
        const syncIndicator = document.getElementById('sync-indicator');
        
        if (!events.length) return;

        // 1. Dashboard List (Standard Style)
        if (listContainer) {
            const dashboardHtml = events.map(record => {
                const date = new Date((record.timestamp || Date.now() / 1000) * 1000);
                const formattedDate = date.getFullYear() + '-' + 
                                    String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                                    String(date.getDate()).padStart(2, '0') + ' ' + 
                                    String(date.getHours()).padStart(2, '0') + ':' + 
                                    String(date.getMinutes()).padStart(2, '0') + ':' + 
                                    String(date.getSeconds()).padStart(2, '0');

                return `
                    <div class="flex items-start justify-between py-4 border-b border-gray-50 dark:border-slate-700/50 last:border-0 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors px-2 -mx-2 rounded-lg group">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></span>
                                <span class="font-bold text-slate-900 dark:text-white tracking-tight">${record.src_ip || record.ip}</span>
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium pl-3.5">
                                ${formattedDate}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-slate-800 dark:text-slate-200 text-sm">${record.country || 'Unknown'}</div>
                            <div class="text-xs font-bold text-rose-500 mt-1">${record.count || 1}</div>
                        </div>
                    </div>
                `;
            }).join('');
            listContainer.innerHTML = dashboardHtml;
        }

        // 2. Fullscreen List (Boxed Style Matching Leaderboard)
        if (fsListContainer) {
            const fsHtml = events.map((record, index) => {
                const date = new Date((record.timestamp || Date.now() / 1000) * 1000);
                const timeStr = String(date.getHours()).padStart(2, '0') + ':' + 
                              String(date.getMinutes()).padStart(2, '0') + ':' + 
                              String(date.getSeconds()).padStart(2, '0');
                
                const countryCode = record.country_code || (record.country ? record.country.substring(0,2).toUpperCase() : 'UNK');

                return `
                <div class="flex items-center justify-between p-2 rounded-lg border bg-slate-800/50 border-slate-700/50 mb-2 last:mb-0 hover:border-slate-600 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col items-center justify-center w-8 h-8 rounded bg-slate-700/50 border border-slate-600/30">
                            <span class="text-[10px] font-bold text-slate-400">${index + 1}</span>
                        </div>
                        <div class="space-y-0.5">
                            <div class="text-xs font-bold text-slate-200 font-mono tracking-tight">${record.src_ip || record.ip}</div>
                            <div class="text-[10px] text-slate-400 flex items-center gap-1.5">
                                <span class="text-blue-400 font-bold">${countryCode}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-600"></span>
                                <span>${timeStr}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-600"></span>
                                <span>${record.module || 'WAF'}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right pl-2">
                        <div class="text-[10px] font-bold text-rose-400 bg-rose-500/10 border border-rose-500/20 px-2 py-0.5 rounded inline-block whitespace-nowrap">
                            ID: ${record.rule_id || record.id || '403'}
                        </div>
                    </div>
                </div>`;
            }).join('');
            fsListContainer.innerHTML = fsHtml;
        }
        
        if (syncIndicator) {
            syncIndicator.style.display = 'none';
        }
    }

    function updateLeaderboardStats(attacks) {
        const container = document.getElementById('fs-leaderboard-content');
        if (!container || !attacks.length) return;

        // Group by IP
        const counts = {};
        attacks.forEach(a => {
            const ip = a.src_ip || a.ip || 'Unknown';
            if(ip === 'Unknown') return;
            
            if (!counts[ip]) {
                counts[ip] = {
                    ip: ip,
                    country: a.country || 'Unknown',
                    count: 0
                };
            }
            // If API provides 'count', use it, else count individual records
            counts[ip].count += (parseInt(a.count) || 1);
        });

        // Sort Top 5
        const sorted = Object.values(counts).sort((a, b) => b.count - a.count).slice(0, 5);

        if (sorted.length === 0) {
            container.innerHTML = '<div class="text-center text-slate-500 text-xs py-2">No active attacks today</div>';
            return;
        }

        const html = sorted.map((item, index) => {
            const rankColor = index === 0 ? 'text-yellow-400' : (index === 1 ? 'text-slate-300' : (index === 2 ? 'text-amber-600' : 'text-slate-500'));
            const bgClass = index === 0 ? 'bg-yellow-400/10 border-yellow-400/20' : 'bg-slate-800/50 border-slate-700/50';
            
            return `
            <div class="flex items-center justify-between p-2 rounded-lg border ${bgClass} mb-2 last:mb-0">
                <div class="flex items-center gap-3">
                    <div class="font-black font-mono ${rankColor} w-4 text-center">${index + 1}</div>
                    <div>
                        <div class="text-xs font-bold text-slate-200 font-mono">${item.ip}</div>
                        <div class="text-[10px] text-slate-400">${item.country}</div>
                    </div>
                </div>
                <div class="px-2 py-0.5 bg-slate-700 rounded text-xs font-bold text-white min-w-[30px] text-center">
                    ${item.count.toLocaleString()}
                </div>
            </div>`;
        }).join('');

        container.innerHTML = html;
    }

    // -----------------------------------------------------
    // Live Clock
    // -----------------------------------------------------
    function startClock() {
        const clockElem = document.getElementById('live-clock');
        const dateElem = document.getElementById('live-date');
        if (!clockElem) return;

        setInterval(() => {
            const now = new Date();
            clockElem.innerText = now.getHours().toString().padStart(2, '0') + ':' + 
                                now.getMinutes().toString().padStart(2, '0') + ':' + 
                                now.getSeconds().toString().padStart(2, '0');
            
            if (now.getSeconds() === 0) {
                dateElem.innerText = now.getFullYear() + '-' + 
                                    (now.getMonth() + 1).toString().padStart(2, '0') + '-' + 
                                    now.getDate().toString().padStart(2, '0');
            }
        }, 1000);
    }
    
    startClock();

    // -----------------------------------------------------
    // Fullscreen Panels Logic
    // -----------------------------------------------------
    // -----------------------------------------------------
    // Fullscreen Panels Logic
    // -----------------------------------------------------
    window.toggleFsPanel = function(contentId, btn) {
        const content = document.getElementById(contentId);
        const icon = btn.querySelector('svg:last-child');
        
        // Check if currently closed
        if (content.classList.contains('max-h-0')) {
            // OPEN
            content.classList.remove('max-h-0', 'py-0', 'opacity-0');
            
            // Set specific max-heights based on ID
            if (contentId.includes('attack')) content.classList.add('max-h-[60vh]');
            else content.classList.add('max-h-[40vh]');
            
            content.classList.add('p-4', 'pt-2');
            
            // Rotate icon to point up (indicating it can be closed)
            icon.classList.add('rotate-180');
        } else {
            // CLOSE
            content.classList.remove('max-h-[60vh]', 'max-h-[40vh]', 'p-4', 'pt-2');
            content.classList.add('max-h-0', 'py-0', 'opacity-0');
            
            // Rotate icon to point down (indicating it can be opened)
            icon.classList.remove('rotate-180');
        }
    };

    // -----------------------------------------------------
    // Fullscreen Logic
    // -----------------------------------------------------
    const mapCard = document.getElementById('map-card');
    const btnFullscreen = document.getElementById('btn-fullscreen');
    const iconFullscreen = document.getElementById('icon-fullscreen');

    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            if (mapCard.requestFullscreen) {
                mapCard.requestFullscreen();
            } else if (mapCard.webkitRequestFullscreen) { /* Safari */
                mapCard.webkitRequestFullscreen();
            } else if (mapCard.msRequestFullscreen) { /* IE11 */
                mapCard.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }
        }
    }

    if (btnFullscreen) {
        btnFullscreen.addEventListener('click', toggleFullscreen);
    }

    // Keyboard shortcut 'F' for fullscreen
    document.addEventListener('keydown', function(e) {
        if (e.key.toLowerCase() === 'f' && !e.ctrlKey && !e.altKey && !e.shiftKey) {
            if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                toggleFullscreen();
            }
        }
    });

    const handleFullscreenChange = () => {
        if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
            mapCard.classList.add('is-fullscreen');
            iconFullscreen.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
        } else {
            mapCard.classList.remove('is-fullscreen');
            iconFullscreen.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />';
        }
        setTimeout(() => { if (chartInstance) chartInstance.resize(); }, 150);
    };

    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);

    // -----------------------------------------------------
    // Premium Theme Switcher Logic
    // -----------------------------------------------------
    window.setMapTheme = function(mode) {
        currentTheme = mode;
        localStorage.setItem('attack-map-theme', mode);
        
        // Update Slider UI
        const indicator = document.getElementById('theme-indicator');
        if (indicator) {
            indicator.style.transform = mode === 'dark' ? 'translateX(42px)' : 'translateX(0px)';
        }
        
        // Update Chart
        const theme = MAP_THEMES[mode];
        if (chartInstance) {
            chartInstance.setOption({
                backgroundColor: theme.ocean,
                geo: {
                    itemStyle: {
                        normal: {
                            areaColor: theme.land,
                            borderColor: theme.border
                        },
                        emphasis: {
                            areaColor: mode === 'dark' ? '#1e3a8a' : '#f1f5f9'
                        }
                    }
                }
            });
        }

        // Update card background for fullscreen surroundings
        const mapCard = document.getElementById('map-card');
        if (mapCard) {
            if (mode === 'dark') {
                mapCard.style.setProperty('background-color', theme.ocean, 'important');
                mapCard.classList.add('map-dark-theme');
            } else {
                mapCard.style.removeProperty('background-color');
                mapCard.classList.remove('map-dark-theme');
            }
        }
    };

    // Initialize UI on load
    setTimeout(() => {
        setMapTheme(currentTheme);
    }, 500);

    // -----------------------------------------------------
    // Ctrl + Interaction Requirement
    // -----------------------------------------------------
    const mapInteractionEl = document.getElementById('attack-map-container');
    const interactionOverlay = document.getElementById('map-interaction-overlay');
    let overlayTimeout;

    const showInteractionHint = () => {
        if (!interactionOverlay) return;
        interactionOverlay.classList.remove('opacity-0', 'pointer-events-none');
        interactionOverlay.classList.add('opacity-100');
        clearTimeout(overlayTimeout);
        overlayTimeout = setTimeout(() => {
            interactionOverlay.classList.remove('opacity-100');
            interactionOverlay.classList.add('opacity-0', 'pointer-events-none');
        }, 1500);
    };

    // Capture wheel events to block ECharts zoom if Ctrl is not held
    mapInteractionEl.addEventListener('wheel', (e) => {
        // Bypass if in fullscreen OR if Ctrl is held
        if (!document.fullscreenElement && !e.ctrlKey) {
            e.preventDefault();   // Prevent page scroll
            e.stopPropagation();  // Stop reaching ECharts
            showInteractionHint();
        }
    }, { capture: true, passive: false });

    // Capture mousedown to block ECharts pan if Ctrl is not held
    mapInteractionEl.addEventListener('mousedown', (e) => {
        // Bypass if in fullscreen OR if Ctrl is held
        // Only block for left mouse button
        if (e.button === 0 && !document.fullscreenElement && !e.ctrlKey) {
            e.stopPropagation();  // Stop reaching ECharts
            showInteractionHint();
        }
    }, { capture: true });

    // Initialize Map
    initMap();
    
    // Initial fetch after 1s
    setTimeout(refreshDashboardStats, 1000);
    
    // Poll every 12s (Slower poll to allow animations to play out and reduce server load)
    let dashboardPolling = setInterval(refreshDashboardStats, 12000);

    // Visibility Management: Stop polling when tab is inactive to save resources
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(dashboardPolling);
        } else {
            refreshDashboardStats();
            dashboardPolling = setInterval(refreshDashboardStats, 12000);
        }
    });
});
</script>
