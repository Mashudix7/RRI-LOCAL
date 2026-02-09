<!-- =====================================================
     Navigation Bar - Underline Animation Style
     ===================================================== -->
<nav id="navbar" class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-7xl transition-all duration-300 bg-white/80 dark:bg-[#020617]/70 backdrop-blur-xl border border-gray-100 dark:border-white/10 rounded-2xl shadow-xl dark:shadow-2xl dark:shadow-black/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="<?= base_url() ?>" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center 
                            group-hover:scale-110 transition-transform duration-300 shadow-md overflow-hidden">
                    <img src="<?= base_url('assets/img/logo_rri.png') ?>" alt="Logo RRI" class="w-full h-full object-contain p-1">
                </div>
                <div>
                    <span class="text-xl font-bold text-gray-700 dark:text-white"> CSIRT</span>
                </div>
            </a>
            
            <!-- Desktop Navigation with Underline Animation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="<?= base_url() ?>" 
                   class="nav-link text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors <?= $this->uri->segment(1) == '' ? 'active' : '' ?>">
                    Beranda
                </a>
                <a href="<?= base_url('artikel') ?>" 
                   class="nav-link text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors <?= $this->uri->segment(1) == 'artikel' ? 'active' : '' ?>">
                    Artikel
                </a>
                <a href="<?= base_url('tentang') ?>" 
                   class="nav-link text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors <?= $this->uri->segment(1) == 'tentang' ? 'active' : '' ?>">
                    Tentang
                </a>
                <a href="<?= base_url('tim') ?>" 
                   class="nav-link text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors <?= $this->uri->segment(1) == 'tim' ? 'active' : '' ?>">
                    Tim
                </a>
                <a href="<?= base_url('kontak') ?>" 
                   class="nav-link text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors <?= $this->uri->segment(1) == 'kontak' ? 'active' : '' ?>">
                    Kontak
                </a>
            </div>
            
            <div class="hidden md:flex items-center gap-3">
                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                        class="p-2.5 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors">
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
                
                <!-- Auth Status -->
                <?php if ($this->session->userdata('logged_in')): ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white"><?= $this->session->userdata('username') ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?= $this->session->userdata('role_name') ?? ucfirst($this->session->userdata('role')) ?></p>
                            </div>
                            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-blue-500 shadow-sm">
                                <?php $avatar = $this->session->userdata('avatar'); ?>
                                <?php if (!empty($avatar) && $avatar !== 'default_avatar.png'): ?>
                                    <img src="<?= base_url('uploads/avatars/' . $avatar) ?>" alt="Profile" class="w-full h-full object-cover" decoding="async">
                                <?php else: ?>
                                    <div class="w-full h-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                        <?= strtoupper(substr($this->session->userdata('username'), 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </button>
                        
                        <!-- Dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 py-1 z-50">
                            
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-700 lg:hidden">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white"><?= $this->session->userdata('username') ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?= ucfirst($this->session->userdata('role')) ?></p>
                            </div>
                            
                            <a href="<?= base_url('dashboard') ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400">
                                Dashboard
                            </a>
                            <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-slate-700">
                                Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" 
                       class="px-5 py-2.5 btn-gradient text-white font-semibold rounded-lg 
                              shadow-md hover:shadow-lg transition-all duration-300">
                        Login
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="flex items-center gap-2 md:hidden flex-shrink-0">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                        class="p-2 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 flex-shrink-0 w-10 h-10 flex items-center justify-center">
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg x-show="!darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
                
                <button onclick="toggleMobileMenu()" class="text-gray-700 dark:text-white p-2 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex-shrink-0 w-10 h-10 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden pb-4">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 space-y-1 shadow-lg border border-gray-100 dark:border-slate-700">
                <a href="<?= base_url() ?>" class="block px-4 py-3 text-gray-700 dark:text-white hover:bg-blue-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                    Beranda
                </a>
                <a href="<?= base_url('artikel') ?>" class="block px-4 py-3 text-gray-700 dark:text-white hover:bg-blue-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                    Artikel
                </a>
                <a href="<?= base_url('tentang') ?>" class="block px-4 py-3 text-gray-700 dark:text-white hover:bg-blue-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                    Tentang
                </a>
                <a href="<?= base_url('tim') ?>" class="block px-4 py-3 text-gray-700 dark:text-white hover:bg-blue-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                    Tim
                </a>
                <a href="<?= base_url('kontak') ?>" class="block px-4 py-3 text-gray-700 dark:text-white hover:bg-blue-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                    Kontak
                </a>
                <a href="<?= base_url('auth/login') ?>" 
                   class="block px-4 py-3 btn-gradient text-white font-semibold rounded-lg text-center mt-2">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>
