<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white"><?= $title ?></h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Edit data server</p>
        </div>
        <a href="<?= base_url('admin/server_credentials') ?>" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Perbarui Informasi Kredensial
            </h3>
        </div>

        <div class="p-8">
            <?= form_open('admin/server_credentials/update/' . $credential['id'], ['class' => 'space-y-8']) ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <!-- VM Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Nama VM / Host</label>
                        <input type="text" name="vm_name" value="<?= htmlspecialchars($credential['vm_name']) ?>" required class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>
                    
                    <!-- IP Address -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">IP Address</label>
                        <input type="text" name="ip_address" value="<?= htmlspecialchars($credential['ip_address']) ?>" required class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono text-blue-600 dark:text-blue-400">
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Username</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($credential['username']) ?>" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono">
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Password</label>
                        <input type="text" name="password" value="<?= htmlspecialchars($credential['password']) ?>" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono text-red-600 dark:text-red-400">
                    </div>

                    <!-- Domain -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Domain / Subdomain</label>
                        <input type="text" name="domain" value="<?= htmlspecialchars($credential['domain']) ?>" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Deskripsi / Keterangan</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm"><?= htmlspecialchars($credential['description']) ?></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-8 border-t border-gray-100 dark:border-slate-700">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all btn-press-anim">
                        Update Data
                    </button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
