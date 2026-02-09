<!-- =====================================================
     User Management Page - Dark Mode Support
     ===================================================== -->

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Pengguna</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola akun pengguna dan hak akses</p>
    </div>
    <?php if ($this->session->userdata('role') === 'admin'): ?>
    <a href="<?= base_url('admin/user_create') ?>" 
            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Pengguna
    </a>
    <?php endif; ?>
</div>



<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6" data-aos="fade-up">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-gray-900 dark:text-white"><?= count($users) ?></div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Total Pengguna</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-green-600 dark:text-green-400"><?= count(array_filter($users, function($u) { return $u['status'] === 'active'; })) ?></div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Aktif</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-gray-400"><?= count(array_filter($users, function($u) { return $u['status'] === 'inactive'; })) ?></div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Nonaktif</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm dark:shadow-none">
        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400"><?= count(array_filter($users, function($u) { return $u['role'] === 'admin'; })) ?></div>
        <div class="text-sm text-gray-500 dark:text-gray-400">Admin</div>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Pengguna</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Login Terakhir</th>
                    <?php if ($this->session->userdata('role') === 'admin'): ?>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                <?php $no = 1; foreach ($users as $u): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-medium"><?= $no++ ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden <?= (empty($u['avatar']) || $u['avatar'] === 'default_avatar.png') ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gray-100' ?>">
                                <?php if (!empty($u['avatar']) && $u['avatar'] !== 'default_avatar.png'): ?>
                                    <img src="<?= base_url('uploads/avatars/' . $u['avatar']) ?>" alt="<?= $u['username'] ?>" class="w-full h-full object-cover" loading="lazy">
                                <?php else: ?>
                                    <span class="text-white font-semibold"><?= strtoupper(substr($u['username'], 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($u['username']) ?></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($u['email']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <?php
                        $role_colors = [
                            'admin' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300',
                            'management' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                            'auditor' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300'
                        ];
                        $color = $role_colors[$u['role']] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300';
                        ?>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full <?= $color ?>">
                            <?= ucfirst($u['role']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($u['is_online']): ?>
                            <span class="flex items-center gap-1.5 text-green-600 dark:text-green-400 text-sm">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                Online
                            </span>
                        <?php else: ?>
                            <span class="flex items-center gap-1.5 text-gray-400 text-sm">
                                <span class="w-2 h-2 bg-gray-300 dark:bg-gray-500 rounded-full"></span>
                                Offline
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                        <div>
                            <?php if (!empty($u['last_login'])): ?>
                                <div class="font-medium text-gray-900 dark:text-white"><?= date('d M Y, H:i', strtotime($u['last_login'])) ?> WIB</div>
                                <div class="text-xs text-gray-400">Login Terakhir</div>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Belum pernah login</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <?php if ($this->session->userdata('role') === 'admin'): ?>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= base_url('admin/user_edit/' . $u['id']) ?>" class="p-2 text-gray-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/20 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <a href="<?= base_url('admin/user_delete/' . $u['id']) ?>" data-confirm="Apakah Anda yakin ingin menghapus pengguna ini?" class="p-2 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script removed as modal is no longer used -->
