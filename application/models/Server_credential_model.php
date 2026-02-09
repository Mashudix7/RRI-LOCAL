<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_credential_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->get('server_credentials')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('server_credentials', ['id' => $id])->row_array();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('server_credentials', $data);
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('server_credentials', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('server_credentials');
    }
    
    public function count_all() {
        return $this->db->count_all('server_credentials');
    }
}
