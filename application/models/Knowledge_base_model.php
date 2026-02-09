<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledge_base_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($limit = null, $offset = 0) {
        $this->db->order_by('created_at', 'DESC');
        if($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('knowledge_base')->result_array();
    }

    public function get_public($limit = null, $offset = 0) {
        $this->db->where('is_public', 1);
        $this->db->order_by('created_at', 'DESC');
        if($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('knowledge_base')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('knowledge_base', ['id' => $id])->row_array();
    }

    public function get_by_slug($slug) {
        return $this->db->get_where('knowledge_base', ['slug' => $slug])->row_array();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('knowledge_base', $data);
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('knowledge_base', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('knowledge_base');
    }
}
