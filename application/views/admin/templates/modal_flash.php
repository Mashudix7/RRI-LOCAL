<!-- Global Flash Message Modal - Premium Minimalist Design -->
<div id="flash-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="flash-title" role="dialog" aria-modal="true">
    <!-- Backdrop with dynamic blur -->
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-500 opacity-0" id="flash-backdrop"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Panel with Smooth Animation -->
        <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all duration-400 ease-out sm:my-8 sm:w-full sm:max-w-sm opacity-0 translate-y-4 scale-95 border border-gray-100 dark:border-slate-700" id="flash-panel">
            
            <div class="p-8">
                <div class="flex flex-col items-center text-center">
                    <!-- Icon Container - No Glow, Solid Flat Design -->
                    <div id="flash-icon-container" class="relative flex items-center justify-center w-16 h-16 rounded-2xl mb-6">
                        <div class="relative z-10">
                            <!-- Success Icon -->
                            <svg id="flash-icon-success" class="w-8 h-8 hidden" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <!-- Error Icon -->
                            <svg id="flash-icon-error" class="w-8 h-8 hidden" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content with Clean Typography -->
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white" id="flash-title"></h3>
                        <div class="text-sm text-gray-500 dark:text-slate-400 font-medium leading-relaxed prose prose-sm dark:prose-invert max-w-none" id="flash-message"></div>
                    </div>
                </div>
            </div>

            <!-- Action Button - Solid Minimal -->
            <div class="p-6 pt-0">
                <button type="button" onclick="closeFlashModal()" 
                        class="group relative w-full overflow-hidden rounded-xl p-3.5 text-sm font-bold text-white transition-all duration-200" id="flash-button">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Tutup
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Flash Data Transfer -->
<?php if ($this->session->flashdata('success')): ?>
    <div id="flash-data-success" data-message="<?= htmlspecialchars($this->session->flashdata('success')) ?>" hidden></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div id="flash-data-error" data-message="<?= htmlspecialchars($this->session->flashdata('error')) ?>" hidden></div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const flashSuccess = document.getElementById('flash-data-success');
    const flashError = document.getElementById('flash-data-error');
    
    if (flashSuccess) {
        showFlashModal('success', flashSuccess.dataset.message);
    } else if (flashError) {
        showFlashModal('error', flashError.dataset.message);
    }
});

function showFlashModal(type, message) {
    const modal = document.getElementById('flash-modal');
    const backdrop = document.getElementById('flash-backdrop');
    const panel = document.getElementById('flash-panel');
    
    // Elements
    const iconContainer = document.getElementById('flash-icon-container');
    const iconSuccess = document.getElementById('flash-icon-success');
    const iconError = document.getElementById('flash-icon-error');
    const title = document.getElementById('flash-title');
    const msg = document.getElementById('flash-message');
    const btn = document.getElementById('flash-button');

    // Reset styles
    iconSuccess.classList.add('hidden');
    iconError.classList.add('hidden');
    
    // Apply styles based on type (Indonesian Language only)
    if (type === 'success') {
        iconContainer.className = 'relative flex items-center justify-center w-16 h-16 rounded-2xl mb-6 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400';
        iconSuccess.classList.remove('hidden');
        title.textContent = 'Berhasil';
        btn.className = 'group relative w-full overflow-hidden rounded-xl p-3.5 text-sm font-bold text-white transition-all duration-200 bg-emerald-600 hover:bg-emerald-700';
    } else {
        iconContainer.className = 'relative flex items-center justify-center w-16 h-16 rounded-2xl mb-6 bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400';
        iconError.classList.remove('hidden');
        title.textContent = 'Terjadi Kesalahan';
        btn.className = 'group relative w-full overflow-hidden rounded-xl p-3.5 text-sm font-bold text-white transition-all duration-200 bg-red-600 hover:bg-red-700';
    }

    // Process Message
    msg.innerHTML = message;

    // Show
    modal.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
        panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
    }, 50);
}

window.closeFlashModal = function() {
    const modal = document.getElementById('flash-modal');
    const backdrop = document.getElementById('flash-backdrop');
    const panel = document.getElementById('flash-panel');

    backdrop.classList.add('opacity-0');
    panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
    panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 400);
};
</script>
<style>
#flash-message p { margin: 0; }
</style>
