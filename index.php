<?php

require_once __DIR__ . '/vendor/autoload.php';

use Cache\CacheFactory;
use Config\CacheConfig;

CacheConfig::load(__DIR__ . '/config/cache.php');

$cache = CacheFactory::create(CacheConfig::get());

$cache->set('test', 'данные', 10);
echo $cache->get('test');

if ($cache->has('test')) {
    echo ' есть в кэше';
}

$cache->delete('test');