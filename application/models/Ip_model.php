<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ip_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Networks
    public function get_networks() {
        $this->db->order_by('is_reserve', 'ASC');
        $this->db->order_by('id', 'ASC');
        return $this->db->get('networks')->result_array();
    }

    public function get_network_by_slug($slug) {
        return $this->db->get_where('networks', ['slug' => $slug])->row_array();
    }

    // IPs
    public function get_ips_by_network($network_id) {
        $this->db->where('network_id', $network_id);
        // Sort by INET_ATON to sort IPs correctly naturally
        // But since we store as string, complex sort is needed or just sort by ID if inserted in order
        // Let's rely on natural sort of the last octet if possible, or just ID
        $this->db->order_by('id', 'ASC'); 
        return $this->db->get('ip_addresses')->result_array();
    }

    public function get_all_grouped_by_network($search = null) {
        $networks = $this->get_networks();
        $result = [];

        foreach ($networks as $net) {
            $db_ips = $this->get_ips_by_network($net['id']);
            
            // Index DB IPs by address for easy lookup
            $keyed_ips = [];
            foreach ($db_ips as $db_ip) {
                $keyed_ips[$db_ip['ip_address']] = $db_ip;
            }

            // Generate Full Range
            $start_parts = explode('.', $net['range_start']);
            $end_parts = explode('.', $net['range_end']);
            $prefix = $start_parts[0] . '.' . $start_parts[1] . '.' . $start_parts[2];
            $start_idx = (int)end($start_parts);
            $end_idx = (int)end($end_parts);

            // Safety cap
            if ($end_idx < $start_idx) $end_idx = $start_idx;
            if ($end_idx - $start_idx > 255) $end_idx = $start_idx + 255;

            $formatted_ips = [];
            $counter = 1;

            for ($i = $start_idx; $i <= $end_idx; $i++) {
                $current_ip = "$prefix.$i";
                $item = null;
                
                if (isset($keyed_ips[$current_ip])) {
                    // Exists in DB
                    $ip_data = $keyed_ips[$current_ip];
                    $item = [
                        'no' => $counter,
                        'id' => $ip_data['id'],
                        'network_id' => $net['id'],
                        'ip_address' => $ip_data['ip_address'],
                        'description' => $ip_data['description'],
                        'type' => $ip_data['type'],
                        'status' => $ip_data['status'],
                        'is_reserve' => $net['is_reserve'] 
                    ];
                } else {
                    // Does not exist in DB -> Free / Inactive
                    $item = [
                        'no' => $counter,
                        'id' => null,
                        'network_id' => $net['id'],
                        'ip_address' => $current_ip,
                        'description' => '',
                        'type' => 'normal',
                        'status' => 'inactive',
                        'is_reserve' => $net['is_reserve']
                    ];
                }

                // Filter Logic
                if ($search) {
                    $search = strtolower($search);
                    $in_ip = strpos($item['ip_address'], $search) !== false;
                    $in_desc = strpos(strtolower($item['description']), $search) !== false;
                    
                    if (!$in_ip && !$in_desc) {
                        continue; // Skip this item
                    }
                }

                $formatted_ips[] = $item;
                $counter++; // Only increment counter if item is added? Or keep natural order?
                // Visual preference: If searching, usually we want to see found items listed 1..N.
                // If we want to keep original "No" relative to subnet, we should increment counter outside IF.
                // But list.php uses 'no' as index. Let's keep it simply incrementing for the view table.
            }

            $result[$net['slug']] = [
                'id' => $net['id'],
                'name' => $net['name'],
                'cidr' => $net['cidr'],
                'range_start' => $net['range_start'],
                'range_end' => $net['range_end'],
                'ips' => $formatted_ips,
                'total_ips' => count($formatted_ips) 
            ];
        }

        return $result;
    }

    public function get_global_stats() {
        $total_networks = $this->db->count_all('networks');
        
        // Count ONLY Public IPs (exclude gateway, broadcast if we want purely 'Public IP' count)
        $this->db->from('ip_addresses');
        $this->db->where('type', 'public'); 
        $total_ips = $this->db->count_all_results();

        $this->db->from('ip_addresses');
        $this->db->where('type', 'public');
        $this->db->where('status', 'active');
        $used_ips = $this->db->count_all_results();

        return [
            'total_networks' => $total_networks,
            'total_ips' => $total_ips,
            'used_ips' => $used_ips,
            'free_ips' => $total_ips - $used_ips,
            'usage_percent' => ($total_ips > 0) ? round(($used_ips / $total_ips) * 100) : 0
        ];
    }

    // =========================================================================
    // CRUD Operations - Network
    // =========================================================================

    public function get_network_by_id($id) {
        return $this->db->get_where('networks', ['id' => $id])->row_array();
    }

    public function create_network($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('networks', $data);
    }

    public function update_network($id, $data) {
        $this->db->where('id', $id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('networks', $data);
    }

    public function delete_network($id) {
        // Optional: Delete related IPs or set them to null? 
        // For now, let's just delete the network entry. Database constraint might restrict this if FK exists.
        $this->db->where('id', $id);
        return $this->db->delete('networks');
    }

    // =========================================================================
    // CRUD Operations - IP Addresses
    // =========================================================================

    public function get_ip_by_id($id) {
        return $this->db->get_where('ip_addresses', ['id' => $id])->row_array();
    }

    public function get_ip_by_address($address) {
        return $this->db->get_where('ip_addresses', ['ip_address' => $address])->row_array();
    }

    public function save_ip($data) {
        $ip_address = $data['ip_address'];
        
        // Cek exist by IP address
        $existing = $this->db->get_where('ip_addresses', ['ip_address' => $ip_address])->row_array();
        
        if ($existing) {
            $this->db->where('id', $existing['id']);
            // $data['updated_at'] = date('Y-m-d H:i:s'); // Column likely doesn't exist
            return $this->db->update('ip_addresses', $data);
        } else {
            // $data['created_at'] = date('Y-m-d H:i:s'); // Column likely doesn't exist
            // Ensure network_id is valid or handled if null?
            return $this->db->insert('ip_addresses', $data);
        }
    }
    // =========================================================================
    // VPN Management
    // =========================================================================

    public function get_all_vpns() {
        if (!$this->db->table_exists('vpn_ips')) {
            return [];
        }
        return $this->db->get('vpn_ips')->result_array();
    }

    public function get_vpn_by_id($id) {
        return $this->db->get_where('vpn_ips', ['id' => $id])->row_array();
    }

    public function get_vpn_stats() {
        if (!$this->db->table_exists('vpn_ips')) {
            return ['total' => 0, 'online' => 0, 'offline' => 0];
        }

        $total = $this->db->count_all('vpn_ips');
        $this->db->where('status', 'online');
        $online = $this->db->count_all_results('vpn_ips');

        return [
            'total' => $total,
            'online' => $online,
            'offline' => $total - $online
        ];
    }
    
    public function create_vpn($data) {
        return $this->db->insert('vpn_ips', $data);
    }

    public function update_vpn($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('vpn_ips', $data);
    }

    public function delete_vpn($id) {
        $this->db->where('id', $id);
        return $this->db->delete('vpn_ips');
    }

    // New method for bulk import
    public function truncate_vpn() {
        if ($this->db->table_exists('vpn_ips')) {
            $this->db->truncate('vpn_ips');
        }
    }
}
