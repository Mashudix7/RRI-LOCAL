<div class="min-h-[80vh] flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-slate-700">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="inline-flex w-16 h-16 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Halaman Terkunci</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Masukkan kata sandi untuk mengakses halaman Data IP & Password.</p>
            </div>
            
            <?php if($this->session->flashdata('error')): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm text-center">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/server_credentials/unlock') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi / Kode Pemulihan</label>
                    <input type="password" name="password" required autofocus class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500 text-center text-lg tracking-wider" placeholder="••••••••">
                </div>

                <div class="text-xs text-center text-gray-400">
                    <p>Lupa kata sandi? Masukkan Kode Pemulihan Anda di atas.</p>
                </div>

                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Buka Kunci
                </button>
            </form>
        </div>
    </div>
</div>
