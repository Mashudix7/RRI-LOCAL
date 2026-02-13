<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- =====================================================
     VAULT LOCK - TOTP Authentication
     Full-page centered layout inside admin shell
     ===================================================== -->
<div class="vault-page relative flex items-center justify-center" style="min-height: calc(100vh - 4rem);">

    <!-- ── Atmospheric Background ── -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Cyber Grid -->
        <div class="vault-cyber-grid"></div>
        <!-- Center Glow -->
        <div class="vault-center-glow"></div>
        <!-- Diagonal Light -->
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(255,255,255,0.008) 0%, transparent 50%, rgba(0,0,0,0.15) 100%);"></div>
        <!-- Floating Orbs -->
        <div class="absolute top-1/4 left-1/5 w-72 h-72 bg-blue-500/[0.04] rounded-full blur-3xl vault-float"></div>
        <div class="absolute bottom-1/4 right-1/5 w-56 h-56 bg-indigo-500/[0.04] rounded-full blur-3xl vault-float-reverse"></div>
        <!-- Decorative Rings -->
        <div class="absolute top-1/2 left-1/2 w-[420px] h-[420px] border border-white/[0.03] rounded-full vault-ring-slow"></div>
        <div class="absolute top-1/2 left-1/2 w-[600px] h-[600px] border border-white/[0.015] rounded-full vault-ring-slow-reverse"></div>
    </div>

    <!-- ── Main Content ── -->
    <div class="relative z-10 w-full max-w-[420px] px-4 py-8">

        <!-- Lock Icon + Title -->
        <div class="text-center mb-8 vault-anim vault-anim-d1">
            <div class="inline-flex items-center justify-center w-[72px] h-[72px] rounded-2xl mb-5 relative vault-icon-container">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 border border-blue-400/20"></div>
                <div class="absolute inset-0 rounded-2xl vault-icon-pulse"></div>
                <svg class="w-9 h-9 text-blue-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-[22px] font-extrabold text-white tracking-tight leading-none mb-2.5 uppercase">Vault Protected</h2>
            <p class="text-slate-500 text-[13px] max-w-[300px] mx-auto leading-relaxed">Masukkan kode 6-digit dari <span class="text-blue-400 font-semibold">Google Authenticator</span> untuk membuka vault.</p>
        </div>

        <!-- Glass Card -->
        <div class="vault-glass rounded-2xl p-7 vault-anim vault-anim-d2 relative overflow-hidden">

            <!-- Subtle top glow inside card -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-blue-400/40 to-transparent"></div>

            <!-- Locked Out Warning -->
            <?php if($is_locked): ?>
                <div class="mb-5 p-3.5 rounded-xl flex items-center gap-3 text-[13px] border border-red-500/20" style="background: rgba(239,68,68,0.08);">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(239,68,68,0.15);">
                        <svg class="w-4 h-4 text-red-400 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-red-300 block text-[12px]">Akun Terkunci</span>
                        <span class="text-red-400/80 text-[11px]">Terlalu banyak percobaan. Coba lagi dalam <?= $is_locked ?>.</span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Error Flash -->
            <?php if($this->session->flashdata('vault_error')): ?>
                <div class="mb-5 p-3.5 rounded-xl flex items-center gap-3 text-[13px] vault-shake border border-red-500/20" style="background: rgba(239,68,68,0.08);">
                    <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold text-red-300"><?= $this->session->flashdata('vault_error') ?></span>
                </div>
            <?php endif; ?>

            <!-- Info Flash -->
            <?php if($this->session->flashdata('vault_info')): ?>
                <div class="mb-5 p-3.5 rounded-xl flex items-center gap-3 text-[13px] border border-blue-500/20" style="background: rgba(59,130,246,0.08);">
                    <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium text-blue-300"><?= $this->session->flashdata('vault_info') ?></span>
                </div>
            <?php endif; ?>

            <!-- OTP Form -->
            <form action="<?= base_url('admin/server_credentials/unlock') ?>" method="POST" id="otp-form" autocomplete="off">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="is_recovery" value="0" id="is_recovery">
                <input type="hidden" name="otp_code" id="otp_code_hidden">

                <!-- ── OTP Mode ── -->
                <div id="otp-mode-section">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3 ml-0.5">Kode Autentikasi</label>

                    <!-- 6-Digit Input Boxes -->
                    <div class="flex justify-center items-center gap-2 sm:gap-2.5 mb-4" id="otp-container">
                        <?php for($i = 0; $i < 6; $i++): ?>
                            <?php if($i === 3): ?>
                                <div class="flex items-center px-0.5">
                                    <div class="w-2 h-[2px] rounded-full bg-slate-700"></div>
                                </div>
                            <?php endif; ?>
                            <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                                class="otp-digit w-11 h-[52px] sm:w-12 sm:h-14 text-center text-xl sm:text-2xl font-extrabold rounded-xl outline-none transition-all duration-200"
                                data-index="<?= $i ?>"
                                <?= ($i === 0 && !$is_locked) ? 'autofocus' : '' ?>
                                <?= $is_locked ? 'disabled' : '' ?>>
                        <?php endfor; ?>
                    </div>

                    <!-- TOTP 30-Second Timer -->
                    <div class="flex items-center justify-center gap-2.5 mb-6">
                        <div class="relative w-5 h-5">
                            <svg class="w-5 h-5 -rotate-90" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="2.5"/>
                                <circle cx="12" cy="12" r="10" fill="none" stroke-width="2.5" stroke-linecap="round" id="totp-timer-circle" class="text-blue-400" stroke="currentColor"
                                    stroke-dasharray="62.83" stroke-dashoffset="0"/>
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold text-slate-500 tabular-nums tracking-wider" id="totp-timer-text">30s</span>
                        <span class="text-[10px] text-slate-600">— kode berubah otomatis</span>
                    </div>
                </div>

                <!-- ── Recovery Mode (hidden) ── -->
                <div id="recovery-mode-section" class="hidden">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3 ml-0.5">Kode Pemulihan</label>
                    <div class="relative group mb-6">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-amber-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <input type="text" id="recovery_code_input" placeholder="XXXX-XXXX" autocomplete="off"
                            class="block w-full pl-12 pr-4 py-4 bg-white/[0.04] border border-white/[0.08] rounded-xl focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/20 text-white transition-all outline-none font-mono text-lg tracking-[0.3em] text-center uppercase placeholder-slate-600">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="unlock-btn" <?= $is_locked ? 'disabled' : '' ?>
                    class="w-full relative overflow-hidden py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3 group disabled:opacity-40 disabled:cursor-not-allowed vault-submit-btn">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700 group-hover:from-blue-500 group-hover:to-blue-600 transition-all duration-300"></div>
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);"></div>
                    <span class="relative z-10 text-[11px] uppercase tracking-[0.2em]" id="unlock-btn-text">Unlock Session</span>
                    <svg class="relative z-10 w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>

            <!-- Mode Toggle + Dashboard Link -->
            <div class="mt-5 space-y-1.5">
                <button type="button" onclick="toggleRecoveryMode()" 
                    class="w-full py-2.5 text-center text-[10px] font-bold text-slate-500 hover:text-blue-400 transition-colors uppercase tracking-[0.15em] rounded-lg hover:bg-white/[0.03]" id="toggle-mode-btn">
                    Gunakan Recovery Code
                </button>
                <a href="<?= base_url('admin/dashboard') ?>" 
                    class="block w-full py-2 text-center text-[10px] font-bold text-slate-600 hover:text-slate-400 transition-colors uppercase tracking-[0.15em] rounded-lg hover:bg-white/[0.02]">
                    ← Kembali ke Dashboard
                </a>
            </div>

            <!-- Bottom Security Bar -->
            <div class="mt-7 pt-5 border-t border-white/[0.05] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></div>
                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-[0.15em]">Vault: Locked</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-3 h-3 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-2.597 9.129-6.514 11.441a1.454 1.454 0 01-1.486 0c-3.917-2.312-6.514-6.495-6.514-11.441 0-.68.058-1.35.166-2.001z" />
                    </svg>
                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-[0.15em]">TOTP · v3.0</span>
                </div>
            </div>

            <?php if(isset($totp_record) && $totp_record && $totp_record['failed_attempts'] > 0 && !$is_locked): ?>
            <div class="mt-3 flex items-center justify-center gap-1.5">
                <?php for($i = 0; $i < 5; $i++): ?>
                    <div class="w-6 h-1 rounded-full <?= $i < $totp_record['failed_attempts'] ? 'bg-red-500/60' : 'bg-white/[0.06]' ?> transition-all"></div>
                <?php endfor; ?>
                <span class="text-[9px] font-bold text-red-400/60 ml-2"><?= $totp_record['failed_attempts'] ?>/5</span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- =====================================================
     Styles
     ===================================================== -->
