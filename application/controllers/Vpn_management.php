<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vpn_management extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        // Allow Superadmin, Admin, Management, Auditor
        $this->_check_role_access(['superadmin', 'admin', 'management', 'auditor']);
        $this->load->model('Ip_model');
    }

    public function index()
    {
        $data['title'] = 'Manajemen IP VPN';
        $data['page'] = 'vpn_management';
        $data['user'] = $this->_get_user_data();

        // Fetch Data from DB (DYNAMIC)
        $all_vpns = $this->Ip_model->get_all_vpns();
        $data['stats'] = $this->Ip_model->get_vpn_stats();
        
        $data['vpns'] = $all_vpns; 

        $this->render_admin('admin/ip/vpn_management/index', $data);
    }

    public function create()
    {
        // Write access check
        if (!in_array($this->session->userdata('role'), ['superadmin', 'admin', 'management'])) { show_error('Unauthorized', 403); }

        $data['title'] = 'Tambah IP VPN';
        $data['page'] = 'vpn_management';
        $data['user'] = $this->_get_user_data();
        
        $this->render_admin('admin/ip/vpn_management/form', $data);
    }

    public function store()
    {
        if (!in_array($this->session->userdata('role'), ['superadmin', 'admin', 'management'])) { show_error('Unauthorized', 403); }
        
        $data = [
            'satker' => $this->input->post('satker', TRUE),
            'ip_lan' => $this->input->post('ip_lan', TRUE) ?: null,
            'ip_vpn' => $this->input->post('ip_vpn', TRUE) ?: null,
            'status' => $this->input->post('status', TRUE) ?: 'offline'
        ];

        if ($this->Ip_model->create_vpn($data)) {
            $this->session->set_flashdata('success', 'Data VPN berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data VPN.');
        }
        
        redirect('admin/vpn-management');
    }

    public function edit($id)
    {
        if (!in_array($this->session->userdata('role'), ['superadmin', 'admin', 'management'])) { show_error('Unauthorized', 403); }

        $vpn = $this->Ip_model->get_vpn_by_id($id);
        if (!$vpn) show_404();

        $data['title'] = 'Edit IP VPN';
        $data['page'] = 'vpn_management';
        $data['user'] = $this->_get_user_data();
        $data['vpn'] = $vpn;
        
        $this->render_admin('admin/ip/vpn_management/form', $data);
    }

    public function update($id)
    {
        if (!in_array($this->session->userdata('role'), ['superadmin', 'admin', 'management'])) { show_error('Unauthorized', 403); }
        
        $data = [
            'satker' => $this->input->post('satker', TRUE),
            'ip_lan' => $this->input->post('ip_lan', TRUE) ?: null,
            'ip_vpn' => $this->input->post('ip_vpn', TRUE) ?: null,
            'status' => $this->input->post('status', TRUE) ?: 'offline'
        ];

        if ($this->Ip_model->update_vpn($id, $data)) {
            $this->session->set_flashdata('success', 'Data VPN berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data VPN.');
        }
        
        redirect('admin/vpn-management');
    }

    public function delete($id)
    {
        if (!in_array($this->session->userdata('role'), ['superadmin', 'admin', 'management'])) { show_error('Unauthorized', 403); }

        if ($this->Ip_model->delete_vpn($id)) {
            $this->session->set_flashdata('success', 'Data VPN berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data VPN.');
        }
        redirect('admin/vpn-management');
    }
}
