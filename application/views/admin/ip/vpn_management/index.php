<?php 
// RBAC: Check if user can edit
$role = $this->session->userdata('role');
$can_edit = in_array($role, ['superadmin', 'admin', 'management']);
?>
<div class="space-y-6">

    <!-- Header & Summary Cards (Preserved) -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4" data-aos="fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen IP VPN</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Daftar IP VPN Tunnel & LAN Satker Radio Republik Indonesia</p>
        </div>
    </div>

    <!-- Stats Cards (Preserved for Fast Count Animation) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up">
        <!-- Card 1: Total VPN -->
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Satker VPN</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1" data-count-up="<?= isset($vpns) ? count($vpns) : 0 ?>"><?= isset($vpns) ? count($vpns) : 0 ?></p>
                </div>
            </div>
        </div>

        <!-- Card 2: Online Status -->
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Online Now</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1" data-count-up="<?= $stats['online'] ?? 0 ?>"><?= $stats['online'] ?? 0 ?></p>
                    <div class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active Connections
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Offline Status -->
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl text-red-600 dark:text-red-400">
                    <svg class="w-6 h-6" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Not Connected</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1" data-count-up="<?= $stats['offline'] ?? 0 ?>"><?= $stats['offline'] ?? 0 ?></p>
                </div>
            </div>
        </div>
    </div>


    <!-- MAIN TABLE SECTION (Re-designed to match Public IP Detail Layout) -->
    <div class="bg-slate-900 rounded-xl border border-slate-700 shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        
        <!-- Toolbar -->
        <div class="p-5 border-b border-slate-700 bg-slate-800/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <!-- Title Block -->
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                    <svg class="w-5 h-5 text-blue-400" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Alokasi IP Private</h2>
                    <div class="flex items-center gap-2 text-sm text-slate-400">
                        <span class="px-2 py-0.5 rounded bg-slate-800 border border-slate-600 font-mono text-xs">LAN & VPN</span>
                        <span>•</span>
                        <span><?= isset($vpns) ? count($vpns) : 0 ?> Total Satker</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 w-full sm:w-auto" x-data="{ search: '' }">
                <div class="relative flex-1 sm:flex-initial">
                    <input type="text" x-model="search" @input="$dispatch('search-table', search)" placeholder="Cari Satker atau IP..." 
                           class="w-full sm:w-64 pl-9 pr-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-sm text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <?php if ($can_edit): ?>
                <a href="<?= base_url('admin/vpn-management/create') ?>" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-lg transition-all shadow-md flex items-center gap-2 btn-press-anim">
                    <svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </a>
                <?php endif; ?>

                <button class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition-colors border border-slate-600 flex items-center gap-2 btn-press-anim">
                    <svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="vpnTable">
                <thead>
                    <tr class="bg-slate-800/50 border-b border-slate-700 text-xs uppercase text-slate-400 font-bold tracking-wider">
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4">Daerah / Unit</th>
                        <th class="px-6 py-4">Network (LAN)</th>
                        <th class="px-6 py-4">Gateway / IP Remote</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50 block-search-list">
                    <?php if (empty($vpns)): ?>
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500 italic">Tidak ada data IP VPN.</td></tr>
                    <?php else: ?>
                        <?php $no=1; foreach ($vpns as $vpn): ?>
                        <tr class="group hover:bg-slate-800/60 transition-colors bg-slate-900 text-sm search-item" 
                            data-search="<?= strtolower($vpn['satker'] . ' ' . $vpn['ip_lan'] . ' ' . $vpn['ip_vpn']) ?>">
                            
                            <td class="px-6 py-4 text-center text-slate-500 font-mono"><?= $no++ ?></td>
                            
                            <td class="px-6 py-4">
                                <div class="font-bold text-white mb-0.5"><?= !empty($vpn['satker']) ? $vpn['satker'] : '<span class="text-slate-500 italic">No Name</span>' ?></div>
                            </td>
                            
                            <td class="px-6 py-4 font-mono text-emerald-400">
                                <?= !empty($vpn['ip_lan']) ? $vpn['ip_lan'] : '<span class="text-slate-600">---</span>' ?>
                            </td>
                            
                            <td class="px-6 py-4 font-mono text-blue-400">
                                <?= !empty($vpn['ip_vpn']) ? $vpn['ip_vpn'] : '<span class="text-slate-600">---</span>' ?>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <?php if($vpn['status'] === 'online'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-700/50 text-slate-400 border border-slate-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <?php if ($can_edit): ?>
                                    <a href="<?= base_url('admin/vpn-management/edit/'.$vpn['id']) ?>" class="p-1.5 text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 rounded-lg transition-colors border border-transparent hover:border-blue-500/30" title="Edit">
                                        <svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <a href="<?= base_url('admin/vpn-management/delete/'.$vpn['id']) ?>" 
                                       class="p-1.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors border border-transparent hover:border-red-500/30" 
                                       title="Hapus"
                                       data-confirm="Apakah Anda yakin ingin menghapus data VPN satker <?= $vpn['satker'] ?>?">
                                        <svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (Static for now, but design implies it) -->
        <div class="p-4 border-t border-slate-700 bg-slate-800/30 flex items-center justify-between text-xs text-slate-400">
            <div>Menampilkan 1-<?= count($vpns) ?> dari <?= count($vpns) ?> data</div>
            <div class="flex gap-1">
                <button class="px-3 py-1 bg-slate-800 border border-slate-600 rounded hover:bg-slate-700 disabled:opacity-50" disabled>Previous</button>
                <button class="px-3 py-1 bg-slate-800 border border-slate-600 rounded hover:bg-slate-700 disabled:opacity-50" disabled>Next</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    // Basic Client-Side Search
    const searchInput = document.querySelector('input[placeholder="Cari Satker atau IP..."]');
    if(searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.search-item');
            
            rows.forEach(row => {
                const text = row.getAttribute('data-search');
                if(text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
