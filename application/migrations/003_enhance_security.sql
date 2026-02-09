-- =====================================================
-- Complete Security Enhancement Migration
-- =====================================================
-- Purpose: Ensure all required columns exist and add security features
-- Date: 2026-01-23

-- Step 1: Ensure base columns exist in users table
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'last_activity');
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE users ADD COLUMN last_activity DATETIME NULL AFTER last_login',
    'SELECT "Column last_activity already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 2: Add session index
SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'ci_sessions' AND index_name = 'idx_timestamp');
SET @sql = IF(@index_exists = 0, 
    'ALTER TABLE ci_sessions ADD INDEX idx_timestamp (timestamp)',
    'SELECT "Index idx_timestamp already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 3: Enhance audit_logs table
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
WHERE table_schema = DATABASE() AND table_name = 'audit_logs' AND column_name = 'request_method');
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE audit_logs 
    ADD COLUMN request_method VARCHAR(10) AFTER action,
    ADD COLUMN request_uri VARCHAR(255) AFTER request_method,
    ADD COLUMN response_code INT AFTER user_agent,
    ADD COLUMN execution_time FLOAT AFTER response_code',
    'SELECT "audit_logs columns already exist" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 4: Add security columns to users table
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'failed_login_attempts');
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE users ADD COLUMN failed_login_attempts INT DEFAULT 0 AFTER last_activity',
    'SELECT "Column failed_login_attempts already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'account_locked_until');
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE users ADD COLUMN account_locked_until DATETIME NULL AFTER failed_login_attempts',
    'SELECT "Column account_locked_until already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'login_ip');
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE users ADD COLUMN login_ip VARCHAR(45) NULL AFTER account_locked_until',
    'SELECT "Column login_ip already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 5: Add performance indexes
SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'audit_logs' AND index_name = 'idx_created_user');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE audit_logs ADD INDEX idx_created_user (created_at, user_id)',
    'SELECT "Index idx_created_user already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'audit_logs' AND index_name = 'idx_action');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE audit_logs ADD INDEX idx_action (action)',
    'SELECT "Index idx_action already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'users' AND index_name = 'idx_username');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE users ADD INDEX idx_username (username)',
    'SELECT "Index idx_username already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'articles' AND index_name = 'idx_status_published');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE articles ADD INDEX idx_status_published (status, published_at)',
    'SELECT "Index idx_status_published already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'articles' AND index_name = 'idx_category');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE articles ADD INDEX idx_category (category)',
    'SELECT "Index idx_category already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'articles' AND index_name = 'idx_author');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE articles ADD INDEX idx_author (author_id)',
    'SELECT "Index idx_author already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'teams' AND index_name = 'idx_division_active');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE teams ADD INDEX idx_division_active (division, is_active)',
    'SELECT "Index idx_division_active already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists = (SELECT COUNT(*) FROM information_schema.statistics 
WHERE table_schema = DATABASE() AND table_name = 'teams' AND index_name = 'idx_display_order');
SET @sql = IF(@index_exists = 0,
    'ALTER TABLE teams ADD INDEX idx_display_order (display_order)',
    'SELECT "Index idx_display_order already exists" AS msg');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 6: Create login_history table
CREATE TABLE IF NOT EXISTS login_history (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    attempt_time DATETIME NOT NULL,
    success TINYINT(1) NOT NULL DEFAULT 0,
    failure_reason VARCHAR(255),
    INDEX idx_username_time (username, attempt_time),
    INDEX idx_ip_time (ip_address, attempt_time),
    INDEX idx_attempt_time (attempt_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Step 7: Add security settings
INSERT IGNORE INTO settings (setting_key, setting_value, setting_group, input_type) VALUES
('session_timeout', '7200', 'security', 'number'),
('max_login_attempts', '5', 'security', 'number'),
('login_lockout_duration', '900', 'security', 'number'),
('enable_2fa', '0', 'security', 'toggle'),
('password_min_length', '8', 'security', 'number'),
('password_require_uppercase', '1', 'security', 'toggle'),
('password_require_number', '1', 'security', 'toggle'),
('password_require_special', '1', 'security', 'toggle');
