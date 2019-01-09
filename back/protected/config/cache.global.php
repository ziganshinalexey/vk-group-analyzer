<?php

use yii\redis\Cache;
use yii\redis\Connection;

return [
    'components' => [
        'redis' => [
            'class'    => Connection::class,
            'hostname' => 'redis',
        ],
        'cache' => [
            'class' => Cache::class,
        ],
    ],
];
