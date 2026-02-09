<?php
/**
 * =====================================================
 * Security Manager Library
 * =====================================================
 * 
 * Provides security utilities for CSIRT application
 * - Rate limiting
 * - Input sanitization
 * - File upload validation
 * - XSS/SQL injection prevention
 * 
 * @package     CSIRT RRI
 * @subpackage  Libraries
 * @category    Security
 * @author      Tim Teknologi Media Baru
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_manager {
    
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
    }
    
    /**
     * Check rate limiting for login attempts
     * @param string $identifier - Username or IP address
     * @param string $type - 'username' or 'ip'
     * @return bool - True if allowed, False if rate limited
     */
    public function check_rate_limit($identifier, $type = 'username', $max_attempts = 5, $time_window = 900)
    {
        // Get settings from database if available
        $this->CI->load->model('Settings_model');
        $max_attempts = $this->CI->Settings_model->get_value('max_login_attempts', $max_attempts);
        $time_window = $this->CI->Settings_model->get_value('login_lockout_duration', $time_window);
        
        $time_threshold = date('Y-m-d H:i:s', time() - $time_window);
        
        if ($type === 'username') {
            $this->CI->db->where('username', $identifier);
        } else {
            $this->CI->db->where('ip_address', $identifier);
        }
        
        $this->CI->db->where('attempt_time >=', $time_threshold);
        $this->CI->db->where('success', 0);
        $count = $this->CI->db->count_all_results('login_history');
        
        return $count < $max_attempts;
    }
    
    /**
     * Log login attempt
     * @param string $username
     * @param bool $success
     * @param string $failure_reason
     */
    public function log_login_attempt($username, $success = false, $failure_reason = '')
    {
        $data = [
            'username' => $username,
            'ip_address' => $this->CI->input->ip_address(),
            'user_agent' => $this->CI->input->user_agent(),
            'attempt_time' => date('Y-m-d H:i:s'),
            'success' => $success ? 1 : 0,
            'failure_reason' => $failure_reason
        ];
        
        $this->CI->db->insert('login_history', $data);
    }
    
    /**
     * Check if account is locked
     * @param int $user_id
     * @return bool
     */
    public function is_account_locked($user_id)
    {
        $this->CI->db->select('account_locked_until');
        $this->CI->db->where('id', $user_id);
        $result = $this->CI->db->get('users')->row();
        
        if (!$result || !$result->account_locked_until) {
            return false;
        }
        
        // Check if lock has expired
        if (strtotime($result->account_locked_until) < time()) {
            // Unlock account
            $this->unlock_account($user_id);
            return false;
        }
        
        return true;
    }
    
    /**
     * Lock user account
     * @param int $user_id
     * @param int $duration - Duration in seconds
     */
    public function lock_account($user_id, $duration = 900)
    {
        $this->CI->load->model('Settings_model');
        $duration = $this->CI->Settings_model->get_value('login_lockout_duration', $duration);
        
        $lock_until = date('Y-m-d H:i:s', time() + $duration);
        
        $this->CI->db->where('id', $user_id);
        $this->CI->db->update('users', [
            'account_locked_until' => $lock_until,
            'failed_login_attempts' => 0 // Reset counter
        ]);
    }
    
    /**
     * Unlock user account
     * @param int $user_id
     */
    public function unlock_account($user_id)
    {
        $this->CI->db->where('id', $user_id);
        $this->CI->db->update('users', [
            'account_locked_until' => NULL,
            'failed_login_attempts' => 0
        ]);
    }
    
    /**
     * Increment failed login attempts
     * @param int $user_id
     */
    public function increment_failed_attempts($user_id)
    {
        $this->CI->db->set('failed_login_attempts', 'failed_login_attempts + 1', FALSE);
        $this->CI->db->where('id', $user_id);
        $this->CI->db->update('users');
        
        // Check if should lock account
        $this->CI->db->select('failed_login_attempts');
        $this->CI->db->where('id', $user_id);
        $result = $this->CI->db->get('users')->row();
        
        $this->CI->load->model('Settings_model');
        $max_attempts = $this->CI->Settings_model->get_value('max_login_attempts', 5);
        
        if ($result && $result->failed_login_attempts >= $max_attempts) {
            $this->lock_account($user_id);
        }
    }
    
    /**
     * Reset failed login attempts
     * @param int $user_id
     */
    public function reset_failed_attempts($user_id)
    {
        $this->CI->db->where('id', $user_id);
        $this->CI->db->update('users', ['failed_login_attempts' => 0]);
    }
    
    /**
     * Validate file upload for security
     * @param array $file - $_FILES array element
     * @param array $allowed_types - Allowed MIME types
     * @param int $max_size - Max file size in KB
     * @return array - ['valid' => bool, 'error' => string]
     */
    public function validate_file_upload($file, $allowed_types = [], $max_size = 2048)
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['valid' => false, 'error' => 'Invalid file upload'];
        }
        
        // Check file size
        if ($file['size'] > ($max_size * 1024)) {
            return ['valid' => false, 'error' => 'File size exceeds maximum allowed (' . $max_size . 'KB)'];
        }
        
        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!empty($allowed_types) && !in_array($mime_type, $allowed_types)) {
            return ['valid' => false, 'error' => 'File type not allowed'];
        }
        
        // Check for malicious content in images
        if (strpos($mime_type, 'image/') === 0) {
            $image_info = @getimagesize($file['tmp_name']);
            if (!$image_info) {
                return ['valid' => false, 'error' => 'Invalid image file'];
            }
        }
        
        // Check filename for malicious patterns
        $filename = $file['name'];
        if (preg_match('/\.(php|phtml|php3|php4|php5|exe|sh|bat)$/i', $filename)) {
            return ['valid' => false, 'error' => 'Dangerous file extension detected'];
        }
        
        return ['valid' => true, 'error' => ''];
    }
    
    /**
     * Sanitize output for XSS prevention
     * @param mixed $data
     * @return mixed
     */
    public function sanitize_output($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize_output'], $data);
        }
        
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Generate secure random token
     * @param int $length
     * @return string
     */
    public function generate_token($length = 32)
    {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Clean old login attempts (cleanup cron job)
     * @param int $days_old - Remove attempts older than this
     */
    public function cleanup_old_attempts($days_old = 30)
    {
        $threshold = date('Y-m-d H:i:s', strtotime("-{$days_old} days"));
        $this->CI->db->where('attempt_time <', $threshold);
        $this->CI->db->delete('login_history');
    }
    
    /**
     * Validate password strength
     * @param string $password
     * @return array - ['valid' => bool, 'errors' => array]
     */
    public function validate_password_strength($password)
    {
        $errors = [];
        
        $this->CI->load->model('Settings_model');
        $min_length = $this->CI->Settings_model->get_value('password_min_length', 8);
        $require_uppercase = $this->CI->Settings_model->get_value('password_require_uppercase', 1);
        $require_number = $this->CI->Settings_model->get_value('password_require_number', 1);
        $require_special = $this->CI->Settings_model->get_value('password_require_special', 1);
        
        if (strlen($password) < $min_length) {
            $errors[] = "Password harus minimal {$min_length} karakter";
        }
        
        if ($require_uppercase && !preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password harus mengandung huruf besar";
        }
        
        if ($require_number && !preg_match('/[0-9]/', $password)) {
            $errors[] = "Password harus mengandung angka";
        }
        
        if ($require_special && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = "Password harus mengandung karakter khusus";
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
