<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- =====================================================
     TOTP Setup - Scan QR & Activate Authenticator
     Full-page centered layout inside admin shell
     ===================================================== -->
<div class="vault-page relative flex items-center justify-center" style="min-height: calc(100vh - 4rem);">

    <!-- ── Atmospheric Background ── -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="vault-cyber-grid"></div>
        <div class="vault-center-glow" style="background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, rgba(16,185,129,0.03) 35%, transparent 70%);"></div>
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(255,255,255,0.008) 0%, transparent 50%, rgba(0,0,0,0.15) 100%);"></div>
        <div class="absolute top-1/3 left-1/4 w-72 h-72 bg-emerald-500/[0.03] rounded-full blur-3xl vault-float"></div>
        <div class="absolute bottom-1/4 right-1/5 w-56 h-56 bg-blue-500/[0.03] rounded-full blur-3xl vault-float-reverse"></div>
        <div class="absolute top-1/2 left-1/2 w-[420px] h-[420px] border border-white/[0.03] rounded-full vault-ring-slow"></div>
        <div class="absolute top-1/2 left-1/2 w-[600px] h-[600px] border border-white/[0.015] rounded-full vault-ring-slow-reverse"></div>
    </div>

    <!-- ── Main Content ── -->
    <div class="relative z-10 w-full max-w-[480px] px-4 py-8">

        <!-- Setup Icon + Title -->
        <div class="text-center mb-7 vault-anim vault-anim-d1">
            <div class="inline-flex items-center justify-center w-[72px] h-[72px] rounded-2xl mb-5 relative vault-icon-container">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 border border-emerald-400/20"></div>
                <div class="absolute inset-0 rounded-2xl vault-icon-pulse" style="border-color: rgba(16,185,129,0.15);"></div>
                <svg class="w-9 h-9 text-emerald-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2 class="text-[22px] font-extrabold text-white tracking-tight leading-none mb-2.5 uppercase">Setup Authenticator</h2>
            <p class="text-slate-500 text-[13px] max-w-[340px] mx-auto leading-relaxed">Scan QR code di bawah dengan <span class="text-emerald-400 font-semibold">Google Authenticator</span> atau aplikasi TOTP lainnya.</p>
        </div>

        <!-- Glass Card -->
        <div class="vault-glass rounded-2xl p-7 vault-anim vault-anim-d2 relative overflow-hidden">

            <!-- Top glow line -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-emerald-400/30 to-transparent"></div>

            <!-- Error Message -->
            <?php if($this->session->flashdata('totp_error')): ?>
                <div class="mb-5 p-3.5 rounded-xl flex items-center gap-3 text-[13px] vault-shake border border-red-500/20" style="background: rgba(239,68,68,0.08);">
                    <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold text-red-300"><?= $this->session->flashdata('totp_error') ?></span>
                </div>
            <?php endif; ?>

            <!-- Steps Container -->
            <div class="space-y-6">

                <!-- ═══════ STEP 1 — QR Code ═══════ -->
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-5 h-5 rounded-md bg-emerald-500/20 flex items-center justify-center">
                            <span class="text-[10px] font-black text-emerald-400">1</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Scan QR Code</span>
                    </div>
                    <div class="flex justify-center">
                        <div class="relative p-3 rounded-xl inline-block" style="background: rgba(255,255,255,0.04); border: 1px dashed rgba(255,255,255,0.08);">
                            <!-- White background for QR readability -->
                            <div class="bg-white rounded-lg p-2.5 shadow-lg">
                                <img src="<?= $qr_url ?>" alt="TOTP QR Code" class="w-[180px] h-[180px] sm:w-[200px] sm:h-[200px] rounded" id="qr-code-img"
                                     onerror="this.style.display='none'; document.getElementById('qr-fallback').style.display='flex';">
                                <div id="qr-fallback" class="w-[180px] h-[180px] sm:w-[200px] sm:h-[200px] rounded bg-slate-100 items-center justify-center text-center p-4" style="display:none;">
                                    <p class="text-xs text-slate-500">QR tidak bisa dimuat.<br>Gunakan kode manual.</p>
                                </div>
                            </div>
                            <!-- Corner decorations -->
                            <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-emerald-500/30 rounded-tl-xl"></div>
                            <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-emerald-500/30 rounded-tr-xl"></div>
                            <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-emerald-500/30 rounded-bl-xl"></div>
                            <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-emerald-500/30 rounded-br-xl"></div>
                        </div>
                    </div>
                </div>

                <!-- ═══════ STEP 2 — Manual Key ═══════ -->
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-5 h-5 rounded-md bg-blue-500/20 flex items-center justify-center">
                            <span class="text-[10px] font-black text-blue-400">2</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Atau masukkan kode manual</span>
                    </div>
                    <div class="relative group">
                        <div class="rounded-xl p-3.5 text-center" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                            <code class="font-mono text-base sm:text-lg font-bold text-blue-400 tracking-[0.25em] select-all" id="secret-key">
                                <?= $formatted_secret ?>
                            </code>
                        </div>
                        <button type="button" onclick="copySecret()"
                            class="absolute top-1/2 right-2.5 -translate-y-1/2 p-2 rounded-lg transition-all hover:bg-white/[0.06] group/copy" title="Copy">
                            <svg class="w-4 h-4 text-slate-600 group-hover/copy:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- ═══════ RECOVERY CODES (if available) ═══════ -->
                <?php if(!empty($recovery_codes)): ?>
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-5 h-5 rounded-md bg-amber-500/20 flex items-center justify-center">
                            <span class="text-[10px] font-black text-amber-400">!</span>
                        </div>
                        <span class="text-[10px] font-bold text-amber-400 uppercase tracking-[0.2em]">Recovery Codes — Simpan!</span>
                    </div>
                    <div class="rounded-xl p-4" style="background: rgba(245,158,11,0.04); border: 1px solid rgba(245,158,11,0.1);">
                        <div class="grid grid-cols-2 gap-1.5">
                            <?php foreach($recovery_codes as $code): ?>
                            <code class="font-mono text-[13px] font-bold text-amber-400/80 px-3 py-2 rounded-lg text-center select-all" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(245,158,11,0.08);">
                                <?= $code ?>
                            </code>
                            <?php endforeach; ?>
                        </div>
                        <p class="text-[10px] text-amber-500/60 mt-3 text-center font-medium leading-relaxed">
                            Kode ini hanya ditampilkan <strong>sekali</strong>. Simpan di tempat aman sebelum melanjutkan.
                        </p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ═══════ STEP 3 — Verify OTP ═══════ -->
                <form action="<?= base_url('admin/server_credentials/verify_totp_setup') ?>" method="POST" autocomplete="off" id="setup-form">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="otp_code" id="otp_code_hidden">

                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-5 h-5 rounded-md bg-emerald-500/20 flex items-center justify-center">
                            <span class="text-[10px] font-black text-emerald-400">3</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Masukkan kode dari Authenticator</span>
                    </div>

                    <!-- 6-Digit OTP Input -->
                    <div class="flex justify-center items-center gap-2 sm:gap-2.5 mb-5" id="otp-container">
                        <?php for($i = 0; $i < 6; $i++): ?>
                            <?php if($i === 3): ?>
                                <div class="flex items-center px-0.5">
                                    <div class="w-2 h-[2px] rounded-full bg-slate-700"></div>
                                </div>
                            <?php endif; ?>
                            <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                                class="otp-digit w-11 h-[52px] sm:w-12 sm:h-14 text-center text-xl sm:text-2xl font-extrabold rounded-xl outline-none transition-all duration-200"
                                data-index="<?= $i ?>"
                                <?= $i === 0 ? 'autofocus' : '' ?>>
                        <?php endfor; ?>
                    </div>

                    <button type="submit" id="verify-btn" disabled
                        class="w-full relative overflow-hidden py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3 group disabled:opacity-30 disabled:cursor-not-allowed vault-submit-btn">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-700 group-hover:from-emerald-500 group-hover:to-emerald-600 transition-all duration-300"></div>
                        <svg class="relative z-10 w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="relative z-10 text-[11px] uppercase tracking-[0.2em]">Verifikasi & Aktifkan</span>
                    </button>
                </form>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-7 pt-5 border-t border-white/[0.05] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></div>
                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-[0.15em]">Setup Mode</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-3 h-3 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-2.597 9.129-6.514 11.441a1.454 1.454 0 01-1.486 0c-3.917-2.312-6.514-6.495-6.514-11.441 0-.68.058-1.35.166-2.001z" />
                    </svg>
                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-[0.15em]">TOTP · RFC 6238</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy Toast -->
