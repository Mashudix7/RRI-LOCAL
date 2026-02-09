<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Safeline WAF API Library
 * 
 * Handle:
 * - CSRF token fetching & caching
 * - JWT login & caching
 * - Auto-refresh JWT kalau expired (max 1 retry)
 * - API requests dengan proper error handling
 */

class Safeline_api {
    
    private $ci;
    private $config;
    private $base_url;
    
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->config->load('safeline');
        $this->config = $this->ci->config->item('safeline');
        $this->base_url = $this->config['base_url'];
        
        // Load cache driver
        $this->ci->load->driver('cache', array('adapter' => 'file'));
    }
    
    /**
     * Get CSRF Token
     * Private method - internal use only
     */
    private function get_csrf_token() {
        $cache_key = $this->config['csrf_cache_key'];
        
        // Cek cache dulu
        $cached = $this->ci->cache->get($cache_key);
        if ($cached) {
            log_message('debug', 'CSRF Token from cache');
            return $cached;
        }
        
        $url = $this->base_url . '/open/auth/csrf';
        
        // CURL request
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->config['request_timeout'],
            CURLOPT_SSL_VERIFYPEER => $this->config['enable_ssl_verify'],
            CURLOPT_SSL_VERIFYHOST => 2,
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        if ($curl_error) {
            throw new Exception('CURL Error: ' . $curl_error);
        }
        
        if ($http_code !== 200) {
            throw new Exception('Failed to get CSRF token (HTTP ' . $http_code . ')');
        }
        
        $data = json_decode($response, true);
        if (!isset($data['data']['csrf_token'])) {
            throw new Exception('Invalid CSRF token response');
        }
        
        $csrf = $data['data']['csrf_token'];
        
        // Cache 5 menit
        $this->ci->cache->save($cache_key, $csrf, $this->config['csrf_ttl']);
        log_message('debug', 'CSRF Token generated & cached');
        
        return $csrf;
    }
    
    /**
     * Login & get JWT
     * Private method - internal use only
     */
    private function login() {
        $cache_key = $this->config['jwt_cache_key'];
        
        // Cek cache JWT dulu
        $cached = $this->ci->cache->get($cache_key);
        if ($cached) {
            log_message('debug', 'JWT from cache');
            return $cached;
        }
        
        log_message('debug', 'JWT expired or not found, requesting new token');
        
        // Get CSRF token
        $csrf_token = $this->get_csrf_token();
        
        $url = $this->base_url . '/open/auth/login';
        
        $payload = json_encode(array(
            'username' => $this->config['username'],
            'password' => $this->config['password_hash'],
            'csrf_token' => $csrf_token,
            'callback_address' => $this->config['callback_url'] ?? 'https://trial-waf.rri.go.id',
            'test' => false,
        ));
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
            ),
            CURLOPT_TIMEOUT => $this->config['request_timeout'],
            CURLOPT_SSL_VERIFYPEER => $this->config['enable_ssl_verify'],
            CURLOPT_SSL_VERIFYHOST => 2,
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        if ($curl_error) {
            throw new Exception('CURL Error: ' . $curl_error);
        }
        
        if ($http_code !== 200) {
            log_message('error', 'Safeline Login Failed. HTTP Code: ' . $http_code . '. Response: ' . $response);
            throw new Exception('Login failed (HTTP ' . $http_code . ')');
        }
        
        $data = json_decode($response, true);
        if (!isset($data['data']['jwt'])) {
            log_message('error', 'Safeline Login Response missing JWT. Data: ' . json_encode($data));
            throw new Exception('Invalid JWT response from login');
        }
        
        $jwt = $data['data']['jwt'];
        
        // Cache JWT 50 menit
        $this->ci->cache->save($cache_key, $jwt, $this->config['jwt_ttl']);
        log_message('info', 'JWT token obtained & cached');
        
        return $jwt;
    }
    
    /**
     * API Request dengan auto-login & max 1 retry
     * 
     * @param string $endpoint
     * @param string $method (GET, POST, PUT, DELETE)
     * @param array $data (optional, for POST/PUT)
     * @param bool $retry (internal, max 1 retry)
     */
    public function request($endpoint, $method = 'GET', $data = null, $retry = true) {
        try {
            // Get JWT
            $jwt = $this->login();
            $url = $this->base_url . '/' . $endpoint;
            
            $ch = curl_init();
            
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Bearer ' . $jwt,
                ),
                CURLOPT_TIMEOUT => $this->config['request_timeout'],
                CURLOPT_SSL_VERIFYPEER => false, // Set to false to avoid cert issues on local
                CURLOPT_SSL_VERIFYHOST => 0,
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
            
            // Handle 401 Unauthorized - JWT expired, retry ONCE
            if ($http_code === 401 && $retry) {
                log_message('warning', 'JWT expired, clearing cache & retrying once');
                $this->ci->cache->delete($this->config['jwt_cache_key']);
                return $this->request($endpoint, $method, $data, false);
            }
            
            // If 401 again, don't retry anymore (prevent infinite loop)
            if ($http_code === 401) {
                throw new Exception('Authentication failed after retry');
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
