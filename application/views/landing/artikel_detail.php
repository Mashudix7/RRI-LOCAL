<!-- =====================================================
     Artikel
     ===================================================== -->

<main class="pt-24 pb-16 bg-white dark:bg-[#020617] min-h-screen">
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <a href="<?= base_url('artikel') ?>" class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Artikel
        </a>
        
        <!-- Article Header -->
        <header class="mb-8" data-aos="fade-up">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 btn-gradient text-white text-xs font-semibold rounded-full">
                    <?= htmlspecialchars($article['category']) ?>
                </span>
                <?php if ($article['is_featured']): ?>
                <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-semibold rounded-full">
                    PENTING
                </span>
                <?php endif; ?>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                <?= htmlspecialchars($article['title']) ?>
            </h1>
            
            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 btn-gradient rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <span>CSIRT Team</span>
                </div>
                <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                <span><?= date('d M Y', strtotime($article['created_at'])) ?></span>
            </div>
        </header>
        
        <!-- Featured Image Placeholder -->
        <div class="relative h-64 md:h-96 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl overflow-hidden mb-8" data-aos="fade-up" data-aos-delay="100">
            <?php if (!empty($article['thumbnail'])): ?>
                <?php 
                    $thumb = $article['thumbnail'];
                    if (strpos($thumb, 'assets/') === false) $thumb = 'assets/uploads/articles/' . $thumb;
                ?>
                <img src="<?= base_url($thumb) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover" loading="lazy" decoding="async">
            <?php else: ?>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-24 h-24 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Article Content -->
        <div class="prose prose-lg dark:prose-invert max-w-none mb-12" data-aos="fade-up" data-aos-delay="200">
            <style>
                .prose h3 { @apply text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4; }
                .prose p { @apply text-gray-600 dark:text-gray-300 mb-4 leading-relaxed; }
                .prose ul { @apply list-disc list-inside space-y-2 mb-6 text-gray-600 dark:text-gray-300; }
                .prose li { @apply leading-relaxed; }
            </style>
            <?= $article['content'] ?>
        </div>
        
        <!-- Share & Actions -->
        <div class="flex items-center justify-between py-6 border-t border-b border-gray-200 dark:border-white/10 mb-12">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Artikel ini bermanfaat? Bagikan kepada rekan kerja.
            </div>
            <div class="flex items-center gap-3">
                <button onclick="navigator.clipboard.writeText(window.location.href)" 
                        class="px-4 py-2 bg-gray-100 dark:bg-[#0f172a] text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-800 transition-colors text-sm font-medium">
                    Salin Link
                </button>
            </div>
        </div>
        
        <!-- Related Articles -->
        <?php if (!empty($related_articles)): ?>
        <section data-aos="fade-up" data-aos-delay="300">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Artikel Lainnya</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <?php foreach ($related_articles as $rel): ?>
                    <a href="<?= base_url('artikel/' . $rel['id']) ?>" class="bg-gray-50 dark:bg-[#0f172a] rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors group">
                        <span class="text-xs text-blue-600 dark:text-blue-400 font-medium"><?= htmlspecialchars($rel['category']) ?></span>
                        <h3 class="font-semibold text-gray-900 dark:text-white mt-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            <?= htmlspecialchars($rel['title']) ?>
                        </h3>
                        <span class="text-xs text-gray-400 mt-2 block"><?= date('d M Y', strtotime($rel['created_at'])) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </article>
</main>
