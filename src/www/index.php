<?php
mb_internal_encoding('UTF-8');
error_reporting(E_ALL);

require_once (__DIR__ . '/../protected/config/debug.php');
ini_set('display_errors', YII_DEBUG);

$yii = __DIR__ . '/../protected/vendor/yiisoft/yii/framework/' . (YII_DEBUG ? 'yii.php' : 'yiilite.php');
require_once (__DIR__ . '/../protected/vendor/autoload.php');
require_once ($yii);

$config =(is_file('installer.php')) ? 'installer.php' : __DIR__ . '/../protected/config/config.php';
Yii::createWebApplication($config)->run();
