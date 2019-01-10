<?php

use Userstory\ComponentAutoconfig\components\Autoconfig;
use yii\web\Application;

require_once __DIR__ . '/../../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../../vendor/yiisoft/yii2/Yii.php';

$config = ( new Autoconfig() )->load(__DIR__ . '/../../../../../protected/config/web.php');

new Application($config);
