<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="min-h-[70vh] flex items-center justify-center p-4">
    <div class="max-w-md w-full relative" data-aos="fade-up">
        <div class="absolute inset-0 -m-8 opacity-[0.03] dark:opacity-[0.05] pointer-events-none">
            <svg width="100%" height="100%">
                <pattern id="lock-grid-centered" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                </pattern>
                <rect width="100%" height="100%" fill="url(#lock-grid-centered)" />
            </svg>
        </div>
        <div class="text-center mb-8 relative z-10" data-aos="fade-right" data-aos-delay="200">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100/50 dark:border-blue-500/20 mb-5 shadow-sm">
                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight leading-none mb-2 uppercase">Vault Protected</h2>
            <p class="text-gray-500 dark:text-gray-400 text-xs max-w-[260px] mx-auto font-medium">Input Master Password untuk mendekripsi akses data kredensial.</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 p-8 relative z-10 overflow-hidden" data-aos="fade-up" data-aos-delay="400">
            
            <?php if($this->session->flashdata('vault_error')): ?>
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 rounded-xl flex items-center gap-3 text-red-600 dark:text-red-400 text-sm animate-shake">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-bold underline decoration-2 underline-offset-4"><?= $this->session->flashdata('vault_error') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/server_credentials/unlock') ?>" method="POST" class="space-y-6">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                
                <div class="space-y-2.5">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">System Master Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <input type="password" name="vault_password" id="vault_password" required autofocus
                            class="block w-full pl-12 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-700/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all outline-none font-mono text-lg tracking-[0.5em]"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex flex-col gap-3.5 pt-1">
                    <button type="submit" 
                        class="w-full bg-slate-900 dark:bg-blue-600 hover:bg-slate-800 dark:hover:bg-blue-700 text-white font-black py-4 px-6 rounded-xl transition-all flex items-center justify-center gap-3 active:scale-[0.98] btn-press-anim shadow-sm">
                        <span class="text-xs uppercase tracking-widest">Unlock Session</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                    <a href="<?= base_url('admin/dashboard') ?>" 
                        class="w-full py-2 text-center text-[10px] font-bold text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors uppercase tracking-widest">
                        Kembali ke Dashboard
                    </a>
                </div>
            </form>

            <!-- Bottom Security Metrics -->
            <div class="mt-8 pt-6 border-t border-slate-50 dark:border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Vault: Locked</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-2.597 9.129-6.514 11.441a1.454 1.454 0 01-1.486 0c-3.917-2.312-6.514-6.495-6.514-11.441 0-.68.058-1.35.166-2.001z" />
                    </svg>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">v2.4</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    15%, 45%, 75% { transform: translateX(-8px); }
    30%, 60%, 90% { transform: translateX(8px); }
}
.animate-shake {
    animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
}
</style>
