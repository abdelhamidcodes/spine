<?php

use System\Support\Text;
use System\Container\Path;
use Illuminate\Support\Env;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    | Supported: "apc", "array", "database", "file",
    |            "memcached", "redis", "dynamodb"
    |
    */

    'default' => Env::get('CACHE_DRIVER', 'redis'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    */

    'stores' => [

        'array' => [
            'driver'    => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver'          => 'database',
            'table'           => 'cache',
            'connection'      => null,
            'lock_connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path'   => Path::storage('framework/cache/data'),
        ],

        'redis' => [
            'driver'          => 'redis',
            'connection'      => 'cache',
            'lock_connection' => 'default',
        ],

        'dynamodb' => [
            'driver'   => 'dynamodb',
            'key'      => Env::get('AWS_ACCESS_KEY_ID'),
            'secret'   => Env::get('AWS_SECRET_ACCESS_KEY'),
            'region'   => Env::get('AWS_DEFAULT_REGION', 'us-east-1'),
            'table'    => Env::get('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => Env::get('DYNAMODB_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM based store such as APC or Memcached, there might
    | be other applications utilizing the same cache. So, we'll specify a
    | value to get prefixed to all our keys so we can avoid collisions.
    |
    */

    'prefix' => Env::get('CACHE_PREFIX', Text::slug(Env::get('APP_NAME'), '_').'_cache_'),

];
