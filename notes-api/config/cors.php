<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', '*')),
    'supports_credentials' => false,
];

