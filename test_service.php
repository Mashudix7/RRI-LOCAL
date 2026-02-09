<?php
define('BASEPATH', 'mock');
define('APPPATH', 'application/');
// Mock CI environment
class MockCI {
    public $config;
    public $cache;
    public $zabbix_api;
    public function __construct() {
        $this->config = new class {
            public function item($k) { 
                if ($k == 'mapping_cache_ttl') return 86400;
                if ($k == 'traffic_cache_ttl') return 60;
                return null;
            }
            public function load($f) {}
        };
        $this->cache = new class { 
            public $data = [];
            public function get($k) { return $this->data[$k] ?? null; }
            public function save($k, $v, $t) { $this->data[$k] = $v; return true; }
            public function delete($k) { unset($this->data[$k]); }
        };
    }
    public function load() { return $this; }
    public function helper($h) {}
    public function library($n, $p=null, $o=null) {}
}

require_once 'application/libraries/Zabbix_api.php';
require_once 'application/libraries/Zabbix_traffic_service.php';

$ci = new MockCI();
$api = new Zabbix_api();
// Manually set properties for Zabbix_api since we don't have real config object behavior
$ref = new ReflectionClass($api);
$prop_url = $ref->getProperty('api_url'); $prop_url->setAccessible(true); $prop_url->setValue($api, 'http://10.30.1.15/zabbix/api_jsonrpc.php');
$prop_token = $ref->getProperty('api_token'); $prop_token->setAccessible(true); $prop_token->setValue($api, '5a528bfad53bd5f00c26213a7dca5025572c7c36b1c0d9c567be9044a14110cb');
$prop_timeout = $ref->getProperty('timeout'); $prop_timeout->setAccessible(true); $prop_timeout->setValue($api, 15);

$ci->zabbix_api = $api;

function get_instance() { global $ci; return $ci; }
function log_message($l, $m) { echo "[$l] $m\n"; }

$service = new Zabbix_traffic_service();
$mapping = $service->get_interface_traffic('10710', 'sfp-sfpplus1-fibernet');

echo "Result:\n";
echo json_encode($mapping, JSON_PRETTY_PRINT);
