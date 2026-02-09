<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evidence_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($limit = null, $offset = 0) {
        $this->db->select('evidence.*, users.username as uploader');
        $this->db->from('evidence');
        $this->db->join('users', 'users.id = evidence.uploaded_by', 'left');
        $this->db->order_by('evidence.created_at', 'DESC');
        if($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('evidence', ['id' => $id])->row_array();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('evidence', $data);
    }
    
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('evidence');
    }
}
