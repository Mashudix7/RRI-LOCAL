<!-- =====================================================
     Team Page - Organizational Chart Style
     ===================================================== -->

<!-- Hero Section -->
<section class="relative pt-24 pb-16 bg-white dark:bg-[#020617] overflow-hidden">
    <!-- Cinematic Background (Dark Only) -->
    <div class="absolute inset-0 z-0 pointer-events-none hidden dark:block">
        <div class="absolute inset-0 cyber-grid opacity-20"></div>
        <div class="absolute inset-0 diagonal-light"></div>
        <div class="absolute top-[-100px] left-1/2 -translate-x-1/2 w-full h-[400px] top-spotlight opacity-50"></div>
        <div class="absolute top-[40%] left-1/2 -translate-x-1/2 w-[800px] h-[800px] center-glow opacity-30"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 dark:bg-white/10 dark:text-white backdrop-blur-sm rounded-full text-sm font-medium mb-4 border border-blue-100 dark:border-white/10">
            Tim Kami
        </span>
        <h1 class="reveal-sweep delay-100 text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
            Tim <span class="text-blue-600 dark:text-blue-400">CSIRT RRI</span>
        </h1>
        <p class="reveal-sweep delay-200 text-gray-600 dark:text-blue-200/80 max-w-2xl mx-auto">
            Para profesional yang berdedikasi untuk menjaga keamanan siber RRI
        </p>
    </div>
</section>

