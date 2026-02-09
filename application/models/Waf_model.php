<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Waf_model extends CI_Model {

    // API Configuration
    private $api_url = '';
    private $api_token = '';
    private $cache_file = APPPATH . 'cache/waf_stats_v3.json';
    private $events_cache_file = APPPATH . 'cache/waf_events_v3.json';
    private $geoip_cache_file = APPPATH . 'cache/geoip_cache.json';
    private $cache_duration = 180; // 3 minutes for summary/stats
    private $events_cache_duration = 60; // 1 minute for events
    private $geoip_data = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->driver('cache', array('adapter' => 'file'));
        $this->load->model('Settings_model');
        
        // Get config from database
        $this->api_url = $this->Settings_model->get_value('waf_api_url', 'https://trial-waf.rri.go.id/api/commercial/record/export');
        $this->api_token = $this->Settings_model->get_value('waf_api_token', '');
        // Ensure cache directory exists
        if (!is_dir(dirname($this->cache_file))) {
            @mkdir(dirname($this->cache_file), 0777, true);
        }
    }

    /**
     * Get Daily Stats
     * Fetches attack data from today 00:00 to now.
     */
    public function get_daily_stats()
    {
        // 1. Check Cache
        $cached = $this->_get_cache();
        if ($cached) {
            return $cached;
        }

        // 2. Load Safeline Library
        $this->load->library('safeline_api');
        
        // 3. Get Records (Remove filter temporarily to verify connection)
        $result = $this->safeline_api->request('open/records?limit=100');

        if (isset($result['error'])) {
            log_message('error', 'Safeline API Error in Waf_model: ' . $result['error']);
            return $this->_get_fallback_stats();
        }

        // 4. Parse Response
        $stats = $this->_parse_safeline_response($result);
        
        // 4b. Optional: Get event count for more accurate totals if needed
        // For now, we rely on records total, but we check if result has it
        if (isset($result['data']['total'])) {
            $stats['summary']['total_events'] = $result['data']['total'];
        }

        // 5. Save Cache
        $this->_save_cache($stats);

        return $stats;
    }

    /**
     * Get Paginated Records for WAF Logs
     */
    public function get_paginated_records($limit = 10, $offset = 0, $search = null)
    {
        $this->load->library('safeline_api');
        $endpoint = 'open/records?limit=' . $limit . '&offset=' . $offset;
        
        if ($search) {
            $filter = array('src_ip' => $search); 
            $endpoint .= '&filter=' . urlencode(json_encode($filter));
        }

        $result = $this->safeline_api->request($endpoint);
        
        if (isset($result['error'])) return array('data' => [], 'total' => 0);

        $data_container = $result['data'] ?? [];
        $records = [];
        $total = 0;

        if (isset($data_container['data'])) {
            $records = (array) $data_container['data'];
            $total = $data_container['total'] ?? count($records);
        } elseif (isset($data_container['list'])) {
            $records = (array) $data_container['list'];
            $total = $data_container['total'] ?? count($records);
        } else {
            $records = is_array($data_container) ? $data_container : [];
            $total = count($records);
        }

        return array('data' => $records, 'total' => $total);
    }

    /**
     * Get Daily Events
     * Important events from Safeline
     */
    public function get_daily_events($limit = 30)
    {
        // Check Events Cache
        if (file_exists($this->events_cache_file) && (time() - filemtime($this->events_cache_file) < $this->events_cache_duration)) {
            return json_decode(file_get_contents($this->events_cache_file), true);
        }

        $this->load->library('safeline_api');
        $result = $this->safeline_api->get_events($limit, 0);

        if (isset($result['error'])) {
            log_message('error', 'Safeline Events API Error: ' . $result['error']);
            return [];
        }

        $data_container = $result['data'] ?? [];
        $records = [];
        
        if (isset($data_container['nodes']) && is_array($data_container['nodes'])) {
            $records = $data_container['nodes'];
        } elseif (isset($data_container['list']) && is_array($data_container['list'])) {
            $records = $data_container['list'];
        } elseif (isset($data_container['data']) && is_array($data_container['data'])) {
            $records = $data_container['data'];
        } elseif (is_array($data_container) && count($data_container) > 0 && !isset($data_container['total'])) {
            $records = $data_container;
        }

        $parsed = $this->_parse_events($records);
        
        // Save Cache
        file_put_contents($this->events_cache_file, json_encode($parsed));

        return $parsed;
    }

    /**
     * Get Paginated Events
     */
    public function get_paginated_events($limit = 10, $offset = 0)
    {
        $this->load->library('safeline_api');
        $result = $this->safeline_api->get_events($limit, $offset);

        if (isset($result['error'])) return array('data' => [], 'total' => 0);

        $data_container = $result['data'] ?? [];
        $records = [];
        $total = 0;

        if (isset($data_container['nodes']) && is_array($data_container['nodes'])) {
            $records = $data_container['nodes'];
            $total = $data_container['total'] ?? count($records);
        } elseif (isset($data_container['list']) && is_array($data_container['list'])) {
            $records = $data_container['list'];
            $total = $data_container['total'] ?? count($records);
        } elseif (isset($data_container['data']) && is_array($data_container['data'])) {
            $records = $data_container['data'];
            $total = $data_container['total'] ?? count($records);
        } else {
            $records = is_array($data_container) ? $data_container : [];
            $total = count($records);
        }

        return array('data' => $this->_parse_events($records), 'total' => $total);
    }

    private function _parse_events($records)
    {
        if (!is_array($records)) return [];
        $parsed = [];
        foreach ($records as $r) {
            if (!is_array($r)) continue;
            
            $ts = $r['timestamp'] ?? ($r['start_time'] ?? ($r['first_time'] ?? ($r['start_at'] ?? ($r['updated_at'] ?? time()))));
            if ($ts > 2000000000) $ts = floor($ts / 1000); // ms to sec

            $ip = $r['src_ip'] ?? ($r['ip'] ?? '-');
            
            $country = $r['country'] ?? ($r['src_country'] ?? ($r['geoip_country_name'] ?? 'Unknown'));
            $province = $r['province'] ?? ($r['region'] ?? null);

            $parsed[] = [
                'src_ip' => $ip,
                'country' => $country,
                'province' => $province ?? '-',
                'city' => $r['city'] ?? ($r['src_city'] ?? ($r['geoip_city_name'] ?? '-')),
                'host' => $r['host'] ?? ($r['target'] ?? '-'),
                'count' => $r['count'] ?? ($r['attack_count'] ?? (($r['deny_count'] ?? 0) + ($r['pass_count'] ?? 0) ?: 1)),
                'duration' => $r['duration'] ?? '1m',
                'timestamp' => $ts,
                'module' => $r['module'] ?? ($r['attack_type'] ?? 'Web Attack'),
                'coords' => $this->_resolve_geoip($ip, $province, $country)
            ];
        }
        return $parsed;
    }


    /**
     * Public helper to aggregate records by IP
     */
    public function aggregate_records($records)
    {
        if (empty($records)) return array();
        
        $grouped_threats = array();
        foreach ($records as $record) {
            $ip = $record['src_ip'] ?? ($record['ip'] ?? 'Unknown');
            $action = isset($record['action']) ? $record['action'] : 0;
            
            if (!isset($grouped_threats[$ip])) {
                $grouped_threats[$ip] = array(
                    'module' => $record['module'] ?? ($record['attack_type'] ?? 'Unknown'),
                    'src_ip' => $ip,
                    'city' => $record['city'] ?? '',
                    'country' => $record['country'] ?? '',
                    'host' => $record['host'] ?? '',
                    'url_path' => $record['url_path'] ?? '',
                    'min_ts' => $record['timestamp'] ?? time(),
                    'max_ts' => $record['timestamp'] ?? time(),
                    'action' => $action,
                    'count' => 0
                );
            }
            
            $grouped_threats[$ip]['count']++;
            $ts = $record['timestamp'] ?? time();
            if ($ts < $grouped_threats[$ip]['min_ts']) $grouped_threats[$ip]['min_ts'] = $ts;
            if ($ts > $grouped_threats[$ip]['max_ts']) $grouped_threats[$ip]['max_ts'] = $ts;
            
            if ($ts >= $grouped_threats[$ip]['max_ts']) {
                $grouped_threats[$ip]['url_path'] = $record['url_path'] ?? $grouped_threats[$ip]['url_path'];
                $grouped_threats[$ip]['host'] = $record['host'] ?? $grouped_threats[$ip]['host'];
            }
        }

        $aggregated = array();
        foreach ($grouped_threats as $ip => $data) {
            $diff = $data['max_ts'] - $data['min_ts'];
            $duration = ($diff < 60) ? '1m' : ceil($diff / 60) . 'm';

            $aggregated[] = array(
                'module' => $data['module'],
                'src_ip' => $data['src_ip'],
                'city' => $data['city'],
                'country' => $data['country'],
                'host' => $data['host'],
                'url_path' => $data['url_path'],
                'timestamp' => $data['max_ts'],
                'action' => $data['action'],
                'count' => $data['count'],
                'duration' => $duration
            );
        }

        // Sort by most recent
        usort($aggregated, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        return $aggregated;
    }

    private function _parse_safeline_response($result)
    {
        $data_container = isset($result['data']) ? $result['data'] : array();
        $records = array();
        $total_attacks = 0;

        if (isset($data_container['data']) && is_array($data_container['data'])) {
            $records = $data_container['data'];
            $total_attacks = isset($data_container['total']) ? $data_container['total'] : count($records);
        } elseif (isset($data_container['list']) && is_array($data_container['list'])) {
            $records = $data_container['list'];
            $total_attacks = isset($data_container['total']) ? $data_container['total'] : count($records);
        } elseif (is_array($data_container)) {
            $records = $data_container;
            $total_attacks = count($records);
        }
        
        $blocked_attacks = 0;
        $unique_ips = array();
        $attack_types = array(
            'ddos' => 0,
            'phishing' => 0,
            'malware' => 0,
            'intrusion' => 0,
            'other' => 0
        );
        
        // Sum total blocked
        foreach ($records as $record) {
            // SafeLine standard: deny_count > 0 means blocked
            $is_blocked = (isset($record['deny_count']) && $record['deny_count'] > 0) || 
                          (isset($record['action']) && in_array($record['action'], [1, 'block', 'deny']));
            
            if ($is_blocked) {
                $blocked_attacks++;
            }

            $ip = $record['src_ip'] ?? ($record['ip'] ?? 'Unknown');
            if ($ip !== 'Unknown') $unique_ips[$ip] = true;

            $module = strtolower($record['module'] ?? ($record['attack_type'] ?? 'other'));
            if (strpos($module, 'ddos') !== false) {
                $attack_types['ddos']++;
            } elseif (strpos($module, 'sql') !== false || strpos($module, 'xss') !== false || strpos($module, 'injection') !== false || strpos($module, 'php') !== false) {
                $attack_types['intrusion']++;
            } elseif (strpos($module, 'malware') !== false) {
                $attack_types['malware']++;
            } else {
                $attack_types['other']++;
            }
        }

        // Decorate individual records with IP-based metrics
        $ip_counts = array();
        $ip_times = array();
        foreach ($records as $r) {
            $ip = $r['src_ip'] ?? ($r['ip'] ?? 'Unknown');
            // convert start_at (ms) to seconds if needed
            $ts = $r['timestamp'] ?? ($r['start_at'] ?? time());
            if ($ts > 2000000000) $ts = floor($ts / 1000); // ms to sec
            
            $ip_counts[$ip] = ($ip_counts[$ip] ?? 0) + ($r['deny_count'] ?? 1) + ($r['pass_count'] ?? 0);
            if (!isset($ip_times[$ip])) {
                $ip_times[$ip] = array('min' => $ts, 'max' => $ts);
            } else {
                if ($ts < $ip_times[$ip]['min']) $ip_times[$ip]['min'] = $ts;
                if ($ts > $ip_times[$ip]['max']) $ip_times[$ip]['max'] = $ts;
            }
        }

        $recent_threats = array();
        foreach (array_slice($records, 0, 50) as $r) {
            $ip = $r['src_ip'] ?? ($r['ip'] ?? 'Unknown');
            $diff = $ip_times[$ip]['max'] - $ip_times[$ip]['min'];
            $ts = $r['timestamp'] ?? ($r['start_at'] ?? time());
            if ($ts > 2000000000) $ts = floor($ts / 1000);

            $recent_threats[] = array(
                'module' => $r['module'] ?? ($r['attack_type'] ?? 'Web Attack'),
                'src_ip' => $ip,
                'city' => $r['city'] ?? '',
                'country' => $r['country'] ?? '',
                'host' => $r['host'] ?? '',
                'url_path' => $r['url_path'] ?? ($r['url'] ?? '-'),
                'timestamp' => $ts,
                'action' => (isset($r['deny_count']) && $r['deny_count'] > 0) ? 1 : ($r['action'] ?? 0),
                'count' => $ip_counts[$ip],
                'duration' => ($diff < 60) ? '1m' : ceil($diff / 60) . 'm',
                'coords' => $this->_resolve_geoip($ip)
            );
        }

        if (count($records) > 0 && $blocked_attacks > 0) {
             $ratio = $blocked_attacks / count($records);
             $blocked_attacks = floor($total_attacks * $ratio);
        } else if ($total_attacks > 0) {
             $blocked_attacks = floor($total_attacks * 0.98);
        }

        return array(
            'summary' => array(
                'total_attacks' => $total_attacks,
                'blocked_attacks' => $blocked_attacks,
                'unique_ips' => count($unique_ips),
                'protection_level' => 'High',
                'status' => 'online'
            ),
            'recent' => $recent_threats,
            'types' => $attack_types
        );
    }

    private function _get_cache()
    {
        if (file_exists($this->cache_file)) {
            if (time() - filemtime($this->cache_file) < $this->cache_duration) {
                return json_decode(file_get_contents($this->cache_file), true);
            }
        }
        return false;
    }

    private function _save_cache($data)
    {
        file_put_contents($this->cache_file, json_encode($data));
    }

    private function _get_fallback_stats()
    {
        return array(
            'summary' => array(
                'total_attacks' => 0,
                'blocked_attacks' => 0,
                'active_threats' => 0,
                'protection_level' => 'Offline'
            ),
            'recent' => array(),
            'types' => array(
                'ddos' => 0,
                'intrusion' => 0,
                'malware' => 0,
                'phishing' => 0,
                'other' => 0
            )
        );
    }

    /**
     * Resolve IP to Geo Coordinates with local caching
     */
    private function _resolve_geoip($ip, $province = null, $country = null)
    {
        if (!$ip || $ip == 'Unknown' || $ip == '-' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0) {
            return null;
        }

        // 1. Initialization & Translation Map
        $translation_map = [
            '雅加达' => 'DKI Jakarta', '西爪哇' => 'Jawa Barat', '中爪哇' => 'Jawa Tengah',
            '东爪哇' => 'Jawa Timur', '万丹' => 'Banten', '峇里' => 'Bali',
            '北苏门答腊' => 'Sumatera Utara', '南苏门答腊' => 'Sumatera Selatan',
            '廖内' => 'Riau', '北苏拉威西' => 'Sulawesi Utara', '南苏拉威西' => 'Sulawesi Selatan',
            '苏门答腊' => 'Sumatera', '爪哇' => 'Jawa', '苏拉威西' => 'Sulawesi',
            '加里曼丹' => 'Kalimantan', '巴布亚' => 'Papua', '马鲁古' => 'Maluku'
        ];

        // Translate the input province if possible
        $input_province_translated = $province;
        if (isset($translation_map[$province])) {
            $input_province_translated = $translation_map[$province];
        }

        // 2. Load/Check Cache
        if ($this->geoip_data === null) {
            if (file_exists($this->geoip_cache_file)) {
                $this->geoip_data = json_decode(file_get_contents($this->geoip_cache_file), true) ?: [];
            } else {
                $this->geoip_data = [];
            }
        }

        if (isset($this->geoip_data[$ip])) {
            return $this->geoip_data[$ip];
        }

        // 3. PRIORITY: Precise Tracking API
        // Limit new fetches to 15 per request to prevent slowdown
        static $new_fetches = 0;
        if ($new_fetches < 15) {
            $new_fetches++;
            try {
                $url = "http://ip-api.com/json/" . $ip . "?fields=status,message,country,countryCode,regionName,city,lat,lon";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 2);
                $response = curl_exec($ch);
                curl_close($ch);

                if ($response) {
                    $data = json_decode($response, true);
                    if (isset($data['lat']) && isset($data['lon'])) {
                        $region = $data['regionName'] ?? '';
                        // Translate API region if it matches our list
                        if (isset($translation_map[$region])) $region = $translation_map[$region];
                        
                        $coords = [
                            'lat' => (float)$data['lat'],
                            'lon' => (float)$data['lon'],
                            'city' => $data['city'] ?? '',
                            'region' => $region ?: ($input_province_translated ?: '')
                        ];
                        
                        $this->geoip_data[$ip] = $coords;
                        file_put_contents($this->geoip_cache_file, json_encode($this->geoip_data));
                        return $coords;
                    }
                }
            } catch (Exception $e) {}
        }

        // 4. FALLBACK: Local Tracking Map (if API fails or exceeds limit)
        $province_coords = [
            'Aceh' => [95.3, 5.5], 'Sumatera Utara' => [98.6, 3.6], 'Sumatera Barat' => [100.3, -0.9],
            'Riau' => [101.4, 0.5], 'Jambi' => [103.6, -1.6], 'Sumatera Selatan' => [104.7, -2.9],
            'Bengkulu' => [102.3, -3.8], 'Lampung' => [105.2, -5.4], 'Kepulauan Bangka Belitung' => [106.1, -2.1],
            'Kepulauan Riau' => [108.2, 3.9], 'DKI Jakarta' => [106.8, -6.2], 'Jawa Barat' => [107.6, -6.9],
            'Jawa Tengah' => [110.4, -7.0], 'DI Yogyakarta' => [110.3, -7.8], 'Jawa Timur' => [112.7, -7.2],
            'Banten' => [106.1, -6.1], 'Bali' => [115.2, -8.4], 'Nusa Tenggara Barat' => [116.1, -8.6],
            'Nusa Tenggara Timur' => [123.5, -10.1], 'Kalimantan Barat' => [109.3, 0.0],
            'Kalimantan Tengah' => [113.9, -2.2], 'Kalimantan Selatan' => [114.6, -3.3],
            'Kalimantan Timur' => [117.1, -0.5], 'Kalimantan Utara' => [117.4, 3.3],
            'Sulawesi Utara' => [124.8, 1.5], 'Sulawesi Tengah' => [119.8, -0.9],
            'Sulawesi Selatan' => [119.4, -5.1], 'Sulawesi Tenggara' => [122.5, -3.9],
            'Gorontalo' => [123.0, 0.5], 'Sulawesi Barat' => [119.3, -2.3],
            'Maluku' => [128.1, -3.7], 'Maluku Utara' => [127.3, 0.7],
            'Papua Barat' => [134.0, -0.8], 'Papua' => [138.8, -4.2],
            'Jakarta' => [106.8, -6.2], 'Surabaya' => [112.7, -7.2], 'Medan' => [98.6, 3.6],
            'Bandung' => [107.6, -6.9], 'Makassar' => [119.4, -5.1], 'Semarang' => [110.4, -7.0],
            'Palembang' => [104.7, -2.9], 'Batam' => [104.0, 1.1], 'Pekanbaru' => [101.4, 0.5],
        ];

        if (($country == 'ID' || $country == 'Indonesia')) {
            $search_name = !empty($input_province_translated) ? $input_province_translated : $province;
            foreach ($province_coords as $name => $coords) {
                if ($search_name && stripos($search_name, $name) !== false) {
                    return ['lon' => (float)$coords[0], 'lat' => (float)$coords[1], 'region' => $search_name, 'city' => ''];
                }
            }
        }

        return null;
    }
}
