<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between group" data-aos="fade-down">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?= isset($vpn) ? 'Edit IP VPN' : 'Tambah IP VPN' ?></h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">
                <?= isset($vpn) ? 'Perbarui data VPN' : 'Entri data VPN baru' ?>
            </p>
        </div>
        <a href="<?= base_url('admin/vpn-management') ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up">
        
        <form action="<?= isset($vpn) ? base_url('admin/vpn-management/update/'.$vpn['id']) : base_url('admin/vpn-management/store') ?>" method="POST" class="p-6">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Satker -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nama Satker <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="satker" required
                           value="<?= isset($vpn) ? $vpn['satker'] : '' ?>"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Contoh: RRI Jakarta">
                </div>

                <!-- Network (LAN) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        IP Network (LAN)
                    </label>
                    <input type="text" name="ip_lan" 
                           value="<?= isset($vpn) ? $vpn['ip_lan'] : '' ?>"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono"
                           placeholder="Contoh: 192.168.1.0/24">
                </div>

                <!-- Gateway / IP VPN -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Gateway / IP Remote
                    </label>
                    <input type="text" name="ip_vpn" 
                           value="<?= isset($vpn) ? $vpn['ip_vpn'] : '' ?>"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono"
                           placeholder="Contoh: 172.16.6.1">
                </div>

                <!-- Status -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status Koneksi
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-slate-600 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20 has-[:checked]:border-emerald-500 transition-all">
                            <input type="radio" name="status" value="online" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500"
                                   <?= (isset($vpn) && $vpn['status'] == 'online') || !isset($vpn) ? 'checked' : '' ?>>
                            <span class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Terhubung (Online)
                            </span>
                        </label>
                        
                        <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-slate-600 has-[:checked]:bg-gray-100 dark:has-[:checked]:bg-slate-700 has-[:checked]:border-gray-500 transition-all">
                            <input type="radio" name="status" value="offline" class="w-4 h-4 text-gray-600 focus:ring-gray-500"
                                   <?= isset($vpn) && $vpn['status'] == 'offline' ? 'checked' : '' ?>>
                            <span class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Belum Terhubung (Offline)
                            </span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        * Merubah status menjadi Online akan memindahkan data ke tab <strong>Terhubung</strong>, dan sebaliknya.
                    </p>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                <button type="reset" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                    Reset
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>
