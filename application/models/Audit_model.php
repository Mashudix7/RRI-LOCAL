<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Log an activity
     * 
     * @param string $action Action name (e.g., 'login', 'create_user')
     * @param string $details Detailed description
     * @param int|null $user_id Optional user ID (defaults to current session)
     * @return bool
     */
    public function log($action, $details = null, $user_id = null) {
        $user_id = $user_id ?? $this->session->userdata('user_id');
        
        // Ensure user_id is NULL if it's empty (like 0) to satisfy foreign key constraints
        if (empty($user_id)) {
            $user_id = NULL;
        }


        // Derive module from action (e.g., create_user -> user) or default to 'system'
        // This is necessary because 'module' column is NOT NULL in database but removed from arguments
        $parts = explode('_', $action);
        $module = count($parts) > 1 ? end($parts) : 'system';

        $data = [
            'user_id' => $user_id,
            'action' => $action,
            'module' => $module,
            'details' => $details,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
            // 'created_at' removed to use MySQL CURRENT_TIMESTAMP (Realtime)
        ];

        return $this->db->insert('audit_logs', $data);
    }

    /**
     * Get all logs
     * Can be filtered by limit/offset for pagination
     */
    public function get_all($limit = 100, $offset = 0) {
        // Fetch user details via JOIN to ensure data appears even if not snapshotted
        $this->db->select('audit_logs.*, users.username, users.role, users.avatar, users.email');
        $this->db->join('users', 'users.id = audit_logs.user_id', 'left');
        $this->db->order_by('audit_logs.created_at', 'DESC');
        return $this->db->get('audit_logs', $limit, $offset)->result_array();
    }

    /**
     * Get logs by date
     * 
     * @param string $date YYYY-MM-DD
     */
    public function get_by_date($date) {
        $this->db->select('audit_logs.*, users.username, users.role, users.avatar, users.email');
        $this->db->join('users', 'users.id = audit_logs.user_id', 'left');
        $this->db->where('DATE(audit_logs.created_at)', $date);
        $this->db->order_by('audit_logs.created_at', 'DESC');
        return $this->db->get('audit_logs')->result_array();
    }
}
