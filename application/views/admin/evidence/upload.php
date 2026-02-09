<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="<?= base_url('admin/evidence') ?>" class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Upload Bukti Digital</h2>
    </div>

    <!-- Alert Warning -->
    <div class="p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg text-sm">
        <strong>Security Notice:</strong> File akan dienkripsi namanya dan disimpan di folder terproteksi. Hash SHA-256 akan dihitung secara otomatis untuk integritas data.
    </div>


    
    <!-- Form -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <form action="<?= base_url('admin/evidence/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Case Ref -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nomor Referensi Kasus <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="case_ref_no" required placeholder="ex: CSIRT-2026-001"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white uppercase font-mono focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                </div>

                 <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Judul Bukti <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required placeholder="ex: Server Log Access"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Catatan Tambahan
                </label>
                <textarea name="notes" rows="3"
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    File Bukti (Max 100MB) <span class="text-red-500">*</span>
                </label>
                <input type="file" name="evidence_file" required
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100 dark:file:bg-slate-700 dark:file:text-gray-300
                              transition-all border border-gray-200 dark:border-slate-600 rounded-lg cursor-pointer">
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-slate-700">
                <a href="<?= base_url('admin/evidence') ?>" 
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors shadow-lg shadow-indigo-500/30">
                    Upload & Secure
                </button>
            </div>
        </form>
    </div>
</div>
