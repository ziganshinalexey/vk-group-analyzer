<?php

declare(strict_types = 1);

return [
    'components'    => [
        'competingView' => require __DIR__ . '/competingView.component.global.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/ziganshinalexey/keyword-admin/migrations'],
        ],
    ],
];
