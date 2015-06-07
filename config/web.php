<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'Shop',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => 'app\modules\backend\ShopAdminModule',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UarvlSI50_Uf5OQAGzeCXUW3GRzPNYot',
        ],
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName'  => true,
            'rules' => [
                'admin/<controller:\w+>/<id:\d+>/<action:\w+-*\w*>' => 'admin/<controller>/<action>',
                'admin/catalog/<action:\w+>' => 'admin/catalog/<action>',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'admin/catalog/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
