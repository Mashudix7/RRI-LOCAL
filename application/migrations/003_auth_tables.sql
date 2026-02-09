-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL, -- bcrypt hash
  `email` varchar(100) NOT NULL,
  `role` enum('admin','management','auditor') NOT NULL DEFAULT 'auditor',
  `avatar` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Audit Logs Table
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL, -- Denormalized for preservation
  `role` varchar(20) DEFAULT NULL,
  `action` varchar(50) NOT NULL, -- e.g., 'login', 'create_user', 'update_ip'
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Default Users
-- Passwords are 'password123' hashed with BCRYPT
-- Use https://bcrypt.online/ or PHP password_hash('password123', PASSWORD_BCRYPT) to verify/generate
-- Admin: admin / password123
-- Management: manager / password123
-- Auditor: auditor / password123

INSERT INTO `users` (`username`, `password`, `email`, `role`, `avatar`, `created_at`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@rri.co.id', 'admin', 'default_avatar.png', NOW()),
('manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager@rri.co.id', 'management', 'default_avatar.png', NOW()),
('auditor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'auditor@rri.co.id', 'auditor', 'default_avatar.png', NOW());
