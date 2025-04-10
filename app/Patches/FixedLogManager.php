<?php

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
            $driver ??= 'null';
        }
        
        // Fix: Ensure we have a string before trimming
        return is_string($driver) ? trim($driver) : (string) $driver;
    }
} 