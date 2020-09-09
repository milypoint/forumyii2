<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DQhng55rrE2iP7m3_3JYRJjS--9Eiea8',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/login'
        ],
        'errorHandler' => [
//            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'auth/confirm/<email>/<code>' => 'auth/confirm',
                '/' => 'category/index',
                'category' => 'category/index',
                'category/create' => 'category/create',
                'category/<category_path>' => 'post/index',
                'category/<category_path>/delete' => 'category/delete',
                'category/<category_path>/post/<post_id>' => 'message/index',
                'post/<post_id>/delete' => 'post/delete',
                'post/create/<category_path>' => 'post/create',
                'message/create/<post_id>' => 'message/create',
                'login' => 'auth/login',
                'register' => 'auth/register',
                'logout' => 'auth/logout',
                'like/message/<message_id>' =>'/like/message',
                'POST /api/like' => 'api/like/like',
                'GET /api/like' => 'api/like/index'
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'modules' => [
        'api' => [
            'class' => \app\modules\api\Module::class
        ]
    ],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
