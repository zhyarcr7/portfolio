<?php

/**
 * This file contains a patch for the LogManager class to fix the trim(null) deprecation warning.
 * It needs to be included at application startup before the LogManager is instantiated.
 */

// Only apply the fix if the original class exists
if (class_exists('Illuminate\Log\LogManager') && !class_exists('Illuminate\Log\LogManager_Original')) {
    // Rename the original class to LogManager_Original
    class_alias('Illuminate\Log\LogManager', 'Illuminate\Log\LogManager_Original');
    
    // Create a new class with the same name that extends the original
    namespace Illuminate\Log;
    
    class LogManager extends \Illuminate\Log\LogManager_Original
    {
        /**
         * Parse the driver name.
         *
         * @param  string|null  $driver
         * @return string|null
         */
        protected function parseDriver($driver)
        {
            $driver ??= $this->getDefaultDriver();
            
            if ($this->app->runningUnitTests()) {
                $driver ??= 'null';
            }
            
            // Fix: ensure driver is a string before trimming
            return $driver !== null ? trim($driver) : '';
        }
    }
} 