<?php

return [
    'singletons' => [
        \yii\redis\Connection::class => [
          ['class' => \yii\redis\Connection::class],
          [
              [
                  'hostname' => 'manager_redis'
              ]
          ]
        ],
        \yii\db\Connection::class => [
            ['class' => \yii\db\Connection::class],
            [
                [
                    'dsn' => 'mysql:host=manager_database;dbname=' . env('DATABASE_NAME'),
                    'username' => env('DATABASE_USER'),
                    'password' => env('DATABASE_PASSWORD'),
                    'charset' => 'utf8',

                    // Schema cache options (for production environment)
                    'enableSchemaCache' => env('YII_DEBUG') === false,
                    'schemaCacheDuration' => env('YII_DEBUG') === true ? 600 : 0,
                    'schemaCache' => 'cache',
                ]
            ]
        ],
        \App\infrastructure\repository\contracts\LotRepositoryInterface::class => [
            'class' => \App\infrastructure\repository\LotRepository::class
        ],
        \App\infrastructure\repository\contracts\UserRepositoryInterface::class => [
            'class' => \App\infrastructure\repository\UserRepository::class
        ],
        \App\infrastructure\repository\contracts\AuctionStepRepositoryInterface::class => [
            'class' => \App\infrastructure\repository\AuctionStepRepository::class
        ]
    ],
    'definitions' => [
    ]
];