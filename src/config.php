<?php

// @codeCoverageIgnoreStart

return [
    'access_token' => \env('INSTAGRAM_ACCESS_TOKEN'),
    'cache'        => [
        'strategy' => 'force-cache',
        'ttl'      => 3600,
        'driver'   => \env('INSTAGRAM_CACHE_DRIVER', 'file')
    ]
];

// @codeCoverageIgnoreEnd
