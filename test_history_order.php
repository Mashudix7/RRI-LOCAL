<?php
$token = '5a528bfad53bd5f00c26213a7dca5025572c7c36b1c0d9c567be9044a14110cb';
$itemid = '423546';

function get_hist($itemid, $order, $token) {
    $payload = json_encode([
        'jsonrpc' => '2.0',
        'method'  => 'history.get',
        'params'  => [
            'itemids' => [$itemid],
            'history' => 3,
            'sortfield' => 'clock',
            'sortorder' => $order,
            'limit' => 5
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

    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

echo "--- ASC (Oldest) ---\n";
$asc = get_hist($itemid, 'ASC', $token);
if (isset($asc['result'])) {
    foreach ($asc['result'] as $r) echo $r['clock'] . " : " . $r['value'] . "\n";
}

echo "\n--- DESC (Newest) ---\n";
$desc = get_hist($itemid, 'DESC', $token);
if (isset($desc['result'])) {
    foreach ($desc['result'] as $r) echo $r['clock'] . " : " . $r['value'] . "\n";
}
