<?php
$token = '5a528bfad53bd5f00c26213a7dca5025572c7c36b1c0d9c567be9044a14110cb';
$payload = json_encode([
    'jsonrpc' => '2.0',
    'method'  => 'item.get',
    'params'  => [
        'hostids' => '10710',
        'search' => ['name' => '*sfp-sfpplus1-fibernet*'],
        'output' => ['itemid', 'name'],
        'searchWildcardsEnabled' => true
    ],
    'auth'    => $token,
    'id'      => 1
]);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://10.30.1.15/zabbix/api_jsonrpc.php',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_TIMEOUT => 5,
    CURLOPT_SSL_VERIFYPEER => false,
]);

echo curl_exec($ch);
