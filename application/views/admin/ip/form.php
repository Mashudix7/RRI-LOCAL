<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                <?= isset($ip['id']) ? 'Edit IP Address' : 'Tambah IP Address' ?>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">
                <?= isset($ip['id']) ? 'Update informasi penggunaan IP' : 'Daftarkan IP baru ke inventory' ?>
            </p>
        </div>
        <a href="<?= base_url('admin/ip_management') ?>" class="px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <form action="<?= isset($ip['id']) ? base_url('admin/ip_update/' . $ip['id']) : base_url('admin/ip_store') ?>" method="POST" class="p-6 md:p-8">
            
            <!-- Location (Hidden or Readonly if editing specific flow, but let's make it selectable) -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi data Center</label>
                <select name="location" class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow" required>
                    <?php 
                    $locations = ['DC Jakarta', 'DC PDN Serpong', 'Kantor Pusat', 'DC Depok'];
                    $currentLoc = $ip['location'] ?? '';
                    foreach ($locations as $loc): ?>
                        <option value="<?= $loc ?>" <?= $currentLoc == $loc ? 'selected' : '' ?>><?= $loc ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- IP Address -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IP Address</label>
                <input type="text" name="ip_address" value="<?= $ip['ip_address'] ?? '' ?>" class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow font-mono" placeholder="e.g., 218.33.123.1" required>
            </div>

            <!-- Description / Usage -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan / Penggunaan</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow" placeholder="Kosongkan jika IP tersedia/tidak digunakan"><?= $ip['description'] ?? '' ?></textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan field ini jika IP sedang 'Available' (Tersedia).</p>
            </div>

            <!-- Special Type -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Khusus</label>
                <div class="flex flex-wrap gap-4 mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="normal" <?= (!isset($ip['type']) || $ip['type'] == 'normal') ? 'checked' : '' ?> class="text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Normal (Host/Server)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="gateway" <?= (isset($ip['type']) && $ip['type'] == 'gateway') ? 'checked' : '' ?> class="text-yellow-600 focus:ring-yellow-500 border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Gateway / Router</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="reserve" <?= (isset($ip['type']) && $ip['type'] == 'reserve') ? 'checked' : '' ?> class="text-orange-600 focus:ring-orange-500 border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Reserve / Cadangan</span>
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-slate-700">
                <a href="<?= base_url('admin/ip_management') ?>" class="px-5 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors font-medium">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