<div id="copy-toast" class="fixed bottom-8 left-1/2 -translate-x-1/2 px-5 py-3 rounded-xl shadow-2xl text-[12px] font-bold flex items-center gap-2 z-50 transition-all duration-300 opacity-0 translate-y-6 pointer-events-none" style="background: rgba(16,185,129,0.9); color: white; backdrop-filter: blur(8px);">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    Secret key disalin!
</div>

<!-- =====================================================
     Styles
     ===================================================== -->
<style>
/* ── Full-bleed dark background ── */
.vault-page {
    background: linear-gradient(135deg, #020617 0%, #050d1a 30%, #0a1628 60%, #0d1b2a 100%);
    margin: -1rem; padding: 1rem;
}
@media (min-width: 1024px) {
    .vault-page { margin: -1.5rem; padding: 1.5rem; }
}

/* ── Cyber Grid ── */
.vault-cyber-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(16,185,129,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(16,185,129,0.03) 1px, transparent 1px);
    background-size: 50px 50px;
    mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
    -webkit-mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
    animation: vault-grid-in 1.5s ease-out forwards;
}
@keyframes vault-grid-in {
    from { opacity: 0; transform: scale(1.08); }
    to   { opacity: 1; transform: scale(1); }
}

/* ── Glow ── */
.vault-center-glow {
    position: absolute; top: 35%; left: 50%;
    transform: translate(-50%,-50%);
    width: 650px; height: 650px;
    filter: blur(50px);
    animation: vault-pulse-glow 8s ease-in-out infinite alternate;
}
@keyframes vault-pulse-glow {
    from { transform: translate(-50%,-50%) scale(1); opacity: 0.5; }
    to   { transform: translate(-50%,-50%) scale(1.12); opacity: 1; }
}

