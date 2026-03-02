<?php
require __DIR__.'/../vendor/autoload.php';

// 1. Bikin semua folder yang dibutuhkan Laravel di dalam /tmp/ (satu-satunya tempat yang tidak dikunci Vercel)
$tmpStorage = '/tmp/storage';
$paths = [
    "$tmpStorage/framework/views",
    "$tmpStorage/framework/cache/data",
    "$tmpStorage/framework/sessions",
    "$tmpStorage/logs"
];

foreach ($paths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

// 2. Panggil mesin Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// 3. Paksa Laravel pakai folder /tmp/ yang sudah kita buat
$app->useStoragePath($tmpStorage);

// 4. Nyalakan website!
$app->handleRequest(Illuminate\Http\Request::capture());