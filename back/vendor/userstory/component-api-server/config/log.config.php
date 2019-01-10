<?php

use Userstory\ComponentLog\loggers\FileTarget;

return [
    'targets' => [
        [
            'class'          => FileTarget::class,
            'logPath'        => '@runtime/logs/api',
            'templatePath'   => '@vendor/userstory/component-api-server/logger/views/api-log',
            'daysLife'       => 180,
            'exportInterval' => YII_DEBUG ? 1 : 100,
            'levels'         => ['info'],
            'categories'     => ['apiLog'],
        ],
    ],
];
