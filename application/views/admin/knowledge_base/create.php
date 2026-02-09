<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="<?= base_url('admin/knowledgebase') ?>" class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Panduan</h2>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <form action="<?= base_url('admin/knowledgebase/store') ?>" method="POST" class="space-y-6">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Judul Panduan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" required
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                       placeholder="Contoh: Cara Menangani Phishing">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="General">General</option>
                        <option value="Malware">Malware</option>
                        <option value="Phishing">Phishing</option>
                        <option value="Network">Network Security</option>
                        <option value="Incident Response">Incident Response</option>
                        <option value="Vulnerability">Vulnerability</option>
                    </select>
                </div>

                <!-- Visibility -->
                <div class="flex items-center pt-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_public" value="1" checked
                               class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tampilkan ke Publik</span>
                    </label>
                </div>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Konten <span class="text-red-500">*</span>
                </label>
                <textarea name="content" rows="15" required
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all font-mono text-sm"
                          placeholder="Tulis konten panduan di sini (Support Markdown sederhana atau HTML)..."></textarea>
                <p class="mt-1 text-xs text-gray-500">Gunakan HTML tags untuk formatting (e.g., &lt;h3&gt;, &lt;p&gt;, &lt;ul&gt;).</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-slate-700">
                <a href="<?= base_url('admin/knowledgebase') ?>" 
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-lg shadow-blue-500/30">
                    Simpan Panduan
                </button>
            </div>
        </form>
    </div>
</div>
