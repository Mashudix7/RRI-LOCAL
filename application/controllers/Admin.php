<?php
/**
 * =====================================================
 * Admin Controller
 * =====================================================
 * 
 * Controller untuk semua halaman administrasi.
 * Memerlukan autentikasi dan role admin.
 * 
 * @package     CSIRT RRI
 * @subpackage  Controllers
 * @category    Administration
 * @author      Tim Teknologi Media Baru
 * 
 * Komentar Kritikal:
 * - SEMUA method memerlukan autentikasi
 * - Role admin diperlukan untuk akses
 * - Audit log untuk semua aksi sensitif
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->database();
        $this->load->library('form_validation'); // Make sure validation is loaded
        // Models will be loaded on-demand in specific methods to improve performance
        // except User_model and Audit_model which are used frequently/globally in this controller
        $this->load->model('User_model');
        $this->load->model('Audit_model');
        
        // Proteksi: Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Proteksi: Cek role yang diizinkan (Semua role yang valid boleh masuk, tapi akses menu dibatasi di method masing-masing)
        $role = $this->session->userdata('role');
        $allowed_roles = ['admin', 'management', 'auditor'];
        
        if (!in_array($role, $allowed_roles)) {
            // Role tidak dikenali
            $this->session->sess_destroy();
            redirect('auth/login');
        }
        
        // Update user activity timestamp (untuk status online & last login)
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->User_model->update_activity($user_id);
        }
    }

    /**
     * User Management
     */
    public function users()
    {
        // RBAC: Admin Only
        if ($this->session->userdata('role') !== 'admin' && $this->session->userdata('role') !== 'auditor') {
            show_error('Unauthorized Access', 403);
        }

        $data['title'] = 'Manajemen Pengguna';
        $data['page'] = 'users';
        $data['user'] = $this->_get_user_data();
        
        $data['users'] = $this->User_model->get_all_with_status();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    /**
     * User Management CRUD
     */
    public function user_create()
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $data['title'] = 'Tambah Pengguna';
        $data['page'] = 'users'; 
        $data['user'] = $this->_get_user_data();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/users/create', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function user_store()
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $this->form_validation->set_rules('username', 'Username', 'required|callback__check_unique_username');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__check_unique_email');
        $this->form_validation->set_rules('password', 'Password', 'required|callback__check_password_strength');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,management,auditor]');

        if ($this->form_validation->run() === FALSE) {
            // Set flashdata error dengan pesan validasi
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            $this->user_create();
            return;
        }

        $data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'), // Model will hash it
            'role' => $this->input->post('role'),
            'status' => 'active', // Default status for new users
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Handle Image Upload
        if (!empty($_FILES['avatar']['name'])) {
            $config['upload_path'] = './uploads/avatars/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size'] = 5120; // 5MB
            $config['file_name'] = 'avatar_' . time();

            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('avatar')) {
                $upload_data = $this->upload->data();
                $data['avatar'] = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/user_create');
                return;
            }
        } else {
            $data['avatar'] = 'default_avatar.png'; // Default
        }

        if ($this->User_model->create($data)) {
            $this->Audit_model->log('create_user', 'Created user: ' . $data['username']);
            $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan pengguna ke database.');
        }
        
        redirect('admin/users');
    }

    /**
     * Password Strength Callback
     */
    public function _check_password_strength($password)
    {
        if ($this->_is_strong_password($password)) {
            return TRUE;
        }

        $this->form_validation->set_message(['_check_password_strength' => '{field} kurang kuat! Gunakan minimal 8 karakter dengan kombinasi Huruf Besar, Angka & Simbol.']);
        return FALSE;
    }

    private function _is_strong_password($password)
    {
        if (strlen($password) < 8) return FALSE;
        if (!preg_match("#[0-9]+#", $password)) return FALSE;
        if (!preg_match("#[a-z]+#", $password)) return FALSE;
        if (!preg_match("#[A-Z]+#", $password)) return FALSE;
        // Use [^A-Za-z0-9] to match frontend logic (includes underscore and symbols)
        if (!preg_match("#[^A-Za-z0-9]+#", $password)) return FALSE;
        return TRUE;
    }

    /**
     * Unique Username Callback (Ignore Deleted)
     */
    public function _check_unique_username($username)
    {
        $this->db->where('username', $username);
        // Removed is_deleted check to ensure global uniqueness
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message(['_check_unique_username' => 'Username sudah digunakan (termasuk akun non-aktif)!']);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Unique Email Callback
     */
    public function _check_unique_email($email)
    {
        $this->db->where('email', $email);
        // Removed is_deleted check to ensure global uniqueness
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message(['_check_unique_email' => 'Email sudah terdaftar (termasuk akun non-aktif)!']);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Profile Detail
     */
    public function profile()
    {
        $data['title'] = 'Profil Saya';
        $data['page'] = 'profile';
        $data['user'] = $this->_get_user_data();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/profile', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    /**
     * Dashboard (Homepage)
     */
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard';
        $data['user'] = $this->_get_user_data();

        // Load WAF Model
        $this->load->model('Waf_model');
        
        // Fetch Real-time Stats & Logs from Safeline WAF
        $waf_data = $this->Waf_model->get_daily_stats();
        
        // Fetch Dedicated Events from Safeline API
        $waf_events = $this->Waf_model->get_daily_events(30);

        // Load Infrastructure Model
        $this->load->model('Ip_model');
        $infra_stats = $this->Ip_model->get_global_stats();
        $vpn_stats = $this->Ip_model->get_vpn_stats();

        $data['stats'] = $waf_data['summary'];
        $data['attack_stats'] = $waf_data['types'];
        // logs = raw records (individual events)
        $data['recent_logs'] = $waf_data['recent'] ?? []; 
        
        // events = grouped events from open/events api
        $data['recent_events'] = $waf_events ?? [];

        // Add additional dynamic stats
        $data['stats']['uptime'] = '99.9%'; 
        $data['stats']['protected_sites'] = $infra_stats['total_networks'] ?? 12; // Using networks as "sites" or proxy
        $data['stats']['infra'] = [
            'data_centers' => 4, // Still hardcoded if no model for this, but could be from Ip_model if needed
            'vpns' => $vpn_stats['total'] ?? 0,
            'ips' => $infra_stats['total_ips'] ?? 0
        ];
        // Debug Log
        if (empty($data['recent_logs'])) {
            log_message('error', 'DEBUG: recent_logs is EMPTY');
        }
        if (empty($data['recent_events'])) {
            log_message('error', 'DEBUG: recent_events is EMPTY');
        } else {
            log_message('debug', 'DEBUG: recent_events has ' . count($data['recent_events']) . ' items');
            file_put_contents(APPPATH . 'cache/admin_events_check.txt', 'Count: ' . count($data['recent_events']));
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function user_edit($id)
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $data['title'] = 'Edit Pengguna';
        $data['page'] = 'users';
        $data['user'] = $this->_get_user_data();
        
        $data['user_edit'] = $this->User_model->get_by_id($id);
        
        if (!$data['user_edit']) {
            show_404();
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/users/edit', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function user_update($id)
    {
         if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        // SECURITY: Get current user ID and target user 
        $current_user_id = $this->session->userdata('user_id');
        $target_user = $this->User_model->get_by_id($id);
        
        // SECURITY: Prevent admin from changing their own role
        $new_role = $this->input->post('role');
        if ($id == $current_user_id && $new_role !== $target_user['role']) {
            $this->session->set_flashdata('error', 'Anda tidak dapat mengubah role akun Anda sendiri!');
            redirect('admin/users');
            return;
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,management,auditor]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->user_edit($id);
            return;
        }

        $data = [
            'email' => $this->input->post('email'),
            'role' => $this->input->post('role')
        ];

        // Update Password only if provided
        $password = $this->input->post('password');
        if (!empty($password)) {
            if (!$this->_is_strong_password($password)) {
                $this->session->set_flashdata('error', 'Password baru kurang kuat! Gunakan minimal 8 karakter dengan kombinasi Huruf Besar, Angka & Simbol.');
                redirect('admin/user_edit/' . $id);
                return;
            }
            $data['password'] = $password; 
        }

        // Handle Image Upload
        if (!empty($_FILES['avatar']['name'])) {
            $config['upload_path'] = './uploads/avatars/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size'] = 5120; // 5MB
            $config['file_name'] = 'avatar_' . time();

            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('avatar')) {
                $upload_data = $this->upload->data();
                $data['avatar'] = $upload_data['file_name'];
            }
        }

        if ($this->User_model->update($id, $data)) {
            $this->Audit_model->log('update_user', 'Updated user ID: ' . $id);
            $this->session->set_flashdata('success', 'Pengguna berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui pengguna.');
        }

        redirect('admin/users');
    }

    /**
     * Team Management
     */
    public function teams($action = 'index', $id = null)
    {
        $this->load->model('Team_model');
        $role = $this->session->userdata('role');
        $data = [];

        // RBAC Check
        if (in_array($action, ['create', 'store', 'edit', 'update', 'delete'])) {
             if (!in_array($role, ['admin', 'management'])) {
                 show_error('Unauthorized', 403);
             }
        }

        switch ($action) {
            case 'create':
                $data['title'] = 'Tambah Anggota Tim';
                $data['page'] = 'teams';
                $data['leaders_status'] = [
                    'Tim IT' => $this->Team_model->has_leader('Tim IT'),
                    'Tim Teknologi Media Baru' => $this->Team_model->has_leader('Tim Teknologi Media Baru')
                ];
                $this->render_admin('admin/teams/create', $data);
                break;

            case 'store':
                $input = $this->input->post();
                
                // Special handling for Director
                if ($input['role'] === 'director') {
                    if ($this->Team_model->has_director()) {
                        $this->session->set_flashdata('error', 'Posisi Kepala Direktur sudah terisi! Hanya boleh ada 1 Kepala Direktur.');
                        redirect('admin/teams/create');
                        return;
                    }
                    $input['division'] = 'Direksi';
                }

                unset($input[$this->security->get_csrf_token_name()]);
                if (!empty($_FILES['photo']['name'])) {
                    $upload = $this->_upload_and_resize('photo', 400, 400);
                    if ($upload['status']) $input['photo'] = 'assets/uploads/' . $upload['file_name'];
                }
                if ($this->Team_model->create($input)) {
                    $this->session->set_flashdata('success', 'Anggota tim berhasil ditambahkan');
                }
                redirect('admin/teams');
                break;

            case 'edit':
                $data['title'] = 'Edit Anggota Tim';
                $data['page'] = 'teams';
                $data['member'] = $this->Team_model->get_by_id($id);
                if (!$data['member']) show_404();
                $this->render_admin('admin/teams/edit', $data);
                break;

            case 'update':
                $input = $this->input->post();
                
                // Special handling for Director
                if ($input['role'] === 'director') {
                    if ($this->Team_model->has_director($id)) {
                        $this->session->set_flashdata('error', 'Posisi Kepala Direktur sudah terisi! Hanya boleh ada 1 Kepala Direktur.');
                        redirect('admin/teams/edit/' . $id);
                        return;
                    }
                    $input['division'] = 'Direksi';
                }

                unset($input[$this->security->get_csrf_token_name()]);
                if (!empty($_FILES['photo']['name'])) {
                    $upload = $this->_upload_and_resize('photo', 400, 400);
                    if ($upload['status']) $input['photo'] = 'assets/uploads/' . $upload['file_name'];
                }
                if ($this->Team_model->update($id, $input)) {
                    $this->session->set_flashdata('success', 'Data tim berhasil diperbarui');
                }
                redirect('admin/teams');
                break;

            case 'delete':
                if ($this->Team_model->delete($id)) {
                    $this->session->set_flashdata('success', 'Anggota tim berhasil dihapus');
                }
                redirect('admin/teams');
                break;

            case 'index':
            default:
                $data['title'] = 'Manajemen Tim';
                $data['page'] = 'teams';
                $all_teams = $this->Team_model->get_all_by_division_sorted();
                $data['all_teams'] = $all_teams;
                
                // Segregate roles
                $data['director'] = array_filter($all_teams, function($t) { return $t['role'] == 'director'; });
                $data['main_head'] = array_filter($all_teams, function($t) { return $t['role'] == 'main_head'; });
                
                $data['team_media_baru'] = array_filter($all_teams, function($t) { 
                    return $t['division'] == 'Tim Teknologi Media Baru' && !in_array($t['role'], ['main_head', 'director']); 
                });
                $data['team_it'] = array_filter($all_teams, function($t) { 
                    return $t['division'] == 'Tim IT' && !in_array($t['role'], ['main_head', 'director']); 
                });
                $this->render_admin('admin/teams/teams', $data);
                break;
        }
    }

    public function user_delete($id)
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);
        
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun sendiri!');
            redirect('admin/users');
            return;
        }

        $user = $this->User_model->get_by_id($id);
        if ($this->User_model->delete($id)) {
             $this->Audit_model->log('delete_user', 'Deleted user: ' . ($user['username'] ?? $id));
             $this->session->set_flashdata('success', 'Pengguna berhasil dihapus!');
        } else {
             $this->session->set_flashdata('error', 'Gagal menghapus pengguna.');
        }
        redirect('admin/users');
    }

    /**
     * Audit Log
     */
    public function audit_log()
    {
        $role = $this->session->userdata('role');
        if ($role !== 'admin' && $role !== 'auditor') {
            show_error('Unauthorized', 403);
        }

        $data['title'] = 'Audit Log';
        $data['page'] = 'audit_log';
        $data['user'] = $this->_get_user_data();

        // Date Filter Logic
        $date = $this->input->get('date');
        if (empty($date)) {
            $date = date('Y-m-d'); // Default to today
        }
        $data['selected_date'] = $date;
        
        $data['logs'] = $this->Audit_model->get_by_date($date); 

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/audit_log', $data); 
        $this->load->view('admin/templates/footer', $data);
    }

    /**
     * Article Management
     */
    /**
     * Article Management
     */
    public function articles($action = 'index', $id = null)
    {
        $data['user'] = $this->_get_user_data();

        // RBAC Check for CUD
        $role = $this->session->userdata('role');
        if (in_array($action, ['create', 'store', 'edit', 'update', 'delete'])) {
             if (!in_array($role, ['admin', 'management'])) {
                 show_error('Unauthorized', 403);
             }
        }

        // Ensure model is loaded
        $this->load->model('Article_model');

        switch ($action) {
            case 'create':
                $data['title'] = 'Tambah Artikel';
                $data['page'] = 'articles';
                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/templates/sidebar', $data);
                $this->load->view('admin/articles/create', $data);
                $this->load->view('admin/templates/footer', $data);
                break;

            case 'store':
                // Handle form submission
                $input = $this->input->post();
                
                // Explicitly validatable fields
                $this->form_validation->set_rules('title', 'Judul', 'required');
                $this->form_validation->set_rules('content', 'Konten', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                    $this->session->set_flashdata('error', validation_errors());
                    redirect('admin/articles/create');
                    return;
                }

                $thumbnail = null;
                // Handle File Upload
                if (!empty($_FILES['thumbnail']['name'])) {
                    $upload = $this->_upload_and_resize('thumbnail', 800, 600);
                    if ($upload['status']) {
                        $thumbnail = 'assets/uploads/' . $upload['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $upload['error']);
                        redirect('admin/articles/create');
                        return;
                    }
                }
                
                // Prepare Data for DB (EXPLICIT MAPPING)
                $data = [
                    'title' => $input['title'],
                    'slug'  => url_title($input['title'], '-', TRUE),
                    'category' => $input['category'],
                    'content' => $input['content'],
                    'status' => $input['status'],
                    'author_id' => $this->session->userdata('user_id'),
                    'thumbnail' => $thumbnail,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Handle Excerpt
                $data['excerpt'] = !empty($input['excerpt']) ? $input['excerpt'] : substr(strip_tags($input['content']), 0, 150);
                
                // Handle Published Date
                if ($input['status'] === 'published') {
                    $data['published_at'] = date('Y-m-d H:i:s');
                } else {
                    $data['published_at'] = null;
                }

                if ($this->Article_model->create($data)) {
                    $this->Audit_model->log('create_article', 'Created article: ' . substr($input['title'], 0, 50));
                    $this->session->set_flashdata('success', 'Artikel berhasil ditambahkan');
                } else {
                    $db_error = $this->db->error();
                    $this->session->set_flashdata('error', 'Gagal menambahkan artikel: ' . ($db_error['message'] ?? 'Unknown Error'));
                }
                redirect('admin/articles');
                break;

            case 'edit':
                $data['title'] = 'Edit Artikel';
                $data['page'] = 'articles';
                $data['article'] = $this->Article_model->get_by_id($id);
                
                if (!$data['article']) {
                    show_404();
                }

                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/templates/sidebar', $data);
                $this->load->view('admin/articles/edit', $data);
                $this->load->view('admin/templates/footer', $data);
                break;
                
            case 'update':
                $input = $this->input->post();
                
                // Prepare Data for DB (EXPLICIT MAPPING)
                $data = [
                    'title' => $input['title'],
                    'category' => $input['category'],
                    'content' => $input['content'],
                    'status' => $input['status'],
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (isset($input['title'])) {
                    $data['slug'] = url_title($input['title'], '-', TRUE);
                }

                // Handle File Upload
                if (!empty($_FILES['thumbnail']['name'])) {
                    $upload = $this->_upload_and_resize('thumbnail', 800, 600);
                    if ($upload['status']) {
                        $data['thumbnail'] = 'assets/uploads/' . $upload['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $upload['error']);
                        redirect('admin/articles/edit/' . $id);
                        return;
                    }
                }
                
                // Handle Excerpt if user changed it? Or simple update logic
                // If we want to auto-update excerpt when content changes unless explicitly set:
                // For now, simpler:
                if (!empty($input['excerpt'])) {
                    $data['excerpt'] = $input['excerpt'];
                }

                // Handle Published Date Update
                if ($input['status'] === 'published') {
                    $data['published_at'] = date('Y-m-d H:i:s');
                }

                if ($this->Article_model->update($id, $data)) {
                    $this->Audit_model->log('update_article', 'Updated article ID: ' . $id);
                    $this->session->set_flashdata('success', 'Artikel berhasil diperbarui');
                } else {
                    $db_error = $this->db->error();
                    $this->session->set_flashdata('error', 'Gagal memperbarui artikel: ' . ($db_error['message'] ?? 'Unknown Error'));
                }
                redirect('admin/articles');
                break;
                
            case 'delete':
                $article = $this->Article_model->get_by_id($id);
                if ($this->Article_model->delete($id)) {
                    $this->Audit_model->log('delete_article', 'Deleted article: ' . ($article['title'] ?? $id));
                    $this->session->set_flashdata('success', 'Artikel berhasil dihapus');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menghapus artikel');
                }
                redirect('admin/articles');
                break;

            case 'index':
            default:
                $data['title'] = 'Manajemen Artikel';
                $data['page'] = 'articles';
                $data['articles'] = $this->Article_model->get_all();
                
                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/templates/sidebar', $data);
                $this->load->view('admin/articles/articles', $data);
                $this->load->view('admin/templates/footer', $data);
                break;
        }
    }

    /**
     * Helper: Upload and Resize Image
     */
    private function _upload_and_resize($field_name, $width, $height)
    {
        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
        $config['max_size']      = 5120; // 5MB
        // $config['encrypt_name']  = TRUE; // Disable to keep easy names or enable for security

        // Check if directory exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($field_name)) {
            return ['status' => false, 'error' => $this->upload->display_errors()];
        }

        $upload_data = $this->upload->data();
        
        // Resize Image
        $config_resize['image_library']  = 'gd2';
        $config_resize['source_image']   = $upload_data['full_path'];
        $config_resize['create_thumb']   = FALSE;
        $config_resize['maintain_ratio'] = TRUE;
        $config_resize['width']          = $width;
        $config_resize['height']         = $height;
        $config_resize['quality']        = '80%'; 

        $this->load->library('image_lib', $config_resize);
        $this->image_lib->resize();
        $this->image_lib->clear();

        return ['status' => true, 'file_name' => $upload_data['file_name']];
    }

    /**
     * Reports
     */
    public function reports()
    {
        $data['title'] = 'Laporan & St atistik Keamanan';
        $data['page'] = 'reports';
        $data['user'] = $this->_get_user_data();
        
        // Security Statistics  
        $data['stats'] = [
            'total_users' => $this->db->count_all('users'),
            'successful_logins' => $this->db->where('success', 1)
                ->where('attempt_time >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->count_all_results('login_history'),
            'failed_logins' => $this->db->where('success', 0)
                ->where('attempt_time >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->count_all_results('login_history'),
            'active_sessions' => $this->db->where('timestamp >=', time() - 7200)
                ->count_all_results('ci_sessions')
        ];
        
        // Recent Activity (last 10 audit logs)
        $this->db->select('audit_logs.*, users.username');
        $this->db->from('audit_logs');
        $this->db->join('users', 'users.id = audit_logs.user_id', 'left');
        $this->db->order_by('audit_logs.created_at', 'DESC');
        $this->db->limit(10);
        $data['recent_activity'] = $this->db->get()->result_array();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/reports', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    /**
     * Settings
     */
    /**
     * Settings
     */
    public function settings()
    {
        if ($this->session->userdata('role') !== 'admin' && $this->session->userdata('role') !== 'auditor') {
            show_error('Unauthorized Access', 403);
        }

        $this->load->model('Settings_model');

        $data['title'] = 'Pengaturan Sistem';
        $data['page'] = 'settings';
        $data['user'] = $this->_get_user_data();
        $data['settings_grouped'] = $this->Settings_model->get_all_grouped();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/settings', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function settings_update()
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $this->load->model('Settings_model');
        $input = $this->input->post();

        if (!empty($input)) {
            $updated_count = 0;
            foreach ($input as $key => $value) {
                // Ignore CSRF token if present
                if ($key == $this->security->get_csrf_token_name()) continue;

                if ($this->Settings_model->update($key, $value)) {
                    $updated_count++;
                }
            }
            
            // Log Action
            $this->Audit_model->log('update_settings', "Updated $updated_count settings");
            $this->session->set_flashdata('success', 'Pengaturan berhasil disimpan.');
        }

        redirect('admin/settings');
    }



    /**
     * IP Address Management
     */
    /**
     * IP Address Management
     */

    // =====================================================
    // INCIDENT RESPONSE SYSTEM
    // =====================================================

    public function incident_triage($id)
    {
        $data = $this->_get_user_data();
        $data['title'] = 'Incident Triage';
        $data['incident'] = $this->_get_mock_incident($id); // Mock data for now
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        // $this->load->view('admin/templates/topbar'); // Removed invalid view
        $this->load->view('admin/incidents/triage', $data);
        $this->load->view('admin/templates/footer');
    }

    public function incident_assignment($id)
    {
        $data = $this->_get_user_data();
        $data['title'] = 'Incident Assignment';
        $data['incident'] = $this->_get_mock_incident($id);
        $data['teams'] = [
            'network' => 'Tim Jaringan',
            'server' => 'Tim Server',
            'security' => 'Tim Keamanan',
            'dev' => 'Tim Developer'
        ];
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        // $this->load->view('admin/templates/topbar'); // Removed invalid view
        $this->load->view('admin/incidents/assignment', $data);
        $this->load->view('admin/templates/footer');
    }

    public function incident_investigation($id)
    {
        $data = $this->_get_user_data();
        $data['title'] = 'Incident Investigation';
        $data['incident'] = $this->_get_mock_incident($id);
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        // $this->load->view('admin/templates/topbar'); // Removed invalid view
        $this->load->view('admin/incidents/investigation', $data);
        $this->load->view('admin/templates/footer');
    }

    public function incident_mitigation($id)
    {
        $data = $this->_get_user_data();
        $data['title'] = 'Incident Mitigation';
        $data['incident'] = $this->_get_mock_incident($id);
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        // $this->load->view('admin/templates/topbar'); // Removed invalid view
        $this->load->view('admin/incidents/mitigation', $data);
        $this->load->view('admin/templates/footer');
    }

    public function incident_recovery($id)
    {
        $data = $this->_get_user_data();
        $data['title'] = 'Incident Recovery';
        $data['incident'] = $this->_get_mock_incident($id);
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        // $this->load->view('admin/templates/topbar'); // Removed invalid view
        $this->load->view('admin/incidents/recovery', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _get_mock_incident($id)
    {
        return [
            'id' => $id,
            'title' => 'Suspicious Activity Detected',
            'description' => 'Unusual traffic pattern observed on port 8080.',
            'status' => 'Open',
            'source' => 'System Monitoring',
            'reported_at' => date('Y-m-d H:i:s'),
            'reporter' => 'SysAdmin',
            'severity' => 'High',
            'category' => 'Intrusion',
            'affected_systems' => 'Web Server 01',
            'pic' => 'Budi Santoso',
            'sla_deadline' => date('Y-m-d H:i:s', strtotime('+4 hours'))
        ];
    }



    /**
     * IP Address Management
     */


    // =====================================================
    // IP Management (Public IP - Dynamic from DB)
    // =====================================================
    public function ip_management($region = null)
    {
        $data['user'] = $this->_get_user_data();
        $data['page'] = 'ip_management'; 
        
        $this->load->model('Ip_model');
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data); 

        // Fetch Data from DB
        $search = $this->input->get('q');
        $all_ip_data = $this->Ip_model->get_all_grouped_by_network($search);

        // If no region selected, show dashboard with summary data
        if (!$region) {
            $data['title'] = 'Manajemen IP Address';
            
            // Generate Summary for Dashboard Cards
            $summary = [];
            foreach ($all_ip_data as $slug => $net) {
                // Calculate usage stats dynamically based on DB rows
                // Assumptions: 
                // - Total IPs = Rows in DB (for now, as we only seeded significant ones)
                // - Used = Status active
                // To display "Total Capacity" (e.g. /26 = 64 IPs), we would need calculation. 
                // User requirement: "Data yg sebelumnya hardcode dijadikan database".
                // The DB rows represent the "Inventory".
                
                $total_rows = count($net['ips']);
                $used_rows = 0;
                foreach ($net['ips'] as $ip) {
                    if ($ip['status'] == 'active') $used_rows++;
                }

                $summary[$slug] = [
                    'name' => $net['name'],
                    'cidr' => $net['cidr'],
                    'range_start' => $net['range_start'],
                    'range_end' => $net['range_end'],
                    'subnet_mask' => $net['subnet_mask'] ?? '255.255.255.0',
                    'total' => $total_rows,
                    'used' => $used_rows,
                    'free' => $total_rows - $used_rows,
                    'usage_percent' => ($total_rows > 0) ? round(($used_rows / $total_rows) * 100) : 0
                ];
            }

            $data['regions'] = $summary;
            $data['global_stats'] = $this->Ip_model->get_global_stats();

            $this->load->view('admin/ip/ip_management/index', $data);
        } else {
            // Show specific region list
            if (isset($all_ip_data[$region])) {
                $data['title'] = $all_ip_data[$region]['name'];
                $data['location_name'] = $all_ip_data[$region]['name'];
                $data['network_cidr'] = $all_ip_data[$region]['cidr'];
                $data['ip_list'] = $all_ip_data[$region]['ips'];
                $this->load->view('admin/ip/ip_management/list', $data);
            } else {
                show_404();
            }
        }

        $this->load->view('admin/templates/footer');
    }

    public function ip_export($region)
    {
        // Cek login & role
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }

        $this->load->model('Ip_model');

        $search = $this->input->get('q');
        $all_ip_data = $this->Ip_model->get_all_grouped_by_network($search);

        // =====================================================
        // 1. Export Summary (Laporan Rekapitulasi)
        // =====================================================
        if ($region === 'summary') {
            $filename = 'Laporan_Rekapitulasi_IP_Address_' . date('Ymd_His') . '.xls';
            
            // Set Headers for Excel Download
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            echo '<html>';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';
            echo '<body>';
            echo '<h3>Laporan Rekapitulasi IP Address Data Center</h3>';
            echo '<table border="1" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">';
            echo '<thead>';
            echo '<tr style="background-color: #4CAF50; color: white;">';
            echo '<th style="padding: 10px; text-align: center;">No.</th>';
            echo '<th style="padding: 10px; text-align: left;">Network IP</th>';
            echo '<th style="padding: 10px; text-align: left;">Range IP Akhir</th>';
            echo '<th style="padding: 10px; text-align: left;">Subnet Mask</th>';
            echo '<th style="padding: 10px; text-align: center;">Prefix</th>';
            echo '<th style="padding: 10px; text-align: center;">Total IP</th>';
            echo '<th style="padding: 10px; text-align: left;">Lokasi / Nama Network</th>';
            echo '<th style="padding: 10px; text-align: left;">Keterangan</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $no = 1;
            foreach ($all_ip_data as $slug => $net) {
                $total_rows = count($net['ips']);
                $is_reserve = (stripos($slug, 'reserve') !== false || stripos($net['name'], 'reserve') !== false);
                $bg_color = $is_reserve ? 'background-color: #fff9c4;' : ''; // Light yellow for reserve

                echo "<tr style=\"$bg_color\">";
                echo "<td style=\"padding: 8px; text-align: center;\">{$no}</td>";
                echo "<td style=\"padding: 8px; font-weight: bold;\">{$net['range_start']}</td>";
                echo "<td style=\"padding: 8px;\">{$net['range_end']}</td>";
                echo "<td style=\"padding: 8px;\">" . ($net['subnet_mask'] ?? '255.255.255.0') . "</td>";
                echo "<td style=\"padding: 8px; text-align: center;\">{$net['cidr']}</td>";
                echo "<td style=\"padding: 8px; text-align: center;\">{$total_rows}</td>";
                echo "<td style=\"padding: 8px;\">{$net['name']}</td>";
                echo "<td style=\"padding: 8px; font-style: italic;\">" . ($is_reserve ? 'Reserved / Cadangan' : 'Data Center / Core') . "</td>";
                echo "</tr>";
                $no++;
            }
            echo '</tbody>';
            echo '</table>';
            echo '</body></html>';
            return;
        }

        // =====================================================
        // 2. Export Specific Region (Detail List)
        // =====================================================
        if (!isset($all_ip_data[$region])) {
            show_404();
            return;
        }

        $network = $all_ip_data[$region];
        $ips = $network['ips'];
        $filename = 'Laporan_Detail_IP_' . str_replace(' ', '_', $network['name']) . '_' . date('Ymd_His') . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<html>';
        echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';
        echo '<body>';
        echo "<h3>Laporan Detail IP Address - {$network['name']} ({$network['cidr']})</h3>";
        
        // Add Network Info Summary at top
        echo '<table border="0" style="margin-bottom: 20px; font-family: Arial, sans-serif;">';
        echo "<tr><td><strong>Network</strong></td><td>: {$network['range_start']} - {$network['range_end']}</td></tr>";
        $subnet = isset($network['subnet_mask']) ? $network['subnet_mask'] : '-';
        echo "<tr><td><strong>Subnet/CIDR</strong></td><td>: {$subnet} / {$network['cidr']}</td></tr>";
        echo "<tr><td><strong>Total IP</strong></td><td>: " . count($ips) . "</td></tr>";
        echo '</table>';

        echo '<table border="1" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">';
        echo '<thead>';
        echo '<tr style="background-color: #2196F3; color: white;">';
        echo '<th style="padding: 10px; text-align: center; width: 50px;">No.</th>';
        echo '<th style="padding: 10px; text-align: left; width: 150px;">IP Address</th>';
        echo '<th style="padding: 10px; text-align: left; width: 300px;">Keterangan / Penggunaan</th>';
        echo '<th style="padding: 10px; text-align: center; width: 100px;">Status</th>';
        echo '<th style="padding: 10px; text-align: center; width: 100px;">Tipe</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($ips as $ip) {
            $is_reserve = isset($ip['is_reserve']) && $ip['is_reserve'];
            $is_gateway = isset($ip['type']) && $ip['type'] === 'gateway';
            
            $bg_color = '';
            if ($is_reserve) $bg_color = 'background-color: #fff9c4; color: #f57f17;'; // Yellowish
            elseif ($is_gateway) $bg_color = 'background-color: #e3f2fd; color: #1565c0; font-weight: bold;'; // Bluish
            elseif ($ip['status'] == 'active') $bg_color = 'background-color: #e8f5e9;'; // Greenish

            $description = htmlspecialchars($ip['description']);
            if (empty($description)) $description = '-';
            
            $status_label = ucfirst($ip['status']);
            if ($is_reserve) $status_label = 'Reserved';

            echo "<tr style=\"$bg_color\">";
            echo "<td style=\"padding: 8px; text-align: center;\">{$ip['no']}</td>";
            echo "<td style=\"padding: 8px;\">{$ip['ip_address']}</td>";
            echo "<td style=\"padding: 8px;\">{$description}</td>";
            echo "<td style=\"padding: 8px; text-align: center;\">{$status_label}</td>";
            echo "<td style=\"padding: 8px; text-align: center;\">" . ucfirst($ip['type']) . "</td>";
            echo "</tr>";
        }

        echo '</tbody>';
        echo '</table>';
        echo '</body></html>';
    }

    public function ip_private()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Manajemen IP Private';
        $data['page'] = 'ip_private';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/ip/ip_private', $data);
        $this->load->view('admin/templates/footer', $data);
    }



    // =====================================================
    // Network CRUD Actions
    // =====================================================
    public function networks()
    {
        $data['title'] = 'Kelola Network Wilayah';
        $data['page'] = 'ip_management';
        $data['user'] = $this->_get_user_data();
        
        $this->load->model('Ip_model');
        $data['networks'] = $this->Ip_model->get_networks();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/ip/ip_management/networks/index', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function network_create()
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $data['title'] = 'Tambah Network';
        $data['page'] = 'ip_management';
        $data['user'] = $this->_get_user_data();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/ip/ip_management/networks/form', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function network_store()
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $this->load->model('Ip_model');
        
        $data = [
            'slug' => url_title($this->input->post('name'), 'dash', TRUE),
            'name' => $this->input->post('name'),
            'cidr' => $this->input->post('cidr'),
            'range_start' => $this->input->post('range_start'),
            'range_end' => $this->input->post('range_end'),
            'subnet_mask' => $this->input->post('subnet_mask'),
            'description' => $this->input->post('description'),
            'is_reserve' => $this->input->post('is_reserve') ? 1 : 0
        ];

        // Check duplicate? For now, standard insert
        if ($this->Ip_model->create_network($data)) {
            $this->Audit_model->log('create_network', 'Created network: ' . $data['name']);
            $this->session->set_flashdata('success', 'Network berhasil ditambahkan!');
        } else {
            $error = $this->db->error(); // Capture DB error like duplicate slug
            $this->session->set_flashdata('error', 'Gagal menambahkan network: ' . $error['message']);
        }
        
        redirect('admin/ip_management/networks');
    }

    public function network_edit($id)
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $this->load->model('Ip_model');
        $network = $this->Ip_model->get_network_by_id($id);
        
        if(!$network) show_404();

        $data['title'] = 'Edit Network';
        $data['page'] = 'ip_management';
        $data['user'] = $this->_get_user_data();
        $data['network'] = $network;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/ip/ip_management/networks/form', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function network_update($id)
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $this->load->model('Ip_model');
        
        $data = [
            'name' => $this->input->post('name'),
            'cidr' => $this->input->post('cidr'),
            'range_start' => $this->input->post('range_start'),
            'range_end' => $this->input->post('range_end'),
            'subnet_mask' => $this->input->post('subnet_mask'),
            'description' => $this->input->post('description'),
            'is_reserve' => $this->input->post('is_reserve') ? 1 : 0
        ];

        if ($this->Ip_model->update_network($id, $data)) {
            $this->Audit_model->log('update_network', 'Updated network ID: ' . $id);
            $this->session->set_flashdata('success', 'Data Network berhasil diperbarui!');
        } else {
             $this->session->set_flashdata('error', 'Gagal memperbarui data network.');
        }
        redirect('admin/ip_management/networks');
    }

    public function network_delete($id)
    {
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $this->load->model('Ip_model');
        // Get name before delete for log
        $network = $this->Ip_model->get_network_by_id($id);

        if ($this->Ip_model->delete_network($id)) {
            $this->Audit_model->log('delete_network', 'Deleted network: ' . ($network['name'] ?? $id));
            $this->session->set_flashdata('success', 'Network berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus network.');
        }
        redirect('admin/ip_management/networks');
    }

    // =====================================================
    // IP CRUD (Individual)
    // =====================================================

    public function ip_edit($ip_or_id = null)
    {
        // Admin & Management
        if (!in_array($this->session->userdata('role'), ['admin', 'management'])) {
            show_error('Unauthorized', 403);
        }

        $this->load->model('Ip_model');
        
        $ip_data = null;
        
        // Retrieve explicit query param if present (safer for IPs with dots)
        $query_ip = $this->input->get('ip'); 
        if ($query_ip) {
            $ip_or_id = $query_ip;
        }

        // 1. Try by ID (if numeric)
        if (is_numeric($ip_or_id)) {
            $ip_data = $this->Ip_model->get_ip_by_id($ip_or_id);
        }

        // 2. If not found by ID (or not numeric), try by IP Address String
        if (!$ip_data && $ip_or_id) {
             $ip_data = $this->Ip_model->get_ip_by_address($ip_or_id);
        }

        // 3. If still not found, it means it's a "Free/Virtual" IP we want to activate/edit
        if (!$ip_data && $ip_or_id) {
             // Create a temporary object for the view
             $ip_data = [
                 'id' => null,
                 'network_id' => $this->input->get('network_id'), // Passed from link
                 'ip_address' => $ip_or_id,
                 'description' => '',
                 'type' => 'normal',
                 'status' => 'inactive'
             ];
        }

        if (!$ip_data) {
            show_404();
            return;
        }

        $data['title'] = 'Edit IP Address';
        $data['page'] = 'ip_management';
        $data['user'] = $this->_get_user_data();
        $data['ip'] = $ip_data;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/ip/ip_management/form_ip', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function ip_update()
    {
        // Admin & Management
        if (!in_array($this->session->userdata('role'), ['admin', 'management'])) {
            show_error('Unauthorized', 403);
        }

        $this->load->model('Ip_model');
        
        $data = [
            'network_id' => $this->input->post('network_id'),
            'ip_address' => $this->input->post('ip_address'),
            'description' => $this->input->post('description'),
            'type' => $this->input->post('type'),
            'status' => $this->input->post('status')
        ];

        // Basic Validation
        if (empty($data['network_id']) || empty($data['ip_address'])) {
             $this->session->set_flashdata('error', 'Data tidak lengkap (Network ID / IP missing).');
             redirect('admin/ip_management');
             return;
        }

        if ($this->Ip_model->save_ip($data)) {
            $this->Audit_model->log('update_ip', "Updated IP: {$data['ip_address']} ({$data['status']})");
            $this->session->set_flashdata('success', 'Data IP berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data IP.');
        }

        // Redirect logic
        $network = $this->Ip_model->get_network_by_id($data['network_id']);
        if ($network && isset($network['slug'])) {
            redirect('admin/ip_management/' . $network['slug']);
        } else {
             redirect('admin/ip_management');
        }
    }

    // =====================================================
    // Infrastructure - Network
    // =====================================================

    public function network_traffic_mrtg()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Traffic MRTG';
        $data['page'] = 'network_traffic_mrtg';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        // Note: Filesystem shows network files in 'security' folder
        $this->load->view('admin/security/network_traffic_mrtg', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function network_traffic_ap()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Traffic Access Point';
        $data['page'] = 'network_traffic_ap';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        // Note: Filesystem shows network files in 'security' folder
        $this->load->view('admin/infrastructure/security/network_traffic_ap', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    // =====================================================
    // Infrastructure - Data Center
    // =====================================================

    public function datacenter_resource_server()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Resource Server (JKT, MBC)';
        $data['page'] = 'datacenter_resource_server';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/infrastructure/data_center/datacenter_resource_server', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function datacenter_traffic_vm()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Traffic Virtual Machine';
        $data['page'] = 'datacenter_traffic_vm';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/infrastructure/data_center/datacenter_traffic_vm', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    // =====================================================
    // Infrastructure - Security
    // =====================================================

    public function security_waf_activity()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Aktivitas Serangan WAF';
        $data['page'] = 'security_waf_activity';
        
        // Load WAF Model
        $this->load->model('Waf_model');
        
        // Fetch Real-time Stats from Safeline WAF
        $waf_data = $this->Waf_model->get_daily_stats();
        $waf_events = $this->Waf_model->get_daily_events(30);
        
        $data['stats'] = $waf_data['summary'];
        $data['attack_stats'] = $waf_data['types'];
        $data['recent_logs'] = $waf_data['recent'];
        $data['recent_events'] = $waf_events;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/security/waf_activity', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function security_fortigate()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Fortigate';
        $data['page'] = 'security_fortigate';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        // Note: Filesystem shows security files in 'network' folder
        $this->load->view('admin/infrastructure/network/security_fortigate', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function security_safeline()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Safe Line';
        $data['page'] = 'security_safeline';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        // Note: Filesystem shows security files in 'network' folder
        $this->load->view('admin/infrastructure/network/security_safeline', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    // =====================================================
    // Infrastructure - Satellite
    // =====================================================

    public function satellite_starlink()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Starlink';
        $data['page'] = 'satellite_starlink';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/infrastructure/satelite/satellite_starlink', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function satellite_broadcast_audio()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Broadcast Audio';
        $data['page'] = 'satellite_broadcast_audio';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/infrastructure/satelite/satellite_broadcast_audio', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    /**
     * Audit Log
     */
    public function audit()
    {
        // Admin Only
        if ($this->session->userdata('role') !== 'admin') show_error('Unauthorized', 403);

        $data['title'] = 'Audit Log';
        $data['page'] = 'audit';
        $data['user'] = $this->_get_user_data();

        // Get logs
        // Limit 500, passing raw data so view can access joined fields (username, role, avatar)
        $data['logs'] = $this->Audit_model->get_all(500); 
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/audit', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    // =====================================================
    // ZABBIX TRAFFIC API ENDPOINT (MULTI-HOST MRTG)
    // =====================================================

    /**
     * Traffic Data API Endpoint - MULTI-HOST MRTG VERSION
     * 
     * Actions:
     * - get / mrtg : Ambil trend data semua 12 host
     * - clear-cache: Hapus cache
     * 
     * @param string $action Action to perform
     * @return JSON
     */
    public function traffic($action = 'mrtg')
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');

        $this->load->model('Zabbix_model');

        // Action: mrtg / get - Ambil semua trend data 12 host
        if ($action === 'mrtg' || $action === 'get') {
            $result = $this->Zabbix_model->get_mrtg_data();
            echo json_encode($result);
            return;
        }

        // Action: clear-cache
        if ($action === 'clear-cache') {
            $cleared = $this->Zabbix_model->clear_cache();
            echo json_encode(['success' => true, 'message' => "Cleared {$cleared} cache files"]);
            return;
        }

        echo json_encode([
            'success' => false,
            'error'   => 'Invalid action. Use: mrtg, clear-cache'
        ]);
    }
}
