<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola Daftar Network</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Tambah, edit, atau hapus network wilayah IP Publik.</p>
        </div>
        <a href="<?= base_url('admin/ip_management/network_create') ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Network
        </a>
    </div>

    <!-- Alert -->


    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama Network</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">CIDR</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Range IP</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Keterangan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    <?php if(empty($networks)): ?>
                    <tr>
                         <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data network.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($networks as $net): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            <?= $net['name'] ?>
                            <?php if(isset($net['is_reserve']) && $net['is_reserve']): ?>
                                <span class="ml-2 px-2 py-0.5 rounded text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Reserved</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 font-mono text-sm text-blue-600 dark:text-blue-400"><?= $net['cidr'] ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                           <div class="font-mono"><?= $net['range_start'] ?> -</div>
                           <div class="font-mono"><?= $net['range_end'] ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            <?= $net['description'] ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?= base_url('admin/ip_management/network_edit/'.$net['id']) ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                <span class="text-gray-300">|</span>
                                <a href="<?= base_url('admin/ip_management/network_delete/'.$net['id']) ?>" data-confirm="Apakah Anda yakin ingin menghapus network ini?" class="text-red-500 hover:text-red-700 font-medium text-sm">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
