<?php

return [

    //microservice url
    'backoffice-service' => [
        'base_uri' => env('BACKOFFICE_SERVICE_BASE_URI'),
        'secret' => env('BACKOFFICE_SERVICE_SECRET')
    ],
    'sync-service' => [
        'base_uri' => env('SYNC_SERVICE_BASE_URI'),
        'secret' => env('SYNC_SERVICE_SECRET'),
    ],
    'global-service' => [
        'base_uri' => env('GLOBAL_SERVICE_BASE_URI'),
        'secret' => env('GLOBAL_SERVICE_SECRET'),
    ]
];
