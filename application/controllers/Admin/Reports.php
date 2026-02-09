<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->_check_role_access(['admin', 'auditor']); // Auditors can view reports
        $this->load->model('User_model');
        $this->load->model('Article_model');
        $this->load->model('Knowledge_base_model');
        $this->load->model('Evidence_model');
        $this->load->model('Audit_log_model'); // Need access to logs, but might need custom query
    }

    public function index()
    {
        $data['title'] = 'Laporan Bulanan';
        $data['page'] = 'reports';
        
        $month = $this->input->get('month') ?? date('m');
        $year = $this->input->get('year') ?? date('Y');
        
        $data['selected_month'] = $month;
        $data['selected_year'] = $year;

        // --- Get Stats for Selected Month ---
        $start_date = "$year-$month-01 00:00:00";
        $end_date = date("Y-m-t 23:59:59", strtotime($start_date));

        // 1. New Evidence Uploaded
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $data['total_evidence'] = $this->db->count_all_results('evidence');

        // 2. New KB Articles
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $data['total_kb'] = $this->db->count_all_results('knowledge_base');

        // 3. New News Articles
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $data['total_articles'] = $this->db->count_all_results('articles');
        
        // 4. Login Activity (Success vs Failed)
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $this->db->where('action', 'LOGIN');
        $data['login_success'] = $this->db->count_all_results('audit_logs');

        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $this->db->where('action', 'LOGIN_FAILED');
        $data['login_failed'] = $this->db->count_all_results('audit_logs');
        
        // 5. Recent Audit Logs (Sample 10)
        $this->db->select('audit_logs.*, users.username');
        $this->db->from('audit_logs');
        $this->db->join('users', 'users.id = audit_logs.user_id', 'left');
        $this->db->where('audit_logs.created_at >=', $start_date);
        $this->db->where('audit_logs.created_at <=', $end_date);
        $this->db->order_by('audit_logs.created_at', 'DESC');
        $this->db->limit(10);
        $data['recent_logs'] = $this->db->get()->result_array();

        $this->render_admin('admin/reports/index', $data);
    }
}
