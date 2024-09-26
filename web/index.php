<?php
$server_name=$_SERVER['SERVER_NAME'];
$test_server=array('localhost','127.0.0.1','jambo.com','jambo.localhost','joshua');
if((in_array($server_name,$test_server)))
{
    // comment out the following two lines when deployed to production
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
