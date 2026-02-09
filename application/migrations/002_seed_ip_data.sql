-- 1. Create Networks Table
CREATE TABLE IF NOT EXISTS `networks` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `cidr` VARCHAR(45) NOT NULL,
    `range_start` VARCHAR(45) NOT NULL,
    `range_end` VARCHAR(45) NOT NULL,
    `subnet_mask` VARCHAR(45),
    `description` TEXT,
    `is_reserve` BOOLEAN DEFAULT FALSE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Modify IP Addresses Table
-- Add network_id and ensure enums are correct
ALTER TABLE `ip_addresses` 
ADD COLUMN `network_id` INT,
ADD CONSTRAINT `fk_ip_network` FOREIGN KEY (`network_id`) REFERENCES `networks`(`id`) ON DELETE CASCADE;

ALTER TABLE `ip_addresses` MODIFY COLUMN `type` ENUM('public', 'private', 'local', 'vpn', 'gateway') NOT NULL DEFAULT 'public';
ALTER TABLE `ip_addresses` MODIFY COLUMN `status` ENUM('active', 'inactive') DEFAULT 'active'; -- Active = Used/Online, Inactive = Unused/Offline

-- 3. Seed Networks (From ip_networks.json)
INSERT INTO `networks` (`slug`, `name`, `cidr`, `range_start`, `range_end`, `subnet_mask`, `description`, `is_reserve`) VALUES
('jakarta', 'Data Center Jakarta', '218.33.123.0/26', '218.33.123.0', '218.33.123.63', '255.255.255.192', 'Core Network', 0),
('serpong', 'DC PDN Serpong', '218.33.123.64/26', '218.33.123.64', '218.33.123.127', '255.255.255.192', 'Disaster Recovery (DRC)', 0),
('pusat', 'DC Kantor Pusat', '218.33.123.128/27', '218.33.123.128', '218.33.123.159', '255.255.255.224', 'Headquarters', 0),
('reserve1', 'Network Cadangan 1', '218.33.123.160/28', '218.33.123.160', '218.33.123.175', '255.255.255.240', 'Dapat digunakan untuk: IP Transit', 1),
('reserve2', 'Network Cadangan 2', '218.33.123.176/28', '218.33.123.176', '218.33.123.191', '255.255.255.240', 'Future DC / Event / Kebutuhan Dadakan', 1),
('depok', 'DC Depok', '218.33.123.192/26', '218.33.123.192', '218.33.123.255', '255.255.255.192', 'Data Center', 0);

-- 4. Seed IP Addresses (From Admin.php)
-- Helper to insert IP with conditional status
-- Note: We only insert USED/NAMED IPs for now. The application logic can either generate the rest on the fly or we seed ALL possible IPs.
-- For "Total IP Public" stats, it's better to verify if we want to store ALL IPs or just used ones.
-- User said: "Data yg sebelumnya hardcode dijadikan data yg diintregasikan di database".
-- The hardcoded view generates ALL IPs in the range.
-- Strategy: We will insert the KNOWN (Used) IPs.
-- The application logic will need to handle "Available" IPs either by counting theoretical max - count(used) OR by checking if IP exists in DB.
-- However, user wants "for unused -> inactive". It implies row existence.
-- Ideally we should seed ALL IPs in the subnet. But that's 256 rows. Cheap. Let's do explicit inserts for the ones with descriptions.

