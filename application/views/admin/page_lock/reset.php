<div class="min-h-[80vh] flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-slate-700">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="inline-flex w-16 h-16 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reset Kata Sandi</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Kode pemulihan diterima. Silakan buat kata sandi baru.</p>
            </div>
            
            <form action="<?= base_url('admin/server_credentials/reset_password') ?>" method="POST" class="space-y-6">
                <input type="hidden" name="recovery_token" value="<?= $recovery_token ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" required class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500" placeholder="Kata sandi baru">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="confirm_password" required class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500" placeholder="Ulangi kata sandi">
                </div>

                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Reset & Buka Kunci
                </button>
            </form>
        </div>
    </div>
</div>
