<!-- Global Confirmation Modal -->
<div id="confirmation-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" id="modal-panel">
                
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 dark:bg-red-500/10 flex items-center justify-center" id="modal-icon-bg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" id="modal-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">Konfirmasi Aksi</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400" id="modal-message">Apakah Anda yakin ingin melanjutkan aksi ini? Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 dark:bg-slate-700/30 px-6 py-4 flex flex-row-reverse gap-3">
                    <button type="button" id="btn-confirm" class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-colors">
                        Ya, Lanjutkan
                    </button>
                    <button type="button" id="btn-cancel" class="inline-flex w-full justify-center rounded-lg bg-white dark:bg-slate-700 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-600 hover:bg-gray-50 dark:hover:bg-slate-600 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmation-modal');
    const backdrop = document.getElementById('modal-backdrop');
    const panel = document.getElementById('modal-panel');
    const btnConfirm = document.getElementById('btn-confirm');
    const btnCancel = document.getElementById('btn-cancel');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    
    let targetLink = null;
    let targetForm = null;

    // Open Modal Function
    window.openConfirmation = function(event, message = null) {
        event.preventDefault();
        
        // Reset targets
        targetLink = null;
        targetForm = null;

        // Determine source
        const target = event.target.closest('[data-confirm]');
        if (target.tagName === 'A') {
            targetLink = target.href;
        } else if (target.tagName === 'BUTTON' && target.type === 'submit') {
            targetForm = target.closest('form');
        }

        // Set Message
        if (message) {
            modalMessage.textContent = message;
        } else if (target.dataset.confirm) {
            modalMessage.textContent = target.dataset.confirm;
        }

        // Show Modal
        modal.classList.remove('hidden');
        // Animation
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
        }, 10);
    };

    // Close Modal Function
    function closeModal() {
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
        panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Confirm Action
    btnConfirm.addEventListener('click', function() {
        if (targetLink) {
            window.location.href = targetLink;
        } else if (targetForm) {
            targetForm.submit();
        }
        closeModal();
    });

    // Cancel Action
    btnCancel.addEventListener('click', closeModal);

    // Global Listener for data-confirm
    document.addEventListener('click', function(e) {
        const target = e.target.closest('[data-confirm]');
        if (target) {
            window.openConfirmation(e);
        }
    });
});
</script>
