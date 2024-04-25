<?php

declare(strict_types=1);

return [
    'enabled' => env('DKIM_ENABLED', true),
    'private_key' => env('DKIM_PRIVATE_KEY', storage_path('app/dkim/private_key.txt')),
    'selector' => env('DKIM_SELECTOR', 'default'),
    'domain' => env('DKIM_DOMAIN', parse_url(config('app.url'))['host']),
    'passphrase' => env('DKIM_PASSPHRASE', ''),
    'algorithm' => env('DKIM_ALGORITHM', 'rsa-sha256'),
    'identity' => env('DKIM_IDENTITY', null),
    'mailers' => env('DKIM_MAILERS', ['smtp', 'sendmail', 'log', 'mail']),
];
