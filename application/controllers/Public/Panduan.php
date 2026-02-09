<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panduan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Knowledge_base_model');
    }

    public function index()
    {
        $data['title'] = 'Panduan & SOP';
        $data['articles'] = $this->Knowledge_base_model->get_public();
        
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/panduan', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function detail($slug)
    {
        $article = $this->Knowledge_base_model->get_by_slug($slug);
        
        if (!$article || !$article['is_public']) {
            show_404();
        }

        $this->Knowledge_base_model->update($article['id'], ['views' => $article['views'] + 1]);
        
        $data['title'] = $article['title'];
        $data['article'] = $article;
        $data['recent'] = $this->Knowledge_base_model->get_public(5);
        
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/panduan_detail', $data);
        $this->load->view('layouts/footer', $data);
    }
}
