<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 mb-6 text-sm text-gray-500 dark:text-gray-400">
        <a href="<?= base_url('admin/ip_management/networks') ?>" class="hover:text-blue-600 dark:hover:text-blue-400">Kelola Network</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-semibold"><?= isset($network) ? 'Edit Network' : 'Tambah Network' ?></span>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 md:p-8">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6"><?= isset($network) ? 'Edit Data Network' : 'Tambah Network Baru' ?></h1>

        <form action="<?= isset($network) ? base_url('admin/ip_management/network_update/'.$network['id']) : base_url('admin/ip_management/network_store') ?>" method="POST" class="space-y-6">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            
            <?php if(!isset($network)): ?>
            <!-- ID/Slug (Only for create) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ID / Slug (Unik, lowercase)</label>
                <input type="text" name="id" required class="w-full px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white" placeholder="contoh: dc_surabaya">
            </div>
            <?php endif; ?>

            <!-- Nama Wilayah -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Wilayah / Network</label>
                <input type="text" name="name" value="<?= $network['name'] ?? '' ?>" required class="w-full px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white" placeholder="Contoh: DC Surabaya">
            </div>

            <!-- CIDR -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CIDR Block</label>
                <input type="text" name="cidr" value="<?= $network['cidr'] ?? '' ?>" required class="w-full px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white font-mono" placeholder="218.33.123.0/26">
                <p class="text-xs text-gray-500 mt-1">Format: x.x.x.x/xx</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- IP Start -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Range IP Awal</label>
                    <input type="text" name="range_start" value="<?= $network['range_start'] ?? '' ?>" required class="w-full px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white font-mono">
                </div>
                 <!-- IP End -->
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Range IP Akhir</label>
                    <input type="text" name="range_end" value="<?= $network['range_end'] ?? '' ?>" required class="w-full px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white font-mono">
                </div>
            </div>
             <!-- Subnet Mask -->
             <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subnet Mask</label>
                <input type="text" name="subnet_mask" value="<?= $network['subnet_mask'] ?? '' ?>" required class="w-full px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white font-mono">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white"><?= $network['description'] ?? '' ?></textarea>
            </div>

             <!-- Is Reserve? -->
            <div class="flex items-center gap-3 bg-gray-50 dark:bg-slate-900 p-3 rounded-lg border border-gray-200 dark:border-slate-700">
                <input type="checkbox" id="is_reserve" name="is_reserve" value="1" <?= (isset($network['is_reserve']) && $network['is_reserve']) ? 'checked' : '' ?> class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <label for="is_reserve" class="text-sm text-gray-700 dark:text-gray-300">Tandai sebagai Reserved / Cadangan</label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
                <a href="<?= base_url('admin/ip_management/networks') ?>" class="px-5 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Network
                </button>
            </div>
        </form>
    </div>
</div>
