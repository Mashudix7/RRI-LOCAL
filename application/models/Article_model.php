<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($limit = null, $offset = 0) {
        $this->db->select('articles.*, users.username as author');
        $this->db->from('articles');
        $this->db->join('users', 'users.id = articles.author_id', 'left');
        $this->db->order_by('articles.created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('articles', ['id' => $id])->row_array();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('articles', $data);
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('articles', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('articles');
    }
    
    public function count_all() {
        return $this->db->count_all('articles');
    }
    
    /**
     * Get published articles with optional category filter
     * @param int|null $limit - Max number of articles
     * @param string|null $category - Category to filter (case-insensitive)
     * @return array
     */
    public function get_published($limit = null, $category = null) {
        $this->db->select('articles.*, users.username as author');
        $this->db->from('articles');
        $this->db->join('users', 'users.id = articles.author_id', 'left');
        $this->db->where('articles.status', 'published');
        
        // Filter by category if provided (case-insensitive)
        if (!empty($category)) {
            $this->db->where('LOWER(articles.category)', strtolower($category));
        }
        
        $this->db->order_by('articles.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        return $this->db->get()->result_array();
    }

    public function count_by_category($category) {
        $this->db->where('LOWER(category)', strtolower($category));
        $this->db->where('status', 'published');
        return $this->db->count_all_results('articles');
    }
}
