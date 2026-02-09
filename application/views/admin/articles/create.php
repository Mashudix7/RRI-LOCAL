<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white"><?= $title ?></h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tulis artikel baru</p>
        </div>
        <a href="<?= base_url('admin/articles') ?>" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
            Kembali
        </a>
    </div>



    <!-- Form -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
        <?= form_open_multipart('admin/articles/store', ['class' => 'space-y-6']) ?>
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Artikel</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" placeholder="Masukkan judul artikel...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="Berita">Berita</option>
                        <option value="Panduan">Panduan</option>
                        <option value="Keamanan">Keamanan</option>
                        <option value="Pengumuman">Pengumuman</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konten</label>
                <textarea name="content" rows="10" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" placeholder="Tulis konten artikel di sini..."></textarea>
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Thumbnail Image</label>
                <div class="flex items-start gap-4">
                    <div class="w-32 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0 relative">
                        <img id="preview-image" class="w-full h-full object-cover hidden" loading="lazy">
                        <div id="placeholder-image" class="w-full h-full flex items-center justify-center text-gray-500 text-sm">
                            Preview
                        </div>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="thumbnail" accept="image/*" onchange="previewImage(this)" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maksimal 5MB. Gambar akan dikompres otomatis oleh sistem.</p>
                    </div>
                </div>
            </div>

            <script>
            function previewImage(input) {
                var preview = document.getElementById('preview-image');
                var placeholder = document.getElementById('placeholder-image');
                
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        if(placeholder) placeholder.classList.add('hidden');
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                }
            }
            </script>

            <div class="flex justify-end pt-6">
                <!-- Save Draft -->
                <button type="submit" name="status" value="draft" class="mr-3 px-6 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                    Simpan sebagai Draft
                </button>
                <!-- Publish -->
                <button type="submit" name="status" value="published" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Publish Artikel
                </button>
            </div>
        <?= form_close() ?>
    </div>
</div>
