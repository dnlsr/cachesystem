<?php

namespace Cache;

interface CacheInterface
{
    public function set(string $key, $value, int $ttl = 0): bool;
    
    public function get(string $key);
    
    public function delete(string $key): bool;
    
    public function has(string $key): bool;
}