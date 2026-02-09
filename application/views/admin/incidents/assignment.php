<!-- =====================================================
     Incident Assignment
     Tahap 3: Penunjukan Personil
     ===================================================== -->
<div class="max-w-6xl mx-auto p-6">
    <!-- Stepper -->
    <?php $active_step = 3; include APPPATH . 'views/admin/incidents/flow_stepper.php'; ?>

    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar Info -->
        <div class="col-span-12 md:col-span-4 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Ringkasan Validasi</h3>
                <div class="space-y-4">
                    <div class="p-3 bg-green-50 dark:bg-green-500/10 rounded-lg border border-green-100 dark:border-green-500/20">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-semibold text-green-700 dark:text-green-500">Incident Valid</span>
                        </div>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1 ml-7">Divalidasi oleh Administrator</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                            <span class="block text-xs text-gray-400">Severity</span>
                            <span class="font-bold text-red-500"><?= $incident['severity'] ?></span>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                            <span class="block text-xs text-gray-400">Kategori</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300"><?= $incident['category'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignment Form -->
        <div class="col-span-12 md:col-span-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/30">
                    <h2 class="font-semibold text-gray-800 dark:text-white">Penugasan Tim & SLA</h2>
                </div>

                <form action="#" class="p-6 space-y-6">
                    <!-- PIC Assignment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PIC Utama (Handler)</label>
                        <select class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                            <option value="">Pilih Incident Handler...</option>
                            <option value="1">Budi Santoso (Network Lead)</option>
                            <option value="2">Siti Aminah (Security Analyst)</option>
                            <option value="3">Rudi Hermawan (SysAdmin)</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Orang yang bertanggung jawab penuh atas penyelesaian insiden.</p>
                    </div>

                    <!-- Support Teams -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tim Pendukung</label>
                        <div class="grid grid-cols-2 gap-3">
                            <?php foreach ($teams as $key => $label): ?>
                            <label class="flex items-center p-3 border border-gray-200 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer">
                                <input type="checkbox" name="teams[]" value="<?= $key ?>" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300"><?= $label ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- SLA & Target -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-900/30">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h4 class="font-semibold text-blue-800 dark:text-blue-300">Target Penyelesaian (SLA)</h4>
                                <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                                    Berdasarkan severity <strong><?= $incident['severity'] ?></strong>, target penyelesaian adalah <strong>4 Jam</strong>.
                                </p>
                                <div class="mt-3">
                                    <label class="text-xs font-semibold text-blue-700 dark:text-blue-300">Deadline:</label>
                                    <input type="datetime-local" class="mt-1 block w-full px-3 py-2 border border-blue-200 dark:border-blue-800 rounded text-sm bg-white dark:bg-slate-900" 
                                           value="<?= date('Y-m-d\TH:i', strtotime('+4 hours')) ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <a href="<?= base_url('admin/incident_triage/'.$incident['id']) ?>" class="px-5 py-2.5 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition-colors">
                            &larr; Kembali
                        </a>
                        <a href="<?= base_url('admin/incident_investigation/'.$incident['id']) ?>" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                            Assign & Mulai Investigasi
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
