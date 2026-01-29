<?php

namespace Cache;

class CacheFactory
{
    public static function create(array $config): CacheInterface
    {
        $driver = $config['driver'] ?? 'file';
        
        if ($driver === 'memory') {
            return new MemoryCache();
        }
        
        $cacheDir = $config['file']['directory'] ?? sys_get_temp_dir() . '/cache';
        $prefix = $config['file']['prefix'] ?? 'cache_';
        
        return new FileCache($cacheDir, $prefix);
    }
}