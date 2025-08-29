<?php

return [
    'base_url'         => env('ZIPPOPOTAM_BASE_URL', 'https://api.zippopotam.us'),
    'country'          => env('ZIPPOPOTAM_COUNTRY', 'de'),
    'timeout'          => (int) env('ZIPPOPOTAM_TIMEOUT', 5),
    'cache_ttl'        => (int) env('ZIPPOPOTAM_CACHE_TTL', 21600),
    'enable_api_route' => (bool) env('BUNDESLAND_ENABLE_API', false),
];