<style>
/* ── Page Background ── */
.vault-page {
    background: linear-gradient(135deg, #020617 0%, #050d1a 30%, #0a1628 60%, #0d1b2a 100%);
    margin: -1rem -1rem -1rem -1rem;  /* Bleed into main padding */
    padding: 1rem;
}
@media (min-width: 1024px) {
    .vault-page { margin: -1.5rem -1.5rem -1.5rem -1.5rem; padding: 1.5rem; }
}

/* ── Cyber Grid ── */
.vault-cyber-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(59,130,246,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59,130,246,0.04) 1px, transparent 1px);
    background-size: 50px 50px;
    mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
    -webkit-mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
    animation: vault-grid-in 1.5s ease-out forwards;
}
@keyframes vault-grid-in {
    from { opacity: 0; transform: scale(1.08); }
    to   { opacity: 1; transform: scale(1); }
}

/* ── Center Glow ── */
.vault-center-glow {
    position: absolute; top: 40%; left: 50%;
    transform: translate(-50%,-50%);
    width: 650px; height: 650px;
    background: radial-gradient(circle, rgba(30,64,175,0.12) 0%, rgba(30,64,175,0.04) 35%, transparent 70%);
    filter: blur(50px);
    animation: vault-pulse-glow 8s ease-in-out infinite alternate;
}
@keyframes vault-pulse-glow {
    from { transform: translate(-50%,-50%) scale(1); opacity: 0.6; }
    to   { transform: translate(-50%,-50%) scale(1.12); opacity: 1; }
}

