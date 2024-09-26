<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'layout' => 'main',
    'name' => 'USSD GAMES',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','queue'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => "Cw5)Z5/Ue+e&<W'Y",
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
            ],
        ],
        'queue' =>  [
            'class' => \yii\queue\db\Queue::class,
            //'strictJobType' => false,
            //'serializer' => \yii\queue\serializers\JsonSerializer::class,
            'db' => $db, // DB connection component or its config 
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
            'ttr' => 43200,
        ],
         'assetManager' => [
        'bundles' => [
            'yii\bootstrap\BootstrapAsset' => [
                'sourcePath' => '@vendor/kartik-v/yii2-bootstrap4/assets/',
                'css' => ['css/bootstrap.css'],
            ],
            'yii\bootstrap\BootstrapPluginAsset' => [
                'sourcePath' => '@vendor/kartik-v/yii2-bootstrap4/assets/',
                'js' => ['js/bootstrap.bundle.js'],
            ],
        ],
    ],
    'myhelper' => [
        'class' => 'app\components\Myhelper', // Adjust the path if necessary
    ],
    ],
    'modules' => [
     'gridview' => ['class' => 'kartik\grid\Module']] ,
    'params' => array_merge($params, [
        'bsVersion' => '4.x',
    ]),
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
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
