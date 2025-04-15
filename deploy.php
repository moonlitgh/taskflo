<?php
// Script untuk membantu proses deployment
echo "Starting deployment process...\n";

// 1. Clear cache
echo "Clearing cache...\n";
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/services.php',
    'storage/framework/cache/*',
    'storage/framework/views/*',
    'storage/framework/sessions/*'
];

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        if (is_dir($file)) {
            array_map('unlink', glob($file));
        } else {
            unlink($file);
        }
    }
}

// 2. Create storage link
echo "Creating storage link...\n";
if (!file_exists('public/storage')) {
    symlink('../storage/app/public', 'public/storage');
}

// 3. Set permissions
echo "Setting permissions...\n";
require_once 'check-permissions.php';

// 4. Generate application key if not exists
echo "Checking application key...\n";
$envFile = '.env';
if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    if (strpos($envContent, 'APP_KEY=') === false) {
        $key = 'base64:' . base64_encode(random_bytes(32));
        file_put_contents($envFile, "\nAPP_KEY=$key", FILE_APPEND);
        echo "New application key generated.\n";
    }
}

echo "Deployment process completed!\n";
?> 