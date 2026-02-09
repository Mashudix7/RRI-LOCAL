<?php
/**
 * =====================================================
 * Zabbix Model - SCALABLE VERSION
 * =====================================================
 * 
 * Model untuk mengakses Zabbix API secara dinamis.
 * TIDAK menggunakan hardcoded item IDs!
 * 
 * Flow:
 * 1. Search host by name -> get hostid
 * 2. Search items by interface name -> get itemids
 * 3. Filter for "Bits received" (RX) and "Bits sent" (TX)
 * 4. Fetch history for those items
 * 
 * @package     CSIRT RRI
 * @subpackage  Models
 * @category    API Integration
 * @author      Tim Teknologi Media Baru
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Zabbix_model extends CI_Model {

    // API Configuration (from .env)
    private $api_url;
    private $auth_token;
    private $timeout;
    private $cache_ttl;
    private $cache_dir;

    // Default config (can be overridden by .env)
    private $default_host_name = 'Mikrotik Core Fibernet';
    private $default_interface_name = 'sfp-sfpplus1-fibernet';

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

        // Optional: Override default host/interface from .env
        if (getenv('ZABBIX_DEFAULT_HOST')) {
            $this->default_host_name = getenv('ZABBIX_DEFAULT_HOST');
        }
        if (getenv('ZABBIX_DEFAULT_INTERFACE')) {
            $this->default_interface_name = getenv('ZABBIX_DEFAULT_INTERFACE');
        }

        // Ensure cache directory exists
        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0777, true);
        }
    }

    /**
     * =====================================================
     * MAIN METHOD: GET TRAFFIC DATA (FULLY DYNAMIC)
     * =====================================================
     * 
     * Mengambil data traffic RX/TX dengan pencarian dinamis:
     * 1. Cari host berdasarkan nama
     * 2. Cari items berdasarkan nama interface
     * 3. Filter untuk Bits received/sent
     * 4. Ambil history
     * 
     * @param string $host_name Nama host (default dari config)
     * @param string $interface_name Nama interface (default dari config)
     * @param int $limit Jumlah data yang diambil
     * @param int $hours_back Berapa jam ke belakang
     * @return array
     */
    public function get_traffic_data($host_name = null, $interface_name = null, $limit = 500, $hours_back = 12)
    {
        $host_name = $host_name ?: $this->default_host_name;
        $interface_name = $interface_name ?: $this->default_interface_name;

        // Step 1: Find host by name
        $host = $this->find_host_by_name($host_name);
        
        if (empty($host)) {
            return [
                'success' => false,
                'error' => "Host not found: {$host_name}",
                'rx' => [],
                'tx' => []
            ];
        }

        $hostid = $host['hostid'];

        // Step 2: Find RX/TX item IDs for the interface
        $items = $this->find_interface_traffic_items($hostid, $interface_name);
        
        if (empty($items['rx_itemid']) || empty($items['tx_itemid'])) {
            return [
                'success' => false,
                'error' => "RX/TX items not found for interface: {$interface_name}",
                'rx' => [],
                'tx' => [],
                'debug' => $items
            ];
        }

        // Step 3: Check cache for traffic data
        $cache_key = "zabbix_traffic_{$items['rx_itemid']}_{$items['tx_itemid']}_{$limit}";
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        // Step 4: Fetch history data
        $rx_data = $this->_get_history($items['rx_itemid'], $limit, $hours_back);
        $tx_data = $this->_get_history($items['tx_itemid'], $limit, $hours_back);

        if (isset($rx_data['error']) || isset($tx_data['error'])) {
            $error = isset($rx_data['error']) ? $rx_data['error'] : $tx_data['error'];
            return [
                'success' => false,
                'error' => $error,
                'rx' => [],
                'tx' => []
            ];
        }

        $result = [
            'success' => true,
            'host' => $host['name'],
            'interface' => $interface_name,
            'rx' => $this->_parse_history($rx_data),
            'tx' => $this->_parse_history($tx_data),
            'meta' => [
                'hostid' => $hostid,
                'rx_itemid' => $items['rx_itemid'],
                'tx_itemid' => $items['tx_itemid']
            ]
        ];

        // Cache for 60 seconds (live update)
        $this->_save_cache($cache_key, $result, 60);

        return $result;
    }

    /**
     * Find Host by Name (Dynamic)
     * 
     * @param string $name Host name to search (supports partial match)
     * @return array|null Host data or null
     */
    public function find_host_by_name($name)
    {
        $cache_key = "zabbix_host_" . md5($name);
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'host.get',
            'params' => [
                'search' => [
                    'name' => $name
                ],
                'searchWildcardsEnabled' => true,
                'searchByAny' => true,
                'output' => ['hostid', 'host', 'name', 'status']
            ],
            'auth' => $this->auth_token,
            'id' => 1
        ];

        $response = $this->_call_api($payload);
        
        if (isset($response['result']) && !empty($response['result'])) {
            $host = $response['result'][0];
            $this->_save_cache($cache_key, $host, $this->cache_ttl);
            return $host;
        }

        // Log tidak ditemukan untuk debugging
        log_message('error', 'Zabbix: Host not found with name: ' . $name);
        
        return null;
    }

    /**
     * Find Interface Traffic Items (RX/TX)
     * 
     * @param string $hostid Host ID
     * @param string $interface_name Interface name to search
     * @return array ['rx_itemid' => string, 'tx_itemid' => string]
     */
    public function find_interface_traffic_items($hostid, $interface_name)
    {
        $cache_key = "zabbix_items_{$hostid}_" . md5($interface_name);
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        // Search for items containing interface name
        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'hostids' => $hostid,
                'search' => [
                    'name' => $interface_name
                ],
                'output' => ['itemid', 'name', 'key_', 'lastvalue', 'units']
            ],
            'auth' => $this->auth_token,
            'id' => 2
        ];

        $response = $this->_call_api($payload);
        
        $rx_itemid = null;
        $tx_itemid = null;
        $all_items = [];

        if (isset($response['result']) && is_array($response['result'])) {
            $all_items = $response['result'];
            
            foreach ($response['result'] as $item) {
                $name = strtolower($item['name']);
                
                // Find "Bits received" for RX
                if (strpos($name, 'bits received') !== false) {
                    $rx_itemid = $item['itemid'];
                }
                
                // Find "Bits sent" for TX
                if (strpos($name, 'bits sent') !== false) {
                    $tx_itemid = $item['itemid'];
                }
            }
        }

        $result = [
            'rx_itemid' => $rx_itemid,
            'tx_itemid' => $tx_itemid,
            'items_found' => count($all_items)
        ];

        // Cache for 5 minutes (item IDs don't change often)
        $this->_save_cache($cache_key, $result, 300);

        return $result;
    }

    /**
     * Get All Hosts (for dropdown/selection)
     * 
     * @return array List of hosts
     */
    public function get_hosts()
    {
        $cache_key = 'zabbix_all_hosts';
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
     * Get Host Interfaces (for dropdown/selection)
     * 
     * @param string $hostid Host ID
     * @return array List of interfaces with traffic metrics
     */
    public function get_host_interfaces($hostid)
    {
        $cache_key = "zabbix_interfaces_{$hostid}";
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        // Get all network interface items
        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'hostids' => $hostid,
                'search' => [
                    'key_' => 'net.if'
                ],
                'output' => ['itemid', 'name', 'key_', 'units']
            ],
            'auth' => $this->auth_token,
            'id' => 2
        ];

        $response = $this->_call_api($payload);
        
        // Parse unique interface names
        $interfaces = [];
        if (isset($response['result']) && is_array($response['result'])) {
            foreach ($response['result'] as $item) {
                // Extract interface name from "Interface XXX: Metric"
                if (preg_match('/^Interface ([^:]+):/i', $item['name'], $matches)) {
                    $iface_name = trim($matches[1]);
                    if (!isset($interfaces[$iface_name])) {
                        $interfaces[$iface_name] = [
                            'name' => $iface_name,
                            'item_count' => 0
                        ];
                    }
                    $interfaces[$iface_name]['item_count']++;
                }
            }
        }

        $result = array_values($interfaces);
        $this->_save_cache($cache_key, $result, $this->cache_ttl);

        return $result;
    }

    /**
     * Get History Data
     * 
     * @param string $itemid Item ID
     * @param int $limit Limit
     * @param int $hours_back Hours back
     * @return array
     */
    private function _get_history($itemid, $limit = 500, $hours_back = 12)
    {
        $time_from = time() - ($hours_back * 3600);
        
        $payload = [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'itemids' => $itemid,
                'history' => 3, // Unsigned integer (for bps data)
                'time_from' => $time_from,
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
     * Call Zabbix API
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
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
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
            return ['error' => 'JSON Parse Error'];
        }

        if (isset($decoded['error'])) {
            log_message('error', 'Zabbix API Error: ' . json_encode($decoded['error']));
            return ['error' => $decoded['error']['data'] ?? $decoded['error']['message'] ?? 'Unknown API Error'];
        }

        return $decoded;
    }

    /**
     * Parse History Response
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
     */
    private function _get_cache($key)
    {
        $cache_file = $this->cache_dir . $key . '.json';
        
        if (file_exists($cache_file)) {
            $age = time() - filemtime($cache_file);
            $ttl = (strpos($key, 'traffic') !== false) ? 60 : $this->cache_ttl;
            
            if ($age < $ttl) {
                return json_decode(file_get_contents($cache_file), true);
            }
        }

        return false;
    }

    /**
     * Save Cache
     */
    private function _save_cache($key, $data, $ttl = null)
    {
        $cache_file = $this->cache_dir . $key . '.json';
        file_put_contents($cache_file, json_encode($data));
    }

    /**
     * Clear All Zabbix Cache
     */
    public function clear_cache()
    {
        $files = glob($this->cache_dir . 'zabbix_*.json');
        foreach ($files as $file) {
            @unlink($file);
        }
        return count($files);
    }
}
