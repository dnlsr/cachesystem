<?php

namespace Config;

class CacheConfig
{
    private static ?array $config = null;

    public static function load(string $configFile): void
    {
        if (file_exists($configFile)) {
            self::$config = require $configFile;
        }
    }

    public static function get(): array
    {
        if (self::$config === null) {
            return [
                'driver' => 'file',
                'file' => [
                    'directory' => sys_get_temp_dir() . '/cache',
                    'prefix' => 'cache_'
                ]
            ];
        }
        
        return self::$config;
    }
}