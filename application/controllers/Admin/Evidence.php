<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evidence extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->_check_role_access(['admin', 'access_management', 'auditor']);
        $this->load->model('Evidence_model');
    }

    public function index()
    {
        $data['title'] = 'Evidence Locker';
        $data['page'] = 'evidence';
        $data['evidence_list'] = $this->Evidence_model->get_all();
        
        $this->render_admin('admin/evidence/index', $data);
    }

    public function upload()
    {
        $data['title'] = 'Upload Evidence';
        $data['page'] = 'evidence';
        
        $this->render_admin('admin/evidence/upload', $data);
    }

    public function store()
    {
        // Check if upload path exists, create if not
        $upload_path = APPPATH . 'uploads/evidence/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
            // Create .htaccess to deny direct access
            file_put_contents($upload_path . '.htaccess', 'Deny from all');
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = '*'; // Allow all types, restricted by logic
        $config['max_size'] = 102400; // 100MB
        $config['encrypt_name'] = TRUE; // Randomize name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('evidence_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('admin/evidence/upload');
            return;
        }

        $file_data = $this->upload->data();
        $full_path = $file_data['full_path'];
        
        // Calculate SHA-256 Hash
        $file_hash = hash_file('sha256', $full_path);

        $data = [
            'title' => $this->input->post('title'),
            'case_ref_no' => $this->input->post('case_ref_no'),
            'file_name' => $file_data['file_name'],
            'original_name' => $file_data['client_name'],
            'file_type' => $file_data['file_type'],
            'file_size' => $file_data['file_size'],
            'file_hash' => $file_hash,
            'uploaded_by' => $this->session->userdata('user_id'),
            'notes' => $this->input->post('notes')
        ];

        if ($this->Evidence_model->create($data)) {
            // Log Audit
            $this->Audit_log_model->log($this->session->userdata('user_id'), 'UPLOAD_EVIDENCE', "Uploaded {$data['original_name']} (Ref: {$data['case_ref_no']})", 'evidence');
            $this->session->set_flashdata('success', 'Evidence uploaded successfully! Hash: ' . substr($file_hash, 0, 8) . '...');
        } else {
            // Delete file if DB insert fails
            unlink($full_path);
            $this->session->set_flashdata('error', 'Database error.');
        }

        redirect('admin/evidence');
    }

    public function download($id)
    {
        $evidence = $this->Evidence_model->get_by_id($id);
        if (!$evidence) {
            show_404();
        }

        $file_path = APPPATH . 'uploads/evidence/' . $evidence['file_name'];
        if (!file_exists($file_path)) {
            show_404();
        }

        // Log Download
        $this->Audit_log_model->log($this->session->userdata('user_id'), 'DOWNLOAD_EVIDENCE', "Downloaded {$evidence['original_name']}", 'evidence');

        // Force Download
        $this->load->helper('download');
        force_download($evidence['original_name'], file_get_contents($file_path));
    }

    public function delete($id)
    {
        $evidence = $this->Evidence_model->get_by_id($id);
        if ($evidence) {
             $file_path = APPPATH . 'uploads/evidence/' . $evidence['file_name'];
             if (file_exists($file_path)) {
                 unlink($file_path);
             }
             $this->Evidence_model->delete($id);
             $this->Audit_log_model->log($this->session->userdata('user_id'), 'DELETE_EVIDENCE', "Deleted {$evidence['original_name']}", 'evidence');
             $this->session->set_flashdata('success', 'Evidence deleted.');
        } else {
            $this->session->set_flashdata('error', 'Evidence not found.');
        }
        redirect('admin/evidence');
    }
}