/* ── Float ── */
@keyframes vault-float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-25px); } }
@keyframes vault-float-reverse { 0%,100% { transform: translateY(0); } 50% { transform: translateY(20px); } }
.vault-float { animation: vault-float 12s ease-in-out infinite; }
.vault-float-reverse { animation: vault-float-reverse 15s ease-in-out infinite; }

/* ── Rings ── */
@keyframes vault-ring { from { transform: translate(-50%,-50%) rotate(0deg); } to { transform: translate(-50%,-50%) rotate(360deg); } }
.vault-ring-slow { animation: vault-ring 80s linear infinite; }
.vault-ring-slow-reverse { animation: vault-ring 120s linear infinite reverse; }

/* ── Glass ── */
.vault-glass {
    background: rgba(255,255,255,0.03);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.06);
    box-shadow: 0 0 0 1px rgba(255,255,255,0.02), 0 20px 60px -10px rgba(0,0,0,0.5), 0 0 80px rgba(16,185,129,0.03);
}

/* ── Icon Pulse ── */
.vault-icon-pulse { animation: vault-icon-ring 3s ease-in-out infinite; }
@keyframes vault-icon-ring {
    0%,100% { transform: scale(1); opacity: 0.4; }
    50% { transform: scale(1.15); opacity: 0; }
}

/* ── OTP Digits ── */
.otp-digit {
    background: rgba(255,255,255,0.04);
    border: 1.5px solid rgba(255,255,255,0.08);
    color: white; caret-color: #34d399;
}
.otp-digit:focus {
    background: rgba(16,185,129,0.06);
    border-color: rgba(16,185,129,0.5);
    box-shadow: 0 0 0 3px rgba(16,185,129,0.12), 0 0 20px rgba(16,185,129,0.06);
    transform: scale(1.06);
}
.otp-digit.filled { border-color: rgba(16,185,129,0.3); background: rgba(16,185,129,0.04); }
.otp-digit.complete {
    border-color: rgba(16,185,129,0.5) !important;
    background: rgba(16,185,129,0.06) !important;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
}

/* ── Animations ── */
@keyframes vault-enter {
    from { opacity: 0; transform: translateY(24px); filter: blur(6px); }
    to   { opacity: 1; transform: translateY(0);    filter: blur(0); }
}
.vault-anim { opacity: 0; animation: vault-enter 0.7s cubic-bezier(0.16,1,0.3,1) forwards; }
.vault-anim-d1 { animation-delay: 0.1s; }
.vault-anim-d2 { animation-delay: 0.3s; }

/* ── Submit ── */
.vault-submit-btn:not(:disabled):hover { transform: translateY(-1px); box-shadow: 0 8px 30px rgba(16,185,129,0.2); }
.vault-submit-btn:not(:disabled):active { transform: translateY(0) scale(0.98); }

/* ── Shake ── */
@keyframes vault-shake { 0%,100%{transform:translateX(0)} 15%,45%,75%{transform:translateX(-6px)} 30%,60%,90%{transform:translateX(6px)} }
.vault-shake { animation: vault-shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
</style>

<!-- =====================================================
     Scripts
     ===================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp_code_hidden');
    const verifyBtn = document.getElementById('verify-btn');

    function updateOtp() {
        let code = '';
        digits.forEach(d => code += d.value);
        hidden.value = code;
        verifyBtn.disabled = code.length !== 6;
        digits.forEach(d => {
            d.classList.remove('filled','complete');
            if (d.value) d.classList.add(code.length === 6 ? 'complete' : 'filled');
        });
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
});

function copySecret() {
    const secret = '<?= str_replace(' ', '', $formatted_secret) ?>';
    navigator.clipboard.writeText(secret).then(() => {
        const t = document.getElementById('copy-toast');
        t.style.opacity = '1'; t.style.transform = 'translate(-50%, 0)';
        setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translate(-50%, 24px)'; }, 2500);
    });
}
</script>
