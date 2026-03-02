<?php
require __DIR__.'/../vendor/autoload.php';

// 1. HAPUS CACHE "AMERIKA" (Ini biang kerok 500-nya!)
$cacheDir = __DIR__ . '/../bootstrap/cache';
$staleFiles = ['packages.php', 'services.php', 'config.php', 'routes.php'];
foreach ($staleFiles as $file) {
    if (file_exists($cacheDir . '/' . $file)) {
        @unlink($cacheDir . '/' . $file);
    }
}

// 2. Buat folder sementara yang SAMA PERSIS dengan .env kamu
$tmpPaths = [
    '/tmp/views', // Wajib persis dengan VIEW_COMPILED_PATH
    '/tmp/storage/logs',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views'
];

foreach ($tmpPaths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

// 3. Panggil mesin Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// 4. Paksa Laravel pakai /tmp/
$app->useStoragePath('/tmp/storage');

// 5. Nyalakan website!
$app->handleRequest(Illuminate\Http\Request::capture());