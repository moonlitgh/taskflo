<?php
// Script untuk memeriksa dan memperbaiki izin file
$directories = [
    'storage',
    'bootstrap/cache',
    'public/storage'
];

foreach ($directories as $directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }
    
    // Set permissions
    chmod($directory, 0755);
    
    // Recursively set permissions for files
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $item) {
        if ($item->isDir()) {
            chmod($item->getPathname(), 0755);
        } else {
            chmod($item->getPathname(), 0644);
        }
    }
}

echo "Permissions have been set successfully!";
?> 