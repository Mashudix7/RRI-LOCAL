<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->get_where('users', ['is_deleted' => 0])->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('users', ['id' => $id, 'is_deleted' => 0])->row_array();
    }

    public function create($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('users', $data);
    }

    public function update($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->update('users', [
            'is_deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function login($username, $password) {
        $user = $this->db->get_where('users', [
            'username' => $username,
            'is_deleted' => 0
        ])->row_array();
        
        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $this->db->where('id', $user['id']);
            $this->db->update('users', ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }
        return false;
    }

    public function update_activity($user_id) {
        $this->db->where('id', $user_id);
        $this->db->update('users', [
            'last_activity' => date('Y-m-d H:i:s')
        ]);
    }

    public function get_all_with_status() {
        $users = $this->db->get_where('users', ['is_deleted' => 0])->result_array();
        
        // Define online threshold (e.g., 5 minutes)
        $threshold = 5 * 60; // 5 minutes in seconds
        $current_time = time();

        foreach ($users as &$user) {
            if (!empty($user['last_activity'])) {
                $last_activity_time = strtotime($user['last_activity']);
                $time_diff = $current_time - $last_activity_time;
                $user['is_online'] = ($time_diff <= $threshold);
            } else {
                $user['is_online'] = false;
            }
        }

        // Sort: Online users first, then by ID
        usort($users, function($a, $b) {
            if ($a['is_online'] && !$b['is_online']) return -1;
            if (!$a['is_online'] && $b['is_online']) return 1;
            return $a['id'] - $b['id'];
        });

        return $users;
    }

    public function count_all() {
        return $this->db->where('is_deleted', 0)->count_all_results('users');
    }
}
