<?php

declare(strict_types=1);

return [
    'private_key' => env('DKIM_PRIVATE_KEY', storage_path('app/dkim/private_key.txt')),
    'selector' => env('DKIM_SELECTOR', 'default'),
    'domain' => env('DKIM_DOMAIN', null),
    'passphrase' => env('DKIM_PASSPHRASE', ''),
    'algorithm' => env('DKIM_ALGORITHM', 'rsa-sha256'),
    'identity' => env('DKIM_IDENTITY', null),
];
