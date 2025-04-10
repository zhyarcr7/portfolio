<?php

/**
 * This file contains a runtime fix for Laravel's LogManager trim(null) deprecation.
 * Include this file at the beginning of your application bootstrap.
 */

// Load Composer's autoloader
require __DIR__.'/vendor/autoload.php';

// Create directory for our app if it doesn't exist
if (!is_dir(__DIR__.'/app/Patches')) {
    mkdir(__DIR__.'/app/Patches', 0755, true);
}

// Create a patched version of LogManager
file_put_contents(__DIR__.'/app/Patches/FixedLogManager.php', '<?php

namespace App\Patches;

use Illuminate\Contracts\Foundation\Application;

class FixedLogManager extends \Illuminate\Log\LogManager
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Parse the driver name.
     *
     * @param  string|null  $driver
     * @return string
     */
    protected function parseDriver($driver)
    {
        $driver ??= $this->getDefaultDriver();
        
        if ($this->app->runningUnitTests()) {
            $driver ??= \'null\';
        }
        
        // Fix: Ensure we have a string before trimming
        return is_string($driver) ? trim($driver) : (string) $driver;
    }
}
');

// Replace Laravel's LogManager with our fixed version
$app = require_once __DIR__.'/bootstrap/app.php';

// Replace the log binding
$app->singleton('log', function ($app) {
    return new \App\Patches\FixedLogManager($app);
});

// Continue with normal bootstrapping
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response); 