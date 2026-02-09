<!-- =====================================================
     Create Incident Form
     Form untuk melaporkan insiden baru
     ===================================================== -->

<div class="w-full">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-r from-rri-blue to-blue-800">
            <h2 class="text-xl font-bold text-white">Lapor Insiden Baru</h2>
            <p class="text-blue-100 mt-1">Isi formulir di bawah ini dengan lengkap untuk memulai penanganan insiden.</p>
        </div>
        
        <!-- Form -->
        <form action="<?= base_url('incidents/store') ?>" method="POST" enctype="multipart/form-data" class="p-8">
            <!-- CSRF Token -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            
            <div class="grid grid-cols-12 gap-8">
                <!-- Left Column: Primary Info -->
                <div class="col-span-12 lg:col-span-8 space-y-8">
                    <!-- Section: Incident Details -->
                    <div class="space-y-6">
                        <h3 class="flex items-center text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider border-b border-gray-100 dark:border-slate-700 pb-3">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Detail Insiden
                        </h3>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Judul Insiden <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" required
                                   class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 bg-white dark:bg-slate-900 text-gray-900 dark:text-white transition-all"
                                   placeholder="Contoh: Percobaan akses tidak sah ke server mail">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" rows="8" required
                                      class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-y bg-white dark:bg-slate-900 text-gray-900 dark:text-white transition-all"
                                      placeholder="Jelaskan secara rinci apa yang terjadi..."></textarea>
                        </div>
                        
                        <!-- Attachments -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Lampiran Bukti
                            </label>
                            <div class="border-2 border-dashed border-gray-200 dark:border-slate-600 rounded-xl p-8 text-center hover:border-blue-400 dark:hover:border-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all cursor-pointer group">
                                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Upload screenshot atau log file</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Drag & drop atau klik untuk memilih file</p>
                                <input type="file" name="attachments[]" multiple class="hidden">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Meta Info -->
                <div class="col-span-12 lg:col-span-4 space-y-8">
                    <!-- Section: Classification -->
                    <div class="bg-gray-50 dark:bg-slate-700/30 rounded-xl p-6 border border-gray-100 dark:border-slate-700 space-y-6">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                            Klasifikasi
                        </h3>

                        <!-- Source -->
                        <div>
                            <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sumber Laporan <span class="text-red-500">*</span>
                            </label>
                            <select id="source" name="source" required
                                    class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                                <option value="">Pilih sumber...</option>
                                <option value="user">User / Manual</option>
                                <option value="monitoring">System Monitoring</option>
                                <option value="email">Email Report</option>
                                <option value="external">Eksternal (BSSN/etc)</option>
                            </select>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category" required
                                    class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                                <option value="">Pilih kategori...</option>
                                <?php foreach ($category_options as $value => $label): ?>
                                    <option value="<?= $value ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Severity -->
                        <div>
                            <label for="severity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Severity <span class="text-red-500">*</span>
                            </label>
                            <select id="severity" name="severity" required
                                    class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                                <option value="">Pilih tingkat keparahan...</option>
                                <?php foreach ($severity_options as $value => $label): ?>
                                    <option value="<?= $value ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Section: Additional Info -->
                    <div class="bg-gray-50 dark:bg-slate-700/30 rounded-xl p-6 border border-gray-100 dark:border-slate-700 space-y-6">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                            Info Tambahan
                        </h3>

                        <!-- Affected Systems -->
                        <div>
                            <label for="affected_systems" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sistem Terdampak
                            </label>
                            <input type="text" id="affected_systems" name="affected_systems"
                                   class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white"
                                   placeholder="IP / Hostname / Service">
                        </div>

                        <!-- Detection Time -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Waktu Terdeteksi
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" name="detection_date" value="<?= date('Y-m-d') ?>"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white text-sm">
                                <input type="time" name="detection_time" value="<?= date('H:i') ?>"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white text-sm">
                            </div>
                        </div>

                        <!-- Reporter (Readonly) -->
                         <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pelapor
                            </label>
                            <input type="text" value="<?= $user['username'] ?? 'Guest' ?>" readonly
                                   class="w-full px-4 py-2.5 bg-gray-200 dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 mt-8 pt-8 border-t border-gray-100 dark:border-slate-700">
                <a href="<?= base_url('incidents') ?>" 
                   class="px-6 py-3 text-gray-600 dark:text-gray-400 font-medium hover:text-gray-900 dark:hover:text-white transition-colors">
                    Batalkan
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span>Kirim Laporan</span>
                </button>
            </div>
        </form>
    </div>
</div>
