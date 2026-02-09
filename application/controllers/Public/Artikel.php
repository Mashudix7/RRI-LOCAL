<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Article_model');
        $this->load->library('pagination');
    }

    public function index() {
        $data['title'] = 'Artikel & Berita';

        // ... Logic Pagination (Simplified for transfer)
        $config['base_url'] = base_url('artikel');
        $config['total_rows'] = $this->Article_model->count_all();
        $config['per_page'] = 6;
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['articles'] = $this->Article_model->get_all($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/artikel_list', $data); // Renamed View
        $this->load->view('layouts/footer', $data);
    }

    public function detail($id) {
        $data['article'] = $this->Article_model->get_by_id($id);
        if(!$data['article']) show_404();

        $data['title'] = $data['article']['title'];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/artikel_detail', $data); // Renamed View
        $this->load->view('layouts/footer', $data);
    }
}
