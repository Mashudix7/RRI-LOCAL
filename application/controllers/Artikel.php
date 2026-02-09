<?php
/**
 * =====================================================
 * Artikel Controller
 * =====================================================
 * 
 * Controller untuk halaman artikel publik.
 * Menampilkan daftar dan detail artikel keamanan siber.
 * 
 * @package     CSIRT RRI
 * @subpackage  Controllers
 * @category    Public Content
 * @author      Tim Teknologi Media Baru
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Article_model');
    }

    /**
     * Daftar Artikel
     */
    public function index($kategori = null)
    {
        // Disable cache to ensure fresh articles are shown
        // $this->output->cache(30);

        $data['title'] = 'Artikel';
        
        // Filter kategori dari URL segment (artikel/kategori/xxx) atau query string
        if (empty($kategori)) {
            $kategori = $this->input->get('kategori', TRUE); // Fallback to query string
        }
        $data['kategori'] = $kategori ? strtolower(urldecode($kategori)) : '';
        
        // Get published articles from database (filtered by status and optional category)
        $data['articles'] = $this->Article_model->get_published(null, $data['kategori']);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('landing/artikel', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Detail Artikel
     */
    public function detail($id)
    {
        // Disable cache for fresh content
        // $this->output->cache(60);

        // Find article by ID
        $article = $this->Article_model->get_by_id($id);
        
        if (!$article) {
            show_404();
        }
        
        $data['title'] = $article['title'];
        $data['article'] = $article;
        
        // Related articles (latest 3 published, except current)
        $all_articles = $this->Article_model->get_published(4);
        $data['related_articles'] = array_filter($all_articles, function($a) use ($id) {
            return $a['id'] != $id;
        });
        $data['related_articles'] = array_slice($data['related_articles'], 0, 3);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('landing/artikel_detail', $data);
        $this->load->view('templates/footer', $data);
    }
}