/* ── Floating Orbs ── */
@keyframes vault-float {
    0%,100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-25px) scale(1.05); }
}
@keyframes vault-float-reverse {
    0%,100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(20px) scale(0.95); }
}
.vault-float { animation: vault-float 12s ease-in-out infinite; }
.vault-float-reverse { animation: vault-float-reverse 15s ease-in-out infinite; }

/* ── Decorative Rings ── */
@keyframes vault-ring {
    from { transform: translate(-50%,-50%) rotate(0deg); }
    to   { transform: translate(-50%,-50%) rotate(360deg); }
}
.vault-ring-slow { animation: vault-ring 80s linear infinite; }
.vault-ring-slow-reverse { animation: vault-ring 120s linear infinite reverse; }

/* ── Glass Card ── */
.vault-glass {
    background: rgba(255,255,255,0.03);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.06);
    box-shadow:
        0 0 0 1px rgba(255,255,255,0.02),
        0 20px 60px -10px rgba(0,0,0,0.5),
        0 0 80px rgba(59,130,246,0.04);
}

/* ── Icon Pulse Ring ── */
.vault-icon-pulse {
    border: 2px solid rgba(96,165,250,0.15);
    animation: vault-icon-ring 3s ease-in-out infinite;
}
@keyframes vault-icon-ring {
    0%,100% { transform: scale(1); opacity: 0.4; }
    50% { transform: scale(1.15); opacity: 0; }
}

/* ── OTP Digit Inputs ── */
.otp-digit {
    background: rgba(255,255,255,0.04);
    border: 1.5px solid rgba(255,255,255,0.08);
    color: white;
    caret-color: #60a5fa;
}
.otp-digit:focus {
    background: rgba(59,130,246,0.06);
    border-color: rgba(59,130,246,0.5);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12), 0 0 20px rgba(59,130,246,0.06);
    transform: scale(1.06);
}
.otp-digit.filled {
    border-color: rgba(59,130,246,0.4);
    background: rgba(59,130,246,0.05);
}
.otp-digit.complete {
    border-color: rgba(16,185,129,0.5) !important;
    background: rgba(16,185,129,0.06) !important;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
}

