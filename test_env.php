<?php
define('BASEPATH', '1');
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require_once 'application/helpers/env_helper.php';

echo "DB_HOST: " . env('DB_HOST', 'FAILED') . "\n";
echo "DB_USER: " . env('DB_USER', 'FAILED') . "\n";
echo "DB_PASS: " . env('DB_PASS', 'FAILED') . "\n";
echo "DB_NAME: " . env('DB_NAME', 'FAILED') . "\n";
echo "APP_BASE_URL: " . env('APP_BASE_URL', 'FAILED') . "\n";
