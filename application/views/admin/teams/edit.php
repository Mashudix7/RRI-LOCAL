<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white"><?= $title ?></h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Edit data anggota tim</p>
        </div>
        <a href="<?= base_url('admin/teams') ?>" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
            Kembali
        </a>
    </div>



    <!-- Form -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
        <?= form_open_multipart('admin/teams/update/' . $member['id'], ['class' => 'space-y-6']) ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="<?= $member['name'] ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Position -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jabatan</label>
                    <input type="text" name="position" value="<?= $member['position'] ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Wrapper for Role Logic -->
                <div class="contents" x-data="{ role: '<?= $member['role'] ?>' }">
                    
                    <!-- Division (Hidden if Director) -->
                    <div x-show="role !== 'director'" x-transition>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Divisi</label>
                        <select name="division" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="Tim Teknologi Media Baru" <?= ($member['division'] == 'Tim Teknologi Media Baru') ? 'selected' : '' ?>>Teknologi Media Baru</option>
                            <option value="Tim IT" <?= ($member['division'] == 'Tim IT') ? 'selected' : '' ?>>Tim IT</option>
                        </select>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role / Tingkatan</label>
                        <select x-model="role" name="role" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="member" <?= ($member['role'] == 'member') ? 'selected' : '' ?>>Anggota Tim (Maks 8 per Divisi)</option>
                            <option value="leader" <?= ($member['role'] == 'leader') ? 'selected' : '' ?>>Ketua Tim (Maks 1 per Divisi)</option>
                            <option value="main_head" <?= ($member['role'] == 'main_head') ? 'selected' : '' ?>>Kepala Utama (Hanya 1 Orang)</option>
                            <option value="director" <?= ($member['role'] == 'director') ? 'selected' : '' ?> class="font-bold text-blue-600">Kepala Direktur (Hanya 1 Orang)</option>
                        </select>
                        <p class="mt-1 text-[10px] text-gray-500 italic">* Struktur: 1 Kepala Direktur, 1 Kepala Utama, 2 Ketua Tim, 16 Anggota.</p>
                    </div>
                </div>

                <!-- Photo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden relative">
                            <?php if (!empty($member['photo'])): ?>
                                <img id="preview-photo" src="<?= base_url($member['photo']) ?>" class="w-full h-full object-cover" loading="lazy">
                            <?php else: ?>
                                <img id="preview-photo" class="w-full h-full object-cover hidden">
                                <div id="placeholder-text" class="w-full h-full flex items-center justify-center text-gray-500 text-xl font-bold">
                                    <?= substr($member['name'], 0, 1) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="photo" accept="image/*" onchange="previewPhoto(this)" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto. (Maks 5MB, Foto akan dikompres otomatis)</p>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function previewPhoto(input) {
                var preview = document.getElementById('preview-photo');
                var placeholder = document.getElementById('placeholder-text');
                
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
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Update Anggota
                </button>
            </div>
        <?= form_close() ?>
    </div>
</div>
