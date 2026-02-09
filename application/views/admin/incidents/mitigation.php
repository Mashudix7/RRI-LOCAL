<!-- =====================================================
     Incident Mitigation
     Tahap 5: Mitigasi & Containment
     ===================================================== -->
<div class="max-w-6xl mx-auto p-6">
    <!-- Stepper -->
    <?php $active_step = 5; include APPPATH . 'views/admin/incidents/flow_stepper.php'; ?>

    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar Info -->
        <div class="col-span-12 md:col-span-4 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Ringkasan Investigasi</h3>
                <div class="space-y-4">
                    <div class="p-3 bg-red-50 dark:bg-red-500/10 rounded-lg border border-red-100 dark:border-red-500/20">
                        <span class="block text-xs text-red-600 dark:text-red-400 font-bold uppercase">Root Cause Identified</span>
                        <p class="text-sm text-gray-800 dark:text-white mt-1 font-medium">Weak Authentication on Admin Panel</p>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Impact:</strong> Multiple failed login attempts & unauthorized file upload.
                    </p>
                </div>
            </div>
        </div>

        <!-- Mitigation Form -->
        <div class="col-span-12 md:col-span-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/30">
                    <h2 class="font-semibold text-gray-800 dark:text-white">Tindakan Mitigasi & Containment</h2>
                </div>

                <form action="#" class="p-6 space-y-6">
                    
                    <!-- Mitigation Checklist -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Checklist Tindakan</label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border border-gray-200 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Blokir IP Address Attacker</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Isolasi Server / Layanan Terdampak</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Reset Password Akun Terkompromi</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Patching Vulnerability / Update Sistem</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Pembersihan Malware / Backdoor</span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Log -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Tindakan Tambahan</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" 
                            placeholder="Catat tindakan spesifik lain yang dilakukan..."></textarea>
                    </div>

                    <!-- Status Update -->
                    <div class="p-4 bg-yellow-50 dark:bg-yellow-500/10 rounded-lg border border-yellow-200 dark:border-yellow-500/20">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="contained" class="w-5 h-5 text-yellow-600 rounded border-gray-300 focus:ring-yellow-500">
                            <label for="contained" class="font-medium text-gray-800 dark:text-white">Konfirmasi: Insiden telah terkendali (Contained)?</label>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 ml-8">Centang ini jika ancaman aktif telah dihentikan dan tidak menyebar lagi.</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <a href="<?= base_url('admin/incident_investigation/'.$incident['id']) ?>" class="px-5 py-2.5 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition-colors">
                            &larr; Kembali
                        </a>
                        <a href="<?= base_url('admin/incident_recovery/'.$incident['id']) ?>" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                            Selesai Mitigasi & Lanjut Recovery
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
