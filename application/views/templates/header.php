<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CSIRT RRI - Tim Tanggap Insiden Keamanan Siber Radio Republik Indonesia">
    <title><?= isset($title) ? $title . ' | ' : '' ?>CSIRT RRI</title>
    <link rel="preload" as="image" href="<?= base_url('assets/img/favicon.png') ?>">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
    
    <!-- DNS Prefetch & Preconnect for Performance -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- CRITICAL: Theme Initialization -->
    <script>
        // Check for saved theme or system preference
        if (localStorage.getItem('darkMode') === 'true' || 
           (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
        }
    </script>
    
    <!-- Alpine.js for theme toggle -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        accent: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library - Deferred for performance -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script defer src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <!-- Custom Styles -->
    <style>
        /* =====================================================
         * CSIRT RRI - Theme System
         * Light: White + Blue Accent
         * Dark: Navy + Blue Glow
         * ===================================================== */
        
        html { 
            scroll-behavior: smooth; 
            overflow-y: scroll; /* Fix layout jumping */
            overflow-x: hidden; /* Fix horizontal scroll */
        }
        body {
            overflow-x: hidden; /* Double protection */
            width: 100%;
        }
        
        /* Alpine.js cloak - hide elements until Alpine loads */
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Prevent navbar layout shift on load */
        #navbar {
            min-height: 64px; /* h-16 = 64px */
        }
        
        /* Performance: GPU acceleration for animations */
        [data-aos] {
            will-change: transform, opacity;
        }
        
        /* Performance: Contain layout for isolated sections */
        section {
            contain: layout style;
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Gradient Button */
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 50%, #1e3a8a 100%);
        }
        
        /* ===== NAVBAR UNDERLINE ANIMATION ===== */
        .nav-link {
            position: relative;
            padding: 0.5rem 0;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        .nav-link.active {
            color: #3b82f6;
        }
        .dark .nav-link.active {
            color: #60a5fa;
        }
        .dark .nav-link::after {
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
        }
        
        /* ===== HERO GRADIENT ===== */
        /* Light mode hero */
        .hero-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        }
        
        /* Dark mode hero - Navy with glow */
        .dark .hero-gradient {
            background: linear-gradient(135deg, #0a1628 0%, #0d1b2a 50%, #0f172a 100%);
        }
        
        /* Glow effect for dark mode */
        .dark .hero-glow {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 400px;
            background: radial-gradient(ellipse, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #93c5fd; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #60a5fa; }
        
        .dark ::-webkit-scrollbar-track { background: #0f172a; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        
        /* Fade in animation */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Hover lift */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.15);
        }
        .dark .hover-lift:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
        }
        /* =========================================
           GLOBAL ANIMATIONS & CINEMATIC STYLES
           ========================================= */

        /* Cinematic Overlay (Curtain Up) */
        .cinematic-overlay {
            position: fixed;
            inset: 0;
            /* bg color handled by utility classes in HTML */
            z-index: 9999;
            animation: curtain-up 1.2s cubic-bezier(0.7, 0, 0.3, 1) forwards;
            pointer-events: none;
        }

        @keyframes curtain-up {
            0% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }
        
        /* Reveal Sharpen Sweep Animation */
        @keyframes reveal-sharpen-sweep {
            0% { 
                filter: blur(20px) brightness(0.7); 
                opacity: 0; 
                transform: scale(1.02); 
            }
            100% { 
                filter: blur(0) brightness(1); 
                opacity: 1; 
                transform: scale(1); 
            }
        }

        .reveal-sweep {
            animation: reveal-sharpen-sweep 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            will-change: filter, opacity, transform;
        }

        /* Hero specific slower animation */
        .reveal-sweep-hero {
            animation: reveal-sharpen-sweep 2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            will-change: filter, opacity, transform;
        }

        /* Staggered Delays */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        /* Global Glow & Lighting Effects */
        .glow-spot { /* Legacy support */
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }

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

        /* Cyber Grid Background */
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
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); document.documentElement.classList.toggle('dark', val) }); document.documentElement.classList.toggle('dark', darkMode)"
      class="font-sans antialiased bg-white dark:bg-[#020617] text-gray-900 dark:text-gray-100 transition-colors duration-300">
    
    <!-- Page Wrapper - Prevents horizontal overflow -->
    <div id="page-wrapper" class="w-full max-w-full overflow-x-hidden">
