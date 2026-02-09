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
    
    // =====================================================
    // Authentication - JWT Token
    // =====================================================
    
    // JWT Token langsung untuk autentikasi API
    // Cara mendapatkan: Login ke Safeline WAF → F12 → Network → Authorization header
    'jwt_token' => env('SAFELINE_JWT_TOKEN', ''),
    
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
 * Log warning jika JWT token kosong
 */
if (empty($config['safeline']['jwt_token'])) {
    log_message('error', 'Safeline Config: JWT Token tidak terkonfigurasi! Isi SAFELINE_JWT_TOKEN di .env file!');
}