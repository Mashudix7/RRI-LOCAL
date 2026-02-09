<!-- Toast Notification Component - Centered & Themed -->
<div x-data="toastNotification()" 
     x-init="init()"
     class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] flex flex-col gap-3 pointer-events-none w-full max-w-lg px-4">
    
    <!-- Success Toast (Login) - Slate Theme (Same as Logout) -->
    <template x-if="successMessage">
        <div x-show="showSuccess" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform -translate-y-8"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-8"
             class="pointer-events-auto flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 text-white rounded-2xl shadow-2xl shadow-slate-500/20 w-full border border-slate-600/30">
            <div class="flex-shrink-0 w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-base">Login Berhasil</p>
                <p class="text-slate-300 text-sm truncate" x-text="successMessage"></p>
            </div>
            <button @click="showSuccess = false" class="flex-shrink-0 text-white/60 hover:text-white transition-colors p-1 hover:bg-white/10 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
    
    <!-- Info Toast - Slate Theme -->
    <template x-if="infoMessage">
        <div x-show="showInfo" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform -translate-y-8"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-8"
             class="pointer-events-auto flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 text-white rounded-2xl shadow-2xl shadow-slate-500/20 w-full border border-slate-600/30">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-base">Informasi</p>
                <p class="text-slate-300 text-sm truncate" x-text="infoMessage"></p>
            </div>
            <button @click="showInfo = false" class="flex-shrink-0 text-white/60 hover:text-white transition-colors p-1 hover:bg-white/10 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
    
    <!-- Error Toast - Red Theme -->
    <template x-if="errorMessage">
        <div x-show="showError" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform -translate-y-8"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-8"
             class="pointer-events-auto flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-red-600 via-red-700 to-red-800 text-white rounded-2xl shadow-2xl shadow-red-500/30 w-full border border-red-500/30">
            <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-base">Error</p>
                <p class="text-red-100 text-sm truncate" x-text="errorMessage"></p>
            </div>
            <button @click="showError = false" class="flex-shrink-0 text-white/60 hover:text-white transition-colors p-1 hover:bg-white/10 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastNotification() {
    return {
        successMessage: '<?= addslashes($this->session->flashdata("toast_success") ?? "") ?>',
        infoMessage: '<?= addslashes($this->session->flashdata("toast_info") ?? "") ?>',
        errorMessage: '<?= addslashes($this->session->flashdata("toast_error") ?? "") ?>',
        showSuccess: false,
        showInfo: false,
        showError: false,
        
        init() {
            // Check for AOS reset signal
            <?php if ($this->session->flashdata('aos_reset')): ?>
            // Clear all AOS session storage keys
            Object.keys(sessionStorage).forEach(key => {
                if (key.startsWith('aos_seen_')) {
                    sessionStorage.removeItem(key);
                }
            });
            <?php endif; ?>
            
            // Show toasts with slight delay for animation
            setTimeout(() => {
                if (this.successMessage) this.showSuccess = true;
                if (this.infoMessage) this.showInfo = true;
                if (this.errorMessage) this.showError = true;
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    this.showSuccess = false;
                    this.showInfo = false;
                    this.showError = false;
                }, 5000);
            }, 300);
        }
    }
}
</script>
