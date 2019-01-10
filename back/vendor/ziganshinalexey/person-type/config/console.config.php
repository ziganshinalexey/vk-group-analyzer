<?php

declare(strict_types = 1);

return [
    'components'    => [
        'personType' => require __DIR__ . '/personType.component.global.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/ziganshinalexey/person-type/migrations'],
        ],
    ],
];
