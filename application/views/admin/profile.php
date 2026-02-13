<?php
// Profile Detail Page
$profile = $user;
$role_labels = [
    'admin' => 'Administrator',
    'management' => 'Management',
    'auditor' => 'Auditor'
];
$role_colors = [
    'admin' => ['from' => 'from-violet-600', 'to' => 'to-purple-600', 'bg' => 'bg-violet-500/10', 'text' => 'text-violet-400'],
    'management' => ['from' => 'from-blue-600', 'to' => 'to-cyan-600', 'bg' => 'bg-blue-500/10', 'text' => 'text-blue-400'],
    'auditor' => ['from' => 'from-amber-500', 'to' => 'to-orange-500', 'bg' => 'bg-amber-500/10', 'text' => 'text-amber-400']
];
$rc = $role_colors[$profile['role']] ?? $role_colors['management'];
$role_label = $role_labels[$profile['role']] ?? ucfirst($profile['role']);
?>

<style>
    .info-row {
        transition: all 0.2s ease;
        border-radius: 0.5rem;
        padding: 0.75rem 0.875rem;
    }
    .info-row:hover {
        background: rgba(99, 102, 241, 0.04);
    }
    .dark .info-row:hover {
        background: rgba(255, 255, 255, 0.03);
    }
</style>

<!-- Header -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6" data-aos="fade-up">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profil Saya</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Informasi akun dan aktivitas Anda</p>
    </div>
</div>

<!-- Profile Hero Card -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-6" data-aos="fade-up" data-aos-delay="50">
    <div class="p-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <!-- Avatar -->
            <div class="relative flex-shrink-0">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden shadow-lg <?= (empty($profile['avatar']) || $profile['avatar'] === 'default_avatar.png') ? 'bg-gradient-to-br ' . $rc['from'] . ' ' . $rc['to'] . ' flex items-center justify-center' : '' ?>">
                    <?php if (!empty($profile['avatar']) && $profile['avatar'] !== 'default_avatar.png'): ?>
                        <img src="<?= base_url('uploads/avatars/' . $profile['avatar']) ?>" alt="Avatar" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span class="text-white text-3xl sm:text-4xl font-bold"><?= strtoupper(substr($profile['username'] ?? 'U', 0, 1)) ?></span>
                    <?php endif; ?>
                </div>
                <!-- Online Indicator -->
                <?php if (($profile['status'] ?? 'active') === 'active'): ?>
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-lg border-[3px] border-white dark:border-slate-800"></div>
                <?php endif; ?>
            </div>

            <!-- User Info -->
            <div class="text-center sm:text-left flex-1 min-w-0">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate"><?= htmlspecialchars($profile['username'] ?? 'User') ?></h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5 truncate"><?= htmlspecialchars($profile['email'] ?? '-') ?></p>
                
                <div class="flex items-center gap-2.5 mt-3 justify-center sm:justify-start flex-wrap">
                    <!-- Role Badge -->
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-gradient-to-r <?= $rc['from'] ?> <?= $rc['to'] ?> text-white shadow-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <?= $role_label ?>
                    </span>

                    <!-- Status Badge -->
                    <?php if (($profile['status'] ?? 'active') === 'active'): ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 ring-1 ring-emerald-500/20">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            Aktif
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-gray-50 dark:bg-gray-500/10 text-gray-500 dark:text-gray-400 ring-1 ring-gray-500/20">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                            Nonaktif
                        </span>
                    <?php endif; ?>

                    <!-- Joined Date -->
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-xs text-gray-400 dark:text-slate-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bergabung <?= !empty($profile['created_at']) ? date('d M Y', strtotime($profile['created_at'])) : '-' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Account Detail Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/30">
            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Akun
            </h3>
        </div>
        <div class="p-4">
            <!-- Username -->
            <div class="info-row flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest">Username</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-200 truncate mt-0.5"><?= htmlspecialchars($profile['username'] ?? '-') ?></p>
                </div>
            </div>

            <!-- Email -->
            <div class="info-row flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest">Email</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-200 truncate mt-0.5"><?= htmlspecialchars($profile['email'] ?? '-') ?></p>
                </div>
            </div>

            <!-- Role -->
            <div class="info-row flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest">Role</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5"><?= $role_label ?></p>
                </div>
            </div>

            <!-- Joined -->
            <div class="info-row flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest">Bergabung Sejak</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        <?= !empty($profile['created_at']) ? date('d F Y', strtotime($profile['created_at'])) : '-' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Security & Activity Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/30">
            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Keamanan & Aktivitas
            </h3>
        </div>
        <div class="p-4">
            <!-- Last Login -->
            <div class="info-row flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-green-50 dark:bg-green-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest">Login Terakhir</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        <?php if (!empty($profile['last_login'])): ?>
                            <?= date('d M Y, H:i', strtotime($profile['last_login'])) ?> WIB
                        <?php else: ?>
                            <span class="text-gray-400 dark:text-slate-500 italic font-normal">Belum pernah login</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Last Activity -->
            <div class="info-row flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-cyan-50 dark:bg-cyan-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest">Aktivitas Terakhir</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        <?php if (!empty($profile['last_activity'])): ?>
                            <?= date('d M Y, H:i', strtotime($profile['last_activity'])) ?> WIB
                        <?php else: ?>
                            <span class="text-gray-400 dark:text-slate-500 italic font-normal">-</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Account Status -->
            <div class="info-row flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest">Status Akun</p>
                    <div class="mt-1">
                        <?php if (($profile['status'] ?? 'active') === 'active'): ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-semibold rounded-full ring-1 ring-emerald-500/20">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-xs font-semibold rounded-full ring-1 ring-red-500/20">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Nonaktif
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
