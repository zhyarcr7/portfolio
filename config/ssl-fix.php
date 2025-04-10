<?php
// Configure PHP to use a specific CA bundle (useful for Windows environments)
// Only do this in non-production environments
if (!env('PUSHER_VERIFY_SSL', true)) {
    // This effectively disables SSL verification
    ini_set('curl.cainfo', __DIR__ . '/../storage/ca-bundle.crt');
    
    // Set the OpenSSL configuration to use our CA bundle
    putenv('SSL_CERT_FILE=' . __DIR__ . '/../storage/ca-bundle.crt');
} 