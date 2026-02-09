
<!-- Session Monitor Component -->
<div id="sessionModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity opacity-0" id="sessionOverlay"></div>
    
    <!-- Modal -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl p-8 max-w-sm w-full mx-4 relative z-10 transform scale-95 opacity-0 transition-all duration-300" id="sessionContent">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Sesi Berakhir</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-6">
                Waktu sesi Anda telah habis karena inaktivitas. Silakan login kembali untuk melanjutkan.
            </p>
            
            <a href="<?= base_url('auth/login') ?>" 
               class="block w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors shadow-lg hover:shadow-red-600/30">
                Login Kembali
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // PHP Session expiration in milliseconds (from config)
        // Default to 7200s (2 hours) if not set
        const sessionLifetime = <?= ($this->config->item('sess_expiration') ?: 7200) * 1000 ?>;
        
        let sessionTimer;
        
        // Modal elements
        const modal = document.getElementById('sessionModal');
        const overlay = document.getElementById('sessionOverlay');
        const content = document.getElementById('sessionContent');
        
        function showSessionExpired() {
            // Show modal container
            modal.classList.remove('hidden');
            
            // Animate in
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function startSessionTimer() {
            clearTimeout(sessionTimer);
            sessionTimer = setTimeout(showSessionExpired, sessionLifetime);
        }
        
        // Start timer on load
        startSessionTimer();
        
        // Optional: Reset timer on user activity if you want "rolling" session behavior
        // But since CI uses absolute expiration for sess_expiration (usually), 
        // strictly speaking we might not want to reset this client-side 
        // unless we know the server updated the session (via AJAX).
        // 
        // For standard "inactivity logout" usually coupled with sliding expiration:
        // const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
        // events.forEach(evt => {
        //     document.addEventListener(evt, () => {
        //         // Debounce or throttle could be added here
        //         // startSessionTimer(); 
        //     }, true);
        // });
        //
        // Note: CodeIgniter 3 'sess_expiration' is by default absolute life? 
        // No, sess_expiration is "The number of seconds you would like the session to last."
        // "If you would like the session to last indefinitely, set the value to 0"
        // CI3 typically updates 'last_activity' on every request.
        // So client-side inactivity monitoring IS appropriate.
        // We will reset the timer on activity to match CI's behavior of extending session on request.
        // However, without an AJAX call, the SERVER session doesn't extend.
        // So checking client activity without talking to server is risky (UI says alive, server says dead).
        //
        // BEST PRACTICE: Just let the timer run from page load. 
        // If user interacts, they likely click a link or load a page, which resets everything.
        // If they assume "moving mouse" keeps them logged in without clicking, they might be wrong.
        // So we stick to: Timer starts on page load.
    });
</script>
