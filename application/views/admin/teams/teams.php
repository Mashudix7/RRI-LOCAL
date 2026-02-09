<!-- =====================================================
     Team Management Page - Admin Panel
     ===================================================== -->
<?php 
// RBAC: Check if user can create/update/delete
$role = $this->session->userdata('role');
$can_crud = in_array($role, ['admin', 'management']);
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Tim</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1"><?= $can_crud ? 'Kelola anggota tim yang ditampilkan di landing page' : 'Lihat daftar anggota tim' ?></p>
    </div>
    <?php if ($can_crud): ?>
    <a href="<?= base_url('admin/teams/create') ?>" 
            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Anggota
    </a>
    <?php endif; ?>
</div>



<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6" data-aos="fade-up">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-gray-900 dark:text-white"><?= count($team_media_baru) ?></div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tim Media Baru</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400"><?= count($team_it) ?></div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tim IT</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-amber-600 dark:text-amber-400"><?= count($director ?? []) ?></div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kepala Direktur</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400"><?= count(array_filter($all_teams, function($t){ return $t['role'] == 'leader'; })) ?></div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ketua Tim</div>
    </div>
</div>

<!-- Director Section (Simple & Prominent) -->
<?php if (!empty($director)): ?>
<div class="mb-6" data-aos="fade-up" data-aos-delay="50">
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-amber-200 dark:border-amber-900/30 overflow-hidden shadow-lg shadow-amber-500/5">
        <div class="bg-amber-600/5 dark:bg-amber-600/10 px-6 py-4 border-b border-amber-100 dark:border-amber-900/20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-600 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-amber-900 dark:text-amber-100 text-lg">Struktur Organisasi</h3>
                    <p class="text-xs text-amber-600 dark:text-amber-400">Pimpinan Tertinggi</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <?php foreach ($director as $dir): ?>
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-amber-100 dark:border-amber-900/30 shadow-md">
                        <?php if(!empty($dir['photo'])): ?>
                            <img src="<?= base_url($dir['photo']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-amber-600 flex items-center justify-center text-white text-3xl font-bold">
                                <?= strtoupper(substr($dir['name'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($dir['name']) ?></h4>
                    <p class="text-amber-600 dark:text-amber-500 font-medium mb-2"><?= htmlspecialchars($dir['position']) ?></p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1.5 bg-gray-50 dark:bg-slate-700 px-3 py-1 rounded-full border border-gray-100 dark:border-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <?= htmlspecialchars($dir['email'] ?: '-') ?>
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="<?= base_url('admin/teams/edit/' . $dir['id']) ?>" class="px-4 py-2 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-sm font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Data
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Team Tabs -->
<div x-data="{ activeTab: '<?= $this->input->get('tab') ?: 'media-baru' ?>' }" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <!-- Tab Buttons -->
    <div class="flex border-b border-gray-100 dark:border-slate-700">
        <button @click="activeTab = 'media-baru'" 
                :class="activeTab === 'media-baru' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-blue-50 dark:bg-blue-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                class="flex-1 px-6 py-4 font-medium text-sm transition-colors">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Tim Media Baru
            </span>
        </button>
        <button @click="activeTab = 'it'" 
                :class="activeTab === 'it' ? 'text-emerald-600 dark:text-emerald-400 border-b-2 border-emerald-600 dark:border-emerald-400 bg-emerald-50 dark:bg-emerald-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                class="flex-1 px-6 py-4 font-medium text-sm transition-colors">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
                Tim IT
            </span>
        </button>
    </div>

    <!-- Tim Media Baru Table -->
    <div x-show="activeTab === 'media-baru'" class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Anggota</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Jabatan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Role</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                <?php $no = 1; foreach ($team_media_baru as $member): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-medium"><?= $no++ ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center overflow-hidden">
                                <?php if(!empty($member['photo'])): ?>
                                    <img src="<?= base_url($member['photo']) ?>" class="w-full h-full object-cover" loading="lazy">
                                <?php else: ?>
                                    <span class="text-white font-semibold"><?= strtoupper(substr($member['name'], 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($member['name']) ?></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300"><?= htmlspecialchars($member['position']) ?></td>
                    <td class="px-6 py-4">
                        <?php if ($member['role'] === 'main_head'): ?>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300 border border-purple-200 dark:border-purple-800/50">Kepala Utama</span>
                        <?php elseif ($member['role'] === 'leader'): ?>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50">Ketua Tim</span>
                        <?php else: ?>
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700 dark:bg-gray-500/10 dark:text-gray-400 border border-gray-200 dark:border-gray-700/50">Anggota</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <?php if ($can_crud): ?>
                            <a href="<?= base_url('admin/teams/edit/' . $member['id']) ?>" class="p-2 text-gray-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/20 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <a href="<?= base_url('admin/teams/delete/' . $member['id']) ?>" data-confirm="Apakah Anda yakin ingin menghapus anggota tim ini?" class="p-2 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </a>
                            <?php else: ?>
                            <span class="text-xs text-gray-400 dark:text-gray-500 italic">View only</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>   
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Tim IT Table -->
    <div x-show="activeTab === 'it'" class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Anggota</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Jabatan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Role</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                <?php $no = 1; foreach ($team_it as $member): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-medium"><?= $no++ ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center overflow-hidden">
                                <?php if(!empty($member['photo'])): ?>
                                    <img src="<?= base_url($member['photo']) ?>" class="w-full h-full object-cover" loading="lazy">
                                <?php else: ?>
                                    <span class="text-white font-semibold"><?= strtoupper(substr($member['name'], 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($member['name']) ?></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300"><?= htmlspecialchars($member['position']) ?></td>
                    <td class="px-6 py-4">
                        <?php if ($member['role'] === 'main_head'): ?>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300 border border-purple-200 dark:border-purple-800/50">Kepala Utama</span>
                        <?php elseif ($member['role'] === 'leader'): ?>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/50">Ketua Tim</span>
                        <?php else: ?>
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700 dark:bg-gray-500/10 dark:text-gray-400 border border-gray-200 dark:border-gray-700/50">Anggota</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <?php if ($can_crud): ?>
                            <a href="<?= base_url('admin/teams/edit/' . $member['id']) ?>" class="p-2 text-gray-400 dark:text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/20 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <a href="<?= base_url('admin/teams/delete/' . $member['id']) ?>" data-confirm="Apakah Anda yakin ingin menghapus anggota tim ini?" class="p-2 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </a>
                            <?php else: ?>
                            <span class="text-xs text-gray-400 dark:text-gray-500 italic">View only</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>
