<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Knowledge Base</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola panduan dan SOP</p>
        </div>
        <a href="<?= base_url('admin/knowledgebase/create') ?>" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Panduan
        </a>
    </div>


    
    <!-- Table Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Judul</th>
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Dibuat</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    <?php if (empty($kb_articles)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Belum ada panduan. Silakan tambah baru.
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($kb_articles as $kb): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900 dark:text-white block"><?= html_escape($kb['title']) ?></span>
                                <span class="text-xs text-gray-500 truncate block max-w-xs"><?= base_url('panduan/' . $kb['slug']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    <?= html_escape($kb['category']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($kb['is_public']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Publik
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-300">
                                        Internal
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                <?= date('d M Y', strtotime($kb['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/knowledgebase/edit/' . $kb['id']) ?>" 
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <a href="<?= base_url('admin/knowledgebase/delete/' . $kb['id']) ?>" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus"
                                            data-confirm="Apakah Anda yakin ingin menghapus panduan ini?">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </a>
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

<!-- Delete Modal using Standard one (assuming accessible globally or include script) -->

