<!-- =====================================================
     Home Page - Full Height Hero with Dark Mode Support
     ===================================================== -->

<!-- Hero Section - FULL VIEWPORT HEIGHT -->
<section class="relative min-h-screen flex items-center overflow-hidden bg-white dark:bg-[#020617] pt-20 lg:pt-0">
    <!-- Cinematic Entrance & Atmospheric Styles -->
    <style>
        /* Initial navy dark state */
        .cinematic-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            animation: curtain-up 1.2s cubic-bezier(0.7, 0, 0.3, 1) forwards;
            pointer-events: none;
        }

        @keyframes curtain-up {
            0% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }

        @keyframes reveal-sharpen-sweep {
            0% { 
                filter: blur(40px) brightness(0.5); 
                opacity: 0; 
                transform: scale(1.05); 
            }
            100% { 
                filter: blur(0) brightness(1); 
                opacity: 1; 
                transform: scale(1); 
            }
        }

        .reveal-sweep {
            animation: reveal-sharpen-sweep 2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            will-change: filter, opacity, transform;
        }

        .delay-sweep-1 { animation-delay: 0.3s; }
        .delay-sweep-2 { animation-delay: 0.4s; }
        .delay-sweep-3 { animation-delay: 0.5s; }
        .delay-sweep-4 { animation-delay: 0.6s; }

        /* Intensified Center Glow - Circular Like Image */
        .center-glow {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 1000px;
            height: 1000px;
            background: radial-gradient(circle, rgba(30, 64, 175, 0.25) 0%, rgba(30, 64, 175, 0.1) 30%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 1;
            animation: pulse-glow 8s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            to { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
        }

        /* 3D Directional Light */
        .diagonal-light {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, transparent 50%, rgba(0, 0, 0, 0.2) 100%);
            pointer-events: none;
            z-index: 2;
        }

        .top-spotlight {
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 400px;
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 1;
        }

        .grid-entrance {
            animation: grid-reveal 3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes grid-reveal {
            from { opacity: 0; transform: scale(1.1); }
            to { opacity: 1; transform: scale(1); }
        }

        .cyber-grid {
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        /* 3D Orbit Particles */
        @keyframes orbit-3d {
            0% { transform: rotateY(0deg) translateX(220px) rotateY(0deg) scale(0.8); z-index: 5; opacity: 0.4; }
            25% { opacity: 1; z-index: 30; }
            50% { transform: rotateY(180deg) translateX(220px) rotateY(-180deg) scale(1.2); z-index: 30; opacity: 1; }
            75% { opacity: 0.4; z-index: 5; }
            100% { transform: rotateY(360deg) translateX(220px) rotateY(-360deg) scale(0.8); z-index: 5; opacity: 0.4; }
        }

        .orbit-container {
            position: absolute;
            inset: 0;
            transform-style: preserve-3d;
            pointer-events: none;
        }
        
        .light-particle {
            position: absolute;
            top: 45%; 
            left: 45%;
            width: 12px;
            height: 12px;
            background: rgb(96, 165, 250); /* Blue-400 */
            border-radius: 50%;
            box-shadow: 0 0 20px 5px rgba(59, 130, 246, 0.8);
            animation: orbit-3d 6s linear infinite;
        }
        .light-particle.p2 {
            animation-delay: -2s;
            background: rgb(250, 250, 250);
            box-shadow: 0 0 20px 5px rgba(255, 255, 255, 0.8);
        }
        .light-particle.p3 {
            animation-delay: -4s;
            background: rgb(167, 139, 250);
            box-shadow: 0 0 20px 5px rgba(139, 92, 246, 0.8);
        }
        /* Text Animations */
        @keyframes text-flow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-text {
            background-size: 200% auto;
            animation: text-flow 3s linear infinite;
        }
        
        @keyframes float-text {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-float-text {
            animation: float-text 5s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse-slow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: .7; }
        }
        
        /* Button Shine Animation */
        @keyframes shine {
            0% { left: -100%; opacity: 0; }
            5% { left: -100%; opacity: 0.5; }
            50% { left: 100%; opacity: 0.5; }
            100% { left: 100%; opacity: 0; }
        }
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            animation: shine 3s infinite;
            pointer-events: none;
        }
    </style>

    <!-- Initial Loading State Overlay -->
    <div class="cinematic-overlay bg-white dark:bg-[#020617]"></div>

    <!-- Atmospheric Overlays -->
    <div class="center-glow hidden dark:block"></div>
    <div class="top-spotlight hidden dark:block"></div>
    <div class="diagonal-light hidden dark:block"></div>
    
    <!-- Grid Pattern -->
    <div class="absolute inset-0 z-0 grid-entrance">
        <div class="w-full h-full cyber-grid"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Text Content -->
            <div class="order-2 lg:order-1 text-center lg:text-left">
                <!-- Badge -->
                <div class="reveal-sweep delay-sweep-1 inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-white/5 backdrop-blur-xl rounded-full mb-6 border border-blue-200 dark:border-white/10">
                    <span class="relative flex h-2 w-2">
                       <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                       <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-blue-700 dark:text-blue-300 text-sm font-semibold tracking-wide">Tim CSIRT Aktif 24/7</span>
                </div>
                
                <!-- Main Heading -->
                <h1 class="reveal-sweep delay-sweep-2 text-4xl sm:text-5xl md:text-7xl font-bold text-gray-900 dark:text-white mb-6 leading-[1.05] tracking-tight">
                    <span class="inline-block animate-float-text">Computer Security</span><br>
                    <span class="animate-gradient-text text-blue-600 dark:text-blue-400 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-blue-400 to-blue-600 dark:from-blue-400 dark:via-blue-200 dark:to-blue-400 drop-shadow-sm pb-2">Incident Response Team</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="reveal-sweep delay-sweep-3 text-lg text-gray-600 dark:text-blue-100/50 max-w-2xl mx-auto lg:mx-0 mb-10 leading-relaxed font-medium">
                    <span class="animate-pulse-slow block">
                        Portal informasi keamanan siber internal Radio Republik Indonesia. 
                        Akses artikel, panduan, dan wawasan keamanan digital dengan mudah dan cepat.
                    </span>
                </p>
                
                <!-- CTA Buttons -->
                <div class="reveal-sweep delay-sweep-4 flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start gap-4">
                    <a href="<?= base_url('auth/login') ?>" 
                       class="btn-shine w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-xl 
                              hover:bg-blue-700 shadow-lg hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-300 flex items-center justify-center gap-2 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk Dashboard
                    </a>
                    <a href="#articles" 
                       class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-white/5 text-blue-600 dark:text-white font-bold rounded-xl border-2 border-blue-200 dark:border-white/10
                              hover:bg-blue-50 dark:hover:bg-white/10 transition-all duration-300 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        Lihat Artikel
                    </a>
                </div>
            </div>
            
            <!-- Hero Image/Illustration - Right Side -->
            <div class="reveal-sweep delay-sweep-4 order-1 lg:order-2 flex justify-center lg:justify-end">
                <div class="relative w-56 md:w-72 lg:w-[400px] animate-float z-10" style="transform-style: preserve-3d;">
                    <!-- Particles -->
                    <div class="orbit-container">
                        <div class="light-particle"></div>
                        <div class="light-particle p2"></div>
                        <div class="light-particle p3"></div>
                    </div>

                    <!-- Phone Image -->
                    <img src="<?= base_url('assets/img/phone.png') ?>" alt="CSIRT Mobile App" class="relative z-10 w-full drop-shadow-2xl">
                    
                    <!-- Floating Stats Card (Bottom Left) -->
                    <div class="absolute bottom-10 -left-6 md:left-0 bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-4 pr-6 rounded-2xl shadow-2xl border border-gray-100 dark:border-white/10 z-20 animate-bounce" style="animation-duration: 3s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-500/20 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Status Sistem</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Aman & Terlindungi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Glow Back -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-blue-500/20 dark:bg-blue-600/20 blur-3xl -z-10 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="reveal-anim delay-4 absolute bottom-10 inset-x-0 z-20 hidden md:flex justify-center">
        <a href="#articles" class="flex flex-col items-center gap-2 text-blue-500 dark:text-white/40 hover:text-blue-600 dark:hover:text-blue-300 transition-colors group">
            <span class="text-xs font-bold tracking-[0.2em] uppercase">Scroll</span>
            <div class="animate-bounce">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </a>
    </div>
</section>

<!-- ============================================= -->
<!-- ARTIKEL SECTION - STARTS AFTER HERO          -->
<!-- ============================================= -->
<section id="articles" class="py-20 bg-white dark:bg-[#020617]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-10" data-aos="fade-up">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Artikel Terbaru</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Informasi dan panduan keamanan siber</p>
            </div>
            <a href="<?= base_url('artikel') ?>" class="hidden sm:flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <!-- Articles Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($recent_articles)): ?>
                <div class="col-span-3 text-center py-10" data-aos="fade-in">
                    <p class="text-gray-500">Belum ada artikel terbaru.</p>
                </div>
            <?php else: ?>
                <?php foreach ($recent_articles as $index => $article): ?>
                    <!-- Article Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md dark:shadow-none border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-lg dark:hover:border-slate-600 transition-all group <?= $index === 0 ? 'lg:col-span-2 lg:row-span-2' : '' ?>" 
                         data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <!-- Image Placeholder -->
                        <div class="relative <?= $index === 0 ? 'h-64 lg:h-80' : 'h-40' ?> bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-600 dark:to-blue-900 overflow-hidden">
                            <?php if (!empty($article['thumbnail'])): ?>
                                <img src="<?= base_url($article['thumbnail']) ?>" alt="<?= $article['title'] ?>" class="w-full h-full object-cover" loading="lazy">
                            <?php else: ?>
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-white/40">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($index === 0): ?>
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow">TERBARU</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-<?= $index === 0 ? '6' : '5' ?>">
                            <div class="flex items-center gap-3 text-sm text-gray-400 dark:text-gray-500 mb-3">
                                <span><?= date('d M Y', strtotime($article['created_at'])) ?></span>
                                <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                                <span class="text-blue-600 dark:text-blue-400"><?= $article['category'] ?? 'Informasi' ?></span>
                            </div>
                            <h3 class="<?= $index === 0 ? 'text-xl lg:text-2xl' : 'font-bold' ?> font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                <?= $article['title'] ?>
                            </h3>
                            <?php if ($index === 0): ?>
                            <p class="text-gray-500 dark:text-gray-400 line-clamp-3 mb-4">
                                <?= strip_tags($article['content']) ?>
                            </p>
                            <?php endif; ?>
                            
                            <a href="<?= base_url('artikel/detail/' . $article['id']) ?>" class="inline-flex items-center gap-2 <?= $index === 0 ? 'mt-0' : '' ?> text-blue-600 dark:text-blue-400 font-medium hover:gap-3 transition-all">
                                <?= $index === 0 ? 'Baca Selengkapnya' : 'Baca →' ?>
                                <?php if ($index === 0): ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Mobile View All -->
        <div class="mt-8 text-center sm:hidden" data-aos="fade-up">
            <a href="<?= base_url('artikel') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>

<!-- Categories - Light Blue Tint in Light Mode -->
<section class="py-20 bg-gradient-to-b from-blue-50 to-white dark:from-[#020617] dark:to-[#020617]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">Kategori Informasi</h2>
            <p class="text-gray-500 dark:text-gray-400">Jelajahi artikel berdasarkan kategori</p>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="<?= base_url('artikel?kategori=keamanan') ?>" class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md transition-all group text-center"
               data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 mx-auto bg-red-50 dark:bg-red-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Keamanan</h3>
                <p class="text-sm text-gray-400"><?= $article_counts['keamanan'] ?> Artikel</p>
            </a>
            
            <a href="<?= base_url('artikel?kategori=panduan') ?>" class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md transition-all group text-center"
               data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 mx-auto bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Panduan</h3>
                <p class="text-sm text-gray-400"><?= $article_counts['panduan'] ?> Artikel</p>
            </a>
            
            <a href="<?= base_url('artikel?kategori=pengumuman') ?>" class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md transition-all group text-center"
               data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 mx-auto bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Pengumuman</h3>
                <p class="text-sm text-gray-400"><?= $article_counts['pengumuman'] ?> Artikel</p>
            </a>
            
            <a href="<?= base_url('artikel?kategori=berita') ?>" class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md transition-all group text-center"
               data-aos="fade-up" data-aos-delay="400">
                <div class="w-14 h-14 mx-auto bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Berita</h3>
                <p class="text-sm text-gray-400"><?= $article_counts['berita'] > 0 ? $article_counts['berita'] . ' Artikel' : 'Update Terbaru' ?></p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 hero-gradient relative overflow-hidden" data-aos="fade-in">
    <!-- Grid Pattern -->
    <div class="absolute inset-0 opacity-20 dark:opacity-30">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="cta-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cta-grid)"/>
        </svg>
    </div>
    
    <!-- Glow for dark mode -->
    <div class="hero-glow hidden dark:block"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4" data-aos="fade-up">
            Pusat Literasi Keamanan
        </h2>
        <p class="text-blue-100 dark:text-blue-200/80 mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Tingkatkan pemahaman keamanan siber Anda. Akses panduan, kebijakan, dan prosedur keamanan
            terbaru melalui dashboard internal kami.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
            <a href="<?= base_url('auth/login') ?>" 
               class="px-8 py-4 bg-white text-blue-700 dark:text-blue-900 font-semibold rounded-xl 
                      hover:bg-blue-50 shadow-lg transition-all duration-300">
                Akses Dashboard
            </a>
            <a href="<?= base_url('kontak') ?>" 
               class="px-8 py-4 bg-white/10 dark:bg-white/5 text-white font-semibold rounded-xl border border-white/30 dark:border-white/10
                      hover:bg-white/20 dark:hover:bg-white/10 transition-all duration-300">
                Hubungi Tim
            </a>
        </div>
    </div>
</section>
