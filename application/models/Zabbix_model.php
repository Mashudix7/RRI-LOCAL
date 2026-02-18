<?php
/**
 * =====================================================
 * Zabbix Model - MULTI-HOST MRTG VERSION
 * =====================================================
 * 
 * Model untuk mengakses Zabbix API.
 * Mendukung 12 host dengan IN/OUT item IDs.
 * 
 * Flow:
 * 1. item.get -> get item details (name, key_, units, hosts)
 * 2. trend.get -> get trend data (value_avg, value_max) per hari
 * 
 * @package     CSIRT RRI
 * @subpackage  Models
 * @category    API Integration
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Zabbix_model extends CI_Model {

    private $api_url;
    private $auth_token;
    private $timeout;
    private $cache_ttl;
    private $cache_dir;

    /**
     * Host definitions: label => [in_itemid, out_itemid]
     * Urutan sesuai raw JSON user
     */
    private $hosts = [
        [
            'label' => 'ASTINET',
            'in'    => '66918',
            'out'   => '66942'
        ],
        [
            'label' => 'FIBERNET GEDUNG MBC PUSBANGKOM 300Mbps',
            'in'    => '373160',
            'out'   => '373193'
        ],
        [
            'label' => 'FIBERNET',
            'in'    => '407210',
            'out'   => '407255'
        ],
        [
            'label' => 'FIBERNET BINA PROFESI',
            'in'    => '374148',
            'out'   => '374166'
        ],
        [
            'label' => 'ASTINET TUNNEL',
            'in'    => '374437',
            'out'   => '374458'
        ],
        [
            'label' => 'FIBERNET PUSBANGKOM',
            'in'    => '406908',
            'out'   => '406956'
        ],
        [
            'label' => 'FIBERNET DC DPOK',
            'in'    => '413803',
            'out'   => '413821'
        ],
        [
            'label' => 'FIBERNET SPI',
            'in'    => '423530',
            'out'   => '423587'
        ],
        [
            'label' => 'INTERNET DC JKT (Fibernet)',
            'in'    => '41470',
            'out'   => '41536'
        ],
        [
            'label' => 'FIBERNET PEMANCAR KEBAYORAN',
            'in'    => '407499',
            'out'   => '407604'
        ],
        [
            'label' => 'INTERNET RRI KANTOR PUSAT (Fibernet)',
            'in'    => '370159',
            'out'   => '370237'
        ],
        [
            'label' => 'FIBERNET DC PDN',
            'in'    => '369924',
            'out'   => '370002'
        ]
    ];

    public function __construct()
    {
        parent::__construct();

        $this->api_url    = getenv('ZABBIX_API_URL') ?: 'http://10.30.1.15/zabbix/api_jsonrpc.php';
        $this->auth_token = getenv('ZABBIX_API_AUTH_TOKEN') ?: '';
        $this->timeout    = (int)(getenv('ZABBIX_API_TIMEOUT') ?: 15);
        $this->cache_ttl  = (int)(getenv('ZABBIX_API_CACHE_TTL') ?: 300);
        $this->cache_dir  = APPPATH . 'cache/';

        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0777, true);
        }
    }

    /**
     * Get semua item IDs (flat array) dari hosts config
     */
    private function _get_all_itemids()
    {
        $ids = [];
        foreach ($this->hosts as $h) {
            $ids[] = $h['in'];
            $ids[] = $h['out'];
        }
        return $ids;
    }

    /**
     * Get host definitions (untuk frontend)
     */
    public function get_host_definitions()
    {
        return $this->hosts;
    }

    /**
     * =====================================================
     * STEP 1: item.get - Ambil detail item (name, key_, units, host)
     * =====================================================
     */
    public function get_item_details()
    {
        $cache_key = 'zabbix_mrtg_items';
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $payload = [
            'jsonrpc' => '2.0',
            'method'  => 'item.get',
            'params'  => [
                'itemids'     => $this->_get_all_itemids(),
                'output'      => ['itemid', 'name', 'key_', 'units'],
                'selectHosts' => ['host']
            ],
            'auth' => $this->auth_token,
            'id'   => 1
        ];

        $response = $this->_call_api($payload);

        if (isset($response['result'])) {
            // Index by itemid for fast lookup
            $indexed = [];
            foreach ($response['result'] as $item) {
                $indexed[$item['itemid']] = $item;
            }
            $this->_save_cache($cache_key, $indexed, $this->cache_ttl);
            return $indexed;
        }

        return [];
    }

    /**
     * =====================================================
     * STEP 2: trend.get - Ambil trend data hari ini
     * =====================================================
     */
    public function get_trend_data($time_from = null, $time_till = null)
    {
        // Default: hari ini (UTC+7)
        if (!$time_from) {
            // Start of today WIB (UTC+7)
            $now = time();
            $wib_offset = 7 * 3600;
            $today_start_utc = strtotime(date('Y-m-d', $now + $wib_offset) . ' 00:00:00') - $wib_offset;
            $time_from = $today_start_utc;
            $time_till = $today_start_utc + 86399;
        }

        $cache_key = 'zabbix_mrtg_trend_' . $time_from;
        $cached = $this->_get_cache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $payload = [
            'jsonrpc' => '2.0',
            'method'  => 'trend.get',
            'params'  => [
                'itemids'   => $this->_get_all_itemids(),
                'time_from' => $time_from,
                'time_till' => $time_till,
                'output'    => ['itemid', 'clock', 'value_avg', 'value_max'],
                'sortfield' => 'clock',
                'sortorder' => 'ASC'
            ],
            'auth' => $this->auth_token,
            'id'   => 2
        ];

        $response = $this->_call_api($payload);

        if (isset($response['result'])) {
            // Group by itemid
            $grouped = [];
            foreach ($response['result'] as $row) {
                $grouped[$row['itemid']][] = [
                    'clock'     => (int) $row['clock'],
                    'value_avg' => (float) $row['value_avg'],
                    'value_max' => (float) $row['value_max']
                ];
            }
            // Cache 60 seconds for live-ish data
            $this->_save_cache($cache_key, $grouped, 60);
            return $grouped;
        }

        return [];
    }

    /**
     * =====================================================
     * MAIN: Get all MRTG data (combined) for frontend
     * =====================================================
     * Returns structured array per host with labels, item details, and trend data
     */
    public function get_mrtg_data($time_from = null, $time_till = null)
    {
        $items  = $this->get_item_details();
        $trends = $this->get_trend_data($time_from, $time_till);

        $result = [];

        foreach ($this->hosts as $host) {
            $in_id  = $host['in'];
            $out_id = $host['out'];

            // Item details
            $in_item  = isset($items[$in_id]) ? $items[$in_id] : null;
            $out_item = isset($items[$out_id]) ? $items[$out_id] : null;

            // Trend data
            $in_trend  = isset($trends[$in_id]) ? $trends[$in_id] : [];
            $out_trend = isset($trends[$out_id]) ? $trends[$out_id] : [];

            // Calculate stats from trend
            $in_stats  = $this->_calc_stats($in_trend);
            $out_stats = $this->_calc_stats($out_trend);

            $result[] = [
                'label'    => $host['label'],
                'in_id'    => $in_id,
                'out_id'   => $out_id,
                'in_name'  => $in_item ? $in_item['name'] : 'Unknown',
                'out_name' => $out_item ? $out_item['name'] : 'Unknown',
                'in_host'  => ($in_item && !empty($in_item['hosts'])) ? $in_item['hosts'][0]['host'] : 'Unknown',
                'in_data'  => $in_trend,
                'out_data' => $out_trend,
                'in_stats' => $in_stats,
                'out_stats'=> $out_stats
            ];
        }

        return [
            'success' => true,
            'hosts'   => $result,
            'fetched' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Calculate min/avg/max/last stats from trend array
     */
    private function _calc_stats($trend_data)
    {
        if (empty($trend_data)) {
            return ['last' => 0, 'min' => 0, 'avg' => 0, 'max' => 0];
        }

        $avgs = array_column($trend_data, 'value_avg');
        $maxs = array_column($trend_data, 'value_max');

        return [
            'last' => end($avgs),
            'min'  => min($avgs),
            'avg'  => array_sum($avgs) / count($avgs),
            'max'  => max($maxs)
        ];
    }

    /**
     * Call Zabbix API via CURL
     */
    private function _call_api($payload)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
        ]);

        $response   = curl_exec($ch);
        $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
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
     * Get Cache
     */
    private function _get_cache($key)
    {
        $cache_file = $this->cache_dir . $key . '.json';

        if (file_exists($cache_file)) {
            $age = time() - filemtime($cache_file);
            $ttl = (strpos($key, 'trend') !== false) ? 60 : $this->cache_ttl;

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
