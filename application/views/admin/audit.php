<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Audit Log</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Rekam jejak aktivitas pengguna sistem</p>
        </div>
        <div>
            <button onclick="window.print()" class="px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Log
            </button>
        </div>
    </div>

    <!-- Filter Section (Optional) -->
    <!-- <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700">
        Filter controls here...
    </div> -->

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">
                        <th class="px-6 py-4 w-48">Waktu</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4 w-32">Role</th>
                        <th class="px-6 py-4">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    <?php if(empty($logs)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data log aktivitas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($logs as $log): ?>
                            <?php
                                // Role Color
                                $role_colors = [
                                    'admin' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                                    'management' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                    'auditor' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                    'analyst' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-300',
                                    'system' => 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-300'
                                ];
                                $userRole = $log['role'] ?? 'system';
                                $roleColor = $role_colors[$userRole] ?? 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-300';
                                
                                // displayName Logic
                                $displayName = !empty($log['username']) ? $log['username'] : 'System/Guest';
                                $displayRole = !empty($log['role']) ? $log['role'] : 'system';
                            ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-gray-600 dark:text-gray-400">
                                    <?php 
                                        $timestamp = strtotime($log['created_at']);
                                        echo ($timestamp && $timestamp > 0 && date('Y', $timestamp) > 1970) ? date('d M Y H:i:s', $timestamp) : '-';
                                    ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden <?= (empty($log['avatar']) || $log['avatar'] === 'default_avatar.png') ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gray-100' ?>">
                                            <?php if (!empty($log['avatar']) && $log['avatar'] !== 'default_avatar.png'): ?>
                                                <img src="<?= base_url('uploads/avatars/' . $log['avatar']) ?>" alt="<?= htmlspecialchars($displayName) ?>" class="w-full h-full object-cover" loading="lazy">
                                            <?php else: ?>
                                                <span class="text-white font-semibold"><?= strtoupper(substr($displayName, 0, 1)) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($displayName) ?></div>
                                            <!-- ID hidden for security -->
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $roleColor ?>">
                                        <?= ucfirst($displayRole) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm max-w-md truncate" title="<?= htmlspecialchars($log['details']) ?>">
                                    <?php
                                        // Clean details: Remove "ID: 123" pattern
                                        $cleanDetails = preg_replace('/ID: \d+/', '', $log['details']);
                                        echo htmlspecialchars(trim($cleanDetails));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination if implemented -->
        <div class="p-4 border-t border-gray-100 dark:border-slate-700 text-right">
             <span class="text-xs text-gray-400">Menampilkan 100 aktivitas terakhir</span>
        </div>
    </div>
</div>
