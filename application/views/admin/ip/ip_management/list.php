<?php 
// RBAC: Check if user can edit
$role = $this->session->userdata('role');
$can_edit = in_array($role, ['admin', 'management']);
?>
<div class="space-y-6">
    <!-- Breadcrumb & Navigation -->
    <nav class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">
        <a href="<?= base_url('admin/ip_management') ?>" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">IP Management</a>
        <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-semibold"><?= $location_name ?></span>
    </nav>

    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col md:flex-row items-center justify-between gap-4" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?= $location_name ?></h1>
                <div class="flex items-center gap-3 mt-1 text-sm">
                    <span class="flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-mono">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        <?= $network_cidr ?>
                    </span>
                    <span class="text-gray-400">•</span>
                    <span class="text-gray-500 dark:text-gray-400"><?= count($ip_list) ?> Total Hosts</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
             <form method="GET" action="<?= current_url() ?>" class="flex gap-2 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <input type="text" name="q" value="<?= $this->input->get('q') ?>" placeholder="Cari IP atau Keterangan..." 
                           class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-sm">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors btn-press-anim">
                    Cari
                </button>
            </form>
            <a href="<?= base_url('admin/ip_export/' . $this->uri->segment(3)) . '?q=' . urlencode($this->input->get('q')) ?>" 
               class="px-4 py-2 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-white rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors flex items-center gap-2 btn-press-anim">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </a>
        </div>
    </div>

    <!-- IP Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg shadow-gray-200/50 dark:shadow-black/20 border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase w-20 text-center">No/Host</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase w-48">IP Address</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Keterangan / Penggunaan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase w-32">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-right w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    <?php if (empty($ip_list)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <span>Tidak ada data IP address ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ip_list as $ip): ?>
                            <?php 
                                // Color Logic
                                $is_reserve = isset($ip['is_reserve']) && $ip['is_reserve'];
                                $is_gateway = isset($ip['type']) && $ip['type'] === 'gateway';
                                $has_desc = !empty($ip['description']);

                                $row_class = "hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors";
                                $highlight_bar = "";

                                if ($is_reserve) {
                                    $row_class = "bg-yellow-50/60 dark:bg-yellow-900/10 hover:bg-yellow-100 dark:hover:bg-yellow-900/20";
                                    $highlight_bar = "border-l-4 border-yellow-400";
                                } elseif ($is_gateway) {
                                    $row_class = "bg-blue-50/60 dark:bg-blue-900/10 hover:bg-blue-100 dark:hover:bg-blue-900/20";
                                    $highlight_bar = "border-l-4 border-blue-500";
                                } elseif ($has_desc) {
                                     $row_class = "bg-white dark:bg-slate-800";
                                } else {
                                     $row_class = "bg-white dark:bg-slate-800"; // Available rows clean
                                }
                            ?>
                            <tr class="<?= $row_class ?> <?= $highlight_bar ?>">
                                <td class="px-6 py-4 text-center font-medium text-gray-400 text-sm">
                                    <?= $ip['no'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <code class="text-sm font-mono font-medium <?= $has_desc || $is_gateway ? 'text-gray-900 dark:text-white' : 'text-gray-400' ?>">
                                            <?= $ip['ip_address'] ?>
                                        </code>
                                        <?php if ($is_gateway): ?>
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700 uppercase tracking-wide">GW</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if ($is_reserve): ?>
                                        <span class="text-yellow-700 dark:text-yellow-500 italic block py-1">Cadangan (Kosong)</span>
                                    <?php elseif ($ip['status'] === 'inactive' && empty($ip['description'])): ?>
                                        <span class="text-gray-400 dark:text-gray-500 text-xs italic opacity-60">- Available for allocation -</span>
                                    <?php elseif (empty($ip['description'])): ?>
                                         <span class="text-gray-300 dark:text-gray-600 text-xs italic">-</span>
                                    <?php else: ?>
                                        <span class="font-medium text-gray-800 dark:text-gray-200 block py-1"><?= htmlspecialchars($ip['description']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($ip['status'] === 'active'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100/80 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    <?php elseif ($is_reserve): ?>
                                         <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100/80 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                            Reserved (Inactive)
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-slate-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <?php if ($can_edit): ?>
                                        <?php 
                                            // Secure link generation to avoid dot issues in URI segments
                                            $edit_url = base_url('admin/ip_edit');
                                            if ($ip['id']) {
                                                $edit_url .= '/' . $ip['id']; // ID is safe in segment
                                            } else {
                                                $edit_url .= '?ip=' . urlencode($ip['ip_address']); // IP in query string
                                            }
                                            $edit_url .= ($ip['id'] ? '?' : '&') . 'network_id=' . $ip['network_id'];
                                        ?>
                                        <a href="<?= $edit_url ?>" 
                                           class="text-blue-600 hover:text-blue-800 p-1 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded transition-colors"
                                           title="Edit IP">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <?php else: ?>
                                        <span class="text-xs text-gray-400 italic">-</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
