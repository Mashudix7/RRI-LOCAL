    <!-- =====================================================
     Data Triage
     Tahap 2: Validasi dan Klasifikasi
     ===================================================== -->
<div class="max-w-6xl mx-auto p-6">
    <!-- Stepper -->
    <?php $active_step = 2; include APPPATH . 'views/admin/incidents/flow_stepper.php'; ?>

    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar Info -->
        <div class="col-span-12 md:col-span-4 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Informasi Insiden</h3>
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs text-gray-400">Judul</span>
                        <p class="text-gray-900 dark:text-white font-medium"><?= $incident['title'] ?></p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400">Dilaporkan Oleh</span>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                <?= substr($incident['reporter'], 0, 1) ?>
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300"><?= $incident['reporter'] ?></span>
                        </div>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400">Waktu Laporan</span>
                        <p class="text-sm text-gray-700 dark:text-gray-300"><?= $incident['reported_at'] ?></p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400">Sumber</span>
                        <span class="inline-block px-2 py-1 mt-1 text-xs rounded bg-purple-100 text-purple-700 font-medium">
                            <?= ucfirst($incident['source']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Triage Form -->
        <div class="col-span-12 md:col-span-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/30 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800 dark:text-white">Validasi & Triage</h2>
                    <span class="text-xs text-orange-500 bg-orange-100 px-2 py-1 rounded-full font-bold">Pending Review</span>
                </div>

                <form action="#" class="p-6 space-y-6">
                    <!-- Validation Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Status Validasi</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="validity" value="valid" class="peer sr-only" checked>
                                <div class="p-4 rounded-lg border-2 border-gray-200 dark:border-slate-600 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-500/10 transition-all text-center">
                                    <h4 class="font-bold text-gray-700 dark:text-gray-200 peer-checked:text-green-600">Valid Incident</h4>
                                    <p class="text-xs text-gray-500 mt-1">Lanjutkan ke penanganan</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="validity" value="invalid" class="peer sr-only">
                                <div class="p-4 rounded-lg border-2 border-gray-200 dark:border-slate-600 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-500/10 transition-all text-center">
                                    <h4 class="font-bold text-gray-700 dark:text-gray-200 peer-checked:text-red-600">False Positive</h4>
                                    <p class="text-xs text-gray-500 mt-1">Tolak dan tutup tiket</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Category Confirmation -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori (Konfirmasi)</label>
                            <select class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                                <option value="malware" <?= $incident['category'] == 'Malware' ? 'selected' : '' ?>>Attributes of Malware</option>
                                <option value="network" <?= $incident['category'] == 'Intrusion' ? 'selected' : '' ?>>Network Intrusion</option>
                                <option value="phishing">Phishing / Social Engineering</option>
                                <option value="content">Abusive Content</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tingkat Keparahan</label>
                            <select class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                                <option value="low">Low - Dampak minimal</option>
                                <option value="medium">Medium - Dampak lokal</option>
                                <option value="high" <?= $incident['severity'] == 'High' ? 'selected' : '' ?>>High - Dampak sistemik</option>
                                <option value="critical">Critical - Lumpuh total</option>
                            </select>
                        </div>
                    </div>

                    <!-- Analysis Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Triage</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" placeholder="Jelaskan alasan validasi dan temuan awal..."></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
                        <a href="<?= base_url('admin/incidents') ?>" class="px-5 py-2.5 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition-colors">Batal</a>
                        <a href="<?= base_url('admin/incident_assignment/'.$incident['id']) ?>" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                            Konfirmasi & Lanjut (Assign)
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
