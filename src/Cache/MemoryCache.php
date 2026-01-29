<?php

namespace Cache;

class MemoryCache implements CacheInterface
{
    private array $storage = [];

    public function set(string $key, $value, int $ttl = 0): bool
    {
        $this->storage[$key] = [
            'value' => $value,
            'expires' => $ttl > 0 ? time() + $ttl : 0
        ];
        
        return true;
    }

    public function get(string $key)
    {
        if (!isset($this->storage[$key])) {
            return null;
        }
        
        $item = $this->storage[$key];
        
        if ($item['expires'] > 0 && $item['expires'] < time()) {
            unset($this->storage[$key]);
            return null;
        }
        
        return $item['value'];
    }

    public function delete(string $key): bool
    {
        unset($this->storage[$key]);
        return true;
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }
}