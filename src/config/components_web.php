<?php

return [
    'errorHandler' => [
        'errorAction' => 'api/errors'
    ],
    'response' => [
        'formatters' => [
            \yii\web\Response::FORMAT_JSON => [
                'class' => 'yii\web\JsonResponseFormatter',
                'prettyPrint' => YII_DEBUG, // используем "pretty" в режиме отладки
                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
        ],
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            [
                'class' => \yii\web\GroupUrlRule::class,
                'prefix' => 'auction/v1',
                'rules' => [
                    'GET,POST create' => 'index/create',
                    'GET view/<uuid:.+>' => 'index/view',
                    'POST run/<uuid:.+>' => 'index/run',
                    'GET,POST betting/<uuid_lot:.+>' => 'index/betting'
                ]
            ],
        ]
    ],
    'user' => [
        'identityClass' => \App\Http\models\User::class,
        'enableSession' => false,
        'identityCookie' => false,
        'loginUrl' => false
    ],
    'request' => [
        'parsers' => [
            'application/json' => 'yii\web\JsonParser'
        ],
        'enableCsrfCookie' => false,
        'enableCsrfValidation' => false,
        'enableCookieValidation' => false,
    ],
];