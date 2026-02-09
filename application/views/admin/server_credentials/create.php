<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white"><?= $title ?></h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tambah data server baru</p>
        </div>
        <a href="<?= base_url('admin/server_credentials') ?>" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Formulir Entry Data
            </h3>
        </div>

        <div class="p-8">
            <?= form_open('admin/server_credentials/store', ['class' => 'space-y-8']) ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <!-- VM Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Nama VM / Host</label>
                        <input type="text" name="vm_name" required placeholder="Contoh: Core-Server-01" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>
                    
                    <!-- IP Address -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">IP Address</label>
                        <input type="text" name="ip_address" required placeholder="0.0.0.0" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono text-blue-600 dark:text-blue-400">
                    </div>

                    <!-- Domain -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Domain / Subdomain</label>
                        <input type="text" name="domain" placeholder="example.rri.co.id" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Username</label>
                        <input type="text" name="username" placeholder="root / admin" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono">
                    </div>
                    
                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Password</label>
                        <input type="text" name="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono text-red-600 dark:text-red-400">
                    </div>
                    
                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Deskripsi / Keterangan</label>
                        <textarea name="description" rows="4" placeholder="Keterangan tambahan mengenai server ini..." class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-slate-600 bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-8 border-t border-gray-100 dark:border-slate-700">
                    <button type="reset" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors font-medium btn-press-anim">
                        Reset
                    </button>
                    <button type="submit" class="px-8 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all btn-press-anim">
                        Simpan Data
                    </button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