/* ── Entrance Animations ── */
@keyframes vault-enter {
    from { opacity: 0; transform: translateY(24px); filter: blur(6px); }
    to   { opacity: 1; transform: translateY(0);    filter: blur(0); }
}
.vault-anim {
    opacity: 0;
    animation: vault-enter 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.vault-anim-d1 { animation-delay: 0.1s; }
.vault-anim-d2 { animation-delay: 0.3s; }

/* ── Submit Button ── */
.vault-submit-btn:not(:disabled):hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 30px rgba(59,130,246,0.25);
}
.vault-submit-btn:not(:disabled):active {
    transform: translateY(0) scale(0.98);
}

/* ── Shake Animation ── */
@keyframes vault-shake {
    0%,100% { transform: translateX(0); }
    15%,45%,75% { transform: translateX(-6px); }
    30%,60%,90% { transform: translateX(6px); }
}
.vault-shake { animation: vault-shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
</style>

<!-- =====================================================
     Scripts
     ===================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── OTP Input Handler ──
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp_code_hidden');
    const form = document.getElementById('otp-form');

    function updateOtp() {
        let code = '';
        digits.forEach(d => code += d.value);
        hidden.value = code;
        const complete = code.length === 6;
        digits.forEach(d => {
            d.classList.remove('filled', 'complete');
            if (d.value) d.classList.add(complete ? 'complete' : 'filled');
        });
        if (complete) setTimeout(() => form.submit(), 350);
    }

    digits.forEach((el, i) => {
        el.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            if (this.value && i < 5) digits[i + 1].focus();
            updateOtp();
        });
        el.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && i > 0) {
                digits[i - 1].focus();
                digits[i - 1].value = '';
                updateOtp();
            }
        });
        el.addEventListener('paste', function(e) {
            e.preventDefault();
            const txt = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            if (txt.length >= 6) {
                for (let j = 0; j < 6; j++) digits[j].value = txt[j] || '';
                digits[5].focus();
                updateOtp();
            }
        });
    });

    // ── TOTP Timer Circle ──
    const circle = document.getElementById('totp-timer-circle');
    const timerText = document.getElementById('totp-timer-text');
    if (circle && timerText) {
        const C = 2 * Math.PI * 10;
        function tick() {
            const rem = 30 - (Math.floor(Date.now() / 1000) % 30);
            circle.style.strokeDashoffset = C * (1 - rem / 30);
            timerText.textContent = rem + 's';
            circle.style.color = rem <= 5 ? '#ef4444' : '#60a5fa';
            timerText.style.color = rem <= 5 ? '#ef4444' : '';
        }
        tick();
        setInterval(tick, 1000);
    }
});

// ── Toggle Recovery Mode ──
let _recoveryMode = false;
function toggleRecoveryMode() {
    _recoveryMode = !_recoveryMode;
    const otpSec = document.getElementById('otp-mode-section');
    const recSec = document.getElementById('recovery-mode-section');
    const recInput = document.getElementById('recovery_code_input');
    const hiddenOtp = document.getElementById('otp_code_hidden');
    const isRec = document.getElementById('is_recovery');
    const btn = document.getElementById('toggle-mode-btn');
    const btnText = document.getElementById('unlock-btn-text');

    if (_recoveryMode) {
        otpSec.classList.add('hidden');
        recSec.classList.remove('hidden');
        isRec.value = '1';
        btn.textContent = 'Gunakan Kode OTP';
        btnText.textContent = 'Unlock dengan Recovery';
        recInput.focus();
        recInput.oninput = () => hiddenOtp.value = recInput.value;
    } else {
        otpSec.classList.remove('hidden');
        recSec.classList.add('hidden');
        isRec.value = '0';
        btn.textContent = 'Gunakan Recovery Code';
        btnText.textContent = 'Unlock Session';
        hiddenOtp.value = '';
        const first = document.querySelector('.otp-digit[data-index="0"]');
        if (first) first.focus();
    }
}
</script>
