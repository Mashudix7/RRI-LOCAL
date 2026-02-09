<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * =====================================================
 * Safeline WAF Configuration
 * =====================================================
 * 
 * Konfigurasi untuk integrasi dengan Safeline WAF API.
 * 
 * PENTING:
 * - Kredensial TIDAK disimpan di file ini
 * - Semua kredensial dibaca dari file .env
 * - Lihat .env.example untuk template
 * 
 * @package     CSIRT RRI
 * @subpackage  Config
 * @category    Security
 * @author      Tim Teknologi Media Baru
 * =====================================================
 */

// Manually load env helper because config files are loaded before the autoloader
if (!function_exists('env')) {
    $helper_path = __DIR__ . '/../helpers/env_helper.php';
    if (file_exists($helper_path)) {
        require_once $helper_path;
    }
}

/**
 * Safeline API Configuration
 * 
 * Semua nilai dibaca dari .env dengan fallback ke default values
 */
$config['safeline'] = array(
    // =====================================================
    // API Connection
    // =====================================================
    
    // Base URL untuk API (tanpa trailing slash)
    'base_url' => env('SAFELINE_BASE_URL', 'https://trial-waf.rri.go.id/api'),
    
    // Callback URL untuk login
    'callback_url' => env('SAFELINE_CALLBACK_URL', 'https://trial-waf.rri.go.id'),
    
    // =====================================================
    // Authentication Credentials
    // =====================================================
    
    // Username untuk login ke WAF API
    'username' => env('SAFELINE_USERNAME', ''),
    
    // Password hash (encoded dari browser F12)
    'password_hash' => env('SAFELINE_PASSWORD_HASH', ''),
    
    // =====================================================
    // Caching Configuration
    // =====================================================
    
    // Cache keys
    'jwt_cache_key' => 'safeline_jwt_token',
    'csrf_cache_key' => 'safeline_csrf_token',
    
    // JWT Token Time-To-Live (seconds)
    // Default: 50 menit (3000 detik)
    'jwt_ttl' => env('SAFELINE_JWT_TTL', 3000),
    
    // CSRF Token Time-To-Live (seconds)
    // Default: 5 menit (300 detik)
    'csrf_ttl' => env('SAFELINE_CSRF_TTL', 300),
    
    // =====================================================
    // Request Settings
    // =====================================================
    
    // CURL request timeout (seconds)
    'request_timeout' => env('SAFELINE_REQUEST_TIMEOUT', 15),
    
    // SSL verification (ALWAYS true in production!)
    'enable_ssl_verify' => env('SAFELINE_SSL_VERIFY', true),
);

/**
 * Validate required credentials
 * Log warning jika credentials kosong
 */
if (empty($config['safeline']['username']) || empty($config['safeline']['password_hash'])) {
    log_message('error', 'Safeline Config: Username atau Password tidak terkonfigurasi di .env file!');
}