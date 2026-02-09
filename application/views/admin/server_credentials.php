<!-- =====================================================
     Server Credentials Management Page
     ===================================================== -->

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data IP dan Password</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola data server, IP, dan kredensial</p>
    </div>
    <a href="<?= base_url('admin/server_credentials_create') ?>" 
            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Data
    </a>
</div>

<!-- Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="overflow-x-auto">
            <table class="w-full table-fixed">
                <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700 sticky top-0 z-10 backdrop-blur-sm">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[5%] whitespace-nowrap">No</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[15%]">VM Name</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[12%]">IP Address</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[10%]">Username</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[10%]">Password</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[20%]">Keterangan</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[20%]">Domain</th>
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-[8%] whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    <?php 
                    $no = 1; 
                    $counter = 0;
                    foreach ($credentials as $item): 
                        $counter++;
                        $isHidden = $counter > 10;
                    ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors <?= $isHidden ? 'hidden row-hidden' : '' ?>">
                        <td class="px-3 py-3 text-sm text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap align-top"><?= $no++ ?></td>
                        <td class="px-3 py-3 text-sm text-gray-900 dark:text-white font-medium break-words align-top"><?= !empty($item['vm_name']) ? htmlspecialchars($item['vm_name']) : '<span class="text-gray-400">-</span>' ?></td>
                        <td class="px-3 py-3 text-sm text-gray-500 dark:text-gray-400 font-mono break-all align-top"><?= !empty($item['ip_address']) ? htmlspecialchars($item['ip_address']) : '<span class="text-gray-400">-</span>' ?></td>
                        <td class="px-3 py-3 text-sm text-gray-500 dark:text-gray-400 break-all align-top"><?= !empty($item['username']) ? htmlspecialchars($item['username']) : '<span class="text-gray-400">-</span>' ?></td>
                        <td class="px-3 py-3 text-sm text-gray-500 dark:text-gray-400 font-mono break-all align-top"><?= !empty($item['password']) ? htmlspecialchars($item['password']) : '<span class="text-gray-400">-</span>' ?></td>
                        <td class="px-3 py-3 text-sm text-gray-500 dark:text-gray-400 break-words align-top"><?= !empty($item['description']) ? htmlspecialchars($item['description']) : '<span class="text-gray-400">-</span>' ?></td>
                        <td class="px-3 py-3 text-sm text-gray-500 dark:text-gray-400 align-top">
                            <?php if(!empty($item['domain'])): ?>
                                <a href="<?= (strpos($item['domain'], 'http') === 0) ? $item['domain'] : 'https://' . $item['domain'] ?>" target="_blank" class="text-blue-600 hover:underline break-all">
                                    <?= htmlspecialchars($item['domain']) ?>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-3 text-right whitespace-nowrap align-top">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?= base_url('admin/server_credentials_edit/' . $item['id']) ?>" class="p-2 text-gray-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/20 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="<?= base_url('admin/server_credentials_delete/' . $item['id']) ?>" data-confirm="Apakah Anda yakin ingin menghapus data ini?" class="p-2 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>

    <?php if (count($credentials) > 10): ?>
    <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/30 border-t border-gray-100 dark:border-slate-700 text-center">
        <button id="btn-show-more" onclick="toggleRows()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
            <span>Lihat Selengkapnya (<?= count($credentials) - 10 ?> data lagi)</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
    </div>
    <script>
        function toggleRows() {
            const hiddenRows = document.querySelectorAll('.row-hidden');
            const btn = document.getElementById('btn-show-more');
            
            hiddenRows.forEach(row => {
                row.classList.remove('hidden');
            });
            
            // Hide button after showing all
            btn.style.display = 'none';
        }
    </script>
    <?php endif; ?>
</div>