-- JAKARTA (ID 1)
INSERT INTO `ip_addresses` (`network_id`, `ip_address`, `description`, `type`, `status`) VALUES
(1, '218.33.123.1', 'Gateway', 'gateway', 'active'),
(1, '218.33.123.2', 'Internet DNS Server Lokal', 'public', 'active'),
(1, '218.33.123.3', 'Internet Aplikasi NextCloud', 'public', 'active'),
(1, '218.33.123.4', 'Aplikasi AudioLibrary', 'public', 'active'),
(1, '218.33.123.5', 'Internet PPID RRI', 'public', 'active'),
(1, '218.33.123.6', 'Aplikasi Simpatik (PT. Novarya)', 'public', 'active'),
(1, '218.33.123.7', 'Aplikasi Drive Cloud', 'public', 'active'),
(1, '218.33.123.8', 'WAF-Jakarta', 'public', 'active'),
(1, '218.33.123.9', 'Pro 1 Streaming', 'public', 'active'),
(1, '218.33.123.10', 'Pro 2 Streaming', 'public', 'active'),
(1, '218.33.123.11', 'Pro 4 Streaming', 'public', 'active'),
(1, '218.33.123.12', 'Streaming Sentral', 'public', 'active'),
(1, '218.33.123.13', 'Aplikasi Logger NEW', 'public', 'active'),
(1, '218.33.123.14', 'GL Audio Streaming', 'public', 'active'),
(1, '218.33.123.15', 'SIP Server Lama', 'public', 'active'),
(1, '218.33.123.16', 'Zabbix All NMS', 'public', 'active'),
(1, '218.33.123.17', 'Aplikasi Meeting TMB', 'public', 'active'),
(1, '218.33.123.18', 'Aplikasi Video GL', 'public', 'active'),
(1, '218.33.123.19', 'Omada Controller', 'public', 'active'),
(1, '218.33.123.20', 'Aplikasi Sisporja NEW', 'public', 'active'),
(1, '218.33.123.21', 'Unify Controller Pusat', 'public', 'active'),
(1, '218.33.123.22', 'DC JKT Cloud Proxmox VE', 'public', 'active'),
(1, '218.33.123.23', 'Aplikasi DAP & MEDIA', 'public', 'active'),
(1, '218.33.123.24', 'Intranet JKT', 'public', 'active'),
(1, '218.33.123.25', 'Aplikasi Supporting Server', 'public', 'active'),
(1, '218.33.123.26', 'IP PUBLIK NEW PRO 1', 'public', 'active'),
(1, '218.33.123.27', 'IP PUBLIK NEW PRO 2', 'public', 'active'),
(1, '218.33.123.28', 'IP PUBLIK NEW PRO 4', 'public', 'active'),
(1, '218.33.123.29', 'Global Media Academy', 'public', 'active'),
(1, '218.33.123.30', 'Aplikasi Presensi Mobile API Node JS', 'public', 'active'),
(1, '218.33.123.31', 'Aplikasi PNBP NEW', 'public', 'active'),
(1, '218.33.123.32', 'Aplikasi PNet Lab', 'public', 'active'),
(1, '218.33.123.33', 'IoT Siaga', 'public', 'active'),
(1, '218.33.123.34', 'IP Extend Portal Berita RRI', 'public', 'active'),
(1, '218.33.123.35', 'IP Private-Streaming Video', 'public', 'active'),
(1, '218.33.123.36', 'Aplikasi Mail Corporate (rri.co.id)', 'public', 'active'),
(1, '218.33.123.37', 'Aplikasi Mail Gateway Corporate (rri.co.id)', 'public', 'active'),
(1, '218.33.123.38', 'Aplikasi E-Learning MBC', 'public', 'active'),
(1, '218.33.123.39', 'Aplikasi WAZUH SOC', 'public', 'active'),
(1, '218.33.123.40', 'DevOps', 'public', 'active'),
(1, '218.33.123.41', 'RRI Digital 1', 'public', 'active'),
(1, '218.33.123.42', 'RRI Digital 2', 'public', 'active'),
(1, '218.33.123.43', 'RRI Digital 3', 'public', 'active'),
(1, '218.33.123.44', 'S3 RRI Digital', 'public', 'active'),
(1, '218.33.123.45', 'NextCloud Collabora', 'public', 'active'),
(1, '218.33.123.46', 'Docker Swarm', 'public', 'active'),
(1, '218.33.123.47', 'My-Presensi Terbaru (PT. TKM)', 'public', 'active'),
(1, '218.33.123.48', 'LB My-Presensi Terbaru (PT. TKM)', 'public', 'active'),
(1, '218.33.123.49', 'MinIO My-Presensi Terbaru (PT. TKM)', 'public', 'active'),
(1, '218.33.123.50', 'JDIH Nginx', 'public', 'active'),
(1, '218.33.123.51', 'Codec Backup', 'public', 'active'),
(1, '218.33.123.52', 'H3C', 'public', 'active'),
(1, '218.33.123.53', 'Aplikasi DIAS', 'public', 'active'),
(1, '218.33.123.54', 'IP Router Firewall DC Jakarta', 'public', 'active'),
(1, '218.33.123.56', 'TrueNas', 'public', 'active'),
(1, '218.33.123.57', 'internet Gedung Sebelah (sebelumnya digunakan LPU)', 'public', 'active'),
(1, '218.33.123.58', 'CMS Portal', 'public', 'active'),
(1, '218.33.123.59', 'Front Portal', 'public', 'active'),
(1, '218.33.123.60', 'Server API Portal', 'public', 'active');

