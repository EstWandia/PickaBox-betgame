<?php


return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.MONEY_HOST.';dbname='.MONEY_DB,
    'username' => DB_USERNAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'
];