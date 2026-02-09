<!-- =====================================================
     Article Management Page - Dark Mode Support
     ===================================================== -->
<?php 
// RBAC: Check if user can create/update/delete
$role = $this->session->userdata('role');
$can_crud = in_array($role, ['admin', 'management']);
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Artikel</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1"><?= $can_crud ? 'Kelola artikel dan konten informasi' : 'Lihat daftar artikel dan konten informasi' ?></p>
    </div>
    <?php if ($can_crud): ?>
    <button onclick="window.location.href='<?= base_url('admin/articles/create') ?>'" 
            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tulis Artikel
    </button>
    <?php endif; ?>
</div>




<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6" data-aos="fade-up">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-gray-900 dark:text-white"><?= count($articles) ?></div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Total Artikel</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-green-600 dark:text-green-400"><?= count(array_filter($articles, function($a) { return $a['status'] === 'published'; })) ?></div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Published</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-amber-600 dark:text-amber-400"><?= count(array_filter($articles, function($a) { return $a['status'] === 'draft'; })) ?></div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Draft</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">4</div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Kategori</div>
    </div>
</div>

<!-- Articles Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-24">Gambar</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Artikel</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                <?php foreach ($articles as $article): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-4">
                        <?php if(!empty($article['thumbnail'])): ?>
                            <img src="<?= base_url($article['thumbnail']) ?>" class="w-16 h-10 object-cover rounded-lg border border-gray-200 dark:border-slate-700" loading="lazy">
                        <?php else: ?>
                            <div class="w-16 h-10 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($article['title']) ?></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">oleh <?= htmlspecialchars($article['author']) ?></div>
                        </div>
                    </td>
                    <td class="px-6 py-     4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 dark:bg-blue-500/20 text-blue-600 dark:text-blue-300">
                            <?= htmlspecialchars($article['category']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($article['status'] === 'published'): ?>
                            <span class="flex items-center gap-1.5 text-green-600 dark:text-green-400 text-sm">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                Published
                            </span>
                        <?php else: ?>
                            <span class="flex items-center gap-1.5 text-amber-600 dark:text-amber-400 text-sm">
                                <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                Draft
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                        <?= date('d M Y H:i', strtotime($article['published_at'] ? $article['published_at'] : $article['created_at'])) . ' WIB' ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= base_url('artikel/' . $article['id']) ?>" target="_blank" 
                               class="p-2 text-gray-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/20 rounded-lg transition-colors" title="Lihat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <?php if ($can_crud): ?>
                            <a href="<?= base_url('admin/articles/edit/' . $article['id']) ?>" class="p-2 text-gray-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/20 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <a href="<?= base_url('admin/articles/delete/' . $article['id']) ?>" data-confirm="Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan." class="p-2 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
