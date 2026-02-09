<!-- =====================================================
     Reports Page - Security & Audit Dashboard
     ===================================================== -->

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan & Statistik Keamanan</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Ringkasan aktivitas sistem dan performa keamanan</p>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none" data-aos="fade-up" data-aos-delay="0">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($stats['total_users'] ?? 0) ?></div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Pengguna</div>
            </div>
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none" data-aos="fade-up" data-aos-delay="100">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-3xl font-bold text-green-600 dark:text-green-400"><?= number_format($stats['successful_logins'] ?? 0) ?></div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Login Berhasil</div>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none" data-aos="fade-up" data-aos-delay="200">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-3xl font-bold text-red-600 dark:text-red-400"><?= number_format($stats['failed_logins'] ?? 0) ?></div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Login Gagal</div>
            </div>
            <div class="w-12 h-12 bg-red-100 dark:bg-red-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none" data-aos="fade-up" data-aos-delay="300">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400"><?= number_format($stats['active_sessions'] ?? 0) ?></div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sesi Aktif</div>
            </div>
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Placeholder -->
<div class="grid lg:grid-cols-2 gap-6 mb-8" data-aos="fade-up" data-aos-delay="400">
    <!-- Login Activity by Day -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aktivitas Login (7 Hari Terakhir)</h3>
        <div class="h-64 bg-gray-50 dark:bg-slate-700/50 rounded-lg flex items-center justify-center">
            <div class="text-center text-gray-400 dark:text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p>Chart akan ditampilkan di sini</p>
                <p class="text-sm">(Integrasi Chart.js)</p>
            </div>
        </div>
    </div>
    
    <!-- Audit Log Activity -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aktivitas Audit Log</h3>
        <div class="h-64 bg-gray-50 dark:bg-slate-700/50 rounded-lg flex items-center justify-center">
            <div class="text-center text-gray-400 dark:text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <p>Pie Chart akan ditampilkan di sini</p>
                <p class="text-sm">(Integrasi Chart.js)</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none mb-8" data-aos="fade-up" data-aos-delay="500">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aktivitas Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-slate-700">
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Waktu</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Pengguna</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($recent_activity) && !empty($recent_activity)): ?>
                    <?php foreach ($recent_activity as $activity): ?>
                    <tr class="border-b border-gray-100 dark:border-slate-700/50 hover:bg-gray-50 dark:hover:bg-slate-700/30">
                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                            <?= date('d M Y H:i', strtotime($activity['created_at'])) ?>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-900 dark:text-white">
                            <?= htmlspecialchars($activity['username'] ?? 'System') ?>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                            <?= htmlspecialchars($activity['action']) ?>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                                Success
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">
                            Belum ada aktivitas
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Export Options -->
<div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none" data-aos="fade-up" data-aos-delay="600">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Export Laporan</h3>
    <div class="flex flex-wrap gap-3">
        <button class="px-4 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>
            </svg>
            Export Excel
        </button>
        <button class="px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>
            </svg>
            Export PDF
        </button>
        <button class="px-4 py-2.5 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print
        </button>
    </div>
</div>
