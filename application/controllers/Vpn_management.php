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

    public function export()
    {
        // Check access
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $this->load->helper('download');
        $vpns = $this->Ip_model->get_all_vpns();
        $filename = 'Laporan_Data_IP_VPN_' . date('Ymd_His') . '.xls';

        // Headers for Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<html>';
        echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';
        echo '<body>';
        echo '<h3>Laporan Data IP VPN Tunnel & LAN Satker RRI</h3>';
        echo '<table border="1" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">';
        echo '<thead>';
        echo '<tr style="background-color: #4CAF50; color: white;">';
        echo '<th style="padding: 10px; text-align: center; width: 50px;">No.</th>';
        echo '<th style="padding: 10px; text-align: left;">Daerah / Unit (Satker)</th>';
        echo '<th style="padding: 10px; text-align: left;">Network (LAN)</th>';
        echo '<th style="padding: 10px; text-align: left;">Gateway / IP Tunnel</th>';
        echo '<th style="padding: 10px; text-align: center;">Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $no = 1;
        foreach ($vpns as $vpn) {
            $status_color = ($vpn['status'] === 'online') ? 'color: #2e7d32; font-weight: bold;' : 'color: #c62828;';
            $status_bg = ($vpn['status'] === 'online') ? 'background-color: #e8f5e9;' : 'background-color: #ffebee;';
            
            echo "<tr>";
            echo "<td style=\"padding: 8px; text-align: center;\">{$no}</td>";
            echo "<td style=\"padding: 8px;\">{$vpn['satker']}</td>";
            echo "<td style=\"padding: 8px; font-family: monospace;\">{$vpn['ip_lan']}</td>";
            echo "<td style=\"padding: 8px; font-family: monospace;\">{$vpn['ip_vpn']}</td>";
            echo "<td style=\"padding: 8px; text-align: center; {$status_color} {$status_bg}\">" . ucfirst($vpn['status']) . "</td>";
            echo "</tr>";
            $no++;
        }

        echo '</tbody>';
        echo '</table>';
        echo '</body></html>';
    }
}
