<?php

namespace Cache;

class FileCache implements CacheInterface
{
    private string $cacheDir;
    private string $prefix;

    public function __construct(string $cacheDir, string $prefix = 'cache_')
    {
        $this->cacheDir = rtrim($cacheDir, '/') . '/';
        $this->prefix = $prefix;
        
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function set(string $key, $value, int $ttl = 0): bool
    {
        $filename = $this->getFilename($key);
        $data = [
            'value' => $value,
            'expires' => $ttl > 0 ? time() + $ttl : 0
        ];
        
        return file_put_contents($filename, serialize($data)) !== false;
    }

    public function get(string $key)
    {
        $filename = $this->getFilename($key);
        
        if (!file_exists($filename)) {
            return null;
        }
        
        $data = unserialize(file_get_contents($filename));
        
        if ($data === false) {
            return null;
        }
        
        if ($data['expires'] > 0 && $data['expires'] < time()) {
            $this->delete($key);
            return null;
        }
        
        return $data['value'];
    }

    public function delete(string $key): bool
    {
        $filename = $this->getFilename($key);
        
        if (file_exists($filename)) {
            return unlink($filename);
        }
        
        return true;
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    private function getFilename(string $key): string
    {
        return $this->cacheDir . $this->prefix . md5($key) . '.cache';
    }
}