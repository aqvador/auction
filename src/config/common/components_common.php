<?php
/**
 * Project: template alltel24-yii2
 * User: achelnokov
 * Date: 02.03.2020г.
 * Time: 19:44
 */

return [
    'cache' => [
        'class' => \yii\caching\FileCache::class
    ],
    'redis' => \yii\redis\Connection::class,
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => \yii\log\FileTarget::class,
                'levels' => ['error', 'warning'],
            ]
        ],
    ],
    'app-queue' => \App\Console\queues\queueReleases\AppQueue::class,
    'db' => \yii\db\Connection::class
];