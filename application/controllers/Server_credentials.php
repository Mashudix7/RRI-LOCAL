<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * =====================================================
 * Server Credentials Controller
 * =====================================================
 * 
 * Controller untuk mengelola data IP & Password server.
 * Dilindungi oleh TOTP (Google Authenticator) vault lock.
 * 
 * Flow TOTP:
 * 1. User pertama kali → setup_totp() → generate secret + QR code
 * 2. User scan QR → verify_totp_setup() → aktifkan TOTP
 * 3. Setiap akses → _check_lock() → redirect ke form OTP
 * 4. User input OTP → unlock() → validasi & buka vault
 * 5. Lock manual atau timeout → lock()
 * 
 * @package     CSIRT RRI
 * @subpackage  Controllers
 * @category    Security / Credentials
 * =====================================================
 */
class Server_credentials extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
        
        // Login Check
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // RBAC
        if ($this->session->userdata('role') !== 'admin') {
            redirect('admin/dashboard');
        }

        $this->load->model('Server_credential_model');
        $this->load->model('Totp_model');
        $this->load->library('totp');
        $this->load->library('form_validation');
    }

    // ─────────────────────────────────────────────────
    //  VAULT LOCK SYSTEM (TOTP)
    // ─────────────────────────────────────────────────

    /**
     * Check if vault is locked
     * Returns true if locked (page should not be shown)
     */
    private function _check_lock() {
        $user_id = $this->session->userdata('user_id');
        
        // Check if TOTP is enabled for this user
        if (!$this->Totp_model->is_totp_enabled($user_id)) {
            // TOTP not set up yet → redirect to setup
            redirect('admin/server_credentials/setup_totp');
            return true;
        }

        // Check session vault unlock status
        if (!$this->session->userdata('vault_unlocked')) {
            $this->_show_otp_form();
            return true;
        }

        // Check vault timeout (auto-lock after 30 minutes)
        $unlock_time = $this->session->userdata('vault_unlocked_at');
        if ($unlock_time && (time() - $unlock_time) > 1800) { // 30 minutes
            $this->session->unset_userdata('vault_unlocked');
            $this->session->unset_userdata('vault_unlocked_at');
            $this->session->set_flashdata('vault_info', 'Sesi vault telah berakhir. Silakan masukkan kode OTP kembali.');
            $this->_show_otp_form();
            return true;
        }

        return false; // Unlocked
    }

    /**
     * Show OTP input form (vault lock screen)
     */
    private function _show_otp_form() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Vault Locked';
        $data['page'] = 'server_credentials';
        $data['user'] = [
            'username' => $this->session->userdata('username'),
            'role' => $this->session->userdata('role'),
            'role_name' => $this->session->userdata('role_name'),
            'avatar' => $this->session->userdata('avatar')
        ];
        $data['is_locked'] = $this->Totp_model->is_locked($user_id);
        $data['totp_record'] = $this->Totp_model->get_by_user($user_id);

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/server_credentials/lock_totp', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    /**
     * TOTP Setup Page
     * Show QR code and secret for first-time setup
     */
    public function setup_totp() {
        $user_id = $this->session->userdata('user_id');
        $username = $this->session->userdata('username');

        // If already set up and verified, redirect to main page
        if ($this->Totp_model->is_totp_enabled($user_id)) {
            redirect('admin/server_credentials');
            return;
        }

        // Check if there's a pending (unverified) secret
        $existing = $this->Totp_model->get_by_user($user_id);
        
        if ($existing && $existing['is_verified'] == 0) {
            // Reuse existing unverified secret
            $secret = $existing['secret'];
        } else {
            // Generate new secret & recovery codes
            $secret = $this->totp->generate_secret();
            $recovery_codes = $this->Totp_model->generate_recovery_codes(8);
            $this->Totp_model->save_secret($user_id, $secret, $recovery_codes);
            
            // Store recovery codes in session temporarily for display
            $this->session->set_userdata('totp_recovery_codes', $recovery_codes);
        }

        // Generate QR data
        $otpauth_url = $this->totp->get_otpauth_url($secret, $username);
        $qr_url = $this->totp->get_qr_url($otpauth_url, 250);

        $data['title'] = 'Setup TOTP Authenticator';
        $data['page'] = 'server_credentials';
        $data['user'] = [
            'username' => $username,
            'role' => $this->session->userdata('role'),
            'role_name' => $this->session->userdata('role_name'),
            'avatar' => $this->session->userdata('avatar')
        ];
        $data['secret'] = $secret;
        $data['formatted_secret'] = $this->totp->format_secret($secret);
        $data['qr_url'] = $qr_url;
        $data['otpauth_url'] = $otpauth_url;
        $data['recovery_codes'] = $this->session->userdata('totp_recovery_codes') ?: [];

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/server_credentials/setup_totp', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    /**
     * Verify TOTP Setup
     * User enters the 6-digit code from their authenticator to confirm setup
     */
    public function verify_totp_setup() {
        $user_id = $this->session->userdata('user_id');
        $code = $this->input->post('otp_code');

        $record = $this->Totp_model->get_by_user($user_id);
        if (!$record) {
            $this->session->set_flashdata('totp_error', 'TOTP secret tidak ditemukan. Silakan setup ulang.');
            redirect('admin/server_credentials/setup_totp');
            return;
        }

        // Verify the code
        if ($this->totp->verify_code($record['secret'], $code)) {
            // Mark as verified
            $this->Totp_model->verify_setup($user_id);
            
            // Auto-unlock vault after successful setup
            $this->session->set_userdata('vault_unlocked', true);
            $this->session->set_userdata('vault_unlocked_at', time());
            
            // Clear temporary recovery codes from session
            $this->session->unset_userdata('totp_recovery_codes');

            $this->session->set_flashdata('success', 'TOTP Authenticator berhasil diaktifkan! Vault telah dibuka.');
            redirect('admin/server_credentials');
        } else {
            $this->session->set_flashdata('totp_error', 'Kode OTP tidak valid. Pastikan jam perangkat Anda sinkron.');
            redirect('admin/server_credentials/setup_totp');
        }
    }

    /**
     * Unlock vault with TOTP code or recovery code
     */
    public function unlock() {
        $user_id = $this->session->userdata('user_id');
        $code = trim($this->input->post('otp_code'));
        $is_recovery = $this->input->post('is_recovery');

        // Check if locked out
        $lock_status = $this->Totp_model->is_locked($user_id);
        if ($lock_status) {
            $this->session->set_flashdata('vault_error', 'Terlalu banyak percobaan gagal. Coba lagi dalam ' . $lock_status . '.');
            redirect('admin/server_credentials');
            return;
        }

        $record = $this->Totp_model->get_by_user($user_id);
        if (!$record) {
            redirect('admin/server_credentials/setup_totp');
            return;
        }

        $success = false;

        if ($is_recovery) {
            // Try recovery code
            $success = $this->Totp_model->verify_recovery_code($user_id, $code);
        } else {
            // Try TOTP code
            $success = $this->totp->verify_code($record['secret'], $code);
        }

        if ($success) {
            // Unlock vault
            $this->session->set_userdata('vault_unlocked', true);
            $this->session->set_userdata('vault_unlocked_at', time());
            $this->Totp_model->reset_failed($user_id);
            redirect('admin/server_credentials');
        } else {
            // Increment failed attempts
            $this->Totp_model->increment_failed($user_id);
            
            $error_msg = $is_recovery 
                ? 'Kode pemulihan tidak valid.' 
                : 'Kode OTP tidak valid. Pastikan jam perangkat Anda sinkron.';
            
            $this->session->set_flashdata('vault_error', $error_msg);
            redirect('admin/server_credentials');
        }
    }

    /**
     * Lock vault (manual lock or called on logout)
     */
    public function lock() {
        $this->session->unset_userdata('vault_unlocked');
        $this->session->unset_userdata('vault_unlocked_at');
        redirect('admin/server_credentials');
    }

    /**
     * Reset TOTP (disable and re-setup)
     * Requires current valid OTP to confirm
     */
    public function reset_totp() {
        $user_id = $this->session->userdata('user_id');
        $code = $this->input->post('otp_code');

        $record = $this->Totp_model->get_by_user($user_id);
        if (!$record) {
            redirect('admin/server_credentials/setup_totp');
            return;
        }

        // Must verify current OTP before reset
        if ($this->totp->verify_code($record['secret'], $code)) {
            $this->Totp_model->delete_secret($user_id);
            $this->session->unset_userdata('vault_unlocked');
            $this->session->unset_userdata('vault_unlocked_at');
            $this->session->set_flashdata('success', 'TOTP telah direset. Silakan setup ulang.');
            redirect('admin/server_credentials/setup_totp');
        } else {
            $this->session->set_flashdata('error', 'Kode OTP tidak valid untuk reset.');
            redirect('admin/server_credentials');
        }
    }

    // ─────────────────────────────────────────────────
    //  CREDENTIALS CRUD (Protected by vault lock)
    // ─────────────────────────────────────────────────

    public function index() {
        if ($this->_check_lock()) return;

        $data['title'] = 'Data IP & Password';
        $data['page'] = 'server_credentials';
        
        $data['user'] = [
            'username' => $this->session->userdata('username'),
            'role' => $this->session->userdata('role'),
            'role_name' => $this->session->userdata('role_name'),
            'avatar' => $this->session->userdata('avatar')
        ];

        $data['credentials'] = $this->Server_credential_model->get_all();
        
        // Calculate remaining vault time
        $unlock_time = $this->session->userdata('vault_unlocked_at');
        $data['vault_remaining'] = $unlock_time ? max(0, 1800 - (time() - $unlock_time)) : 0;

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/server_credentials/index', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function create() {
        if ($this->_check_lock()) return;
        $data['title'] = 'Tambah Data IP & Password';
        $data['page'] = 'server_credentials';
        
        $data['user'] = [
            'username' => $this->session->userdata('username'),
            'role' => $this->session->userdata('role'),
            'role_name' => $this->session->userdata('role_name'),
            'avatar' => $this->session->userdata('avatar')
        ];

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/server_credentials/create', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function edit($id) {
        if ($this->_check_lock()) return;
        $data['title'] = 'Edit Data IP & Password';
        $data['page'] = 'server_credentials';
        
        $data['user'] = [
            'username' => $this->session->userdata('username'),
            'role' => $this->session->userdata('role'),
            'role_name' => $this->session->userdata('role_name'),
            'avatar' => $this->session->userdata('avatar')
        ];

        $data['credential'] = $this->Server_credential_model->get_by_id($id);
        
        if (!$data['credential']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/server_credentials');
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/server_credentials/edit', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function store() {
        $this->form_validation->set_rules('vm_name', 'Nama VM', 'required');
        $this->form_validation->set_rules('ip_address', 'IP Address', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'vm_name' => $this->input->post('vm_name'),
                'ip_address' => $this->input->post('ip_address'),
                'domain' => $this->input->post('domain'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'description' => $this->input->post('description')
            ];
            
            if ($this->Server_credential_model->create($data)) {
                $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data');
            }
        }
        redirect('admin/server_credentials');
    }

    public function update($id) {
        $this->form_validation->set_rules('vm_name', 'Nama VM', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'vm_name' => $this->input->post('vm_name'),
                'ip_address' => $this->input->post('ip_address'),
                'domain' => $this->input->post('domain'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'description' => $this->input->post('description')
            ];
            
            if ($this->Server_credential_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Data berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', 'Gagal update data');
            }
        }
        redirect('admin/server_credentials');
    }

    public function delete($id) {
        if ($this->Server_credential_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }
        redirect('admin/server_credentials');
    }
}
