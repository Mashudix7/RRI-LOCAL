<?php
/**
 * =====================================================
 * Landing Controller
 * =====================================================
 * 
 * Controller untuk halaman publik (company profile).
 * Tidak memerlukan autentikasi.
 * 
 * @package     CSIRT RRI
 * @subpackage  Controllers
 * @category    Landing Page
 * @author      Tim Teknologi Media Baru
 * 
 * Komentar Kritikal:
 * - Controller ini TIDAK boleh mengakses data sensitif insiden
 * - Semua halaman di sini bersifat publik (internal network)
 * - Tidak ada session check yang diperlukan
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    /**
     * Constructor
     * Load helper & library yang diperlukan
     */
    public function __construct()
    {
        parent::__construct();
        // Load URL helper untuk base_url()
        $this->load->helper('url');
        $this->load->model('Team_model');
        $this->load->model('Article_model');
    }

    /**
     * Halaman Beranda
     * Menampilkan hero section dan overview CSIRT
     */
    public function index()
    {
        // Cache removed to support dynamic session state in navbar
        // $this->output->cache(60);

        $data['title'] = 'Beranda';
        
        // Get latest 3 articles for news section
        $data['recent_articles'] = $this->Article_model->get_all(3, 0);

        // Fetch Stats (Using DB count or fallback)
        $data['stats'] = [
            'tickets_resolved' => 1240, // Default base
            'attacks_blocked' => 8500, // Default base
            'active_monitoring' => '24/7',
            'uptime' => '99.9%'
        ];
        
        // Try to get real counts if tables exist
        if ($this->db->table_exists('tickets')) {
             $data['stats']['tickets_resolved'] += $this->db->where('status', 'resolved')->count_all_results('tickets');
        }
        if ($this->db->table_exists('login_attempts')) {
             $data['stats']['attacks_blocked'] += $this->db->count_all('login_attempts');
         }

        // Fetch Article Counts by Category
        $data['article_counts'] = [
            'keamanan' => $this->Article_model->count_by_category('keamanan'),
            'panduan' => $this->Article_model->count_by_category('panduan'),
            'pengumuman' => $this->Article_model->count_by_category('pengumuman'),
            'berita' => $this->Article_model->count_by_category('berita'),
        ];
        
        // Load views dengan template
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('landing/home', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Halaman Tentang CSIRT
     * Menampilkan visi, misi, dan ruang lingkup kerja
     */
    public function tentang()
    {
        // Cache removed to support dynamic session state in navbar
        // $this->output->cache(60);

        $data['title'] = 'Tentang CSIRT';
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('landing/about', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Halaman Tim
     * Menampilkan profil anggota tim CSIRT
     */
    public function tim()
    {
        // Cache removed to support dynamic session state in navbar
        // $this->output->cache(60);

        $data['title'] = 'Tim Kami';
        
        // Data tim dari database
        $all_teams = $this->Team_model->get_all();
        
        $data['director'] = null;
        $data['main_head'] = null; // Keeping for potential fallback or legacy, though view might ignore
        $grouped_teams = [];

        foreach ($all_teams as $member) {
            $role = $member['role'] ?? '';
            
            if ($role === 'director') {
                $data['director'] = $member;
                continue;
            }
            if ($role === 'main_head') {
                $data['main_head'] = $member;
                continue;
            }

            $division = $member['division'] ?? 'Lainnya'; 
            if (!isset($grouped_teams[$division])) {
                $grouped_teams[$division] = [];
            }
            $grouped_teams[$division][] = $member;
        }

        // Sort each group: Leader first, then others
        foreach ($grouped_teams as $div => &$members) {
            usort($members, function($a, $b) {
                $level_order = ['leader' => 1, 'member' => 2];
                $wa = $level_order[$a['role'] ?? 'member'] ?? 99;
                $wb = $level_order[$b['role'] ?? 'member'] ?? 99;
                if ($wa != $wb) return $wa - $wb;
                return strcmp($a['name'], $b['name']);
            });
        }
        
        $data['grouped_teams'] = $grouped_teams;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('landing/team', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Halaman Kontak
     * Informasi kontak dan form (jika diperlukan)
     */
    public function kontak()
    {
        // Cache output for 60 minutes
        // $this->output->cache(60);

        $data['title'] = 'Kontak';
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('landing/contact', $data);
        $this->load->view('templates/footer', $data);
    }
}
