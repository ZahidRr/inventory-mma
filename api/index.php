<?php

// 1. Paksa environment variable dari dalam kode PHP
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/views';

// 2. Buat folder sementara
if (!file_exists('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

// 3. Teruskan ke Laravel
require __DIR__ . '/../public/index.php';