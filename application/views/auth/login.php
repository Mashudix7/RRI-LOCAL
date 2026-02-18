<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - CSIRT RRI">
    <title>Login | CSIRT RRI</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            800: '#0d1b2a',
                            900: '#0a1628',
                            950: '#060d17',
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
    
    <style>
        /* Prevent scrolling on login page */
        html, body {
            overflow: hidden;
            height: 100%;
        }

        /* Deep dark gradient background */
        .navy-gradient {
            background: linear-gradient(135deg, #020617 0%, #050d1a 30%, #0a1628 60%, #0d1b2a 100%);
        }
        
        /* Cyber Grid (same as landing hero) */
        .cyber-grid {
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
            -webkit-mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            animation: grid-fade-in 2s ease-out forwards;
        }

        @keyframes grid-fade-in {
            from { opacity: 0; transform: scale(1.05); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Atmospheric glow */
        .center-glow {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(30, 64, 175, 0.15) 0%, rgba(30, 64, 175, 0.05) 30%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 1;
            animation: pulse-glow 8s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from { transform: translate(-50%, -50%) scale(1); opacity: 0.6; }
            to { transform: translate(-50%, -50%) scale(1.15); opacity: 1; }
        }

        .diagonal-light {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.01) 0%, transparent 50%, rgba(0, 0, 0, 0.3) 100%);
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
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.06) 0%, transparent 70%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 1;
        }

        .hero-glow {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 400px;
            background: radial-gradient(ellipse, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        /* Gradient text - Blue accent */
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Input focus effect */
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        
        /* Glow effect */
        .glow {
            box-shadow: 0 0 80px rgba(59, 130, 246, 0.1);
        }

        /* ===== ENTRANCE ANIMATIONS ===== */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(30px); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .anim-fade-up {
            opacity: 0;
            animation: fade-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .anim-delay-1 { animation-delay: 0.1s; }
        .anim-delay-2 { animation-delay: 0.25s; }
        .anim-delay-3 { animation-delay: 0.4s; }
        .anim-delay-4 { animation-delay: 0.6s; }

        /* Slow rotate for decorative rings */
        @keyframes slow-spin {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .ring-rotate {
            animation: slow-spin 60s linear infinite;
        }
        .ring-rotate-reverse {
            animation: slow-spin 90s linear infinite reverse;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- =====================================================
         Login Page - Navy Gradient Theme
         ===================================================== -->
    
    <div class="h-screen navy-gradient flex items-center justify-center px-4 relative overflow-hidden">
        <!-- Cyber Grid Pattern -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full cyber-grid"></div>
        </div>

        <!-- Atmospheric Overlays -->
        <div class="center-glow"></div>
        <div class="top-spotlight"></div>
        <div class="diagonal-light"></div>
        <div class="hero-glow"></div>
        
        <!-- Glow Effects -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-blue-600/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <!-- Decorative Rings (animated) -->
        <div class="absolute top-1/2 left-1/2 w-[500px] h-[500px] border border-white/[0.04] rounded-full pointer-events-none ring-rotate"></div>
        <div class="absolute top-1/2 left-1/2 w-[700px] h-[700px] border border-white/[0.02] rounded-full pointer-events-none ring-rotate-reverse"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] border border-white/[0.01] rounded-full pointer-events-none"></div>
        
        <div class="relative z-10 w-full max-w-md">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <a href="<?= base_url() ?>" class="anim-fade-up anim-delay-1 inline-flex items-center gap-3 group mb-6">
                    <img src="<?= base_url('assets/img/logo_rri.png') ?>" alt="Logo RRI" 
                         class="w-12 h-12 object-contain rounded-xl group-hover:scale-110 transition-transform duration-300 drop-shadow-2xl">
                    <div class="text-left">
                        <span class="text-2xl font-bold text-white"> CSIRT</span>
                    </div>
                </a>
                <h1 class="anim-fade-up anim-delay-2 text-2xl font-bold text-white mb-2">Selamat Datang</h1>
                <p class="anim-fade-up anim-delay-2 text-slate-500">Masuk ke dashboard untuk melanjutkan</p>
            </div>
            
            <!-- Login Card -->
            <div class="anim-fade-up anim-delay-3 glass rounded-2xl p-8 glow">
                <!-- Error Message -->
                <?php if (!empty($error)): ?>
                    <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-red-300 text-sm"><?= $error ?></span>
                    </div>
                <?php endif; ?>
                
                <!-- Success Message -->
                <?php if (!empty($success)): ?>
                    <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-300 text-sm"><?= $success ?></span>
                    </div>
                <?php endif; ?>
                
                <!-- Login Form -->
                <form action="<?= base_url('auth/authenticate') ?>" method="POST" class="space-y-6">
                    <!-- CSRF Token -->
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-slate-300 text-sm font-medium mb-2">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" id="username" name="username" required autofocus
                                   class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500
                                          focus:outline-none focus:border-blue-500 input-focus transition-all duration-300"
                                   placeholder="Masukkan username">
                        </div>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-slate-300 text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-12 pr-12 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500
                                          focus:outline-none focus:border-blue-500 input-focus transition-all duration-300"
                                   placeholder="Masukkan password">
                            <!-- Toggle Password Visibility -->
                            <button type="button" onclick="togglePassword()" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-slate-300 transition-colors">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl 
                                   hover:from-blue-500 hover:to-blue-600 hover:shadow-xl hover:shadow-blue-500/30 
                                   transition-all duration-300 hover:scale-[1.02]
                                   flex items-center justify-center gap-2">
                        <span>Masuk</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>
                
                <!-- Demo Credentials Notice Removed -->
            </div>
            
            <!-- Back to Home -->
            <div class="anim-fade-up anim-delay-4 text-center mt-6">
                <a href="<?= base_url() ?>" class="text-slate-500 hover:text-blue-400 transition-colors text-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
    
    <!-- Alpine.js for Toast -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Toast Notification for Login Page - Centered & Themed -->
    <?php 
        $is_logout = $this->input->get('logout') === 'success';
    ?>
    <?php if ($is_logout): ?>
    <div x-data="{ show: false }" 
         x-init="
            // Clear all AOS session storage keys on logout
            Object.keys(sessionStorage).forEach(key => {
                if (key.startsWith('aos_seen_')) {
                    sessionStorage.removeItem(key);
                }
            });
            
            // Show toast
            setTimeout(() => { show = true }, 300);
            setTimeout(() => { show = false }, 5000);
         "
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 transform -translate-y-8"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-8"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 text-white rounded-2xl shadow-2xl shadow-slate-500/30 w-full max-w-lg border border-slate-600/30 mx-4">
        <div class="flex-shrink-0 w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center backdrop-blur-sm p-2">
            <img src="<?= base_url('assets/img/logo-rri.png') ?>" alt="RRI Logo" class="w-full h-full object-contain">
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-base">Logout Berhasil</p>
            <p class="text-slate-300 text-sm">Anda telah berhasil keluar dari sistem.</p>
        </div>
        <button @click="show = false" class="flex-shrink-0 text-white/60 hover:text-white transition-colors p-1 hover:bg-white/10 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <?php endif; ?>
</body>
</html>
