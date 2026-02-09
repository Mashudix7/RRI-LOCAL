<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit IP Address</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Konfigurasi penggunaan IP Address.</p>
        </div>
        <a href="javascript:history.back()" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 max-w-2xl">
        <?= form_open('admin/ip_update') ?>
            <input type="hidden" name="network_id" value="<?= isset($ip['network_id']) ? $ip['network_id'] : $this->input->get('network_id') ?>">
            
            <div class="grid gap-6">
                <!-- IP Address (Read Only) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">IP Address</label>
                    <input type="text" name="ip_address" value="<?= $ip['ip_address'] ?>" readonly 
                           class="w-full px-4 py-2 bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg text-gray-500 cursor-not-allowed font-mono">
                    <p class="text-xs text-gray-400 mt-1">IP Address tidak dapat diubah.</p>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Keterangan / Penggunaan</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white placeholder-gray-400"
                              placeholder="Contoh: Server Web Portal, Gateway Router, dll."><?= isset($ip['description']) ? $ip['description'] : '' ?></textarea>
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika IP tidak digunakan/inactive (Otomatis: Available for allocation).</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipe Penggunaan</label>
                        <select name="type" class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white">
                            <option value="public" <?= (isset($ip['type']) && $ip['type'] == 'public') ? 'selected' : '' ?>>Public Host</option>
                            <option value="gateway" <?= (isset($ip['type']) && $ip['type'] == 'gateway') ? 'selected' : '' ?>>Gateway</option>
                            <option value="private" <?= (isset($ip['type']) && $ip['type'] == 'private') ? 'selected' : '' ?>>Private/Local</option>
                            <option value="broadcast" <?= (isset($ip['type']) && $ip['type'] == 'broadcast') ? 'selected' : '' ?>>Broadcast</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white">
                            <option value="active" <?= (isset($ip['status']) && $ip['status'] == 'active') ? 'selected' : '' ?>>Active (Digunakan)</option>
                            <option value="inactive" <?= (isset($ip['status']) && $ip['status'] == 'inactive') ? 'selected' : '' ?>>Inactive (Kosong)</option>
                        </select>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-lg shadow-blue-500/30 transition-all transform hover:scale-[1.02]">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>
