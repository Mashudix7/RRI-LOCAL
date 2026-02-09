<!-- =====================================================
     Incident Detail View
     Detail insiden dengan timeline dan actions
     ===================================================== -->

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Main Content (2 columns) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Incident Info Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-gray-500 dark:text-gray-400 text-sm">ID: #<?= $incident['id'] ?></span>
                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full badge-<?= $incident['severity'] ?>">
                        <?= ucfirst($incident['severity']) ?>
                    </span>
                    <?php
                    $status_labels = [
                        'reported' => 'Dilaporkan',
                        'validated' => 'Divalidasi',
                        'in_progress' => 'Ditangani',
                        'mitigated' => 'Dimitigasi',
                        'recovered' => 'Dipulihkan',
                        'closed' => 'Ditutup'
                    ];
                    ?>
                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full badge-<?= $incident['status'] ?>">
                        <?= $status_labels[$incident['status']] ?? $incident['status'] ?>
                    </span>
                </div>
                
                <!-- Actions dropdown -->
                <?php if ($user['role'] === 'admin' || $user['role'] === 'analyst'): ?>
                <div class="relative">
                    <button class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        Update Status ▾
                    </button>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="p-6">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-4"><?= htmlspecialchars($incident['title']) ?></h1>
                
                <div class="prose prose-sm text-gray-600 dark:text-gray-400 max-w-none">
                    <p><?= nl2br(htmlspecialchars($incident['description'])) ?></p>
                </div>
                
                <!-- Metadata Grid -->
                <div class="grid md:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-slate-700">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Kategori</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <?= ucfirst(str_replace('_', ' ', $incident['category'])) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Sistem Terdampak</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <?= htmlspecialchars($incident['affected_systems'] ?? '-') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Dilaporkan Oleh</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <?= htmlspecialchars($incident['reporter']['name']) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Ditugaskan Ke</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <?= htmlspecialchars($incident['assignee']['name'] ?? '-') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tanggal Laporan</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <?= date('d M Y, H:i', strtotime($incident['created_at'])) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Terakhir Update</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <?= date('d M Y, H:i', strtotime($incident['updated_at'])) ?>
                        </p>
                    </div>
                </div>
                
                <!-- Initial Assessment -->
                <?php if (!empty($incident['initial_assessment'])): ?>
                <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Penilaian Awal</p>
                    <div class="bg-yellow-50 dark:bg-yellow-500/10 border border-yellow-100 dark:border-yellow-500/20 rounded-lg p-4">
                        <p class="text-sm text-yellow-800 dark:text-yellow-300"><?= htmlspecialchars($incident['initial_assessment']) ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Timeline Aktivitas</h2>
            </div>
            
            <div class="p-6">
                <?php if (!empty($timeline)): ?>
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-slate-600"></div>
                    
                    <div class="space-y-6">
                        <?php foreach ($timeline as $index => $event): ?>
                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            
                            <div class="flex-1 pb-6 <?= $index === count($timeline) - 1 ? 'pb-0' : '' ?>">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($event['action']) ?></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">oleh <?= htmlspecialchars($event['user']) ?></p>
                                    </div>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                        <?= date('d M, H:i', strtotime($event['time'])) ?>
                                    </span>
                                </div>
                                <?php if (!empty($event['notes'])): ?>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 bg-gray-50 dark:bg-slate-700/50 rounded-lg p-3">
                                    <?= htmlspecialchars($event['notes']) ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php else: ?>
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada aktivitas.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Add Note Form -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Catatan</h2>
            </div>
            
            <form action="<?= base_url('incidents/' . $incident['id'] . '/notes') ?>" method="POST" class="p-6">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <textarea name="notes" rows="3" required
                          class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none bg-white dark:bg-slate-900 text-gray-900 dark:text-white"
                          placeholder="Tambahkan catatan atau update..."></textarea>
                
                <div class="flex justify-end mt-4">
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Tambah Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Aksi</h3>
            
            <div class="space-y-3">
                <?php if ($user['role'] === 'admin' || $user['role'] === 'analyst'): ?>
                    <?php if ($incident['status'] === 'reported'): ?>
                    <button class="w-full flex items-center gap-3 px-4 py-3 bg-purple-50 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-medium rounded-lg hover:bg-purple-100 dark:hover:bg-purple-500/30 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Validasi Insiden
                    </button>
                    <?php endif; ?>
                    
                    <?php if ($incident['status'] === 'validated'): ?>
                    <button class="w-full flex items-center gap-3 px-4 py-3 bg-blue-50 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 font-medium rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/30 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                        Mulai Penanganan
                    </button>
                    <?php endif; ?>
                    
                    <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-slate-700/50 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Assign Analyst
                    </button>
                <?php endif; ?>
                
                <a href="<?= base_url('incidents') ?>" 
                   class="w-full flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-gray-400 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
        
        <!-- Attachments -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Lampiran</h3>
            
            <div class="text-center py-6 text-gray-400 dark:text-gray-500">
                <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                </svg>
                <p class="text-sm">Belum ada lampiran</p>
            </div>
        </div>
        
        <!-- Related Incidents -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Insiden Terkait</h3>
            
            <div class="text-center py-6 text-gray-400 dark:text-gray-500">
                <p class="text-sm">Tidak ada insiden terkait</p>
            </div>
        </div>
    </div>
</div>
