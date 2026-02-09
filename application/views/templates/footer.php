    <!-- =====================================================
         Footer Section - With Dark Mode Support
         ===================================================== -->
    <footer class="bg-white dark:bg-[#020617] border-t border-gray-200 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg overflow-hidden">
                            <img src="<?= base_url('assets/img/logo_rri.png') ?>" alt="Logo CSIRT RRI" class="w-full h-full object-contain p-1" loading="lazy">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">CSIRT RRI</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Computer Security Incident Response Team</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed max-w-md">
                        Tim Tanggap Insiden Keamanan Siber Radio Republik Indonesia. 
                        Melindungi infrastruktur digital dan menjaga keamanan informasi institusi.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="<?= base_url() ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-sm">Beranda</a></li>
                        <li><a href="<?= base_url('artikel') ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-sm">Artikel</a></li>
                        <li><a href="<?= base_url('tentang') ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-sm">Tentang CSIRT</a></li>
                        <li><a href="<?= base_url('tim') ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-sm">Tim Kami</a></li>
                        <li><a href="<?= base_url('kontak') ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-sm">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400 text-sm">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            csirt@rri.co.id
                        </li>
                        <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400 text-sm">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            (021) 3456-7890
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-200 dark:border-white/5 mt-10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 dark:text-gray-500 text-sm">
                    &copy; <?= date('Y') ?> CSIRT RRI. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scroll to Top Button -->
    <button id="scrollTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="fixed bottom-6 right-6 w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg 
                   flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-blue-700 hover:scale-110 z-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
    
    <script>
        // Initialize AOS Animation - Optimized for performance
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 600,  // Reduced from 800ms for snappier feel
                    once: true,     // Only animate once
                    offset: 50,     // Reduced from 100px  
                    easing: 'ease-out-cubic'
                });
            }
        });

        // Navbar Scroll Effect & Scroll-to-Top Button
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            const scrollBtn = document.getElementById('scrollTopBtn');
            
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-md');
                } else {
                    navbar.classList.remove('shadow-md');
                }
            }
            
            if (scrollBtn) {
                if (window.scrollY > 300) {
                    scrollBtn.classList.remove('opacity-0', 'invisible');
                    scrollBtn.classList.add('opacity-100', 'visible');
                } else {
                    scrollBtn.classList.add('opacity-0', 'invisible');
                    scrollBtn.classList.remove('opacity-100', 'visible');
                }
            }
        });
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }
    </script>
    </div><!-- End #page-wrapper -->
</body>
</html>
