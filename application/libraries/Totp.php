<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * =====================================================
 * TOTP Library (RFC 6238)
 * =====================================================
 * 
 * Pure PHP implementation of Time-based One-Time Password.
 * Compatible with Google Authenticator, Authy, etc.
 * 
 * @package     CSIRT RRI
 * @subpackage  Libraries
 * @category    Security / 2FA
 * @author      System
 * 
 * Flow:
 * 1. generate_secret()  → Generate random Base32 secret
 * 2. get_qr_url()       → Generate QR code URI for authenticator app
 * 3. verify_code()      → Validate 6-digit OTP from user
 * =====================================================
 */
class Totp {

    /**
     * Length of the OTP code (6 digits standard)
     */
    private $code_length = 6;

    /**
     * Time step in seconds (30 seconds standard)
     */
    private $time_step = 30;

    /**
     * Number of time steps to check before/after current time
     * Allows for clock drift (1 = ±30 seconds)
     */
    private $discrepancy = 1;

    /**
     * Base32 character set (RFC 4648)
     */
    private $base32_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * Application name shown in authenticator
     */
    private $issuer = 'CSIRT RRI';

    // ─────────────────────────────────────────────────
    //  PUBLIC METHODS
    // ─────────────────────────────────────────────────

    /**
     * Generate a new random TOTP secret (Base32 encoded)
     * 
     * @param int $length Secret length in bytes (default 20 = 160 bits, recommended by RFC)
     * @return string Base32-encoded secret key
     */
    public function generate_secret($length = 20)
    {
        $random_bytes = '';
        
        if (function_exists('random_bytes')) {
            $random_bytes = random_bytes($length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $random_bytes = openssl_random_pseudo_bytes($length);
        } else {
            // Fallback (less secure)
            for ($i = 0; $i < $length; $i++) {
                $random_bytes .= chr(mt_rand(0, 255));
            }
        }

        return $this->_base32_encode($random_bytes);
    }

    /**
     * Generate the current TOTP code for a given secret
     * 
     * @param string $secret Base32-encoded secret
     * @param int|null $time_slice Optional specific time slice (for testing)
     * @return string 6-digit OTP code (zero-padded)
     */
    public function get_code($secret, $time_slice = null)
    {
        if ($time_slice === null) {
            $time_slice = floor(time() / $this->time_step);
        }

        $secret_key = $this->_base32_decode($secret);

        // Pack time into 8-byte big-endian binary
        $time_bytes = chr(0) . chr(0) . chr(0) . chr(0) . pack('N*', $time_slice);

        // HMAC-SHA1
        $hash = hash_hmac('sha1', $time_bytes, $secret_key, true);

        // Dynamic truncation (RFC 4226 §5.4)
        $offset = ord($hash[19]) & 0x0F;
        $otp = (
            ((ord($hash[$offset + 0]) & 0x7F) << 24) |
            ((ord($hash[$offset + 1]) & 0xFF) << 16) |
            ((ord($hash[$offset + 2]) & 0xFF) << 8)  |
            ((ord($hash[$offset + 3]) & 0xFF))
        ) % pow(10, $this->code_length);

        return str_pad($otp, $this->code_length, '0', STR_PAD_LEFT);
    }

    /**
     * Verify a TOTP code against a secret
     * Checks current time step ± discrepancy window
     * 
     * @param string $secret Base32-encoded secret
     * @param string $code User-submitted 6-digit code
     * @param int|null $discrepancy Override default discrepancy window
     * @return bool True if code is valid
     */
    public function verify_code($secret, $code, $discrepancy = null)
    {
        if ($discrepancy === null) {
            $discrepancy = $this->discrepancy;
        }

        // Sanitize: remove spaces, ensure string
        $code = trim(str_replace(' ', '', (string) $code));

        if (strlen($code) !== $this->code_length) {
            return false;
        }

        $current_time_slice = floor(time() / $this->time_step);

        // Check ±discrepancy time steps
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $check_time = $current_time_slice + $i;
            $calculated_code = $this->get_code($secret, $check_time);

            if (hash_equals($calculated_code, $code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate otpauth:// URI for QR code
     * This URI is what authenticator apps scan
     * 
     * @param string $secret Base32-encoded secret
     * @param string $account_name User identifier (e.g. username or email)
     * @param string|null $issuer Override default issuer
     * @return string otpauth:// URI
     */
    public function get_otpauth_url($secret, $account_name, $issuer = null)
    {
        if ($issuer === null) {
            $issuer = $this->issuer;
        }

        $label = rawurlencode($issuer) . ':' . rawurlencode($account_name);

        return 'otpauth://totp/' . $label . '?' . http_build_query([
            'secret'    => $secret,
            'issuer'    => $issuer,
            'algorithm' => 'SHA1',
            'digits'    => $this->code_length,
            'period'    => $this->time_step,
        ]);
    }

    /**
     * Generate QR code image URL using Google Charts API
     * (Simple, no library needed)
     * 
     * @param string $otpauth_url The otpauth:// URI
     * @param int $size QR image size in pixels
     * @return string URL to QR code image
     */
    public function get_qr_url($otpauth_url, $size = 250)
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?'
            . http_build_query([
                'size' => $size . 'x' . $size,
                'data' => $otpauth_url,
                'ecc'  => 'M',
            ]);
    }

    /**
     * Format secret for display (groups of 4 characters)
     * Makes it easier for users to manually type the secret
     * 
     * @param string $secret Raw Base32 secret
     * @return string Formatted secret (e.g., "JBSW Y3DP EHPK 3PXP")
     */
    public function format_secret($secret)
    {
        return trim(chunk_split($secret, 4, ' '));
    }

    /**
     * Set custom issuer name
     * 
     * @param string $issuer Application/organization name
     */
    public function set_issuer($issuer)
    {
        $this->issuer = $issuer;
    }

    /**
     * Set custom discrepancy (time window tolerance)
     * 
     * @param int $discrepancy Number of time steps (each 30 seconds)
     */
    public function set_discrepancy($discrepancy)
    {
        $this->discrepancy = max(0, (int) $discrepancy);
    }

    // ─────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────────

    /**
     * Base32 encode binary data to RFC 4648 Base32 string
     * 
     * @param string $data Binary data
     * @return string Base32 encoded string (no padding)
     */
    private function _base32_encode($data)
    {
        if (empty($data)) return '';

        $binary = '';
        foreach (str_split($data) as $char) {
            $binary .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }

        $encoded = '';
        $chunks = str_split($binary, 5);
        foreach ($chunks as $chunk) {
            $chunk = str_pad($chunk, 5, '0', STR_PAD_RIGHT);
            $encoded .= $this->base32_chars[bindec($chunk)];
        }

        return $encoded;
    }

    /**
     * Base32 decode RFC 4648 Base32 string to binary data
     * 
     * @param string $data Base32 encoded string
     * @return string Binary data
     */
    private function _base32_decode($data)
    {
        if (empty($data)) return '';

        $data = strtoupper($data);
        $data = str_replace('=', '', $data); // Remove padding

        $binary = '';
        foreach (str_split($data) as $char) {
            $pos = strpos($this->base32_chars, $char);
            if ($pos === false) continue; // Skip invalid chars
            $binary .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }

        $decoded = '';
        $bytes = str_split($binary, 8);
        foreach ($bytes as $byte) {
            if (strlen($byte) < 8) continue; // Skip incomplete bytes
            $decoded .= chr(bindec($byte));
        }

        return $decoded;
    }
}
