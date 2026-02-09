<?php
/**
 * =====================================================
 * Dashboard Controller
 * =====================================================
 * 
 * Controller untuk dashboard admin CSIRT.
 * Memerlukan autentikasi.
 * 
 * @package     CSIRT RRI
 * @subpackage  Controllers
 * @category    Dashboard
 * @author      Tim Teknologi Media Baru
 * 
 * Komentar Kritikal:
 * - SEMUA method di sini memerlukan user yang sudah login
 * - Akses ke dashboard dicek di constructor
 * - Data statistik harus di-query secara efisien
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        // Admin_Controller already handles session and database
    }

    /**
     * Halaman Utama Dashboard
     * 
     * Komentar:
     * - Menampilkan statistik overview insiden
     * - Data statistik ditampilkan secara real-time dari DB & WAF
     */
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard';
        
        // Data user from session
        $data['user'] = $this->_get_user_data();
        
        // Load WAF Model
        $this->load->model('Waf_model');
        
        // Fetch Real-time Stats from Safeline WAF
        $waf_data = $this->Waf_model->get_daily_stats();
        $waf_events = $this->Waf_model->get_daily_events(30);
        
        $data['stats'] = $waf_data['summary'];
        $data['attack_stats'] = $waf_data['types'];
        $data['recent_logs'] = $waf_data['recent'];
        $data['recent_events'] = $waf_events;
        
        // Render using parent helper
        $this->render_admin('admin/dashboard', $data);
    }
}
