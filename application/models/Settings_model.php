<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->_initialize_table();
        $this->seed_defaults();
    }

    /**
     * Create table if not exists (Auto-Migration)
     */
    private function _initialize_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) NOT NULL UNIQUE,
            setting_value TEXT,
            setting_group VARCHAR(50) DEFAULT 'general',
            input_type VARCHAR(50) DEFAULT 'text',
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $this->db->query($sql);
    }

    /**
     * Get all settings grouped by their category
     */
    public function get_all_grouped()
    {
        $settings = $this->db->get('settings')->result_array();
        $grouped = [];
        
        foreach ($settings as $s) {
            $grouped[$s['setting_group']][] = $s;
        }
        
        return $grouped;
    }

    /**
     * Get a single setting value by key
     */
    public function get_value($key, $default = null)
    {
        $query = $this->db->where('setting_key', $key)->get('settings');
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        return $default;
    }

    /**
     * Update a setting
     */
    public function update($key, $value)
    {
        $this->db->where('setting_key', $key);
        return $this->db->update('settings', ['setting_value' => $value]);
    }

    /**
     * Seed default settings if table is empty
     */
    /**
     * Seed default settings if they don't exist
     */
    private function seed_defaults()
    {
        $defaults = [
            // General
            ['setting_key' => 'site_title', 'setting_value' => 'CSIRT RRI', 'setting_group' => 'general', 'input_type' => 'text'],
            ['setting_key' => 'site_description', 'setting_value' => 'Computer Security Incident Response Team LPP RRI', 'setting_group' => 'general', 'input_type' => 'textarea'],
            ['setting_key' => 'contact_email', 'setting_value' => 'csirt@rri.go.id', 'setting_group' => 'general', 'input_type' => 'email'],
            ['setting_key' => 'contact_phone', 'setting_value' => '+62 21 12345678', 'setting_group' => 'general', 'input_type' => 'text'],
            ['setting_key' => 'footer_text', 'setting_value' => '&copy; 2026 RRI CSIRT. All rights reserved.', 'setting_group' => 'general', 'input_type' => 'text'],
            
            // Security
            ['setting_key' => 'max_login_attempts', 'setting_value' => '5', 'setting_group' => 'security', 'input_type' => 'number'],
            ['setting_key' => 'maintenance_mode', 'setting_value' => '0', 'setting_group' => 'security', 'input_type' => 'toggle'],

            // Social Media
            ['setting_key' => 'social_facebook', 'setting_value' => '#', 'setting_group' => 'social', 'input_type' => 'text'],
            ['setting_key' => 'social_twitter', 'setting_value' => '#', 'setting_group' => 'social', 'input_type' => 'text'],
            ['setting_key' => 'social_instagram', 'setting_value' => '#', 'setting_group' => 'social', 'input_type' => 'text'],
        ];

        foreach ($defaults as $setting) {
            $exists = $this->db->where('setting_key', $setting['setting_key'])->count_all_results('settings');
            if ($exists == 0) {
                $this->db->insert('settings', $setting);
            }
        }
    }
}
