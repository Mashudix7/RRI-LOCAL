<?php
/**
 * =====================================================
 * Zabbix Model
 * =====================================================
 * 
 * Model untuk mengakses Zabbix API secara langsung
 * Mengambil data RX/TX untuk monitoring traffic jaringan.
 * 
 * @package     CSIRT RRI
 * @subpackage  Models
 * @category    API Integration
 * @author      Tim Teknologi Media Baru
 * 
 * Komentar Kritikal:
 * - LANGSUNG akses RX/TX via history.get (best practice)
 * - Credentials dari .env file
 * - Support caching untuk mengurangi load API
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Zabbix_model extends CI_Model {

    // API Configuration
    private $api_url;
    private $auth_token;
    private $timeout;
    private $cache_ttl;
    private $cache_dir;

    // Default Item IDs untuk SFP Fibernet
    // RX: 423546, TX: 423603
    private $default_rx_itemid = '423546';
    private $default_tx_itemid = '423603';

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', ['adapter' => 'file']);
        
        // Load config dari environment
        $this->api_url = getenv('ZABBIX_API_URL') ?: 'http://10.30.1.15/zabbix/api_jsonrpc.php';
        $this->auth_token = getenv('ZABBIX_API_AUTH_TOKEN') ?: '';
        $this->timeout = (int)(getenv('ZABBIX_API_TIMEOUT') ?: 15);
        $this->cache_ttl = (int)(getenv('ZABBIX_API_CACHE_TTL') ?: 300);
        $this->cache_dir = APPPATH . 'cache/';

        // Ensure cache directory exists
        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0777, true);
        }
    }

    /**
     * =====================================================
     * GET RX/TX DATA - BEST PRACTICE (LANGSUNG)
     * =====================================================
     * Langsung ambil data history RX dan TX tanpa lookup host/item dulu.
     * Ini lebih efisien dan cepat.
     * 
     * @param string $rx_itemid Item ID untuk RX (incoming traffic)
     * @param string $tx_itemid Item ID untuk TX (outgoing traffic)
     * @param int $limit Jumlah data history yang diambil
     * @return array ['success' => bool, 'rx' => array, 'tx' => array]
     */
    public function get_traffic_data($rx_itemid = null, $tx_itemid = null, $limit = 300)
    {
        $rx_itemid = $rx_itemid ?: $this->default_rx_itemid;
        $tx_itemid = $tx_itemid ?: $this->default_tx_itemid;

        // Cek cache dulu
        $cache_key = "zabbix_traffic_{$rx_itemid}_{$tx_itemid}_{$limit}";
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        // Fetch RX data
        $rx_data = $this->_get_history($rx_itemid, $limit);
        
        // Fetch TX data
        $tx_data = $this->_get_history($tx_itemid, $limit);

        if (isset($rx_data['error']) || isset($tx_data['error'])) {
            $error_msg = isset($rx_data['error']) ? $rx_data['error'] : $tx_data['error'];
            log_message('error', 'Zabbix API Error: ' . json_encode($error_msg));
            return [
                'success' => false,
                'error' => $error_msg,
                'rx' => [],
                'tx' => []
            ];
        }

        // Parse dan format data
        $result = [
            'success' => true,
            'rx' => $this->_parse_history($rx_data),
            'tx' => $this->_parse_history($tx_data)
        ];

        // Simpan ke cache
        $this->_save_cache($cache_key, $result, 60); // 60 detik cache untuk live update

        return $result;
    }

    /**
     * Get History Data dari Zabbix
     * 
     * @param string $itemid Item ID untuk mengambil history
     * @param int $limit Jumlah record yang diambil
     * @return array Response dari API
     */
    private function _get_history($itemid, $limit = 300)
    {
        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'itemids' => $itemid,
                'history' => 3, // Unsigned integer (untuk traffic data)
                'sortfield' => 'clock',
                'sortorder' => 'ASC',
                'limit' => $limit
            ],
            'auth' => $this->auth_token,
            'id' => mt_rand(1, 9999)
        ];

        return $this->_call_api($payload);
    }

    /**
     * Get Hosts dari Zabbix (Optional - untuk browsing hosts)
     * 
     * @return array List of hosts
     */
    public function get_hosts()
    {
        $cache_key = 'zabbix_hosts';
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'host.get',
            'params' => [
                'output' => ['hostid', 'host', 'name', 'status']
            ],
            'auth' => $this->auth_token,
            'id' => 1
        ];

        $response = $this->_call_api($payload);
        
        if (isset($response['result'])) {
            $this->_save_cache($cache_key, $response['result'], $this->cache_ttl);
            return $response['result'];
        }

        return [];
    }

    /**
     * Get Items by Host ID (untuk mencari item yang tersedia)
     * 
     * @param string $hostid Host ID
     * @param string $search_key Keyword untuk filter item
     * @return array List of items
     */
    public function get_items($hostid, $search_key = 'net.if')
    {
        $cache_key = "zabbix_items_{$hostid}_{$search_key}";
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'hostids' => $hostid,
                'search' => [
                    'key_' => $search_key
                ],
                'output' => ['itemid', 'name', 'key_', 'lastvalue', 'units']
            ],
            'auth' => $this->auth_token,
            'id' => 2
        ];

        $response = $this->_call_api($payload);
        
        if (isset($response['result'])) {
            $this->_save_cache($cache_key, $response['result'], $this->cache_ttl);
            return $response['result'];
        }

        return [];
    }

    /**
     * Get SFP Items by Name (untuk mencari SFP-SFPPLUS1 items)
     * 
     * @param string $hostid Host ID
     * @param string $sfp_name Nama SFP (contoh: sfp-sfpplus1-fibernet)
     * @return array List of items matching the SFP name
     */
    public function get_sfp_items($hostid, $sfp_name = 'sfp-sfpplus1-fibernet')
    {
        $cache_key = "zabbix_sfp_{$hostid}_{$sfp_name}";
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'hostids' => $hostid,
                'search' => [
                    'name' => $sfp_name
                ],
                'output' => ['itemid', 'name', 'key_', 'lastvalue', 'units']
            ],
            'auth' => $this->auth_token,
            'id' => 1
        ];

        $response = $this->_call_api($payload);
        
        if (isset($response['result'])) {
            $this->_save_cache($cache_key, $response['result'], $this->cache_ttl);
            return $response['result'];
        }

        return [];
    }

    /**
     * Call Zabbix API
     * 
     * @param array $payload JSON-RPC payload
     * @return array API response
     */
    private function _call_api($payload)
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            log_message('error', 'Zabbix CURL Error: ' . $curl_error);
            return ['error' => 'CURL Error: ' . $curl_error];
        }

        if ($httpcode !== 200) {
            log_message('error', 'Zabbix HTTP Error: ' . $httpcode);
            return ['error' => 'HTTP Error: ' . $httpcode];
        }

        $decoded = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Zabbix JSON Parse Error: ' . json_last_error_msg());
            return ['error' => 'JSON Parse Error'];
        }

        // Cek Zabbix API error
        if (isset($decoded['error'])) {
            log_message('error', 'Zabbix API Error: ' . json_encode($decoded['error']));
            return ['error' => $decoded['error']['data'] ?? $decoded['error']['message'] ?? 'Unknown API Error'];
        }

        return $decoded;
    }

    /**
     * Parse History Response
     * 
     * @param array $response API response
     * @return array Parsed history data
     */
    private function _parse_history($response)
    {
        if (!isset($response['result']) || !is_array($response['result'])) {
            return [];
        }

        $parsed = [];
        foreach ($response['result'] as $record) {
            $parsed[] = [
                'clock' => (int) $record['clock'],
                'value' => (float) $record['value']
            ];
        }

        return $parsed;
    }

    /**
     * Get Cache
     * 
     * @param string $key Cache key
     * @return mixed Cached data or false
     */
    private function _get_cache($key)
    {
        $cache_file = $this->cache_dir . $key . '.json';
        
        if (file_exists($cache_file)) {
            $age = time() - filemtime($cache_file);
            $ttl = (strpos($key, 'traffic') !== false) ? 60 : $this->cache_ttl;
            
            if ($age < $ttl) {
                $data = file_get_contents($cache_file);
                return json_decode($data, true);
            }
        }

        return false;
    }

    /**
     * Save Cache
     * 
     * @param string $key Cache key
     * @param mixed $data Data to cache
     * @param int $ttl Time to live in seconds
     */
    private function _save_cache($key, $data, $ttl = null)
    {
        $cache_file = $this->cache_dir . $key . '.json';
        file_put_contents($cache_file, json_encode($data));
    }

    /**
     * Clear Cache
     * 
     * @param string $pattern Pattern to match cache files
     */
    public function clear_cache($pattern = 'zabbix_*')
    {
        $files = glob($this->cache_dir . $pattern . '.json');
        foreach ($files as $file) {
            @unlink($file);
        }
    }
}
