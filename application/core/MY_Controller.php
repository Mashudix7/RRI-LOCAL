<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Comprehensive Security Headers
        $this->output->set_header('X-Frame-Options: SAMEORIGIN');
        $this->output->set_header('X-Content-Type-Options: nosniff');
        $this->output->set_header('X-XSS-Protection: 1; mode=block');
        $this->output->set_header('Referrer-Policy: strict-origin-when-cross-origin');
        $this->output->set_header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
        
        // Content Security Policy - Permissive for Local Development/Debugging
        $this->output->set_header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval' data: blob:;");
        
        // HSTS - Enable in production with valid SSL
        // $this->output->set_header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
}

class Admin_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load common libraries and models
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form', 'security']);
        $this->load->model('User_model');
        $this->load->model('Audit_model');

        // Check login status
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        } else {
            // Check session timeout (2 hours = 7200 seconds)
            $last_activity = $this->session->userdata('last_activity');
            $current_time = time();
            
            if ($last_activity && ($current_time - $last_activity) > 7200) {
                // Session expired
                $this->session->sess_destroy();
                $this->session->set_flashdata('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
                redirect('auth/login');
            }
            
            // Update last activity timestamp
            $this->session->set_userdata('last_activity', $current_time);
            
            // Update user last activity in database
            $this->User_model->update_activity($this->session->userdata('user_id'));
        }
    }

    /**
     * Helper to render admin views with standard layout
     */
    protected function render_admin($view, $data = [])
    {
        // Get current user data for the layout (navbar/sidebar)
        $user_data = $this->_get_user_data();
        $data['current_user'] = $user_data;
        $data['user'] = $user_data; // Compatibility with older templates using $user

        // Load partials
        $this->load->view('admin/templates/header', $data); 
        $this->load->view('admin/templates/sidebar', $data);
        // Topbar might be redundant if Sidebar handles it or included in header
        $this->load->view($view, $data);
        $this->load->view('admin/templates/footer');
    }

    /**
     * Check role access
     */
    protected function _check_role_access($allowed_roles)
    {
        $user_role = $this->session->userdata('role');
        if (!in_array($user_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            redirect('admin/dashboard'); 
        }
    }

    /**
     * Get fresh user data
     */
    protected function _get_user_data()
    {
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_by_id($user_id);
        
        // Add default photo if missing (logic copied from views)
        if (empty($user['photo'])) {
            $user['username'] = $user['username'] ?? 'User'; // Fallback
            $user['photo_url'] = "https://ui-avatars.com/api/?name=" . urlencode($user['username']) . "&background=random";
        } else {
            $user['photo_url'] = base_url($user['photo']);
        }
        
        return $user;
    }
}
