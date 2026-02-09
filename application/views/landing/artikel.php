<!-- =====================================================
     Artikel List Page
     ===================================================== -->

<main class="pt-24 pb-16 bg-gray-50 dark:bg-[#020617] min-h-screen">
    <section class="relative pt-32 pb-16 bg-white dark:bg-[#020617] overflow-hidden">
    <!-- Cinematic Background (Dark Only) -->
    <div class="absolute inset-0 z-0 pointer-events-none hidden dark:block">
        <div class="absolute inset-0 cyber-grid opacity-20"></div>
        <div class="absolute inset-0 diagonal-light"></div>
        <div class="absolute top-[-100px] left-1/2 -translate-x-1/2 w-full h-[400px] top-spotlight opacity-50"></div>
        <div class="absolute top-[40%] left-1/2 -translate-x-1/2 w-[800px] h-[800px] center-glow opacity-30"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">Artikel</h1>
            <p class="text-gray-500 dark:text-gray-400">Informasi, panduan, dan pengumuman keamanan siber</p>
        </div>
        
        <!-- Category Filter -->
        <div class="flex flex-wrap gap-2 mb-8" data-aos="fade-up">
            <?php 
                // Fungsi helper untuk menentukan class aktif
                $activeClass = 'btn-gradient text-white';
                $inactiveClass = 'bg-white dark:bg-[#0f172a] text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-white/10 hover:border-blue-300';
            ?>
            <a href="<?= base_url('artikel') ?>" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition-colors 
                      <?= empty($kategori) ? $activeClass : $inactiveClass ?>">
                Semua
            </a>
            <a href="<?= base_url('artikel/kategori/keamanan') ?>" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition-colors 
                      <?= $kategori === 'keamanan' ? $activeClass : $inactiveClass ?>">
                Keamanan
            </a>
            <a href="<?= base_url('artikel/kategori/panduan') ?>" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition-colors 
                      <?= $kategori === 'panduan' ? $activeClass : $inactiveClass ?>">
                Panduan
            </a>
            <a href="<?= base_url('artikel/kategori/pengumuman') ?>" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition-colors 
                      <?= $kategori === 'pengumuman' ? $activeClass : $inactiveClass ?>">
                Pengumuman
            </a>
            <a href="<?= base_url('artikel/kategori/laporan') ?>" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition-colors 
                      <?= $kategori === 'laporan' ? $activeClass : $inactiveClass ?>">
                Laporan
            </a>
        </div>
        
        <!-- Articles Grid -->
        <?php if (!empty($articles)): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($articles as $index => $article): ?>
            <article class="bg-white dark:bg-[#0f172a] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden hover-lift group" data-aos="fade-up">
                <!-- Image Placeholder -->
                <div class="relative h-48 bg-gradient-to-br from-blue-500 to-blue-700 overflow-hidden">
                    <?php if (!empty($article['thumbnail'])): ?>
                        <?php 
                            $thumb = $article['thumbnail'];
                            if (strpos($thumb, 'assets/') === false) $thumb = 'assets/uploads/' . $thumb;
                        ?>
                        <img src="<?= base_url($thumb) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <!-- Category Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-white/90 dark:bg-[#020617]/90 text-blue-600 dark:text-blue-400 text-xs font-semibold rounded-full shadow-sm">
                            <?= htmlspecialchars($article['category']) ?>
                        </span>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-5">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span><?= date('d M Y', strtotime($article['created_at'])) ?></span>
                        <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                        <span>CSIRT Team</span>
                    </div>
                    
                    <h2 class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                        <?= htmlspecialchars($article['title']) ?>
                    </h2>
                    
                    <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                        <?= htmlspecialchars(strip_tags($article['content'])) ?>
                    </p>
                    
                    <a href="<?= base_url('artikel/detail/' . $article['id']) ?>" 
                       class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 text-sm font-medium hover:gap-2 transition-all">
                        Baca Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada artikel dalam kategori ini.</p>
        </div>
        <?php endif; ?>
    </div>
    </div>
    </section>
</main>
