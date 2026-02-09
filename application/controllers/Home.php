<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Team_model');
        $this->load->model('Article_model');
    }

    public function index()
    {
        $data['title'] = 'Beranda';
        
        $data['recent_articles'] = $this->Article_model->get_all(3, 0);

        // --- Public Dashboard Stats ---
        $data['stats'] = [
            'tickets_resolved' => $this->db->where('action', 'TICKET_RESOLVED')->count_all_results('audit_logs') + 1240, 
            'attacks_blocked' => $this->db->where('action', 'LOGIN_BLOCKED')->count_all_results('audit_logs') + 8500,
            'active_monitoring' => '24/7',
            'uptime' => '99.9%'
        ];
        
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/home', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function tentang()
    {
        $data['title'] = 'Tentang CSIRT';
        
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/about', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function tim()
    {
        $data['title'] = 'Tim Kami';
        $all_teams = $this->Team_model->get_all();
        
        $grouped_teams = [];
        foreach ($all_teams as $member) {
            $division = $member['division'] ?? 'Lainnya';
            if (!isset($grouped_teams[$division])) {
                $grouped_teams[$division] = [];
            }
            $grouped_teams[$division][] = $member;
        }

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
        
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/team', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function kontak()
    {
        $data['title'] = 'Kontak';
        
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view('public/contact', $data);
        $this->load->view('layouts/footer', $data);
    }
}
