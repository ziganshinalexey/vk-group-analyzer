<?php

declare(strict_types = 1);

return [
    'components'    => [
        'personTypeRest' => require __DIR__ . '/personTypeRest.component.global.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/ziganshinalexey/person-type-rest/migrations'],
        ],
    ],
];