-- SERPONG (ID 2)
INSERT INTO `ip_addresses` (`network_id`, `ip_address`, `description`, `type`, `status`) VALUES
(2, '218.33.123.65', 'Gateway', 'gateway', 'active'),
(2, '218.33.123.66', 'IP Router 1', 'public', 'active'),
(2, '218.33.123.67', 'IP Router 2', 'public', 'active'),
(2, '218.33.123.68', 'IP Server', 'public', 'active'),
(2, '218.33.123.69', 'IP API Portal', 'public', 'active'),
(2, '218.33.123.70', 'IP CMS Portal', 'public', 'active'),
(2, '218.33.123.71', 'IP Frontend Portal', 'public', 'active'),
(2, '218.33.123.72', 'IP Pro 1 Streaming', 'public', 'active'),
(2, '218.33.123.73', 'IP Pro 2 Streaming', 'public', 'active'),
(2, '218.33.123.74', 'IP Pro 4 Streaming', 'public', 'active'),
(2, '218.33.123.75', 'IP WAF DC PDN Serpong', 'public', 'active'),
(2, '218.33.123.76', 'IP S3 Portal', 'public', 'active');

-- PUSAT (ID 3)
INSERT INTO `ip_addresses` (`network_id`, `ip_address`, `description`, `type`, `status`) VALUES
(3, '218.33.123.129', 'Gateway', 'gateway', 'active'),
(3, '218.33.123.130', 'IP Firewall Kantor Pusat', 'public', 'active'),
(3, '218.33.123.131', 'IP Router Kantor Pusat', 'public', 'active');

-- DEPOK (ID 6 - Note ID 4,5 are reserves)
INSERT INTO `ip_addresses` (`network_id`, `ip_address`, `description`, `type`, `status`) VALUES
(6, '218.33.123.193', 'Gateway', 'gateway', 'active'),
(6, '218.33.123.194', 'Internet Semua Perangkat DC MBC', 'public', 'active'),
(6, '218.33.123.195', 'Aplikasi Manajemen IP', 'public', 'active'),
(6, '218.33.123.196', 'Aplikasi Pusdatin NEW', 'public', 'active'),
(6, '218.33.123.197', 'Aplikasi JDIH NEW', 'public', 'active'),
(6, '218.33.123.198', 'IP Internet Server Aplikasi E-Learning MBC', 'public', 'active'),
(6, '218.33.123.199', 'IP Internet Server Docker MBC', 'public', 'active'),
(6, '218.33.123.200', 'T-Track Pemancar', 'public', 'active'),
(6, '218.33.123.201', 'IP Publik Email Corporate RRI (rri.go.id)', 'public', 'active'),
(6, '218.33.123.202', 'Aplikasi DRM Proxy', 'public', 'active'),
(6, '218.33.123.203', 'Aplikasi WAF MBC', 'public', 'active'),
(6, '218.33.123.204', 'Aplikasi Jenkins Git Docker', 'public', 'active'),
(6, '218.33.123.205', 'IP Router Core Operasional', 'public', 'active'),
(6, '218.33.123.206', 'IP Publik-Streaming Video', 'public', 'active'),
(6, '218.33.123.207', 'IP Aplikasi Logger NEW', 'public', 'active'),
(6, '218.33.123.208', 'IP Aplikasi Simpatik (PT. Novarya)', 'public', 'active'),
(6, '218.33.123.209', 'IP My-Presensi Terbaru (PT. TKM)', 'public', 'active'),
(6, '218.33.123.210', 'IP LB My-Presensi Terbaru (PT. TKM)', 'public', 'active'),
(6, '218.33.123.211', 'IP MinIO My-Presensi Terbaru (PT. TKM)', 'public', 'active'),
(6, '218.33.123.212', 'IP Aplikasi Presensi Mobile API Node JS', 'public', 'active');
