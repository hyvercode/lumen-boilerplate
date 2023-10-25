<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],
        'sftp' => [
            'driver' => 'sftp',
            'host' => '167.71.211.42',
            'username' => 'irwan',
            'password' => 'irwan@sip2021',
            'port' => 51018,
            'root' => '/var/www/html/file/storage/app/public/',
            'timeout' => 30,
            'visibility' => 'public',
            'permPublic' => 0775,
            'directoryPerm' => 0775
        ],
        'oss' => [
            'driver' => 'oss',
            'access_id' => env('CDN_IMG_ID', 'LTAI4GEGv6y9AkvobrREGTdy'),
            'access_key' => env('CDN_IMG_KEY', 'QAqHV9gXAHaG2vtYR3pEQyWsERczHf'),
            'bucket' => env('CDN_IMG_PATH_URL', 'basedev'),
            'endpoint' => env('CDN_IMG_URL', 'oss-ap-southeast-5.aliyuncs.com'),
            'isCName' => false,
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

//    'links' => [
//        public_path('storage') => storage_path('app/public'),
//    ],

];
