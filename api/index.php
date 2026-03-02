<?php

// 1. BAJAK JALUR CACHE (Bypass Vercel Build Cache)
// Kita paksa Laravel mengabaikan cache rusak dengan mengalihkan semua jalurnya ke /tmp/
$caches = [
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_CONFIG_CACHE'   => '/tmp/config.php',
    'APP_ROUTES_CACHE'   => '/tmp/routes.php',
    'APP_EVENTS_CACHE'   => '/tmp/events.php',
    'VIEW_COMPILED_PATH' => '/tmp/views',
];

foreach ($caches as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// 2. SIAPKAN RUANG SEMENTARA
$tmpStorage = '/tmp/storage';
$paths = [
    '/tmp/views',
    "$tmpStorage/logs",
    "$tmpStorage/framework/cache/data",
    "$tmpStorage/framework/sessions",
    "$tmpStorage/framework/views"
];

foreach ($paths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

// 3. JALANKAN LARAVEL
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// 4. PAKSA PAKAI /tmp/
$app->useStoragePath($tmpStorage);

// 5. NYALAKAN WEBSITE
$app->handleRequest(Illuminate\Http\Request::capture());