<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Safeline WAF API Library
 * 
 * Handle:
 * - API requests dengan JWT Token langsung dari .env
 * - Proper error handling
 * 
 * CATATAN: Library ini menggunakan JWT token langsung tanpa login.
 * Pastikan SAFELINE_JWT_TOKEN di .env selalu valid dan diupdate jika expired.
 */

class Safeline_api {
    
    private $ci;
    private $config;
    private $base_url;
    private $jwt_token;
    
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->config->load('safeline');
        $this->config = $this->ci->config->item('safeline');
        $this->base_url = $this->config['base_url'];
        $this->jwt_token = $this->config['jwt_token'];
        
        // Validate JWT token exists
        if (empty($this->jwt_token)) {
            log_message('error', 'Safeline API: JWT Token tidak ditemukan di .env!');
        }
    }
    
    /**
     * API Request dengan JWT Token langsung
     * 
     * @param string $endpoint
     * @param string $method (GET, POST, PUT, DELETE)
     * @param array $data (optional, for POST/PUT)
     */
    public function request($endpoint, $method = 'GET', $data = null) {
        try {
            if (empty($this->jwt_token)) {
                throw new Exception('JWT Token tidak terkonfigurasi di .env');
            }
            
            $url = $this->base_url . '/' . $endpoint;
            
            $ch = curl_init();
            
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Bearer ' . $this->jwt_token,
                ),
                CURLOPT_TIMEOUT => $this->config['request_timeout'],
                CURLOPT_SSL_VERIFYPEER => $this->config['enable_ssl_verify'],
                CURLOPT_SSL_VERIFYHOST => $this->config['enable_ssl_verify'] ? 2 : 0,
            );
            
            // Method specific options
            if ($method === 'POST') {
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
            } elseif ($method === 'PUT') {
                $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
            } elseif ($method === 'DELETE') {
                $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            }
            
            curl_setopt_array($ch, $options);
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);
            
            if ($curl_error) {
                throw new Exception('CURL Error: ' . $curl_error);
            }
            
            // Handle 401 Unauthorized - JWT expired
            if ($http_code === 401) {
                log_message('error', 'Safeline API: JWT Token expired atau tidak valid. Update SAFELINE_JWT_TOKEN di .env!');
                throw new Exception('JWT Token expired atau tidak valid. Silakan update token di .env');
            }
            
            // Non-200 responses
            if ($http_code >= 400) {
                throw new Exception('API Error (HTTP ' . $http_code . ')');
            }
            
            $decoded = json_decode($response, true);
            return $decoded ?: array('error' => 'Invalid JSON response');
            
        } catch (Exception $e) {
            log_message('error', 'Safeline API Error: ' . $e->getMessage());
            return array('error' => $e->getMessage());
        }
    }
    
    /**
     * Get Attack Records
     * 
     * @param int $limit
     * @param int $offset
     */
    public function get_records($limit = 100, $offset = 0) {
        $endpoint = 'open/records?limit=' . $limit . '&offset=' . $offset;
        return $this->request($endpoint, 'GET');
    }
    
    /**
     * Get Single Record Detail
     * 
     * @param string $id (event_id)
     */
    public function get_record($id) {
        $endpoint = 'open/record/' . $id;
        return $this->request($endpoint, 'GET');
    }

    /**
     * Get Events (Kejadian Penting)
     * 
     * @param int $limit
     * @param int $offset
     */
    public function get_events($limit = 100, $offset = 0) {
        $endpoint = 'open/events?limit=' . $limit . '&offset=' . $offset;
        return $this->request($endpoint, 'GET');
    }
}
