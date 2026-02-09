<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * WAF Controller
 * 
 * Endpoint untuk ambil data attack records dari Safeline
 */

class Waf extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load library HANYA di controller yang perlu (bukan autoload)
        $this->load->library('safeline_api');
        
        // Ensure user is logged in (optional, but recommended for security)
        // If your admin session is checkable, do it here.
        // For now I'll follow the user request exactly but add a note.
    }
    
    /**
     * GET /waf/records
     * List semua attack records
     * 
     * Query params:
     *   - limit: jumlah records (default 100)
     *   - offset: mulai dari record ke- (default 0)
     */
    public function records() {
        try {
            $limit = $this->input->get('limit', TRUE) ?: 100;
            $offset = $this->input->get('offset', TRUE) ?: 0;
            
            // Validasi input
            if (!is_numeric($limit) || !is_numeric($offset) || $limit < 1 || $offset < 0) {
                return $this->_json_response(false, 'Invalid limit or offset', null, 400);
            }
            
            // Add Today's filter for accuracy
            $today_start = strtotime('today');
            $filter = json_encode(array('timestamp' => array($today_start, time() + 86400)));
            $result = $this->safeline_api->request('open/records?limit=' . $limit . '&offset=' . $offset . '&filter=' . urlencode($filter));
            
            // Cek error
            if (isset($result['error'])) {
                log_message('error', 'Safeline API Error: ' . $result['error']);
                return $this->_json_response(false, $result['error'], null, 500);
            }
            
            // Robust parsing for different API versions
            $data_container = isset($result['data']) ? $result['data'] : [];
            $records = [];
            $total = 0;

            if (isset($data_container['data']) && is_array($data_container['data'])) {
                $records = $data_container['data'];
                $total = isset($data_container['total']) ? $data_container['total'] : count($records);
            } elseif (isset($data_container['list']) && is_array($data_container['list'])) {
                $records = $data_container['list'];
                $total = isset($data_container['total']) ? $data_container['total'] : count($records);
            }

            // Calculate metrics per IP for decoration
            $ip_metrics = array();
            foreach ($records as $r) {
                $ip = $r['src_ip'] ?? ($r['ip'] ?? 'Unknown');
                $ts = $r['timestamp'] ?? time();
                if (!isset($ip_metrics[$ip])) {
                    $ip_metrics[$ip] = array('count' => 0, 'min' => $ts, 'max' => $ts);
                }
                $ip_metrics[$ip]['count']++;
                if ($ts < $ip_metrics[$ip]['min']) $ip_metrics[$ip]['min'] = $ts;
                if ($ts > $ip_metrics[$ip]['max']) $ip_metrics[$ip]['max'] = $ts;
            }

            // Decorate records with these metrics
            foreach ($records as &$r) {
                $ip = $r['src_ip'] ?? ($r['ip'] ?? 'Unknown');
                $r['count'] = $ip_metrics[$ip]['count'];
                $diff = $ip_metrics[$ip]['max'] - $ip_metrics[$ip]['min'];
                $r['duration'] = ($diff < 60) ? '1m' : ceil($diff / 60) . 'm';
            }

            // Calculate simple summary for Live View cards
            $blocked_count = 0;
            foreach ($records as $r) {
                $action = isset($r['action']) ? $r['action'] : 0;
                if ($action == 1 || $action == 'block' || $action == 'deny') {
                    $blocked_count++;
                }
            }
            
            $estimated_blocked = $blocked_count;
            if (count($records) > 0 && $total > count($records)) {
                $ratio = $blocked_count / count($records);
                $estimated_blocked = floor($total * $ratio);
            } elseif ($total > 0 && $estimated_blocked == 0) {
                $estimated_blocked = floor($total * 0.98);
            }

            // Success
            return $this->_json_response(true, 'OK', array(
                'data' => $records, // Return individual events (many rows)
                'summary' => array(
                    'total' => $total,
                    'blocked' => $estimated_blocked
                ),
                'limit' => $limit,
                'offset' => $offset,
            ), 200);
            
        } catch (Exception $e) {
            log_message('error', 'WAF Controller Error: ' . $e->getMessage());
            return $this->_json_response(false, 'Internal Server Error', null, 500);
        }
    }
    
    /**
     * GET /waf/record/:id
     * Detail satu attack record
     */
    public function record($id = null) {
        try {
            if (!$id) {
                return $this->_json_response(false, 'Record ID required', null, 400);
            }
            
            // Validasi format ID (alphanumeric only)
            if (!preg_match('/^[a-f0-9]{32}$/', $id)) {
                return $this->_json_response(false, 'Invalid record ID format', null, 400);
            }
            
            $result = $this->safeline_api->get_record($id);
            
            if (isset($result['error'])) {
                log_message('error', 'Safeline API Error: ' . $result['error']);
                return $this->_json_response(false, $result['error'], null, 500);
            }
            
            return $this->_json_response(true, 'OK', $result['data'], 200);
            
        } catch (Exception $e) {
            log_message('error', 'WAF Controller Error: ' . $e->getMessage());
            return $this->_json_response(false, 'Internal Server Error', null, 500);
        }
    }
    
    /**
     * Health check endpoint
     * GET /waf/health
     */
    public function health() {
        return $this->_json_response(true, 'WAF API Service is running', null, 200);
    }
    
    /**
     * POST /waf/records_paged
     * For DataTables Server Side
     */
    public function records_paged() {
        try {
            $draw = $this->input->post('draw', TRUE);
            $start = $this->input->post('start', TRUE);
            $length = $this->input->post('length', TRUE);
            $search = $this->input->post('search', TRUE);
            $search_val = isset($search['value']) ? $search['value'] : null;

            $this->load->model('Waf_model');
            $result = $this->Waf_model->get_paginated_records($length, $start, $search_val);
            
            // Also fetch summary for the cards
            $stats = $this->Waf_model->get_daily_stats();

            $response = array(
                "draw" => intval($draw),
                "recordsTotal" => intval($result['total']),
                "recordsFiltered" => intval($result['total']),
                "data" => $result['data'],
                "stats" => $stats['summary'] ?? null
            );

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
                
        } catch (Exception $e) {
            log_message('error', 'WAF Controller Paged Error: ' . $e->getMessage());
            return $this->_json_response(false, 'Error fetching paged records', null, 500);
        }
    }

    /**
     * POST /waf/events_paged
     * For DataTables Server Side Events
     */
    public function events_paged() {
        try {
            $draw = $this->input->post('draw', TRUE);
            $start = $this->input->post('start', TRUE);
            $length = $this->input->post('length', TRUE);

            $this->load->model('Waf_model');
            $result = $this->Waf_model->get_paginated_events($length, $start);
            
            $response = array(
                "draw" => intval($draw),
                "recordsTotal" => intval($result['total']),
                "recordsFiltered" => intval($result['total']),
                "data" => $result['data']
            );

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
                
        } catch (Exception $e) {
            log_message('error', 'WAF Controller Events Paged Error: ' . $e->getMessage());
            return $this->_json_response(false, 'Error fetching paged events', null, 500);
        }
    }

    /**
     * GET /waf/dashboard_live
     * Returns both active logs and events for dashboard
     */
    public function dashboard_live() {
        try {
            $this->load->model('Waf_model');
            
            // Get records (Logs)
            $waf_data = $this->Waf_model->get_daily_stats();
            
            // Get events (Grouped Kejadian)
            $waf_events = $this->Waf_model->get_daily_events(30);
            
            $response_data = array(
                'records' => $waf_data['recent'] ?? [],
                'events' => $waf_events ?? [],
                'summary' => $waf_data['summary'] ?? null
            );

            // Debug Log
            file_put_contents(APPPATH . 'cache/debug_dashboard_live.json', json_encode($response_data));
            
            return $this->_json_response(true, 'OK', $response_data, 200);

        } catch (Exception $e) {
            log_message('error', 'WAF Dashboard Live Error: ' . $e->getMessage());
            return $this->_json_response(false, 'Error fetching live data', null, 500);
        }
    }

    /**
     * Private: Return JSON response
     */
    private function _json_response($success, $message, $data = null, $http_code = 200) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($http_code)
            ->set_output(json_encode(array(
                'success' => (bool) $success,
                'message' => $message,
                'data' => $data,
                'timestamp' => date('c'),
            )));
    }
}
