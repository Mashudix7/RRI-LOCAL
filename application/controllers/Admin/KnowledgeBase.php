<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KnowledgeBase extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->_check_role_access(['admin', 'access_management']); // Assuming roles. Admin allows all.
        $this->load->model('Knowledge_base_model');
    }

    public function index()
    {
        $data['title'] = 'Knowledge Base';
        $data['page'] = 'knowledge_base';
        $data['kb_articles'] = $this->Knowledge_base_model->get_all();
        
        $this->render_admin('admin/knowledge_base/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Panduan';
        $data['page'] = 'knowledge_base';
        
        $this->render_admin('admin/knowledge_base/create', $data);
    }

    public function store()
    {
        $title = $this->input->post('title');
        $slug = url_title($title, 'dash', TRUE);
        
        $data = [
            'title' => $title,
            'slug' => $slug,
            'category' => $this->input->post('category'),
            'content' => $this->input->post('content'),
            'is_public' => $this->input->post('is_public') ? 1 : 0
        ];
        
        if ($this->Knowledge_base_model->create($data)) {
            $this->session->set_flashdata('success', 'Panduan berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan panduan!');
        }
        redirect('admin/knowledgebase');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Panduan';
        $data['page'] = 'knowledge_base';
        $data['article'] = $this->Knowledge_base_model->get_by_id($id);
        
        if (!$data['article']) show_404();
        
        $this->render_admin('admin/knowledge_base/edit', $data);
    }

    public function update($id)
    {
        $title = $this->input->post('title');
        $slug = url_title($title, 'dash', TRUE);

        $data = [
            'title' => $title,
            'slug' => $slug,
            'category' => $this->input->post('category'),
            'content' => $this->input->post('content'),
            'is_public' => $this->input->post('is_public') ? 1 : 0
        ];
        
        if ($this->Knowledge_base_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Panduan berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui panduan!');
        }
        redirect('admin/knowledgebase');
    }

    public function delete($id)
    {
        if ($this->Knowledge_base_model->delete($id)) {
            $this->session->set_flashdata('success', 'Panduan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus panduan!');
        }
        redirect('admin/knowledgebase');
    }
}
