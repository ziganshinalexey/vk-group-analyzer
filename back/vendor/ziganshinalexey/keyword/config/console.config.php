<?php

declare(strict_types = 1);

return [
    'components'    => [
        'keyword' => require __DIR__ . '/keyword.component.global.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/ziganshinalexey/keyword/migrations'],
        ],
    ],
];
