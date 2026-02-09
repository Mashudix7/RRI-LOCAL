<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Evidence Locker</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Penyimpanan bukti digital aman</p>
        </div>
        <a href="<?= base_url('admin/evidence/upload') ?>" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors shadow-lg shadow-indigo-500/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Upload Bukti
        </a>
    </div>


    
    <!-- Table Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Ref No.</th>
                        <th class="px-6 py-4 font-semibold">Judul / File</th>
                        <th class="px-6 py-4 font-semibold">Hash (SHA-256)</th>
                        <th class="px-6 py-4 font-semibold">Uploader</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    <?php if (empty($evidence_list)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Belum ada bukti digital yang diunggah.
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($evidence_list as $ev): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                <?= html_escape($ev['case_ref_no']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900 dark:text-white block"><?= html_escape($ev['title']) ?></span>
                                <span class="text-xs text-indigo-600 dark:text-indigo-400 font-mono block"><?= html_escape($ev['original_name']) ?></span>
                                <span class="text-[10px] text-gray-400 block"><?= number_format($ev['file_size'] / 1024, 2) ?> KB</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1 group cursor-pointer" onclick="navigator.clipboard.writeText('<?= $ev['file_hash'] ?>'); alert('Hash copied!');">
                                    <code class="text-[10px] bg-gray-100 dark:bg-slate-700 px-1 py-0.5 rounded text-gray-600 dark:text-gray-300 truncate w-24 block">
                                        <?= substr($ev['file_hash'], 0, 16) ?>...
                                    </code>
                                    <svg class="w-3 h-3 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs">
                                <?= html_escape($ev['uploader']) ?>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs">
                                <?= date('d/m/Y H:i', strtotime($ev['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/evidence/download/' . $ev['id']) ?>" 
                                       class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                       title="Download Securely">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                    
                                    <?php if($this->session->userdata('role') === 'admin'): ?>
                                    <a href="<?= base_url('admin/evidence/delete/' . $ev['id']) ?>" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Permanently Delete"
                                            data-confirm="PERINGATAN: File bukti akan dihapus permanen dari server. Tindakan ini tidak dapat dibatalkan. Lanjutkan?">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    </div>
</div>


