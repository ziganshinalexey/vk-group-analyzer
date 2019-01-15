<?php

declare(strict_types = 1);

return [
    'components'    => [
        'user'  => require __DIR__ . '/user.component.global.php',
        'group' => require __DIR__ . '/group.component.global.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/ziganshinalexey/yii2-vk-api/migrations'],
        ],
    ],
];
