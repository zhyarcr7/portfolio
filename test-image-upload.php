<?php

// Simple test script to upload an image directly to storage
require 'vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

// Make sure the directory exists
if (!file_exists(storage_path('app/public/hero-slides'))) {
    mkdir(storage_path('app/public/hero-slides'), 0755, true);
}

// Create a test image
$manager = new ImageManager(new Driver());
$img = $manager->create(800, 600)->fill('#ff6600');

// Generate a unique filename
$filename = 'test_' . time() . '.jpg';
$storagePath = 'hero-slides/' . $filename;
$fullPath = storage_path('app/public/' . $storagePath);

// Save directly to the storage directory
$img->encode(new JpegEncoder())->save($fullPath);

echo "Upload test results:\n";
echo "Storage path: {$fullPath}\n";
echo "Public path: {$storagePath}\n";
echo "File exists in storage: " . (file_exists($fullPath) ? 'Yes' : 'No') . "\n";
echo "File exists in public: " . (file_exists(public_path('storage/' . $storagePath)) ? 'Yes' : 'No') . "\n";

// Create directories for storage symlink
$publicTarget = public_path('storage/hero-slides');
if (!file_exists($publicTarget)) {
    mkdir($publicTarget, 0755, true);
}

// Check directory contents
echo "\nFiles in storage/app/public/hero-slides:\n";
$storageFiles = glob(storage_path('app/public/hero-slides/*.*'));
foreach ($storageFiles as $file) {
    echo "- " . basename($file) . "\n";
}

echo "\nFiles in public/storage/hero-slides:\n";
$publicFiles = glob(public_path('storage/hero-slides/*.*'));
if (count($publicFiles) > 0) {
    foreach ($publicFiles as $file) {
        echo "- " . basename($file) . "\n";
    }
} else {
    echo "No files found in public/storage/hero-slides\n";
} 