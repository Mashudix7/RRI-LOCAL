<?php
// Calculate Global Stats from Regions data
$total_capacity = 0;
$total_used = 0;
$networks_count = count($regions);
$network_names = [];

foreach ($regions as $slug => $net) {
    // Determine number of IPs from the generated list (which represents partial or full subnet)
    // If the list is filtered by search, this might be inaccurate for "Global Dashboard", 
    // but ip_management() checks if !$region, it loads ALL data without search usually?
    // Wait, ip_management does NOT pass search param in the dashboard branch (lines 598+ in Admin.php)
    // Actually lines 596 calling get_all_grouped_by_network() gets everything if search is null.
    // So $net['ips'] is the full list.
    
    $total_capacity += $net['total'];
    $total_used += $net['used'];
    $network_names[] = $net['name'];
}

$total_free = $total_capacity - $total_used;
$percent_free = ($total_capacity > 0) ? round(($total_free / $total_capacity) * 100) : 0;
$percent_used = ($total_capacity > 0) ? round(($total_used / $total_capacity) * 100) : 0;
?>

<div class="space-y-8">
    <!-- Page Header & Summary -->
    <div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6" data-aos="fade-up">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Mapping IP Publik RRI
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 ml-10">Ringkasan alokasi dan distribusi IP Address Publik Data Center.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?= base_url('admin/ip_management/networks') ?>" class="px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Kelola Wilayah
                </a>
                <button class="px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm flex items-center gap-2 btn-press-anim">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export Report
                </button>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-start justify-between" data-aos="fade-up" data-aos-delay="0">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total IP Publik</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1" data-count-up="<?= $total_capacity ?>"><?= $total_capacity ?></h3>
                    <p class="text-xs text-green-600 font-medium mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Termasuk Reserved
                    </p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            
            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-start justify-between" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Networks</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1" data-count-up="<?= $networks_count ?>"><?= $networks_count ?></h3>
                    <p class="text-xs text-gray-500 mt-1 truncate w-40" title="<?= implode(', ', $network_names) ?>">
                        <?= count($network_names) > 3 ? implode(', ', array_slice($network_names, 0, 3)) . ', ...' : implode(', ', $network_names) ?>
                    </p>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>

             <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-start justify-between" data-aos="fade-up" data-aos-delay="200">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Available IP</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1"><span data-count-up="<?= $percent_free ?>"><?= $percent_free ?></span>%</h3>
                    <p class="text-xs text-yellow-600 font-medium mt-1"><?= $total_free ?> IP Kosong</p>
                </div>
                <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg text-green-600 dark:text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-5 rounded-xl shadow-lg shadow-blue-500/20 text-white flex items-center justify-between" data-aos="fade-up" data-aos-delay="300">
                <div>
                    <p class="text-xs font-medium text-blue-100 uppercase tracking-wider">System Status</p>
                    <h3 class="text-xl font-bold mt-1">Normal</h3>
                    <p class="text-xs text-blue-100 mt-1 opacity-80">All Networks Reachable</p>
                </div>
                <div class="p-3 bg-white/10 rounded-lg">
                   <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg shadow-gray-200/50 dark:shadow-black/20 border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="400">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-800/50">
            <h3 class="font-semibold text-gray-900 dark:text-white">Daftar Network & Wilayah</h3>
            <div class="text-xs text-gray-500 italic">Klik pada baris untuk melihat detail IP</div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-slate-900/50 text-gray-600 dark:text-gray-400 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider w-16 text-center">No.</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Network IP</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Range IP Akhir</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Subnet</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider w-20 text-center">Prefix</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider w-28 text-center">Total IP</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Keterangan</th>
                        <th class="px-4 py-4 w-10"></th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                    <?php $no = 1; foreach($regions as $slug => $net): ?>
                        <?php 
                            // Determine if it's reserve
                            $is_reserve = (stripos($slug, 'reserve') !== false || stripos($net['name'], 'reserve') !== false);
                            
                            // Base theme color (emerald for normal, yellow for reserve)
                            $theme_color = $is_reserve ? 'yellow' : 'emerald';
                        ?>
                        <tr class="group hover:bg-emerald-50 dark:hover:bg-emerald-900/10 cursor-pointer transition-all duration-200 relative <?= $is_reserve ? 'border-l-4 border-yellow-400' : '' ?>" onclick="window.location='<?= base_url('admin/ip_management/' . $slug) ?>'">
                            <td class="px-6 py-4 text-center font-medium text-gray-500"><?= $no++ ?></td>
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-<?= $is_reserve ? 'yellow' : 'emerald' ?>-600 dark:text-<?= $is_reserve ? 'yellow' : 'emerald' ?>-400 <?= $is_reserve ? 'bg-yellow-100 dark:bg-yellow-900/40 px-2 py-1 rounded' : '' ?>">
                                    <?= $net['range_start'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-blue-600 dark:text-blue-400 font-bold"><?= $net['range_end'] ?></td>
                            <td class="px-6 py-4 font-mono text-gray-500">
                                <?= $net['subnet_mask'] ?? '255.255.255.0' ?>
                            </td>
                            <td class="px-6 py-4 text-center"><span class="px-2 py-1 bg-gray-100 dark:bg-slate-700 rounded text-xs font-bold text-gray-600 dark:text-gray-300"><?= $net['cidr'] ?></span></td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-700 dark:text-gray-200"><?= $net['total'] ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                                    <span class="font-medium text-gray-900 dark:text-white"><?= $net['name'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 italic">
                                <?php if($is_reserve): ?>
                                    Reserved / Cadangan
                                <?php else: ?>
                                    Data Center / Core
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-4 text-gray-400 group-hover:text-emerald-500">
                                 <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
