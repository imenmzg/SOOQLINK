<?php
/**
 * Health Check Endpoint
 * Visit: https://sooqlink.onrender.com/health.php
 */

header('Content-Type: application/json');

$health = [
    'status' => 'ok',
    'checks' => []
];

// Check PHP version
$health['checks']['php_version'] = [
    'status' => version_compare(PHP_VERSION, '8.3.0', '>=') ? 'ok' : 'fail',
    'value' => PHP_VERSION
];

// Check if .env exists
$health['checks']['env_file'] = [
    'status' => file_exists(__DIR__ . '/../.env') ? 'ok' : 'fail',
    'value' => file_exists(__DIR__ . '/../.env') ? 'exists' : 'missing'
];

// Check storage permissions
$storagePath = __DIR__ . '/../storage';
$health['checks']['storage'] = [
    'status' => is_writable($storagePath) ? 'ok' : 'fail',
    'value' => is_writable($storagePath) ? 'writable' : 'not writable'
];

// Check bootstrap cache
$bootstrapPath = __DIR__ . '/../bootstrap/cache';
$health['checks']['bootstrap'] = [
    'status' => is_writable($bootstrapPath) ? 'ok' : 'fail',
    'value' => is_writable($bootstrapPath) ? 'writable' : 'not writable'
];

// Try to load Laravel
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    $health['checks']['laravel'] = ['status' => 'ok', 'value' => 'loaded'];
    
    // Check APP_KEY
    $key = env('APP_KEY');
    $health['checks']['app_key'] = [
        'status' => !empty($key) ? 'ok' : 'fail',
        'value' => !empty($key) ? 'set' : 'missing'
    ];
    
    // Check database connection
    try {
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        $db = $app->make('db');
        $db->connection()->getPdo();
        $health['checks']['database'] = ['status' => 'ok', 'value' => 'connected'];
    } catch (Exception $e) {
        $health['checks']['database'] = [
            'status' => 'fail',
            'value' => 'error: ' . $e->getMessage()
        ];
    }
    
} catch (Exception $e) {
    $health['checks']['laravel'] = [
        'status' => 'fail',
        'value' => 'error: ' . $e->getMessage()
    ];
}

// Overall status
$allOk = true;
foreach ($health['checks'] as $check) {
    if ($check['status'] !== 'ok') {
        $allOk = false;
        break;
    }
}

$health['status'] = $allOk ? 'ok' : 'fail';

http_response_code($allOk ? 200 : 500);
echo json_encode($health, JSON_PRETTY_PRINT);

