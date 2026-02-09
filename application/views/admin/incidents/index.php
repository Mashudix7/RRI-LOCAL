<!-- =====================================================
     Incidents List View
     Daftar insiden dengan filter dan search
     ===================================================== -->

<!-- Filter Bar -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 p-4 mb-6">
    <form method="GET" action="<?= base_url('incidents') ?>" class="flex flex-col lg:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>"
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white placeholder-gray-400"
                       placeholder="Cari insiden...">
            </div>
        </div>
        
        <!-- Status Filter -->
        <div class="w-full lg:w-48">
            <select name="status" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                <option value="">Semua Status</option>
                <option value="reported" <?= ($filter_status ?? '') == 'reported' ? 'selected' : '' ?>>Dilaporkan</option>
                <option value="validated" <?= ($filter_status ?? '') == 'validated' ? 'selected' : '' ?>>Divalidasi</option>
                <option value="in_progress" <?= ($filter_status ?? '') == 'in_progress' ? 'selected' : '' ?>>Ditangani</option>
                <option value="mitigated" <?= ($filter_status ?? '') == 'mitigated' ? 'selected' : '' ?>>Dimitigasi</option>
                <option value="recovered" <?= ($filter_status ?? '') == 'recovered' ? 'selected' : '' ?>>Dipulihkan</option>
                <option value="closed" <?= ($filter_status ?? '') == 'closed' ? 'selected' : '' ?>>Ditutup</option>
            </select>
        </div>
        
        <!-- Severity Filter -->
        <div class="w-full lg:w-48">
            <select name="severity" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                <option value="">Semua Severity</option>
                <option value="critical" <?= ($filter_severity ?? '') == 'critical' ? 'selected' : '' ?>>Critical</option>
                <option value="high" <?= ($filter_severity ?? '') == 'high' ? 'selected' : '' ?>>High</option>
                <option value="medium" <?= ($filter_severity ?? '') == 'medium' ? 'selected' : '' ?>>Medium</option>
                <option value="low" <?= ($filter_severity ?? '') == 'low' ? 'selected' : '' ?>>Low</option>
            </select>
        </div>
        
        <!-- Filter Button -->
        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            Filter
        </button>
    </form>
</div>

<!-- Incidents Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Insiden</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Severity</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pelapor</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                <?php $no = 1; ?>
                <?php if (!empty($incidents)): ?>
                    <?php foreach ($incidents as $incident): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-900 dark:text-white"><?= $no++ ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="<?= base_url('incidents/' . $incident['id']) ?>" 
                                   class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    <?= htmlspecialchars($incident['title']) ?>
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?= ucfirst(str_replace('_', ' ', $incident['category'])) ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full badge-<?= $incident['severity'] ?>">
                                    <?= ucfirst($incident['severity']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $status_labels = [
                                    'reported' => 'Dilaporkan',
                                    'validated' => 'Divalidasi',
                                    'in_progress' => 'Ditangani',
                                    'mitigated' => 'Dimitigasi',
                                    'recovered' => 'Dipulihkan',
                                    'closed' => 'Ditutup'
                                ];
                                ?>
                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full badge-<?= $incident['status'] ?>">
                                    <?= $status_labels[$incident['status']] ?? $incident['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?= htmlspecialchars($incident['reporter']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500 dark:text-gray-400"><?= date('d M Y', strtotime($incident['created_at'])) ?></span>
                                <p class="text-xs text-gray-400 dark:text-gray-500"><?= date('H:i', strtotime($incident['created_at'])) ?></p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/incident_triage/' . $incident['id']) ?>" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm"
                                       title="Proses Insiden">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                        <span>Proses</span>
                                    </a>
                                    <a href="<?= base_url('incidents/' . $incident['id']) ?>" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                        <span>Detail</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada insiden yang ditemukan.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination placeholder -->
    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 flex items-center justify-between">
        <p class="text-sm text-gray-500 dark:text-gray-400">Menampilkan <?= count($incidents ?? []) ?> insiden</p>
        <div class="flex gap-2">
            <!-- Pagination akan ditambahkan setelah database terintegrasi -->
        </div>
    </div>
</div>
