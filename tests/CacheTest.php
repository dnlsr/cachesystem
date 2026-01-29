<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Cache\FileCache;
use Cache\MemoryCache;

$fileCache = new FileCache(sys_get_temp_dir() . '/test_cache');

$fileCache->set('key', 'value', 2);
echo $fileCache->get('key') === 'value' ? 'ok ' : 'fail';

sleep(3);
echo $fileCache->get('key') === null ? 'ok ' : 'fail';

$memoryCache = new MemoryCache();
$memoryCache->set('key', 'value', 2);
echo $memoryCache->get('key') === 'value' ? 'ok ' : 'fail';

sleep(3);
echo $memoryCache->get('key') === null ? 'ok' : 'fail';