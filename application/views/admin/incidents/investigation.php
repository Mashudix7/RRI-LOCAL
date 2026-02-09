<!-- =====================================================
     Incident Investigation
     Tahap 4: Investigasi Teknis
     ===================================================== -->
<div class="max-w-6xl mx-auto p-6">
    <!-- Stepper -->
    <?php $active_step = 4; include APPPATH . 'views/admin/incidents/flow_stepper.php'; ?>

    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar Info -->
        <div class="col-span-12 md:col-span-4 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Tim Investigasi</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="w-10 h-10 rounded-full" alt="PIC" loading="lazy">
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Budi Santoso</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">Incident Handler (PIC)</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100 dark:border-slate-700">
                        <p class="text-xs text-gray-500 mb-2">Support Teams:</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-1 text-xs bg-gray-100 dark:bg-slate-700 rounded text-gray-600 dark:text-gray-300">Tim Server</span>
                            <span class="px-2 py-1 text-xs bg-gray-100 dark:bg-slate-700 rounded text-gray-600 dark:text-gray-300">Tim Keamanan</span>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100 dark:border-slate-700">
                        <p class="text-xs text-gray-500 mb-1">Target SLA:</p>
                        <p class="text-sm font-mono text-red-500 font-bold">03:45:00 Remaining</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Investigation Dashboard -->
        <div class="col-span-12 md:col-span-8 space-y-6">
            <!-- Evidence Collection -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/30">
                    <h2 class="font-semibold text-gray-800 dark:text-white">Pengumpulan Bukti & Log</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Upload Area -->
                    <div class="border-2 border-dashed border-gray-200 dark:border-slate-600 rounded-lg p-6 text-center bg-gray-50 dark:bg-slate-900">
                        <input type="file" id="evidence_upload" class="hidden" multiple>
                        <label for="evidence_upload" class="cursor-pointer">
                            <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <span class="text-sm font-medium text-blue-600 hover:text-blue-500">Upload Log / Screenshot</span>
                            <p class="text-xs text-gray-500 mt-1">Syslog, Pcap, Access Logs, dll.</p>
                        </label>
                    </div>
                    
                    <!-- Evidence List (Mock) -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Bukti Tersimpan (2)</h4>
                        <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-700 border border-gray-100 dark:border-slate-600 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="p-2 bg-red-100 text-red-600 rounded text-xs font-mono">LOG</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">access_log_20251010.txt</p>
                                    <p class="text-xs text-gray-500">Uploaded by System • 2MB</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-blue-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analysis Form -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/30">
                    <h2 class="font-semibold text-gray-800 dark:text-white">Analisa Teknis & Root Cause</h2>
                </div>
                <form action="#" class="p-6 space-y-6">
                    
                    <!-- Root Cause -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Akar Penyebab (Root Cause)</label>
                        <select class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white mb-3">
                            <option value="">Belum ditentukan...</option>
                            <option value="vuln">Vulnerability pada Aplikasi</option>
                            <option value="weak_auth">Weak Authentication / Credential Leak</option>
                            <option value="human">Human Error / Misconfiguration</option>
                            <option value="zero_day">Zero Day Exploit</option>
                            <option value="ddos">DDoS Attack</option>
                        </select>
                        <textarea rows="5" class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" 
                            placeholder="Detail teknis analisa: Bagaimana serangan terjadi, payload yang digunakan, IP attacker, dll..."></textarea>
                    </div>

                    <!-- Impact Scope -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Scope Dampak (Update)</label>
                        <input type="text" value="<?= $incident['affected_systems'] ?>" class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <a href="<?= base_url('admin/incident_assignment/'.$incident['id']) ?>" class="px-5 py-2.5 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition-colors">
                            &larr; Kembali
                        </a>
                        <a href="<?= base_url('admin/incident_mitigation/'.$incident['id']) ?>" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                            Simpan Hasil & Lanjut Mitigasi
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
