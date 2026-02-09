<!-- =====================================================
     Incident Recovery
     Tahap 6: Pemulihan & Penutupan
     ===================================================== -->
<div class="max-w-6xl mx-auto p-6">
    <!-- Stepper -->
    <?php $active_step = 6; include APPPATH . 'views/admin/incidents/flow_stepper.php'; ?>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden text-center p-12">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Pemulihan Layanan</h2>
        <p class="text-gray-500 dark:text-gray-400 max-w-lg mx-auto mb-8">
            Pastikan seluruh layanan telah beroperasi normal kembali sebelum menutup tiket ini secara permanen.
        </p>

        <div class="max-w-2xl mx-auto text-left bg-gray-50 dark:bg-slate-700/30 rounded-lg p-8 border border-gray-200 dark:border-slate-600 mb-8">
            <h4 class="font-semibold text-gray-800 dark:text-white mb-4">Checklist Pemulihan:</h4>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="ml-3 text-gray-700 dark:text-gray-300">Verifikasi layanan dapat diakses user</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="ml-3 text-gray-700 dark:text-gray-300">Monitoring pasca-insiden aktif dan stabil</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="ml-3 text-gray-700 dark:text-gray-300">Tidak ada anomali traffic lanjutan</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="ml-3 text-gray-700 dark:text-gray-300">Backup data terakhir aman</span>
                </label>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-600">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Penutupan (Lessons Learned)</label>
                <textarea rows="3" class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" placeholder="Pelajaran yang bisa diambil..."></textarea>
            </div>
        </div>

        <div class="flex justify-center gap-4">
            <a href="<?= base_url('admin/incident_mitigation/'.$incident['id']) ?>" class="px-6 py-3 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition-colors">
                Kembali ke Mitigasi
            </a>
            <a href="<?= base_url('admin/incidents') ?>" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-xl shadow-green-500/30 transition-all transform hover:-translate-y-1 inline-block">
                Tutup Tiket (Resolved)
            </a>
        </div>
    </div>
</div>
