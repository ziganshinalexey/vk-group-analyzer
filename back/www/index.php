<?php

use Userstory\ComponentAutoconfig\components\web\Autoconfig;
use yii\web\Application;

defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$customMasks = [
    '*.global.php',
    '*.local.php',
    '*.web.php',
];
$config      = ( new Autoconfig() )->load(__DIR__ . '/../protected/config/web.php', [], $customMasks);

( new Application($config) )->run();
