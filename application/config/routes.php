<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
/**
 * =====================================================
 * CSIRT RRI Routes Configuration
 * =====================================================
 * 
 * Komentar: Konfigurasi routing aplikasi
 * - Landing pages untuk company profile
 * - Auth routes untuk autentikasi
 * - Dashboard/Admin routes (akan ditambahkan)
 * =====================================================
 */

// Default controller - Landing page
$route['default_controller'] = 'landing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// =====================================================
// Landing Page Routes (Public)
// =====================================================
$route['tentang'] = 'landing/tentang';
$route['tim'] = 'landing/tim';
$route['kontak'] = 'landing/kontak';

// =====================================================
// Article Routes (Public)
// =====================================================
$route['artikel'] = 'artikel/index';
$route['artikel/kategori/(:any)'] = 'artikel/index/$1';
$route['artikel/detail/(:num)'] = 'artikel/detail/$1';
$route['artikel/(:num)'] = 'artikel/detail/$1';

// =====================================================
// Auth Routes
// =====================================================
$route['auth'] = 'auth/login';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';

// =====================================================
// Dashboard Routes (Protected)
// =====================================================
$route['dashboard'] = 'dashboard/index';

// =====================================================
// Admin Routes (Protected - Admin Only)
// =====================================================
$route['admin/dashboard'] = 'admin/index';
$route['admin/profile'] = 'admin/profile';

$route['admin/users'] = 'admin/users';
$route['admin/users/(:any)'] = 'admin/users/$1';

$route['admin/articles'] = 'admin/articles';
$route['admin/articles/(:any)'] = 'admin/articles/$1';

$route['admin/teams'] = 'admin/teams';
$route['admin/teams/(:any)'] = 'admin/teams/$1';

// Server Credentials
$route['admin/server_credentials'] = 'server_credentials/index';
$route['admin/server_credentials/unlock'] = 'server_credentials/unlock';
$route['admin/server_credentials/lock'] = 'server_credentials/lock';
$route['admin/server_credentials/setup_totp'] = 'server_credentials/setup_totp';
$route['admin/server_credentials/verify_totp_setup'] = 'server_credentials/verify_totp_setup';
$route['admin/server_credentials/reset_totp'] = 'server_credentials/reset_totp';
$route['admin/server_credentials/create'] = 'server_credentials/create';
$route['admin/server_credentials/store'] = 'server_credentials/store';
$route['admin/server_credentials/edit/(:any)'] = 'server_credentials/edit/$1';
$route['admin/server_credentials/update/(:any)'] = 'server_credentials/update/$1';
$route['admin/server_credentials/delete/(:any)'] = 'server_credentials/delete/$1';

$route['admin/ip-management'] = 'admin/ip_management';

// Specific IP/Network CRUD Routes - MUST be before generic (:any)
$route['admin/ip_management/networks'] = 'admin/networks'; // Handle the link currently in UI
$route['admin/ip_management/network_create'] = 'admin/network_create';
$route['admin/ip_management/network_store'] = 'admin/network_store';
$route['admin/ip_management/network_edit/(:any)'] = 'admin/network_edit/$1';
$route['admin/ip_management/network_update/(:any)'] = 'admin/network_update/$1';
$route['admin/ip_management/network_delete/(:any)'] = 'admin/network_delete/$1';

$route['admin/ip_edit/(:any)'] = 'admin/ip_edit/$1';
$route['admin/ip_update'] = 'admin/ip_update';

$route['admin/ip-management/(:any)'] = 'admin/ip_management/$1';
$route['admin/ip-private'] = 'admin/ip_private';
$route['admin/vpn-management'] = 'vpn_management';
$route['admin/vpn-management/index'] = 'vpn_management/index';
$route['admin/vpn-management/create'] = 'vpn_management/create';
$route['admin/vpn-management/store'] = 'vpn_management/store';
$route['admin/vpn-management/edit/(:any)'] = 'vpn_management/edit/$1';
$route['admin/vpn-management/update/(:any)'] = 'vpn_management/update/$1';
$route['admin/vpn-management/delete/(:any)'] = 'vpn_management/delete/$1';
$route['admin/vpn-management/export'] = 'vpn_management/export';
$route['admin/reports'] = 'admin/reports';
$route['admin/audit'] = 'admin/audit_log';
$route['admin/audit-log'] = 'admin/audit_log';

// Zabbix Traffic API Routes
$route['admin/traffic/get/(:any)/(:any)'] = 'admin/traffic/get/$1/$2';
$route['admin/traffic/get/(:any)'] = 'admin/traffic/get/$1';
$route['admin/traffic/get'] = 'admin/traffic/get';
$route['admin/traffic/hosts'] = 'admin/traffic/hosts';
$route['admin/traffic/items/(:any)/(:any)'] = 'admin/traffic/items/$1/$2';

// =====================================================
// Infrastructure Routes
// =====================================================
// Network
$route['admin/network-traffic-mrtg'] = 'admin/network_traffic_mrtg';
$route['admin/network-traffic-ap'] = 'admin/network_traffic_ap';

// Data Center
$route['admin/datacenter-resource-server'] = 'admin/datacenter_resource_server';
$route['admin/datacenter-traffic-vm'] = 'admin/datacenter_traffic_vm';

// Security
$route['admin/security-waf-activity'] = 'admin/security_waf_activity';
$route['admin/security-fortigate'] = 'admin/security_fortigate';
$route['admin/security-safeline'] = 'admin/security_safeline';

// Satellite
$route['admin/satellite-starlink'] = 'admin/satellite_starlink';
$route['admin/satellite-broadcast-audio'] = 'admin/satellite_broadcast_audio';

