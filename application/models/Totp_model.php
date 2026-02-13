<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * =====================================================
 * TOTP Model
 * =====================================================
 * 
 * Model untuk mengelola TOTP secrets per user.
 * Auto-creates table jika belum ada.
 * 
 * Tabel: totp_secrets
 * - id, user_id, secret, is_verified, recovery_codes,
 *   failed_attempts, locked_until, created_at, updated_at
 * =====================================================
 */
class Totp_model extends CI_Model {

    private $table = 'totp_secrets';

    public function __construct()
    {
        parent::__construct();
        $this->_initialize_table();
    }

    /**
     * Auto-create table if not exists
     */
    private function _initialize_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `secret` VARCHAR(64) NOT NULL,
            `is_verified` TINYINT(1) DEFAULT 0 COMMENT '1 = user sudah scan QR dan verifikasi pertama kali',
            `recovery_codes` TEXT DEFAULT NULL COMMENT 'JSON array of hashed recovery codes',
            `failed_attempts` INT UNSIGNED DEFAULT 0,
            `locked_until` DATETIME DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `uq_user_totp` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $this->db->query($sql);
    }

    // ─────────────────────────────────────────────────
    //  CRUD
    // ─────────────────────────────────────────────────

    /**
     * Get TOTP record for a user
     * 
     * @param int $user_id
     * @return array|null
     */
    public function get_by_user($user_id)
    {
        return $this->db->where('user_id', $user_id)
                        ->get($this->table)
                        ->row_array();
    }

    /**
     * Check if user has TOTP setup (secret exists AND is verified)
     * 
     * @param int $user_id
     * @return bool
     */
    public function is_totp_enabled($user_id)
    {
        $record = $this->get_by_user($user_id);
        return $record && $record['is_verified'] == 1;
    }

    /**
     * Save a new TOTP secret for a user
     * (Overwrites existing if any)
     * 
     * @param int $user_id
     * @param string $secret Base32-encoded secret
     * @param array $recovery_codes Plain-text recovery codes (will be hashed)
     * @return bool
     */
    public function save_secret($user_id, $secret, $recovery_codes = [])
    {
        // Delete existing
        $this->db->where('user_id', $user_id)->delete($this->table);

        // Hash recovery codes for storage
        $hashed_codes = [];
        foreach ($recovery_codes as $code) {
            $hashed_codes[] = password_hash($code, PASSWORD_DEFAULT);
        }

        return $this->db->insert($this->table, [
            'user_id'        => $user_id,
            'secret'         => $secret,
            'is_verified'    => 0,
            'recovery_codes' => json_encode($hashed_codes),
            'failed_attempts'=> 0,
        ]);
    }

    /**
     * Mark TOTP as verified (user successfully scanned QR and entered valid code)
     * 
     * @param int $user_id
     * @return bool
     */
    public function verify_setup($user_id)
    {
        return $this->db->where('user_id', $user_id)
                        ->update($this->table, ['is_verified' => 1]);
    }

    /**
     * Delete TOTP secret (disable 2FA)
     * 
     * @param int $user_id
     * @return bool
     */
    public function delete_secret($user_id)
    {
        return $this->db->where('user_id', $user_id)
                        ->delete($this->table);
    }

    // ─────────────────────────────────────────────────
    //  RATE LIMITING
    // ─────────────────────────────────────────────────

    /**
     * Increment failed attempts counter
     * Auto-lock after 5 failed attempts for 5 minutes
     * 
     * @param int $user_id
     */
    public function increment_failed($user_id)
    {
        $this->db->where('user_id', $user_id)
                 ->set('failed_attempts', 'failed_attempts + 1', FALSE)
                 ->update($this->table);

        // Check if should lock
        $record = $this->get_by_user($user_id);
        if ($record && $record['failed_attempts'] >= 5) {
            $this->db->where('user_id', $user_id)
                     ->update($this->table, [
                         'locked_until' => date('Y-m-d H:i:s', time() + 300) // 5 minutes
                     ]);
        }
    }

    /**
     * Reset failed attempts after successful verification
     * 
     * @param int $user_id
     */
    public function reset_failed($user_id)
    {
        $this->db->where('user_id', $user_id)
                 ->update($this->table, [
                     'failed_attempts' => 0,
                     'locked_until'    => null,
                 ]);
    }

    /**
     * Check if user is locked out
     * 
     * @param int $user_id
     * @return bool|string False if not locked, remaining time string if locked
     */
    public function is_locked($user_id)
    {
        $record = $this->get_by_user($user_id);
        if (!$record || !$record['locked_until']) {
            return false;
        }

        $locked_until = strtotime($record['locked_until']);
        if (time() < $locked_until) {
            $remaining = $locked_until - time();
            $minutes = ceil($remaining / 60);
            return $minutes . ' menit';
        }

        // Lock expired, reset
        $this->reset_failed($user_id);
        return false;
    }

    // ─────────────────────────────────────────────────
    //  RECOVERY CODES
    // ─────────────────────────────────────────────────

    /**
     * Verify a recovery code (one-time use)
     * 
     * @param int $user_id
     * @param string $code Plain-text recovery code
     * @return bool
     */
    public function verify_recovery_code($user_id, $code)
    {
        $record = $this->get_by_user($user_id);
        if (!$record || !$record['recovery_codes']) {
            return false;
        }

        $hashed_codes = json_decode($record['recovery_codes'], true);
        if (!is_array($hashed_codes)) return false;

        foreach ($hashed_codes as $index => $hashed) {
            if (password_verify($code, $hashed)) {
                // Remove used code
                unset($hashed_codes[$index]);
                $this->db->where('user_id', $user_id)
                         ->update($this->table, [
                             'recovery_codes' => json_encode(array_values($hashed_codes))
                         ]);
                return true;
            }
        }

        return false;
    }

    /**
     * Generate random recovery codes
     * 
     * @param int $count Number of codes to generate
     * @return array Plain-text recovery codes
     */
    public function generate_recovery_codes($count = 8)
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            // Generate format: XXXX-XXXX (8 characters)
            $part1 = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
            $part2 = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
            $codes[] = $part1 . '-' . $part2;
        }
        return $codes;
    }
}
