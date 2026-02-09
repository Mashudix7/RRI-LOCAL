<?php
/**
 * =====================================================
 * Environment Helper
 * =====================================================
 * 
 * Helper untuk membaca environment variables dari file .env
 * 
 * @package     CSIRT RRI
 * @subpackage  Helpers
 * @category    Configuration
 * @author      Tim Teknologi Media Baru
 * 
 * Komentar Kritikal:
 * - File .env HARUS ada di root project
 * - JANGAN commit file .env ke repository
 * - Gunakan .env.example sebagai template
 * =====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('env')) {
    /**
     * Get environment variable value
     * 
     * Prioritas:
     * 1. $_ENV (jika sudah di-load oleh PHP)
     * 2. getenv() (system environment)
     * 3. Parse langsung dari file .env
     * 4. Return default value
     * 
     * @param string $key Variable name
     * @param mixed $default Default value jika tidak ditemukan
     * @return mixed
     */
    function env($key, $default = null)
    {
        // Static cache untuk parsed .env
        static $env_cache = null;
        
        // Load dan cache .env jika belum
        if ($env_cache === null) {
            // Ensure APPPATH is defined if used inside load_env_file or locally
            if (!defined('APPPATH')) {
                define('APPPATH', dirname(__FILE__) . '/../');
            }
            $env_cache = load_env_file();
        }

        
        // Cek di cache dulu
        if (isset($env_cache[$key])) {
            return parse_env_value($env_cache[$key]);
        }
        
        // Fallback ke $_ENV
        if (isset($_ENV[$key])) {
            return parse_env_value($_ENV[$key]);
        }
        
        // Fallback ke getenv()
        $value = getenv($key);
        if ($value !== false) {
            return parse_env_value($value);
        }
        
        return $default;
    }
}

if (!function_exists('load_env_file')) {
    /**
     * Load dan parse file .env
     * 
     * @return array Associative array key => value
     */
    function load_env_file()
    {
        $env_data = [];
        
        // Path ke file .env (root project)
        $env_path = (defined('FCPATH') ? FCPATH : dirname(__FILE__) . '/../../') . '.env';
        
        if (!file_exists($env_path)) {
            // Avoid log_message during early config loading to prevent recursion
            if (function_exists('log_message') && class_exists('CI_Log', false)) {
                log_message('debug', 'ENV Helper: .env file not found at ' . $env_path);
            }
            return $env_data;
        }

        
        // Parse file
        $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            
            // Parse KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes jika ada
                if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                    (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                
                $env_data[$key] = $value;
            }
        }
        
        if (function_exists('log_message') && class_exists('CI_Log', false)) {
            log_message('debug', 'ENV Helper: Loaded ' . count($env_data) . ' variables from .env');
        }
        
        return $env_data;
    }
}

if (!function_exists('parse_env_value')) {
    /**
     * Parse string value ke tipe yang sesuai
     * 
     * @param string $value
     * @return mixed
     */
    function parse_env_value($value)
    {
        // Boolean parsing
        $lower = strtolower($value);
        if ($lower === 'true' || $lower === '(true)') {
            return true;
        }
        if ($lower === 'false' || $lower === '(false)') {
            return false;
        }
        if ($lower === 'null' || $lower === '(null)') {
            return null;
        }
        if ($lower === 'empty' || $lower === '(empty)') {
            return '';
        }
        
        // Numeric parsing
        if (is_numeric($value)) {
            if (strpos($value, '.') !== false) {
                return (float) $value;
            }
            return (int) $value;
        }
        
        return $value;
    }
}

if (!function_exists('env_required')) {
    /**
     * Get required environment variable
     * Throws exception jika tidak ada
     * 
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    function env_required($key)
    {
        $value = env($key);
        
        if ($value === null) {
            throw new Exception("Required environment variable '{$key}' is not set. Check your .env file.");
        }
        
        return $value;
    }
}
