<div class="space-y-6">
    <div class="flex items-center justify-between no-print" data-aos="fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Audit Log</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Rekam jejak aktivitas pengguna sistem</p>
        </div>
        <div>
            <button onclick="window.print()" class="px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm flex items-center gap-2 btn-press-anim">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Log
            </button>
        </div>
    </div>

    <!-- Print Background Image (Forced via IMG tag to ensure printing) -->
    <!-- Added time() to bust cache in case of previous 404 -->
    <img src="<?= base_url('assets/img/report_bg.jpg?v=' . time()) ?>" class="print-bg" alt="Background">

    <!-- Print Header (Visible only in print) -->
    <div class="hidden print-header mb-6">
        <h1 class="text-2xl font-bold text-blue-800 text-center uppercase mb-2">Laporan Audit Log</h1>
        <div class="flex justify-between text-sm text-gray-600 border-b-2 border-blue-800 pb-2">
            <div>Tanggal Cetak: <?= date('d F Y H:i:s') ?></div>
            <div>Dicetak Oleh: <?= $user['username'] ?? 'System' ?> (<?= isset($user['role']) ? ucfirst($user['role']) : '-' ?>)</div>
        </div>
        <?php if(isset($selected_date)): ?>
            <div class="mt-2 text-center font-semibold text-gray-800">
                Data Tanggal: <?= date('d F Y', strtotime($selected_date)) ?>
            </div>
        <?php endif; ?>
    </div>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            
            /* Print Background Logic - Adjusted */
            .print-bg {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: -1000; /* Ensure deeply behind */
                display: block !important;
            }

            /* FORCE RESET ALL OTHER BACKGROUNDS */
            html, body {
                background: transparent !important;
                height: 100%;
            }
            
            * {
                background-color: transparent !important;
                color: black !important;
                box-shadow: none !important;
                text-shadow: none !important;
            }

            body {
                /* Remove CSS background to avoid conflict/double */
                background: none !important;
                margin: 0 !important;
                /* content padding to fit inside letterhead design */
                padding: 40mm 15mm 20mm 15mm !important; 
                font-family: 'Arial', sans-serif !important;
            }

            /* Hide Strictly Non-Print */
            .no-print, nav, aside, .sidebar-scroll, header, .filter-section, button, footer, .fixed, .absolute, .print-hidden-col {
                display: none !important;
            }
            
            /* ... rest of existing styles ... */
            .bg-white, .dark\:bg-slate-800, .rounded-xl, .shadow-sm, .border, .p-4, .space-y-6, .overflow-hidden, .overflow-x-auto {
                background: none !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                border-radius: 0 !important;
                overflow: visible !important;
            }
            
            .overflow-x-auto {
                display: block !important;
                width: 100% !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
                border: 2px solid #1e3a8a !important;
                font-size: 11pt !important;
                margin-top: 20px !important;
            }
            
            thead tr {
                background-color: #1e3a8a !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            th {
                color: white !important;
                border: 1px solid black !important;
                padding: 8px 10px !important;
            }

            td {
                border: 1px solid black !important;
                padding: 6px 10px !important;
            }
            
            td:nth-child(1) { width: 140px; font-weight: bold; }
            /* td:nth-child(2) { display: none; } -- Logic changed: hide inner avatar, not cell */
            
            .rounded-full {
                background: none !important;
                color: black !important;
            }

            .print-header {
                display: block !important;
                margin-bottom: 20px !important;
                border-bottom: 2px solid #1e3a8a;
                padding-bottom: 10px;
            }
        }
        
        /* Hide print-bg on screen */
        @media screen {
            .print-bg { display: none; }
        }
    </style>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-wrap items-center no-print" data-aos="fade-up" data-aos-delay="50">
        <form action="<?= base_url('admin/audit-log') ?>" method="GET" class="flex items-center gap-3">
            <label for="date" class="text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Tanggal:</label>
            <input type="date" name="date" id="date" value="<?= isset($selected_date) ? $selected_date : date('Y-m-d') ?>" 
                   onchange="this.form.submit()"
                   class="px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all cursor-pointer">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-md shadow-blue-200 dark:shadow-none btn-press-anim">
                Tampilkan
            </button>
        </form>
        
        <?php if(isset($selected_date) && $selected_date !== date('Y-m-d')): ?>
            <div class="ml-auto">
                <a href="<?= base_url('admin/audit-log') ?>" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-all font-medium text-sm border border-slate-200 dark:border-slate-600 flex items-center gap-2 btn-press-anim">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kembali ke Hari Ini
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
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
                                        <!-- Avatar: Hide in Print -->
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden <?= (empty($log['avatar']) || $log['avatar'] === 'default_avatar.png') ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gray-100' ?> no-print">
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
