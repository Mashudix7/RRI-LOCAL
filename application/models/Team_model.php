<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->where('is_active', 1);
        $this->db->order_by('display_order', 'ASC');
        $this->db->order_by('name', 'ASC');
        return $this->db->get('teams')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('teams', ['id' => $id])->row_array();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('teams', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('teams', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('teams');
    }

    public function has_main_head($exclude_id = null) {
        $this->db->where('role', 'main_head');
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('teams');
        return $query->num_rows() > 0;
    }

    public function has_director($exclude_id = null) {
        $this->db->where('role', 'director');
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('teams');
        return $query->num_rows() > 0;
    }

    public function has_leader($division, $exclude_id = null) {
        $this->db->where('division', $division);
        $this->db->where('role', 'leader');
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('teams');
        return $query->num_rows() > 0;
    }

    public function count_members($division, $exclude_id = null) {
        $this->db->where('division', $division);
        $this->db->where('role', 'member');
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('teams');
    }

    public function get_all_by_division_sorted() {
        $this->db->from('teams');
        // Sort by role precedence: director=1, main_head=2, leader=3, member=4
        $this->db->order_by("FIELD(role, 'director', 'main_head', 'leader', 'member')", '', FALSE);
        // Then by division
        $this->db->order_by('division', 'ASC');
        $this->db->order_by('name', 'ASC');
        
        return $this->db->get()->result_array();
    }

    public function count_all() {
        return $this->db->count_all('teams');
    }

}
