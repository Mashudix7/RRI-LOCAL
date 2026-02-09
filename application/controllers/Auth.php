<?php
/**
 * =====================================================
 * Auth Controller
 * =====================================================
 * 
 * Controller untuk autentikasi pengguna.
 * 
 * @package     CSIRT RRI
 * @subpackage  Controllers
 * @category    Authentication
 * @author      Tim Teknologi Media Baru
 * 
 * Komentar Kritikal:
 * - SEMUA proses login HARUS dicatat di audit log
 * - Password HARUS di-hash menggunakan bcrypt
 * - Session HARUS di-regenerate setelah login berhasil
 * - Implementasi rate limiting untuk mencegah brute force
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    /**
     * Constructor
     * Load model dan library yang diperlukan
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model');
        $this->load->model('Audit_model');
    }

    /**
     * Halaman Login
     */
    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['title'] = 'Login';
        $data['error'] = $this->session->flashdata('error');
        $data['success'] = $this->session->flashdata('success');
        
        $this->load->view('auth/login', $data);
    }

    /**
     * Proses Autentikasi
     */
    public function authenticate()
    {
        // Load security manager
        $this->load->library('Security_manager');
        
        // Validasi
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required|trim', [
            'required' => 'Username harus diisi.'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required', [
            'required' => 'Password harus diisi.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
            redirect('auth/login');
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');
        $ip_address = $this->input->ip_address();

        // Check rate limiting by IP
        if (!$this->security_manager->check_rate_limit($ip_address, 'ip')) {
            $this->security_manager->log_login_attempt($username, false, 'Rate limit exceeded (IP)');
            $this->session->set_flashdata('error', 'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.');
            redirect('auth/login');
            return;
        }

        // Check rate limiting by username
        if (!$this->security_manager->check_rate_limit($username, 'username')) {
            $this->security_manager->log_login_attempt($username, false, 'Rate limit exceeded (Username)');
            $this->session->set_flashdata('error', 'Terlalu banyak percobaan login untuk username ini. Silakan coba lagi dalam 15 menit.');
            redirect('auth/login');
            return;
        }

        // Check Login
        $user = $this->User_model->login($username, $password);

        if ($user) {
            // Check if account is locked
            if ($this->security_manager->is_account_locked($user['id'])) {
                $this->security_manager->log_login_attempt($username, false, 'Account locked');
                $this->session->set_flashdata('error', 'Akun Anda dikunci karena terlalu banyak percobaan login yang gagal. Silakan hubungi administrator.');
                redirect('auth/login');
                return;
            }
            
            // Check if account is active
            if (isset($user['status']) && $user['status'] !== 'active') {
                $this->security_manager->log_login_attempt($username, false, 'Account inactive');
                $this->session->set_flashdata('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
                redirect('auth/login');
                return;
            }
            
            // Regenerate session for security
            $this->session->sess_regenerate(TRUE);
            
            // Set session data
            $sess_data = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'role_name' => ucfirst($user['role']),
                'logged_in' => TRUE,
                'login_time' => time(),
                'last_activity' => time(), // Initialize activity tracking
                'login_ip' => $ip_address,
                'avatar' => $user['avatar'] ?? 'default_avatar.png'
            ];
            $this->session->set_userdata($sess_data);

            // Update user login info
            $this->db->where('id', $user['id']);
            $this->db->update('users', [
                'last_login' => date('Y-m-d H:i:s'),
                'last_activity' => date('Y-m-d H:i:s'),
                'login_ip' => $ip_address
            ]);

            // Reset failed attempts
            $this->security_manager->reset_failed_attempts($user['id']);

            // Audit Log (Success)
            $this->Audit_model->log('login', 'User logged in successfully', $user['id']);
            
            // Security Log (Success)
            $this->security_manager->log_login_attempt($username, true);

            // Set flash for toast notification
            $this->session->set_flashdata('toast_success', 'Login berhasil! Selamat datang, ' . $user['username']);

            redirect('dashboard');
        } else {
            // Get user ID for failed attempt tracking
            $this->db->select('id');
            $this->db->where('username', $username);
            $user_data = $this->db->get('users')->row();
            
            if ($user_data) {
                // Increment failed attempts
                $this->security_manager->increment_failed_attempts($user_data->id);
            }
            
            // Audit Log (Failed)
            $this->Audit_model->log('login_failed', "Failed login attempt for username: $username from IP: $ip_address", NULL);
            
            // Security Log (Failed)
            $this->security_manager->log_login_attempt($username, false, 'Invalid credentials');

            $this->session->set_flashdata('error', 'Username atau password salah.');
            redirect('auth/login');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Audit Log & Activity Update
        if ($this->session->userdata('logged_in')) {
            $user_id = $this->session->userdata('user_id');
            $this->Audit_model->log('logout', 'User logged out');
            
            // Set activity to NULL or old date to appear offline immediately
            $this->db->where('id', $user_id);
            $this->db->update('users', ['last_activity' => NULL]);
        }

        // Destroy session
        $this->session->sess_destroy();
        
        // Redirect with query string to signal logout (flashdata doesn't survive sess_destroy)
        redirect('auth/login?logout=success');
    }
}
