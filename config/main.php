<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.MAIN_HOST.';dbname='.MAIN_DB,
    'username' => 'root',
    'password' => 'P@ssW0rd',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