<!-- Team Chart Section -->
<section class="py-20 bg-white dark:bg-gradient-to-b dark:from-[#020617] dark:to-[#020617] relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100/50 dark:bg-blue-600/5 rounded-full blur-3xl -mr-48 -mt-24"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-100/50 dark:bg-purple-600/5 rounded-full blur-3xl -ml-48 -mb-24"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <?php if (!$director && !$main_head && empty($grouped_teams)): ?>
            <div class="text-center py-20" data-aos="fade-up">
                <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354l1.1 3.393h3.566l-2.885 2.096 1.1 3.393L12 11.14l-2.885 2.096 1.1-3.393-2.885-2.096h3.565L12 4.354z"></path></svg>
                </div>
                <p class="text-gray-500 font-medium">Data tim belum tersedia.</p>
            </div>
        <?php else: ?>

            <!-- Level 1: Kepala Direktur -->
            <div class="flex justify-center mb-16 relative">
                <?php if ($director): ?>
                    <div class="relative group reveal-sweep delay-300">
                        <!-- Connecting Line Down -->
                        <div class="absolute left-1/2 -bottom-16 w-0.5 h-16 bg-gray-300 dark:bg-slate-600 hidden lg:block"></div>
                        
                        <div class="bg-white dark:bg-[#0f172a] rounded-2xl p-6 border border-gray-200 dark:border-white/10 shadow-xl text-center w-64 md:w-72 transform transition-all duration-500 hover:scale-105">
                            <div class="w-28 h-28 mx-auto mb-4 p-1 rounded-full border-4 border-white dark:border-slate-700 shadow-sm overflow-hidden">
                                <?php if (!empty($director['photo'])): ?>
                                    <img src="<?= base_url(strpos($director['photo'], 'assets') !== false ? $director['photo'] : 'assets/uploads/' . $director['photo']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full bg-amber-600 flex items-center justify-center text-white text-4xl font-black">
                                        <?= substr($director['name'], 0, 1) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-tight mb-1"><?= htmlspecialchars($director['name']) ?></h3>
                            <p class="text-amber-600 dark:text-amber-500 text-sm font-medium"><?= htmlspecialchars($director['position']) ?></p>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest">Pimpinan Tertinggi</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

                <!-- Level 2 & 3: Divisions Layout -->
            <div class="relative">
                <!-- Horizontal Connecting Line (Desktop) -->
                <div class="absolute -top-8 left-[25%] right-[25%] h-0.5 bg-blue-500 hidden lg:block shadow-sm"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
                    
                    <?php 
                    $divisions = ['Tim Teknologi Media Baru', 'Tim IT'];
                    foreach ($divisions as $divIdx => $divName): 
                        $members = $grouped_teams[$divName] ?? [];
                        $leader = null;
                        $staff = [];
                        foreach ($members as $m) {
                            if (($m['role'] ?? '') === 'leader') $leader = $m;
                            else $staff[] = $m;
                        }
                    ?>
                    <!-- Division Column -->
                    <div class="relative flex flex-col items-center">
                        <!-- Vertical line from connector to leader -->
                        <div class="absolute -top-8 left-1/2 -ml-0.5 w-0.5 h-8 bg-blue-500 hidden lg:block shadow-sm"></div>

                        <!-- Division Leader -->
                        <div class="z-10 mb-2" data-aos="fade-up" data-aos-delay="<?= $divIdx * 100 ?>">
                            <?php if ($leader): ?>
                            <div class="bg-white dark:bg-[#0f172a] rounded-2xl p-5 border-2 border-blue-500/20 dark:border-blue-400/30 shadow-xl text-center w-56 transform transition-all hover:scale-105 relative">
                                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-blue-500 text-white text-[10px] font-bold uppercase rounded-full shadow-md">
                                    Ketua <?= ($divIdx == 0) ? 'TMB' : 'IT' ?>
                                </div>
                                <div class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden border-2 border-blue-100 dark:border-blue-900/50">
                                    <?php if (!empty($leader['photo'])): ?>
                                        <img src="<?= base_url(strpos($leader['photo'], 'assets') !== false ? $leader['photo'] : 'assets/uploads/' . $leader['photo']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xl font-bold">
                                            <?= substr($leader['name'], 0, 1) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm leading-tight"><?= htmlspecialchars($leader['name']) ?></h4>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-1"><?= htmlspecialchars($leader['position']) ?></p>
                            </div>
                            <?php else: ?>
                            <div class="w-48 h-20 border-2 border-dashed border-gray-300 dark:border-slate-700 rounded-xl flex items-center justify-center text-gray-400 text-xs italic">
                                Ketua Belum Ditentukan
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Line and Capsule to Members -->
                        <?php if (!empty($staff)): ?>
                        <div class="relative flex flex-col items-center w-full z-10">
                            <!-- Line connecting Leader to Members -->
                            <div class="h-8 w-0.5 bg-blue-500 shadow-sm"></div>
                            
                            <!-- Capsule Badge (Solid Blue Background) -->
                            <div class="-mb-3 z-20">
                                <span class="px-5 py-1.5 bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-full border-4 border-gray-50 dark:border-slate-900 shadow-md">
                                    Anggota Tim <?= ($divIdx == 0) ? 'TMB' : 'IT' ?>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Division Staff Grid (Compact & Centered) -->
                        <div class="inline-block max-w-[90%] md:max-w-3xl bg-white dark:bg-[#0f172a]/50 rounded-2xl p-4 border border-blue-100 dark:border-white/5 relative mt-0" data-aos="fade-up" data-aos-delay="<?= $divIdx * 150 + 100 ?>">
                            <!-- Top subtle highlight -->
                            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>
                            
                            <!-- Grid container for 4 items per row -->
                            <div class="grid grid-cols-4 gap-3 pt-3 justify-items-center">
                                <?php if (empty($staff)): ?>
                                    <div class="col-span-4 py-2 text-center text-[10px] text-gray-400 italic">Belum ada anggota</div>
                                <?php else: ?>
                                    <?php foreach ($staff as $sIdx => $s): ?>
                                    <div class="w-20 md:w-24 bg-white dark:bg-[#0f172a] rounded-lg p-2 border border-gray-200 dark:border-white/10 shadow-sm hover:shadow hover:-translate-y-0.5 transition-all duration-300 text-center group relative overflow-hidden flex-shrink-0">
                                        <!-- Top Accent -->
                                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-80"></div>
                                        
                                        <div class="w-10 h-10 mx-auto mb-2 rounded-xl overflow-hidden ring-1 ring-gray-100 dark:ring-slate-700 group-hover:ring-blue-400 dark:group-hover:ring-blue-500 transition-all">
                                            <?php if (!empty($s['photo'])): ?>
                                                <img src="<?= base_url(strpos($s['photo'], 'assets') !== false ? $s['photo'] : 'assets/uploads/' . $s['photo']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-400 dark:text-gray-500 text-xs font-bold">
                                                    <?= substr($s['name'], 0, 1) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <h6 class="text-[9px] font-bold text-gray-900 dark:text-white line-clamp-2 h-6 leading-tight flex items-center justify-center"><?= htmlspecialchars($s['name']) ?></h6>
                                        <p class="text-[7px] text-gray-500 dark:text-gray-400 line-clamp-1 mt-0.5"><?= htmlspecialchars($s['position']) ?></p>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>
        
    </div>
</section>

<!-- Join Team CTA -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 dark:from-[#0f172a]/80 dark:to-[#0f172a]/80 relative overflow-hidden" data-aos="fade-in">
    <!-- Grid pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="join-grid" width="30" height="30" patternUnits="userSpaceOnUse">
                    <path d="M 30 0 L 0 0 0 30" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#join-grid)"/>
        </svg>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in">
        <h2 class="text-2xl font-bold text-white mb-4">Bergabung dengan Tim Kami?</h2>
        <p class="text-blue-100 dark:text-gray-400 mb-6">Kami selalu mencari talenta terbaik untuk memperkuat tim CSIRT RRI</p>
        <a href="<?= base_url('kontak') ?>" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-medium rounded-lg hover:bg-blue-50 shadow-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Hubungi Kami
        </a>
    </div>
</section>
