<?php
// Role Check
$role = $this->session->userdata('role');
$isAdmin = ($role === 'admin');
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4" data-aos="fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data IP & Password</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manajemen kredensial server dan IP Address.</p>
        </div>
        
        <?php if ($isAdmin): ?>
        <div class="flex items-center gap-3">
            <a href="<?= base_url('admin/server_credentials/lock') ?>" class="px-4 py-2 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 font-medium rounded-lg transition-all flex items-center gap-2 border border-red-100 dark:border-red-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Lock Vault
            </a>
            <a href="<?= base_url('admin/server_credentials/create') ?>" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md transition-all flex items-center gap-2 btn-press-anim">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Data
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
    <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
        <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
        <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="w-full">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-[5%]">No</th>
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-[20%]">VM Name / Host</th>
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-[15%]">IP Address</th>
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-[15%]">Domain</th>
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-[15%]">Username</th>
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-[15%]">Password</th>
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-[15%]">Deskripsi</th>
                        <?php if ($isAdmin): ?>
                        <th class="p-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-[10%]">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    <?php if(empty($credentials)): ?>
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-500">Belum ada data kredensial.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($credentials as $index => $row): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="p-4 text-center font-mono text-xs text-gray-400 align-top border-r border-gray-50 dark:border-slate-700/50">
                            <?= $index + 1 ?>
                        </td>
                        <td class="p-4 align-top border-r border-gray-50 dark:border-slate-700/50">
                            <div class="font-medium text-gray-900 dark:text-white break-words text-sm"><?= $row['vm_name'] ?: '<span class="text-gray-300">-</span>' ?></div>
                        </td>
                        <td class="p-4 align-top border-r border-gray-50 dark:border-slate-700/50">
                            <div class="font-mono text-sm text-blue-600 dark:text-blue-400 break-all"><?= $row['ip_address'] ?: '<span class="text-gray-300">-</span>' ?></div>
                        </td>
                        <td class="p-4 align-top border-r border-gray-50 dark:border-slate-700/50">
                            <div class="text-sm text-gray-600 dark:text-gray-300 break-all"><?= $row['domain'] ?: '<span class="text-gray-300">-</span>' ?></div>
                        </td>
                        <td class="p-4 align-top border-r border-gray-50 dark:border-slate-700/50">
                            <div class="font-mono text-sm text-gray-600 dark:text-gray-300 break-all"><?= $row['username'] ?: '<span class="text-gray-300">-</span>' ?></div>
                        </td>
                        <td class="p-4 align-top border-r border-gray-50 dark:border-slate-700/50">
                            <div class="font-mono text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/10 px-2 py-1 rounded break-all inline-block">
                                <?= $row['password'] ?: '-' ?>
                            </div>
                        </td>
                        <td class="p-4 align-top border-r border-gray-50 dark:border-slate-700/50">
                            <div class="text-sm text-gray-500 dark:text-gray-400 italic break-words"><?= $row['description'] ?: '<span class="text-gray-300">-</span>' ?></div>
                        </td>
                        <?php if ($isAdmin): ?>
                        <td class="p-4 text-center align-top">
                            <div class="flex items-center justify-center gap-2">
                                <a href="<?= base_url('admin/server_credentials/edit/'.$row['id']) ?>" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <a href="<?= base_url('admin/server_credentials/delete/'.$row['id']) ?>" onclick="return confirm('Hapus data ini?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </a>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
